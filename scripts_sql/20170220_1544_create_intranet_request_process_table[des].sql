CREATE TABLE INTREQPR (
    ID VARCHAR(45),
    REQNUMBER VARCHAR(45),
    REQTYPE VARCHAR(255), -- TIPO DE SOLICITUD
    PROCESS VARCHAR(90),  -- PROCESO IMPACTADO
    SUBPROCESS VARCHAR(90), -- SUBPROCESO IMPACTADO
    NOTE VARCHAR(1000), -- DESCRIPCION
    CAUSEANALY VARCHAR(1000), -- ANALISIS DE CAUSA
    PEOINVOLVE VARCHAR(1000), --PERSONAS INVOLUCRADAS
    DELIVERABL VARCHAR(1000), -- ENTREGABLES
    OBSERVATIO VARCHAR(1000), -- OBSERVACIONES
    USRAPPROVE VARCHAR(1000), -- USUARIOS QUE APRUEBAN

    CREATED_BY VARCHAR(45),
    CREATED_BY_NAME VARCHAR(100),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATED_BY_NAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
