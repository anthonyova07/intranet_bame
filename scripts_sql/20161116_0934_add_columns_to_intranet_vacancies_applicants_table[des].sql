ALTER TABLE INTRANET_VACANCIES_APPLICANTS ADD IS_ELIGIBLE_FOR_VACANCIES CHAR(1) BEFORE CREATED_AT

ALTER TABLE INTRANET_VACANCIES_APPLICANTS ADD VACANCIES_POSIBLE VARCHAR(255) BEFORE CREATED_AT
