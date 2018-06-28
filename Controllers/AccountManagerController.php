<?php
class AccountManagerController extends Controller
{
    public function __construct()
    {
        $this->db = NewSQLConnection();
        $this->Manager = new AccountManager();
    }

    public function SignUp()
    {
        if(isset($_POST["submit"]))
        {
            if($this->Manager->SignUp($_POST["email"], $_POST["password"]))
            {
                Response::Redirect("~/");
            }
            else{
                $Error = "Not able to sign up or user already exists";
                $this->View();
            }
        }
        else
        {
            return $this->View();
        }
    }

    public function LogIn()
    {
        if(isset($_POST["submit"]))
        {
            if($this->Manager->LogIn($_POST["email"], $_POST["password"]))
            {
                echo "success";
                Response::Redirect("~/");
            }
            $Error = "Invalid Credentials";
        }
        $this->View();
    }

    public function ForgotPassword()
    {
        if(isset($_POST["submit"]) && isset($_POST["email"]))
        {
            if($this->Manager->ChangePassword($_POST["email"]))
            {
                $this->View("FollowUp.php");
            }
            $Error = "";
        }
        $this->View();
    }
}
?>