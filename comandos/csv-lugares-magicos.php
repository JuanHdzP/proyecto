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
$rangos = [
    1 => '1-11'
    , 2 => '12-16'
    , 3 => '17-21'
    , 4 => '22-32'
    , 5 => '33-150'
    , 6 => '151-217'
    , 7 => '218-233'
    , 8 => '234-271'
    , 9 => '272-281'
    , 10 => '282-320'
    , 11 => '321-366'
    , 12 => '367-447'
    , 13 => '448-531'
    , 14 => '532-656'
    , 15 => '657-781'
    , 16 => '782-894'
    , 17 => '895-927'
    , 18 => '928-947'
    , 19 => '948-998'
    , 20 => '999-1568'
    , 21 => '1569-1785'
    , 22 => '1786-1803'
    , 23 => '1804-1814'
    , 24 => '1815-1872'
    , 25 => '1873-1890'
    , 26 => '1891-1962'
    , 27 => '1963-1979'
    , 28 => '1980-2022'
    , 29 => '2023-2082'
    , 30 => '2083-2294'
    , 31 => '2295-2400'
    , 32 => '2401-2458'
];
echo "id,estado_id,municipio_id,nombre_lugar,descripcion,estatus<br>";
$contador = 1;
foreach($estados as $estado_id => $estado) {
    for($numero = 1; $numero <= 5; $numero++) {
        echo "{$contador},{$estado_id},Id del municipio: {$rangos[$estado_id]},Escribe aquí el nombre del lugar,Escribe aquí la descripción del lugar,Activo<br>";
        $contador++;
    }
}
?>
</body>
</html>