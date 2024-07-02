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

$sql = "SELECT idautor, nombre, apellido,fecha_nacimiento 
        FROM autores";


$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Registros de entidad1</title>
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
    <h2>Registros de entidad1</h2>
    <table>
        <thead>
            <tr>
                <th>idautor</th>
                <th>nombre</th>
                <th>apellido</th>
                <th>fecha_nacimiento</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['idautor']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_nacimiento']->format('Y-m-d')); ?></td> <!-- Formato de fecha -->
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
