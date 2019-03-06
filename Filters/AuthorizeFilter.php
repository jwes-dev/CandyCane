<?php
class AuthorizeFilter extends Filter
{
    public function OnBeforeExecute($args)
    {
        if(!isset($_SESSION["Email"]))
        {
            echo "email failed";
            die();
            Response::Redirect("~/Account/Login".(strlen(Request::$Url) > 0 ? "?url=".Request::$Url : ""));
        }
        else if(FilterHelper::ResolveMethodFilters($this->Context) === -1)
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