<?php
require('vendor/autoload.php');
require_once './conexion.php';
    $sql="SELECT l.titulo, l.editorial_id, l.autor, l.descripcion, l.fotografia, e.editorial from libros l INNER JOIN editoriales AS e ON l.editorial_id = e.id  where l.id = :id";	
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
	$libro = $sentencia->fetch(PDO::FETCH_ASSOC);
    $sql = 'select tema_id from libros_temas where libro_id = :id';
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $temas_id = [];
    foreach($sentencia->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $temas_id[] = $row['tema_id'];
    }
    $_POST['tema_id'] = $temas_id;		
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $libro['titulo']; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  	<!-- Fuente de Google -->
</head>
<body>
<?php
    require_once './menu.php';
    ?>
	    <div class="container">
	        <div class="row">
            <div class="col-2"></div>
	        	<div class="col-8">	        		
		            <div class="row">
		            	<div class="col-sm-6">
                    <br>
		            		<img src="<?php echo (!empty($libro['fotografia'])) ? 'fotografias-libros/'.$libro['fotografia'] : 'fotografias-libros/noimage.jpg'; ?>" width="100%" class="zoom" data-magnify-src="images/large-<?php echo $libro['fotografia']; ?>">
		            		<br><br>
		            	</div>
		            	<div class="col-6">
                  <br><br><br><br><br>
		            		<h2 class="page-header text-center"><?php echo $libro['titulo']; ?></h2>
		            		<br><br><br><p><b>Autor:</b> <?php echo $libro['autor']; ?></a></p><br>
                            <?php
                                $sql = 'select id, editorial from editoriales order by editorial asc';
                                foreach ($conexion->query($sql, PDO::FETCH_ASSOC) as $row) {
                                }
                                echo <<<fin
                                    <p><b>Editorial:</b> {$row['editorial']}
fin;
                                ?>
		            		<br><br><p><b>Descripción:</b></p>
		            		<p><?php echo $libro['descripcion']; ?></p>
		            	</div>
		            </div>
		            <br>
	        	</div>
	        	<div class="col-3">
	        	</div>
	        </div>
	    </div>              
</body>
</html>