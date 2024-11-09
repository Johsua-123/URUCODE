
-- Creacion de la base de datos

CREATE DATABASE urucode;
USE urucode;

-- Creacion de las tablas

create table usuarios (
   codigo integer auto_increment primary key,
   rol enum ("dueño", "supervisor", "admin", "empleado", "usuario") default "usuario",
   email varchar(150) UNIQUE,
   nombre varchar(30),
   apellido varchar(30),
   telefono varchar(12),
   ubicacion varchar(150),
   direccion varchar(150),
   verificado boolean default false,
   imagen_id integer,
   contrasena varchar(60),
   eliminado boolean default false,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table imagenes (
   codigo integer auto_increment primary key,
   nombre text,
   tipo enum (".png", ".jpg", ".jpeg", ".webp"),
   eliminado boolean default false,
   fecha_creacion datetime,
   fecha_actualizacion datetime	
);

create table codigos (
   codigo integer auto_increment primary key,
   tipo enum ("verificar-cuenta", "resetear-cuenta", "eliminar-cuenta"),
   valor varchar(60),
   usuario_id integer,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table servicios (
   codigo integer auto_increment primary key,
   nombre varchar(150) unique,
   precio decimal,
   eliminado boolean default false,
   imagen_id integer,
   descripcion text,
   fecha_creacion datetime,
   fecha_actualizacion datetime	
);

create table productos (
   codigo integer auto_increment primary key,
   nombre varchar(150), 
   marca varchar(70),
   modelo varchar(70) unique,
   cantidad integer default 1, 
   en_venta boolean default false,
   eliminado boolean default false,
   imagen_id integer,
   descripcion text,
   precio_costo decimal,
   precio_venta decimal,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table categorias (
   codigo integer auto_increment primary key,
   nombre varchar(150) unique,
   eliminado boolean default false,
   imagen_id integer,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table mensajes (
  codigo integer auto_increment primary key,
  email varchar(180) not null,
  leido boolean default false,
  nombre varchar(60) not null,
  asunto varchar(150) not null,
  mensaje text not null,
  fecha_creacion datetime,
  fecha_actualizacion datetime
);

create table productos_categorias (
    producto_id integer,
    categoria_id integer,
    fecha_creacion datetime,
    fecha_actualizacion datetime
);

create table productos_imagenes (
    eliminado boolean default false,
    imagen_id integer,
    producto_id integer,
    fecha_creacion datetime,
    fecha_actualizacion datetime 
);

-- Creacion de las llaves foraneas

alter table usuarios add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table codigos add foreign key (usuario_id) references usuarios (codigo) on update cascade;

alter table codigos add unique (tipo, usuario_id);

alter table productos add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table servicios add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table categorias add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table productos_imagenes add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table productos_imagenes add foreign key (producto_id) references productos (codigo) on update cascade;

alter table productos_categorias add foreign key (producto_id) references productos (codigo) on update cascade;

alter table productos_categorias add foreign key (categoria_id) references categorias (codigo) on update cascade;

alter table productos_categorias add unique (producto_id, categoria_id);

-- Creacion de los indices

alter table usuarios add index idx_nombre (nombre), add index idx_apellido (apellido), add index idx_telefono (telefono), add index idx_eliminado (eliminado);

alter table imagenes add index idx_eliminado (eliminado);

alter table servicios add index idx_precio (precio), add index idx_eliminado (eliminado);

alter table productos add index idx_nombre (nombre), add index idx_marca (marca), 
add index idx_en_venta (en_venta), add index idx_eliminado (eliminado), add index idx_precio_venta (precio_venta);

alter table categorias add index idx_eliminado (eliminado);

alter table mensajes add index idx_email (email), add index idx_nombre (nombre);

alter table productos_imagenes add index idx_eliminado (eliminado);

alter table productos_categorias add index idx_eliminado (eliminado);