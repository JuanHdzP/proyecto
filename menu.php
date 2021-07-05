<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Cross book</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="dropdown-item" href="index.php"><i class="bi-house"></i> Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        ¿Algo en particular?
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="usuarios.php"><i class="bi-person-circle"></i> Usuarios</a></li>
                        <li><a class="dropdown-item" href="editoriales.php"><i class="bi-printer"></i> Editoriales</a></li>
                        <li><a class="dropdown-item" href="libros.php"><i class="bi-book"></i> Libros</a></li>
                        <li><a class="dropdown-item" href="temas.php"><i class="bi-stars"></i> Temas</a></li>
                    </ul>
                </li>
                <?php
                if(isset($segment) && !empty($segment->get('id'))) {
                    echo <<<fin
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="salir.php">Cerrar sesión</a>
                </li>
fin;
                }
                ?>
            </ul>
            <!-- <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
        </div>
    </div>
</nav>