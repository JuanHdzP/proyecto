<?php
require_once './checa-sesion.php';
require('vendor/autoload.php');
use Rakit\Validation\Validator;
require_once './conexion.php';
$accion = 'Crear usuario';
if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $accion = 'Editar usuario';
    $sql = 'select id, nombre, primer_apellido, segundo_apellido, sexo, fecha_nacimiento, correo_electronico, contrasena, perfil, estatus, celular from usuarios where id = :id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (null == $usuario) {
        require_once './error-no-encontrado.php';
        exit;
    }
    $_POST = array_merge($_POST, $usuario);
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlentities($accion) ?></title>
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
                    <h5 i class="bi-people text-center"></i> <?php echo htmlentities($accion) ?></h5>
                </div>
                <div class="card-body">
                <?php
                    if ('POST' == $_SERVER['REQUEST_METHOD']) {
                        // validamos los datos
                        $validator = new Validator;
                        $validation = $validator->make($_POST, [
                            'nombre' => 'required|min:4|max:45'
                            , 'primer_apellido' => 'required|min:4|max:45'
                            , 'segundo_apellido' => 'nullable|max:45'
                            , 'sexo' => 'required|in:Femenino,Masculino'
                            , 'fecha_nacimiento' => 'required|date:Y-m-d|before:yesterday'
                            , 'correo_electronico' => 'required|email'
                            , 'contrasena' => 'nullable|min:8'
                            , 'contrasena_confirma' => 'nullable|same:contrasena'
                            , 'perfil' => 'required|in:Administrador,Cliente'
                            , 'estatus' => 'required|in:Activo,Inactivo'
                            , 'celular' => 'required|min:10|max:45'
                        ]);
                        $validation->setMessages([
                            'required' => ':attribute es requerido'
                            , 'min' => ':attribute longitud mínima no se cumple'
                            , 'max' => ':attribute longitud máxima no se cumple'
                        ]);
                        // then validate
                        $validation->validate();
                        $errors = $validation->errors();
                    }
                    if ('GET' == $_SERVER['REQUEST_METHOD'] || $validation->fails()) {
                    ?>
                    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre(s)</label>
                            <input type="text" name="nombre" required class="form-control form-control-sm" id="nombre" value="<?php echo htmlentities($_POST['nombre'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="primer_apellido" class="form-label">Primer apellido</label>
                            <input type="text" name="primer_apellido" required class="form-control form-control-sm" id="primer_apellido" value="<?php echo htmlentities($_POST['primer_apellido'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="segundo_apellido" class="form-label">Segundo apellido</label>
                            <input type="text" name="segundo_apellido" required class="form-control form-control-sm" id="segundo_apellido" value="<?php echo htmlentities($_POST['segundo_apellido'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="sexo1" class="form-label">Sexo</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo1" value="Femenino" <?php echo 'Femenino' == ($_POST['sexo'] ?? '') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="sexo1">
                                        Femenino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo2" value="Masculino" <?php echo 'Masculino' == ($_POST['sexo'] ?? '') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="sexo2">
                                        Masculino
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" required class="form-control form-control-sm" id="fecha_nacimiento" value="<?php echo htmlentities($_POST['fecha_nacimiento'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Correo electrónico</label>
                            <input type="email" name="correo_electronico" required class="form-control form-control-sm" id="correo_electronico" value="<?php echo htmlentities($_POST['correo_electronico'] ?? '') ?>">
                        </div>
                        <?php
                        if ('Editar usuario' == $accion) {
                            echo <<<fin
                        <div class="alert alert-dark" role="alert">
                            Solo si deseas cambiar la contraseña
                        </div>
fin;
                        }
                        ?>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" name="contrasena" class="form-control form-control-sm" id="contrasena">
                        </div>
                        <div class="mb-3">
                            <label for="contrasena_confirma" class="form-label">Contraseña (confirma)</label>
                            <input type="password" name="contrasena_confirma" class="form-control form-control-sm" id="contrasena_confirma">
                        </div>
                        <div class="mb-3">
                            <label for="perfil1" class="form-label">Perfil</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="perfil" id="perfil1" value="Administrador" <?php echo 'Administrador' == ($_POST['perfil'] ?? '') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="perfil1">
                                        Administrador
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="perfil" id="perfil2" value="Cliente" <?php echo 'Cliente' == ($_POST['perfil'] ?? '') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="perfil2">
                                        Cliente
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="estatus1" class="form-label">Estatus</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estatus" id="estatus1" value="Activo" <?php echo 'Activo' == ($_POST['estatus'] ?? '') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="estatus1">
                                        Activo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estatus" id="estatus2" value="Inactivo" <?php echo 'Inactivo' == ($_POST['estatus'] ?? '') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="estatus2">
                                        Inactivo
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label for="celular" class="form-label">Celular</label>
                                    <input type="tel" name="celular" required class="form-control form-control-sm" id="celular" value="<?php echo htmlentities($_POST['celular'] ?? '') ?>">
                                </div>
                                <div id="grupo-documentacion" style="display:none">
                                    <div class="alert alert-secondary" role="alert">
                                        Documentación requerida
                                    </div>
                                    <table class="table table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width:50%;">Identificación</th>
                                                <th style="width:50%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="file" class="form-control form-control-sm" name="archivo1" accept=".jpg">
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width:50%;">Comprobante de domicilio</th>  
                                                <th style="width:50%;"></th>                    
                                            </tr>
                                        </thead>
                                    <tbody>
                                    <tr>
                                    <td colspan="2">
                                    <input type="file" class="form-control form-control-sm" name="archivo2" accept=".jpg">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                         <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>                             
                                    <th style="width:50%;">Carta aval 1</th>  
                                    <th style="width:50%;"></th>                                                     
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                    <input type="file" class="form-control form-control-sm" name="archivo3" accept=".jpg">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                            <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="width:50%;">Carta aval 2</th>
                                    <th style="width:50%;"></th>                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                    <input type="file" class="form-control form-control-sm" name="archivo4" accept=".jpg">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-danger">  Enviar</button>
                        <a href="usuarios.php" class="btn btn-danger">  Cancelar</a>
                    </div>
                    </form>
                    <?php
                    } else {
                        // es post y todo está bien
                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                            //actualizamos
                        $sql = <<<fin
                        update usuarios set
                            nombre = :nombre
                            , primer_apellido = :primer_apellido
                            , segundo_apellido = :segundo_apellido 
                            , sexo = :sexo
                            , fecha_nacimiento = :fecha_nacimiento 
                            , correo_electronico = :correo_electronico 
                            , contrasena = :contrasena
                            , perfil = :perfil
                            , estatus = :estatus
                            , celular = :celular 
                            , comprobante_domicilio = :comprobante_domicilio 
                            , identificacion = :identificacion 
                            , carta_aval_1 = :carta_aval_1 
                            , carta_aval_2 = :carta_aval_2
                        where
                            id = :id
fin;
                            // ¿cambiar contraseña?
                            if(!$errors->has('contrasena') && !$errors->has('contrasena_confirma') && !empty($_POST['contrasena'])) {
                                $opciones = [
                                    'cost' => 12,
                                ];
                                $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT, $opciones);
                            } else {
                                // dejamos la misma contraseña
                                $sentencia = $conexion->prepare('select contrasena from usuarios where id = :id');
                                $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
                                $sentencia->execute();
                                $contrasena = $sentencia->fetchColumn(0);
                            }
                            if(is_uploaded_file($_FILES['archivo1']['tmp_name'])) {
                                $nombre_archivo1 = uniqid('ID-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                move_uploaded_file($_FILES['archivo1']['tmp_name'], './documentacion-imgs/' . $nombre_archivo1);
                            }
                            else{
                                $nombre_archivo1 = "";
                            }
                            if (is_uploaded_file($_FILES['archivo2']['tmp_name'])) {
                                $nombre_archivo2 = uniqid('CD-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                // mover archivo a su ubicación final
                                move_uploaded_file($_FILES['archivo2']['tmp_name'], './documentacion-imgs/' . $nombre_archivo2);
                            }
                            else{
                                $nombre_archivo2 = "";
                            }
                            if (is_uploaded_file($_FILES['archivo3']['tmp_name'])) {
                                $nombre_archivo3 = uniqid('CA1-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                // mover archivo a su ubicación final
                                move_uploaded_file($_FILES['archivo3']['tmp_name'], './documentacion-imgs/' . $nombre_archivo3);
                            }
                            else{
                                $nombre_archivo3 = "";
                            }
                            if (is_uploaded_file($_FILES['archivo4']['tmp_name'])) {
                                $nombre_archivo4 = uniqid('CA2-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                // mover archivo a su ubicación final
                                move_uploaded_file($_FILES['archivo4']['tmp_name'], './documentacion-imgs/' . $nombre_archivo4);
                            }
                            else{
                                $nombre_archivo4 = "";
                            }
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':nombre', $_REQUEST['nombre'], PDO::PARAM_STR);
                            $sentencia->bindValue(':primer_apellido', $_REQUEST['primer_apellido'], PDO::PARAM_STR);
                            $sentencia->bindValue(':segundo_apellido', $_REQUEST['segundo_apellido'], PDO::PARAM_STR);
                            $sentencia->bindValue(':sexo', $_REQUEST['sexo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':fecha_nacimiento', $_REQUEST['fecha_nacimiento'], PDO::PARAM_STR);
                            $sentencia->bindValue(':correo_electronico', $_REQUEST['correo_electronico'], PDO::PARAM_STR);
                            $sentencia->bindValue(':contrasena', $contrasena, PDO::PARAM_STR);
                            $sentencia->bindValue(':perfil', $_REQUEST['perfil'], PDO::PARAM_STR);
                            $sentencia->bindValue(':estatus', $_REQUEST['estatus'], PDO::PARAM_STR);
                            $sentencia->bindValue(':celular', $_REQUEST['celular'], PDO::PARAM_STR);
                            $sentencia->bindValue(':identificacion', $nombre_archivo1, PDO::PARAM_STR);
                            $sentencia->bindValue(':comprobante_domicilio', $nombre_archivo2, PDO::PARAM_STR);
                            $sentencia->bindValue(':carta_aval_1', $nombre_archivo3, PDO::PARAM_STR);
                            $sentencia->bindValue(':carta_aval_2', $nombre_archivo4, PDO::PARAM_STR);
                            $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
                            $sentencia->execute();
                            echo '<h6>Usuario actualizado</h6>';
                            echo '<div class="d-grid gap-2"><a href="usuarios.php" class="btn btn-outline-danger"><i class="bi-people"></i>   Usuarios</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a></div>';
                        } else {
                            //creamos
                            $sql = <<<fin
                            insert into usuarios (
                                nombre
                                , primer_apellido
                                , segundo_apellido 
                                , sexo
                                , fecha_nacimiento 
                                , correo_electronico 
                                , contrasena
                                , perfil
                                , estatus
                                , celular
                                , comprobante_domicilio 
                                , identificacion 
                                , carta_aval_1 
                                , carta_aval_2
                            ) values (
                                :nombre
                                , :primer_apellido
                                , :segundo_apellido 
                                , :sexo
                                , :fecha_nacimiento 
                                , :correo_electronico 
                                , :contrasena
                                , :perfil
                                , :estatus
                                , :celular
                                , :comprobante_domicilio 
                                , :identificacion 
                                , :carta_aval_1 
                                , :carta_aval_2
                            )
fin;
                            if (is_uploaded_file($_FILES['archivo1']['tmp_name'])) {
                                $nombre_archivo1 = uniqid('ID-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                // mover archivo a su ubicación final
                                move_uploaded_file($_FILES['archivo1']['tmp_name'], './documentacion-imgs/' . $nombre_archivo1);
                            }
                            else{
                                $nombre_archivo1 = "";
                            }
                            if (is_uploaded_file($_FILES['archivo2']['tmp_name'])) {
                                $nombre_archivo2 = uniqid('CD-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                // mover archivo a su ubicación final
                                move_uploaded_file($_FILES['archivo2']['tmp_name'], './documentacion-imgs/' . $nombre_archivo2);
                            }
                            else{
                                $nombre_archivo2 = "";
                            }
                            if (is_uploaded_file($_FILES['archivo3']['tmp_name'])) {
                                $nombre_archivo3 = uniqid('CA1-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                // mover archivo a su ubicación final
                                move_uploaded_file($_FILES['archivo3']['tmp_name'], './documentacion-imgs/' . $nombre_archivo3);
                            }
                            else{
                                $nombre_archivo3 = "";
                            }
                            if (is_uploaded_file($_FILES['archivo4']['tmp_name'])) {
                                $nombre_archivo4 = uniqid('CA2-', true) . '.jpg'; // se supone sólo se admiten .jpg
                                // mover archivo a su ubicación final
                                move_uploaded_file($_FILES['archivo4']['tmp_name'], './documentacion-imgs/' . $nombre_archivo4);
                            }
                            else{
                                $nombre_archivo4 = "";
                            }
                            // Encriptamos la contraseña
                            $opciones = [
                                'cost' => 12,
                            ];
                            $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT, $opciones);
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':nombre', $_REQUEST['nombre'], PDO::PARAM_STR);
                            $sentencia->bindValue(':primer_apellido', $_REQUEST['primer_apellido'], PDO::PARAM_STR);
                            $sentencia->bindValue(':segundo_apellido', $_REQUEST['segundo_apellido'], PDO::PARAM_STR);
                            $sentencia->bindValue(':sexo', $_REQUEST['sexo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':fecha_nacimiento', $_REQUEST['fecha_nacimiento'], PDO::PARAM_STR);
                            $sentencia->bindValue(':correo_electronico', $_REQUEST['correo_electronico'], PDO::PARAM_STR);
                            $sentencia->bindValue(':contrasena', $contrasena, PDO::PARAM_STR);
                            $sentencia->bindValue(':perfil', $_REQUEST['perfil'], PDO::PARAM_STR);
                            $sentencia->bindValue(':estatus', $_REQUEST['estatus'], PDO::PARAM_STR);
                            $sentencia->bindValue(':celular', $_REQUEST['celular'], PDO::PARAM_STR);
                            $sentencia->bindValue(':comprobante_domicilio', $nombre_archivo2, PDO::PARAM_STR);
                            $sentencia->bindValue(':identificacion', $nombre_archivo1, PDO::PARAM_STR);
                            $sentencia->bindValue(':carta_aval_1', $nombre_archivo3, PDO::PARAM_STR);
                            $sentencia->bindValue(':carta_aval_2', $nombre_archivo4, PDO::PARAM_STR);
                            $sentencia->execute();
                            echo '<h6>Usuario creado</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="usuario.php" class="btn btn btn-danger"><i class="bi-plus-lg"></i>   Crear otro</a>
                            <a href="usuarios.php" class="btn btn-outline-danger"><i class="bi-people"></i>   Usuarios</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a></div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-3.6.0.min.js"></script>
<script>
$(function (e){
    $('[name="perfil"]').click(function(e){
        if('Administrador'== $(this).val()){
            $('#grupo-documentacion').hide();
        }else{
            $('#grupo-documentacion').show();
        }
    })
})
</script>
</body>
</html>