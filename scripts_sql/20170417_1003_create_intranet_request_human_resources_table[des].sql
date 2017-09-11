CREATE TABLE INTREQRH (
    ID VARCHAR(45),
    REQNUMBER VARCHAR(45),
    REQTYPE VARCHAR(255), -- TIPO DE SOLICITUD
    REQSTATUS VARCHAR(255), -- STATUS
    REASONREJE VARCHAR(500), -- RAZON DE RECHAZO

    COLUSER VARCHAR(45), --USUARIO
    COLCODE VARCHAR(45), --CODIGO COLABORADOR
    COLNAME VARCHAR(100), --NOMBRE COLABORADOR
    COLPOSI VARCHAR(100), --POSICION
    COLDEPART VARCHAR(100), --DEPARTAMENTO

    COLSUPUSER VARCHAR(45), --SUPERVISOR USUARIO
    COLSUPNAME VARCHAR(100), --SUPERVISOR NOMBRE
    COLSUPPOSI VARCHAR(100), --SUPERVISOR NOMBRE
    APPROVESUP CHAR(1), --APROBADO POR SUPERVISOR [p = pendiente, a = aprobado, r = rechazada]

    RHVERIFIED CHAR(1), --RH VERIFICADO
    RHUSER VARCHAR(45), --RH USUARIO
    RHNAME VARCHAR(45), --RH NOMBRE
    APPROVERH CHAR(1), --APROBADO POR RH

    CANCELLED CHAR(1), --SI ESTA CANCELADO

    CREATED_BY VARCHAR(45),
    CREATENAME VARCHAR(100),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATENAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
