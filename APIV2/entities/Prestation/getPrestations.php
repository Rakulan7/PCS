<?php

function getServices()
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getServicesQuery = $databaseConnection->query("SELECT * FROM Service;");

    $Services = $getServicesQuery->fetchAll(PDO::FETCH_ASSOC);

    return $Services;
}
