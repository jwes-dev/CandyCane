<?php
class AuthorizeFilter extends Filter
{
    public function OnBeforeExecute($roles)
    {        
        if(!isset($_SESSION["Email"]))
        {
            if(FilterHelper::ResolveMethodFilters($this->Context) !== -1)
                Response::Redirect("~/Account/Login".(strlen(Request::$Url) > 0 ? "?url=".Request::$Url : ""));
        }
    }
}
?>