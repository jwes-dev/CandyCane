<?php
require_once R::File("~/Models/Identity.php");
require_once R::File("~/Models/Account.php");

class AccountController extends Controller
{
    public function Login()
    {
        $this->View();
    }

    /**
    FILTER HTTPPOST
    FILTER AntiForgery
    */
    public function Authenticate()
    {
        $data = Request::RequestData(new IdentityView());
        if(!isset($data->Email))
        {
            Response::Redirect("~/Account/Login". (isset($_REQUEST["url"]) ? "?url=".$_REQUEST["url"] : ""));
        }
        if(!isset($data->Password))
        {
            Response::Redirect("~/Account/Login". (isset($_REQUEST["url"]) ? "?url=".$_REQUEST["url"] : ""));
        }

        $auth = new AuthManager(new IdentityContext());
        if($auth->Login($data->Email, $data->Password))
        {
            if(isset($_REQUEST["url"]))
            {
                echo "~/".urldecode($_REQUEST["url"])."hello";
                Response::Redirect("~/".urldecode($_REQUEST["url"]));
            }
            else
            {
                Response::Redirect("~/");
            }
        }
        else
        {
            Response::Redirect("~/Account/Login?msg=".urlencode("Email or password was incorrect`").(isset($_REQUEST["url"]) ? "&url=".$_REQUEST["url"] : ""));
        }
    }

    public function Logout()
    {
        $auth = new AuthManager(new IdentityContext());
        $auth->LogOut();
        Response::Redirect("~/");
    }

    public function Register()
    {
        $this->View();
    }

    /**
    FILTER HTTPPOST
    FILTER AntiForgery
    */
    public function RegisterAccount()
    {
        $data = Request::RequestData(new IdentityView());
        $identity = new IdentityManager(new IdentityContext());
        if($identity->CreateUser($data, []))
        {
            Response::Redirect("~/Account/Login");
        }
        else
        {
            Response::Redirect("~/Account/Register");
        }
    }
}
?>