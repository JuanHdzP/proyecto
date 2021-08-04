<?php
require_once './menu.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurso no encontrado</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                <i class="bi bi-exclamation-lg"></i>  Usuario no encontrado
                </div>
                <div class="card-body">
                    Usuario no es administrador o la contraseña/usuario son incorrectos                    
                    <div>
                    <div class="d-grid gap-2">
                    <a href="sesion.php" class="btn btn-outline-success"><i class="bi-door-open-fill"></i>  Inicio de sesión</a>
                <a href="index.php" class="btn btn-outline-dark float-end">
                    <i class="bi-house-door-fill"></i>   Inicio</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>