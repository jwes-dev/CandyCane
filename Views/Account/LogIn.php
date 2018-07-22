<?php
    $this->ViewBag->Title = "Login";    
?>
<h2>Login.</h2>
<br />
<form action="<?php echo R::App("~/Account/LogIn"); ?>" method="POST" class="form-horizontal">
    <p>
    <?php
        if(isset($this->ViewBag->Error))
            echo $this->ViewBag->Error;
    ?>
    </p>
    <div class="form-group">
        <label class="col-md-2 control-label">Email</label>
        <div class="col-md-10">
            <input name="email" placeholder="email" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Password</label>
        <div class="col-md-10">
            <input name="password" type="password" placeholder="password" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <input name="submit" value="Login" class="btn btn-success" type="submit" />
        </div>
    </div>
</form>