ALTER TABLE INTCURETDC ADD DELETED_AT TIMESTAMP
ALTER TABLE INTCURETDC ADD DELETENAME VARCHAR(100) BEFORE DELETED_AT
ALTER TABLE INTCURETDC ADD DELETED_BY VARCHAR(45) BEFORE DELETENAME
ALTER TABLE INTCURETDC ADD DELETEREAS VARCHAR(500) BEFORE DELETED_BY --RAZON DE LA ELIMINACION

ALTER TABLE INTCURETDC ALTER COLUMN CHANNEL SET DATA TYPE VARCHAR(20)
ALTER TABLE INTCURETPR ALTER COLUMN CHANNEL SET DATA TYPE VARCHAR(20)

ALTER TABLE INTCURETPR ADD BUSINESS VARCHAR(150) BEFORE PRODUCTTYP