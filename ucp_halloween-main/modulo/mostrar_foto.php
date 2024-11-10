<?php
include('../php/conexion.php');
conectar();

$sql = mysqli_query($con, "SELECT foto_blob FROM disfraces WHERE id =".$_GET['id']);
$r = mysqli_fetch_array($sql);
header("Content-type: image/jpg");
echo $r['foto_blob'];
?>