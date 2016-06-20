<?php
include 'database.php';
if(isset($_POST['change'])){
    completeTodo($_POST['ID'], $_POST['Input_Remark']);
header("Location: ../home.php?page=todo");
}
