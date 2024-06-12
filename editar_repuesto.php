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
    $row = $result->fetch_assoc();
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
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Repuesto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Editar Repuesto</h2>
    <form action="editar_repuesto.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['RepuestoID']; ?>">
        <label for="nombreRepuesto">Nombre del Repuesto:</label>
        <input type="text" id="nombreRepuesto" name="nombreRepuesto" value="<?php echo $row['NombreRepuesto']; ?>" required><br>
        <label for="cantidadStock">Cantidad en Stock:</label>
        <input type="number" id="cantidadStock" name="cantidadStock" value="<?php echo $row['CantidadStock']; ?>" required><br>
        <label for="precioUnitario">Precio Unitario:</label>
        <input type="number" id="precioUnitario" name="precioUnitario" step="0.01" value="<?php echo $row['PrecioUnitario']; ?>" required><br>
        <label for="proveedor">Proveedor:</label>
        <input type="text" id="proveedor" name="proveedor" value="<?php echo $row['Proveedor']; ?>" required><br>
        <button type="submit" name="update">Actualizar</button>
    </form>
</body>
</html>
