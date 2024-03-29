CREATE TABLE INTRHEMPLO (
    ID VARCHAR(45),

    RECORDCARD VARCHAR(45),
    NAME VARCHAR(150),
    IDENTIFICA VARCHAR(45),

    USEREMP VARCHAR(45),
    MAIL VARCHAR(150),

    BIRTHDATE DATE,
    SERVICEDAT DATE,

    GENDER char(1),

    IS_ACTIVE CHAR(1),

    ID_POS VARCHAR(45), --ID DE LA POSICION
    ID_DEP VARCHAR(45), --ID DEL DEPARTAMENTO
    ID_SUP VARCHAR(45), --ID DEL SUPERVISOR

    CREATED_BY VARCHAR(45),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATED_AT TIMESTAMP
)
