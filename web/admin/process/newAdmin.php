<?php

include("../include/utils.php");
checkSessionElseLogin("");

include("../log.php");

$db = getDatabase();

date_default_timezone_set('Europe/Paris');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["nomUtilisateur"], $_POST["emailUtilisateur"], $_POST["fonctionUtilisateur"], $_POST["passwordUtilisateur"], $_POST["passwordUtilisateurCheck"])
    && !empty($_POST["nomUtilisateur"]) && !empty($_POST["emailUtilisateur"]) && !empty($_POST["passwordUtilisateur"]) && !empty($_POST["passwordUtilisateurCheck"])) {

        $nomUtilisateur = $_POST["nomUtilisateur"];
        $emailUtilisateur = $_POST["emailUtilisateur"];
        $fonctionUtilisateur = $_POST["fonctionUtilisateur"];
        $passwordUtilisateur = $_POST["passwordUtilisateur"];
        $passwordUtilisateurCheck = $_POST["passwordUtilisateurCheck"];

        if (!filter_var($emailUtilisateur, FILTER_VALIDATE_EMAIL)) {
            logActivity("../", "Erreur lors de la création d'un administrateur l'adresse email n'est pas valide.");
            header("location: ../administrateur.php?msg=L'adresse email n'est pas valide. L'administrateur n'a pas été créé.&err=true");
            exit();
        }

        if ($passwordUtilisateur !== $passwordUtilisateurCheck) {
            logActivity("../", "Erreur lors de la création d'un administrateur les mots de passe ne correspondent pas.");
            header("location: ../administrateur.php?msg=Les mots de passe ne correspondent pas. L'administrateur n'a pas été créé.&err=true");
            exit();
        }

        $query = "SELECT * FROM administrateur WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":email", $emailUtilisateur);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            logActivity("../", "Erreur lors de la création d'un administrateur l'email est déjà utilisé par un autre utilisateur.");
            header("location: ../administrateur.php?msg=Cet email est déjà utilisé par un autre utilisateur. L'administrateur n'a pas été créé.&err=true");
            exit();
        }

        $date = date("Y/m/d H:i:s");

        $insertQuery = "INSERT INTO administrateur (username, email, fonction, password, creationDate, adminCreate) VALUES (:nom, :email, :fonction, :mot_de_passe, :creationDate, :createur)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->bindParam(":nom", $nomUtilisateur);
        $insertStmt->bindParam(":email", $emailUtilisateur);
        $insertStmt->bindParam(":fonction", $fonctionUtilisateur);
        $hashedPassword = password_hash($passwordUtilisateur, PASSWORD_BCRYPT);
        $insertStmt->bindParam(":mot_de_passe", $hashedPassword);
        $insertStmt->bindParam(":creationDate", $date);
        $insertStmt->bindParam(":createur", $_SESSION["admin_id"]);

        if ($insertStmt->execute()) {
            logActivity("../", "L'administrateur ". $nomUtilisateur ." a été créé avec succès.");
            header("location: ../administrateur.php?msg=L'administrateur a été créé avec succès.&err=false");
            exit();
        } else {
            echo "Une erreur est survenue lors de la création de l'administrateur.";
            logActivity("../", "Une erreur est survenue lors de la création de l'administrateur.");
            header("location: ../administrateur.php?msg=Une erreur est survenue lors de la création de l'administrateur.&err=true");
            exit();
        }

    } else {
        logActivity("../", "Erreur lors de la création d'un administrateur tout les champs n'ont pas été remplit.");
        header("location: ../administrateur.php?msg=Veuillez remplir tous les champs du formulaire. L'administrateur n'a pas été créé.&err=true");
        exit();
    }
} else {
    logActivity("../", "Méthode de requête incorrecte. L'adminsitrateur n'a pas été créer.");
    header("location: ../administrateur.php?msg=Méthode de requête incorrecte.&err=true");
    exit();
}
