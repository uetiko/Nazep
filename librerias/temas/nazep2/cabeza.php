<?php
/*
Sistema: Nazep
Nombre archivo: cabeza.php
Funci�n archivo: archivo que genera la cabeza del tema por defecto nazep2 para su visualizaci�n
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
?>
<table width="777" border="0" cellspacing="0" cellpadding="0" align="center" class="imagen_cabeza" >
	<tr><td height="96" align="right" valign="bottom">
        <?php if(!$this->registro =="no")
			{echo 'Usuario: '.$this->nom_usuario.'<br/><a href="index.php?salir=si">Salir</a>';}?>
	</td></tr>
</table>
<table width="777" border="0" cellspacing="0" cellpadding="0" align="center" class="imagen_fondo_menu">
	<tr>
		<td width="60%" valign="top" align="right">|</td>
		<td valign="top" align="center">
			<?php $this->enlace_inicio("Inicio");?>
		</td>
		<td valign="top" align="center">|</td>
		<td  valign="top" align="center">
			 <?php $this->enlace_buscador("Buscador"); ?>
		</td>
		<td  valign="top" align="center">|</td>
		<td  valign="top" align="center">
			<?php $this->enlace_mapa_sitio("Mapa del sitio"); ?>
		</td>
		<td valign="top" align="center">|</td>
		<td valign="top" align="center">
			<?php $this->enlace_contacto("Contacto"); ?>
		</td>
		<td valign="top" align="center">|</td>
	</tr>
</table>