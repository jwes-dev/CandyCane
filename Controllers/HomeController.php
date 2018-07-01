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
}
?>
