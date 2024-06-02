<?php

function getPrestataires()
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getPrestatairesQuery = $databaseConnection->query("SELECT * FROM Prestataire;");

    $Prestataires = $getPrestatairesQuery->fetchAll(PDO::FETCH_ASSOC);

    return $Prestataires;
}
