<?php
session_start();
include_once 'database.php';

$number = $_POST["number"];
$start = $_POST["start_Date"];
$end = $_POST["end_Date"];
$id = $_POST["cycle_ID"];
if ($start < $end && $end > $start) {
    updateCycle($number, $start, $end, $id);
}
 else {
 $_SESSION['ERROR'] = 'http://activeshowcase.s3.amazonaws.com/activelab/files/538f6a9731ef4.jpg';
 
}

header("Location: ../home.php?page=createCycle");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

