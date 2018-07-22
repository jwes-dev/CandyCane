<?php
class TestController extends Controller
{
    public function Check()
    {
        echo Application::$AppData->MyData->age;
    }
}
?>