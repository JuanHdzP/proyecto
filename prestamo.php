<?php
require_once './checa-sesion.php';
require('vendor/autoload.php');
use Rakit\Validation\Validator;
require_once './conexion.php';
if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sql = 'select * from prestamos where id = :id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $prestamo = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (null == $prestamo) {
        require_once './error-no-encontrado.php';
        exit;
    }
    $_POST = array_merge($_POST, $prestamo);
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo prestamo</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <script>			
    		$(function(){
				$("#adicional").on('click', function(){
					$("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla");
				});
			 
				$(document).on("click",".eliminar",function(){
					var parent = $(this).parents().get(0);
					$(parent).remove();
				});
			});
		</script>
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
                <h5 i class="bi bi-arrows-angle-contract text-center"></i> Préstamo</h5>
                </div>
                <div class="card-body">
                <?php
                    if ('POST' == $_SERVER['REQUEST_METHOD']) {
                        //print_r($_POST);
                        //exit;
                        // validamos los datos
                        $validator = new Validator;
                        $validation = $validator->make($_POST, [
                            'contacto_id' => 'required'
                            , 'fecha_prestamo' => 'required|date:Y-m-d|'
                            , 'fecha_entrega' => 'required|date:Y-m-d|'
                            , 'fecha_devolucion' => 'required|date:Y-m-d|'                      
                            , 'costo' => 'required|min:1|max:100'
                            , 'costo_penalizacion' => 'required|min:1|max:100'
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
                            </div>

                            <div class="mb-3">
                                <label for="fecha_prestamo" class="form-label">Fecha del préstamo</label>
                                <input type="date" name="fecha_prestamo" required class="form-control form-control" id="fecha_prestamo" value="<?php echo htmlentities($_POST['fecha_prestamo'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="fecha_entrega" class="form-label">Fecha de entrega</label>
                                <input type="date" name="fecha_entrega" required class="form-control form-control" id="fecha_entrega" value="<?php echo htmlentities($_POST['fecha_entrega'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="fecha_devolucion" class="form-label">Fecha de devolución</label>
                                <input type="date" name="fecha_devolucion" required class="form-control form-control" id="fecha_devolucion" value="<?php echo htmlentities($_POST['fecha_devolucion'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                            <label for="costo" class="form-label">Costo por dia</label>
                            <input type="text" name="costo" required class="form-control form-control" id="costo" value="<?php echo htmlentities($_POST['costo'] ?? '') ?>">
                            </div>
                        
                        <div class="mb-3">
                            <label for="costo_penalizacion" class="form-label">Costo Penalización</label>
                            <input type="text" name="costo_penalizacion" required class="form-control form-control" id="costo_penalizacion" value="<?php echo htmlentities($_POST['costo_penalizacion'] ?? '') ?>">
                            </div>
	        			                            
                            <table class="table"  id="tabla">
                                <thead>
                            <tr class="info">	
                            <th style="width:8%;">Id</th>                                                         				
                            <th style="width:71%;">Libro</th>
		        				<th>Costo Total</th>                                                 
                                <th><button id="adicional" name="adicional" type="button" class="btn btn-primary"> + </button><th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="fija-fija">
                            <td>
                                    <input type="text" name="prestamo_id[]" required class="form-control form-control" id="prestamo_id" value="<?php echo htmlentities($_POST['prestamo_id'] ?? '') ?>">
                                </td> 
                                <td>
                                    <select name="libros_id[]" id="libros_id" class="form-select form-select" aria-label=".form-select example" aria-describedby="libros_idHelp">
                                    <option selected value="">Selecciona</option>
                                     <?php
                                    $sql = 'select id, titulo from libros order by titulo asc';
                                    foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $row) {
                                        $selected = $_POST['libros_id'] == $row['id'] ? 'selected' : '';
                                        echo <<<fin
                                    <option value="{$row['id']}" {$selected}>{$row['titulo']}</option>
fin;
                                    }
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="costo_prestamo_dia[]" required class="form-control form-control" id="costo_prestamo_dia" value="<?php echo htmlentities($_POST['costo_prestamo_dia'] ?? '') ?>">
                                </td>                                
                                <td class="eliminar">
                                    <input type="button" value=x class="btn btn-danger">
                                </td>
                            </tr>
                            </tbody>
                            </table> 
                                         
	        			</div>	        	
                        <div class="d-grid gap-2">  
                        <input type="submit" name="insertar" value="Enviar" class="btn btn-outline-success">                      
                        <a href="prestamos.php" class="btn btn-outline-danger">Cancelar</a>
                        </div>
                        </div>
                        </div>
                        </div>
                    </form>
                    <?php
                    } else {
                        // es post y todo está bien
                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                            //actualizamos registro en tabla libros
                            $sql = <<<fin
                            update prestamos set
                            contacto_id = :contacto_id
                            , fecha_prestamo = :fecha_prestamo
                            , fecha_entrega = :fecha_entrega
                            , fecha_devolucion = :fecha_devolucion
                            , costo = :costo
                            , costo_penalizacion = :costo_penalizacion
                            where id = :id
fin;
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':contacto_id', $_REQUEST['contacto_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':fecha_prestamo', $_REQUEST['fecha_prestamo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':fecha_entrega', $_REQUEST['fecha_entrega'], PDO::PARAM_STR);
                            $sentencia->bindValue(':fecha_devolucion', $_REQUEST['fecha_devolucion'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo', $_REQUEST['costo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo_penalizacion', $_REQUEST['costo_penalizacion'], PDO::PARAM_STR);
                            $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
                            $sentencia->execute();  
                            $items1 = ($_POST['prestamo_id']);
				            $items2 = ($_POST['libros_id']);
				            $items3 = ($_POST['costo_prestamo_dia']);
				            while(true) {
				                $item1 = current($items1);
				                $item2 = current($items2);
				                $item3 = current($items3);
				                $prestamo_id=(( $item1 !== false) ? $item1 : ", &nbsp;");
				                $libros_id=(( $item2 !== false) ? $item2 : ", &nbsp;");
				                $costo_prestamo_dia=(( $item3 !== false) ? $item3 : ", &nbsp;");
				                $valores='('.$prestamo_id.',"'.$libros_id.'","'.$costo_prestamo_dia.'"),';
				                $valoresQ= substr($valores, 0, -1);				    
				                $sql = "INSERT INTO prestamos_detalle (prestamo_id, libros_id, costo_prestamo_dia) 
					            VALUES $valoresQ";					
					            $sqlRes=$conexion->query($sql) or mysql_error();				    
				                $item1 = next( $items1 );
				                $item2 = next( $items2 );
				                $item3 = next( $items3 );
				                // Check terminator
				                if($item1 === false && $item2 === false && $item3 === false) break;    
				            }		                                           
                            echo '<h6>Préstamo modificado</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="prestamos.php" class="btn btn-outline-success"><i class="bi-book"></i>   Préstamos</a>
                            <a href="index.php" class="btn btn-outline-dark"><i class="bi-house-door-fill"></i>   Inicio</a>
                            </div>';
                        } else {
                            //creamos
                            $sql = <<<fin
insert into prestamos
(
contacto_id
, fecha_prestamo
, fecha_entrega
, fecha_devolucion
, costo
, costo_penalizacion
)
values
(
:contacto_id
, :fecha_prestamo
, :fecha_entrega
, :fecha_devolucion
, :costo
, :costo_penalizacion
)
fin;
                            $sentencia = $conexion->prepare($sql);
                            $sentencia->bindValue(':contacto_id', $_REQUEST['contacto_id'], PDO::PARAM_INT);
                            $sentencia->bindValue(':fecha_prestamo', $_REQUEST['fecha_prestamo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':fecha_entrega', $_REQUEST['fecha_entrega'], PDO::PARAM_STR);
                            $sentencia->bindValue(':fecha_devolucion', $_REQUEST['fecha_devolucion'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo', $_REQUEST['costo'], PDO::PARAM_STR);
                            $sentencia->bindValue(':costo_penalizacion', $_REQUEST['costo_penalizacion'], PDO::PARAM_STR);
                            $sentencia->execute(); 
                            $items1 = ($_POST['prestamo_id']);
				            $items2 = ($_POST['libros_id']);
				            $items3 = ($_POST['costo_prestamo_dia']);
				            while(true) {
				                $item1 = current($items1);
				                $item2 = current($items2);
				                $item3 = current($items3);
				                $prestamo_id=(( $item1 !== false) ? $item1 : ", &nbsp;");
				                $libros_id=(( $item2 !== false) ? $item2 : ", &nbsp;");
				                $costo_prestamo_dia=(( $item3 !== false) ? $item3 : ", &nbsp;");
				                $valores='('.$prestamo_id.',"'.$libros_id.'","'.$costo_prestamo_dia.'"),';
				                $valoresQ= substr($valores, 0, -1);				    
				                $sql = "INSERT INTO prestamos_detalle (prestamo_id, libros_id, costo_prestamo_dia) 
					            VALUES $valoresQ";					
					            $sqlRes=$conexion->query($sql) or mysql_error();				    
				                $item1 = next( $items1 );
				                $item2 = next( $items2 );
				                $item3 = next( $items3 );
				                // Check terminator
				                if($item1 === false && $item2 === false && $item3 === false) break;    
				            }		                                
                            echo '<h6>Préstamo generado</h6>';
                            echo '<div class="d-grid gap-2">
                            <a href="prestamo.php" class="btn btn-success"><i class="bi-plus-lg"></i>   Generar otro</a>
                            <a href="prestamos.php" class="btn btn-outline-success"><i class="bi-book"></i>   Préstamos</a>
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