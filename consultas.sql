/*selecciona bd*/
use viajes_experienciales;

/*estados de la república*/
select
	id, estado
from
	estados
order by estado asc
;

/*rangos de ids de municipios por estado*/
select estado_id, min(id) as minimo, max(id) as maximo from municipios group by estado_id;

/*municipios del estado de méxico*/
select
    id, municipio
from
    municipios
where
    estado_id = 15
    and municipio like 'te%'
;

/*categorías*/
select id, categoria from categorias order by categoria 
;

/*lugares magicos*/
select id, estado_id, municipio_id, nombre_lugar, descripcion, estatus from lugares_magicos
;

/*lugares magicos con estado y municipio*/
select
    lm.id, lm.estado_id, lm.municipio_id, lm.nombre_lugar, lm.descripcion, lm.estatus, e.estado, m.municipio
from
    lugares_magicos lm
    inner join estados e on lm.estado_id = e.id
    inner join municipios m on lm.municipio_id = m.id
where
    lm.id = 1
;

/*categorías de un lugar mágico*/
select
    straight_join
    c.id 
    , c.categoria 
from
    lugares_magicos_categorias lmc
    inner join categorias c on lmc.categoria_id = c.id
where
    lmc.lugar_magico_id = 1
order by
    c.categoria asc
;

/*lugares mágicos de una categoría*/
select
    lm.id, lm.estado_id, lm.municipio_id, lm.nombre_lugar, lm.descripcion, lm.estatus, e.estado, m.municipio
from
    lugares_magicos lm
    inner join estados e on lm.estado_id = e.id
    inner join municipios m on lm.municipio_id = m.id
where
    lm.id in (select lugar_magico_id from lugares_magicos_categorias where categoria_id = 10) -- categoría con id 10
order by
    lm.estado_id, lm.municipio_id, lm.nombre_lugar
;

/*lugares mágicos de una categoría y estado*/
select
    lm.id, lm.estado_id, lm.municipio_id, lm.nombre_lugar, lm.descripcion, lm.estatus, e.estado, m.municipio
from
    lugares_magicos lm
    inner join estados e on lm.estado_id = e.id
    inner join municipios m on lm.municipio_id = m.id
where
    lm.estado_id = 15 -- Estado de México
    and lm.id in (select lugar_magico_id from lugares_magicos_categorias where categoria_id = 10) -- categoría con id 10
order by
    lm.estado_id, lm.municipio_id, lm.nombre_lugar
;

/*truncar categorías y crear algunas*/
set foreign_key_checks=0;
truncate table categorias;
truncate table lugares_magicos;
truncate table lugares_magicos_categorias;
set foreign_key_checks=1;

insert into categorias (categoria)
values('Ciudad colonial'), ('Gastronomía'), ('Playas'), ('Vinos'), ('Reservas naturales'), ('Artesanías'), ('Deportes extremos'), ('Museos'), ('Zafaris'), ('Zona arqueológica')
;

/*insertar lugares mágicos*/
insert into lugares_magicos (estado_id, municipio_id, nombre_lugar, descripcion, estatus)
values (15, 708, 'Zona arqueológica de Malinalco', 'Llamada localmente "el cerro de los ídolos", significa "lugar donde se adora a Malinalxóchitl" diosa mexica responsable de la hechicería y otras artes oscuras, hermana de Huitzilopochtli.', 'Activo')
, (15, 746, 'Zona arqueológica de Teotenango', 'Teotenango es una voz náhuatl, se deriva de Téotl (sagrado, dios, divino); de tenamitl (muralla, cerco, albarrada) y de co, (indicativo de lugar); es decir, puede traducirse como "En el lugar de la muralla sagrada o divina”.', 'Activo')
;

/*categorias de lugares mágicos*/
insert into lugares_magicos_categorias (lugar_magico_id, categoria_id)
values
(1, 2) -- Gastronomía
, (1, 8) -- Museos
, (1, 10) -- Zona arqueológica
, (2, 2) -- Gastronomía
, (2, 8) -- Museos
, (2, 10) -- Zona arqueológica
;

/*verificar si se permite la carga de archivos*/
-- https://stackoverflow.com/questions/34102562/mysql-error-1290-hy000-secure-file-priv-option
SELECT @@GLOBAL.secure_file_priv;

/*
nano ~/.my.cnf

[mysqld_safe]
[mysqld]
secure_file_priv="/Applications/MAMP/htdocs/"
*/

/*
NOTA: En windows, modificar el archivo que suele estar en: C:\xampp\mysql\bin\my.ini
y agregar la línea:
secure_file_priv = "/"

después de:
pid_file = "mysql.pid"
*/

/*
NOTAS: Verificar la ruta del archivo, si tu carpeta dentro de htdocs se llama diferente o si no tienes xammp en unidad c
*/

/*cargar categorías desde un archivo csv*/
-- https://dev.mysql.com/doc/refman/8.0/en/load-data.html
load data infile '/xampp/htdocs/dsm31/csv/categorias.csv'
into table categorias
character set UTF8
fields terminated by ','
optionally enclosed by '"'
escaped by '\\'
lines terminated by '\r\n' -- Para linux y mac suele ser '\n'
ignore 1 lines
(categoria)
;


/*cargar lugares mágicos desde un archivo csv*/
-- https://dev.mysql.com/doc/refman/8.0/en/load-data.html
load data infile '/xampp/htdocs/dsm31/csv/lugares_magicos.csv'
into table lugares_magicos
character set UTF8
fields terminated by ','
optionally enclosed by '"'
escaped by '\\'
lines terminated by '\r\n' -- Para linux y mac suele ser '\n'
ignore 1 lines
(estado_id, municipio_id, nombre_lugar, descripcion, estatus)
;
