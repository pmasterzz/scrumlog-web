<?php
function getAllStudents()
{
    $url = 'http://localhost/scrumlog-api/index.php/api/tables';
    
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Token: ' . $_SESSION['Token']
    ));
    
    $result = curl_exec($ch);
    $filled_Seatings = json_decode($result, TRUE);
   
    return $teacher;
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

