<?php
require_once './checa-sesion.php';
require('vendor/autoload.php');
use Rakit\Validation\Validator;
require_once './conexion.php';
if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sql = 'select * from intercambios where id = :id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $intercambio = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (null == $intercambio) {
        require_once './error-no-encontrado.php';
        exit;
    }
    $_POST = array_merge($_POST, $intercambio);
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intercambio</title>
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
                <h5 i class="bi bi-arrow-left-right text-center"></i> Intercambio</h5>
                </div>
                <div class="card-body">
                <?php
                    if ('POST' == $_SERVER['REQUEST_METHOD']) {
                        $validator = new Validator;
                        $validation = $validator->make($_POST, [
                            'contacto_id' => 'required'
                            , 'empleado_id' => 'required'
                            , 'entrada_libro_id' => 'required'
                            , 'salida_libro_id' => 'required'                        
                            , 'fecha_intercambio' => 'required|date:Y-m-d|'
                            , 'costo' => 'required|min:1|max:100'
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
                            <label for="contacto_id" class="form-label">Cliente</label>
                            <select name="contacto_id" id="contacto_id" class="form-select form-select" aria-label=".form-select example" aria-describedby="contactoHelp">
                                <option selected value="">Selecciona</option>
                                <?php
                                $sql = "select id, nombre, perfil from usuarios where perfil='Cliente' order by nombre asc";
                                foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $row) {
                                    $selected = $_POST['contacto_id'] == $row['id'] ? 'selected' : '';
                                    echo <<<fin
                                <option value="{$row['id']}" {$selected}>{$row['nombre']}</option>
fin;
                                }
                                ?>
                            </select>

                            <div class="mb-3">
                            <label for="empleado_id" class="form-label">Empleado</label>
                            <select name="empleado_id" id="empleado_id" class="form-select form-select" aria-label=".form-select example" aria-describedby="empleadoHelp">
                                <option selected value="">Selecciona</option>
                                <?php
                                $sql = "select id, nombre, perfil from usuarios where perfil='Administrador' order by nombre asc";
                                foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $row) {
                                    $selected = $_POST['empleado_id'] == $row['id'] ? 'selected' : '';
                                    echo <<<fin
                                <option value="{$row['id']}" {$selected}>{$row['nombre']}</option>
fin;
                                }
                                ?>
                            </select>

                            <div class="mb-3">
                            <label for="entrada_libro_id" class="form-label">Libro que entra</label>
                            <select name="entrada_libro_id" id="entrada_libro_id" class="form-select form-select" aria-label=".form-select example" aria-describedby="entrada_libroHelp">
                                <option selected value="">Selecciona</option>
                                <?php
                                $sql = 'select id, titulo from libros order by titulo asc';
                                foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $row) {
                                    $selected = $_POST['entrada_libro_id'] == $row['id'] ? 'selected' : '';
                                    echo <<<fin
                                <option value="{$row['id']}" {$selected}>{$row['titulo']}</option>
fin;
                                }
                                ?>
                            </select>

                            <div class="mb-3">
                            <label for="salida_libro_id" class="form-label">Libro que sale</label>
                            <select name="salida_libro_id" id="salida_libro_id" class="form-select form-select" aria-label=".form-select example" aria-describedby="salida_libroHelp">
                                <option selected value="">Selecciona</option>
                                <?php
                                $sql = 'select id, titulo from libros order by titulo asc';
                                foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $row) {
                                    $selected = $_POST['salida_libro_id'] == $row['id'] ? 'selected' : '';
                                    echo <<<fin
                                <option value="{$row['id']}" {$selected}>{$row['titulo']}</option>
fin;
                                }
                                ?>
                            </select>

                            <div class="mb-3">
                                <label for="fecha_intercambio" class="form-label">Fecha del intercambio</label>
                                <input type="date" name="fecha_intercambio" required class="form-control form-control" id="fecha_intercambio" value="<?php echo htmlentities($_POST['fecha_intercambio'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                            <label for="costo" class="form-label">Costo</label>
                            <input type="text" name="costo" required class="form-control form-control" id="costo" value="<?php echo htmlentities($_POST['costo'] ?? '') ?>">
                            </div>
                        
                            <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-outline-primary">Enviar</button>
                            <a href="intercambios.php" class="btn btn-outline-danger">Cancelar</a>
                            </div>
                    </form>
                    <?php
                    } else {
                        // es post y todo está bien
                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                            //actualizamos registro en tabla libros
                            $sql = <<<fin
                            update intercambios set
                            contacto_id = :contacto_id
                            , empleado_id = :empleado_id
                            , entrada_libro_id = :entrada_libro_id
                            , salida_libro_id = :salida_libro_id
                            , fecha_intercambio = :fecha_intercambio
                            , costo = :costo
                            where id = :id
fin;
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':contacto_id', $_REQUEST['contacto_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':empleado_id', $_REQUEST['empleado_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':entrada_libro_id', $_REQUEST['entrada_libro_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':salida_libro_id', $_REQUEST['salida_libro_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':fecha_intercambio', $_REQUEST['fecha_intercambio'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo', $_REQUEST['costo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
                            $sentencia->execute();
                            echo '<h6>Intercambio modificado</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="intercambios.php" class="btn btn-outline-success"><i class="bi-book"></i>   Intercambios</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a>
                            </div>';
                        } else {
                            //creamos
                            $sql = <<<fin
insert into intercambios
    (
        contacto_id
        , empleado_id
        , entrada_libro_id
        , salida_libro_id
        , fecha_intercambio
        , costo
    )
    values
    (
        :contacto_id
        , :empleado_id
        , :entrada_libro_id
        , :salida_libro_id
        , :fecha_intercambio
        , :costo
    )
fin;
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':contacto_id', $_REQUEST['contacto_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':empleado_id', $_REQUEST['empleado_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':entrada_libro_id', $_REQUEST['entrada_libro_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':salida_libro_id', $_REQUEST['salida_libro_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':fecha_intercambio', $_REQUEST['fecha_intercambio'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo', $_REQUEST['costo'], PDO::PARAM_STR);
                            $sentencia->execute();
                            echo '<h6>Intercambio generado</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="intercambios.php" class="btn btn-success"><i class="bi-plus-lg"></i>   Generar otro</a>
                            <a href="intercambios.php" class="btn btn-outline-success"><i class="bi-book"></i>   Intercambios</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a>
                            </div>';
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
<script src="js/jquery-3.6.0.min.js"></script>
<script>
</script>
</body>
</html>