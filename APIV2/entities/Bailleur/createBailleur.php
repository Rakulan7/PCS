<?php

function createBailleur(
    string $nom,
    string $prenom,
    string $email,
    string $mot_passe,
    string $date_inscription,
    string $date_naissance,
    string $numero_telephone,
    string $pays_telephone,
    bool $bloque,
    string $supprime,
    int $code_banque,
    int $code_guichet,
    int $numero_compte,
    int $cle_rib,
    int $iban,
    string $bic_swift,
    string $url_rib
): bool {
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createBailleurQuery = $databaseConnection->prepare("
        INSERT INTO bailleur(
            nom, prenom, email, mot_passe, date_inscription, date_naissance, numero_telephone, pays_telephone,
            bloque, supprime, code_banque, code_guichet, numero_compte, cle_rib, iban, bic_swift, url_rib
        ) VALUES (
            :nom, :prenom, :email, :mot_passe, :date_inscription, :date_naissance, :numero_telephone, :pays_telephone,
            :bloque, :supprime, :code_banque, :code_guichet, :numero_compte, :cle_rib, :iban, :bic_swift, :url_rib
        );
    ");

    return $createBailleurQuery->execute([
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "mot_passe" => $mot_passe,
        "date_inscription" => $date_inscription,
        "date_naissance" => $date_naissance,
        "numero_telephone" => $numero_telephone,
        "pays_telephone" => $pays_telephone,
        "bloque" => $bloque,
        "supprime" => $supprime,
        "code_banque" => $code_banque,
        "code_guichet" => $code_guichet,
        "numero_compte" => $numero_compte,
        "cle_rib" => $cle_rib,
        "iban" => $iban,
        "bic_swift" => $bic_swift,
        "url_rib" => $url_rib
    ]);
}