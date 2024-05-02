<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    canvas {
      margin: 20px;
    }
  </style>
</head>
<body>

<div class="container mt-5 mb-5">
  <h2 class="mb-4">Tableau de bord</h2>

  <div class="d-none d-md-block">
    <div class="row row-cols-md-2">
      <div class="col">
        <a href="bailleurs_valides.php">
          <canvas id="bailleursChart" width="400" height="300"></canvas>
        </a>
      </div>
      <div class="col">
        <a href="biens_valides.php">
          <canvas id="biensChart" width="400" height="300"></canvas>
        </a>
      </div>
      <div class="col">
        <a href="voyageurs_valides.php">
          <canvas id="voyageursChart" width="400" height="300"></canvas>
        </a>
      </div>
      <div class="col">
        <a href="prestataires_valides.php">
          <canvas id="prestatairesChart" width="400" height="300"></canvas>
        </a>
      </div>
    </div>
  </div>

  <div class="d-md-none">
    <p class="text-center">Les graphiques ne sont pas disponibles sur les téléphones.</p>
  </div>

</div>

<script>
  // Données pour les graphiques
  const bailleursData = {
    labels: ['Validés', 'En attente', 'Refusés'],
    datasets: [{
      label: 'Bailleurs',
      data: [15, 3, 2],
      backgroundColor: [
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 206, 86, 0.2)',
      ],
      borderColor: [
        'rgba(54, 162, 235, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(255, 206, 86, 1)',
      ],
      borderWidth: 1
    }]
  };

  const biensData = {
    labels: ['Validés', 'En attente', 'Refusés'],
    datasets: [{
      label: 'Biens',
      data: [25, 5, 1],
      backgroundColor: [
        'rgba(75, 192, 192, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(153, 102, 255, 0.2)',
      ],
      borderColor: [
        'rgba(75, 192, 192, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(153, 102, 255, 1)',
      ],
      borderWidth: 1
    }]
  };

  const voyageursData = {
    labels: ['Validés', 'En attente', 'Refusés'],
    datasets: [{
      label: 'Voyageurs',
      data: [50, 10, 3],
      backgroundColor: [
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(255, 99, 132, 0.2)',
      ],
      borderColor: [
        'rgba(255, 205, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(255, 99, 132, 1)',
      ],
      borderWidth: 1
    }]
  };

  const prestatairesData = {
    labels: ['Validés', 'En attente', 'Refusés'],
    datasets: [{
      label: 'Prestataires',
      data: [30, 5, 2],
      backgroundColor: [
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(75, 192, 192, 0.2)',
      ],
      borderColor: [
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(75, 192, 192, 1)',
      ],
      borderWidth: 1
    }]
  };

  // Configuration des options de graphique
  const options = {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  };

  // Création des graphiques
  var bailleursChart = new Chart(document.getElementById('bailleursChart'), {
    type: 'bar',
    data: bailleursData,
    options: options
  });

  var biensChart = new Chart(document.getElementById('biensChart'), {
    type: 'bar',
    data: biensData,
    options: options
  });

  var voyageursChart = new Chart(document.getElementById('voyageursChart'), {
    type: 'bar',
    data: voyageursData,
    options: options
  });

  var prestatairesChart = new Chart(document.getElementById('prestatairesChart'), {
    type: 'bar',
    data: prestatairesData,
    options: options
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
