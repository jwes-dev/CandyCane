<?php
/*
form: friendlyName => [
    "Virtual Path",
    "Actual Path",
    "Default_Controller",
    "Default_Action",
    "Default_Parameter_Name"
    ]
*/
class RouteConfig
{
    public static $Routes = array(
        "default" => ["/", "/", "Settings", "Config", "ID"],
        "api" => ["/MyApi/", "/Area/StudentApi/", "Home", "Index", "ID"]
    );
}
?>