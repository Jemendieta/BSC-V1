<LINK href="dist/css/AdminLTE.min.css" type=text/css rel=stylesheet>
<LINK href="estilos.css" type=text/css rel=stylesheet>
<link href="../css/forms.css" rel="stylesheet" type="text/css" />
<?php
function OpenConexion(){
$host = "localhost";
$base = "bdbalancedscore";
$link=mysql_connect($host,"root","") or die("Error de conexion al servidor");
$db=mysql_select_db($base, $link) or die("Error de conexion a la BD");
return $link;
}

function CloseConexion(){
Global $link;
	mysql_close($link);
}

function autogeneradolote($tabla,$campocodigo,$numcaracteres){
Global $link;
	$numcaracteres=$numcaracteres*(-1);
	$rsTabla=mysql_query("select count($campocodigo) from $tabla",$link);
	$ATabla=mysql_fetch_array($rsTabla);
	$nreg=$ATabla[0];
	if($nreg>0)	{
		$rsTabla=mysql_query("select $campocodigo from $tabla",$link);
		mysql_data_seek($rsTabla,$nreg-1);
		$ATabla=mysql_fetch_array($rsTabla);
	}
	$cod=$ATabla[0]+50;
	$cod="00000000000000".$cod;
	$generado=substr($cod,$numcaracteres);
	mysql_free_result($rsTabla);
	return $generado;
}

function autogenerado($tabla,$campocodigo,$numcaracteres){
Global $link;
	$numcaracteres=$numcaracteres*(-1);
	$rsTabla=mysql_query("select count($campocodigo) from $tabla",$link);
	$ATabla=mysql_fetch_array($rsTabla);
	$nreg=$ATabla[0];
	if($nreg>0)	{
		$rsTabla=mysql_query("select $campocodigo from $tabla",$link);
		mysql_data_seek($rsTabla,$nreg-1);
		$ATabla=mysql_fetch_array($rsTabla);
	}
	$cod=$ATabla[0]+1;
	$cod="00000000000000".$cod;
	$generado=substr($cod,$numcaracteres);
	mysql_free_result($rsTabla);
	return $generado;
}

function Msg($title,$message){
	echo "<html><head><title>Message</title><link href='../estilos/style.css' rel=stylesheet type='text/css'></head><body>";
	echo "<div align=center><br><br><br>";
	echo "<table width=40% border=0 cellspacing=0 cellpadding=2>";
	echo "<br><br><br><br><br><br><br><br><br><tr class=T><td align=center height=30>$title</td></tr>";
	echo "<tr><td align=center height=30>$message</td></tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr class=T><td>&nbsp;</td></tr>";
	echo "</table>";
	echo "</div></body></html>";
}
function paginar($sql,$tabla,$mantenimiento) {
Global $ordenarpor;
Global $ordenactual;
Global $sentido;
Global $pagina;
	$limite=6;
	$rs=mysql_query($sql) or die("Error en la consulta");
	$totalfilas = mysql_num_rows($rs); 
	if(empty($pagina))$pagina = 1; 
	$filainicial =  $pagina*$limite-($limite);
if(empty($ordenarpor))$ordenarpor = "1"; 
if($ordenactual==$ordenarpor){
	if($sentido=="Desc")		{
		$sentido="Asc";
	}else{
		$sentido="Desc";
	}
}else{
		$sentido="Asc";
}
$ordenactual=$ordenarpor; 
	$rs_lim=mysql_query("$sql Order By $ordenarpor $sentido Limit $filainicial, $limite") or die ("Error en el ordenamiento...");
	MostrarTabla($rs_lim,$tabla,$pagina,$ordenactual,$sentido);	
	
	if($pagina != 1) { 
		$paginaprevia= $pagina - 1; 
	} 
	echo "<table border=0 cellpadding=0 cellspacing=0 width=100%><tr align=center><td>";
	echo "<font class=text>P&aacute;ginas:&nbsp;</b></font>";
	$numpaginas = ceil($totalfilas/$limite); 
	for($i=1; $i <= $numpaginas; $i++) {
		if($i!=$pagina){
			echo "<font color=#006699 size=2><b><A HREF=".$PHP_SELF."?pagina=".$i."&ordenarpor=".$ordenarpor."&ordenacual=".$ordenactual."&sentido=".$sentido.">".$i."</A></b></font>&nbsp;";  
		}else{
			echo "<font color=red size=2><b>$i</b></font>&nbsp;";  
		}
	} 
	echo "</td></tr></table>";
	if(($totalfilas-($limite*$pagina)) > 0){ 
		$paginasgte = $pagina + 1; 
	}
mysql_free_result($rs);
}

