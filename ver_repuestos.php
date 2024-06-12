<?php
session_start();
if ($_SESSION['usuario_tipo'] != 'Vendedor') {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Obtener repuestos
$sql = "SELECT * FROM repuestos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Repuestos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Taller Mecánico</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Lista de Repuestos</h2>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre del Repuesto</th>
                    <th>Cantidad en Stock</th>
                    <th>Precio Unitario</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['RepuestoID']; ?></td>
                    <td><?php echo $row['NombreRepuesto']; ?></td>
                    <td><?php echo $row['CantidadStock']; ?></td>
                    <td><?php echo $row['PrecioUnitario']; ?></td>
                    <td><?php echo $row['Proveedor']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
