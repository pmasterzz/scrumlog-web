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
                            <input type="date" name="Date"><br>
                            <select>';
                            
                        for($year = date('Y'); $year > $min_Year; $year--){echo '<option value="' . $year . '">' . $year . '</option>';}
                        echo '</select> <br/>' ;
                        echo '<select>';
                        foreach($table as $table)
                        {
                            echo '<option value="' . $table . '">' . $table . '</option>';                        
                        }
                        echo '</select>'
                        . '<button type="submit" name="submit">submit</button>'
                                . '</form>';
                        
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
                    
                    ?>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>