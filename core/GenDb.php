<?php

require_once "../Reference/DbContext.php";
require_once $argv[1];

spl_autoload_register(function ($class_name) {
    if (file_exists("../Models/$class_name.php"))
        require_once "../Models/$class_name.php";
    else
        echo "$class_name does not exist";
});

function getProps($context_name)
{
    $con = new ReflectionClass($context_name);
    return $con->getProperties();
}

function Marshal($cmt)
{
    $cmt = substr($cmt, 3, strlen($cmt) - 5);
    $cmt = trim($cmt);
    $cmt = explode("\n", $cmt);
    foreach($cmt as $k => $c)
    {
        $cmt[$k] = trim($c);
    }
    return $cmt;
}

function GetAttr($prop)
{
    return Marshal($prop->getDocComment());
}

function CreateTable($cname)
{
    $tmp = "CREATE TABLE $cname(";
    $props = getProps($cname);
    foreach($props as $prop)
    {
        $tmp .= "\n".$prop->getName();
        foreach(GetAttr($prop) as $attr)
        {
            $tmp .= " $attr,";
        }
    }
    $tmp = substr($tmp, 0, strlen($tmp) - 1);
    $tmp .= "\n);\n";
    return $tmp;
}

$output = "";
$verbose = false;

if(isset($argv[4]))
    if($argv[4] == "-verbose")
        $verbose = true;
foreach(getProps($argv[2]) as $tbl)
{
    $tmp = CreateTable($tbl->getName());
    if($verbose)
        echo $tmp;
    $output .= $tmp;
}
file_put_contents("../tables.sql", $output.PHP_EOL, LOCK_EX);
echo "tables.sql file is ready\n";
?>