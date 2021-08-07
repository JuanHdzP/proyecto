<?php
use PHPMailer\PHPMailer\PHPMailer;
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña olvidada</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
<?php
require_once './menu.php';
?>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="card">
                    <div class="card-header text-center">
                    <h4 i class="bi-tools"></i>    ¿Olvidaste tu contraseña?</h4>
                    <?php
                    require_once './conexion.php';
                    if (isset($_POST["correo"]) && (!empty($_POST["correo"]))) {
                        $correo = $_POST["correo"];
                        $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
                        $correo = filter_var($correo, FILTER_VALIDATE_EMAIL);
                        if (!$correo) {
                            echo "Correo invalido";
                        } else {
                            $sql = "SELECT * FROM `usuarios` WHERE correo_electronico='" . $correo . "'";
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->execute();
                            $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                            if ($row == "") {
                                echo "Usuario no encontrado";
                            }
                        }
                        if ($error != "") {
                            echo "Error";
                        } else {
                            $output = '';
                            $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
                            $expDate = date("Y-m-d H:i:s", $expFormat);
                            $key = md5(time());
                            $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
                            $key = $key . $addKey;
                            $sql = "INSERT INTO `contrasena_nueva` (`correo`, `contrasena`, `fecha`) VALUES ('" . $correo . "', '" . $key . "', '" . $expDate . "');";
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->execute();
                            $output.='<p>Haga clic en el siguiente enlace para reestablecer su contraseña.</p>';
                            $output.='<p><a href="http://localhost:8080/proyecto/recuperar_contrasena.php?key=' . $key . '&email=' . $correo . '&action=reset" target="_blank">http://localhost:8080/proyecto/recuperar_contrasena.php?key=' . $key . '&email=' . $correo . '&action=reset</a></p>';
                            $body = $output;
                            $subject = "Recuperación de contraseña";
                            $email_to = $correo;
                            $correo = new PHPMailer();
                            $correo->IsSMTP();
                            $correo->Host = 'smtp.mailtrap.io';
                            $correo->SMTPAuth = true;
                            $correo->Port = 2525;
                            $correo->Username = "b4ef166d57cf89";
                            $correo->Password = '78ff571d78f2da';
                            $correo->IsHTML(true);
                            $correo->From = "soporte@croosbook.com";
                            $correo->FromName = "Cross Book";
                            $correo->Subject = $subject;
                            $correo->Body = $body;
                            $correo->AddAddress($email_to);
                            if (!$correo->Send()) {
                                echo "Mailer Error: " . $correo->ErrorInfo;
                            } else {
                                echo "<strong>Te hemos enviado un email al correo ingresado. Solo haz clic en el enlace incluido en el mensaje para elegir una nueva contraseña.</strong>";
                            }
                        }
                    }
                    ?>
                    <div class="card-body">
                    <form method="post" action="" name="reset">                  
                        <div class="form-group">
                           <label>Ingresa tu correo electrónico asociado con la cuenta</label>
                            <input type="correo" name="correo" placeholder="usuario@correo.com" class="form-control">
                        </div>
                        <br>
                        <div class="d-grid gap-2">
                        <input class="btn btn-primary" type="submit" id="reset" value="Enviar" >
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a>
                            </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </body>
</html>