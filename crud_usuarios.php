<?php
session_start();
if ($_SESSION['usuario_tipo'] != 'Administrador') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar entradas
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);

    // Manejar las acciones de Insertar y Eliminar
    if (isset($_POST['insert'])) {
        $sql = "INSERT INTO usuarios (Correo, password, Tipo) VALUES ('$correo', '$password', '$tipo')";
        if ($conn->query($sql) === TRUE) {
            header("Location: crud_usuarios.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = "DELETE FROM usuarios WHERE Rut='$id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: crud_usuarios.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Obtener usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">CRUD Usuarios</h2>
        <form action="crud_usuarios.php" method="post" class="mb-4">
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo" class="form-control" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Mecanico">Mecánico</option>
                    <option value="Aseguradora">Aseguradora</option>
                    <option value="Analista">Analista</option>
                    <option value="Gerente">Gerente</option>
                </select>
            </div>
            <button type="submit" name="insert" class="btn btn-primary">Insertar</button>
        </form>

        <h2>Lista de Usuarios</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>RUT</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['Rut']; ?></td>
                    <td><?php echo $row['Correo']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td><?php echo $row['Tipo']; ?></td>
                    <td>
                        <form action="editar_usuario.php" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['Rut']; ?>">
                            <button type="submit" name="edit" class="btn btn-warning btn-sm">Editar</button>
                        </form>
                        <form action="crud_usuarios.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['Rut']; ?>">
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
