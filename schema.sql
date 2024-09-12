
create table users (
    code integer auto_increment primary key,
    role enum ("dueño", "supervisor", "administrador", "empleado", "usuario") default "usuario",
    email varchar(254) unique,
    image_id integer,
    username varchar(30),
    surname varchar(30),
    address varchar(150),
    location varchar(150),
    password varchar(60),
    created_at datetime,
    updated_at datetime
);

create table images (
    code integer auto_increment primary key,
    name text unique,
    type enum (".png", ".jpg", ".jpeg"),
    created_at datetime,
    updated_at datetime
);

create table services (
    code integer auto_increment primary key,
    name varchar(150) unique,
    price decimal,
    image_id integer,
    description text,
    created_at datetime,
    updated_at datetime
);

create table products (
    code integer auto_increment primary key,
    name varchar(150) unique,
    price decimal,
    brand varchar(50),
    model varchar(50),
    image_id integer,
    description text,
    created_at datetime,
    updated_at datetime
);

create table categories (
    code integer auto_increment primary key,
    name varchar(100) unique,
    image_id integer,
    created_at datetime,
    updated_at datetime
);

create table products_images (
    image_id integer not null,
    product_id integer not null,
    primary key (image_id, product_id)
);

create table products_categories (
    product_id integer not null,
    category_id integer not null
);

-- Creacion de llaves foraneas

alter table users add foreign key (image_id) references images (code);

alter table services add foreign key (image_id) references images (code);

alter table products add foreign key (image_id) references images (code);

alter table categories add foreign key (image_id) references images (code);

alter table products_images add foreign key (image_id) references images (code);

alter table products_images add foreign key (product_id) references products (code);

alter table products_categories add foreign key (product_id) references (code);

alter table products_categories add foreign key (category_id) references (code);