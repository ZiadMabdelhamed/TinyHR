
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
require_once("autoload.php");
define("_ALLOW_ACCESS", 1);
if(!isset($_SESSION))
{
    session_start();
}

session_regenerate_id();

$user = new Users();
$db = new Database();

$signup_status = [];
$login_status = [];
$change_password_status = [];
// sign up
if (isset($_POST["signup_form"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{
//    var_dump($_POST);
    $fname = $_POST["fname"];
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $job = $_POST["job"];
    $image_file = $_FILES["image_file"];
    $cv_file = $_FILES["cv_file"];

    $db->connect();
    $signup_status = $db->singup($user_name,$password,$confirm_password,$fname,$image_file,$cv_file,$job);
    $db->close_connect();

}

if (isset($_POST["log_in_form"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{

    $user_name = $_POST["user_name"];
    $password = $_POST["password"];

    $db->connect();
    $login_status = $db->login($user_name,$password);
    $db->close_connect();
}

if (isset($_POST["sign_out_form"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $db->connect();
    $db->signout();
    $db->close_connect();
}

if (isset($_POST["change_pass"])  && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];


    $db->connect();
    $change_password_status = $db->change_password($old_password,$new_password,$confirm_password);
    $db->close_connect();
//    $db->signout();
}
//var_dump($signup_status);

//********************************************//
//Routing
if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === true) {
    //admin views should be required here
    require_once ("Views/admin/users.php");
} elseif (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === false) {
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



?>


<!-- jQuery 2.0.2 -->
<script src="./Resources/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./Resources/js/bootstrap.min.js" type="text/javascript"></script>

<script src="./Resources/js/app.js" type="text/javascript"></script>