<?php
/*
Sistema: Nazep
Nombre archivo: baner_lateral_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de banner laterales
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_listado_baner_lateral extends conexion
	{
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{ echo '<br />'.avi_no_mod_cam; }
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{ echo '<br />'.avi_no_mod_mod; }
	}
?>