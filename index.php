
<link href="./Resources/css/bootstrap.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="./Resources/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="./Resources/css/AdminLTE.css" rel="stylesheet" type="text/css" />

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("vendor/autoload.php");
require_once("autoload.php");
require_once ("config.php");
define("_ALLOW_ACCESS", 1);
if(!isset($_SESSION))
{
    session_start();
}

session_regenerate_id();

$user = new User();
$user->Start_db();

$db = new Database();

$captcha = new \Anhskohbo\NoCaptcha\NoCaptcha(__Secret_Key__, __Site_Key__);

$fields=array();
 $formArrays = $db->get_data($fields);

$signup_status = [];
$login_status = [];
$change_password_status = [];
$update_data_status = [];
// sign up
if (isset($_POST["signup_form"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{
//    var_dump($_POST);
    $signup_status = $user->sign_up();
}

if (isset($_POST["log_in_form"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{

    $login_status = $user->login($captcha);

}

if (isset($_POST["sign_out_form"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $user->signout();

}

if (isset($_POST["change_pass"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $change_password_status = $user->change_password();
}


if (isset($_POST["Update_data"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $update_data_status = $user->update_user_data();

}

//var_dump($signup_status);

//********************************************//
//Routing
if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === true) {
    //admin views should be required here
    require_once ("Views/admin/users.php");
}
elseif (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === false) {
    if(isset($_GET["page"]) && $_GET["page"] =="edit_user")
    {
        require_once ("Views/member/edit_my_profile.php");
    }
    else if(isset($_GET["page"]) && $_GET["page"] =="change_pass")
    {
        require_once ("Views/member/change_pass_profile.php");
    }
    else
        {
            require_once ("Views/member/view_my_profile.php");
        }


    //members views should be required here
} else {
    if(isset($_GET["page"]) && $_GET["page"] =="signup" || count($signup_status)>0 )
    {
        require_once ("Views/public/signup.php");
    }


    else
        {
            require_once ("Views/public/login.php");
        }


}

//********************************************//
if(isset($_GET["id"]) && is_numeric($_GET["id"])){
    require_once ("Views/admin/user.php");
}
elseif (isset($_GET["Next"]) && is_numeric($_GET["Next"])){
    require_once ("Views/admin/users.php");
}
elseif (isset($_GET["Previous"]) && is_numeric($_GET["Previous"])){
    require_once ("Views/admin/users.php");
}
//else {
//    require_once ("Views/admin/users.php");
//}


?>


<!-- jQuery 2.0.2 -->
<script src="./Resources/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./Resources/js/bootstrap.min.js" type="text/javascript"></script>

<script src="./Resources/js/app.js" type="text/javascript"></script>