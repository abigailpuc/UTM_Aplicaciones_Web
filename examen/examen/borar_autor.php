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

$idToDelete = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $idToDelete = $_POST['idToDelete'];

    
    if (!empty($idToDelete) && is_numeric($idToDelete)) {
       
        $sql = "DELETE FROM autores WHERE idautor = ?";
        $params = array($idToDelete);

       
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Registro eliminado correctamente.";
            
            $idToDelete = "";
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
    } else {
        echo "Por favor, ingresa un ID válido para eliminar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Eliminación</title>
</head>
<body>
    <h2>Formulario de Eliminación</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="idToDelete">ID del Registro a Eliminar:</label>
        <input type="text" id="idToDelete" name="idToDelete" value="<?php echo htmlspecialchars($idToDelete); ?>"><br><br>

        <input type="submit" value="Eliminar">
    </form>
</body>
</html>
