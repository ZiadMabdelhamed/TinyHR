<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>AdminLTE | Registration Page</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

</head>
<body class="bg-black">
<?php

// show errors
if(isset($signup_status) && count($signup_status) > 0)
{
    for($i=0 ;$i<count($signup_status);$i++)
    {
        echo '<div class="alert alert-danger">
                  <strong>Error! </strong>'.$signup_status[$i].
                '</div>';
    }

}

?>

    <div class="form-box" id="login-box">
    <div class="header">Register New Membership</div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" >
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="fname" class="form-control" placeholder="Full name"/>
            </div>
            <div class="form-group">
                <input type="text" name="user_name" class="form-control" placeholder="User ID"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password"/>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" class="form-control" placeholder="Retype password"/>
            </div>
            <div class="form-group">
                <input type="text" name="job" class="form-control" placeholder="Job"/>
            </div>

            <div class="form-group">
                <label >Upload Image:</label>
                <input type="file" name="image_file" class="form-control" accept=".png ,.jpg" placeholder="Image"/>
            </div>

            <div class="form-group">
                <label >Upload CV:</label>
                <input type="file" name="cv_file" class="form-control" accept=".pdf" placeholder="cv"/>
            </div>
        </div>
        <div class="footer">

            <button name="signup_form" type="submit" class="btn bg-olive btn-block">Sign me up</button>
            <?php echo "<a href=". $_SERVER['PHP_SELF'].">I already have a membership</a>" ?>
<!--            <a href="../../index.php" class="text-center">I already have a membership</a>-->
        </div>
    </form>

    <div class="margin text-center">
        <span>Register using social networks</span>
        <br/>
        <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
        <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
        <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

    </div>
</div>



</body>
</html>