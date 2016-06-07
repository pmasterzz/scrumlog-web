<?php
include 'database.php';

$_POST['Date'] = $date;

if (isset($_POST['submit'])) {
    submitComment($_POST['Input_Remark'],$_POST['Input_Teacher'],$_POST['ID']);
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

