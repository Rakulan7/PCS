<?php

require __DIR__ . '/../../database/config.php';


function createBien($data) {
    global $pdo;
    $sql = "INSERT INTO bien (title, description, address, city, code_postal, pays, prix, salon, cuisine, salle_de_bain, toilette, chambre, superficie, creation, maj, raison_refus, id_utilisateur, id_utilisateur_1)
            VALUES (:title, :description, :address, :city, :code_postal, :pays, :prix, :salon, :cuisine, :salle_de_bain, :toilette, :chambre, :superficie, :creation, :maj, :raison_refus, :id_utilisateur, :id_utilisateur_1)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}


function getBien($id) {
    global $pdo;
    $sql = "SELECT * FROM bien WHERE id_bien = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllBiens() {
    global $pdo;
    $sql = "SELECT * FROM bien";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function updateBien($id, $data) {
    global $pdo;
    $data['id'] = $id;
    $sql = "UPDATE bien SET title = :title, description = :description, address = :address, city = :city, code_postal = :code_postal, pays = :pays, prix = :prix, salon = :salon, cuisine = :cuisine, salle_de_bain = :salle_de_bain, toilette = :toilette, chambre = :chambre, superficie = :superficie, creation = :creation, maj = :maj, raison_refus = :raison_refus, id_utilisateur = :id_utilisateur, id_utilisateur_1 = :id_utilisateur_1 WHERE id_bien = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}


function deleteBien($id) {
    global $pdo;
    $sql = "DELETE FROM bien WHERE id_bien = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

?>