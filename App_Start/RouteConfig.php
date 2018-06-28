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
    define("ROUTES", array(
         "default" => ["/", "/", "Home", "Index", "ID"],
        "api" => ["/MyApi/", "/Area/StudentApi/", "Home", "Index", "ID"]
    ));
?>