<?php
// Incluir conexión a la base de datos
include("../../control/conexion.php");

// Cambiar la ruta según la ubicación de "conexion.php"


// Obtener datos del formulario
$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$postal_code = $_POST['postal_code'];

// Consultar si el ID ya existe
$sql_check = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si el ID ya existe, mostrar un mensaje
    echo "<script>
        alert('El ID ya está registrado en el sistema.');
        window.history.back();
    </script>";
} else {
    // Insertar el nuevo usuario
    $sql_insert = "INSERT INTO usuarios (id, username, password, user_type, email, phone, address, city, state, postal_code) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt_insert->bind_param("ssssssssss", $id, $username, $hashed_password, $user_type, $email, $phone, $address, $city, $state, $postal_code);

    if ($stmt_insert->execute()) {
        echo "<script>
            alert('Usuario registrado exitosamente.');
            window.location.href = 'create_user.html';
        </script>";
    } else {
        echo "<script>
            alert('Error al registrar el usuario.');
            window.history.back();
        </script>";
    }
}

$conn->close();
?>
