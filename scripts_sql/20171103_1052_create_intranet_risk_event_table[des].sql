create table intriskeve (
    id varchar(45),
    event_code varchar(45), -- numero del evento
    is_event char(1), -- marca si es o no evento

    busineline varchar(45), -- linea de negocio
    event_type varchar(45), -- tipo de evento
    curre_type varchar(45), -- tipo de divisas
    bran_offic varchar(45), -- sucursal
    area_depar varchar(45), -- area o departamento
    dist_chann varchar(45), -- canal de distribucion
    process varchar(45), -- proceso
    subprocess varchar(45), -- subproceso

    descriptio varchar(150), -- descripcion
    consequenc varchar(150), -- consequencia
    assoc_cont varchar(150), -- control asociado

    loss_type varchar(45), -- tipo de perdida
    event_star date, -- inicio del evento
    event_end date, -- fin del evento
    event_disc date, -- fecha de descubrimiento
    risk_link varchar(45), -- riesgo vinculado
    risk_facto varchar(45), -- factor de riesgo
    rcreatedby varchar(45), -- creador de riesgo
    rcreatenam varchar(100), -- creador de riesgo nombre
    rcreatedat timestamp, -- creador riesgo fecha

    post_date date, -- fecha de contabilizacion
    amount_nac decimal(12,2), -- monto perdida moneda nacional
    amount_ori decimal(12,2), -- monto perdida moneda origen
    amount_ins decimal(12,2), -- monto recuperado por seguro
    amount_rec decimal(12,2), -- monto recuperado
    account varchar(45), -- cuenta contable
    ccreatedby varchar(45), -- creador de contabilidad
    ccreatenam varchar(100), -- creador de contabilidad nombre
    ccreatedat timestamp, -- creador contabilidad fecha

    created_by varchar(45),
    createname varchar(100),
    created_at timestamp,

    updated_by varchar(45),
    updatename varchar(100),
    updated_at timestamp
)
