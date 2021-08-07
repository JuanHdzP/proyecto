<?php
require_once './checa-sesion.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intercambios</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <?php
    require_once './menu.php';
    ?>
    <div class="container mt-3">
        <div class="card">
            <h4 class="card-header  text-center"><i class="bi-arrow-left-right"></i> Intercambios</h4>
            <div class="card-body">
            <div class="d-grid gap-2">
            <a href="intercambio.php" class="btn btn-primary float-end">
                                    <i class="bi-plus-lg"></i> Generar
                                </a>
            </div>
                <table class="table-striped table table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="width: 18%;">Cliente</th>
                            <th style="width: 18%;">Empleado</th>
                            <th style="width: 20%;">Libro que entra</th>
                            <th style="width: 20%;">Libro que sale</th>
                            <th style="width: 10%;">Fecha</th>
                            <th style="width: 34%;">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once './conexion.php';
$sql = <<<fin
                        select
                            i.id
                            , concat(u.primer_apellido, ' ', u.segundo_apellido, ' ', u.nombre) as nombre
                            , concat(u1.primer_apellido, ' ', u1.segundo_apellido, ' ', u1.nombre) as nombre1   
                            , i.contacto_id
                            , i.empleado_id
                            , i.entrada_libro_id
                            , i.salida_libro_id
                            , i.fecha_intercambio
                            , l.titulo
                            , l1.titulo as titulo1
                        from
                            intercambios i
                            inner join usuarios as u on i.contacto_id = u.id 
                            inner join usuarios as u1 on i.empleado_id = u1.id
                            inner join libros as l on i.entrada_libro_id = l.id
                            inner join libros as l1 on i.salida_libro_id = l1.id            
fin;
                        $sentencia = $conexion->prepare($sql);
                        $sentencia->execute();
                        foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlentities($row['nombre']) ?></td>
                            <td><?php echo htmlentities($row['nombre1']) ?></td>
                            <td><?php echo htmlentities($row['titulo']) ?></td>
                            <td><?php echo htmlentities($row['titulo1']) ?></td>
                            <td><?php echo htmlentities($row['fecha_intercambio']) ?></td>
                            <td>
                                <a href="intercambio.php?id=<?php echo $row['id'] ?>" class="btn btn btn-outline-primary float-end">
                                    <i class="bi-pencil-fill"></i>Modificar
                                </a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="d-grid gap-2">
                <a href="index.php" class="btn btn-outline-dark float-end">
                    <i class="bi-house-door-fill"></i>   Inicio</a>
                    </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>