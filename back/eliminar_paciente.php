<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se ha proporcionado un ID a través de la URL
if (isset($_GET["id"])) {
    // Obtener el ID del paciente desde la URL
    $id = $_GET["id"];

    // Preparar la consulta SQL para eliminar el paciente con el ID proporcionado
    $sql = "DELETE FROM pacientes WHERE id = ?";

    // Preparar la sentencia para prevenir inyección SQL
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro con el valor del ID (tipo entero)
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta y verificar si se realizó correctamente
    if ($stmt->execute()) {
        // Redirigir a la lista de pacientes después de una eliminación exitosa
        header("Location: lista_pacientes.php");
        exit(); // Asegurar que el script termine después de la redirección
    }
}
?>
