<?php
// Fonction pour enregistrer les journaux d'activité


function getIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function logActivity($path,  $action, $user_id = null) {
    // Vous pouvez personnaliser cette fonction pour enregistrer les journaux dans votre base de données ou dans un fichier de journal
    date_default_timezone_set('Europe/Paris');
    $timestamp = date("Y/m/d H:i:s");

    if (isset($user) && !empty($user)) {
        $user = '_'.$user_id;
        $id = $user_id;
    } elseif (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
        $user = '_'.$_SESSION['admin_id'];
        $id = $_SESSION["admin_id"];
    } else {
        $user = '';
    }

    $ip_address = getIPAddress();
    $log = "$ip_address - $timestamp - $id - $action\n";
    file_put_contents($path .'logs/activity_log'. $user .'.txt', $log, FILE_APPEND);
}