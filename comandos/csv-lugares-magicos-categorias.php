<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV lugares mágicos</title>
</head>
<body>
<?php
$estados = [
    1 => 'Aguascalientes'
    , 2 => 'Baja California'
    , 3 => 'Baja California Sur'
    , 4 => 'Campeche'
    , 5 => 'Chiapas'
    , 6 => 'Chihuahua'
    , 7 => 'Ciudad de México'
    , 8 => 'Coahuila'
    , 9 => 'Colima'
    , 10 => 'Durango'
    , 15 => 'Estado de México'
    , 11 => 'Guanajuato'
    , 12 => 'Guerrero'
    , 13 => 'Hidalgo'
    , 14 => 'Jalisco'
    , 16 => 'Michoacán'
    , 17 => 'Morelos'
    , 18 => 'Nayarit'
    , 19 => 'Nuevo León'
    , 20 => 'Oaxaca'
    , 21 => 'Puebla'
    , 22 => 'Querétaro'
    , 23 => 'Quintana Roo'
    , 24 => 'San Luis Potosí'
    , 25 => 'Sinaloa'
    , 26 => 'Sonora'
    , 27 => 'Tabasco'
    , 28 => 'Tamaulipas'
    , 29 => 'Tlaxcala'
    , 30 => 'Veracruz'
    , 31 => 'Yucatán'
    , 32 => 'Zacatecas'
];
$categorias = [
    1 => 'Aguas termales'
    , 2 => 'Artesanías'
    , 3 => 'Batallas históricas'
    , 4 => 'Bosques'
    , 5 => 'Cascadas'
    , 6 => 'Cenotes'
    , 7 => 'Ciclismo'
    , 8 => 'Cines'
    , 9 => 'Ciudad colonial'
    , 10 => 'Deportes acuáticos'
    , 11 => 'Desierto'
    , 12 => 'Fauna'
    , 13 => 'Flora'
    , 14 => 'Gastronomía'
    , 15 => 'Grutas'
    , 16 => 'Lagos'
    , 17 => 'Lenguas indígenas'
    , 18 => 'Leyendas'
    , 19 => 'Lugares paradisiacos'
    , 20 => 'Nieve'
    , 21 => 'Paracaidismo'
    , 22 => 'Personajes destacados'
    , 23 => 'Playas'
    , 24 => 'Rappel'
    , 25 => 'Ríos'
    , 26 => 'Ríos subterráneos'
    , 27 => 'Rutas queso'
    , 28 => 'Rutas vino'
    , 29 => 'Senderismo'
    , 30 => 'Sucesos históricos'
    , 31 => 'Templos religiosos'
    , 32 => 'Tirolesa'
    , 33 => 'Zonas arqueológicas'
];
echo "lugar_magico_id,categoria_id,tiene,comentario<br>";
$contador = 1;
foreach($estados as $estado_id => $estado) {
    for($numero = 1; $numero <= 5; $numero++) {
        foreach ($categorias as $categoria_id => $categoria) {
            echo "{$contador},{$categoria_id},No,<=¿Lugar mágico {$contador} tiene '{$categoria}'? Si-No<br>";
        }
        $contador++;
    }
}
?>
</body>
</html>