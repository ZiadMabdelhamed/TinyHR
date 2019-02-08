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
                        <span><?php if(isset($_SESSION["user_id"])) echo $_SESSION["user_id"]?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="./<?php if(isset($_SESSION["user_id"])) echo __Images__Folder__.$_SESSION["user_id"]?>.jpg" class="img-circle" alt="User Image" />
                            <p>
                                <?php if(isset($_SESSION["user_id"])) echo $_SESSION["user_id"]?>
                            </p>
                        </li>

                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <form  method="POST">
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
                    <img src="./<?php if(isset($_SESSION["user_id"])) echo __Images__Folder__.$_SESSION["user_id"]?>.jpg" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p><?php if(isset($_SESSION["user_id"])) echo $_SESSION["user_id"]?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li>
                        <?php echo "<a href=". $_SERVER['PHP_SELF']."> <i class='fa fa-dashboard'></i> <span>Profile</span></a>" ?>
                </li>

                <li class="treeview active">
                    <a href="#">
                        <i class='fa fa-users'></i>
                        <span>Edit Profile</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php echo "<li ><a href=". $_SERVER['PHP_SELF']."?page=edit_user"."><i class='fa fa-angle-double-right'></i> General</a><li>" ?>
                        <?php echo "<li class='active'><a href=". $_SERVER['PHP_SELF']."?page=change_pass"."><i class='fa fa-angle-double-right'></i> Change Password</a><li>" ?>

                    </ul>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <?php
            // show errors
            if(isset($change_password_status) && count($change_password_status) > 0)
            {
                for($i=0 ;$i<count($change_password_status);$i++)
                {
                    echo '<div class="alert alert-danger">
                <strong>Error! </strong>'.$change_password_status[$i].
                        '</div>';
                }

            }



            ?>

            <!-- Small boxes (Stat box) -->



            <div class="row">



                <!-- edit form column -->
                <div class="col-md-9 personal-info">
<!--                    <div class="alert alert-info alert-dismissable">-->
<!--                        <a class="panel-close close" data-dismiss="alert">×</a>-->
<!--                        <i class="fa fa-coffee"></i>-->
<!--                        This is an <strong>.alert</strong>. Use this to show important messages to the user.-->
<!--                    </div>-->
                    <h3> Password info</h3>

                    <form class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF']."?page=change_pass"; ?>" method="POST">


                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Password:</label>
                            <div class="col-md-8">
                                <input name="old_password" class="form-control" type="password" value="">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Password:</label>
                            <div class="col-md-8">
                                <input name="new_password" class="form-control" type="password" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm password:</label>
                            <div class="col-md-8">
                                <input name="confirm_password" class="form-control" type="password" value="">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-8">
                                <input name="change_pass" type="submit" class="btn btn-primary" value="Update Password">
<!--                                <span></span>-->
<!--                                <input type="reset" class="btn btn-default" value="Cancel">-->
                            </div>
                        </div>

                    </form>
                </div>



            </div><!-- /.row (main row) -->

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- add new calendar event modal -->



</body>
</html>