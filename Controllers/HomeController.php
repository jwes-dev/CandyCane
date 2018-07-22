<?php
class HomeController extends Controller
{
    /** FILTERS
    Authorize
     */
    public function Index()
    {
        $db = new AppDbContext();
        $this->View();
    }

    public function Contact()
    {
        $this->View();
    }

    public function About()
    {
        $this->View();
    }
}
?>