<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page bailleurs_status.php");

$db = getDatabase();

$getBailleurAll = $db->prepare("SELECT * FROM bailleur");
$getBailleurAll->execute([]);
$bailleurAll = $getBailleurAll->fetchAll(PDO::FETCH_ASSOC);

$getBailleurAccept = $db->prepare("SELECT * FROM bailleur WHERE accepte = 1");
$getBailleurAccept->execute([]);
$bailleurAccept = $getBailleurAccept->fetchAll(PDO::FETCH_ASSOC);

$getBailleurWaiting = $db->prepare("SELECT * FROM bailleur WHERE (accepte is NULL AND refusee is NULL) OR  (accepte = 0 AND refusee = 0)");
$getBailleurWaiting->execute([]);
$bailleurWaiting = $getBailleurWaiting->fetchAll(PDO::FETCH_ASSOC);

$getBailleurRefuses = $db->prepare("SELECT * FROM bailleur WHERE refusee = 1");
$getBailleurRefuses->execute([]);
$bailleurRefuses = $getBailleurRefuses->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bailleurs status</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <div class="d-flex justify-content-center mt-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" id="all-tab" data-bs-toggle="tab" href="#all">Tout les bailleurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="acceptes-tab" data-bs-toggle="tab" href="#acceptes">Acceptés</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="attente-tab" data-bs-toggle="tab" href="#attente">En attente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="refuses-tab" data-bs-toggle="tab" href="#refuses">Refusés</a>
            </li>
        </ul>
    </div>


    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all">
                        <div class="search-bar mb-4">
                            <input type="text" id="searchInputAll" class="form-control" placeholder="Rechercher...">
                        </div>
                        <h2>Tout les bailleurs</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurAll as $bailleur) {
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_bailleur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="acceptes">
                        <div class="search-bar mb-4">
                            <input type="text" id="searchInputAcceptes" class="form-control" placeholder="Rechercher...">
                        </div>
                        <h2>Bailleurs acceptés</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurAccept as $bailleur) {
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_bailleur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="attente">
                    <div class="search-bar mb-4">
                        <input type="text" id="searchInputAttente" class="form-control" placeholder="Rechercher...">
                    </div>
                    <h2>Bailleurs en attente</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurWaiting as $bailleur) {
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_bailleur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="refuses">
                        <div class="search-bar mb-4">
                            <input type="text" id="searchInputRefuses" class="form-control" placeholder="Rechercher...">
                        </div>
                        <h2>Bailleurs refusés</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurRefuses as $bailleur) {
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_bailleur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // Fonction de recherche en temps réel
            $('#searchInputAll, #searchInputAcceptes, #searchInputAttente, #searchInputRefuses').on('input', function() {
                var searchText = $(this).val().toLowerCase(); // Convertir le texte en minuscules
                var tableBody = $(this).closest('.tab-pane').find('tbody'); // Trouver le corps du tableau à l'intérieur de la même tab-pane

                // Effectuer une requête AJAX vers le script PHP pour obtenir les résultats filtrés
                $.ajax({
                    url: 'process/search.php',
                    method: 'GET',
                    data: { searchTerm: searchText },
                    dataType: 'json',
                    success: function(data) {
                        // Effacer le contenu du tableau
                        tableBody.empty();

                        // Parcourir les résultats et les ajouter au tableau
                        data.forEach(function(bailleur) {
                            var row = '<tr>';
                            row += '<td>' + bailleur['nom'] + '</td>';
                            row += '<td>' + bailleur['prenom'] + '</td>';
                            row += '<td>' + bailleur['email'] + '</td>';
                            row += '<td>' + bailleur['pays_telephone'] + '</td>';
                            row += '<td>' + bailleur['numero_telephone'] + '</td>';
                            row += '<td><a href="bdetails.php?id=' + bailleur['id_bailleur'] + '" class="btn btn-primary">Détails</a></td>';
                            row += '</tr>';
                            tableBody.append(row);
                        });
                    }
                });
            });
        });

    </script>

</body>
</html>
