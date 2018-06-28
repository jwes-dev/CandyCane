<?php
    global $Context;
    $Context->Title = "Forgot Password";
    function RenderBody(){
?>
<h2>Reset Password.</h2>
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
        <div class="col-md-10 col-md-offset-2">
            <input name="submit" value="Reset Password" class="btn btn-success" type="submit" />
        </div>
    </div>
</form>
<p>
    A mail will be sent to this email account with a password reset link. Follow up on that link to reset your password
</p>
<?php } ?>