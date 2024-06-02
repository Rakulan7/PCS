<?php

function getPrestataire(string $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getPrestataireQuery = $databaseConnection->prepare("SELECT * FROM Prestataire WHERE id = :id;");

    $getPrestataireQuery->execute([
        "id" => $id
    ]);

    $Prestataire = $getPrestataireQuery->fetch(PDO::FETCH_ASSOC);

    return $Prestataire;
}
