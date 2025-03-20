<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Iniciar la sesión para gestionar la autenticación del usuario
session_start();

// Verificar si el formulario se envió mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores ingresados en el formulario
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Preparar la consulta SQL para obtener el ID y la contraseña del usuario basado en el correo
    $sql = "SELECT id, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro email a la consulta
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Almacenar el resultado para poder verificar si se encontraron filas
    $stmt->store_result();

    // Vincular los resultados a variables
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    // Verificar si se encontró un usuario y si la contraseña es correcta
    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Iniciar la sesión y almacenar el ID del usuario
        $_SESSION['user_id'] = $id;

        // Redirigir al usuario a la lista de pacientes después del inicio de sesión exitoso
        header("Location: lista_pacientes.php");
        exit(); // Asegurar que el script termine después de la redirección
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Incluir hoja de estilos externa -->
    <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <!-- Formulario de inicio de sesión -->
    <form action="lista_pacientes.php" method="POST">
        <!-- Campo para ingresar el correo electrónico -->
        <input type="email" name="email" placeholder="Correo" required><br>
        
        <!-- Campo para ingresar la contraseña -->
        <input type="password" name="password" placeholder="Contraseña" required><br>
        
        <!-- Botón para enviar el formulario -->
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>
