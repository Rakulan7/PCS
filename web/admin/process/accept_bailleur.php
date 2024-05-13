<?php
include("../include/utils.php");
checkSessionElseLogin("../");


include("../log.php");
logActivity("../", "page refuse bailleur de " . $_POST["id"]);

echo $bailleur_id;



var_dump($bailleur);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $bailleur_id = htmlspecialchars($_POST["id"]);

    $db = getDatabase();

    $getBailleur = $db->prepare("UPDATE bailleur SET accepte = 1, refusee = 0 WHERE id_bailleur = ?");
    $getBailleur->execute([$bailleur_id]);
    $rowsAffected = $getBailleur->rowCount();

    if ($rowsAffected > 0) {
        logActivity("../", "Bailleur id ". $bailleur_id ." a été accepté.");
        header("location: ../bdetails.php?id=". $bailleur_id ."&msg=Bailleur id ". $bailleur_id ." a bien été accepté !&err=false");
    } else {
        logActivity("../", "Bailleur id ". $bailleur_id ." n'a pas été accepté.");
        header("location: ../bailleurs_status.php?msg=Bailleur id ". $bailleur_id ." n'a pas été accepté !&err=true");
    }

} else {
    logActivity("../", "Une erreur est survenue, traitement annulé.");
    header("location: ../bailleurs_status.php?msg=Une erreur est survenue, traitement annulé.&err=true");
}