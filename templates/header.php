<?php
    session_start();
    require_once('core/init.php');
    //include ('includes/modals.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>


    <nav class="navbar  navbar-static-top navbar-default mero-nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                </button>
            
                <a class="navbar-brand" href="#"><h4 id="logo">MBR</h4></a>
            </div>
    
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">

                    <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
                    <li>
                        <?php
                            if($_SESSION['permission']==1){
                                echo "<a href='admin_page.php'><span class='glyphicon glyphicon-user'></span><p id='user'>Welcome ".$_SESSION['username']."</p></a>";    
                            }
                            elseif($_SESSION['permission']==0){
                                echo "<a href='branch_page.php'><span class='glyphicon glyphicon-user'></span><p id='user'> WELCOME ".$_SESSION['username']." </p></a>";
                            }
                        ?>   
                    </li>
 
                    <li>
                        <?php
                                if($_SESSION['permission']==1){
                                    echo "<a href='#' data-toggle='modal' data-target='#myModalViewMessage'><span class='glyphicon glyphicon-menu-hamburger'></span><p id='user'>View Order</p></a>";
                                }
                                elseif($_SESSION['permission']==0){
                                    echo "<a href='#'data-toggle='modal' data-target='#myModalSendMessage'><span class='glyphicon glyphicon-menu-hamburger'></span><p id='user'> Make Order</p></a>";
                                }
                            ?>
                   </li> 
                    <!-- <li><a href="#"><span class="glyphicon glyphicon-refresh"></span> change password</a></li> -->
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span><p id='user'> Logout</p></a></li>
                </ul>
            </div>
        </div>
    </nav>

    
  
