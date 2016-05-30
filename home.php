
<?php


session_start();

if (!isset($_SESSION['login'])){
    header("Location: index.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Scrumlog - Leuker kunnen we het niet maken, wel makkelijker</title>
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <!-- Bootstrap Core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/bootstrap/css/simple-sidebar.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Javascript -->


</head>

<body>
    
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
  
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a>
                        <?php echo '<div class="knop"><h3>Welkom: ' .  $_SESSION['User']['Firstname']  . '</h3></div>'; ?>
                    </a>
                </li>
                <li>
                <?php 
                    if ($_SESSION['Userlevel'] == 'Student')
                        {
                            echo ' <a href="?page=scrumlogInvullen">Scrumlog invullen</a>';
                        }
                ?>
                   
                </li>
                <li>
                    <a href="?page=scrumlogInzien">Scrumlog inzien</a>
                </li>
                <li>
                <?php 
                    if ($_SESSION['Userlevel'] == 'Teacher')
                        {
                            echo ' <a href="?page=createTable">Tafels Wijzigen</a>';
                        }
                ?>   
                </li>
                <li>
                <?php 
                    if ($_SESSION['Userlevel'] == 'Teacher')
                        {
                            echo ' <a href="?page=createCycle">Cyclus Wijzigen</a>';
                        }
                ?>   
                </li>
                
                <li class="beneden">
                    <a href="php/uitloggen.php">uitloggen</a>
                </li>
            </ul>
        </div>
        
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <?php
        if (isset($_GET['page'])){
            switch($_GET['page']){
                case 'scrumlogInvullen':
                    include 'includes/scrumlogInvullen.inc.php';
                    break;
                case 'scrumlogInzien':
                    include 'includes/scrumlogInzien.inc.php';
                    break;
                case 'allescrumloginzien':
                    include 'includes/allescrumlogsInzien.inc.php';
                    break;
                case 'createTable':
                    include 'includes/table.inc.php';
                    break;
                case 'createCycle':
                    include 'includes/cycle.inc.php';
                    break;
                case 'addCycle':
                    include 'includes/addCycle.inc.php';
                    break;
                default:
                    include 'includes/scrumlogInvullen.inc.php';
                    break;
            }
        }
        
        ?>
        <!-- /#page-content-wrapper -->
        <div class="wasHier">
            <?php echo $_SESSION['User']['Firstname'] . ' wazz hier'; ?>
        </div>  
    </div>
    
    <!-- /#wrapper -->

    <!-- jQuery -->
    <!--<script src="assets/bootstrap/js/jquery.js"></script>-->

    <!-- Bootstrap Core JavaScript -->
    <!--<script src="assets/bootstrap/js/bootstrap.min.js"></script>-->
    
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    $(document).ready(function(){
        $('#menu-toggle').click(function(){
        console.log('message');
        $(this).find('i').toggleClass('glyphicon-arrow-left glyphicon-arrow-right');
    });
        
    });
    </script>

</body>

</html>
