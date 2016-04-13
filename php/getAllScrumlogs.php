<?php
if (isset($_POST["submit"]))
    {
        
    
if (isset ($_POST['Year']))
    {
        $year = $_POST['Year'];
    }
     else 
    {
     $year = 'undefined';
    }
if (isset ($_POST['Table']))
    {
        $table = $_POST['Table'];
    }
     else 
    {
     $table = 'undefined';
    }

if ($_SESSION['Userlevel'] == 'Student') 
{
    $student_ID = $_SESSION['User']['Student_ID'];
}
else
{
    if(isset($_POST['Student_ID']))
    {
        $student_ID = $_POST['Student_ID'];
    }
    else 
    {
        $student_ID = 'undefined';
    }    
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
    $date = $_POST['Date'];
    $date = date_create($date);
    $date = date_format($date, 'y-m-d');
    $scrumlogArray = getAllScrumlogs($date, $year,$table,$student_ID,$seating,$cycle_ID);  
  } 
function getAllScrumlogs($date, $year,$table,$student_ID,$seating,$cycle_ID)
{
    
    $url = 'http://localhost/scrumlog-web/api/api.php/api/scrumlog?';    
    $fields = array(
        'date' => urlencode($date),
        'year' => urlencode($year),
        'table' => urlencode($table),
        'student_ID' => urlencode($student_ID),
        'seating' => urlencode($seating),
        'cycle_ID' => urlencode($cycle_ID)
    );
    
    $fields_string="";
    //url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');
    
    
    $url .= $fields_string;

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    //curl_setopt($ch,CURLOPT_POST, count($fields));
    //curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     
    //execute post
    $result = curl_exec($ch);
    $scrumlogs = json_decode($result, TRUE);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    
    return $scrumlogs;
    
    //close connection
    curl_close($ch);
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
