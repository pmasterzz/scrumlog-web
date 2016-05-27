<?php
    include 'php/getCycle.php';
    if ($_SESSION['Userlevel'] != 'Teacher') 
        {
            header("Location: home.php?page=scrumlogInvullen");
        }
?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="doorzichtig">
                    <h1>Cyclus wijzigen</h1>
                    <a href="#menu-toggle"  class="btn btn-default" id="menu-toggle"><i class="glyphicon glyphicon-arrow-left"></i></a>
                    <div class="row cylcus">
<!--                    <div class="tafel">-->
<!--                    <table class="table table-hover">
                        <thead>
                        <th>Start Datum</th>
                        <th>Eind Datum</th>
                        <th>Delete</th>
                        </thead>-->
                    <?php 
                    
                    foreach($cycles as $cycle)
                    {
                         echo '<form class="col-lg-3 invullen">'
                                . '<h3>Cyclus: ' . $cycle['Number'] .  '</h3><br>'
                                . 'Start Datum:<br>
                                  <input  class="form-control" value="' . $cycle['Start_Date'] . '" disabled><br>'
                                . 'Eind Datum:<br>
                                  <input class="form-control" value="' . $cycle['End_Date'] . '" disabled><br>'
                                 . '<div class="row">'
                                    . '<button class="col-lg-6 cyclusButton" data-toggle="tooltip" title="Bijwerken">'
                                     . '<i class="glyphicon glyphicon-pencil"></i>'
                                    . '</button>'
                                    . '<button class="col-lg-6 cyclusButton" data-toggle="tooltip" title="Verwijderen">'
                                        . '<i class="glyphicon glyphicon-trash"></i>'
                                    . '</button>'
                                . '</div>' 
                                . '</form>';
                    }
                    ?>
                    <!--</table>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
