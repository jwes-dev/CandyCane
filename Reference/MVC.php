<?php

function RenderSection($name, $required)
{
    $name = "section_".$name;
    if($required)
    {
        if(function_exists($name))
            $name();
        else
            echo "FATAL ERROR: Call to undefuned section: ".$name;
    }
    else{
        if(function_exists($name))
            $name();
    }
}

class HTML{
    public static function ActionLink($LinkText, $Action, $Controller, $htmlAttributes = "")
    {
        echo "<a href=\"".Application::$AppData->AppPath."/$Controller/$Action\" $htmlAttributes>$LinekText</a>\n";
    }

    public static function ContentUrl($vpath)
    {
        echo Application::$AppData->AppPath."/".$vpath;
    }
}


class Application
{
    public static $AppData;

    public static function Init()
    {
        Application::$AppData = json_decode(file_get_contents("App.Config.json"));
        Application::$AppData->ServerPath = $_SERVER["DOCUMENT_ROOT"].Application::$AppData->AppPath;
    }
}

Application::Init();

class Server
{
    public static function MapPath($path, $data = null)
    {
        $query = "";
        if($data != null)
        {
            $query = "?";
            $ds = get_object_vars($data);
            foreach($ds as $v => $val)
            {
                $query += "$v=$val&";
            }
            $query = substr($query, 0, strlen($query) - 2);
        }
        if(substr($path, 0, 2) == "~/" && strlen($path) == 2)
            return Application::$AppData->AppPath."/$query";
        else if(substr($path, 0, 2) == "~/")
            return Application::$AppData->AppPath."/".substr($path, 2)."$query";
        else
            return $Context->WorkingDir."/".$path."$query";
    }    
}



class R
{
    public static function App($path)
    {
        if (substr($path, 0, 2) == "~/" && strlen($path) == 2)
            return Application::$AppData->AppPath;
        else if (substr($path, 0, 2) == "~/")
            return Application::$AppData->AppPath . "/" . substr($path, 2);
        else
            return $Context->WorkingDir;
    }

    public static function File($path)
    {
        if (substr($path, 0, 2) == "~/" && strlen($path) == 2)
            return Application::$AppData->ServerPath;
        else if (substr($path, 0, 2) == "~/")
            return Application::$AppData->ServerPath . "/" . substr($path, 2);
        else
            return $Context->WorkingDir;
    }
}

class Controller
{
    public function __construct()
    {
        $this->ViewBag = new \stdClass();
    }

    public function View($ViewName = "")
    {
        global $HTML;
        $this->ViewBag->Title = Context::$Method;
        if($ViewName == "")
            Context::$ViewName .= "/".Context::$Controller."/".Context::$Method.".php";
        else
            Context::$ViewName .= "/".$ViewName;
        $ViewPage = "";
        ob_start();
        require_once Context::$ViewName;
        $ViewPage = ob_get_contents();
        ob_end_clean();
        if(!isset($thos->Layout))
        {
            require_once Application::$AppData->ServerPath.Context::$WorkingDir."Views/_ViewStart.php";
        }
        else{
            require_once FILES_Application::$AppData->ServerPathROOT.Context::$WorkingDir.$this->Layout;
        }
    }

    public function JSON($obj)
    {
        header("Content-Type: application/json");
        echo json_encode($obj);
    }

}

class View
{
    public function __construct()
    {

    }
}

?>