<?php
    function getDB()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "scrumlog-db";

        $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
        $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass); 
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }

?>