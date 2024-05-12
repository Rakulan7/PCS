<?php
include("include/utils.php");
checkSessionElseLogin("");

$db = getDatabase();

// Récupère le terme de recherche depuis la requête GET
$searchTerm = $_GET['searchTerm'] ?? '';

// Requête SQL pour récupérer les bailleurs filtrés
$query = "SELECT * FROM bailleur WHERE nom LIKE ? OR prenom LIKE ? OR email LIKE ? OR pays_telephone LIKE ? OR numero_telephone LIKE ?";
$stmt = $db->prepare($query);
$stmt->execute(["%$searchTerm%", "%$searchTerm%", "%$searchTerm%", "%$searchTerm%", "%$searchTerm%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourne les résultats au format JSON
echo json_encode($results);