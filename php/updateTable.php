<?php
include_once'database.php';
$seat = $_POST['table'];
$students = getSpecificTable($seat);
var_dump($students);

//setTable($students);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

