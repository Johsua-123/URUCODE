<?php 
session_start();

if (!isset($_SESSION["code"])) {
    header("Location: ../index.php");
    exit();
}
$location = "accounts";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/products.css">
    <title>Cuentas | Errea Admin</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <div class="container">
        <?php include "reusables/navbar.php"; ?>
        <main style="padding-left: 10px">
            <h1>Listado de Cuentas</h1>

            <?php
            require "../api/mysql.php";
            if ($mysql->connect_error) {
                die("Conexión fallida: " . $mysql->connect_error);
            }
            $sql = "SELECT codigo, rol, email, nombre, apellido, ubicacion, direccion, telefono, fecha_creacion FROM usuarios WHERE eliminado = 0";
            $result = $mysql->query($sql);
            ?>

            <table class="accounts-table">
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Ubicación</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["codigo"]; ?></td>
                    <td><?php echo $row["rol"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["nombre"]; ?></td>
                    <td><?php echo $row["apellido"]; ?></td>
                    <td><?php echo $row["ubicacion"]; ?></td>
                    <td><?php echo $row["direccion"]; ?></td>
                    <td><?php echo $row["telefono"]; ?></td>
                    <td><?php echo $row["fecha_creacion"]; ?></td>
                    <td>
                        <?php if ($row["rol"] != "admin"): ?>
                            <form method="post" action="../api/update_role.php" style="display: block; text-align: center;">
                                <input type="hidden" name="codigo" value="<?php echo $row["codigo"]; ?>">
                                
                                <label>Asignar Rol:</label><br>
                                <select name="nuevo_rol" style="margin-top: 5px;">
                                    <option value="user" <?php if ($row["rol"] == "user") echo 'selected'; ?>>User</option>
                                    <option value="admin" <?php if ($row["rol"] == "admin") echo 'selected'; ?>>Admin</option>
                                    <option value="dueño" <?php if ($row["rol"] == "dueño") echo 'selected'; ?>>Dueño</option>
                                    <option value="supervisor" <?php if ($row["rol"] == "supervisor") echo 'selected'; ?>>Supervisor</option>
                                    <option value="empleado" <?php if ($row["rol"] == "empleado") echo 'selected'; ?>>Empleado</option>
                                </select>
                                <br>
                                <button type="submit" name="accion" value="actualizar" style="margin-top: 5px;">Actualizar Rol</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>

            <?php $mysql->close(); ?>
        </main>
    </div>
</body>
</html>
