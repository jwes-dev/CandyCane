<?php
class HomeController extends Controller
{
    /** FILTERS
    Authorize
     */
    public function Index()
    {
        $db = new AppDbContext();
        $this->View();
    }

    public function Contact()
    {
        $this->View();
    }

    public function About()
    {
        $this->View();
    }

    public function Install()
    {
        $Acc = new AccountHelper();
        if($Acc->SignUp("admin@mbl.com", "admin@1234!!"))
        {
            $Acc->AddToRoles("admin@mbl.com", array("admin"));
            Response::Redirect("~/Account/Login");
        }
        echo "failed";
    }
}
?>