<?php
/*
Sistema: Nazep
Nombre archivo: configuracion.php
Función archivo: Contener las constantes para el funcionamiento de Nazep
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class CtrlErrores
	{
		function __construct()
			{
				function ctr_Fatal($buffer)
					{
						//echo "error Fatal";
						return $buffer; 
					}
				function ctr_Error($numero, $mensaje, $archivo, $linea, $contexto, $retorna=0) 
					{
					}
				ob_start('ctr_Fatal'); 
				set_error_handler('ctr_Error');
			}
	}
$error=new CtrlErrores();
?>