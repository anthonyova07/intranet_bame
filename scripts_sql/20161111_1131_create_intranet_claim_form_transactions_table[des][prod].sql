CREATE TABLE INTRANET_CLAIM_FORM_TRANSACTIONS (
    ID VARCHAR(45),
    FORM_ID VARCHAR(45),
    FORM_TYPE VARCHAR(45),
    TRANSACTION_DATE TIMESTAMP,
    MERCHANT_NAME VARCHAR(150),
    COUNTRY VARCHAR(45),
    CITY VARCHAR(45),
    AMOUNT DECIMAL(10,2)
)