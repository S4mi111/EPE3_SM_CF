<?php
// login.php
session_start();
include 'db.php';

// Sanitizar entradas
$correo = mysqli_real_escape_string($conn, $_POST['correo']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Imprimir entradas sanitizadas para verificar
echo "Correo: $correo <br>";
echo "Contraseña: $password <br>";

$sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND password = '$password'";
$result = $conn->query($sql);

// Imprimir la consulta SQL para verificar
echo "Consulta SQL: $sql <br>";

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $row['Rut'];
        $_SESSION['usuario_tipo'] = $row['Tipo'];
        
        // Imprimir el resultado de la consulta para verificar
        echo "Resultado de la consulta: <pre>";
        print_r($row);
        echo "</pre>";

        switch ($row['Tipo']) {
            case 'Administrador':
                header("Location: admin_menu.php");
                break;
            case 'Vendedor':
                header("Location: vendedor_menu.php");
                break;
            case 'Mecanico':
                header("Location: mecanico_menu.php"); // Asegúrate de crear esta página
                break;
            case 'Aseguradora':
                header("Location: aseguradora_menu.php"); // Asegúrate de crear esta página
                break;
            case 'Analista':
                header("Location: analista_menu.php"); // Asegúrate de crear esta página
                break;
            case 'Gerente':
                header("Location: gerente_menu.php"); // Asegúrate de crear esta página
                break;
            default:
                echo "Tipo de usuario no reconocido.";
                break;
        }
    } else {
        echo "Correo o contraseña incorrectos";
    }
} else {
    echo "Error en la consulta: " . $conn->error;
}
?>
