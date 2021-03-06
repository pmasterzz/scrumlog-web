<?php
include_once 'database.php';

if (isset($_POST['delete'])) {
    if (!deleteCycle($_POST['id'])) {
        $error = "Deze cyclus kan niet verwijderd worden omdat er opdrachten aan deze cyclus zijn verbonden.";
    }

    header("Location: ../home.php?page=createCycle&msg=" . $error);
}

if (isset($_POST['toevoegen'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $description = $_POST['description'];
    //validate input
    if ($start >= $end || $end <= $start) {
        //show error
        $error = "De datums kloppen niet";
        header("Location: ../home.php?page=addCycle&msg=" . $error);
    } else {
        addCycle($start, $end, $description);
        header("Location: ../home.php?page=createCycle&msg=" . $error);

    }
}

if (isset($_POST['annuleren'])) {
    header("Location: ../home.php?page=createCycle");
}

if (isset($_POST['toEdit'])) {
    $id = $_POST['id'];
    $desc = $_POST['description'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    header("Location: ../home.php?page=addCycle&start=" . $start . "&end=" . $end . "&descr=" . $desc . "&id=" . $id);
}

if (isset($_POST['wijzigen'])) {

    $id = $_POST['id'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $description = $_POST['description'];

    
    //validate input
    if ($start >= $end || $end <= $start) {
        //show error
        $error = "De datums kloppen niet";
        header("Location: ../home.php?page=addCycle&msg=" . $error);
    } else {
        updateCycle($description, $start, $end, $id);
        header("Location: ../home.php?page=createCycle");
    }
}


$cycles = getAllCycles();