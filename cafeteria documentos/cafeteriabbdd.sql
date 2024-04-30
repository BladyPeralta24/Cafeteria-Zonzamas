drop database if exists cafeteria;


create database cafeteria;
use cafeteria;

drop table if exists LineaReserva;
drop table if exists Porducto;
drop table if exists Estanteria;
drop table if exists Almacen;
drop table if exists Categoria;
drop table if exists Reserva;
drop table if exists Empleado;
drop table if exists Users;


create table Users(
    id int primary key auto_increment,
    nombre varchar(100) not null,
    telefono varchar(10) UNIQUE not null,
    email VARCHAR(100) not null,
    password VARCHAR(100) not null,
    tipo ENUM('admin', 'cliente', 'Empleado') not null
);

create table Empleado(
    id_empleado int primary key auto_increment,
    fecha_contratacion date not null,
    puesto varchar(50) not null,
    Foreign Key (id_empleado) REFERENCES Users(id)
);

create table Reserva(
    id_reserva int primary key auto_increment,
    fecha_reserva date not null,
    impuesto_IGIC decimal(5,2) not null,
    subtotal decimal(5,2) not null,
    descuento_total decimal(5,2) not null,
    total decimal(5,2) not null,
    id_cliente int not null,
    id_empleado int not null,
    Foreign Key (id_cliente) REFERENCES Users(id),
    Foreign Key (id_empleado) REFERENCES Empleado(id_empleado)
);

create table Categoria(
    id_categoria int primary key auto_increment,
    nombre varchar(50) not null,
    descripcion varchar(100) not null,
);

create table Almacen(
    cod_almacen int primary key auto_increment,
    direccion varchar(100) not null
);

create table Estanteria(
    cod_estanteria int,
    cod_almacen int,
    capacidad int not null,
    dimensiones varchar(50) not null,
    primary key(cod_estanteria, cod_almacen),
    Foreign Key (cod_almacen) REFERENCES Almacen(cod_almacen)
);

create table Producto(
    id_producto int primary key auto_increment,
    nombre varchar(50) not null,
    precio_unitario decimal(5,2) not null,
    stock int not null,
    id_categoria int,
    cod_estanteria, cod_almacen int,
    Foreign Key (id_categoria) REFERENCES Categoria(id_categoria),
    Foreign Key (cod_estanteria, cod_almacen) REFERENCES Estanteria(cod_estanteria, cod_almacen)
);

create table LineaReserva(
    id_linea int,
    id_reserva int,
    cantidad int not null,
    importe_linea decimal(5,2) not null,
    id_producto int,
    primary key (id_linea, id_reserva),
    Foreign Key (id_reserva) REFERENCES Reserva(id_reserva),
    Foreign Key (id_producto) REFERENCES Producto(id_producto),
);