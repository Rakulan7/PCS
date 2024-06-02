<?php

function getVoyageur(string $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getVoyageurQuery = $databaseConnection->prepare("SELECT * FROM Voyageur WHERE id = :id;");

    $getVoyageurQuery->execute([
        "id" => $id
    ]);

    $Voyageur = $getVoyageurQuery->fetch(PDO::FETCH_ASSOC);

    return $Voyageur;
}
