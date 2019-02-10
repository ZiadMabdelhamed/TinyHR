<?php 
$db = new Database("users");
$id = (isset($_GET["id"]))?(int)$_GET["id"]:0;
$Single_page = $db->get_record_by_id($id, "id");
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AdminLTE | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Ionicons -->
    <link href="./Resources/css/ionicons.min.css" rel="stylesheet" type="text/css" />

    <link href="./Resources/css/custom.css" rel="stylesheet" type="text/css" />


</head>
<body class="skin-black">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="<?php $_SERVER['PHP_SELF'] ?>" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        AdminLTE
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">



                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><?php echo $_SESSION["user_id"]; ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="./Uploads/Images/<?php if(isset($_SESSION["user_id"])) echo $_SESSION["user_id"]?>.jpg" class="img-circle" alt="User Image" />
                            <p>
                                <?php echo $_SESSION["user_id"]; ?>
                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <form  method="POST">
                                    <!--                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>-->
                                    <button name="sign_out_form" type="submit" class="btn bg-olive btn-block">Sign out</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="./Uploads/Images/<?php if(isset($_SESSION["user_id"])) echo $_SESSION["user_id"]?>.jpg" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p><?php
                        echo $_SESSION["user_id"];
                        ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="<?php echo __Home_Page__ ?>">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo __Home_Page__ ."?page=online_users" ?>">
                        <i class="fa fa-users"></i> <span>Online Users</span>
                    </a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">

        <!-- Main content -->
        <section class="content">

            <!-- Small boxes (Stat box) -->



            <div class="row">



                <div class="box" style="width: 90%;margin: 0 auto;">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="heading">
                                <img src="./Resources/img/logo.png" />
                            </div>
                        </div>
                    </div>
                    <div class="bio-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="bio-image">
                                            <img src="./<?php if(isset($Single_page["user_name"])) echo __Images__Folder__.$Single_page["user_name"]?>.jpg" Style="width: 254px;height: 240px;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bio-content">

                                     <h1><?php if(isset($Single_page["user_name"])) echo $Single_page["user_name"]?></h1>
                                    <h4>User Name : <?php if(isset($Single_page["Fname"])) echo $Single_page["Fname"]?></h4>
                                    <br>
                                    <h3>Job : <?php if(isset($Single_page["job"])) echo $Single_page["job"]?></h3>


                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.box -->



            </div><!-- /.row (main row) -->

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- add new calendar event modal -->



</body>
</html>
