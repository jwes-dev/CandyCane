<?php
class HttpFileBase
{
    public function __construct($fileName)
    {
        $this->HasFiles = sizeof($_FILES) > 0;
        $this->FileKey = $fileName;
    }

    /**
     * @param string $fileKey The input name of the file upload field
     * @param string $path The patch in which the file is to be stored
     * @param string $savename Name for the file to be saved as on the server
     * Saves a file submitted with the form given by the $fileKey
     */
    public function SaveAs(string $fileKey, string $path, string $savename)
    {
        move_uploaded_file($savename, $path);
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

    /**
     * Gets the request type/method
     */
    public static function Method() : string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * @param mixed $obj The object structure to search the form for
     * Searches the request page for the data matching the given object structure and fills the object with the data if found and returns the object
     */
    public static function RequestData(mixed $obj)
    {
        $reflect = new ReflectionClass($obj);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $prop->setValue($obj, $_REQUEST[$prop->getName()]);
        }
        return $obj;
    }

    /**
     * @param string $Key Name of the header field
     * returns the value of the specified header field
     */
    public static function Header(string $Key) : String{
        $headers = getallheaders();
        if($header == false)
            return null;
        return $headers[$Key];
    }
}


class HTTP
{
    public static function AntiForgeryToken() : string
    {
        return "<input name=\"v1e4681fd36f5589e61de20cea0f6e535\" value=\"".password_hash($_SERVER["REMOTE_ADDR"] . " : " . $_SERVER["SERVER_ADDR"], PASSWORD_DEFAULT)."\" hidden />";
    }

    public static function ValidateAntiforgeryToken()
    {
        if(isset($_REQUEST["v1e4681fd36f5589e61de20cea0f6e535"]))
        {
            $token = $_REQUEST["v1e4681fd36f5589e61de20cea0f6e535"];
            return password_verify($_SERVER["REMOTE_ADDR"] . " : " . $_SERVER["SERVER_ADDR"], $token);
        }
        return false;
    }
}
?>