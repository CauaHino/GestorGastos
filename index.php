<?php
session_start();
// 1. Protección: Si no hay sesión, al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

require 'db.php';

// 2. Cargar categorías para el menú desplegable
$stmtCat = $conn->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Gasto - Gestor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-4" style="max-width: 500px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">💸 Nuevo Gasto</h2>
            <small class="text-muted">Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?></small>
        </div>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Salir</a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-4">
            <form action="guardarGasto.php" method="POST">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Monto ($)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="monto" class="form-control form-control-lg" placeholder="0.00" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Categoría</label>
                    <select name="categoria_id" class="form-select form-select-lg" required>
                        <option value="" selected disabled>Elegir categoría...</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>">
                                <?php echo htmlspecialchars($cat['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Descripción / Nota</label>
                    <input type="text" name="descripcion" class="form-control" placeholder="Ej: Supermercado Semanal" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Guardar Gasto
                    </button>
                    <a href="verGastos.php" class="btn btn-outline-secondary">
                        <i class="bi bi-list-ul"></i> Ver Historial y Gráficos
                    </a>
                </div>
                
            </form>
        </div>
    </div>
</div>

</body>
</html>