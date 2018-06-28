<?php
    global $Context;
    $Context->Title = "Sign Up";
    function RenderBody(){
?>
<h2>Signup.</h2>
<br />
<form action="<?php global $Context; echo Server::MapPath("~/$Context->URL"); ?>" method="POST" class="form-horizontal">
    <?php
        if(isset($Error))
            echo $Error;
    ?>
    <div class="form-group">
        <label class="col-md-2" class="control-label">Email</label>
        <div class="col-md-10">
            <input name="email" placeholder="email" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2" class="control-label">Password</label>
        <div class="col-md-10">
            <input name="password" placeholder="password" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <input name="submit" value="Sign Up" class="btn btn-success" type="submit" />
        </div>
    </div>
</form>
<?php } ?>