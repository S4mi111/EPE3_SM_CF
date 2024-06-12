<?php
session_start();
if ($_SESSION['usuario_tipo'] != 'Vendedor') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar entradas
    $nombreRepuesto = mysqli_real_escape_string($conn, $_POST['nombreRepuesto']);
    $cantidadStock = mysqli_real_escape_string($conn, $_POST['cantidadStock']);
    $precioUnitario = mysqli_real_escape_string($conn, $_POST['precioUnitario']);
    $proveedor = mysqli_real_escape_string($conn, $_POST['proveedor']);

    // Manejar las acciones de Insertar
    if (isset($_POST['insert'])) {
        $sql = "INSERT INTO repuestos (NombreRepuesto, CantidadStock, PrecioUnitario, Proveedor) VALUES ('$nombreRepuesto', '$cantidadStock', '$precioUnitario', '$proveedor')";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = "DELETE FROM repuestos WHERE RepuestoID='$id'";
        $conn->query($sql);
    }
}

// Obtener repuestos
$sql = "SELECT * FROM repuestos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Repuestos</title>
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
        <h2 class="mb-4">CRUD Repuestos</h2>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Agregar Repuesto</h3>
            </div>
            <div class="card-body">
                <form action="crud_repuestos.php" method="post">
                    <div class="form-group">
                        <label for="nombreRepuesto">Nombre del Repuesto:</label>
                        <input type="text" id="nombreRepuesto" name="nombreRepuesto" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cantidadStock">Cantidad en Stock:</label>
                        <input type="number" id="cantidadStock" name="cantidadStock" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="precioUnitario">Precio Unitario:</label>
                        <input type="number" id="precioUnitario" name="precioUnitario" step="0.01" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="proveedor">Proveedor:</label>
                        <input type="text" id="proveedor" name="proveedor" class="form-control" required>
                    </div>
                    <button type="submit" name="insert" class="btn btn-primary">Insertar</button>
                </form>
            </div>
        </div>

        <h2 class="mt-5">Lista de Repuestos</h2>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre del Repuesto</th>
                    <th>Cantidad en Stock</th>
                    <th>Precio Unitario</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
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
                    <td>
                        <form action="editar_repuesto.php" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['RepuestoID']; ?>">
                            <button type="submit" name="edit" class="btn btn-warning btn-sm">Editar</button>
                        </form>
                        <form action="crud_repuestos.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['RepuestoID']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
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
