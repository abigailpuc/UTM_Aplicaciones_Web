<?php
$serverName = "LAPTOP-SPC8CQGE"; // Nombre de tu servidor SQL Server
$connectionOptions = array(
    "Database" => "entidades",
    "Uid" => "proyectos",
    "PWD" => "proyectos123"
);

// Establecer la conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}


$idToUpdate = "";
$nombre = "";
$apellido = "";
$fecha_nacimiento = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $idToUpdate = $_POST['idToUpdate'];

    
    if (!empty($idToUpdate) && is_numeric($idToUpdate)) {
       
        $sql = "SELECT nombre, apellido, fecha_nacimiento
                FROM autores
                WHERE idautor = ?";
        $params = array($idToUpdate);

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        
        if (sqlsrv_fetch($stmt) === true) {
            $nombre = sqlsrv_get_field($stmt, 0);
            $apellido = sqlsrv_get_field($stmt, 1);
            $fecha_nacimiento = sqlsrv_get_field($stmt, 2)->format('Y-m-d'); 
        } else {
            echo "No se encontró ningún registro con el ID proporcionado.";
        }

        sqlsrv_free_stmt($stmt);
    } else {
        echo "Por favor, ingresa un ID válido para buscar.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
   
    $idToUpdate = $_POST['idToUpdate'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

   
    if (!empty($idToUpdate) && is_numeric($idToUpdate)) {
       
        $sql = "UPDATE autores
                SET nombre = ?, apellido = ?, fecha_nacimiento = ?
                WHERE idautor = ?";
        $params = array($nombre, $apellido, $fecha_nacimiento, $idToUpdate);

       
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Registro actualizado correctamente.";
            
            $idToUpdate = "";
            $nombre = "";
            $apellido = "";
            $fecha_nacimiento = "";
        }

      
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
    } else {
        echo "Por favor, ingresa un ID válido para actualizar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Modificación</title>
</head>
<body>
    <h2>Formulario de Modificación</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="idToUpdate">ID del Registro a Modificar:</label>
        <input type="text" id="idToUpdate" name="idToUpdate" value="<?php echo htmlspecialchars($idToUpdate); ?>"><br><br>

        <input type="submit" name="search" value="Buscar">
    </form>

    <br>

    <?php if (!empty($nombre) && !empty($idToUpdate)): ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" id="idToUpdate" name="idToUpdate" value="<?php echo htmlspecialchars($idToUpdate); ?>">
            
            <label for="nombre">Campo 1:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br><br>

            <label for="apellido">Campo 2:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>"><br><br>


            <label for="fecha_nacimiento">Campo 4:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento); ?>"><br><br>


            <input type="submit" name="update" value="Actualizar">
        </form>
    <?php endif; ?>
</body>
</html>
