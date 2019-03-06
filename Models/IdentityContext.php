<?php
class IdentityContext extends DbContext
{
    protected $Identity;
    protected $IdentityRole;
    protected $IdentityEmail;
    
    public function __construct()
    {
        $this->__Initialize(Application::$AppData->DefaultDb);
    }
}
?>