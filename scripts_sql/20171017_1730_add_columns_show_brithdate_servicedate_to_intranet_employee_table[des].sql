alter table intrhemplo add show_birth char(1) before id_pos

alter table intrhemplo add show_servi char(1) before id_pos

update intrhemplo set show_birth = '1', show_servi = '1'