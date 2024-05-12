<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page refuse bailleur de " . $_POST["id"]);

$bailleur_id = htmlspecialchars($_POST["id"]);

$db = getDatabase();

$getBailleur = $db->prepare("SELECT * FROM bailleur WHERE id_bailleur = ?");
$getBailleur->execute([$bailleur_id]);
$bailleur = $getBailleur->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refus bailleur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <?= $_POST["id"] ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
