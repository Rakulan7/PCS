<?php

function getBiens()
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getBiensQuery = $databaseConnection->query("SELECT * FROM Bien;");

    $Biens = $getBiensQuery->fetchAll(PDO::FETCH_ASSOC);

    return $Biens;
}
