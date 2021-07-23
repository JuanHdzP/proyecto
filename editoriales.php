<?php
require_once './checa-sesion.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editoriales</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <?php
    require_once './menu.php';
    ?>
    <div class="container mt-3">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 i class="bi-printer"></i> Editoriales</h4>
                </div>
                <div class="card-body">
                <div class="d-grid gap-2">
                <a class="float-end btn btn-secondary" href="editorial.php" title="Crear editorial">
                        <i class="bi-plus-lg"></i>   Crear</h5>
                    </a>
                </div>
                    <table class="table-striped table table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="width:80%;">Editorial</th>
                                <th style="width:20%;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once './conexion.php';
                            $sql = 'select id, editorial from editoriales order by editorial asc';
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->execute();
                            foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $editorial) {
                                $editorial['editorial'] = htmlentities($editorial['editorial']);
                                echo <<<fin
                            <tr>
                                <td>{$editorial['editorial']}</td>
                                <td>
                                    <a class="btn btn-outline-secondary float-end"  href="editorial.php?id={$editorial['id']}" title="Clic para editar editorial">
                                        <i class="bi-pencil-fill"></i>Modificar
                                    </a>
                                </td>
                            </tr>
fin;
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
    </div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>