CREATE TABLE INTRANET_EVENTS (
    ID VARCHAR(45),
    TITLE VARCHAR(150),
    DETAIL VARCHAR(10000),
    IMAGE VARCHAR(100),
    END_SUBSCRIPTIONS TIMESTAMP,
    START_EVENT TIMESTAMP,
    IS_ACTIVE CHAR(1),
    LIMIT_PERSONS CHAR(1),
    NUMBER_PERSONS INTEGER,
    LIMIT_ACCOMPANISTS CHAR(1),
    NUMBER_ACCOMPANISTS INTEGER,
    DEPARTMENT VARCHAR(50),
    CREATED_BY VARCHAR(45),
    UPDATED_BY VARCHAR(45),
    CREATED_AT TIMESTAMP,
    UPDATED_AT TIMESTAMP
)
