-- SQLBook: Code

-- Creacion de usuarios

use urucode;

grant insert, select, update, delete on * to "dueno" identified by "dueno";

grant insert, select, update on * to "supervisor" identified by "supervisor";

grant insert, select, update, delete on * to "administrador" to "administrador" identified by "administrador";

grant insert, select, update on services to "empleado" identified by "empleado";

grant insert, select, update on sales_details to "empleado";

grant insert, select, update on sales to "empleado";

grant select on payments to "empleado";


