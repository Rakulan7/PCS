<?php

function getReservations()
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getReservationsQuery = $databaseConnection->query("SELECT * FROM Reservation;");

    $Reservations = $getReservationsQuery->fetchAll(PDO::FETCH_ASSOC);

    return $Reservations;
}
