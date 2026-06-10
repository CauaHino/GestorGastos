<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Si no hay sesión, al login
    exit();
}
?>

<?php
require 'db.php';
// Definimos la variable para usarla en todas las consultas
$user_id = $_SESSION['user_id'];

// 1. Suma Total (Corregido para usar sentencias preparadas y evitar inyecciones SQL)
$sqlSuma = "SELECT SUM(monto) AS total_gastos FROM gastos WHERE usuario_id = ?";
$stmtSuma = $conn->prepare($sqlSuma);
$stmtSuma->execute([$user_id]);
$totalGastos = $stmtSuma->fetch(PDO::FETCH_ASSOC)['total_gastos'] ?? 0;

// 2. Datos para el Gráfico (Agrupando por CATEGORÍA para que sea un relatorio real)
$sqlGrafico = "SELECT c.nombre, SUM(g.monto) as total_cat 
               FROM gastos g
               JOIN categorias c ON g.categoria_id = c.id
               WHERE g.usuario_id = ? 
               GROUP BY c.nombre";
$stmtGrafico = $conn->prepare($sqlGrafico);
$stmtGrafico->execute([$user_id]);
$datosGrafico = $stmtGrafico->fetchAll(PDO::FETCH_ASSOC);

// 3. Lista de gastos con el nombre de la categoría
$sql = "SELECT g.*, c.nombre AS cat_nombre 
        FROM gastos g 
        JOIN categorias c ON g.categoria_id = c.id 
        WHERE g.usuario_id = ? 
        ORDER BY g.fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 Resumen</h2>
        <a href="index.php" class="btn btn-outline-primary">+ Añadir</a>
    </div>

    <div class="card bg-primary text-white mb-4 shadow">
        <div class="card-body text-center">
            <h5 class="card-title">Gasto Total</h5>
            <h1 class="display-4">$<?php echo number_format($totalGastos, 2); ?></h1>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title text-center">Distribución de Gastos</h5>
        <canvas id="graficoGastos" style="max-height: 250px;"></canvas>
    </div>
</div>

    <div class="list-group shadow-sm">
        <?php foreach ($gastos as $gasto): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong><?php echo htmlspecialchars($gasto['descripcion']); ?></strong>
                    <br>
                    <small class="text-muted"><?php echo $gasto['fecha']; ?></small>
                </div>
                <span class="badge bg-danger rounded-pill fs-6">
                    -$<?php echo number_format($gasto['monto'], 2); ?>
                </span>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($gastos)): ?>
            <div class="list-group-item text-center py-4">No hay gastos registrados aún.</div>
        <?php endif; ?>
    </div>
</div>
<script>
const ctx = document.getElementById('graficoGastos');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        // Ahora usamos 'nombre' de la categoría en lugar de descripción
        labels: <?php echo json_encode(array_column($datosGrafico, 'nombre')); ?>,
        datasets: [{
            data: <?php echo json_encode(array_column($datosGrafico, 'total_cat')); ?>,
            backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6610f2', '#fd7e14', '#0dcaf0'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

</body>
</html>
