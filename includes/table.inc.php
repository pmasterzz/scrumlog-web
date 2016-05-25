<?php
 //   include 'php/updateTable.php';
    
    include 'php/globals.php';
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
                    <h1>Scrumlog</h1>
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="glyphicon glyphicon-arrow-right"></i></a>
                    <p>
                    <?php
                        echo '<form method="POST" id="tableForm" action="php/getTable.php" class="invullen"><h3>Selecteer een tafel</h3>
                            <select name="table"  class="form-control" onchange="document.getElementById(' . "'tableForm'" . ').submit();">';
                                
                        foreach($table as $table)
                        {
                            echo '<option value="' . $table . '"';
                                    if($_SESSION['seat'] == $table)
                                        { echo 'selected="selected"'; }
                                    echo '>' . $table . '</option>';
                        }
                        echo '</select></form><br>';
                        if (!isset($_SESSION["submit"]))
                        {   
                            
                        }
                        else
                        {
                            echo  '<div class="tafelContainer"><div class="col-lg-5"><form method="POST" action="php/updateTable.php"  id="formTafel"><h3>Tafel: ' . $_SESSION['seat'] . '</h3><select multiple="true"  class="form-control" name="table[]">';
                            foreach($_SESSION['students'] as $student)
                            {
                                echo '<option value="' . $student['Student_ID'] . '" >' . $student['Firstname'] . ' ' . $student['Infix'] . ' ' . $student['Lastname'] . ' ' . $student['Student_ID'] .  '</option>';
                            }
                             echo '</select> <br><br></form></div>';
                             unset($_SESSION['submit']);
                             echo '<div class="col-lg-2">'
                                    . '<div class="knopContainer">'
                                        . '<button type="submit"  form="formTafel" class="knop"><i class="glyphicon glyphicon-arrow-right"></i></button>'
                                        . '<button type="submit" form="formBeschikbaar" class="knop"><i class="glyphicon glyphicon-arrow-left"></i></button>'
                                        
                                    . '</div>'
                                  . '</div>';
                             echo  '<div class="col-lg-5"><form method="POST" action="php/setTable.php" id="formBeschikbaar" ><h3>Beschikbare studenten</h3><select multiple="true" class="form-control" name="table[]">';
                            foreach($_SESSION['availableStudents'] as $student)
                            {
                                echo '<option value="' . $student['Student_ID'] . '" >' . $student['Firstname'] . ' ' . $student['Infix'] . ' ' . $student['Lastname'] . ' ' . $student['Student_ID'] .  '</option>';
                            }
                             echo '</select> <br><br></form></div></div>';
                        }
                    ?>
                        <form action="php/clearTable.php" id="formLegen" method="POST" onclick="confirmBox()"><button type="submit" class="knop"><i class="glyphicon glyphicon-trash"></i></button></form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

