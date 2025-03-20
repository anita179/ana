<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Ejecutar la consulta para obtener todos los pacientes con sus datos
$result = $conn->query("SELECT id, nombre, apellido, telefono, direccion, fecha_nacimiento, fecha_registro FROM pacientes");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Pacientes</title>
    <!-- Incluir hoja de estilos externa -->
    <link rel="stylesheet" href="./style/lista_pacientes.css">
    <style>
        .boton-agregar {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 20px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .boton-agregar:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Lista de Pacientes</h2>

    <!-- Botón para agregar un nuevo paciente -->
    <a href="agregar_paciente.php" class="boton-agregar">Agregar Paciente</a>

    <!-- Tabla para mostrar los datos de los pacientes -->
    <table border="1">
        <tr>
            <!-- Encabezados de la tabla -->
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Fecha de Nacimiento</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
        </tr>

        <!-- Recorrer los resultados de la consulta y mostrarlos en la tabla -->
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <!-- Mostrar los valores de cada paciente en las columnas -->
            <td><?= $row['id'] ?></td>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['apellido'] ?></td>
            <td><?= $row['telefono'] ?></td>
            <td><?= $row['direccion'] ?></td>
            <td><?= $row['fecha_nacimiento'] ?></td>
            <td><?= $row['fecha_registro'] ?></td>
            <td>
                <!-- Enlace para editar el paciente -->
                <a href="editar_paciente.php?id=<?= $row['id'] ?>">Editar</a>
                <!-- Enlace para eliminar el paciente con confirmación -->
                <a href="eliminar_paciente.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

