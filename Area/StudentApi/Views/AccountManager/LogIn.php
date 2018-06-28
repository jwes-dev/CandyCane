<?php
    $Context->Title = "Login";
    function RenderBody(){
?>
<form action="<?php echo $Context->URL; ?>" method="POST">
    <?php
        if(isset($Error))
            echo $Error;
    ?>
    <div>
        <label class="col-ms-2">Email</label>
        <div class="col-md-10 col-md-offset-2">
            <input name="email" placeholder="email" />
        </div>
    </div>

    <div>
        <label class="col-ms-2">Password</label>
        <div class="col-md-10 col-md-offset-2">
            <input name="password" placeholder="password" />
        </div>
    </div>
</form>
<?php } ?>