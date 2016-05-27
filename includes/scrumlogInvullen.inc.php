<?php
    include 'php/getAllTeachers.php';
    if ($_SESSION['Userlevel'] != 'Student') 
        {
            header("Location: home.php?page=scrumlogInzien");
        }
?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="doorzichtig">
                    <h1>Scrumlog</h1>
                    <a href="#menu-toggle"  class="btn btn-default" id="menu-toggle"><i class="glyphicon glyphicon-arrow-left"></i></a>
                    <p>
                    <?php
                    $last_Scrum = $_SESSION['User']['Last_Submitted_Scrumlog'];
                    $todays_Date = date('y-m-d');
                    $str_Today = strtotime($todays_Date);
                    $str_Last_Scrum = strtotime($last_Scrum);
                    if ($str_Last_Scrum != $str_Today){ // form already submitted
                        echo '<div class="scrumin"><form method="POST" action="php/submitScrumlog.php" class="scrum-invullen">
                        <h3>Scrumlog invullen</h3>
                        Wat heb je gister bereikt:<br>
                        <input type="text" name="Input_Yesterday" class="invullen form-control" required autofocus><br>
                        Wat zat je in de weg:<br>
                        <input type="text" name="Input_Problems" class="invullen form-control" required><br>
                        Wat denk je vandaag te bereiken:<br>
                        <input type="text" name="Input_Today" class="invullen form-control" required><br>
                        Wat voor hulp heb je nodig/waarbij?:<br>
                        <input type="text"  name="Input_Help" class="invullen form-control" value="n.v.t." required><br>
                        welk van deze docenten moet jouw helpen?<br>
                        <select name="Input_Teacher" class="form-control">
                            <option value="n.v.t.">geen</option>';   
                            foreach($teachersArray as $teacher)
                            {
                                echo '<option value=' . '"' 
                                        . $teacher['Teacher_ID'] . 
                                        '"' . "> " . $teacher['Firstname'] 
                                        . " " . $teacher['Lastname'] 
                                        . " </option>";
                            }
                           echo '</select><br><br>

                                <button type="submit" class="knop">VERSTUUR SCRUMLOG</button>
                            </form>
                        </p></div>';   
                    }
                    else {
                            echo '<img src="http://thecatapi.com/api/images/get?format=src&type=gif"></img>';
                        }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>