<?php

class Connection
{
    public function connection()
    {
        $host = "wcwimj6zu5aaddlj.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
        $database = "d8ihmh8rpgigv7ra";
    
        $dsn = "mysql:dbname=".$database.";host=".$host;
        
        $username = "ia3dlq52x1t0z5ef";
        $password = "ss9x035kk1jrq6lk";
        
        try {
            $db = new PDO($dsn, $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        } catch (PDOException $e) {
            echo 'ERRO: ' . $e->getMessage();
        }
    }
}
?>