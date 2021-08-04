<!--<?php
//require_once './checa-sesion.php';
?>-->

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Principal</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <?php
    require_once './menu.php';
    ?>
    <div class="container mt-3">
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <th style="width:60%">
                        <div class="card">
                            <p class="card-header fs-5 fw-normal"><i class="bi bi-collection"></i> De un vistazo</p>
                            <div class="card-body">
                                <div id="carouselLibros" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner rounded-3">
                                        
                                        <div class="carousel-item active">
                                            <img src="./recursos/MainSplash.jpg" class="d-block blur " alt="Inicio" height="400" width="100%">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p class="fs-5 fw-light">He aqui algunos de nuestros libros</p>
                                                <p class="fs-6 fw-light">Recuerda consultar la seccion Libros para poder rentarlos o intercambiarlos</p>
                                            </div>
                                        </div>

                                        <?php
                                        require_once './conexion.php';
                                        $sql = 'select titulo, descripcion, fotografia, autor from libros order by titulo asc';
                                        $sentencia = $conexion->prepare($sql);
                                        $sentencia->execute();
                                        foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $row) {
                                            $titulo = htmlentities($row['titulo']);
                                            $descripcion = htmlentities($row['descripcion']);
                                            $fotografia = htmlentities($row['fotografia']);
                                            $autor = htmlentities($row['autor']);

                                            echo <<<fin
                                            <div class="carousel-item">
                                                    <img src='./fotografias-libros/{$fotografia}' class="d-block" alt="{$titulo}" height="400" width="100%">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <p class="fs-5 fw-light">{$titulo} escrito por {$autor}</p>
                                                    <p class="fs-6 fw-light">{$descripcion}</p>
                                                </div>
                                            </div>
                                            fin;
                                        }
                                        ?>

                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselLibros" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Anterior</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselLibros" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Siguiente</span>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                    <th style="width:40%">
                    <div>
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr style="width:40%">
                                    <th>
                                        <div class="card">
                                            <p class="card-header fs-5 fw-normal"><i class="bi bi-journal-plus"></i> Registro</p>
                                            <div class="card-body">
                                                <p class="fs-6 fw-normal">
                                                    Despues de crear tu perfil, podras agregar tantos libros como gustes, ademas de decidir si el tipo de accion sera intercambio, prestamo o regalo, ademas de decidir el precio por la accion.
                                                </p>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr style="width:60%">
                                    <th>
                                        <div class="card">
                                            <p class="card-header fs-5 fw-normal"><i class="bi bi-people"></i> Comunidad</p>
                                            <div class="card-body">
                                                <p class="fs-6 fw-normal">
                                                CroosBook es una plataforma que esta comprometida con su comunidad, ¿Has notado algo raro?, ¿Tardaron en devolverte tu libro?, ¿Tienes alguna sugerencia?, contacta con algun desarrollador ¡Esperamos tus comentarios! 
                                                </p>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>