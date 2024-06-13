<?php
require '../database/config.php';
require 'token_functions.php'; // Le fichier où vous avez défini generateToken

function login($email, $password, $pdo) {
    $stmt = $pdo->prepare('SELECT id_utilisateur, mot_de_passe FROM utilisateur WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        return generateToken($user['id_utilisateur'], $pdo);
    } else {
        return null;
    }
}

$email = $_POST['email'];
$password = $_POST['password'];
$token = login($email, $password, $pdo);

if ($token) {
    echo json_encode(['token' => $token]);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid credentials']);
}
?>
