<?php
require_once "App.config";
require_once "Reference";

class IdentityDbContext extends DbContext
{
    public function __construct()
    {
        // declare all the tables here
        // example:
        // $this->MyTable = new DbSet(new MyTable());
        $Accounts = new DbSet(new Account());
        $Roles = new DbSet(new Roles());
        $Locked = new DbSet(new Locked());

        $this->__Initialize(AppConfig::$DbContext["Default"]);
        $this->Seed();
    }
}

class Account
{
    public $UserName;
    public $Key;
}

class Roles
{
    public $UserName;
    public $Roles;
}

class Locked
{
    public $UserName;
    public $Locked;
}

class AccountManager
{
    public function __construct()
    {
        $this->db = new IdentityDbContext();
    }

    public function SignUp($email, $password)
    {
        $acc = new Account();
        $acc->UserName = $email;
        $acc->key = md5($email.":".$password);
        $this->db->Accounts->Add($acc);
    }

    public function AddToRole($email, $role)
    {
        $r = $this->db->Find($email);
        if($r == null)
        {
            $r = new Roles();
            $r->UserName = $email;
            $r->Roles = $role;
            $this->db->Roles->Add($r);
        }
        else{
            $r->Roles .= ",$role";
            $this->db->Roles->Update($r);
        }
    }

    public function ChangePassword($email, $Password, $NewPassword)
    {
        $acc = $this->db->Accounts->Find(md5($email.":".$password), "Key");
        if($acc == null)
            return false;
        $acc->Key = md5($email.":".$NewPassword);
        $this->db->Accounts->Update($acc);
    }

    public function GetPasswordChangeToken($Email)
    {
        $Key = password_hash($Email, PASSWORD_DEFAULT);
        $q = "INSERT INTO PassReset VALUES('$Email', '$Key')";
        return $this->db->query($q);
    }

    public function GetKeyEmail($Key)
    {
        $q = "SELECT Email FROM PassReset WHERE EKey = '$Key'";
        $res = $this->db->query($q);
        if($res->num_rows == 1)
        {
            $row = $res->fetch_assoc();
            return $res["Email"];
        }
        else
        {
            return "";
        }
    }

    public function VerifyLink($Key,  $Email)
    {
        $q = "SELECT * FROM PassReset WHERE Email = '$Email' AND EKey = '$Key'";
        $res = $this->db->query($q);
        return $res->num_rows == 1;
    }

    public function StartSession($Email, $Role)
    {
        session_start();
        $_SESSION["User"] = $Email;
        $_SESSION["Role"] = password_hash($Role, PASSWORD_DEFAULT);
    }


    public function LogIn($Email, $password)
    {
        $q = "SELECT * FROM Accounts WHERE Email = '$Email'";
        $res = $this->db->query($q);
        if($res->num_rows > 0)
        {
            $row = $res->fetch_assoc();
            if(password_verify($password, $row["Secret"]))
            {
                session_start();
                $_SESSION["User"] = $row["Email"];
                $q = "SELECT * FROM UserRoles WHERE Email = '$Email'";
                $res = $this->db->query($q);
                $_SESSION["Role"] = $row["Roles"];
                return true;
            }
        }
        return false;
    }
}
?>