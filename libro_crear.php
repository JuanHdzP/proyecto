<?php
//print_r($_REQUEST);
// exit;
require_once './checa-sesion.php';
require('vendor/autoload.php');
use Rakit\Validation\Validator;
require_once './conexion.php';
if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sql = 'select id, editorial_id, titulo, autor, descripcion, accion, existencias, costo_prestamo_dia, costo_libro_nuevo from libros where id = :id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $libro = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (null == $libro) {
        require_once './error-no-encontrado.php';
        exit;
    }
    $libro['accion'] = explode(',',$libro['accion']);
    $_POST = array_merge($_POST, $libro);
    // Obtenemos también los ids de los temas que están asociados
    $sql = 'select tema_id from libros_temas where libro_id = :id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $temas_id = [];
    foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $temas_id[] = $row['tema_id'];
    }
    $_POST['tema_id'] = $temas_id;
} else {
    $_POST['titulo'] = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $_POST['tema_id'] = isset($_POST['tema_id']) ? $_POST['tema_id'] : [];
    $_POST['autor'] = isset($_POST['autor']) ? $_POST['autor'] : '';
    $_POST['descripcion'] = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $_POST['tema_id'] = isset($_POST['tema_id']) ? $_POST['tema_id'] : [];
    $_POST['accion'] = isset($_POST['accion']) ? $_POST['accion'] : [];
    $_POST['existencias'] = isset($_POST['existencias']) ? $_POST['existencias'] : '';
    $_POST['costo_prestamo_dia'] = isset($_POST['costo_prestamo_dia']) ? $_POST['costo_prestamo_dia'] : '';
    $_POST['costo_libro_nuevo'] = isset($_POST['costo_libro_nuevo']) ? $_POST['costo_libro_nuevo'] : '';
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear libro</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
<?php
require_once './menu.php';
?>
<div class="container mt-3">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                <h5 i class="bi bi-book text-center"></i> Crear libro</h5>
                </div>
                <div class="card-body">
                <?php
                    if ('POST' == $_SERVER['REQUEST_METHOD']) {
                        //print_r($_POST);
                        //exit;
                        // validamos los datos
                        $validator = new Validator;
                        $validation = $validator->make($_POST, [
                            'editorial_id' => 'required'
                            , 'titulo' => 'required|min:2|max:100'
                            , 'autor' => 'required|min:2|max:100'
                            , 'descripcion' => 'required'
                            , 'accion' => 'required'
                            , 'autor' => 'required|min:2|max:100'
                            , 'existencias' => 'required|integer|min:1|max:100'
                            , 'costo_prestamo_dia' => 'required|min:1|max:100'
                            , 'costo_libro_nuevo' => 'required|min:1|max:100'
                            // , 'categoria_id' => 'required|array'
                            // , 'categoria_id.*' => 'integer'
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
                            <label for="titulo" class="form-label">Título del libro</label>
                            <input type="text" name="titulo" required class="form-control" id="titulo" value="<?php echo htmlentities($_POST['titulo']); ?>">
                            <!-- <div id="tituloHelp" class="form-text">Escribe el nombre del libro.</div> -->
                        </div>
                        <div class="mb-3">
                            <label for="editorial_id" class="form-label">Selecciona editorial</label>
                            <select name="editorial_id" id="editorial_id" class="form-select form-select-sm" aria-label=".form-select-sm example" aria-describedby="editorialHelp">
                                <option selected value="">Selecciona</option>
                                <?php
                                $sql = 'select id, editorial from editoriales order by editorial asc';
                                foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $row) {
                                    $selected = $_POST['editorial_id'] == $row['id'] ? 'selected' : '';
                                    echo <<<fin
                                <option value="{$row['id']}" {$selected}>{$row['editorial']}</option>
fin;
                                }
                                ?>
                            </select>
                            <div id="editorialHelp" class="form-text">Las editoriales de la lista son las unicas permitidas.</div>
                            <div class="mb-3">
                            <label for="autor" class="form-label">Autor</label>
                            <input type="text" name="autor" required class="form-control" id="autor" value="<?php echo htmlentities($_POST['autor']); ?>">
                            <!-- <div id="autorHelp" class="form-text">Escribe el nombre del autor.</div> -->
                        </div>
                        <div class="mb-3">
                            <label for="tema0" class="form-label">Temas</label>
                            <div>
                            <?php
                            $sql = 'select id, nombre from temas order by nombre asc';
                            foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $idx => $row) {
                                $row['nombre'] = htmlentities($row['nombre']);
                                $checked = in_array($row['id'], $_POST['tema_id']) ? 'checked' : '';
                                echo <<<fin
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tema_id[]" id="tema{$idx}" value="{$row['id']}" {$checked}>
                                    <label class="form-check-label" for="tema{$idx}">
                                        {$row['nombre']}
                                    </label>
                                </div>
fin;
                                }
                            ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"><?php echo htmlentities($_POST['descripcion']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <div>
                                <div class="form-check">
                                    <label for="accion0" class="form-label">Préstamo</label>
                                    <input class="form-check-input" type="checkbox" name="accion[]" id="accion0" value="Préstamo" <?php echo in_array('Préstamo',$_POST['accion']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="accion1">
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label for="accion1" class="form-label">Intercambio</label>
                                    <input class="form-check-input" type="checkbox" name="accion[]" id="accion1" value="Intercambio" <?php echo in_array('Intercambio',$_POST['accion']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="accion2">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="existencias" class="form-label">Existencias</label>
                            <input type="text" name="existencias" required class="form-control" id="existencias" value="<?php echo htmlentities($_POST['existencias']) ?>" aria-describedby="existenciasHelp">
                            <div id="existenciasHelp" class="form-text">Escribe el numero de ejemplares que dispones.</div>
                        </div>
                        <div class="mb-3">
                            <label for="costo_prestamo_dia" class="form-label">Costo del prestamo por dia</label>
                            <input type="text" name="costo_prestamo_dia" required class="form-control" id="costo_prestamo_dia" value="<?php echo htmlentities($_POST['costo_prestamo_dia']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="costo_libro_nuevo" class="form-label">Costo original</label>
                            <input type="text" name="costo_libro_nuevo" required class="form-control" id="costo_libro_nuevo" value="<?php echo htmlentities($_POST['costo_libro_nuevo']) ?>" aria-describedby="costo_libro_nuevoHelp">
                            <div id="costo_libro_nuevoHelp" class="form-text">Escribe el costo del libro cuando fue comprado.</div>
                        </div>
                        
                        <label for="costo_libro_nuevo" class="form-label">Fotografía</label>

                        <table class="table table-borderless table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="width:50%;">Archivo</th>
                                    <th style="width:50%;">Título</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="file" class="form-control form-control-sm" name="archivo" accept=".jpg">
                                    </td>
                                    <td>
                                        <input type="text" name="titulo_fotografia" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-success">Enviar</button>
                        <a href="libros.php" class="btn btn-outline-danger">Cancelar</a>
                            </div>
                    </form>
                    <?php
                    } else {
                        // es post y todo está bien
                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                            //actualizamos registro en tabla libros
                            $sql = <<<fin
                            update libros set
                            editorial_id = :editorial_id
                            , titulo = :titulo
                            , autor = :autor
                            , descripcion = :descripcion
                            , accion = :accion
                            , existencias = :existencias
                            , costo_prestamo_dia = :costo_prestamo_dia
                            , costo_libro_nuevo = :costo_libro_nuevo
                            , fotografia = :fotografia
                            , titulo_fotografia = :titulo_fotografia
                            where id = :id
fin;
                            if(is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                                $nombre_archivo = uniqid('Libro-', true) . '.jpg'; //se supone solo se admiten .jpg
                                $titulo_archivo = !empty($_POST['titulo_fotografia']) ? $_POST['titulo_fotografia'] : $_POST['titulo'];
                                move_uploaded_file($_FILES['archivo']['tmp_name'], './fotografias-libros/' . $nombre_archivo);
                            }
                            else{
                                $nombre_archivo = "";
                                $titulo_archivo = "";
                            }
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':fotografia', $nombre_archivo, PDO::PARAM_STR);
                            $sentencia->bindValue(':titulo_fotografia', $titulo_archivo, PDO::PARAM_STR);
                            $sentencia->bindValue(':editorial_id', $_REQUEST['editorial_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':titulo', $_REQUEST['titulo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':autor', $_REQUEST['autor'], PDO::PARAM_STR);
                            $sentencia->bindValue(':descripcion', $_REQUEST['descripcion'], PDO::PARAM_STR);
                            $sentencia->bindValue(':accion', implode(',',$_REQUEST['accion']), PDO::PARAM_STR);
                            $sentencia->bindValue(':existencias', $_REQUEST['existencias'], PDO::PARAM_INT);
                            $sentencia->bindValue(':costo_prestamo_dia', $_REQUEST['costo_prestamo_dia'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo_libro_nuevo', $_REQUEST['costo_libro_nuevo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
                            $sentencia->execute();
                            $sql = <<<fin
                            insert ignore into libros_temas
                            (libro_id, tema_id)
                            values(:libro_id, :tema_id)
fin;
                            $sentencia = $conexion->prepare($sql);
                            foreach($_POST['tema_id'] as $tema_id) {
                                $sentencia->bindValue(':libro_id', $_GET['id'], PDO::PARAM_INT);
                                $sentencia->bindValue(':tema_id', $tema_id, PDO::PARAM_INT);
                                $sentencia->execute();
                            }
                            $sentencia= $conexion->prepare($sql);
                            foreach($_POST['tema_id'] as $tema_id){
                            $sentencia->bindValue(':libro_id', $_GET['id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':tema_id', $tema_id, PDO::PARAM_INT);
                            $sentencia->execute();                            
                            }                      
                            // eliminamos las categorías previas que estaban asociadas y que dejaron de estarlo
                            $temas_ids = implode(',', $_POST['tema_id']);
                            $sql = "delete from libros_temas where libro_id = :libro_id and tema_id not in ({$temas_ids})";
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':libro_id', $_GET['id'], PDO::PARAM_INT);
                            $sentencia->execute();
                            // print_r($_FILES);
                                // ¿Realmente se ha cargado un archivo?
                            echo '<h6>Libro actualizado</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="libros.php" class="btn btn-outline-success"><i class="bi-book"></i>   Libros</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a>
                            </div>';
                        } else {
                            //creamos
                            $sql = <<<fin
insert into libros
    (
        editorial_id
        , titulo
        , autor
        , descripcion
        , accion
        , existencias
        , costo_prestamo_dia
        , costo_libro_nuevo
        , fotografia
        , titulo_fotografia
    )
    values
    (
        :editorial_id
        , :titulo
        , :autor
        , :descripcion
        , :accion
        , :existencias
        , :costo_prestamo_dia
        , :costo_libro_nuevo
        , :fotografia
        , :titulo_fotografia
    )
fin;
                        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                            $nombre_archivo = uniqid('Libro-', true) . '.jpg'; // se supone sólo se admiten .jpg
                            $titulo_archivo = !empty($_POST['titulo_fotografia']) ? $_POST['titulo_fotografia'] : $_POST['titulo'];
                            // mover archivo a su ubicación final
                            move_uploaded_file($_FILES['archivo']['tmp_name'], './fotografias-libros/' . $nombre_archivo);
                        }
                        else{
                            $nombre_archivo = "";
                            $titulo_archivo = "";
                        }
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':fotografia', $nombre_archivo, PDO::PARAM_STR);
                            $sentencia->bindValue(':titulo_fotografia', $titulo_archivo, PDO::PARAM_STR);
                            $sentencia->bindValue(':editorial_id', $_REQUEST['editorial_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':titulo', $_REQUEST['titulo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':autor', $_REQUEST['autor'], PDO::PARAM_STR);
                            $sentencia->bindValue(':descripcion', $_REQUEST['descripcion'], PDO::PARAM_STR);
                            $sentencia->bindValue(':accion', implode(',',$_REQUEST['accion']), PDO::PARAM_STR);
                            $sentencia->bindValue(':existencias', $_REQUEST['existencias'], PDO::PARAM_INT);
                            $sentencia->bindValue(':costo_prestamo_dia', $_REQUEST['costo_prestamo_dia'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo_libro_nuevo', $_REQUEST['costo_libro_nuevo'], PDO::PARAM_STR);
                            $sentencia->execute();
                            // asociar con los temas
                            $libro_id = $conexion->lastInsertId();
                            $sql = <<<fin
insert into libros_temas
(libro_id, tema_id)
values(:libro_id, :tema_id)
fin;
                            $sentencia = $conexion->prepare($sql);
                            foreach($_POST['tema_id'] as $tema_id) {
                                $sentencia->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
                                $sentencia->bindValue(':tema_id', $tema_id, PDO::PARAM_INT);
                                $sentencia->execute();
                            }
                            echo '<h6>Libro creado</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="libro_crear.php" class="btn btn-success"><i class="bi-plus-lg"></i>   Crear otro</a>
                            <a href="libros.php" class="btn btn-outline-success"><i class="bi-book"></i>   Libros</a>
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