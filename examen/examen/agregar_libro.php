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

$titulo = "";
$fecha_publicacion = "";
$idautor = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = trim($_POST['titulo']);
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $idautor = $_POST['idautor'];

   
    if (empty($titulo) || empty($fecha_publicacion) || empty($idautor)) {
        echo "Todos los campos son obligatorios.";
    } else {
 
        if (!strtotime($fecha_publicacion)) {
            echo "La fecha de publicación no es válida.";
        } else {
           
            $hoy = date("Y-m-d");
            if ($fecha_publicacion > $hoy) {
                echo "La fecha de publicación no puede ser posterior a hoy.";
            } else {
                
                if (!is_numeric($idautor)) {
                    echo "El ID del autor debe ser un número.";
                } else {
                  
                    $sql = "INSERT INTO libros (titulo, fecha_publicacion, idautor) 
                            VALUES (?, ?, ?)";
                    
                    $params = array($titulo, $fecha_publicacion, $idautor);

                    $stmt = sqlsrv_query($conn, $sql, $params);
                    if ($stmt === false) {
                        die("Error al insertar el registro: " . print_r(sqlsrv_errors(), true));
                    } else {
                        echo "Registro insertado correctamente.";
                    
                        $titulo = "";
                        $fecha_publicacion = "";
                        $idautor = "";
                    }

                    sqlsrv_free_stmt($stmt);
                    sqlsrv_close($conn);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro de Libros</title>
</head>
<body>
    <h2>Formulario de Registro de Libros</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>"><br><br>

        <label for="fecha_publicacion">Fecha de Publicación:</label>
        <input type="date" id="fecha_publicacion" name="fecha_publicacion" value="<?php echo htmlspecialchars($fecha_publicacion); ?>"><br><br>

        <label for="idautor">ID del Autor:</label>
        <input type="number" id="idautor" name="idautor" value="<?php echo htmlspecialchars($idautor); ?>"><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>
