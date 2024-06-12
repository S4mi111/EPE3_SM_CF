<?php
// db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taller";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Asegúrate de que la conexión use UTF-8
if (!$conn->set_charset("utf8")) {
    die("Error loading character set utf8: " . $conn->error);
}
?>
