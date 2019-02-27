<?php

function ResolveClassFilters($class)
{
    $ref = new ReflectionClass($class);
    $comment = $ref->getDocComment();
    $attrs = explode("\n", trim(trim($comment, "/**")));
    if(trim($attrs[0]) != "FILTERS")
        return;    
    foreach($attrs as $attr)
    {
        if(trim($attr) != "FILTERS")
        {
            $f = explode(" ", trim($attr), 2);
            if(!file_exists(R::File("~/Filters/".$f[0]."Filter.php")))
                return false;
            require_once R::File("~/Filters/".$f[0]."Filter.php");
            if(!class_exists($f[0]."Filter"))
                return false;
            $fil = $f[0]."Filter";
            
            if(isset($f[1]))
            {
                if(strlen($f[1]) > 0)
                    $filter = new $fil(json_decode($f[1]));
            }
            else
                $filter = new $fil();
            return true;
        }
    }
}

function ResolveMethodFilters($class, $method)
{
    $ref = new ReflectionClass($class);
    $comment = $ref->getMethod($method)->getDocComment();
    $attrs = explode("\n", trim(trim($comment, "/**")));
    if(trim($attrs[0]) != "FILTERS")
        return;
    foreach($attrs as $attr)
    {
        if(trim($attr) != "FILTERS")
        {
            $f = explode(" ", trim($attr), 2);
            if(!file_exists(R::File("~/Filters/".$f[0]."Filter.php")))
                return false;
            require_once R::File("~/Filters/".$f[0]."Filter.php");
            if(!class_exists($f[0]."Filter"))
                return false;
            $fil = $f[0]."Filter";
            if(isset($f[1]))
            {
                if(strlen($f[1]) > 0)
                    $filter = new $fil(json_decode($f[1]));
            }
            else
                $filter = new $fil();
            return true;
        }
    }
}

class Filter
{
    public function __construct($args = null)
    {
        $this->OnBeforeExecute($args);
    }
}
?>