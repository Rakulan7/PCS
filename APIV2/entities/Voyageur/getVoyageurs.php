<?php

function getVoyageurs()
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getVoyageursQuery = $databaseConnection->query("SELECT * FROM Voyageur;");

    $Voyageurs = $getVoyageursQuery->fetchAll(PDO::FETCH_ASSOC);

    return $Voyageurs;
}
