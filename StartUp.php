<?php
session_start();
spl_autoload_register(function ($class_name) {
    if (file_exists(Application::$AppData->ServerPath . "/Models/$class_name.php"))
        require_once Application::$AppData->ServerPath . "/Models/$class_name.php";

    else if(file_exists(Application::$AppData->ServerPath."/Helpers/$class_name.php"))
        require_once Application::$AppData->ServerPath."/Helpers/$class_name.php";
});
date_default_timezone_set('UTC');

require_once "Reference/Http.php";
require_once "Reference/EntityFramework.php";
require_once "Reference/MVC.php";
require_once "Reference/Filters.php";

// APP_START
require_once "App_Start/BundlesConfig.php";
require_once "App_Start/RouteConfig.php";


$reqpath = strtok("/" . trim(substr($_SERVER["REQUEST_URI"], strlen(Application::$AppData->AppPath)), "/"), "?");
Request::$Url = trim(substr($_SERVER["REQUEST_URI"], strlen(Application::$AppData->AppPath)), "/");
$Context = new Context();
$Context->ViewName = Application::$AppData->ServerPath;
foreach (RouteConfig::$Routes as $name => $path) {
    $cname = explode("/", substr($reqpath, strlen($path[0])));
    $find = Application::$AppData->ServerPath . $path[1] . "Controllers/$cname[0]Controller.php";
    if (file_exists($find)) {
        // complete path given
        require_once $find;
        $controller = "$cname[0]Controller";
        if (!class_exists($controller))
            Response::SetStatusCodeResult(404, "Not Found");
        $Context->WorkingDir = $path[1];
        $Context->Controller = $cname[0];
        $Context->ViewName .= $path[1] . "Views";
        if (isset($cname[1])) {
            $method = $cname[1];
            if (method_exists($controller, $method)) {
                $Context->Method = $method;
                if (isset($cname[2]))
                    $_REQUEST[$path[4]] = $cname[2];
                $cont = new $controller($Context);
                if(method_exists($controller, "__Initialize__"))                
                    $cont->__Initialize__();
                FilterHelper::ResolveFilters($Context);
                $cont->$method();
                exit;
            }
        } else {
            $method = $path[3];
            if (method_exists($controller, $method)) {
                // ony the controller name is given
                $Context->Method = $method;
                // var_dump($Context);
                if (isset($cname[2]))
                    $_REQUEST[$path[4]] = $cname[2];
                $cont = new $controller($Context);
                if(method_exists($controller, "__Initialize__"))                
                    $cont->__Initialize__();
                FilterHelper::ResolveFilters($Context);
                $cont->$method();
                exit;
            }
        }

    }
}
$ROUTES = array_reverse(RouteConfig::$Routes);
foreach ($ROUTES as $n => $path) {
    if ($reqpath . "/" == $path[0] || $reqpath == $path[0]) {
        //only the area name is given
        $controller = "$path[2]Controller";
        require_once Application::$AppData->ServerPath . $path[1] . "Controllers/$controller.php";
        if (!class_exists($controller))
            Response::SetStatusCodeResult(404, "Not Found");

        $method = $path[3];
        if (method_exists($controller, $method)) {
            $Context->WorkingDir = $path[1];
            $Context->Controller = $path[2];
            $Context->Method = $method;
            $Context->ViewName .= $path[1] . "Views";
            $cont = new $controller($Context);
            if(method_exists($controller, "__Initialize__"))
                $cont->__Initialize__();
            FilterHelper::ResolveFilters($Context);
            $cont->$method();
            exit;
        }
    }
}
Response::SetStatusCodeResult(404, "Not Found");
exit;
?>