
-- Creacion de la base de datos

create database urucode; 
use urucode; 

-- Creacion de las tablas

create table usuarios (
   codigo integer auto_increment primary key,
   rol enum ("dueño", "supervisor", "admin", "empleado", "usuario") default "usuario",
   email varchar(254) unique,
   nombre varchar(30),
   apellido varchar(30),
   telefono varchar(12),
   ubicacion varchar(150),
   direccion varchar(150),
   imagen_id integer,
   contrasena varchar(60),
   eliminado boolean default false,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table imagenes (
   codigo integer auto_increment primary key,
   nombre text,
   tipo enum(".png", ".jpg", ".jpeg", ".webp"),
   eliminado boolean default false,
   fecha_creacion datetime,
   fecha_actualizacion datetime	
);

create table codigos (
   codigo integer auto_increment primary key,
   tipo enum("verificar-cuenta", "resetear-cuenta", "eliminar-cuenta"),
   valor varchar(60),
   usuario_id integer,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table productos (
   codigo integer auto_increment primary key,
   nombre varchar(150) unique, 
   stock integer,  
   precio decimal,
   marca varchar(100),
   modelo varchar(100),
   eliminado boolean default false,
   imagen_id integer,
   descripcion text,
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

create table categorias (
   codigo integer auto_increment primary key,
   nombre varchar(150) unique,
   sub_categoria integer,
   eliminado boolean default false,
   imagen_id integer,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table mensajes (
  codigo integer auto_increment primary key,
  email varchar(150) not null,
  leido boolean default false,
  nombre varchar(60) not null,
  asunto varchar(150) not null,
  mensaje text not null,
  fecha_creacion datetime
);

create table ventas (
   codigo integer auto_increment primary key,
   total decimal,
   usuario_id integer,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table pagos (
   codigo integer auto_increment primary key,
   estado enum ("completado", "pendiente", "vencido"),
   metodo enum("Tarjeta", "PayPal", "Mercado Pago", "Transferencia"),
   cuotas integer default 0,
   venta_id integer,
   usuario_id integer,
   fecha_creacion datetime,
   fecha_actualizacion datetime  
);

create table cuotas (
   codigo integer auto_increment primary key,
   estado enum ("pagada", "pendiente", "vencida"),
   numero integer,
   metodo enum("Tarjeta", "PayPal", "Mercado Pago", "Transferencia"),
   pago_id integer,
   fecha_creacion datetime,
   fecha_actualizacion datetime
);

create table ordenes (
    codigo integer auto_increment primary key,
    tipo enum("producto", "servicio"),
    precio decimal,
    cantidad integer,
    venta_id integer,
    subtotal decimal,
    fecha_creacion datetime,
    fecha_actualizacion datetime   
);

create table productos_imagenes (
    imagen_id integer,
    producto_id integer,
    fecha_creacion datetime,
    fecha_actualizacion datetime 
);

create table productos_categorias (
    producto_id integer,
    categoria_id integer,
    fecha_creacion datetime,
    fecha_actualizacion datetime
);

-- Creacion de llaves foraneas

alter table usuarios add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table codigos add foreign key (usuario_id) references usuarios (codigo) on update cascade;

alter table codigos add unique (tipo, usuario_id);

alter table productos add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table servicios add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table categorias add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table categorias add foreign key (sub_categoria) references categorias (codigo) on update cascade;

alter table ventas add foreign key (usuario_id) references usuarios (codigo) on update cascade;

alter table pagos add foreign key (usuario_id) references usuarios (codigo) on update cascade;

alter table pagos add foreign key (venta_id) references ventas (codigo) on update cascade;

alter table cuotas add foreign key (pago_id) references pagos (codigo) on update cascade;

alter table ordenes add foreign key (venta_id) references ventas (codigo) on update cascade;

alter table productos_imagenes add foreign key (imagen_id) references imagenes (codigo) on update cascade;

alter table productos_imagenes add foreign key (producto_id) references productos (codigo) on update cascade;

alter table productos_imagenes add unique (imagen_id, producto_id);

alter table productos_categorias add foreign key (producto_id) references productos (codigo) on update cascade;

alter table productos_categorias add foreign key (categoria_id) references categorias (codigo) on update cascade;

alter table productos_categorias add unique (producto_id, categoria_id);

-- Creacion de los indices

alter table usuarios add index idx_eliminado (eliminado), add index idx_nombre (nombre), add index idx_apellido (apellido), add index idx_telefono (telefono);

alter table imagenes add index idx_eliminado (eliminado);

alter table productos add index idx_precio (precio), add index idx_marca (marca), add index idx_modelo (modelo), add index idx_eliminado (eliminado);

alter table servicios add index idx_precio (precio), add index idx_eliminado (eliminado);

alter table categorias add index idx_eliminado (eliminado);

alter table pagos add index idx_estado (estado), add index idx_metodo (metodo);

alter table cuotas  add index idx_estado (estado), add index idx_metodo (metodo), add index idx_numero (numero);

alter table ordenes add  index idx_tipo (tipo), add index idx_precio (precio), add index idx_venta_tipo (venta_id, tipo);

-- Creacion de los usuarios

grant insert, select, update, delete  on urucode.* to  'duenio'@'localhost' identified by 'duenio';