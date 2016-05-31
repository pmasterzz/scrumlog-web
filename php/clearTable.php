<?php
//session_start();
include_once 'database.php';
if (isset($_POST['clear'])) {
    $file = 'file.txt';
    $current = file_get_contents($file);
    $current .= 'In clearTable.php';
    file_put_contents($file, $current);
    clearTables();
}

$_SESSION['students'] = getSpecificTable($seat);
$_SESSION['availableStudents'] = getEmptyTable();

header("Location: ../home.php?page=createTable");

//setTable($students);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

