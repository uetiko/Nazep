<?php
/*
Sistema: Nazep
Nombre archivo: articulos_rss_vista.php
Función archivo: archivo para controlar la vista final del módulo de rss de los articulos
Fecha creación: mayo 2009
Fecha última Modificación: Marzo 2011
Versión: 0.1.6
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_articulos_rss extends conexion
	{
		function vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{}
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{}
		function vista_xml($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$con_conf ="select * from nazep_zmod_articulos_rss  where clave_seccion  = '$sec'";
				$res_conf = mysql_query($con_conf);
				$can = mysql_num_rows($res_conf);
				if($can>0)
					{
						$ren_conf = mysql_fetch_array($res_conf);
						$clave_seccion_enlazar = $ren_conf["clave_seccion_enlazar"];
						$nombre_rss = $ren_conf["nombre_rss"];
						$enlace_rss = $ren_conf["enlace_rss"];
						$lenguaje = $ren_conf["lenguaje"];
						$descripcion = $ren_conf["descripcion"];
						$cantidad_mostrar = $ren_conf["cantidad_mostrar"];
						$permitir_ver_comentarios = $ren_conf["permitir_ver_comentarios"];
						$ver_autor = $ren_conf["ver_autor"];
						$tipo_autor_ver = $ren_conf["tipo_autor_ver"];
						$usar_tema = $ren_conf["usar_tema"];
						$tipo_resumen_ver = $ren_conf["tipo_resumen_ver"];
						$permitir_caducar = $ren_conf["permitir_caducar"];
						$cadena_adicional ="";
						$con_conf_url = "select url_sitio from nazep_configuracion";
						$res_con_url = mysql_query($con_conf_url);
						$ren_con_url = mysql_fetch_array($res_con_url);	
						$url_sitio = $ren_con_url[url_sitio];
						$cadena_adicional='';
						if($permitir_caducar =="si")
							{
								$hoy = date('Y-m-d');
								$cadena_adicional= " and fecha_inicio <= '$hoy' and fecha_fin >= '$hoy' ";
							}
						$con_articulo = " select a.titulo, a.resumen_".$tipo_resumen_ver." as resumen_articulo,
						a.numero_articulo, a.fecha_articulo, a.clave_articulo, a.clave_tema,
						a.user_creacion, a.nombre_creacion, a.hora_creacion
						from  nazep_zmod_articulos_tipos at, nazep_zmod_articulos a
						where a.clave_tipo = at.clave_tipo
						and at.clave_seccion = '$clave_seccion_enlazar'
						and a.situacion = 'activo' ".$cadena_adicional.' order by fecha_articulo desc, numero_articulo desc, hora_creacion desc limit 0, '.$cantidad_mostrar;
						$res_con = mysql_query($con_articulo);
						$can = mysql_num_rows($res_con);
						
						echo '<rss version="2.0">';
							echo '<channel>';
							echo '<title>'.$nombre_rss.'</title>';
							echo '<link>'.$enlace_rss.'</link>';
							echo '<description>'.$descripcion.'</description>';
							echo '<language>'.$lenguaje.'</language>';
								while($ren_con = mysql_fetch_array($res_con))
									{
										$clave_tema = $ren_con["clave_tema"];
										$titulo = $ren_con["titulo"];
										$etiquetas = array("<br>","<br/>","<br >","<br />","<p>","</p>","<p >","</ p>"); 
										$titulo = str_replace($etiquetas, "", $titulo);
										$titulo = $this->remplazar_uft8($titulo);
										$resumen_articulo = stripslashes($ren_con["resumen_articulo"]);
										$numero_articulo = $ren_con["numero_articulo"];
										$fecha_articulo = $ren_con["fecha_articulo"];
										$clave_articulo = $ren_con["clave_articulo"];
										$nombre_creacion = $ren_con["nombre_creacion"];
										$user_creacion = $ren_con["user_creacion"];
										$hora_creacion = $ren_con["hora_creacion"];
										echo '<item>';
											echo '<title><![CDATA['.$titulo.']]></title>';
											echo '<link>'.$url_sitio.'/index/index.php?sec='.$clave_seccion_enlazar.'&amp;clave_articulo='.$clave_articulo.'</link>';
											echo '<pubDate>'.$fecha_articulo.' '.$hora_creacion .'</pubDate>';
											if($usar_tema= "si")
												{
													$con_tema = "select nombre from nazep_zmod_articulos_temas where clave_tema = '$clave_tema' ";
													$res_tema = mysql_query($con_tema);
													$ren_tema = mysql_fetch_array($res_tema);
													$nombre_tema = $ren_tema["nombre"];
													echo '<category><![CDATA['.$nombre_tema.']]></category>';
												}
											if($ver_autor=="si")
												{
													if($tipo_autor_ver=="nombre")
														{echo '<author>'.$nombre_creacion.'</author>';}
													elseif($tipo_autor_ver=="nick")
														{echo '<author>'.$user_creacion.'</author>';}
												}
											echo '<description><![CDATA['.$resumen_articulo.']]></description>';
										echo '</item>';
									}
							echo '</channel>';
						echo '</rss>';
					}
				else
					{
						echo '<rss version="2.0">';
							echo '<channel>';
								echo '<title>RSS NO Configurado</title>';
								echo '<description>RSS de NAZEP sin contenido</description>';
								echo '<language>es</language>';
							echo '</channel>';
						echo '</rss>';
					}
			}
	}	
?>