<div cclass="row">
    <div class="col-md-12">
        <h1>Login</h1>
        <form action="<?=R::App("~/Account/Authenticate". (isset($_REQUEST["url"]) ? "?url=".$_REQUEST["url"] : ""))?>" method="POST">
            <?=HTTP::AntiForgeryToken()?>
            <?php if(isset($_REQUEST["msg"])) { ?>
            <p class="text-danger">
            <?= $_REQUEST["msg"] ?>
            </p>
            <?php } ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="Email">
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="password" class="form-control" id="pwd" name="Password">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <p>
            Don't have a account? <?php HTML::ActionLink("Register", "Register", "Account") ?>
        </p>
    </div>
</div>