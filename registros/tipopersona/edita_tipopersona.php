<?php
include('../conexion.php');

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = mysql_query("SELECT * FROM tipopersona WHERE idtipopersona = '$id'");
$valores2 = mysql_fetch_array($valores);

$datos = array(
				0 => $valores2['tipopersona'], 
				);
echo json_encode($datos);
?>