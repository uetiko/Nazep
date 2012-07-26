<?php
/*
Sistema: Nazep
Nombre archivo: mapa_sitio_admon.php
Función archivo: archivo para controlar la administración del módulo de mapa del sitio
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_mapa_sitio extends conexion
	{
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{ echo '<br />'.avi_no_mod_cam; }		
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{ echo '<br />'.avi_no_mod_mod; }
	}
?>