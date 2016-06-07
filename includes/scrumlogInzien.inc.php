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
                    <a href="#menu-toggle"  class="btn btn-default" id="menu-toggle"><i class="glyphicon glyphicon-arrow-left"></i></a>
                    <p>
                    <?php 
                    if ($_SESSION['Userlevel'] == 'Student') {
                    if (!isset($_POST["submit"]) || $scrumlogArray == false){
                        echo '<form action="" method="post" class="scrum-invullen">';
                        
                         if(isset($_POST["submit"]) && $scrumlogArray == false){
                            echo '<div class="alert alert-danger">
                                    Er zijn geen scrumlogs gevonden
                                  </div>';
                                }
                        
                        
                        
                            echo '<h3>Scrumlog bekijken</h3>
                            <input type="date" name="Date" value=' . date('Y-m-d') . ' class="form-control"></br></br>
                            <button type="submit" name="submit" class="knop">bekijk scrumlog</button>
                            </form>';
                     }
                     else
                        {
                         foreach($scrumlogArray as $scrumlog)
                        {
                            echo '<form class="scrum-invullen">'
                                . '<h3>Scrumglog van: ' . $scrumlog['Date'] .  '</h3><br>'
                                . 'Wat heb je gister bereikt:<br>
                                  <input  class="form-control" value="' . $scrumlog['Input_Yesterday'] . '" disabled><br>'
                                . 'Wat zat je in de weg:<br>
                                  <input class="form-control" value="' . $scrumlog['Input_Problems'] . '" disabled><br>'
                                . 'Wat denk je vandaag te bereiken:<br>
                                  <input class="form-control" value="' . $scrumlog['Input_Today'] . '" disabled><br>'
                                . 'Wat voor hulp heb je nodig/waarbij?:<br>
                                  <input class="form-control" value="' . $scrumlog['Input_Help'] . '" disabled><br>'
                                . 'welk van deze docenten moet jouw helpen?<br>
                                  <input class="form-control" value="' . $scrumlog['Radio_Help'] . '" disabled>'
                                . '</form>';
                            }
                        
                        }
                    }
                    else
                    {
                        if ((!isset($_POST["submit"]) && !isset($_POST['todoKnop'])) || $scrumlogArray == false ){
                            
                            echo '<form action="" method="post" class="scrum-invullen">';
                            
                                if(isset($_POST["submit"]) && $scrumlogArray == false){
                            echo '<div class="alert alert-danger">
                                
                                    Er zijn geen scrumlogs gevonden
                                
                            </div>';
                                }
                            
                            
                            
                        
                            echo '<h3>Scrumlog Inzien</h3>
                            Datum:
                            <input type="date" name="Date" value=' . date('Y-m-d') . ' class="form-control"><br/><br/>
                            Jaar:
                            <select name="Year" class="form-control">
                            <option value="undefined" selected="selected">n.v.t.</option>';
                            
                        for($year = date('Y'); $year > $min_Year; $year--){echo '<option value="' . $year . '">' . $year . '</option>';}
                        echo '</select> <br/><br/> Tafel' ;
                        echo '<select name="Table" class="form-control">'
                        . '<option value="undefined">n.v.t.</option>';
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
                         
                        echo '<div class="col-lg-12 centreren">'
                         . '<h3>' . $_POST['Date'] . '</h3>'
                         . '</div>' ;



//                        function afkorten($naam, $lengte) {
//                            $naam2 = $naam;
//                            if (strlen($naam2) > $lengte) {
//                                $naam2 = substr($naam2, 0, $lengte-2)."..";
//                            }
//                            return $naam2;
//                        }

                                 
                         foreach($scrumlogArray as $scrumlog)
                        {
                            $naam = $scrumlog['Firstname'] . ' ' . $scrumlog['Infix'] . ' ' . $scrumlog['Lastname'][0];
                            echo 
                            '<form method="POST" action="" class="col-lg-3 invullen">'
                            . '<h3 title="' . $naam . '">';

//                            echo afkorten($naam,16);
                            echo '</h3><br>'
                            . '<input type="hidden" name="Date" value="' . $scrumlog['Date'] . '">'
                            . '<input type="hidden" name="ID" id="ID" value="' . $scrumlog['Scrumlog_ID'] . '">'
                            . 'Wat heb je gister bereikt:<br>
                              <input  class="form-control" value="' . $scrumlog['Input_Yesterday'] . '" disabled><br>'
                            . 'Wat zat je in de weg:<br>
                              <input class="form-control" value="' . $scrumlog['Input_Problems'] . '" disabled><br>'
                            . 'Wat denk je vandaag te bereiken:<br>
                              <input class="form-control" value="' . $scrumlog['Input_Today'] . '" disabled><br>'
                            . 'Wat voor hulp heb je nodig/waarbij?:<br>
                              <input class="form-control" value="' . $scrumlog['Input_Help'] . '" disabled><br>'
                            . 'welk van deze docenten moet jouw helpen?<br>
                              <input class="form-control" value="' . $scrumlog['Radio_Help'] . '" disabled>'
                            . 'Commentaar doorsturen naar'
                            .'<select id="Input_Teacher" name="Input_Teacher" class="form-control">';
                            foreach($teachersArray as $teacher)
                            {
                                echo '<option value=' . '"'
                                        . $teacher['Teacher_ID'] .
                                        '"' . "> " . $teacher['Firstname']
                                        . " " . $teacher['Lastname']
                                        . " </option>";
                            }
                           echo '</select>'
                            . 'commentaar'
                            . '<input class="form-control" id="Input_Remark" name="Input_Remark" value="'. $scrumlog['Remark'] . '"><br>'
                            . '<button type="submit" id="todoKnop" class="knop" name="todoKnop">VERSTUUR COMMENTAAR</button>'
                            . '</form>';
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