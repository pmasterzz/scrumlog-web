<?php
   include 'php/getAllScrumlogs.php' ;
   include 'php/getAllTeachers.php';
   
?>

<div id="page-content-wrapper">
    <div class="fantasie">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="doorzichtig">
                    
                    <h1>Scrumlog</h1>
                    <a href="#menu-toggle"  class="btn btn-default" id="menu-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
                    
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="white">Persoonlijke todo's</h3>
                            </div> 
                        </div>
                        
                        <?php 
                        $teacher_ID = $_SESSION['User']['Teacher_ID'];
                        $comments = getAllTodos($teacher_ID);
                        $wilComments = getAllTodos(11);
                        function afkorten($naam, $lengte) {
                            $naam2 = $naam;
                            if (strlen($naam2) > $lengte) {
                                $naam2 = substr($naam2, 0, $lengte-2)."..";
                            }
                            return $naam2;
                        }
                        
                        if ($comments) {
                        foreach ($comments as $comment)
                        {
                            $naam = $comment['Firstname'] . ' ' . $comment['Infix'] . ' ' . $comment['Lastname'];
                            echo  '<form method="POST" action="" class="col-lg-3 invullen'; if ($comment['Completed'] == 1) echo ' complete'; echo '">' .  
                               '<h3 title="' . $naam . '">';
                            echo afkorten($naam,16);
                            echo '</h3>'
                            . '<h4 class="orange">Tafel: ' .$comment['Seating']  .  '</h4>'
                            . '<input type="hidden" name="ID" id="ID" value="' . $comment['Scrumlog_ID'] . '">'
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
                            . 'Jouw aantekening:'
                            . '<textarea class="form-control" id="Input_Remark" name="Input_Remark">'
                            . $comment['Remark']
                            . '</textarea>'
                            . '<div class="row">'
                            . '<button name="todoKnop" type="submit" id="todoKnop" class="col-lg-6 todoButton">'
                            . 'doorsturen'
                            . '</button>'
                            . '<button  formaction="php/completeTodo.php" name="change" class="col-lg-6 todoButton">'
                            . 'voltooid?'
                            . '</button>'
                            
                            . '</div>'
                            . '</form>';
                        }
                        
                        }
                        else {
                            echo '<div class="col-lg-12">'
                            . '<p>U heeft nog geen todo' . "'s vandaag" . '</p>'
                            . '</div>';
                        }
                        echo '<div class="col-lg-12 toegewezen">
                            <h3 class="white">Nog niet toegewezen todo' ."'" . 's</h3>
                        </div> ';
                        if ($wilComments) {
                        foreach ($wilComments as $comment)
                        {
                            
                            $naam = $comment['Firstname'] . ' ' . $comment['Infix'] . ' ' . $comment['Lastname'];
                            echo '<form method="POST" action="" class="col-lg-3 invullen'; if ($comment['Completed'] == 1) echo ' complete'; echo '">' .  
                               '<h3 title="' . $naam . '">';

                            echo afkorten($naam,16);
                            echo '</h3>'
                            . '<h4 class="orange">Tafel: ' .$comment['Seating']  .  '</h4>'
                            . '<input type="hidden" name="ID" id="ID" value="' . $comment['Scrumlog_ID'] . '">'
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
                            . 'Jouw aantekening:'
                            . '<textarea class="form-control" id="Input_Remark" name="Input_Remark">'
                            . $comment['Remark']
                            . '</textarea>'
                            . '<div class="row">'
                            . '<button name="todoKnop" type="submit" id="todoKnop" class="col-lg-6 todoButton">'
                            . 'doorsturen'
                            . '</button>'
                            . '<button formaction="php/completeTodo.php" name="change" class="col-lg-6 todoButton">'
                            . 'voltooid?'
                            . '</button>'
                            . '</div>'
                            . '</form>'
                            . '</div>';
                        }
                        }
                        else {
                            echo '<div class="col-lg-12">'
                            . '<p>Er zijn nog geen niet toegewezen todo' . "'s vandaag" . '</p>'
                            . '</div>';
                        }
                        

                        ?>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>