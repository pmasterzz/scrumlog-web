<?php
session_start();

$yesterday = $_POST['Input_Yesterday'];
$problems = $_POST['Input_Problems'];
$today = $_POST['Input_Today'];
$help = $_POST['Input_Help'];
$radio = $_POST['Input_Teacher'];
submitScrumlog();

header("Location: ../home.php?page=scrumlogInzien");
function submitScrumlog(){    
    $url = 'http://localhost/scrumlog-web/api/api.php/api/submitScrumlog';
    $fields = array(
            'input_Yesterday' => urlencode($_POST['Input_Yesterday']),
            'input_Problems' => urlencode($_POST['Input_Problems']),
            'input_Today' => urlencode($_POST['Input_Today']),
            'input_Help' => urlencode($_POST['Input_Help']),
            'input_Teacher' => urlencode($_POST['Input_Teacher']),
            'student_ID' => urlencode($_SESSION['User']['Student_ID']),
            'seating' => urlencode($_SESSION['User']['Seating'])
    );
    var_dump($fields);
    $fields_string="";
    //url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     
    //execute post
    curl_exec($ch);
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

 
    //close connection
    curl_close($ch);
}

