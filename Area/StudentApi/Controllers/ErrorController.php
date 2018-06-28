<?php
    class ErrorController extends Controller
    {
        public function NotFound()
        {
            $this->SetLayout("Views/Shared/Error.php");
            $this->View();
        }
    }
?>