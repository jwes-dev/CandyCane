<?php
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
            return Application::$AppData->AppPath;
        else if (substr($path, 0, 2) == "~/")
            return Application::$AppData->AppPath . "/" . substr($path, 2);
        else
            return $Context->WorkingDir;
    }
}
?>
