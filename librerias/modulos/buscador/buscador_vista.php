<?php
/*
Sistema: Nazep
Nombre archivo: buscador_vista.php
Función archivo: archivo para controlar la vista final del módulo de buscador
Fecha creación: junio 2007
Fecha última Modificación: Diciembre 2009
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_buscador extends conexion
	{
		function __construct()
			{
				$lenguaje = FunGral::SaberIdioma();
				include('librerias/idiomas/'.FunGral::SaberIdioma().'/buscador.php');
			}		
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$frase_buscar = $_POST["frase"];
				if(isset($_POST["buscador"]) and  $_POST["buscador"]=="mini" and $frase_buscar != "")
					{
						echo '<div id="buscador_mini"><a href="index.php?sec='.$sec.'" title="Enlace a Secci&oacute;n">'.bus_txt_titu_b_avan.'</a></div>';
						include("../librerias/modulos/contenido/contenido_vista.php");
						$obj = new clase_contenido();
						$obj->vista_buscador_mini($frase_buscar);
					}
				else
					{
						echo '<div class="clas_tit_bus">'.bus_txt_titu_b_avan.'</div>';
						if($frase_buscar == "")
							{
								$con_sec_avan = "select nombre_archivo  from nazep_zmod_buscador b, nazep_modulos m where b.clave_modulo = m.clave_modulo and b.situacion = 'activo' ";
								$res_con = mysql_query($con_sec_avan);
								$can_mod = mysql_num_rows($res_con);
								if($can_mod >0)
									{
										while($ren= mysql_fetch_array($res_con))
											{
												$nombre = $ren["nombre_archivo"];
												$archivo = "librerias/modulos/".$nombre."/".$nombre."_vista.php";
												$clase = "clase_".$nombre;
												include_once($archivo);
												$obj = new $clase();
												$obj->vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario);
											}
									}
								else
									{echo 'Se necesita Configurar el M&oacute;dulo del Buscador'; }
							}
						elseif(isset($_POST["resultados"]) &&  $_POST["resultados"]=="si")
							{
								$nombre = $_POST["archivo"];
								$archivo = "librerias/modulos/".$nombre."/".$nombre."_vista.php";
								$clase = "clase_".$nombre;
								include_once($archivo);
								$obj = new $clase();
								$obj->vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario);
							}
					}
			}
		function vista_print($sec, $ubicacion_tema, $nick_usuario)	
			{ echo bus_txt_no_imprimir; }
	}
?>