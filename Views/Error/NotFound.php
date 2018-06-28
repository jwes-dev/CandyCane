<?php
    $Context->Title = "Not Found";
    function RenderBody(){
?>
<div class="col-md-12">
<h2 class="text-danger">
<?php
    if(isset($_GET["msg"]))
        echo $_GET["msg"];
?>
</h2>
</div>
<?php
    }
?>