<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si la solicitud se realiza mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el valor del campo 'nombre' enviado desde el formulario
    $nombre = $_POST["nombre"];

    // Preparar la consulta SQL para insertar un nuevo paciente en la base de datos
    $sql = "INSERT INTO pacientes (nombre) VALUES (?)";

    // Preparar la sentencia para evitar inyección SQL
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro con el valor ingresado por el usuario
    $stmt->bind_param("s", $nombre);

    // Ejecutar la consulta y verificar si se realizó correctamente
    if ($stmt->execute()) {
        // Redirigir a la lista de pacientes después de una inserción exitosa
        header("Location: lista_pacientes.php");
        exit(); // Asegurar que el script termine después de la redirección
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Paciente</title>
    <link rel="stylesheet" href="./style/agregar_paciente.css">
</head>
<body>
    <!-- Formulario para agregar un nuevo paciente -->
    <form action="" method="POST">
        <!-- Campo de entrada para el nombre del paciente -->
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <!-- Botón para enviar el formulario -->
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
