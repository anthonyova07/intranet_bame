CREATE TABLE INTREQPRAP (
    ID VARCHAR(45),
    REQ_ID VARCHAR(45),
    USERAPPROV VARCHAR(45),
    USERNAME VARCHAR(100),
    TITLE VARCHAR(150),
    COMMENT VARCHAR(1000),
    APPROVED CHAR(1),
    APPROVDATE TIMESTAMP,

    CREATED_BY VARCHAR(45),
    CREATENAME VARCHAR(100),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATENAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
