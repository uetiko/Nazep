<?php
/*
Sistema: Nazep
Nombre archivo: index.php
Función archivo: Inicia el funcionamiento de nazep y permite terminar la sesion al salir
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
if(file_exists("../instalar/instalar.php"))
	{header("Location: ../instalar/instalar.php");}
else
	{
		header("Location: ../index.php");
	}
?>