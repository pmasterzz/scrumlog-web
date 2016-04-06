<?php

session_start();
    if(isset($_POST['submit'])) {
        $_SESSION['login'] = 'ingelogd';
        login();
<<<<<<< HEAD
        header("Location: ../home.php");
=======
        header("Location: ../home.php?page=scrumloginvullen");
>>>>>>> refs/remotes/origin/master
        
    }
    else{
       header("Location: http://www.google.nl");
    }
function login(){    
    $url = 'http://localhost/scrumlog-api/index.php/api/login';
    $fields = array(
            'username' => urlencode($_POST['form-username']),
            'password' => urlencode($_POST['form-password']),
    );

    //url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);
}