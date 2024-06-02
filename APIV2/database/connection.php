<?php

function getDatabaseConnection(): PDO
{
    return $databaseConnection = new PDO(
        "mysql:host=localhost;dbname=pcs;charset=utf8",
        "root",
        ""
    );
}
