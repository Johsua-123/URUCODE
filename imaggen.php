<?php
// Listar todos los archivos en la carpeta public/images/
$images = glob('public/images/*.*');
foreach ($images as $image) {
    echo basename($image) . "<br>";
}
?>
