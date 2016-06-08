<?php
include 'database.php';
$teacher_ID = $_SESSION['User']['Teacher_ID'];
getAllTodos($teacher_ID);
header("location: ?page=todo");


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

