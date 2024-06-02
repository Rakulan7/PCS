<?php

function createPrestation(
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

    $createPrestationQuery = $databaseConnection->prepare("
        INSERT INTO prestation(
            evaluation, url_fiche, montant, debut_prestation, duree_jour, id_prestataire, id_voyageur
        ) VALUES (
            :evaluation, :url_fiche, :montant, :debut_prestation, :duree_jour, :id_prestataire, :id_voyageur
        );
    ");

    return $createPrestationQuery->execute([
        "evaluation" => $evaluation,
        "url_fiche" => $url_fiche,
        "montant" => $montant,
        "debut_prestation" => $debut_prestation,
        "duree_jour" => $duree_jour,
        "id_prestataire" => $id_prestataire,
        "id_voyageur" => $id_voyageur
    ]);
}
