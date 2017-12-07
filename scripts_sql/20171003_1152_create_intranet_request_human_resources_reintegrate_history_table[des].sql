--intranet request recurso humanos reintegrate history
create table intreqrhrh (
    id varchar(45),
    detail_id varchar(45),

    perdatfror date,
    perdattor date,
    pertimfror time,
    pertimtor time,

    vacdatfror date,
    vacdattor date,

    observar varchar(500),

    created_by varchar(45),
    created_at timestamp,

    updated_by varchar(45),
    updated_at timestamp
)
