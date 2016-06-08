<?php
include 'database.php';
if (isset($_POST["submit"])) {
    if (isset ($_POST['Year'])) {
        $year = $_POST['Year'];
    } else {
        $year = 'undefined';
    }
    if (isset ($_POST['Table'])) {
        $table = $_POST['Table'];
    } else {
        $table = 'undefined';
    }

    if ($_SESSION['Userlevel'] == 'Student') {
        $student_ID = $_SESSION['User']['Student_ID'];
    } else {
        if (isset($_POST['Student_ID'])) {
            $student_ID = $_POST['Student_ID'];
        } else {
            $student_ID = 'undefined';
        }

     
            if (isset ($_POST['Seating']))
                {
                    $seating = $_POST['Seating'];
                } 
            else 
                {
                    $seating = 'undefined';
                }
            if (isset ($_POST['Cycle_ID']))
                {
                    $cycle_ID = $_POST['Cycle_ID'];
                }
            else 
                {
                 $cycle_ID = 'undefined';
                }
            if (isset($_POST['Input_Remark']))
                {
                    $input_Remark = $_POST['Input_Remark'];
                }
            else 
                {
                    $input_Remark = 'undefined';
                }
            if (isset($_POST['Input_Teacher']))
                {
                    $Input_Teacher = $_POST['Input_Teacher'];
                }
             else 
                {
                     $Input_Teacher = 'undefined';
                }
        
    $date = $_POST['Date'];
    
    $date = date_create($date);
    $date = date_format($date, 'y-m-d'); 
    $scrumlogArray = getScrumlog($date, $year,$student_ID,$table,$cycle_ID);
    $_SESSION['scrumlogArray'] = $scrumlogArray;
    $_SESSION['Date'] = $date;
    //$scrumlogArray = getAllScrumlogs($date, $year,$table,$student_ID,$seating,$cycle_ID);  
  } 
}
  if(isset($_POST['Input_Remark']))
                {
                     submitComment($_POST['Input_Remark'],$_POST['Input_Teacher'],$_POST['ID']);
                       
                     $scrumlogArray = $_SESSION['scrumlogArray'];
                     for($i = 0;$i < sizeof($scrumlogArray); $i++) {
                        if ($scrumlogArray[$i]['Scrumlog_ID'] == $_POST['ID']) 
                        {
                            $scrumlogArray[$i]['Remark'] = $_POST['Input_Remark'];
                        }
                     }
                } 


