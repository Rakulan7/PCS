<?php

function updateBien(
    int $id_bien,
    bool $refuse_par_admin,
    string $raison_refuse,
    int $numero_rue,
    string $type_rue,
    string $rue,
    string $ville,
    int $code_postal,
    string $pays,
    string $titre,
    string $description,
    int $nombre_chambre,
    int $nombre_salle_de_bain,
    int $nombre_toilette,
    float $prix,
    float $taille,
    int $id_administrateur,
    int $id_bailleur
): bool {
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $updateBienQuery = $databaseConnection->prepare("
        UPDATE bien
        SET refuse_par_admin = :refuse_par_admin,
            raison_refuse = :raison_refuse,
            numero_rue = :numero_rue,
            type_rue = :type_rue,
            rue = :rue,
            ville = :ville,
            code_postal = :code_postal,
            pays = :pays,
            titre = :titre,
            description = :description,
            nombre_chambre = :nombre_chambre,
            nombre_salle_de_bain = :nombre_salle_de_bain,
            nombre_toilette = :nombre_toilette,
            prix = :prix,
            taille = :taille,
            id_administrateur = :id_administrateur,
            id_bailleur = :id_bailleur
        WHERE id_bien = :id_bien;
    ");

    return $updateBienQuery->execute([
        "id_bien" => $id_bien,
        "refuse_par_admin" => $refuse_par_admin,
        "raison_refuse" => $raison_refuse,
        "numero_rue" => $numero_rue,
        "type_rue" => $type_rue,
        "rue" => $rue,
        "ville" => $ville,
        "code_postal" => $code_postal,
        "pays" => $pays,
        "titre" => $titre,
        "description" => $description,
        "nombre_chambre" => $nombre_chambre,
        "nombre_salle_de_bain" => $nombre_salle_de_bain,
        "nombre_toilette" => $nombre_toilette,
        "prix" => $prix,
        "taille" => $taille,
        "id_administrateur" => $id_administrateur,
        "id_bailleur" => $id_bailleur
    ]);
}
