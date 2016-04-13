<?php
$teachersArray = getAllTeachers();

function getAllTeachers()
{
    $url = 'http://localhost/scrumlog-web/api/api.php/api/getAllTeachers';
    
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Token: ' . $_SESSION['Token']
    ));
    
    $result = curl_exec($ch);
    $teacher = json_decode($result, TRUE);
   
    return $teacher;
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    

}