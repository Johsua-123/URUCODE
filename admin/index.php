<?php
session_start();
require "../api/mysql.php";
$stmt = $mysql->prepare("SELECT rol FROM usuarios WHERE codigo = ?");
$stmt->bind_param("s", $_SESSION["code"]);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$user || !in_array($user["rol"], ["dueño", "supervisor", "admin", "empleado"])) {
    header("Location: ../index.php");
    exit();
}

//obtiene la fecha de creacion de los usuarios, cuenta la cantidad de estas y las agrupa segun la fecha en orden ascendente
$actividadesUsuarios = $mysql->query("
    SELECT DATE(fecha_creacion) AS fecha, COUNT(*) AS cantidad 
    FROM usuarios GROUP BY DATE(fecha_creacion) ORDER BY fecha ASC
")->fetch_all(MYSQLI_ASSOC);

//obtiene la fecha de creacion de las ordenes, cuenta la cantidad de estas y las agrupa segun la fecha en orden ascendente
$actividadesOrdenes = $mysql->query("
    SELECT DATE(fecha_creacion) AS fecha, COUNT(*) AS cantidad 
    FROM ordenes GROUP BY DATE(fecha_creacion) ORDER BY fecha ASC
")->fetch_all(MYSQLI_ASSOC);

//obtiene el nombre de las categorías y cuenta la cantidad de productos que hay asociados a cada una, agrupa segun el codigo de la categoría y ordena según la cantidad de forma descendente
$categoriasProductos = $mysql->query("
    SELECT c.nombre AS categoria, COUNT(pc.producto_id) AS cantidad 
    FROM categorias c 
    LEFT JOIN productos_categorias pc ON c.codigo = pc.categoria_id 
    GROUP BY c.codigo, c.nombre ORDER BY cantidad DESC
")->fetch_all(MYSQLI_ASSOC);

$data = [
    "usuarios" => $actividadesUsuarios,
    "ordenes" => $actividadesOrdenes,
    "categorias" => $categoriasProductos
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/graficas.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard | Errea</title>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
    <?php include "reusables/navbar.php"; ?>

    <main>
        <div class="container">
            <section class="section">
                <div class="box">
                    <h2>Usuarios Registrados por Fecha</h2>
                    <canvas id="usuariosChart"></canvas>
                </div>
                <div class="box">
                    <h2>Órdenes Registradas por Fecha</h2>
                    <canvas id="ordenesChart"></canvas>
                </div>
                <div class="box">
                    <h2>Productos por Categoría</h2>
                    <canvas id="categoriasChart"></canvas>
                </div>
            </section>
        </div>
    </main>

    <script>
        // De aca recibe ls datos de php
        const data = <?php echo json_encode($data); ?>;

        // Aca se crean las graficas
        function crearGrafico(canvasId, labels, data, label, tipo = "bar", color = "rgba(75, 192, 192)") {
            new Chart(document.getElementById(canvasId), {
                type: tipo,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: `${color.replace(")", ", 0.2)")}`, 
                        borderColor: `${color.replace(")", ", 1)")}`, 
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: "#fff" 
                            }
                        },
                        tooltip: {
                            backgroundColor: "#2a2a3c", 
                            titleColor: "#fff", 
                            bodyColor: "#fff" 
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: "#fff" 
                            }
                        },
                        y: {
                            ticks: {
                                color: "#fff"
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        crearGrafico(
            "usuariosChart",
            data.usuarios.map(u => u.fecha),
            data.usuarios.map(u => u.cantidad),
            "Usuarios registrados por fecha"
        );

        crearGrafico(
            "ordenesChart",
            data.ordenes.map(o => o.fecha),
            data.ordenes.map(o => o.cantidad),
            "Órdenes registradas por fecha",
            "line",
            "rgba(255, 99, 132)"
        );

        crearGrafico(
            "categoriasChart",
            data.categorias.map(c => c.categoria),
            data.categorias.map(c => c.cantidad),
            "Productos por categoría",
            "bar",
            "rgba(54, 162, 235)"
        );
    </script>
</body>
</html>
