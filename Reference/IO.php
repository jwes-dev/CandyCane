<?php
class HttpFileBase
{
    public function __construct($fileName)
    {
        $this->HasFiles = sizeof($_FILES) > 0;
        $this->FileKey = $fileName;
    }

    public function SaveAs($fileKey, $path, $savename)
    {
        move_uploaded_file($savenames, $path);
    }
}

class Response
{
    public static function Redirect($NewUrl)
    {
        header("Location:".Server::MapPath($NewUrl));
        exit;
    }

    public static function RedirectTo($Controller, $Action, $Query = "")
    {
        if(strlen($Query) == 0)
            header("Location: ".Application::$AppData->AppPath."$Controller/$Action");
        else
            header("Location: ".Application::$AppData->AppPath."$Controller/$Action?$Query");
    }

    public static function Write($data)
    {
        echo $data;
    }

    public static function SetHeader($key, $value)
    {
        header("$key:$value");
    }

    public static function SetStatusCodeResult($id, $msg)
    {
        $sapi_type = php_sapi_name();
        if (substr($sapi_type, 0, 3) == 'cgi')
            header("Status: $id $msg");
        else
                header("HTTP/1.1 $id $msg");
        die();
    }

    public static function SetContentType($ctype)
    {
        header("Content-Type:$ctype");
    }
}

class Request
{
    public static $Url;
    public function RequestData()
    {
        $reflect = new ReflectionClass($obj);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $prop->setValue($obj, $_REQUEST[$prop->getName()]);
        }
        return $obj;
    }
}
?>