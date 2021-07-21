<div class="container-xl">
<nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php"><i class="bi bi-book"></i> CrossBook</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="./index.php"><i class="bi bi-award"></i> Pagina Principal</a>
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
            <!-- <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
        </div>
    </div>
</nav>
</div>