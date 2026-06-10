<?php
require '../db.php';
session_start(); // ¡Importante! Inicia el sistema de sesiones

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Contraseña correcta: Guardamos datos en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        
        header("Location: ../index.php"); // Nos vamos al gestor
        exit();
    } else {
        echo "Email o contraseña incorrectos.";
    }
}
?>