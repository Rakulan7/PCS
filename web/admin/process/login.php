<?php

include("../include/utils.php");
include("../log.php");

date_default_timezone_set('Europe/Paris');

if (!isset($_POST["email"]) || !isset($_POST["password"])
    || empty($_POST["email"]) || empty($_POST["password"])) {
    header("location: ../login.php?msg=Veuillez remplire tout les champs.&err=true");
    exit;
}

$db = getDatabase();
$select = $db->prepare("SELECT * FROM administrateur WHERE email = :email");
$select->execute([
    "email" => $_POST["email"]
]);

$resultat = $select->fetch(PDO::FETCH_ASSOC);
var_dump($resultat);

if (!$resultat) {
    logActivity("../", "Tentative de connexion vers l'addresse mail : " . $_POST["email"]);
    header("location: ../login.php?msg=Identifiants incorrects&err=true");
    exit;
}

if (password_verify($_POST["password"], $resultat["password"])) {
    
    $temps_cookie = 14400;
    setcookie("temps", time(), time() + $temps_cookie, "/");

    session_start();
    $_SESSION["admin_email"] = $resultat["email"];
    $_SESSION["admin_id"] = $resultat["id_administrateur"];
    logActivity("../", "Connexion réussie");
    header("location: ../index.php");
    exit;


} else {
    logActivity("../", "Connexion réussie", $resultat["administrateur_id"]);
    header("location: ../login.php?msg=Identifiants incorrects&err=true");
    exit;
}