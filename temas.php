<?php
//require_once './checa-sesion.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temas</title>
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
                    <i class="bi-stars"></i> Temas
                </div>
                <div class="card-body">
                    <a class="float-end btn btn-primary btn-sm" href="tema.php" title="Crear categoría">
                        <i class="bi-plus-circle-fill"></i> Crear
                    </a>
                    <table class="table-striped table table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="width:80%;">Tema</th>
                                <th style="width:20%;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once './conexion.php';
                            $sql = 'select id, nombre from temas order by nombre asc';
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->execute();
                            foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $tema) {
                                $tema['nombre'] = htmlentities($tema['nombre']);
                                echo <<<fin
                            <tr>
                                <td>{$tema['nombre']}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="tema.php?id={$tema['id']}" title="Clic para editar tema">
                                        <i class="bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
fin;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>