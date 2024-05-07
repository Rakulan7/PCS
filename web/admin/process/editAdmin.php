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
        $password = $_POST["editPassword"];

        $query = "SELECT COUNT(*) FROM administrateur WHERE email = :email AND id_administrateur != :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            logActivity("../", "Erreur lors de la modification de l'administrateur $username. L'adresse mail existe déjà pour un autre administrateur.");
            header("location: ../administrateur.php?msg=L'adresse e-mail existe déjà pour un autre administrateur.&err=true");
            exit();
        }

        $query = "UPDATE administrateur SET username = :username, email = :email, fonction = :fonction";

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query .= ", password = :password";
        }

        $query .= " WHERE id_administrateur = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":fonction", $fonction);
        
        if (!empty($password)) {
            $stmt->bindParam(":password", $hashedPassword);
        }

        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            logActivity("../", "L'administrateur $username a été modifié.");
            header("location: ../administrateur.php?msg=L'administrateur $username a été modifié avec succès.&err=false");
            exit();
        } else {
            logActivity("../", "Erreur lors de la modification de l'administrateur $username.");
            header("location: ../administrateur.php?msg=Erreur lors de la modification de l'administrateur $username.&err=true");
            exit();
        }
    }
}