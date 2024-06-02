<?php

function updatePrestation(
    int $id_prestation,
    int $evaluation,
    string $url_fiche,
    float $montant,
    string $debut_prestation,
    int $duree_jour,
    int $id_prestataire,
    int $id_voyageur
): bool {
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $updatePrestationQuery = $databaseConnection->prepare("
        UPDATE prestation
        SET evaluation = :evaluation,
            url_fiche = :url_fiche,
            montant = :montant,
            debut_prestation = :debut_prestation,
            duree_jour = :duree_jour,
            id_prestataire = :id_prestataire,
            id_voyageur = :id_voyageur
        WHERE id_prestation = :id_prestation;
    ");

    return $updatePrestationQuery->execute([
        "id_prestation" => $id_prestation,
        "evaluation" => $evaluation,
        "url_fiche" => $url_fiche,
        "montant" => $montant,
        "debut_prestation" => $debut_prestation,
        "duree_jour" => $duree_jour,
        "id_prestataire" => $id_prestataire,
        "id_voyageur" => $id_voyageur
    ]);
}
