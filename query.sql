create database sys_papeleta_salida;
use sys_papeleta_salida;

create table users(
	id int auto_increment primary key,
    type_user varchar(10),
    username varchar(30),
    pass_hash varbinary(60),
    pass_salt varbinary(60),
    nombres varchar(100),
    apellidos varchar(100),
    dni varchar(8),
    email varchar(150),
    area varchar(100),
    oficina varchar(200)
);
drop table users;
select * from users;
commit;
SELECT pass_hash, pass_salt, username FROM users WHERE username  = 'billandy';

delete from users where id=6;
