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

$nombre = "";
$apellido = "";
$fecha_nacimiento = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
   
    $sql = "INSERT INTO autores (nombre, apellido, fecha_nacimiento) 
            VALUES (?, ?, ?)";
    
    $params = array($nombre, $apellido,$fecha_nacimiento);

   
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Registro insertado correctamente.";
        
        $nombre = "";
        $apellido = "";
        $fecha_nacimiento = "";
    }

  
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
</head>
<body>
    <h2>Formulario de Registro</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre">nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br><br>

        <label for="apellido">apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>"><br><br>

        <label for="fecha_nacimiento">fecha_nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento); ?>"><br><br>


        <input type="submit" value="Registrar">
    </form>
</body>
</html>
