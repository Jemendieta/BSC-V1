<?php
session_start();
$idempresa=$_SESSION['id_empresa'];
include('../conexion.php');

$dato = $_POST['dato'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = mysql_query("SELECT * FROM producto p,categoria c WHERE p.idcategoria=c.idcategoria and p.idempresa='$idempresa' and producto like '%$dato%' limit 500");

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="200">Producto</th>
				<th width="200">Stock</th>
				<th width="200">Categoria</th>
				<th width="200">Ver Detalle</th>
            </tr>';
if(mysql_num_rows($registro)>0){
	while($registro2 = mysql_fetch_array($registro)){
		echo '<tr>
				<td>'.utf8_encode($registro2['producto']).'</td>
				<td>'.$registro2['stock'].'</td>
				<td>'.$registro2['categoria'].'</td>
				<td><button onclick="javascript:verdetalle('.utf8_encode($registro2['idproducto']).');" class="btn btn-block btn-primary btn-ls"><i class="glyphicon glyphicon-eye-open"></i> Ver detalle</button></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>