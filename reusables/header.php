
<div class="current-path">
    <a href="index.php">Inicio</a>
    <span>></span>
    <a href="tienda.php?categoria=<?php echo $producto["c.codigo"]; ?>"><?php echo $producto["c.nombre"] ?? ""; ?></a>
    <span>></span>
    <a href="producto.php?producto=<?php echo $proucto["codigo"]; ?>"><?php echo $producto["nombre"] ?? "" ?></a>
</div>