<?php

function updateOccupation(
    int $id_occupation,
    string $date_debut,
    string $date_fin,
    string $raison_indispo,
    float $montant,
    int $nombre_personne,
    int $id_bailleur,
    int $id_voyageur,
    int $id_bien
): bool {
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $updateOccupationQuery = $databaseConnection->prepare("
        UPDATE Occupation
        SET date_debut = :date_debut,
            date_fin = :date_fin,
            raison_indispo = :raison_indispo,
            montant = :montant,
            nombre_personne = :nombre_personne,
            id_bailleur = :id_bailleur,
            id_voyageur = :id_voyageur,
            id_bien = :id_bien
        WHERE id_occupation = :id_occupation;
    ");

    return $updateOccupationQuery->execute([
        "id_occupation" => $id_occupation,
        "date_debut" => $date_debut,
        "date_fin" => $date_fin,
        "raison_indispo" => $raison_indispo,
        "montant" => $montant,
        "nombre_personne" => $nombre_personne,
        "id_bailleur" => $id_bailleur,
        "id_voyageur" => $id_voyageur,
        "id_bien" => $id_bien
    ]);
}
