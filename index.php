<?php
/*
Sistema: Nazep
Nombre archivo: index.php
Función archivo: Redirecciona al index.php colocado en la carpeta index tras validar la existencia del archivo instalar.php
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
Colaborador:Monserrat reyes
*/
if(file_exists("instalar/instalar.php"))
	{header("Location: instalar/instalar.php");}
else
	{
		if(isset($_GET["salir"]) && ($_GET["salir"]  == "si"))
			{
				include("librerias/vista_final.php");	
				$sesion_temporal = md5(nombre_base);
				$_SESSION[$sesion_temporal]->salir();
				session_start();
				session_destroy(); 
				header("Location: index.php");
			}
		else
			{
				include("librerias/vista_final.php");
				$sesion_temporal = md5(nombre_base);
				$_SESSION[$sesion_temporal]->checar_sesion();
				$_SESSION[$sesion_temporal]->cuerpo();
			}
	}
?>