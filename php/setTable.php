<?php
session_start();
include_once'database.php';
$_SESSION["submit"] = "set";
$students = $_POST["table"];
$seat = $_SESSION['seat'];
setTable($students,$seat);

$_SESSION['students'] = getSpecificTable($seat);
$_SESSION['availableStudents'] = getEmptyTable();

 header("Location: ../home.php?page=createTable");

//setTable($students);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

