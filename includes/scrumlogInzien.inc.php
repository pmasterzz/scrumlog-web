<?php
    include 'php/getAllScrumlogs.php';
    include 'php/globals.php';
    $min_Year = date('Y') - 5;
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
                    if ($_SESSION['Userlevel'] == 'Student') {
                    if (!isset($_POST["submit"])){
                        echo '<form action="" method="post">
                            <input type="date" name="Date"><br>
                            <button type="submit" name="submit">submit</button>
                            </form>';
                     }
                     else
                    {
                         foreach($scrumlogArray as $scrumlog)
                        {
                            echo '<p>Datum:' .  '<br>';
                            echo $scrumlog['Date'] .  '<br>';
                            echo 'Wat heb je gister gedaan knuppel:' .  '<br>';
                            echo $scrumlog['Input_Yesterday'] .  '<br>';
                            echo 'wat zat je in de weg:' .  '<br>';
                            echo $scrumlog['Input_Problems'] .  '<br>';
                            echo 'wat denk je vandaag te bereiken:' .  '<br>';
                            echo $scrumlog['Input_Today'] .  '<br>';
                            echo 'hulp heb je zeker nodig:' .  '<br>';
                            echo $scrumlog['Input_Help'] .  '<br>';
                            echo 'welk van deze slachtoffers moet jouw helpen?' .  '<br>';
                            echo $scrumlog['Radio_Help'] .  '<br></p>';
                            }
                        }
                    }
                    else
                    {
                        if (!isset($_POST["submit"])){
                        
                        echo '<form action="" method="post">
                            <input type="date" name="Date"><br><br>
                            <select name="Year">';
                            
                        for($year = date('Y'); $year > $min_Year; $year--){echo '<option value="' . $year . '">' . $year . '</option>';}
                        echo '</select><br><br>' ;
                        echo '<select name="Table"><option value="">n.v.t</option>';
                        foreach($table as $table){ echo '<option value="' . $table . '">' . $table . '</option>';} 
                        echo '</select><br><br>'
                        . '<button type="submit" name="submit">submit</button>';
                        
                     }
                     else
                    {
                        echo '<table class="table table-hover">'
                        . '<thead>'
                        . '<tr>'
                            . '<th>Datum:</th><th>Wat heb je gister gedaan</th><th>Wat zat je in de weg?</th><th>Wat denk je vandaag te bereiken?</th><th>Heb jij hulp nodig?</th><th>Slachtoffer</th>'
                        . '</tr>'
                        . '</thead><tbody>';
                        foreach($scrumlogArray as $scrumlog)
                        {
                            echo '<tr>';
                            echo '<td>' . $scrumlog['Firstname'] . " " . $scrumlog['Infix'] . " " . $scrumlog['Lastname'] . " " . '</td>';
                            echo '<td>' . $scrumlog['Input_Yesterday'] .  '</td>';
                            echo '<td>' . $scrumlog['Input_Problems'] .  '</td>';
                            echo '<td>' . $scrumlog['Input_Today'] .  '</td>';
                            echo '<td>' . $scrumlog['Input_Help'] .  '</td>';
                            echo '<td>' . $scrumlog['Radio_Help'] .  '</td>';
                            echo '</tr>';
                        }
                        }
                        echo '</tbody></table>';
                    }
                    
                    ?>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>
