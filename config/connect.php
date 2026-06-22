<?php
    $server = "localhost";
    $database = "atomdb";
    $username = "root";
    $password = "";

    try{
        $pdo = new PDO("mysql:host=$server;
                   dbname=$database;
                   charset=utf8mb4",
                   $username,
                   $password 
                   );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    }catch(PDOException $e){
        die('connection failed: ' . $e->getMessage());
    }
    
   



        