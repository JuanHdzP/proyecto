<?php
require_once './checa-sesion.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <?php
    require_once './menu.php';
    ?>
    <div class="container mt-3">
        <div class="card">
            <h4 class="card-header  text-center"><i class="bi-people"></i> Usuarios</h4>
            <div class="card-body">
            <div class="d-grid gap-2">
            <a href="usuario.php" class="btn btn btn-danger float-end">
                                    <i class="bi-plus-lg"></i> Crear
                                </a>
            </div>
                <table class="table-striped table table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 20%;">Correo</th>
                            <th style="width: 20%;">Perfil</th>
                            <th style="width: 20%;">Estatus</th>
                            <th style="width: 20%;">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once './conexion.php';
                        $sql = <<<fin
select
    u.id
    , concat(u.primer_apellido, ' ', u.segundo_apellido, ' ', u.nombre) as nombre
    , u.correo_electronico 
    , u.perfil 
    , u.estatus 
from
    usuarios u
fin;
                        $sentencia = $conexion->prepare($sql);
                        $sentencia->execute();
                        foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlentities($row['nombre']) ?></td>
                            <td><?php echo htmlentities($row['correo_electronico']) ?></td>
                            <td><?php echo htmlentities($row['perfil']) ?></td>
                            <td><?php echo htmlentities($row['estatus']) ?></td>
                            <td>
                                <a href="usuario.php?id=<?php echo $row['id'] ?>" class="btn btn btn-outline-danger float-end">
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