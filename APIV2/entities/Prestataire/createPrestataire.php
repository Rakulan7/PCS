<?php

function createPrestataire(
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

    $createPrestataireQuery = $databaseConnection->prepare("
        INSERT INTO prestataire(
            refuse_par_admin, raison_refuse, nom, prenom, email, mot_passe, id_administrateur
        ) VALUES (
            :refuse_par_admin, :raison_refuse, :nom, :prenom, :email, :mot_passe, :id_administrateur
        );
    ");

    return $createPrestataireQuery->execute([
        "refuse_par_admin" => $refuse_par_admin,
        "raison_refuse" => $raison_refuse,
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "mot_passe" => $mot_passe,
        "id_administrateur" => $id_administrateur
    ]);
}
