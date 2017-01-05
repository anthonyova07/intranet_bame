CREATE TABLE INTRANET_CLAIM_PARAM (
    ID VARCHAR(45),
    TYPE VARCHAR(45), -- CT = claim_types, DC = Distrubution Channles, VISA
    CODE VARCHAR(45),
    DESCRIPTION VARCHAR(255),

    ES_NAME VARCHAR(500),
    ES_DETAIL VARCHAR(500),
    ES_DETAIL_2 VARCHAR(500),
    EN_NAME VARCHAR(500),
    EN_DETAIL VARCHAR(500),
    EN_DETAIL_2 VARCHAR(500),

    IS_ACTIVE CHAR(1),
    CREATED_BY VARCHAR(45),
    UPDATED_BY VARCHAR(45),
    CREATED_AT TIMESTAMP,
    UPDATED_AT TIMESTAMP
)