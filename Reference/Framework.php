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
    public static function ActionLink($LinekText, $Action, $Controller, $htmlAttributes = "")
    {
        echo "<a href=\"".Application::$AppData->AppPath."/$Controller/$Action\" $htmlAttributes>$LinekText</a>\n";
    }

    public static  function ContentUrl($vpath)
    {
        echo Application::$AppData->AppPath."/".$vpath;
    }
}
?>