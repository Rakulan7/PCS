<?php

function updatePrestataire(
    int $id_prestataire,
    bool $refuse_par_admin,
    string $raison_refuse,
    string $nom,
    string $prenom,
    string $email,
    string $mot_passe,
    int $id_administrateur
): bool {
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $updatePrestataireQuery = $databaseConnection->prepare("
        UPDATE prestataire
        SET refuse_par_admin = :refuse_par_admin,
            raison_refuse = :raison_refuse,
            nom = :nom,
            prenom = :prenom,
            email = :email,
            mot_passe = :mot_passe,
            id_administrateur = :id_administrateur
        WHERE id_prestataire = :id_prestataire;
    ");

    return $updatePrestataireQuery->execute([
        "id_prestataire" => $id_prestataire,
        "refuse_par_admin" => $refuse_par_admin,
        "raison_refuse" => $raison_refuse,
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "mot_passe" => $mot_passe,
        "id_administrateur" => $id_administrateur
    ]);
}
