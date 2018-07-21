<?php
class AuthorizeFilter extends Filter
{
    public function OnBeforeExecute($roles = null) 
    {
        if($roles == null)
        {
            if(session_status() === PHP_SESSION_ACTIVE)
                if(!isset($_SESSION["email"]))
                    Response::Redirect("~/Error/NotFound");
                else
                    return;
            else
                Response::Redirect("~/Error/NotFound");
        }
        else
        {
            if(session_status() === PHP_SESSION_ACTIVE)
                if(sizeof(array_intersect(explode(",", $_SESSION["Roles"]), explode(",", $roles))) < 1)
                    Response::Redirect("~/Error/NotFound");
                else
                    return;
            else
                Response::Redirect("~/Error/NotFound");
        }
    }
}
?>