<?php
/*
Sistema: Nazep
Nombre archivo: baner_lateral_vista.php
Función archivo: archivo para controlar la vista final del módulo de banner laterales
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_listado_baner_lateral extends conexion
	{
		function __construct()
			{}		
		function vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$hoy = date('Y-m-d');
				$con_conf = "select * from nazep_zmod_baner_configuracion where seccion_ver_mas = '$sec'";
				$res_conf = mysql_query($con_conf);
				$ren_conf = mysql_fetch_array($res_conf);
				$clave_baner_configuracion = $ren_conf["clave_baner_configuracion"];
				$ubicacion_imagen_balazo = $ren_conf["ubicacion_imagen_balazo"];
				$ver_imagen_balazo = $ren_conf["ver_imagen_balazo"];
				$texto_balazo = $ren_conf["texto_balazo"];
				$ver_texto_balazo = $ren_conf["ver_texto_balazo"];
				$con_baner = " select enlace, clave_baner from nazep_zmod_baner 
				where clave_baner_configuracion = '$clave_baner_configuracion'
				and situacion = 'activo' and  fecha_inicio <= '$hoy' and fecha_fin >= '$hoy' order by orden asc";
				$res_con = mysql_query($con_baner);
				echo '<div id="centro_contenido_enlaces" class="centro_contenido_gral_print">';
					while($ren = mysql_fetch_array($res_con))
						{
							$enlace = stripslashes($ren["enlace"]);
							$clave_baner = $ren["clave_baner"];
							if($ver_imagen_balazo == "SI" or $ver_texto_balazo=="SI")
								{
									echo '<div id = "div_listado_enlace_balazo_'.$clave_baner.'" class="listado_enlace_balazo" > ';
										if($ver_imagen_balazo == "SI")
											{ echo '<img src ="'.$ubicacion_imagen_balazo.'" alt = "balazo" />'; }
										elseif($ver_texto_balazo == "SI")
											{ echo $texto_balazo; }
									echo '</div>';
								}
							echo '<div id="div_listado_enlace_'.$clave_baner.'" class="listado_enlace" >'.$enlace.'</div>';
							echo '<div class="separacion_listado_enlace"> </div>';
						}
				echo '</div>';
			}
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$hoy = date('Y-m-d');
				$con_conf = " select * from nazep_zmod_baner_configuracion where seccion_ver_mas = '$sec'";			
				$res_conf = mysql_query($con_conf);
				$ren_conf = mysql_fetch_array($res_conf);
				$clave_baner_configuracion = $ren_conf["clave_baner_configuracion"];
				$ubicacion_imagen_balazo = $ren_conf["ubicacion_imagen_balazo"];
				$ver_imagen_balazo = $ren_conf["ver_imagen_balazo"];
				$texto_balazo = $ren_conf["texto_balazo"];
				$ver_texto_balazo = $ren_conf["ver_texto_balazo"];
				$con_baner = "select enlace, clave_baner  from nazep_zmod_baner 
				where clave_baner_configuracion = '$clave_baner_configuracion'
				and situacion = 'activo' and fecha_inicio <= '$hoy' and fecha_fin >= '$hoy' order by orden asc";
				$res_con = mysql_query($con_baner);
				echo '<div id="centro_contenido_enlaces" class="centro_contenido_gral">';
					while($ren = mysql_fetch_array($res_con))
						{
							$enlace = stripslashes($ren["enlace"]);
							$clave_baner = $ren["clave_baner"];	
							if($ver_imagen_balazo == "SI" or $ver_texto_balazo=="SI")
								{
									echo '<div id = "div_listado_enlace_balazo_'.$clave_baner.'" class="listado_enlace_balazo" > ';
										if($ver_imagen_balazo == "SI")
											{ echo '<img src ="'.$ubicacion_imagen_balazo.'" alt = "balazo " />'; }
										elseif($ver_texto_balazo == "SI")
											{ echo $texto_balazo; }
									echo '</div>';
								}
							echo '<div id="div_listado_enlace_'.$clave_baner.'" class="listado_enlace" >'.$enlace.'</div>';
							echo '<div class="separacion_listado_enlace"> </div>';
						}
				echo '</div>';
			}
	}	
?>