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