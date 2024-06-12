<?php
session_start();
if ($_SESSION['usuario_tipo'] != 'Administrador') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $sql = "DELETE FROM usuarios WHERE Rut='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
header("Location: crud_usuarios.php");
exit();
?>
