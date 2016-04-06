
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

    <title>Simple Sidebar - Start Bootstrap Template</title>

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
<<<<<<< HEAD
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="doorzichtig">   
                            <h1>Scrumlog</h1>
                            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Show menu bitch</a>
                            <p>
                                <form action="submitScrumlog.php" class="invullen">
                                    Wat heb je gister gedaan knuppel:<br>
                                    <input type="text" name="Input_Yesterday" class="invullen"><br>
                                    wat zat je in de weg:<br>
                                    <input type="text" name="Input_Problems" class="invullen"><br>
                                    wat denk je vandaag te bereiken:<br>
                                    <input type="text" name="Input_Today" class="invullen"><br>
                                    hulp heb je zeker nodig:<br>
                                    <input type="text"  name="Input_Help" class="invullen"><br>
                                    welk van deze slachtoffers moet jouw helpen?<br>
                                    <select name="Radio_Help">
                                        <option value="nvt">geen</option>
                                        <option value="Westerveld">Die Vrouw</option>
                                        <option value="Wouters">Die Belg</option>
                                        <option value="Michels">Die ene met die snor</option>
                                        <option value="Dirksen">Die andere vrouw</option>
                                        <option value="Menno">Die kale</option>
                                    </select><br><br>
                                    
                                    <button type="submit">Submit</button>
                                </form>
                            </p>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
=======
        <?php

        if (isset($_GET['page'])){
            switch($_GET['page']){
                case 'scrumloginvullen':
                    include 'includes/scrumloginvullen.inc.php';
                    break;
                case 'scrumloginzien':
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
>>>>>>> refs/remotes/origin/master
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
