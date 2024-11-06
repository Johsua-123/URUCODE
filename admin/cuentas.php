
<?php 

    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
    }

    $location = "cuentas";

    define("URUCODE", true);
    require "../api/mysql.php";

    $stmt = $mysql->prepare("SELECT * FROM usuarios ORDER BY nombre");
    $stmt->execute();

    $resultado = $stmt->get_result();

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
                <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila["codigo"]; ?></td>
                    <td><?php echo $fila["rol"]; ?></td>
                    <td><?php echo $fila["email"]; ?></td>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["apellido"]; ?></td>
                    <td><?php echo $fila["ubicacion"]; ?></td>
                    <td><?php echo $fila["direccion"]; ?></td>
                    <td><?php echo $fila["telefono"]; ?></td>
                    <td><?php echo $fila["fecha_creacion"]; ?></td>
                    <td>
                        <?php if ($fila["rol"] != "admin"): ?>
                            <form method="post" action="../api/update_role.php" style="display: block; text-align: center;">
                                <input type="hidden" name="codigo" value="<?php echo $fila["codigo"]; ?>">
                                
                                <label>Asignar Rol:</label><br>
                                <select name="nuevo_rol" style="margin-top: 5px;">
                                    <option value="user" <?php if ($fila["rol"] == "user") echo 'selected'; ?>>User</option>
                                    <option value="admin" <?php if ($fila["rol"] == "admin") echo 'selected'; ?>>Admin</option>
                                    <option value="dueño" <?php if ($fila["rol"] == "dueño") echo 'selected'; ?>>Dueño</option>
                                    <option value="supervisor" <?php if ($fila["rol"] == "supervisor") echo 'selected'; ?>>Supervisor</option>
                                    <option value="empleado" <?php if ($fila["rol"] == "empleado") echo 'selected'; ?>>Empleado</option>
                                </select>
                                <br>
                                <button type="submit" name="accion" value="actualizar" style="margin-top: 5px;">Actualizar Rol</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </main>
    </div>
</body>
</html>
