<?php
// login.php
session_start();
include 'db.php';

// Sanitizar entradas
$correo = mysqli_real_escape_string($conn, $_POST['correo']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Preparar la consulta
$sql = $conn->prepare("SELECT * FROM usuarios WHERE correo = ? AND Contraseña = ?");

// Verificar si la preparación de la consulta fue exitosa
if ($sql === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$sql->bind_param("ss", $correo, $password);
$sql->execute();
$result = $sql->get_result();

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $row['Rut'];
        $_SESSION['usuario_tipo'] = $row['Tipo'];

        switch ($row['Tipo']) {
            case 'Administrador':
                header("Location: admin_menu.php");
                break;
            case 'Vendedor':
                header("Location: vendedor_menu.php");
                break;
            default:
                $error_message = "Tipo de usuario no reconocido.";
                break;
        }
    } else {
        $error_message = "Correo o contraseña incorrectos.";
    }
} else {
    $error_message = "Error en la consulta: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Iniciar Sesión</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
