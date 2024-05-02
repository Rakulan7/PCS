<?php

include("../include/utils.php");
checkSessionElseLogin("");

include("../log.php");

$db = getDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["userId"]) && !empty($_POST["userId"]) &&
        isset($_POST["editUsername"]) && !empty($_POST["editUsername"]) &&
        isset($_POST["editEmail"]) && !empty($_POST["editEmail"]) &&
        isset($_POST["editFonction"]) && !empty($_POST["editFonction"])
    ) {

        $id = $_POST["userId"];
        $username = $_POST["editUsername"];
        $email = $_POST["editEmail"];
        $fonction = $_POST["editFonction"];
        $password = isset($_POST["editPassword"]) ? $_POST["editPassword"] : '';
        $confirmPassword = isset($_POST["editConfirmPassword"]) ? $_POST["editConfirmPassword"] : '';

        // Vérification que les mots de passe correspondent
        if ($password !== $confirmPassword) {
            logActivity("../", "Erreur lors de la modification de l'administrateur : les mots de passe ne correspondent pas.");
            header("location: ../administrateur.php?msg=Erreur lors de la modification de l'administrateur : les mots de passe ne correspondent pas.&err=true");
            exit();
        }

        // Vérification du format du mot de passe (à adapter selon vos critères)
        if (!empty($password) && strlen($password) < 8) {
            logActivity("../", "Erreur lors de la modification de l'administrateur : le mot de passe est trop court (minimum 8 caractères).");
            header("location: ../administrateur.php?msg=Erreur lors de la modification de l'administrateur : le mot de passe est trop court (minimum 8 caractères).&err=true");
            exit();
        }

        // Hashage du mot de passe s'il est renseigné
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        }

        // Mise à jour des informations de l'administrateur
        $query = "UPDATE administrateur SET username = :username, email = :email, fonction = :fonction";
        
        // Ajout du changement de mot de passe uniquement s'il a été renseigné
        if (!empty($password)) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id_administrateur = :id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":fonction", $fonction);

        // Ajout du paramètre du mot de passe uniquement s'il a été renseigné
        if (!empty($password)) {
            $stmt->bindParam(":password", $hashedPassword);
        }

        if ($stmt->execute()) {
            logActivity("../", "Les informations de l'administrateur $username ont été modifiées.");
            header("location: ../administrateur.php?msg=Les informations de l'administrateur $username ont été modifiées.&err=false");
            exit();
        } else {
            logActivity("../", "Erreur lors de la modification des informations de l'administrateur $username.");
            header("location: ../administrateur.php?msg=Erreur lors de la modification des informations de l'administrateur $username.&err=true");
            exit();
        }

    }
}
?>
