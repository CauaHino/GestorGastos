<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Encriptar la contraseña (IMPORTANTE)
    $password_segura = password_hash($password, PASSWORD_DEFAULT);

    try {
        // 2. Insertar en la base de datos
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre, $email, $password_segura]);

        echo "✅ Usuario creado con éxito. <a href='login.php'>Ir al Login</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Error de duplicado (email ya existe)
            echo "❌ El correo ya está registrado.";
        } else {
            echo "❌ Error: " . $e->getMessage();
        }
    }
}
?>