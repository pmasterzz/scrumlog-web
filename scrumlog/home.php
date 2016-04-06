
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

    <title>Scrumlog!</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/bootstrap/css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Start Bootstrap
                    </a>
                </li>
                <li>
                    <a href="#">Scrumlog invullen</a>
                </li>
                <li>
                    <a href="#">Scrumlog inzien</a>
                </li>

                
                <li class="beneden">
                    <a href="php/uitloggen.php">uitloggen/oprotten</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <?php

        if (isset($_GET['page'])){
            switch($_GET['page']){
                case 'scrumlogInvullen':
                    include 'includes/scrumloginvullen.inc.php';
                    break;
                case 'scrumlogInzien':
                    include 'includes/scrumlogsinzien.inc.php';
                    break;
                case 'allescrumloginzien':
                    include 'includes/allescrumlogsinzien.inc.php';
                    break;
                case 'wijzigtafel':
                    include 'includes/wijzigtafel.inc.php';
                    break;
                default:
                    include 'includes/scrumloginvullen.inc.php';
                    break;
            }
        }
        ?>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="assets/bootstrap/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
