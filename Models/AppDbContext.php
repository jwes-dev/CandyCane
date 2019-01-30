<?php
class AppDbContext extends DbContext
{    
    protected $person;
    protected $UserId;

    public function __construct()
    {
        $this->__Initialize(Application::$AppConfig->DefaultDb);
    }
}
?>