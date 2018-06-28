<?php
function RenderScript($src)
{
    echo "<script src=\"".Application::$AppData->AppPath."/Scripts/".$src.".js\" ></script>\n";
}

function RenderStyle($src)
{
    echo "<link href=\"".Application::$AppData->AppPath."/Content/".$src.".css\" rel=\"stylesheet\" />\n";
}
?>