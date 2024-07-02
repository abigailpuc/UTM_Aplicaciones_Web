<?php
$serverName = "LAPTOP-SPC8CQGE"; 
$connectionOptions = array(
    "Database" => "entidades",
    "Uid" => "proyectos",
    "PWD" => "proyectos123"
);


$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$idToUpdate = "";
$titulo = "";
$fecha_publicacion = "";
$idautor = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $idToUpdate = $_POST['idToUpdate'];

    if (!empty($idToUpdate) && is_numeric($idToUpdate)) {
    
        $sql = "SELECT titulo, fecha_publicacion, idautor
                FROM libros 
                WHERE idlibro = ?";
        $params = array($idToUpdate);

        
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        
        if (sqlsrv_fetch($stmt) === true) {
            $titulo = sqlsrv_get_field($stmt, 0);
            $fecha_publicacion = sqlsrv_get_field($stmt, 1);
            $idautor = sqlsrv_get_field($stmt, 2);
        } else {
            echo "No se encontró ningún libro con el ID proporcionado.";
        }

      
        sqlsrv_free_stmt($stmt);
    } else {
        echo "Por favor, ingresa un ID válido para buscar.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
   
    $idToUpdate = $_POST['idToUpdate'];
    $titulo = $_POST['titulo'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $idautor = $_POST['idautor'];

   
    if (!empty($idToUpdate) && is_numeric($idToUpdate)) {
        
        $sql = "UPDATE libros 
                SET titulo = ?, fecha_publicacion = ?, idautor = ?
                WHERE idlibro = ?";
        $params = array($titulo, $fecha_publicacion, $idautor, $idToUpdate);

       
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Libro actualizado correctamente.";
           
            $idToUpdate = "";
            $titulo = "";
            $fecha_publicacion = "";
            $idautor = "";
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
    <title>Formulario de Modificación de Libros</title>
</head>
<body>
    <h2>Formulario de Modificación de Libros</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="idToUpdate">ID del Libro a Modificar:</label>
        <input type="text" id="idToUpdate" name="idToUpdate" value="<?php echo htmlspecialchars($idToUpdate); ?>"><br><br>

        <input type="submit" name="search" value="Buscar">
    </form>

    <br>

    <?php if (!empty($titulo) && !empty($idToUpdate)): ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" id="idToUpdate" name="idToUpdate" value="<?php echo htmlspecialchars($idToUpdate); ?>">
            
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>"><br><br>

            <label for="fecha_publicacion">Fecha de Publicación:</label>
            <input type="date" id="fecha_publicacion" name="fecha_publicacion" value="<?php echo htmlspecialchars($fecha_publicacion); ?>"><br><br>

            <label for="idautor">ID del Autor:</label>
            <input type="text" id="idautor" name="idautor" value="<?php echo htmlspecialchars($idautor); ?>"><br><br>

            <input type="submit" name="update" value="Actualizar">
        </form>
    <?php endif; ?>
</body>
</html>
