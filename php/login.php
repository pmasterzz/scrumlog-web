<?php

session_start();



    if(isset($_POST['submit'])) {
        
        $isLoggedIn = login();
        if($isLoggedIn){
           $_SESSION['login'] = 'ingelogd'; 
          
           if($_SESSION['Userlevel'] == 'Student')
            {
                header("Location: ../home.php?page=scrumloginvullen");  
            }
           else
           {
                header("Location: ../home.php?page=scrumloginzien");
           }
        }
        else{
           //header("Location: ../index.php");
        }
       
            
    }
    else{
       header("Location: http://www.google.nl");
    }
function login(){    
    $url = 'http://localhost/scrumlog-web/api/index.php/login';
    $fields = array(
            'username' => urlencode($_POST['form-username']),
            'password' => urlencode($_POST['form-password']),
    );

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
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     
    //execute post
    $result = curl_exec($ch);
  
    $result = json_decode($result, TRUE);
	var_dump($result);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	echo $httpCode;

    if($httpCode === 401){
        return FALSE;
    }
    else if($httpCode === 200){
        
        $_SESSION['Token'] = $result['Token'];
        
        $_SESSION['User'] = $result['User'];
        $_SESSION['Userlevel'] = $result['Userlevel'];
        return TRUE;
    }
 
    //close connection
    curl_close($ch);
}
