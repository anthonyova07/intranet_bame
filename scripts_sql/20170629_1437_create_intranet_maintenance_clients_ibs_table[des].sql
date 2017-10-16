CREATE TABLE INTMAIIBS (
    ID VARCHAR(45),

    CLINUMBER VARCHAR(45),
    CLIIDENT VARCHAR(45),
    TYPECORE VARCHAR(45), --ibs,itc

/********************** IBS ********************/
    IBSSTREET VARCHAR(45),
    IBSBUHOUNU VARCHAR(45),
    IBSCOUNTRY VARCHAR(45),

    IBSPROVINC VARCHAR(45),
    IBSPROVIND VARCHAR(45),

    IBSCITYC VARCHAR(45),
    IBSCITYD VARCHAR(45),

    IBSSECTORC VARCHAR(45),
    IBSSECTORD VARCHAR(45),

    IBSPOSMAIL VARCHAR(45),
    IBSZIPCODE VARCHAR(45),
    IBSMAIL VARCHAR(100),

    IBSHOUPHON VARCHAR(45),
    IBSOFFIPHO VARCHAR(45),
    IBSFAXPHON VARCHAR(45),
    IBSMOVIPHO VARCHAR(45),

/********************** ITC ********************/

    TDCNUMBER VARCHAR(510),

/********************** APPROVE ********************/

    ISAPPROV CHAR(1),
    APPROVBY VARCHAR(45),
    APPROVNAME VARCHAR(100),
    APPROVDATE TIMESTAMP,

    CREATED_BY VARCHAR(45),
    CREATENAME VARCHAR(100),
    CREATED_AT TIMESTAMP,

    UPDATED_BY VARCHAR(45),
    UPDATENAME VARCHAR(100),
    UPDATED_AT TIMESTAMP
)
