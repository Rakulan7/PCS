<?php

function getBailleurs()
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getBailleursQuery = $databaseConnection->query("SELECT * FROM Bailleur;");

    $Bailleurs = $getBailleursQuery->fetchAll(PDO::FETCH_ASSOC);

    return $Bailleurs;
}
