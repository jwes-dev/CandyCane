<?php
class AccountController extends Controller
{
    public function __construct()
    {
        $this->Manager = new AccountHelper();
    }

    public function LogIn()
    {
        if(isset($_POST["submit"]))
        {
            if($this->Manager->LogIn($_POST["email"], $_POST["password"]))
                Response::Redirect("~/");            
            $this->ViewBag->Error = "Invalid Credentials";
        }
        $this->View(); 
    }
}
?>