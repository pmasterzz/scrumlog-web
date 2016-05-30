<?php
    function getDB()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "Welkom2016!";
        $dbname = "scrumlog-db";

        $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
        $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass); 
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }

?>