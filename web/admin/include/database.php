<?php

function getDatabase(){
    try{
        $db = new PDO(
            'mysql:host=localhost;dbname=pcs;charset=utf8',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    catch (Exception $e){
        die("failed to connect to the database !\n errors : " . $e->getMessage());
    }
    return $db;
}