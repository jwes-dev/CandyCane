<?php

function ResolveClassFilters($class)
{
    $ref = new ReflectionClass($class);
    $comment = $ref->getDocComment();
    $attrs = explode("\n", trim(trim($comment, "/**")));
    foreach($attrs as $attr)
    {
        $attr = explode(" ", trim($attr));
        if(trim($attr) == "FILTER")
        {
            $fil = $attr[1]."Filter";
            if(!class_exists($fil, false))
            {
                if(!file_exists(R::File("~/Filters/".$fil.".php")))
                    die("EXEC_ERROR: filter class file missing");
                require_once R::File("~/Filters/".$file.".php");
                if(!class_exists($fil))
                    die("EXEC_ERROR: filter class missing");
            }
            if(isset($attr[2]))
            {
                if(strlen($attr[2]) > 0)
                    $filter = new $fil(json_decode($attr[2]));
            }
            else
                $filter = new $fil();
        }
    }
    return true;
}

function ResolveMethodFilters($class, $method)
{
    $ref = new ReflectionClass($class);
    $comment = $ref->getMethod($method)->getDocComment();
    $attrs = explode("\n", trim(trim($comment, "/**")));
    foreach($attrs as $attr)
    {
        $attr = explode(" ", trim($attr));
        if(trim($attr[0]) == "FILTER")
        {
            $fil = $attr[1]."Filter";
            if(!class_exists($fil, false))
            {
                if(!file_exists(R::File("~/Filters/".$fil.".php")))
                    die("EXEC_ERROR: filter class file missing");
                require_once R::File("~/Filters/".$fil.".php");
                if(!class_exists($fil))
                    die("EXEC_ERROR: filter class missing");
            }
            if(isset($attr[2]))
            {
                if(strlen($attr[2]) > 0)
                    $filter = new $fil(json_decode($attr[2]));
            }
            else
                $filter = new $fil();
        }
    }
    return true;
}

class Filter
{
    public function __construct($args = null)
    {
        $this->OnBeforeExecute($args);
    }
}


class POSTFilter extends Filter
{
    public function OnBeforeExecute($args)
    {
        if(Request::Method() !== 'POST')
        {
            Response::SetStatusCodeResult(404, "Not Found");
        }
    }
}

class GETFilter extends Filter
{
    public function OnBeforeExecute($args)
    {
        if(Request::Method() !== 'GET')
        {
            Response::SetStatusCodeResult(404, "Not Found");
        }
    }
}

class AntiForgeryFilter extends Filter
{
    public function OnBeforeExecute($args)
    {
        if(!HTTP::ValidateAntiforgeryToken())
        {
            Response::SetStatusCodeResult(400, "Bad Request");
        }
    }
}
?>