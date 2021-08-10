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
    <div class="container">
    <div class="row justify-content-center">
    <div class="col-5">
                        <?php
                    include('conexion.php');
                    if (isset($_GET["key"]) && isset($_GET["correo"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
                        $contrasena = $_GET["key"];
                        $correo = $_GET["correo"];
                        $fecha_actual = date("Y-m-d H:i:s");
                        $sql ="SELECT * FROM contrasena_nueva WHERE contrasena='" . $contrasena . "' and correo='" . $correo . "';";
                        $sentencia = $conexion->prepare($sql);
                        $sentencia->execute();
                        $user = $sentencia->fetch(PDO::FETCH_ASSOC);                      
                        if (null == $user) {
                            require_once './error-no-encontrado.php';                                                                                    
                        } else {
                            $fecha = $user['fecha'];
                            if ($fecha >= $fecha_actual) {
                                ?> 
                            <div class="card">
                            <div class="card-header text-center">
                                    <h4 i class="bi-tools"></i>    Recuperar contraseña</h4>
                                    <form method="post" action="" name="update">
                                        <input type="hidden" name="action" value="update" class="form-control"/>
                                        <div class="form-group">
                                            <label>Ingresa nueva contraseña</label>
                                            <input type="password"  name="pass1" value="update" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Reingresar contraseña</label>
                                            <input type="password"  name="pass2" value="update" class="form-control"/>
                                        </div>
                                        <input type="hidden" name="correo" value="<?php echo $correo; ?>"/>
                                        <div class="d-grid gap-2 form-group">
                                            <input type="submit" id="reset" value="Cambiar contraseña"  class="btn btn-primary"/>
                                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a>
                                        </div>
                                    </form>
                                    <?php
                                } else {
                                    echo "<strong>Este enlace ha expirado</strong>";
                                }
                            }
                                if ($error != "") {
                                    echo "<div class='error'>" . $error . "</div><br />";
                                }
                    }                                                                                 
                                    if (isset($_POST["correo"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
                                        $error = "";
                                        $pass1 = $_POST["pass1"];
                                        $pass2 = $_POST["pass2"];                                        
                                        $correo = $_POST["correo"];
                                        $curDate = date("Y-m-d H:i:s");
                                        if ($pass1 != $pass2) {
                                        echo "<p>Las contraseñas no coincide, ambas deben ser iguales.<br/><br/></p>";
                                        }else {
                                        $pass1 = password_hash($_POST['pass1'], PASSWORD_BCRYPT,);
                                        $sql1= <<<fin
                                        update usuarios set
                                        contrasena = :contrasena
                                        where
                                        correo_electronico = :correo
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
                                        echo '<div class="error">
                                        <div class="card">
                                        <div class="card-header">
                                            <h5 i class="bi bi-exclamation-lg text-center"></i>  Contraseña actualizada
                                        </div>
                                        <div class="card-body">
                                            <p class="text-center">¡Felicidades! Su contraseña se ha actualizado correctamente.</p>
                                            <div>
                                            <div class="d-grid gap-2">
                                            <a href="sesion.php" class="btn btn-outline-success"><i class="bi-door-open-fill"></i>  Inicio de sesión</a>
                                            <a href="index.php" class="btn btn-outline-dark float-end">
                                            <i class="bi-house-door-fill"></i>   Inicio</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>                                                                        
                                        </div>';
                                    }
                                }                            
                                ?>
                </div>
            </div>
    </body>
</html>