function Title($title){
	echo "<table width=100% border=0 cellspacing=2 cellpadding=0>";
  echo "<tr align=center><td><font class=text><b>$title</b></td></tr>";
}

function MostrarTabla($rs,$tabla,$pagina,$ordenactual,$sentido){	
	$campos=mysql_num_fields($rs);
	$numfilas=mysql_num_rows($rs);
	$ancho='580';if($campos<=3)$ancho='580';
	echo "<form name=frmList action='grabar.php' method=post>";
	 echo "<center><table border=0 cellpadding=0 cellspacing=0 width=590>
       <tr>
         <td><img src=../imagenes/spacer.gif width=1 height=1 border=0></td>
       </tr>
       <tr>
        <td colspan=3><img  src=../imagenes/cuadro1.jpg width=590 height=5 border=0></td>
       </tr>
       <tr>
         	<td><img src=../imagenes/cuadro1.jpg width=6 height=22 border=0></td>
	 <td background=../imagenes/cabecera.jpg><center><font class=textblanco>Registros:<b> ".$numfilas."</font></b></center></td>
         	<td><img src=../imagenes/cuadro1.jpg width=2 height=22 border=0 ></td>
       </tr>
       <tr>
         <td colspan=3><img src=../imagenes/cuadro5.jpg width=590 height=6 border=0 ></td>
       </tr>
       <tr>
   	 <td background=../imagenes/cabecera.jpg></td>
        <td align=center>";
	echo "<table cellPadding=2 cellSpacing=0 width=$ancho>";
	echo "<tr><td width=60%><input type='hidden' name='pag' value='$tabla'>";
	echo "</tr></table>";
	echo "<table cellPadding=2 cellSpacing=1  width=$ancho border=1 bordercolor=#69A6D8>";
	echo "<tr class=Mtr2>";
		echo "<td>&nbsp;<input name='allbox' type='checkbox' onClick='seleccionartodo();' title='Seleccionar o anular la selecci�n de todos los registros'></td>";
		for($i=0;$i<$campos;$i++){
			$campo=mysql_field_name($rs,$i);
			echo "<td ><a href=".$PHP_SELF."?pagina=".$pagina."&ordenarpor=".($i+1)."&ordenactual=".$ordenactual."&sentido=".$sentido." title='Ordenar por ".$campo."'>".$campo."</a></td>";
		} 
	echo "</tr>";
	while($filas=mysql_fetch_array($rs)){
		echo "<tr>";
			echo "<td width=30>&nbsp;<input type='checkbox' name='check[]' value=".$filas[0]." onClick='seleccionaruno(this);'></td>";
			for($i=0;$i<$campos;$i++){
				if($i==0){
					echo "<td class=text><a href=".strtolower($tabla).".php?id=".$filas[0]."&sw=2><img src='../imagenes/editar.jpg' border=0 alt='Modificar'>$filas[$i]</a></td>";
				}else{
					echo "<td class=text>".$filas[$i]."</td>";
				}
			}
		echo "</tr>";
	}
	echo "</table>";
	echo "</td>
	      <td background=../imagenes/cabecera.jpg></td>
       </tr>
       <tr>
         <td colspan=3><img src=../imagenes/cuadro8.jpg width=590 height=9 border=0></td>
       </tr>
     </table>";
	echo "</center>";
	echo "</form>";
	include('mantenimiento.php');
	echo "<center><font class=text>";
}

function llenarcombo($tabla,$campos,$condicion,$seleccionado,$parametroselect,$name){
Global $link;
$rs = mysql_query("select $campos from $tabla".$condicion,$link);
echo "<select name=".$name." ".$parametroselect." class=form-control id=".$name.">";
echo "<option value=''>Seleccione</option>";
	while($cur = mysql_fetch_array($rs)){
		$seleccionar="";
		if($cur[0]==$seleccionado) $seleccionar="selected";
		echo "<option value=".$cur[0]." ".$seleccionar.">".utf8_encode($cur[1])."</option>";
	}
echo "</select>";
mysql_free_result($rs);
}

function llenarchecks($tabla,$campos){
Global $link;
$rsc = mysql_query("select $campos from $tabla".$condicion,$link);
	while($curc = mysql_fetch_array($rsc)){
		echo "<input type='checkbox' value=".$curc[0]." name='chkservicio[]' checked='checked' class='inputcheck ng-pristine ng-valid' ng-model='checked'><span>".$curc[1]."</span>&nbsp;";
	}

mysql_free_result($rsc);
}

?>