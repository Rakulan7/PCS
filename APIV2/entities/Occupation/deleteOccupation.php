<?php

function deleteReservation(string $id): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getReservationQuery = $databaseConnection->prepare("SELECT * FROM Reservation WHERE id = :id;");

    $getReservationQuery->execute([
        "id" => $id
    ]);

    $Reservation = $getReservationQuery->fetch(PDO::FETCH_ASSOC);

    if (!$Reservation) {
        return false;
    }

    $deleteReservationQuery = $databaseConnection->prepare("DELETE FROM Reservation WHERE id = :id;");

    $success = $deleteReservationQuery->execute([
        "id" => $id
    ]);

    return $success;
}
