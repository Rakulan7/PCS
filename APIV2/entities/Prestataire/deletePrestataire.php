<?php

function deletePrestataire(string $id): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getPrestataireQuery = $databaseConnection->prepare("SELECT * FROM Prestataire WHERE id = :id;");

    $getPrestataireQuery->execute([
        "id" => $id
    ]);

    $Prestataire = $getPrestataireQuery->fetch(PDO::FETCH_ASSOC);

    if (!$Prestataire) {
        return false;
    }

    $deletePrestataireQuery = $databaseConnection->prepare("DELETE FROM Prestataire WHERE id = :id;");

    $success = $deletePrestataireQuery->execute([
        "id" => $id
    ]);

    return $success;
}
