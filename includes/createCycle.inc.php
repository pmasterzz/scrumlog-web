<?php
    include 'php/getAllTeachers.php';
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
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>
                    
