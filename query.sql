create database sys_papeleta_salida;
use sys_papeleta_salida;

create table users(
	id int auto_increment primary key,
    type_user varchar(10),
    username varchar(30) UNIQUE KEY NOT NULL,
    pass_hash varbinary(60) NOT NULL,
    pass_salt varbinary(60) NOT NULL,
    nombres varchar(100) NOT NULL,
    apellidos varchar(100) NOT NULL,
    dni varchar(8) UNIQUE KEY NOT NULL,
    email varchar(150) UNIQUE KEY NOT NULL,
    area varchar(100) NOT NULL,
    oficina varchar(200) NOT NULL
);

INSERT INTO users(username, pass_hash, pass_salt, nombres, apellidos, dni, email, area, oficina)
values("billandy", "$2b$12$Bq4ilJf1/9v3S32UpUfDLurSZt4.wZsClfGYjx/qNCp1rZjn8ew3S", "$2b$12$Bq4ilJf1/9v3S32UpUfDLu", "Bill Andy", "Martinez obregon", "76528706", "bill@gmail.com", "AGA", "Informatica");
commit;
