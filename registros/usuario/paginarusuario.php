<?php
session_start();
$idempresa=$_SESSION['id_empresa'];
	include('../conexion.php');
	$paginaActual = $_POST['partida'];

    $nroProductos = mysql_num_rows(mysql_query("SELECT * FROM usuario u,tipousuario tu,area a,empresa e where u.idtipousuario=tu.idtipousuario and u.idarea=a.idarea and u.idempresa=e.idempresa and u.idempresa='$idempresa'"));
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

  	$registro = mysql_query("SELECT * FROM usuario u,tipousuario tu,area a,empresa e where u.idtipousuario=tu.idtipousuario and u.idarea=a.idarea and u.idempresa=e.idempresa and u.idempresa='$idempresa' LIMIT $limit, $nroLotes ");


  	$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			            <tr>
			                <th width="50">Login</th>
							<th width="50">DNI</th>
							<th width="50">Nombres</th>
							<th width="50">Apellidos</th>
							<th width="50">Email</th>
							<th width="50">Tipo Usuario</th>
							<th width="50">Area</th>
							<th width="50">Empresa</th>
			                <th width="50">Opciones</th>
			            </tr>';
				
	while($registro2 = mysql_fetch_array($registro)){
		$tabla = $tabla.'<tr>
							<td>'.$registro2['login'].'</td>
							<td>'.$registro2['dni'].'</td>
							<td>'.$registro2['nombres'].'</td>
							<td>'.$registro2['apellidos'].'</td>
							<td>'.$registro2['correo'].'</td>
							<td>'.$registro2['tipousuario'].'</td>
							<td>'.$registro2['area'].'</td>
							<td>'.$registro2['razonsocial'].'</td>
				<td><a href="javascript:editarusuario('.$registro2['idusuario'].');" class="glyphicon glyphicon-edit"></a> <a href="javascript:eliminarusuario('.$registro2['idusuario'].');" class="glyphicon glyphicon-remove-circle"></a></td>
						  </tr>';		
	}
        

    $tabla = $tabla.'</table>';



    $array = array(0 => $tabla,
    			   1 => $lista);

    echo json_encode($array);
?>