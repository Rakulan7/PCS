<?php

function createVoyageur(
    string $nom,
    string $prenom,
    string $email,
    string $mot_passe,
    string $date_inscription,
    string $date_naissance,
    string $numero_telephone,
    string $pays_telephone,
    bool $bloque,
    string $supprime = null
): bool {
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createVoyageurQuery = $databaseConnection->prepare("
        INSERT INTO voyageur(
            nom, prenom, email, mot_passe, date_inscription, date_naissance, numero_telephone, pays_telephone, bloque, supprime
        ) VALUES (
            :nom, :prenom, :email, :mot_passe, :date_inscription, :date_naissance, :numero_telephone, :pays_telephone, :bloque, :supprime
        );
    ");

    return $createVoyageurQuery->execute([
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "mot_passe" => $mot_passe,
        "date_inscription" => $date_inscription,
        "date_naissance" => $date_naissance,
        "numero_telephone" => $numero_telephone,
        "pays_telephone" => $pays_telephone,
        "bloque" => $bloque,
        "supprime" => $supprime
    ]);
}
