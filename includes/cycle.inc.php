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
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Show menu</a>
                    <?php 
                    foreach($cycles as $cycle)
                    {
                        echo $cycle['Cycle_ID'] . ' ' . $cycle['Start_Date'] . ' ' . $cycle['End_Date'] . '<br/>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
                    
