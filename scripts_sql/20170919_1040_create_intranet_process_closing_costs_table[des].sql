--process closing costs
create table intproccos (
    id varchar(45),

    credtyp_id varchar(45), --tipo de credito
    warrant_id varchar(45), --tipo de garantia

    ranks varchar(150), -- rangos

    onlyrate char(1),
    rate varchar(45), -- tarifas

    created_by varchar(45),
    createname varchar(100),
    created_at timestamp,

    updated_by varchar(45),
    updatename varchar(100),
    updated_at timestamp
)
