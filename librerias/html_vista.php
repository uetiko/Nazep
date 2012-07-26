<?php
/*
Sistema: Nazep
Nombre archivo: html_admon.php
Función archivo: Generar toda las funciones para mostrar los elementos web de la aplicación
Fecha creación: Marzo 2011
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class HtmlVista
	{
		public static function int_contectarse()
			{
				$objconect = new conexion();
				$objconect->conectarse();				
			}		
		public static function ContenidoNoDisponible($ubicacion_tema)
			{
				HtmlVista::int_contectarse();
				$con_contenido = 'select con_no_disponible from nazep_configuracion ';
				$res_contenido = mysql_query($con_contenido);
				$ren_contenido = mysql_fetch_array($res_contenido);
				$con_no_disponible = $ren_contenido['con_no_disponible'];				
				echo '<div id="div_contendio_no_disponible" class="contendio_no_disponible"> '.$con_no_disponible.'</div>';				
			}					
	}
?>