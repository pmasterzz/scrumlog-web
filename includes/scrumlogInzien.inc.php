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
                        echo '<form action="" method="post" class="invullen">
                            <h3>Scrumlog bekijken</h3>
                            <input type="date" name="Date" value=' . date('Y-m-d') . ' class="form-control"></br></br>
                            <button type="submit" name="submit" class="knop">bekijk scrumlog</button>
                            </form>';
                     }
                     else
                    {
                         foreach($scrumlogArray as $scrumlog)
                        {
                            echo '<table class="table table-hover">'
                                . '<thead>'
                                . '<th>Datum</th>'
                                . '<th>Wat heb je gister bereikt</th>'
                                . '<th>Wat zat je in de weg</th>'
                                . '<th>Wat denk je vandaag te bereiken</th>'
                                . '<th>Wat voor hulp heb je nodig/waarbij?</th>'
                                . '<th>Welk van deze docenten moet jouw helpen?</th>'
                                . '</thead>'
                                . '<tbody>'
                                .'<tr>'
                                . '<td>' . $scrumlog['Date'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Yesterday'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Problems'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Today'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Help'] .  '</td>'
                                . '<td>' . $scrumlog['Radio_Help'] .  '</td>'
                                . '</tr>'
                                . '</tbody>'
                                . '</table>'
                                . '</div>';
                            }
                        }
                    }
                    else
                    {
                        if (!isset($_POST["submit"])){
                        echo '<form action="" method="post" class="invullen">
                            Datum:
                            <input type="date" name="Date" value=' . date('Y-m-d') . ' class="form-control"><br/><br/>
                            Jaar:
                            <select name="Year" class="form-control">';
                            
                        for($year = date('Y'); $year > $min_Year; $year--){echo '<option value="' . $year . '">' . $year . '</option>';}
                        echo '</select> <br/><br/> Tafel' ;
                        echo '<select name="Table" class="form-control">';
                        foreach($table as $table)
                        {
                            echo '<option value="' . $table . '">' . $table . '</option>';                        
                        }
                        echo '</select><br/><br/>'
                        . '<button type="submit" name="submit" class="knop">bekijk scrumlog</button>'
                                . '</form>';
                        
                    } 
                     else
                    {
                         echo '<div class="container">';
                         echo '<table class="table table-hover">'
                        . '<thead>'
                            . '<th>Datum</th>'
                            . '<th>Wat heb je gister bereikt</th>'
                            . '<th>Wat zat je in de weg</th>'
                            . '<th>Wat denk je vandaag te bereiken</th>'
                            . '<th>Wat voor hulp heb je nodig/waarbij?</th>'
                            . '<th>Welk van deze docenten moet jouw helpen?</th>'
                        . '</thead>'
                        . '<tbody>';
                         
                         foreach($scrumlogArray as $scrumlog)
                        {
                            echo '<tr>'
                                . '<td>' . $scrumlog['Date'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Yesterday'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Problems'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Today'] .  '</td>'
                                . '<td>' . $scrumlog['Input_Help'] .  '</td>'
                                . '<td>' . $scrumlog['Radio_Help'] .  '</td>'
                                . '</tr>';
                            }
                        }
                        echo '</tbody>'
                        . '</table>'
                        . '</div>';
                    }
                    
                    ?>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>