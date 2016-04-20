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
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Show menu</a>
                    <p>
                    <?php
                        echo '<form method="POST" action="php/updateTable.php">
                            <select name="table">';
                        foreach($table as $table)
                        {
                            echo '<option value="' . $table . '">' . $table . '</option>';
                        }
                        echo '</select> <button type="submit">SELECTEER</button></form>';
                        if (!isset($_SESSION["submit"]))
                        {   
                            
                        }
                        else
                        {
                            echo  '<form method="POST" action=""><select multiple="true" name="table">';
                            foreach($_SESSION['students'] as $student)
                            {
                                echo '<option value="' . $student['Student_ID'] . '" >' . $student['Firstname'] . ' ' . $student['Infix'] . ' ' . $student['Lastname'] . ' ' . $student['Student_ID'] .  '</option>';
                            }
                             echo '</select> <button type="submit">Verlos van deze tafel</button></form>';
                             unset($_SESSION['submit']);
                        }
                    ?>
                    
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

