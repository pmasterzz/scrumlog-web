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
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Show menu</a><br/>
                    <div class="tafel">
                    <table class="table table-hover">
                        <thead>
                        <th>Start Datum</th>
                        <th>Eind Datum</th>
                        <th>Delete</th>
                        </thead>
                    <?php 
                    foreach($cycles as $cycle)
                    {
                        echo '<tr>'
                        . '<td><form action="php/editCycle.php" method="post">
                            <input type="date" name="start_Date" value="' .  $cycle['Start_Date'] . '">'
                            . '<input type="hidden" value="' . $cycle['End_Date'] . '" name="end_Date">'
                            . '<input type="hidden" value="' . $cycle['Number'] . '" name="number">'
                            . '<input type="hidden" value="' . $cycle['Cycle_ID'] . '" name="cycle_ID">'
                        . '<button type="submit" name="submit" class="btn btn-default"><i class="glyphicon glyphicon-edit" "></i></button>'
                        . '</form>'
                        
                        . '</td>'
                        
                        . '<td><form action="php/editCycle.php" method="post">
                            <input type="date" name="end_Date" value="' .  $cycle['End_Date'] . '">'
                            . '<input type="hidden" value="' . $cycle['Start_Date'] . '" name="start_Date">'
                            . '<input type="hidden" value="' . $cycle['Number'] . '" name="number">'
                            . '<input type="hidden" value="' . $cycle['Cycle_ID'] . '" name="cycle_ID">'
                        . '<button type="submit" name="submit" class="btn btn-default"><i class="glyphicon glyphicon-edit" "></i></button>'
                        . '</form>'
                        
                        . '</td>'
                        . '<td><i class="glyphicon glyphicon-remove"></i></td>'
                        . '</tr>';
                        
                    }
                    ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
