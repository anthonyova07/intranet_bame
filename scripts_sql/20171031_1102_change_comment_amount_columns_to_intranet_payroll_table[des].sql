--crear tabla temporal
create table intrhpayrd_temp (
    id varchar(45),
    payroll_id varchar(45),

    transdate date,
    code varchar(500),
    comment varchar(500),
    amount varchar(500)
);

--migrar los datos a la tabla temporal
insert into intrhpayrd_temp select * from intrhpayrd

--eliminar la tabla para cambiar la columna amount a texto
drop table intrhpayrd

--recrear la tabla con la columna amount correcta
create table intrhpayrd (
    id varchar(45),
    payroll_id varchar(45),

    transdate date,
    code varchar(500),
    comment varchar(500),
    amount varchar(500)
)
--ejecutar proceso para migrar la data

--despues de migrar los datos borramos la tabla temporal
drop table intrhpayrd_temp
