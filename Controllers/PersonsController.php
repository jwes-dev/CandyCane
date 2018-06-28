<?php
require_once "Models/person.php";
class PersonsController extends Controller
{
    public function __construct()
    {
        $this->db = new DbSet(new person());
    }

    public function Create()
    {
        $p = new person();
        $p = $this->get_GET($p);
        $this->db->Add($p);

    }

    public function Remove()
    {
        $p = new person();
        $p = $this->get_GET($p);
        $this->db->Remove($p);
    }
}
?>