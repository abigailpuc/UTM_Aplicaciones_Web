<?php
// Función para buscar libros por título o autor
function buscarLibros($textoBusqueda) {
    $serverName = "LAPTOP-SPC8CQGE";
    $connectionInfo = array(
        "Database" => "entidades",
        "Uid" => "proyectos",
        "PWD" => "proyectos123"
    );

    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $sql = "EXEC BuscarLibros @texto_busqueda = ?";
    $params = array($textoBusqueda);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $libros = array();

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $libros[] = $row;
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    return $libros;
}

// Manejar el formulario de búsqueda
if (isset($_POST['buscar'])) {
    $textoBusqueda = $_POST['texto_busqueda'];
    $libros = buscarLibros($textoBusqueda);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Libros por Título o Autor</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Buscar Libros por Título o Autor</h1>
    <form method="POST">
        <label for="texto_busqueda">Buscar:</label>
        <input type="text" id="texto_busqueda" name="texto_busqueda">
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <h2>Resultados de la búsqueda:</h2>
    <?php
    if (isset($libros) && !empty($libros)) {
        echo "<table>";
        echo "<tr><th>Título</th><th>Fecha de Publicación</th><th>Autor</th></tr>";
        foreach ($libros as $libro) {
            echo "<tr>";
            echo "<td>{$libro['titulo']}</td>";
            echo "<td>{$libro['fecha_publicacion']}</td>";
            echo "<td>{$libro['nombre_autor']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }
    ?>
</body>
</html>
