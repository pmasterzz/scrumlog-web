<?php
    function getDB()
    {
        $dbhost = "us-cdbr-azure-central-a.cloudapp.net";
        $dbuser = "beed615a75b973";
        $dbpass = "acd4afcb";
        $dbname = "scrumlog-db";

        $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
        $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass); 
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }

?>