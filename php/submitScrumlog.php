<?php
include_once 'database.php';
session_start();

$yesterday = $_POST['Input_Yesterday'];
$problems = $_POST['Input_Problems'];
$today = $_POST['Input_Today'];
$help = $_POST['Input_Help'];
$radio = $_POST['Input_Teacher'];
$student_ID = $_SESSION['User']['Student_ID'];
$seating = $_SESSION['User']['Seating'];


submitScrumlog($yesterday, $problems, $today, $help, $radio, $student_ID, $seating);
$_SESSION['User']['Last_Submitted_Scrumlog'] = date('y-m-d');


header("Location: ../home.php?page=scrumlogInzien");
?>

