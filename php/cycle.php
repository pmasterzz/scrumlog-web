<?php
include_once 'database.php';

if (isset($_POST['delete'])) {
    if (!deleteCycle($_POST['id'])) {
        $error = "KAN NIET";
    }

    header("Location: ../home.php?page=createCycle&msg=" . $error);
}

if (isset($_POST['toevoegen'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $number = $_POST['number'];
    //validate input
    if ($start >= $end || $end <= $start) {
        //show error
        $error = "De dautms kloppen niet";
        header("Location: ../home.php?page=addCycle&msg=" . $error);
    } else {
        addCycle($start, $end, $number);
        header("Location: ../home.php?page=createCycle&msg=" . $error);

    }
}

if (isset($_POST['annuleren']))
{
    header("Location: ../home.php?page=createCycle");
}

$cycles = getAllCycles();