<?php
   include 'php/database.php' ;
   $sql = "SELECT sc.Remark, sc.Teacher_ID, sc.Completed, p.Firstname, p.Lastname, p.Infix, sc.Scrumlog_ID, sc.Input_Help ";
?>

<div id="page-content-wrapper">
    <div class="fantasie">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="doorzichtig">
                    
                    <h1>Scrumlog</h1>
                    <a href="#menu-toggle"  class="btn btn-default" id="menu-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
                    <?php 
                    $teacher_ID = $_SESSION['User']['Teacher_ID'];
                    $comments = getAllTodos($teacher_ID);
                    $wilComments = getAllTodos(11);
                    foreach ($comments as $comment)
                    {
                        echo '<div class="col-lg-3">'
                        . '<form class="invullen">'
                        . $comment['Firstname']
                        . ' '
                        . $comment['Infix']
                        . ' '
                        . $comment['Lastname']
                        . '<br>Jouw aantekening:'
                        . $comment['Remark']
                        . '<button>'
                        . 'voltooid?'
                        . '</button>'
                        . '</form>'
                        . '</div>';
                    }
                    foreach ($wilComments as $comment)
                    {
                        echo '<div class="col-lg-3">'
                        . '<form class="invullen">'
                        . $comment['Firstname']
                        . ' '
                        . $comment['Infix']
                        . ' '
                        . $comment['Lastname']
                        . '<br>Jouw aantekening:'
                        . $comment['Remark']
                        . '<button>'
                        . 'voltooid?'
                        . '</button>'
                        . '</form>'
                        . '</div>';
                    }
                    
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>