<?php

function getReservation(string $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getReservationQuery = $databaseConnection->prepare("SELECT * FROM Reservation WHERE id = :id;");

    $getReservationQuery->execute([
        "id" => $id
    ]);

    $Reservation = $getReservationQuery->fetch(PDO::FETCH_ASSOC);

    return $Reservation;
}
