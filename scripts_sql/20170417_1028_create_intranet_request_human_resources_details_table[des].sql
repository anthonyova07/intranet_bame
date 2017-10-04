CREATE TABLE INTREQRHDE (
    ID VARCHAR(45),
    REQ_ID VARCHAR(45),

    --SOLICITUDES PERMISOS

    PERTYPE VARCHAR(45), --TIPO DE PERMISO (ONE_DAY, MULTIPLE_DAYS)

    PERDATFROM DATE, --FECHA DEL PERMISO SI ES ONE_DAY O FECHA DESDE SI ESE MULTIPLE_DAYS,
    PERDATFROR DATE, --FECHA DEL PERMISO DE REINTEGRO SI ES ONE_DAY O FECHA DESDE SI ESE MULTIPLE_DAYS,
    PERDATTO DATE, --FECHA HASTA DEL PERSMISO SI ES MULTIPLE_DAYS
    PERDATTOR DATE, --FECHA HASTA DE REINTEGRO DEL PERSMISO SI ES MULTIPLE_DAYS

    PERTIMFROM TIME, --HORA DEL PERMISO DESDE,
    PERTIMFROR TIME, --HORA DEL PERMISO DESDE reintegro,
    PERTIMTO TIME, --HORA DEL PERMISO HASTA,
    PERTIMTOR TIME, --HORA HASTA DE REINTEGRO DEL PERMISO,

    OBSERVAR VARCHAR(500), --OBSERVACION PARA LA FECHA DE REINTEGRO

    PAID CHAR(1), --SI ES REMUNERADO O NO
    PAID_REASON VARCHAR(500), --RAZON DE REMUNERADO
    CODEFORABS VARCHAR(45), -- CODIGO DE LA AUSENCIA
    REAFORABSE VARCHAR(1000), --RAZON DE LA AUSENCIA

    --SOLICITUDES VACACIONES

    VACDATADMI DATE, --FECHA DE INGRESO
    VACDATFROM DATE, --FECHA DE INICIO
    VACDATFROR DATE, --FECHA DE INICIO reintegro
    VACDATTO DATE, --FECHA DE REINTEGRO
    VACDATTOR DATE, --FECHA DE REINTEGRO si se cancelan antes
    VACTOTDAYS INTEGER, --TOTAL DE DIAS A TOMAR
    VACADDDAYS INTEGER, --DIAS ADICIONALES
    VACOUTDAYS INTEGER, --DIAS PENDIENTE POR TOMAR
    VACACCBONU CHAR(1), --ACREDITAR BONO VACACIONAL

    DAYSCORRES INTEGER, --DIAS CORRESPONDIENTES
    DAYSTAKEDM INTEGER, --DIAS TOMANDOS AL MOMENTO
    DAYSPENDIN INTEGER, --DIAS PENDIENTES
    APPLYBONUS CHAR(1), --APLICA BONO VACACIONAL
    BONUSYEAR VARCHAR(20), --AÑO APLICA BONO VACACIONAL
    BONUSREA VARCHAR(150), --MOTIVO APLICA BONO VACACIONAL
    DATEBONUS DATE, --FECHA A PAGAR BONO VACACIONAL SI APLICA
    DATEBONUSD DATE, --FECHA A PAGAR DIFERENCIAL VACACAIONES SI APLICA

    --SOLICITUDES ANTICIPOS

    IDENTIFICA VARCHAR(50), --IDENTIFICACION
    SAVACCOUNT VARCHAR(50), --CUENTA DE AHORRO
    ADVAMOUNT DECIMAL(8,2), --MONTO DEL ANTICIPOS
    ADVDUES INTEGER, --CUOTAS DEL ANTICIPOS
    ADVDUEAMOU DECIMAL(8,2), --MONTO DE CUOTAS

    CLIENTNUM VARCHAR(45), --NUMERO DE CLIENTE
    ADVNUMBER VARCHAR(45), --NUMERO DEL ANTICIPOS
    ADVDATDEPO DATE, --FECHA DEL DEPOSITO DEL ANTICIPOS
    FIRSDUEDAT DATE, --FECHA DEL PRIMER DESCUENTO
    LASTDUEDAT DATE, --FECHA DEL ULTIIMO DESCUENTO

    OBSERVA VARCHAR(1000), --OBSERVACION EMPLEADO
    NOTE VARCHAR(1000), --OBSERVACION RH

    --SOLICITUDES CARTA DE TRABAJO

    CARADDRETO VARCHAR(200),
    CARCOMMENT VARCHAR(300),

    --TIMESTAMPS

    CREATED_BY VARCHAR(45),
    CREATENAME VARCHAR(100),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATENAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
