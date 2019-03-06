<div cclass="row">
    <div class="col-md-12">
        <h1>Register</h1>
        <form action="<?=R::App("~/Account/RegisterAccount". (isset($_REQUEST["url"]) ? "?url=".$_REQUEST["url"] : ""))?>" method="POST">
            <?=HTTP::AntiForgeryToken()?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="Email">
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="password" class="form-control" id="pwd" name="Password">
            </div>
            <div class="form-group">
                <label for="pwd">Confirm Password</label>
                <input type="password" class="form-control" id="cpwd">
            </div>
            <p id="pwd_msg" class="text-danger"></p>
            <button type="submit" id="sub_btn" disabled class="btn btn-default">Submit</button>
        </form>
        <p>
            Already have an account? <?php HTML::ActionLink("Login", "Login", "Account") ?>
        </p>
    </div>
</div>
<?php function section_scripts(){ ?>
<script>
pwd = document.getElementById("pwd");
cpwd = document.getElementById("cpwd");
pwd_mdg = document.getElementById("pwd_msg");

pwd.oninput = function(){
    if(cpwd.value.length > 0)
    {
        if(cpwd.value == pwd.value)
        {
            pwd_msg.innerHTML = "";
            document.getElementById("sub_btn").disabled = false;
        }
        else{
            pwd_msg.innerHTML = "Passwords do not match";
            document.getElementById("sub_btn").disabled = true;
        }
    }
};

cpwd.oninput = function(){
    if(cpwd.value == pwd.value)
        {
            pwd_msg.innerHTML = "";
            document.getElementById("sub_btn").disabled = false;
        }
        else{
            pwd_msg.innerHTML = "Passwords do not match";
            document.getElementById("sub_btn").disabled = true;
        }
};
</script>
<?php } ?>