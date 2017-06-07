CREATE TABLE INTTRRAPRO (
    ID VARCHAR(45),
    NAME VARCHAR(100),
    RATE_TYPE CHAR(1), --P = pasivo, A = activo
    CONTENT CHAR(1),--R = rangos, V = valores, U = unico
    RANGES VARCHAR(500),
    IS_ACTIVE CHAR(1),
    CREATED_BY VARCHAR(45),
    UPDATED_BY VARCHAR(45),
    CREATED_AT TIMESTAMP,
    UPDATED_AT TIMESTAMP
)
