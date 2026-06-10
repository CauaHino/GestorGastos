<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $cat_id  = $_POST['categoria_id'];
    $monto   = $_POST['monto'];
    $desc    = $_POST['descripcion'];
    $fecha   = $_POST['fecha'];

    try {
       $sql = "INSERT INTO gastos (usuario_id, categoria_id, monto, descripcion, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id, $cat_id, $monto, $desc, $fecha]);

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al guardar el gasto: " . $e->getMessage();
    }
}
?>