<?php
class AuthorizeFilter extends Filter
{
    public function OnBeforeExecute($args)
    {
        if(!isset($_SESSION["Email"]))
        {
            if(!FilterHelper::DoesMethodHaveFilter("AllowAnonymous", $this->Context))
                Response::Redirect("~/Account/Login".(strlen(Request::$Url) > 0 ? "?url=".Request::$Url : ""));
            else
                return true;
        }
        else if(!FilterHelper::DoesMethodHaveFilter("AllowAnonymous", $this->Context))
        {
            return true;
        }
        if($args != null)
        {
            if(count(array_intersect($_SESSION["Roles"], $args->InRoles)) < 1)
            {
                Response::Redirect("~/Account/Login".(strlen(Request::$Url) > 0 ? "?url=".Request::$Url : ""));
            }
        }
        return true;
    }
}
?>