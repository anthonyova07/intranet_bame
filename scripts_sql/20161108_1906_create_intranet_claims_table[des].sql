CREATE TABLE INTRANET_CLAIMS (
    ID VARCHAR(45),
    CLAIM_NUMBER VARCHAR(45),
    CUSTOMER_NUMBER INTEGER,
    NAMES VARCHAR(100),
    LAST_NAMES VARCHAR(100),
    IS_COMPANY CHAR(1),
    IDENTIFICATION VARCHAR(45),
    PASSPORT VARCHAR(45),
    LEGAL_NAME VARCHAR(150),
    RESIDENTIAL_PHONE VARCHAR(45),
    OFFICE_PHONE VARCHAR(45),
    CELL_PHONE VARCHAR(45),
    FAX_PHONE VARCHAR(45),
    MAIL VARCHAR(100),
    STREET_ADDRESS VARCHAR(100),
    STREET_NUMBER VARCHAR(45),
    SECTOR_ADDRESS VARCHAR(45),
    BUILDING_RESIDENTIAL VARCHAR(45),
    APARTMENT_NUMBER VARCHAR(45),
    CITY VARCHAR(100),
    PROVINCE VARCHAR(100),
    CURRENCY CHAR(3),
    AMOUNT DECIMAL(10,2),
    RESPONSE_TERM INTEGER,
    RESPONSE_PLACE VARCHAR(45),
    RESPONSE_DATE DATE,
    OBSERVATIONS VARCHAR(10000),
    RATE_DAY DECIMAL(10,2),
    IS_SIGNED CHAR(1),

    CLAIM_TYPE_CODE VARCHAR(45),
    CLAIM_TYPE_DESCRIPTION VARCHAR(255),

    IS_APPROVED CHAR(1),
    APPROVED_BY VARCHAR(45),
    APPROVED_BY_NAME VARCHAR(100),
    APPROVED_COMMENTS VARCHAR(500),
    APPROVED_DATE TIMESTAMP,

    PROCEED_CREDIT CHAR(1),

    IS_CLOSED CHAR(1),
    CLOSED_BY VARCHAR(45),
    CLOSED_BY_NAME VARCHAR(100),
    CLOSED_COMMENTS VARCHAR(500),
    CLOSED_DATE TIMESTAMP,

    CLAIM_RESULT CHAR(1),

    CLAIM_STATUS_CODE VARCHAR(45),
    CLAIM_STATUS_DESCRIPTION VARCHAR(500),

    SOLVED_BY VARCHAR(45),
    SOLVED_BY_NAME VARCHAR(100),
    SOLVED_DATE TIMESTAMP,

    KIND_PERSON_CODE VARCHAR(45),
    KIND_PERSON_DESCRIPTION VARCHAR(255),

    DISTRIBUTION_CHANNEL VARCHAR(255),
    PRODUCT_TYPE VARCHAR(100),
    PRODUCT_NUMBER VARCHAR(45),
    PRODUCT_CODE VARCHAR(45),
    PRODUCT_INTRANET VARCHAR(45),

    AGENT_LEGAL_NAME VARCHAR(150),
    AGENT_IDENTIFICATION VARCHAR(45),
    AGENT_RESIDENTIAL_PHONE VARCHAR(45),
    AGENT_OFFICE_PHONE VARCHAR(45),
    AGENT_CELL_PHONE VARCHAR(45),
    AGENT_FAX_PHONE VARCHAR(45),
    AGENT_MAIL VARCHAR(100),

    RECEIVED_BY VARCHAR(45),
    RECEIVED_BY_NAME VARCHAR(100),
    RECEIVED_AT TIMESTAMP,

    CREATED_BY VARCHAR(45),
    CREATED_BY_NAME VARCHAR(100),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATED_BY_NAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
