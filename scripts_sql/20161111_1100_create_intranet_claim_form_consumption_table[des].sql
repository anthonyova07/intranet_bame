CREATE TABLE INTRANET_CLAIM_FORMS (
    ID VARCHAR(45),
    CLAIM_ID VARCHAR(45),
    FORM_TYPE VARCHAR(45),

    CLAIM_ES_NAME VARCHAR(500),
    CLAIM_ES_DETAIL VARCHAR(500),
    CLAIM_ES_DETAIL_2 VARCHAR(500),
    CLAIM_EN_NAME VARCHAR(500),
    CLAIM_EN_DETAIL VARCHAR(500),
    CLAIM_EN_DETAIL_2 VARCHAR(500),

    ARREARS_LEVEL INTEGER,

    CAPITAL DECIMAL(10,2),
    CAPITAL_DISCOUNT_PERCENT INTEGER,
    CAPITAL_TOTAL DECIMAL(10,2),

    INTEREST DECIMAL(10,2),
    INTEREST_DISCOUNT_PERCENT INTEGER,
    INTEREST_TOTAL DECIMAL(10,2),

    ARREARS DECIMAL(10,2),
    ARREARS_DISCOUNT_PERCENT INTEGER,
    ARREARS_TOTAL DECIMAL(10,2),

    CHARGES DECIMAL(10,2),
    CHARGES_DISCOUNT_PERCENT INTEGER,
    CHARGES_TOTAL DECIMAL(10,2),

    OTHERS_CHARGES DECIMAL(10,2),
    OTHERS_CHARGES_DISCOUNT_PERCENT INTEGER,
    OTHERS_CHARGES_TOTAL DECIMAL(10,2),

    TOTAL_TO_REVERSE DECIMAL(10, 2),

    COMMENTS VARCHAR(500),

    RESPONSE_DATE DATE,

    CREATED_BY VARCHAR(45),
    CREATED_BY_NAME VARCHAR(100),
    CREATED_BY_PHONE VARCHAR(45),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATED_BY_NAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
