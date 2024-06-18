<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

// Connexion à la base de données
$db = getDatabase();

$nfc_id = htmlspecialchars($_GET["id"]);
$id_bien = isset($_GET['id_bien']) ? htmlspecialchars($_GET['id_bien']) : '';
$log_date_time = isset($_GET['log_date_time']) ? htmlspecialchars($_GET['log_date_time']) : '';

try {
    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $db->prepare("SELECT * FROM utilisateur WHERE nfc_id = :nfc_id");
    $stmt->bindParam(':nfc_id', $nfc_id, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Construire la requête SQL pour les logs avec filtres
    $log_query = "SELECT * FROM nfc_log WHERE nfc_id = :nfc_id";
    if (!empty($id_bien)) {
        $log_query .= " AND id_bien = :id_bien";
    }
    if (!empty($log_date_time)) {
        $log_query .= " AND log_date_time LIKE :log_date_time";
        $log_date_time .= '%'; // Pour permettre la recherche par date ou par heure partielle
    }
    $log_query .= " ORDER BY log_date_time DESC";

    // Préparer la requête SQL pour récupérer les logs
    $log_stmt = $db->prepare($log_query);
    $log_stmt->bindParam(':nfc_id', $nfc_id, PDO::PARAM_STR);
    if (!empty($id_bien)) {
        $log_stmt->bindParam(':id_bien', $id_bien, PDO::PARAM_INT);
    }
    if (!empty($log_date_time)) {
        $log_stmt->bindParam(':log_date_time', $log_date_time, PDO::PARAM_STR);
    }
    $log_stmt->execute();
    $logs = $log_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du tag NFC</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Informations du tag NFC</h1>
        <p>Voici l'ID du tag NFC reçu : <strong><?php echo $nfc_id; ?></strong></p>
        
        <?php
        if ($user) {
            echo "<p>Appartient à : <a href='bdetails.php?id=". $user["id_utilisateur"] ."'><strong>" . htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['nom']) . "</strong></a></p>";
        } else {
            echo "<p>Aucun utilisateur trouvé pour cet ID NFC.</p>";
        }
        ?>

        <h2>Logs associés</h2>
        
        <form method="GET" class="mb-4">
            <input type="hidden" name="id" value="<?php echo $nfc_id; ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_bien">ID Bien</label>
                    <input type="text" class="form-control" id="id_bien" name="id_bien" value="<?php echo $id_bien; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="log_date_time">Date/Heure</label>
                    <input type="text" class="form-control datepicker" id="log_date_time" name="log_date_time" value="<?php echo $log_date_time; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <?php if ($logs): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Log</th>
                        <th>Date et Heure</th>
                        <th>ID Bien</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['id_log']); ?></td>
                            <td><?php echo htmlspecialchars($log['log_date_time']); ?></td>
                            <td><a href="bien.php?id=<?= $log['id_bien'] ?>"><?php echo htmlspecialchars($log['id_bien']); ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun log trouvé pour cet ID NFC.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
</body>
</html>
