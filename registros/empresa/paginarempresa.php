<?php
session_start();
$idempresa = $_SESSION['id_empresa'];
	include('../conexion.php');
	$paginaActual = $_POST['partida'];

    $nroProductos = mysql_num_rows(mysql_query("SELECT * FROM empresa where idempresa='$idempresa'"));
    $nroLotes = 15;
    $nroPaginas = ceil($nroProductos/$nroLotes);
    $lista = '';
    $tabla = '';

    if($paginaActual > 1){
        $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual-1).');">Anterior</a></li>';
    }
    for($i=1; $i<=$nroPaginas; $i++){
        if($i == $paginaActual){
            $lista = $lista.'<li class="active"><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
        }else{
            $lista = $lista.'<li><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
        }
    }
    if($paginaActual < $nroPaginas){
        $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual+1).');">Siguiente</a></li>';
    }
  
  	if($paginaActual <= 1){
  		$limit = 0;
  	}else{
  		$limit = $nroLotes*($paginaActual-1);
  	}

  	$registro = mysql_query("SELECT * FROM empresa where idempresa='$idempresa' LIMIT $limit, $nroLotes ");


  	$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			            <tr>
			                <th width="50">RUC</th>
							<th width="50">Razon Social</th>
							<th width="50">Direcci&oacute;n</th>
							<th width="50">Tel&eacute;fono</th>
							<th width="50">Movil</th>
							<th width="50">Correo</th>
			                <th width="50">Opciones</th>
			            </tr>';
				
	while($registro2 = mysql_fetch_array($registro)){
		$tabla = $tabla.'<tr>
							<td>'.$registro2['ruc'].'</td>
							<td>'.utf8_encode($registro2['razonsocial']).'</td>
							<td>'.utf8_encode($registro2['direccion']).'</td>
							<td>'.$registro2['telefono'].'</td>
							<td>'.$registro2['movil'].'</td>
							<td>'.$registro2['email'].'</td>
							<td><a href="javascript:editarempresa('.$registro2['idempresa'].');" class="glyphicon glyphicon-edit"></a> <a href="javascript:eliminarempresa('.$registro2['idempresa'].');" class="glyphicon glyphicon-remove-circle"></a></td>
						  </tr>';		
	}
        

    $tabla = $tabla.'</table>';



    $array = array(0 => $tabla,
    			   1 => $lista);

    echo json_encode($array);
?>