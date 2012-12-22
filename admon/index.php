<?php
/*
Sistema: Nazep
Nombre archivo: index.php
Funci�n archivo: Generar toda las vistas para adminstrar el contenido del sitio
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
if(file_exists("../instalar/instalar.php"))
    { header("Location: ../instalar/instalar.php"); }
else
    {
        if(isset($_GET["salir"]) && ($_GET["salir"]  == "si"))
            {
                include("administracion.php");
                $sesion_temporal_admon = md5(nombre_base."administracion");
                $_SESSION[$sesion_temporal_admon]=null;
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