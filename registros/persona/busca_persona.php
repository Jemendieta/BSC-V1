<?php
session_start();
$idempresa=$_SESSION['id_empresa'];
include('../conexion.php');

$dato = $_POST['dato'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = mysql_query("SELECT * FROM persona p,tipopersona tp where p.idtipopersona=tp.idtipopersona and idempresa='$idempresa' and razonsocial LIKE '%$dato%' ORDER BY idpersona ASC limit 15");

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="50">RUC</th>
							<th width="50">Razon Social</th>
							<th width="50">Direcci&oacute;n</th>
							<th width="50">Tel&eacute;fono</th>
							<th width="50">Movil</th>
							<th width="50">Correo</th>
							<th width="50">Tipo</th>
			                <th width="50">Opciones</th>
			            </tr>';
if(mysql_num_rows($registro)>0){
	while($registro2 = mysql_fetch_array($registro)){
		echo '<tr>
							<td>'.$registro2['ruc'].'</td>
							<td>'.utf8_encode($registro2['razonsocial']).'</td>
							<td>'.utf8_encode($registro2['direccion']).'</td>
							<td>'.$registro2['telefono'].'</td>
							<td>'.$registro2['movil'].'</td>
							<td>'.$registro2['email'].'</td>
							<td>'.$registro2['tipopersona'].'</td>
							<td><a href="javascript:editarpersona('.$registro2['idpersona'].');" class="glyphicon glyphicon-edit"></a> <a href="javascript:eliminarpersona('.$registro2['idpersona'].');" class="glyphicon glyphicon-remove-circle"></a></td>
						  </tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>