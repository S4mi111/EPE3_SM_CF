<?php
session_start();
if ($_SESSION['usuario_tipo'] != 'Administrador') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);

    $sql = "INSERT INTO usuarios (correo, Contraseña, tipo) VALUES ('$correo', '$password', '$tipo')";
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo usuario insertado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
header("Location: crud_usuarios.php");
exit();
?>
