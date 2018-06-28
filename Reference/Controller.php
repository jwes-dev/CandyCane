<?php
class Controller
{
    public function __construct()
    {
    }

    public function View($ViewName = "")
    {
        global $ViewBag;
        global $HTML;
        $ViewBag->Title = Context::$Method;
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

    public function get_GET($obj)
    {
        $reflect = new ReflectionClass($obj);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $prop->setValue($obj, $_GET[$prop->getName()]);
        }
        return $obj;
    }

    public function get_POST($obj)
    {
        $reflect = new ReflectionClass($obj);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $prop->setValue($obj, $_POST[$prop->getName()]);
            //print $prop->getName();
        }
        return $obj; 
    }
}
$ViewBag = new \stdClass();
?>