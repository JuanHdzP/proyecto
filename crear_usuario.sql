-- /opt/lampp/bin/mysql -h localhost -u root -P 3306
-- /Applications/MAMP/Library/bin/mysql -h localhost -u root -p
-- root

use mysql; 
create user 'usr'@'127.0.0.1' identified by 'pwd'; 
flush privileges;
grant alter, alter routine, create, create routine, create temporary tables, create view, delete, drop, event, execute, index, insert, lock tables, references, select, show view, trigger, update on viajes_experienciales.* to 'usr'@'127.0.0.1' with grant option; 
flush privileges;

alter user 'usr'@'127.0.0.1' identified by 'pwd';