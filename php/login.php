<?php
include 'database.php';

session_start();


if (isset($_POST['submit'])) {

    $isLoggedIn = login2();
    if ($isLoggedIn) {
        $_SESSION['login'] = 'ingelogd';

        if ($_SESSION['Userlevel'] == 'Student') {
            header("Location: ../home.php?page=scrumloginvullen");
        } else {
            header("Location: ../home.php?page=scrumloginzien");
        }
    } else {
        $_SESSION['foutmelding'] = 'fout';
        header("Location: ../index.php");
    }


} else {
    header("Location: http://www.google.nl");
}
function login2()
{
    $username = $_POST['form-username'];
    $password = $_POST['form-password'];
    $login = login($username, $password);

    if (!$login) {
        return false;
    } else {
        $_SESSION['Token'] = $login['Token'];
        $_SESSION['User'] = $login['User'];
        $_SESSION['Userlevel'] = $login['Userlevel'];
        return true;
    }
    
}

;
