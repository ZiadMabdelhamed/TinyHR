<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>AdminLTE | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
</head>
<body class="bg-black">
<?php
// show errors
if(isset($login_status) && count($login_status) > 0)
    {
    for($i=0 ;$i<count($login_status);$i++)
        {
            echo '<div class="alert alert-danger">
                <strong>Error! </strong>'.$login_status[$i].
                '</div>';
        }

}

?>




<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="user_name" class="form-control" placeholder="User ID"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password"/>
            </div>
<!--            <div class="form-group">-->
<!--                <input type="checkbox" name="remember_me"/> Remember me-->
<!--            </div>-->
            <div class="form-group">
                <?php echo $captcha->display(); ?>
            </div>
        </div>
        <div class="footer">
            <button name="log_in_form" type="submit" class="btn bg-olive btn-block">Sign me in</button>

<!--            <p><a href="#">I forgot my password</a></p>-->

<!--            <a href="./Views/public/signup.php" class="text-center">Register a new membership</a>-->
            <?php echo "<a href=". $_SERVER['PHP_SELF']."?page=signup".">Register a new membership</a>" ?>
        </div>
    </form>
    <?php echo $captcha->renderJs(); ?>

</div>



</body>
</html>