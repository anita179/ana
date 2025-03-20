<?php 
include 'conexion.php';

// Verificar si 'id' está presente y es numérico
if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) { 
    die("Error: No se proporcionó un ID válido."); 
}

$id = intval($_GET["id"]);

// Consultar la base de datos para obtener el paciente
$sql = "SELECT * FROM pacientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Si no encuentra el paciente, mostrar error
if ($result->num_rows === 0) {
    die("Error: Paciente no encontrado.");
}

$paciente = $result->fetch_assoc();

// Procesar actualización del paciente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["nombre"]))) {
        echo "<p style='color:red;'>Error: El nombre no puede estar vacío.</p>";
    } else {
        $nombre = trim($_POST["nombre"]);
        $sql = "UPDATE pacientes SET nombre = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);

        if ($stmt->execute()) {
            header("Location: lista_pacientes.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error al actualizar el paciente.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="../style/editar_paciente.css">
</head>
<body>
    <div class="container">
        <h2 class="header">Editar Paciente</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($paciente['nombre']) ?>" required>
            </div>
            <button type="submit" class="btn">Actualizar</button>
        </form>
    </div>
</body>
</html>

<?php
include 'conexion.php';

// Validar si el ID está presente y es un número
if (!isset($_GET["id"]) || !filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
    die("Error: No se proporcionó un ID válido.");
}

$id = intval($_GET["id"]);

// Consultar si el paciente existe
$sql = "SELECT * FROM pacientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Si no se encuentra el paciente, mostrar error
if ($result->num_rows === 0) {
    die("Error: Paciente no encontrado.");
}

$paciente = $result->fetch_assoc();

// Procesar la actualización del paciente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    
    if (empty($nombre)) {
        die("Error: El nombre no puede estar vacío.");
    }

    $sql = "UPDATE pacientes SET nombre = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre, $id);

    if ($stmt->execute()) {
        header("Location: lista_pacientes.php");
        exit();
    } else {
        echo "Error al actualizar el paciente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="style/editar_paciente.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: blue;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="header">Editar Paciente</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($paciente['nombre']) ?>" required>
            </div>
            <button type="submit" class="btn">Actualizar</button>
  
