<?php
include("../include/utils.php");
checkSessionElseLogin("");

include("../log.php");

if(isset($_POST["id"])) {
    $prestataire_id = htmlspecialchars($_POST["id"]);
    $reason = htmlspecialchars($_POST["reason"]);

    $db = getDatabase();

    $updatePrestataire = $db->prepare("UPDATE prestataire SET refuse_par_admin = 1, accepte = 0, raison_refuse = ? WHERE id_prestataire = ?");
    $updatePrestataire->execute([$reason, $prestataire_id]);

    logActivity("../", "Prestataire ". $prestataire_id ." refusé avec succès");
    header("Location: ../pdetails.php?id=". $prestataire_id ."&msg=Prestataire refusé avec succès.&err=false");
    exit;
} else {
    logActivity("../", "Erreur lors du refus d'un prestataire");
    header("Location: ../prestataires.php?msg=Une erreur s'est produite process.&err=true");
    exit;
}
?>
