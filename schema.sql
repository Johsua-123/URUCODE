-- SQLBook: Code

create table users (
    code integer auto_increment primary key,
    role enum ("dueño", "supervisor", "administrador", "empleado", "usuario") default "usuario",
    email varchar(254) unique,
    image_id integer,
    username varchar(30),
    surname varchar(30),
    address varchar(150),
    location varchar(150),
    cellphone varchar(12),
    password varchar(60),
    created_at datetime,
    updated_at datetime
);

create table sales (
    code integer auto_increment primary key,
    user_id integer,
    created_at datetime,
    updated_at datetime
);

create table images (
    code integer auto_increment primary key,
    name text,
    type enum (".png", ".jpg", ".jpeg", ".webp"),
    created_at datetime,
    updated_at datetime
);

create table tokens (
    code integer auto_increment primary key,
    type enum ("verificar", "resetar", "eliminar"),
    token varchar(60),
    user_id integer,
    created_at datetime,
    updated_at datetime
);

create table payments (
    code integer auto_increment primary key,
    state enum ("completado", "pendiente", "vencido"),
    method enum ("Tarjeta", "PayPal", "Mercado Pago", "Transferencia"),
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

create table sales_details (
    code integer auto_increment primary key,
    type enum ("producto", "servicio"),
    price decimal,
    amount decimal,
    sale_id integer,
    item_id integer,
    subtotal decimal,
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

alter table users add foreign key (image_id) references images (code) on update cascade on delete set null;

alter table sales add foreign key (user_id) references users (code) on update cascade;

alter table tokens add unique index unique_type (type, user_id);

alter table services add foreign key (image_id) references images (code) on update cascade on delete set null;

alter table products add foreign key (image_id) references images (code) on update cascade on delete set null;

alter table categories add foreign key (image_id) references images (code) on update cascade on delete set null;

alter table sales_details add foreign key (sale_id) references sales (code) on update cascade;

alter table sales_details add foreign key (item_id) references services (code) on update cascade;

alter table sales_details add foreign key (item_id) references products (code) on update cascade;

alter table products_images add foreign key (image_id) references images (code) on update cascade on delete cascade;

alter table products_images add foreign key (product_id) references products (code) on update cascade on delete cascade;

alter table products_categories add foreign key (product_id) references (code) on update cascade on delete cascade;

alter table products_categories add foreign key (category_id) references (code) on update cascade on delete cascade;
