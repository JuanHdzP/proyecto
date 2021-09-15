<?php
//require_once './checa-sesion.php';
require('vendor/autoload.php');
require_once './conexion.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubícanos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  	<!-- Fuente de Google -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">   
    <style type="text/css">
    .prod-body{
      height:300px;
    }
    .box:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    </style>
</head>
<body>
    <?php
    require_once './menu.php';
    ?>
<div class="content-wrapper">
	    <div class="container">
	      <section class="content">
	        <div class="row">
            <div class="col-2"></div>
	        	<div class="col-8">
	            <?php	       			
                       $sql = <<<fin
                       SELECT COUNT(*) AS resultados FROM libros WHERE titulo LIKE :palabra
fin;
                    $sentencia = $conexion->prepare($sql);
                    $sentencia->execute((['palabra' => '%'.$_POST['palabra'].'%']));
                    $row = $sentencia->fetch(PDO::FETCH_ASSOC);
	       			if($row['resultados'] < 1){
	       				echo '<h3 class="text-center">No se encontraron resultados para <i>'.$_POST['palabra'].'</i></h3>';
	       			}
	       			else{
	       				echo '<br><h3 class="text-center">Resultados de búsqueda para "<i>'.$_POST['palabra'].'"</i></h3><br>';
		       			try{
		       			 	$inc = 3;	
						    $stmt = $conexion->prepare("SELECT * FROM libros WHERE titulo LIKE :palabra");
						    $stmt->execute(['palabra' => '%'.$_POST['palabra'].'%']);
					 
						    foreach ($stmt as $row) {
						    	$remarcar = preg_filter('/' . preg_quote($_POST['palabra'], '/') . '/i', '<b>$0</b>', $row['titulo']);
						    	$image = (!empty($row['fotografia'])) ? 'fotografias-libros/'.$row['fotografia'] : 'fotografias-libros/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>
	       								<div class='box box-solid'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h5><p class='text-center'><a href='libro.php?id=".$row['id']."'>".$remarcar."</a></p></h5>
		       								</div>		       							
	       								</div>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "Hay algún problema en la conexión.: " . $e->getMessage();
						}
					}
	       		?> 
	        	</div>
	        	<div class="col-2">
	        	</div>
	        </div>
	      </section>	     
	    </div>
	  </div>  
</div>
</body>
</html>