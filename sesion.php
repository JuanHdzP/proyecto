<?php
require_once('vendor/autoload.php');
// ¿se intenta iniciar sesión y los parámetros se han proporcionado?
if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['correo_electronico']) && isset($_POST['contrasena'])) {
    require_once './conexion.php';
    $sql = 'select id, nombre, correo_electronico, perfil, estatus, contrasena from usuarios where correo_electronico = :correo_electronico and estatus = \'Activo\'';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':correo_electronico', $_POST['correo_electronico'], PDO::PARAM_STR);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (null == $usuario) {
        require_once './error-no-encontrado.php';
        exit;
    }
    // ¿contraseña válida?
    if (password_verify($_POST['contrasena'], $usuario['contrasena'])) {
        // iniciar sesión y guardar datos
        $session_factory = new Aura\Session\SessionFactory;
        $session = $session_factory->newInstance($_COOKIE);
        $segment = $session->getSegment('viajes_experienciales');
        $segment->set('id', $usuario['id']);
        $segment->set('nombre', $usuario['nombre']);
        $segment->set('correo_electronico', $usuario['correo_electronico']);
        $segment->set('perfil', $usuario['perfil']);
        $segment->set('estatus', $usuario['estatus']);
        header('Location: index.php');
    } else {
        header('Location: sesion.php?mensaje=Contraseña incorrecta');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <?php
    require_once './menu.php';
    ?>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Inicio de sesión
                    </div>
                    <div class="card-body">
                        <form action="sesion.php" method="post">
                            <div class="mb-3">
                                <label for="correo_electronico" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control form-control-sm" name="correo_electronico" id="correo_electronico" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control form-control-sm" name="contrasena" id="contrasena" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>