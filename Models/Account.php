<?php
session_start();
class AuthManager
{
    public function __construct($context)
    {
        $this->Db = $context;
    }

    protected function Authenticate($Email, $Secret)
    {
        $User = $this->Db->Identity->Find(md5($Email));
        return password_verify($Secret, $User->Secret);
    }

    /**
     * @param string $Email Email associated with the account
     * @param string $Secret Password for the account
     * Id the Email and the password match, starts a session and returns true, else false
     */
    public function Login(string $Email, string $Secret) : bool
    {
        if($this->Authenticate($Email, $Secret))
        {
            session_start();
            $_SESSION["Email"] = $Email;
            $User = $this->Db->IdentityRole->Find(md5($Email));
            $_SESSION["Roles"] = json_decode($User->Roles);
            return true;
        }
        return false;
    }

    public function LogOut()
    {

        session_unset();
        return session_destroy();
    }
}

class IdentityManager
{
    public function __construct($context)
    {
        $this->Db = $context;
    }

    public function CreateUser(IdentityView $identity, array $Roles)
    {
        $id = new Identity();
        $id->Id = md5($identity->Email);
        $id->Secret = password_hash($identity->Password, PASSWORD_DEFAULT);
        if($this->Db->Identity->Find($id->Id) != null)
        {
            return false;
        }

        $idEmail = new IdentityEmail();
        $idEmail->Id = $id->Id;
        $idEmail->Email = $identity->Email;

        $this->Db->Identity->Add($id);
        $this->Db->IdentityEmail->Add($idEmail);

        return true;
    }

    public function AddToRoles($Email, $Roles)
    {
        $User = $this->Db->IdentityRole->Find(md5($Email));
        if($User == null)
        {
            return false;
        }
        $roles = json_decode($User->Roles);
        if(!is_array($roles))
        {
            $roles = [];
        }
        array_push($roles, $Roles);
        $User->Roles = json_encode($roles);
        $this->Db->IdentityRole->Update($User);
    }
}
?>