    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/estilos.css">
        <br><br><br><br>
        <div class="text-center"><img src="recursos/logo.png" alt="Logo" width="500"></div>
        <br>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark lighten-4">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCenteredExample"
                aria-controls="navbarCenteredExample" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarCenteredExample">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./index.php"><i class="bi bi-award"></i> Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./libros.php"><i class="bi bi-book"></i> Libros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./temas.php"><i class="bi bi-bookmark-heart"></i> Temas</a>
                         </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./editoriales.php"><i class="bi bi-printer"></i> Editoriales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./prestamos.php"><i class="bi bi-arrows-angle-contract"></i> Préstamos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./intercambios.php"><i class="bi bi-arrow-left-right"></i> Intercambios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./ubicanos.php"><i class="bi bi-pin-map-fill"></i> Ubícanos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./informacion.php"><i class="bi bi-code-slash"></i> Acerca De</a>
                        </li>
                        <!--
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Catálogos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="categorias.php"><i class="bi-ui-checks"></i> Categorías</a></li>
                                <li><a class="dropdown-item" href="lugares-magicos.php"><i class="bi-binoculars-fill"></i> Lugares mágicos</a></li>
                                <li><a class="dropdown-item" href="viajes-experienciales.php"><i class="bi-cloud-moon"></i> Viajes experienciales</a></li>
                                <li><a class="dropdown-item" href="usuarios.php"><i class="bi-person-circle"></i> Usuarios</a></li>
                            </ul>
                        </li>
                        -->
                        <form method="POST" class="navbar-form" action="buscar.php">
                            <div class="input-group md-form my-0">
                                <input type="text" class="form-control rounded mr-sm-2" id="navbar-search-input" name="palabra" placeholder="Buscar libro" required>
                                <span class="input-group-text input-sm text-black rounded" id="search">                            
                                    <button class="btn btn-sm" type="submit"><i class="bi bi-search"></i></button>
                                </span>
                            </div>
                        </form>
                        <?php
                            if(isset($segment) && !empty($segment->get('id'))) {
                                echo <<<fin
                                <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="salir.php"><i class="bi bi-x-square"></i> Cerrar sesión</a>
                                </li>
fin;
                            }
                            ?>
                    </ul>
                </div>
            </div>
        </nav>