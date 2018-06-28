<?php
class HomeController extends Controller
{
    public function Index()
    {
        $this->View();
    }

    public function Contact()
    {
        $this->View();
    }

    public function MyApiFunc()
    {
        Response::Write("Hello");
    }

    public function About()
    {
        $this->View();
    }

    public function GotoIndex()
    {
        Response::RedirectTo("Home", "Index");
    }

    public function GetTableData()
    {
        $this->db = NewSQLConnection();
        $data = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Check'");
        $obj = new chk();
        $reflect = new ReflectionClass($obj);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        $sel = "";
        while($seg = $data->fetch_assoc())
        {
            if($seg["DATA_TYPE"] == "date")
                $sel += "";
            var_dump($seg);
            echo "<br /><br />";
        }
    }
}
?>