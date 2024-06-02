<?php

function getBien(string $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getBienQuery = $databaseConnection->prepare("SELECT * FROM Bien WHERE id = :id;");

    $getBienQuery->execute([
        "id" => $id
    ]);

    $Bien = $getBienQuery->fetch(PDO::FETCH_ASSOC);

    return $Bien;
}
