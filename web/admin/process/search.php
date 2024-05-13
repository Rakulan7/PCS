<?php

include("../include/utils.php");
checkSessionElseLogin("../");

// Récupérer le terme de recherche depuis la requête GET
if(isset($_GET['q'])) {
    $searchTerm = $_GET['q'];

    // Connexion à la base de données
    $db = getDatabase(); // Assurez-vous que cette fonction est définie dans votre fichier de connexion à la base de données

    // Préparer la requête SQL pour rechercher dans votre base de données
    $query = "SELECT * FROM bailleur WHERE prenom LIKE :searchTerm OR nom LIKE :searchTerm OR email LIKE :searchTerm OR numero_telephone LIKE :searchTerm OR pays_telephone LIKE :searchTerm";
    $stmt = $db->prepare($query);

    // Exécuter la requête en liant le paramètre de recherche
    $stmt->execute(array(':searchTerm' => '%' . $searchTerm . '%'));

    // Récupérer les résultats de la requête
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Répondre avec les résultats au format JSON
    header('Content-Type: application/json');
    echo json_encode($results);
} else {
    // Répondre avec un message d'erreur si aucun terme de recherche n'est fourni
    echo 'Aucun terme de recherche spécifié';
}