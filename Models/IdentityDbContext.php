<?php
class IdentityDbContext extends DbContext
{
    protected $Users;
    protected $Roles;
    
    public function __construct()
    {
        $this->__Initialize(Application::$AppConfig->DefaultDb, "snowkeld_admin_");
    }
}
?>