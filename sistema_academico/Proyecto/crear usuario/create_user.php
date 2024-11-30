<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "sistema_login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario de registro
$id = $_POST['id'];
$user = $_POST['username'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$user_type = $_POST['user_type'];

// Comprobar si el usuario ya existe
$sql_check = "SELECT * FROM usuarios WHERE username = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $user);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "El nombre de usuario ya existe. <a href='register.html'>Intenta con otro nombre de usuario</a>.";
} else {
    // Insertar en la base de datos si el usuario no existe
    $sql_insert = "INSERT INTO usuarios (id, username, password, email, phone, address, user_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $id, $user, $pass, $email, $phone, $address, $user_type);

    if ($stmt_insert->execute()) {
        echo "Usuario registrado exitosamente. <a href='index.html'>Inicia sesión aquí</a>.";
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
