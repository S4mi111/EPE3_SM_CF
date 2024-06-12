<?php
session_start();
if ($_SESSION['usuario_tipo'] != 'Vendedor') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM repuestos WHERE RepuestoID='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Repuesto no encontrado.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nombreRepuesto = mysqli_real_escape_string($conn, $_POST['nombreRepuesto']);
    $cantidadStock = mysqli_real_escape_string($conn, $_POST['cantidadStock']);
    $precioUnitario = mysqli_real_escape_string($conn, $_POST['precioUnitario']);
    $proveedor = mysqli_real_escape_string($conn, $_POST['proveedor']);

    $sql = "UPDATE repuestos SET NombreRepuesto='$nombreRepuesto', CantidadStock='$cantidadStock', PrecioUnitario='$precioUnitario', Proveedor='$proveedor' WHERE RepuestoID='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: crud_repuestos.php");
        exit();
    } else {
        echo "Error al actualizar el repuesto: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Repuesto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Repuesto</h2>
        <form action="editar_repuesto.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['RepuestoID']; ?>">
            <div class="form-group">
                <label for="nombreRepuesto">Nombre del Repuesto:</label>
                <input type="text" id="nombreRepuesto" name="nombreRepuesto" class="form-control" value="<?php echo $row['NombreRepuesto']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cantidadStock">Cantidad en Stock:</label>
                <input type="number" id="cantidadStock" name="cantidadStock" class="form-control" value="<?php echo $row['CantidadStock']; ?>" required>
            </div>
            <div class="form-group">
                <label for="precioUnitario">Precio Unitario:</label>
                <input type="number" id="precioUnitario" name="precioUnitario" class="form-control" step="0.01" value="<?php echo $row['PrecioUnitario']; ?>" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor:</label>
                <input type="text" id="proveedor" name="proveedor" class="form-control" value="<?php echo $row['Proveedor']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Actualizar</button>
            <a href="crud_repuestos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
