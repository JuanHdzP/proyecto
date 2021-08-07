<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
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
                    <?php
                        require('vendor/autoload.php');
                        require_once './conexion.php';
                        if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_GET['key']) && isset($_GET['correo']) && isset($_GET['action']) && ($_GET['action'] == 'reset') && !isset($_POST['action'])) {
                            $contrasena = $_GET["key"];
                            $correo = $_GET["email"];
                            $fecha_actual = date("Y-m-d H:i:s");
                            $sql = mysqli_query($conexion, "SELECT * FROM `contrasena_nueva` WHERE `contrasena`='" . $contrasena . "' and `correo`='" . $correo . "';");
                            $row = mysqli_num_rows($sql);
                            if ($row == "") {
                                $error .= '<h2>Enlace invalido</h2>';
                            } else {
                                $row = mysqli_fetch_assoc($sql);      
                                $fecha = $row['fecha'];
                            if ($fecha >= $fecha_actual) {
                        ?>
                                <div class="card">
                                    <div class="card-header">
                                            <h4 i class="bi-tools"></i>    Recuperar contraseña</h4>
                                            <form method="post" action="" name="update">
                                                <input type="hidden" name="action" value="update" class="form-control"/>
                                                <div class="form-group">
                                                    <label>Ingresa nueva contraseña</label>
                                                    <input type="password"  name="pass1" value="<?php echo htmlentities($_POST['update'] ?? '') ?>" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Reingresar contraseña</label>
                                                    <input type="password"  name="pass2" value="<?php echo htmlentities($_POST['update'] ?? '') ?>" class="form-control"/>
                                                </div>
                                                <input type="hidden" name="correo" value="<?php echo $correo; ?>"/>
                                                <div class="d-grid gap-2 form-group">
                                                    <input type="submit" id="reset" value="Cambiar contraseña"  class="btn btn-primary"/>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                                            <?php
                                        } else {
                                            echo "<strong>Este enlace ha expirado</strong>";
                                        }
                                    }
                                if (isset($_POST['correo']) && isset($_POST['action']) && ($_POST['action'] == 'update')) {
                                    $correo = $_POST['correo'];
                                    if ($pass1 != $pass2) {
                                        echo "<p>Las contraseñas no coincide, ambas deben ser iguales.<br/><br/></p>";
                                    }
                                    else {
                                        $pass1 = password_hash($_POST['pass1'], PASSWORD_BCRYPT,);
                                        $sql1= <<<fin
                                        update usuarios set
                                        contrasena = :contrasena
                                        where
                                        correo = :correo
            fin;                        
                                        $sentencia = $conexion->prepare($sql1);
                                        $sentencia->bindValue(':correo', $_REQUEST['correo'], PDO::PARAM_STR);
                                        $sentencia->bindValue(':contrasena', $pass1, PDO::PARAM_STR);
                                        $sentencia->execute();
                                        $sql2=<<<fin
                                        delete from 
                                        contrasena_nueva WHERE 
                                        correo = :correo
            fin; 
                                        $sentencia = $conexion->prepare($sql2);
                                        $sentencia->bindValue(':correo', $_REQUEST['correo'], PDO::PARAM_STR);
                                        $sentencia->execute();
                                        echo '<div class="error"><p>¡Felicidades! Su contraseña se ha actualizado correctamente.</p>
                                        <div class="d-grid gap-2">
                                        <a href="sesion.php" class="btn btn-outline-success"><i class="bi-door-open-fill"></i>   Iniciar sesion</a>
                                        <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a>
                                        </div>';
                                    }
                                }
                            }
                                ?>
                </div>
            </div>
    </body>
</html>