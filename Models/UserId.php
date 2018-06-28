<?php

class ExampleModel
{
    public $Name;
    public $Age;
    public $DOB;

    public function MVC_SetTypes()
    {
        settype($Name, "string");
        settype($Age, "string");
        settype($DOB, "string");
    }
}

?>