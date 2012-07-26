<?php
/*
Sistema: Nazep
Nombre archivo: index.php
Función archivo: Generar toda las vistas para adminstrar el contenido del sitio
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
if(file_exists("../instalar/instalar.php"))
	{ header("Location: ../instalar/instalar.php"); }
else
	{
		if(isset($_GET["salir"]) && ($_GET["salir"]  == "si"))
			{
				session_start();
				session_destroy(); 
				header("Location: index.php");			
			}
		else
			{
				include("administracion.php");
				$sesion_temporal_admon = md5(nombre_base."administracion");		
				$_SESSION[$sesion_temporal_admon]->cuerpo();	
			}	
	}
?>