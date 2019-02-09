<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AdminLTE | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Ionicons -->
    <link href="./Resources/css/ionicons.min.css" rel="stylesheet" type="text/css" />


</head>
<body class="skin-black">
    <?php

    $index=0;


if (isset($_GET["Next"])){
    if($_GET["Next"] == 0){
        $index = 5;
        $fields = $db->get_data(5, $index);
    }else if ($_GET["Next"]>=$db->countUsers()){
    $index=0;
    $fields=$db->get_data(0,$index);
    }
    else{
        $index = $_GET["Next"] + 5;
        $fields = $db->get_data(5, $index);
    }
}
else if (isset($_GET["Previous"])){
    if(($_GET["Previous"]-5) < 0){
        $index = 0;
        $fields = $db->get_data(5, $index);
    }else{
        $index = $_GET["Previous"] - 5;
        $fields = $db->get_data(5, $index);
    }
}
else{
    $fields = $db->get_data();
}

    ?>
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="index.html" class="logo">
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
                    <a href="index.html">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="pages/widgets.html">
                        <i class="fa fa-users"></i> <span>Online Users</span>
                    </a>
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

            <!-- Small boxes (Stat box) -->
            <div class="row">



                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                <?php
                               echo $db->countUsers(); ?>
                            </h3>
                            <p>
                                 Our Users
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div><!--                      
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->

            <!-- top row -->
            <div class="row">
                <div class="col-xs-12 connectedSortable">

                </div><!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">



                <div class="box" style="width: 300%; margin: 0 auto;">
                    <div class="box-header">
                        <h3 class="box-title">Bordered Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody><tr>
                                <th style="width: 10px">ID</th>
                                <th>User Name</th>                                
                                <th style="width: 40px">Option</th>
                            </tr>
                            <?php 
                                foreach ($fields as $value){
                                    echo "<tr><td>" .$value[0] . "</td>";    
                                    echo "<td>" .$value[1] . "</td>";    
                                    echo "<td><a href=" . $_SERVER['PHP_SELF']."?id=" .$value['id']. ">More Info</a></td>";                                    
                                }
                                echo "<tr>";
                            ?>
                            </tbody></table>
                    </div><!-- /.box-body -->
                    
                   <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                       <?php   echo " <li><a href=" . $_SERVER['PHP_SELF']."?Previous=".$index.">Previous</a></li>";
                            echo "<li><a href=" . $_SERVER['PHP_SELF']."?Next=".$index.">Next</a></li>"; ?>
                        </ul>
                    </div> 
                </div><!-- /.box -->



            </div><!-- /.row (main row) -->

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- add new calendar event modal -->






</body>
</html>