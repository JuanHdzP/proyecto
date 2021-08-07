<?php
require_once './checa-sesion.php';
require('vendor/autoload.php');
use Rakit\Validation\Validator;
if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_GET['id']) && is_numeric($_GET['id'])) {
    require_once './conexion.php';
    $sql = 'select id, editorial from editoriales where id = :id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $editorial = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (null == $editorial) {
        require_once './error-no-encontrado.php';
        exit;
    }
    $_POST = array_merge($_POST, $editorial);
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear editorial</title>
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
            <div class="card">
                <div class="card-header">
                <h5 i class="bi-printer text-center"></i> Crear editorial </h5>
                </div>
                <div class="card-body">
                    <?php
                    if ('POST' == $_SERVER['REQUEST_METHOD']) {
                        $validator = new Validator;
                        $validation = $validator->make($_POST, [
                            'editorial' => 'required|min:2|max:50'
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
                    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="editorial" class="form-label">Editorial</label>
                            <input type="text" name="editorial" class="form-control form-control-sm<?php echo isset($errors) && $errors->has('editorial') ? ' is-invalid' : 'is-valid' ?>" id="editorial" aria-describedby="categoriaHelp" value="<?php echo $_POST['editorial'] ?? '' ?>">
                            <div id="editorialHelp" class="invalid-feedback"><?php echo isset($errors) && $errors->first('editorial') ?></div>
                        </div>
                        <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-secondary">Enviar</button>
                        <a href="editoriales.php" class="btn btn-outline-danger">Cancelar</a>
                    </div>
                    </form>
                    <?php
                    } else {
                        // es post y todo está bien
                        require_once './conexion.php';
                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                            //actualizamos
                            $sql = 'update editoriales set editorial = :editorial where id = :id';
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':editorial', $_POST['editorial'], PDO::PARAM_STR);
                            $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
                            $sentencia->execute();
                            echo '<h6>Editorial actualizada</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="editoriales.php" class="btn btn-outline-secondary"><i class="bi-printer"></i>   Editoriales</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a></div>';
                        } else {
                            //creamos
                            $sql = 'insert into editoriales (editorial) values (:editorial)';
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':editorial', $_POST['editorial'], PDO::PARAM_STR);
                            $sentencia->execute();
                            echo '<h6>Editorial creada</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="editorial.php" class="btn btn-secondary"><i class="bi-plus-lg"></i>   Crear otra</a>
                            <a href="editoriales.php" class="btn btn-outline-secondary"><i class="bi-printer"></i>   Editoriales</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a></div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>