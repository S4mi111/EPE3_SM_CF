<?php
session_start();
if ($_SESSION['usuario_tipo'] != 'Administrador') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM usuarios WHERE Rut='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);

    $sql = "UPDATE usuarios SET correo='$correo', Contraseña='$password', tipo='$tipo' WHERE Rut='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: crud_usuarios.php");
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
    <title>Editar Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Usuario</h2>
        <form action="editar_usuario.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['Rut']; ?>">
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $row['Correo']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $row['Contraseña']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo" class="form-control" required>
                    <option value="Administrador" <?php if ($row['Tipo'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
                    <option value="Vendedor" <?php if ($row['Tipo'] == 'Vendedor') echo 'selected'; ?>>Vendedor</option>
                    <option value="Mecanico" <?php if ($row['Tipo'] == 'Mecanico') echo 'selected'; ?>>Mecánico</option>
                    <option value="Aseguradora" <?php if ($row['Tipo'] == 'Aseguradora') echo 'selected'; ?>>Aseguradora</option>
                    <option value="Analista" <?php if ($row['Tipo'] == 'Analista') echo 'selected'; ?>>Analista</option>
                    <option value="Gerente" <?php if ($row['Tipo'] == 'Gerente') echo 'selected'; ?>>Gerente</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
