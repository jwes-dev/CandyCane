<?php
class AppDbContext extends DbContext
{
    public function __construct()
    {
        $this->__Initialize(Application::$AppConfig->DefaultDb);
    }
}
?>