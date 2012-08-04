<?php
/*
Sistema: Nazep
Nombre archivo: cabeza.php
Funci�n archivo: archivo que genera la cabeza del tema por defecto nazep para su visualizaci�n
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
?>

<table width="777" border="0" cellspacing="0" cellpadding="0" align="center" class="imagen_cabeza" >
	<tr><td height="96"  align="right" valign="bottom">
    	<?php
			if($this->registro =='si')
				{echo 'Usuario: '.$this->nom_usuario.'<br/><a href="index.php?salir=si">Salir</a>';}
		?>
	</td></tr>
</table>
<table width="777" border="0" cellspacing="0" cellpadding="0" align="center" class="imagen_fondo_menu">
<tr><td height="25" valign="top" align="center">
		<?php $this->lis_secc_prin_hor_tablas("1","7", "|", "777");	?>
</td></tr>
</table>