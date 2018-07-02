<?php
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