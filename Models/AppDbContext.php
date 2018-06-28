<?php
class AppDbContext extends DbContext
{
    public function __construct()
    {
        // declare all the tables here
        // example:
        // $this->MyTable = new DbSet(new MyTable());

        $this->__Initialize(Application::$AppData->DefaultDb);
    }
}
?>