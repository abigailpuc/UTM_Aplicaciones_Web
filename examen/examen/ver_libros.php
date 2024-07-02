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


$sql = "SELECT idlibro, titulo, fecha_publicacion, idautor
        FROM libros";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Registros de Libros</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Registros de Libros</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Fecha de Publicación</th>
                <th>ID del Autor</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['idlibro']); ?></td>
                    <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_publicacion']); ?></td>
                    <td><?php echo htmlspecialchars($row['idautor']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php
    
    sqlsrv_free_stmt($stmt);

    sqlsrv_close($conn);
    ?>
</body>
</html>
