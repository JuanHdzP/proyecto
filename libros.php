<?php
require_once './checa-sesion.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <?php
    require_once './menu.php';
    ?>
    <div class="container mt-3" >
        <div class="card text-dark bg-light mb-3">
            <h4 class="card-header text-center"><i class="bi-book"></i> Libros</h4>
            <div class="card-body">
            <div class="d-grid gap-2">
            <a href="libro_crear.php" class="btn btn-success float-end">
            <i class="bi-plus-lg "></i>  Crear</a>
            </div>
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="width: 35%;">Título</th>
                            <th style="width: 35%;">Autor</th>
                            <th style="width: 20%;">Editorial</th>
                            <th style="width: 10%;">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once './conexion.php';
                        //$sql = <<<fin
//select
//    lm.id
//    , lm.estado_id
//    , lm.municipio_id
//    , lm.nombre_lugar
//    , e.estado
//    , m.municipio
//from
//    lugares_magicos lm
//    inner join estados e on lm.estado_id = e.id
//    inner join municipios m on lm.municipio_id = m.id
//order by
//    e.estado, m.municipio, lm.nombre_lugar asc
//    
//fin;
                        $sql = <<<fin
                        select
                            l.id
                            , l.editorial_id
                            , l.titulo
                            , l.autor
                            , e.editorial
                        from
                            libros l
                            inner join editoriales e on l.editorial_id = e.id
                        order by
                            e.editorial, l.autor, l.titulo asc
                            
fin;
                        $sentencia = $conexion->prepare($sql);
                        $sentencia->execute();
                        foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlentities($row['titulo']) ?></td>
                            <td><?php echo htmlentities($row['autor']) ?></td>
                            <td><?php echo htmlentities($row['editorial']) ?></td>
                            <td>
                                <a href="libro_crear.php?id=<?php echo $row['id'] ?>" class="btn btn-outline-success float-end">
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