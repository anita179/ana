<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si la solicitud se realiza mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $telefono = trim($_POST["telefono"]);
    $direccion = trim($_POST["direccion"]);
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $fecha_registro = $_POST["fecha_registro"];
    
    // Verificar que ningún campo esté vacío
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion) || empty($fecha_nacimiento) || empty($fecha_registro)) {
        die("Error: Todos los campos son obligatorios.");
    }
    
    // Preparar la consulta SQL para insertar un nuevo paciente
    $sql = "INSERT INTO pacientes (nombre, apellido, telefono, direccion, fecha_nacimiento, fecha_registro)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia para evitar inyección SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $apellido, $telefono, $direccion, $fecha_nacimiento, $fecha_registro);
    
    // Ejecutar la consulta y verificar si se realizó correctamente
    if ($stmt->execute()) {
        // Redirigir a la lista de pacientes después de una inserción exitosa
        header("Location: ../back/lista_pacientes.php");
        exit();
    } else {
        die("Error al guardar el paciente: " . $conn->error);
    }
}

// Establecer la fecha actual formateada
$fecha_actual = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Paciente</title>
    <link rel="stylesheet" href="../style/agregar_paciente.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Nuevo Paciente</h2>
        <form action="" method="POST">
            <div class="input-field">
                <input type="text" name="nombre" placeholder="Nombre" required>
            </div>
            
            <div class="input-field">
                <input type="text" name="apellido" placeholder="Apellido" required>
            </div>
            
            <div class="input-field">
                <input type="text" name="telefono" placeholder="Teléfono" required>
            </div>
            
            <div class="input-field">
                <input type="text" name="direccion" placeholder="Dirección" required>
            </div>
            
            <div class="input-field">
                <input type="text" 
                       id="fecha_nacimiento" 
                       name="fecha_nacimiento" 
                       placeholder="Fecha de Nacimiento" 
                       onfocus="(this.type='date')" 
                       onblur="if(!this.value) this.type='text'" 
                       required>
            </div>
            
            <div class="input-field">
                <input type="text" 
                       id="fecha_registro" 
                       name="fecha_registro" 
                       placeholder="Fecha de Registro" 
                       
                       onblur="if(!this.value) this.type='text'" 
                       value="<?php echo $fecha_actual; ?>" 
                       required>
            </div>
            
            <button type="submit">Guardar</button>
        </form>
    </div>

    <script>
        // Script para mejorar la experiencia del usuario con los campos de fecha
        document.addEventListener('DOMContentLoaded', function() {
            // Establecer el formato de fecha adecuado para el campo fecha_registro
            var fechaRegistro = document.getElementById('fecha_registro');
            if(fechaRegistro && !fechaRegistro.value) {
                fechaRegistro.valueAsDate = new Date();
            }
        });
    </script>
</body>
</html>

