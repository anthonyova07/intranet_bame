CREATE TABLE INTREQRHDE (
    ID VARCHAR(45),
    REQ_ID VARCHAR(45),

    --SOLICITUDES PERMISOS

    PERTYPE VARCHAR(45), --TIPO DE PERMISO (ONE_DAY, MULTIPLE_DAYS)

    PERDATFROM DATE, --FECHA DEL PERMISO SI ES ONE_DAY O FECHA DESDE SI ESE MULTIPLE_DAYS,
    PERTIMFROM TIME, --HORA DEL PERMISO DESDE,
    PERTIMTO TIME, --HORA DEL PERMISO HASTA,

    PERDATTO DATE, --FECHA HASTA DEL PERSMISO SI ES MULTIPLE_DAYS

    PAID CHAR(1), --SI ES REMUNERADO O NO
    REAFORABSE CHAR(1), --RAZON DE LA AUSENCIA

    --SOLICITUDES VACACINOES

    VACDATADMI DATE, --FECHA DE INGRESO
    VACDATFROM DATE, --FECHA DE INICIO
    VACDATTO DATE, --FECHA DE REINTEGRO
    VACTOTDAYS INTEGER, --TOTAL DE DIAS A TOMAR
    VACOUTDAYS INTEGER, --DIAS PENDIENTE POR TOMAR
    VACACCBONU CHAR(1), --ACREDITAR BONO VACACIONAL

    DAYSCORRES INTEGER, --DIAS CORRESPONDIENTES
    DAYSTAKEDM INTEGER, --DIAS TOMANDOS AL MOMENTO
    DAYSPENDIN INTEGER, --DIAS PENDIENTES
    APPLYBONUS CHAR(1), --APLICA BONO VACACIONAL
    DATEBONUS DATE, --FECHA A PAGAR BONO VACACIONAL SI APLICA
    DATEBONUSD DATE, --FECHA A PAGAR DIFERENCIAL VACACAIONES SI APLICA
    NOTE VARCHAR(1000), --OBSERVACION

    CREATED_BY VARCHAR(45),
    CREATENAME VARCHAR(100),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATENAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
