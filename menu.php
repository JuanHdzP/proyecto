        <br><br><br><br>
        <div class="text-center"><img src="recursos/logo.png" alt="Logo" width="500"></div>
        <br>
        <nav class="navbar navbar-expand fixed-top navbar-dark bg-dark">
            <div class="container-fluid">               
                    <ul class="navbar-nav mx-auto">
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
        </nav>
        