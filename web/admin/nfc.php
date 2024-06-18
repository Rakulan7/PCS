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
        <p>Voici l'ID du tag NFC reçu : <strong><?php echo htmlspecialchars($nfc_id); ?></strong></p>
        
        <?php
        if ($user) {
            echo "<p>Appartient à : <a href='bdetails.php?id=". htmlspecialchars($user["id_utilisateur"]) ."'><strong>" . htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['nom']) . "</strong></a></p>";
        } else {
            echo "<p>Aucun utilisateur trouvé pour cet ID NFC.</p>";
        }
        ?>

        <h2>Logs associés</h2>
        
        <form id="filterForm" method="GET" class="mb-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($nfc_id); ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_bien">ID Bien</label>
                    <input type="text" class="form-control" id="id_bien" name="id_bien" value="<?php echo htmlspecialchars($id_bien); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="log_date_time">Date/Heure</label>
                    <input type="text" class="form-control datepicker" id="log_date_time" name="log_date_time" value="<?php echo htmlspecialchars($log_date_time); ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <div id="logsTable">
            <?php include 'ajax_refresh_logs.php'; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function(){
            // Initialiser le datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            // Fonction pour rafraîchir les logs toutes les 5 secondes
            function refreshLogs() {
                var formData = $('#filterForm').serialize(); // Sérialiser les données du formulaire

                // Effectuer la requête AJAX
                $.ajax({
                    type: 'GET',
                    url: 'ajax_refresh_logs.php', // L'URL où envoyer la requête AJAX
                    data: formData, // Les données à envoyer, sérialisées
                    success: function(response) {
                        $('#logsTable').html(response); // Mettre à jour le contenu des logs
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la requête AJAX : ' + status + ', ' + error);
                    },
                    complete: function() {
                        // Lancer la prochaine requête après 5 secondes
                        setTimeout(refreshLogs, 1000); // 1000 millisecondes = 1 seconde
                    }
                });
            }

            // Démarrer la première mise à jour des logs
            refreshLogs();
        });
    </script>
</body>
</html>
