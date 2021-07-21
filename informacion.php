
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de</title>
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
                    <th style="width:55%">
                        <div class="card">
                            <h4 p class="card-header fs-5 fw-normal"><i class="bi-file-person"></i> Desarrolladores</h4></p>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%">
                                                <div class="card" style="width: 12rem;">
                                                    <img src="./recursos/DevUno.png" class="card-img-top" alt="DevOne">
                                                    <div class="card-body">
                                                        <p class="fs-6 fw-normal">Ismael Pasalagua Santana</p>
                                                        <p class="fs-6 fw-light">@DevUno</p>
                                                    </div>
                                                </div>
                                            <th style="width: 30%">
                                                <div class="card" style="width: 12rem;">
                                                    <img src="./recursos/DevDos.png" class="card-img-top" alt="DevOne">
                                                    <div class="card-body">
                                                        <p class="fs-6 fw-normal">Juan Hernandez Puebla</p>
                                                        <p class="fs-6 fw-light">@DevDos</p>
                                                    </div>
                                                </div>
                                            <th style="width: 30%">
                                                <div class="card" style="width: 12rem;">
                                                    <img src="./recursos/DevTres.png" class="card-img-top" alt="DevOne">
                                                    <div class="card-body">
                                                        <p class="fs-6 fw-normal">Luis Eduardo Chavez Salgado</p>
                                                        <p class="fs-6 fw-light">@DevTres</p>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </th>
                    <th style="width:35%">
                        <div class="card">
                            <h4 p class="card-header fs-5 fw-normal"><i class="bi bi-envelope"></i> Contacto</h4></p>
                            <div class="card-body">
                                <p class="fs-6 fw-normal">
                                    En caso de querer <h class="fw-bold">reportar</h> alguna situacion:
                                </p>
                                <p class="fs-6 fw-light">
                                    report@croosbook.com
                                </p>

                                <p class="fs-6 fw-normal">
                                    En caso de tener alguna <h class="fw-bold">sugerencia</h>:
                                </p>
                                <p class="fs-6 fw-light">
                                    feedback@croosbook.com
                                </p>

                                <p class="fs-6 fw-normal">
                                    En caso de necesitar <h class="fw-bold">ayuda</h>:
                                </p>
                                <p class="fs-6 fw-light">
                                    help@croosbook.com
                                </p>

                                <br>
                                <p class="fs-6 fw-normal">
                                    O tambien puedes contactar a traves de otra red:
                                </p>
                                <p class="fs-6 fw-light">
                                    <i class="bi bi-twitter"></i>
                                    @Cross_Book
                                </p>
                                <p class="fs-6 fw-light">
                                    <i class="bi bi-facebook"></i>
                                    /CrossBook
                                </p>

                            </div>
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