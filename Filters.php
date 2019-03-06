<?php
class FilterHelper
{
    public static function ResolveFilters(Context $context)
    {
        FilterHelper::ResolveClassFilters($context);
        FilterHelper::ResolveMethodFilters($context);
    }

    public static function ResolveClassFilters(Context $context)
    {
        $class = $context->Controller."Controller";
        $ref = new ReflectionClass($class);
        $comment = $ref->getDocComment();
        if(strlen($comment) < 1)
            return true;
        $attrs = explode("\n", trim(trim($comment, "/*")));
        foreach($attrs as $attr)
        {
            $attr = trim(trim($attr, "/*"));
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
                $args = null;
                $filter = new $fil($context);
                if(isset($attr[2]))
                {
                    if(strlen($attr[2]) > 0)
                        $args = json_decode($attr[2]);
                }
                return $filter->Handle($args);
            }
        }
        return true;
    }

    public static function ResolveMethodFilters(Context $context)
    {
        $class = $context->Controller."Controller";
        $method = $context->Method;
        $ref = new ReflectionClass($class);
        $comment = $ref->getMethod($method)->getDocComment();
        if(strlen($comment) < 1)
            return true;
        $attrs = explode("\n", trim(trim($comment, "/*")));
        foreach($attrs as $attr)
        {
            $attr = trim(trim($attr, "/*"));
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
                $args = null;
                $filter = new $fil($context);
                if(isset($attr[2]))
                {
                    if(strlen($attr[2]) > 0)
                        $args = json_decode($attr[2]);
                }
                return $filter->Handle($args);
            }
        }
        return true;
    }
}

class Filter
{
    public function __construct(Context $context)
    {
        $this->Context = $context;
    }

    public function Handle($args)
    {
        return $this->OnBeforeExecute($args);
    }
}


class HTTPPOSTFilter extends Filter
{
    public function OnBeforeExecute($args)
    {
        if(Request::Method() !== 'POST')
        {
            Response::SetStatusCodeResult(404, "Not Found");
        }
    }
}

class HTTPGETFilter extends Filter
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