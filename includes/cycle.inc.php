<?php
include 'php/getCycle.php';
include 'php/globals.php';
$message = "Weet je het zeker?";
if ($_SESSION['Userlevel'] != 'Teacher') {
    header("Location: home.php?page=scrumlogInvullen");
}
?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="doorzichtig">
                    <h1>Cyclus wijzigen</h1>
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i
                            class="glyphicon glyphicon-arrow-left"></i></a>
                    <a href="?page=addCycle">
                        <button class="cyclusButton">Cyclus Toevoegen</button>
                    </a>
                    <div class="row cylcus">


                        <?php
                        if (isset($_GET['msg']) && $_GET['msg']!="")
                            echo '<div class="alert alert-danger">' . $_GET['msg'] . '</div>';
                        foreach ($cycles as $cycle) {
                            echo '<form method="POST" action="php/cycle.php" class="col-lg-3 invullen">'
                                . '<input type="hidden" name="id" value="' . $cycle['Cycle_ID'] . '">'
                                . '<h3>Cyclus: ' . $cycle['Number'] . '</h3><br>'
                                . 'Start Datum:<br>
                                  <input  class="form-control" value="' . $cycle['Start_Date'] . '" disabled><br>'
                                . 'Eind Datum:<br>
                                  <input class="form-control" value="' . $cycle['End_Date'] . '" disabled><br>'
                                . '<div class="row">'
                                . '<button class="col-lg-6 cyclusButton" data-toggle="tooltip" title="Bijwerken">'
                                . '<i class="glyphicon glyphicon-pencil"></i>'
                                . '</button>'
                                . '<button name="delete" class="col-lg-6 cyclusButton cyclusDeleteBtn" data-toggle="tooltip" title="Verwijderen">'
                                . '<i class="glyphicon glyphicon-trash"></i>'
                                . '</button>'
                                . '</div>'
                                . '</form>';


                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


                    
