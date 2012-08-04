<?php
/*
Sistema: Nazep
Nombre archivo: baner_lateral_vista.php
Funci�n archivo: archivo para controlar la vista final del m�dulo de banner laterales
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_baner_lateral extends conexion
	{
		function __construct()
			{
				include('librerias/idiomas/'.FunGral::SaberIdioma().'/baner_lateral.php');
			}	
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$hoy = date('Y-m-d');
				$con_conf = "select * from nazep_zmod_baner_configuracion where clave_modulo = '$clave_modulo' and clave_seccion = '$sec'";
				$res_conf = mysql_query($con_conf);
				$ren_conf = mysql_fetch_array($res_conf);
				$clave_baner_configuracion = $ren_conf["clave_baner_configuracion"];
				$cantidad_mostrar = $ren_conf["cantidad_mostrar"];
				$texto_titulo = $ren_conf["texto_titulo"];
				$ver_texto_titulo = $ren_conf["ver_texto_titulo"];
				$imagen_titulo = $ren_conf["imagen_titulo"];
				$ver_imagen_titulo = $ren_conf["ver_imagen_titulo"];
				$texto_ver_mas = $ren_conf["texto_ver_mas"];
				$ver_texto_ver_mas = $ren_conf["ver_texto_ver_mas"];
				$ver_imagen_ver_mas = $ren_conf["ver_imagen_ver_mas"];
				$imagen_ver_mas = $ren_conf["imagen_ver_mas"];
				$seccion_ver_mas = $ren_conf["seccion_ver_mas"];
				$ubicacion_imagen_balazo = $ren_conf["ubicacion_imagen_balazo"];
				$ver_imagen_balazo = $ren_conf["ver_imagen_balazo"];
				$texto_balazo = $ren_conf["texto_balazo"];
				$ver_texto_balazo = $ren_conf["ver_texto_balazo"];
				$alin_balazo = $ren_conf["alin_balazo"];
				$color_fondo_lateral = $ren_conf["color_fondo_lateral"];
				$con_baner = "select enlace, clave_baner from nazep_zmod_baner 
				where  clave_baner_configuracion = '$clave_baner_configuracion'
				and situacion = 'activo' and 
				fecha_inicio <= '$hoy' and fecha_fin >= '$hoy'
				order by orden asc
				limit 0, $cantidad_mostrar ";
				$res_con = mysql_query($con_baner);
				if($ver_texto_titulo == 'SI' or $ver_imagen_titulo == 'SI')
					{
						echo '<div class="titulo_banner" >';	
							if($ver_texto_titulo == "SI")
								{ echo $texto_titulo; }
							elseif($ver_imagen_titulo == "SI")
								{ echo '<img src ="'.$imagen_titulo.'" alt = " Titulo de Banners " />'; }
						echo '</div>';
					}
				echo '<div id="cuerpo_baners_'.$clave_modulo.'"  >';
					while($ren = mysql_fetch_array($res_con))
						{
							$enlace = stripslashes($ren["enlace"]);
							$clave_baner = $ren["clave_baner"];
							if($ver_imagen_balazo == "SI" or $ver_texto_balazo=="SI")
								{
									echo '<div id="balazo_ban_'.$clave_baner.'" class="clas_bal_baner">';
										if($ver_imagen_balazo == "SI")
											{ echo '<img src ="'.$ubicacion_imagen_balazo.'" alt = "'.bl_txt_balazo.'" />'; }
										elseif($ver_texto_balazo == "SI")
											{ echo $texto_balazo; }
									echo '</div>';
								}
							echo '<div id="cuerpo_ban_'.$clave_baner.'" class="clas_cue_baner">'.$enlace.'</div>';
							echo '<div id="ren_sep_banner_'.$clave_baner.'" class="clas_ren_sep_banner" ></div>';
						}
				echo '</div>';				
				if($ver_texto_ver_mas== 'SI' or $ver_imagen_ver_mas == 'SI')
					{
						echo '<div id="separ_leer_baner" class="clas_sep_leer_baner"></div>';
						echo '<div id="lerr_mas_baner" class="clas_leer_mas_baner">';
							 echo '<a href= "index.php?sec='.$seccion_ver_mas.'" >';
								if($ver_imagen_ver_mas == "SI")
									{ echo '<img src ="'.$imagen_ver_mas.'" alt = "'.bl_txt_ver_mas.'" border = "0" />';  }
								elseif($ver_texto_ver_mas == "SI")
									{ echo $texto_ver_mas; }
							 echo '</a>';
						echo '</div>';
					}
			}
	}
?>