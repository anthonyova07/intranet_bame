CREATE TABLE INTRANET_EVENT_SUBSCRIPTIONS (
    EVENT_ID VARCHAR(45),
    USERNAME VARCHAR(45),
    NAMES VARCHAR(45),
    IS_SUBSCRIBE CHAR(1),
    UNSUBSCRIPTION_REASON VARCHAR(150),
    CREATED_AT TIMESTAMP,
    UPDATED_AT TIMESTAMP
)
