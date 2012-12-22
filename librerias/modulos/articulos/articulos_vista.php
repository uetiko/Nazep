<?php
/*
Sistema: Nazep
Nombre archivo: articulos_vista.php
Funci�n archivo: archivo para la visualizaci�n del m�dulo de art�culos
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_articulos extends conexion
	{	
		function __construct()
			{
				include('librerias/idiomas/'.FunGral::SaberIdioma().'/articulos.php');
			}
		function vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				if(isset($_POST["votar_articulo"]) &&  $_POST["votar_articulo"]=="si")
					{
						$ip_final = $_SERVER['REMOTE_ADDR'];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$clave_articulo = $_GET["clave_articulo"];
						$direccion_regreso = $_POST["direccion_regreso"];
						$votos = $_POST["votos"];
						$busqueda = "select clave_voto_art from nazep_zmod_articulos_votos  where clave_articulo = '$clave_articulo' and ip = '$ip_final'";
						$res_busqueda = mysql_query($busqueda);
						$cantidad = mysql_num_rows($res_busqueda);
						if($cantidad != "")
							{
								$direccion_regreso .= "&men=1";	
								header("Location:  $direccion_regreso");
							}
						else
							{
								$insertar = "insert into nazep_zmod_articulos_votos (clave_articulo, voto, ip, fecha, hora) 
								values ('$clave_articulo','$votos', '$ip_final','$fecha_hoy','$hora_hoy')";
								$update ="update nazep_zmod_articulos set cantidad_votos = cantidad_votos+1, votos = votos+$votos where clave_articulo = '$clave_articulo'";
								mysql_query("START TRANSACTION;");
								$paso = false;
								if (!@mysql_query($insertar))
									{
										mysql_query("ROLLBACK;");
										$paso = false;
									}
								else
									{
										$paso = true;
										if (!@mysql_query($update))
											{
												mysql_query("ROLLBACK;");
												$paso = false;
											}
										else
											{ $paso = true; }
									}
								if($paso)
									{
										mysql_query("COMMIT;");
										$direccion_regreso .= "&men=2";
										header("Location:  $direccion_regreso");
									}
								else
									{	
										mysql_query("ROLLBACK;");
										$direccion_regreso .= "&men=3";
										header("Location:  $direccion_regreso");
									}
							}
					}
				elseif(isset($_POST["comentar_articulo"]) &&  $_POST["comentar_articulo"]=="si")
					{
						$ip_final = $_SERVER['REMOTE_ADDR'];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$situacion= $_POST["situacion"];
						$clave_articulo = $_GET["clave_articulo"];
						$nombre = $this->escapar_caracteres($_POST["nombre"]);
						$correo = $this->escapar_caracteres($_POST["correo"]);
						$web = $this->escapar_caracteres($_POST["web"]);
						$comentario = $this->escapar_caracteres($_POST["comentario"]);
						$direccion_regreso = $_POST["direccion_regreso"];
						$insertar = "insert into nazep_zmod_articulos_comentarios (clave_articulo, situacion, fecha, hora, ip, nick_usuario, nombre, correo, web, comentario, leido)
						values ('$clave_articulo', '$situacion','$fecha_hoy','$hora_hoy','$ip_final','$nick_usuario','$nombre', '$correo', '$web','$comentario','NO')";
						if (!@mysql_query($insertar))
							{
								$direccion_regreso .= "&men=5";
								header("Location:  $direccion_regreso");
							}
						else
							{
								$direccion_regreso .= "&men=4";
								header("Location:  $direccion_regreso");
							}
					}
			}			
		function vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario)
			{
				if(@$_POST["resultados"]=="" or (@$_POST["resultados"]== "si" and @$_POST["frase"] == ""))
					{
						echo '<div id="centro_articulos" class="centro_contenido_gral">';
							echo '<div id="div_titulo_buscador_articulos" class="titulo_buscador_articulos">'.art_txt_titu_buscador.'</div>';
							echo '<div id="div_formulario_buscador_articulos" class="formulario_buscador_articulos">';
								echo '<form id="buscador_articulos" name="buscador_articulos" action="index.php?sec='.$sec.'" method="post" >';
									echo art_txt_tex_buscar.'&nbsp;';
									echo '<input type = "text" name = "frase" size = "40" />';
									echo '<select name = "metodo">';
										echo '<option value = "exacto" >'.art_txt_fra_exa.' </option>';
										echo '<option value = "palabra" >'.art_txt_palabra.'</option>';
									echo '</select>';
									echo '<input type="hidden" name = "resultados" value ="si" />';
									echo '<input type="hidden" name = "archivo" value = "articulos" />';
									echo '<input type="submit" name="btn_buscar" value="'.art_btn_buscar.'" />';
								echo '</form>';
							echo '</div>';
						echo '</div>';
					}
				elseif(isset($_POST["resultados"]) &&  $_POST["resultados"]=="si")
					{
						$hoy = date('Y-m-d');
						$frase = $_POST["frase"];
						$frase = strip_tags($frase);
						$metodo = $_POST["metodo"];
						if($metodo=="exacto")
							{ $cadena = " ap.texto like '%$frase%' "; }
						elseif($metodo=="palabra")
							{
								$arreglo_palabras = explode(" ", $frase);
								$cantidad_palabras = count($arreglo_palabras);	
								for($a=0;$a<$cantidad_palabras;$a++)
									{
										$tem = $arreglo_palabras[$a];
										if($tem!="")
											{ $cadena .= " cd.texto like '%$tem%' "; }
										$contador = $a+1;
										$proxima = $arreglo_palabras[$contador];
										if(($contador<$cantidad_palabras) && ($proxima!="") )
											{ $cadena .= " or "; }
									}
							}
						$consulta_total = " select a.clave_articulo
						from nazep_zmod_articulos_paginas  ap,
						nazep_zmod_articulos a, 
						nazep_zmod_articulos_tipos  at,
						nazep_secciones s
						where a.clave_articulo = ap.clave_articulo  and a.clave_tipo = at.clave_tipo
						and at.clave_seccion = s.clave_seccion and ap.situacion = 'activo'
						and a.situacion = 'activo' and ($cadena) ";
						$res_con = mysql_query($consulta_total);
						$can_res = mysql_num_rows($res_con);
						$cantidad_mostrar = "10";
						if($_POST["pag"]=="")
							{
								$pag = 1;
								$ini = 0;
							}
						else
							{
								$pag = $_POST["pag"];
								$ini = ($pag-1)*$cantidad_mostrar;
							}
						$total_paginas = ceil($can_res/$cantidad_mostrar);
						$consulta_detallada = "select a.clave_articulo, a.titulo, a.fecha_articulo, ap.pagina, 
						at.clave_seccion
						from
						nazep_zmod_articulos_paginas  ap,
						nazep_zmod_articulos a, 
						nazep_zmod_articulos_tipos  at,
						nazep_secciones s
						where
						a.clave_articulo = ap.clave_articulo 
						and a.clave_tipo = at.clave_tipo
						and at.clave_seccion = s.clave_seccion
						and ap.situacion = 'activo'
						and a.situacion = 'activo'
						and ($cadena)
						order by a.fecha_articulo
						limit $ini, $cantidad_mostrar";		
						$res_con_sec = mysql_query($consulta_detallada);
						echo '<div id="centro_articulos" class="centro_contenido_gral">';
							echo '<div id="div_titulo_res_ava" class="titulo_res_ava" >'; 
								echo art_txt_titu_res_bus.' ('.$can_res.')';
								echo '<br />'.art_txt_res_frase.': <b>'.$frase.'</b>';
							echo '</div>';
							
							while($ren_con = mysql_fetch_array($res_con_sec))
								{
									$clave_articulo = $ren_con["clave_articulo"];
									$titulo = stripslashes($ren_con["titulo"]);
									$fecha_articulo =  $ren_con["fecha_articulo"];
									$pagina =  $ren_con["pagina"];
									$fecha_articulo = FunGral::fechaNormal($fecha_articulo);
									$clave_seccion =  $ren_con["clave_seccion"];
									echo '<div id="res_bus_art_'.$clave_seccion.'" class="res_bus_art" >';
										echo art_txt_titulo.'
										<strong>'.$titulo.'</strong>
										<br />'.art_txt_fecha.':<strong>'.$fecha_articulo.'</strong>
										<br />'.art_txt_pagina.':<strong>'.$pagina.'</strong>';
										echo '<br />';
										echo '<a href="index.php?sec='.$clave_seccion.'&amp;clave_articulo='.$clave_articulo.'&amp;pag='.$pagina.'">';
										echo art_txt_ir;
										echo '</a><hr />';
									echo '</div>';
								}
							echo '<div id="div_pag_res_art" class="pag_res_art" >';
								if($total_paginas >1)
									{
										for($a=1;$a<=$total_paginas;$a++)
											{
												$clave_buscador = $_GET["sec"];
												echo '<form name="buscador_mini_'.$a.'" action="index.php?sec='.$clave_buscador.'" method="post" >';
													echo '<input type="hidden" name="buscador" value = "mini" />';
													echo '<input type="hidden" name = "frase" value = "'.$frase_buscar.'" />';
													echo '<input type="hidden" name = "pag" value = "'.$a.'" />';
												echo '</form>';
											}
										for($b=1;$b<=$total_paginas;$b++)
											{
												if($pag==$b)
													{ echo '<strong><u>'.$pag.'</u></strong>';}
												else
													{ echo '<a href="javascript:document.buscador_mini_'.$b.'.submit()">'.$b.'</a>'; }
											}
									}
							echo '</div>';
						echo '</div>';
					}
			}
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$con_configuracion ="select clave_tipo, nombre, cantidad_art_mostrar, posicion_titulo_lista, posicion_titulo_cuerpo,
				usar_tema, permitir_ver_temas_lista, permitir_ver_temas_cuerpo, posicion_tema_lista, posicion_tema_cuerpo,
				permitir_ver_numero_lista, permitir_ver_numero, posicion_numero_lista, posicion_numero_cuerpo, 
				ver_fecha_lista, formato_fecha_lista, ver_hora_lista, ver_lugar_lista,  ver_fecha_cuerpo, formato_fecha_cuerpo, ver_hora_cuerpo, ver_lugar_cuerpo, posicion_fecha_lugar_lista, posicion_fecha_lugar_cuerpo,
				tipo_resumen_ver, permitir_ver_resumen_cuerpo, posicion_resumen_lista, posicion_resumen_cuerpo,  
				permitir_ver_cuerpo, partes_enlace_cuerpo, posicion_cuerpo,  permitir_ver_visitas_lista, permitir_ver_visitas, posicion_visitas_lista, posicion_visitas_cuerpo, 
				per_ver_fec_actualiza_lista, per_ver_fec_actualiza, posicion_fe_act_lista, posicion_fe_act_cuerpo, 
				permitir_caducar, permitir_calificar, permitir_comentarios, moderar_comentarios, permitir_comentarios_lista,
				ver_buscador, tipo_separacion_lista, posicion_buscador from nazep_zmod_articulos_tipos where clave_seccion = '$sec'";
				
				$cadena_adicional= '';
				$res_configuracion = mysql_query($con_configuracion);
				$ren_configuracion = mysql_fetch_array($res_configuracion);
				$can_con = mysql_num_rows($res_configuracion);
				$clave_tipo =  $ren_configuracion["clave_tipo"];
				$nombre_tipo = $ren_configuracion["nombre"];
				$cantidad_art_mostrar = $ren_configuracion["cantidad_art_mostrar"];
				$posicion_titulo_lista = $ren_configuracion["posicion_titulo_lista"];
				$posicion_titulo_cuerpo = $ren_configuracion["posicion_titulo_cuerpo"];
				$usar_tema = $ren_configuracion["usar_tema"];
				$permitir_ver_temas_lista = $ren_configuracion["permitir_ver_temas_lista"];
				$permitir_ver_temas_cuerpo = $ren_configuracion["permitir_ver_temas_cuerpo"];
				$posicion_tema_lista = $ren_configuracion["posicion_tema_lista"];
				$posicion_tema_cuerpo = $ren_configuracion["posicion_tema_cuerpo"];
				$permitir_ver_numero_lista = $ren_configuracion["permitir_ver_numero_lista"];
				$permitir_ver_numero = $ren_configuracion["permitir_ver_numero"];
				$posicion_numero_lista = $ren_configuracion["posicion_numero_lista"];
				$posicion_numero_cuerpo = $ren_configuracion["posicion_numero_cuerpo"];
				$ver_fecha_lista = $ren_configuracion["ver_fecha_lista"];
				$formato_fecha_lista = $ren_configuracion["formato_fecha_lista"];
				$ver_hora_lista = $ren_configuracion["ver_hora_lista"];
				$ver_lugar_lista = $ren_configuracion["ver_lugar_lista"];
				$ver_fecha_cuerpo = $ren_configuracion["ver_fecha_cuerpo"];
				$formato_fecha_cuerpo = $ren_configuracion["formato_fecha_cuerpo"];
				$ver_hora_cuerpo = $ren_configuracion["ver_hora_cuerpo"];
				$ver_lugar_cuerpo = $ren_configuracion["ver_lugar_cuerpo"];
				$posicion_fecha_lugar_lista = $ren_configuracion["posicion_fecha_lugar_lista"];
				$posicion_fecha_lugar_cuerpo = $ren_configuracion["posicion_fecha_lugar_cuerpo"];
				$tipo_resumen_ver = $ren_configuracion["tipo_resumen_ver"];
				$permitir_ver_resumen_cuerpo = $ren_configuracion["permitir_ver_resumen_cuerpo"];
				$posicion_resumen_lista = $ren_configuracion["posicion_resumen_lista"];
				$posicion_resumen_cuerpo = $ren_configuracion["posicion_resumen_cuerpo"];
				$permitir_ver_cuerpo = $ren_configuracion["permitir_ver_cuerpo"];
				$partes_enlace_cuerpo = $ren_configuracion["partes_enlace_cuerpo"];
				$partes_enlace_cuerpo_array = explode(",", $partes_enlace_cuerpo);
				$posicion_cuerpo = $ren_configuracion["posicion_cuerpo"];
				$permitir_ver_visitas_lista = $ren_configuracion["permitir_ver_visitas_lista"];
				$permitir_ver_visitas = $ren_configuracion["permitir_ver_visitas"];
				$posicion_visitas_lista = $ren_configuracion["posicion_visitas_lista"];
				$posicion_visitas_cuerpo = $ren_configuracion["posicion_visitas_cuerpo"];
				$per_ver_fec_actualiza_lista = $ren_configuracion["per_ver_fec_actualiza_lista"];
				$per_ver_fec_actualiza = $ren_configuracion["per_ver_fec_actualiza"];
				$posicion_fe_act_lista = $ren_configuracion["posicion_fe_act_lista"];
				$posicion_fe_act_cuerpo = $ren_configuracion["posicion_fe_act_cuerpo"];
				$permitir_caducar = $ren_configuracion["permitir_caducar"];
				$permitir_calificar = $ren_configuracion["permitir_calificar"];
				$permitir_comentarios = $ren_configuracion["permitir_comentarios"];
				$moderar_comentarios = $ren_configuracion["moderar_comentarios"];
				$permitir_comentarios_lista = $ren_configuracion["permitir_comentarios_lista"];
				$ver_buscador = $ren_configuracion["ver_buscador"];
				$tipo_separacion_lista = $ren_configuracion["tipo_separacion_lista"];
				$posicion_buscador = $ren_configuracion["posicion_buscador"];
				if($permitir_caducar =='si')
					{
						$hoy = date('Y-m-d');
						$cadena_adicional= " and fecha_inicio <= '$hoy' and fecha_fin >= '$hoy' ";
					}
				if(isset($_GET["clave_articulo"]) && $_GET["clave_articulo"]!= "" and $permitir_ver_cuerpo == "si")
					{
						$clave_articulo = $_GET["clave_articulo"];
						$pag_con = $_GET["pag"];
						if($pag_con == '')
							$pag_con = 1;
						if((is_numeric($clave_articulo)) && (is_numeric($pag_con))  && ($clave_articulo>0) )
							{
								$con_articulo = "select a.fecha_actualizacion, a.nombre_actualiza, a.hora_actualizacion, a.fecha_articulo, a.lugar_articulo, a.titulo,
								a.numero_articulo, a.visitas, a.cantidad_votos, a.votos, ap.texto, a.clave_tema, a.hora_creacion, a.resumen_$tipo_resumen_ver
								from nazep_zmod_articulos  a, nazep_zmod_articulos_paginas ap where a.clave_articulo = ap.clave_articulo and a.clave_articulo = '$clave_articulo'
								and a.situacion = 'activo' and ap.situacion = 'activo' and ap.pagina = '$pag_con' $cadena_adicional";
								$res_articulo = mysql_query($con_articulo);
								$ren_articulo = mysql_fetch_array($res_articulo);
								$can_pagina = mysql_num_rows($res_articulo);
								if($can_pagina>0)
									{
										$nombre_actualiza = $ren_articulo["nombre_actualiza"];
										$fecha_actualizacion = $ren_articulo["fecha_actualizacion"];
										$fecha_actualizacion = FunGral::fechaNormal($fecha_actualizacion);
										$hora_actualizacion = $ren_articulo["hora_actualizacion"];
										$fecha_articulo = $ren_articulo["fecha_articulo"];
										$fecha_articulo = FunGral::$formato_fecha_cuerpo($fecha_articulo);
										$clave_tema = $ren_articulo["clave_tema"];
										$hora_creacion = $ren_articulo["hora_creacion"];
										$lugar_articulo = $ren_articulo["lugar_articulo"];
										$titulo = $ren_articulo["titulo"];
										$numero_articulo = $ren_articulo["numero_articulo"];
										$visitas = $ren_articulo["visitas"];
										$cantidad_votos = $ren_articulo["cantidad_votos"];
										$votos = $ren_articulo["votos"];
										$texto = stripslashes($ren_articulo["texto"]);
										$resumen = stripslashes($ren_articulo["resumen_".$tipo_resumen_ver]);
										echo '<div id="centro_contenido_art" class="centro_contenido_gral">';
											$renglon_separacion = '<div class="renglon_vacio_articulo"></div>';
											$arreglo_renglones[$posicion_titulo_cuerpo] = '<div class="titulo_articulo_completo">'.$titulo.'</div>';
											if(($permitir_ver_temas_cuerpo=="si") and ($usar_tema  =="si"))
												{
													$con_tema = "select nombre from nazep_zmod_articulos_temas where clave_tema = '$clave_tema'";
													$res_tema = mysql_query($con_tema);
													$ren_tema = mysql_fetch_array($res_tema);
													$nombre_tema = $ren_tema["nombre"];	
													$arreglo_renglones[$posicion_tema_cuerpo] = '<div class="tema_articulo_completo">'.art_txt_tema.': '.$nombre_tema.'</div>';
												}
											if($permitir_ver_numero == 'si')
												{$arreglo_renglones[$posicion_numero_cuerpo] ='<div class="numero_articulo_completo">'.art_txt_numero.': '.$numero_articulo.'</div>';}
											if(($ver_fecha_cuerpo=='no')and ($ver_hora_cuerpo=='no')and($ver_lugar_cuerpo=='no'))
												{$temporal_lug_fec_hor = '';}
											else
												{
													$temporal_lug_fec_hor = '<div class="fecha_articulo_completo">';
													if($ver_lugar_cuerpo=='si')
														{ $temporal_lug_fec_hor .= $lugar_articulo.'&nbsp;'; }
													if($ver_fecha_cuerpo=='si')
														{ $temporal_lug_fec_hor .= $fecha_articulo.'&nbsp;'; }
													if($ver_hora_cuerpo=='si')
														{ $temporal_lug_fec_hor .= $hora_creacion.'&nbsp;'; }
													$temporal_lug_fec_hor .= '</div>';
													$arreglo_renglones[$posicion_fecha_lugar_cuerpo] =$temporal_lug_fec_hor;
												}
											if($permitir_ver_resumen_cuerpo == 'si')
												{$arreglo_renglones[$posicion_resumen_cuerpo] = '<div class="resumen_articulo_completo">'.$resumen.'</div>';}
											$temporal_cuerpo ='<div class="cuerpo_articulo_completo">'.$texto.'</div>';
											$consulta_contenido_pag = "select pagina from nazep_zmod_articulos_paginas where clave_articulo = '$clave_articulo' and situacion = 'activo' order by pagina";
											$res_con_pag = mysql_query($consulta_contenido_pag);
											$cantidad_con = mysql_num_rows($res_con_pag);
											if($cantidad_con!="0" and $cantidad_con!="1")
												{
													$temporal_cuerpo .= '<div class="titulo_paginacion_articulos">'.art_txt_titu_pag.'</div><div class="celda_paginacion_articulos">';
													while($ren_con = mysql_fetch_array($res_con_pag))
														{
															$pagina = $ren_con["pagina"];
															if($pag_con == $pagina)
																{$temporal_cuerpo .= '<span class="numero_pagina_seleccionado_articulo">&nbsp;'.$pagina.'&nbsp;</span>';}
															else
																{$temporal_cuerpo .=' <a title="'.art_txt_pagina.' #'.$pagina.'" class="enlace_paginado_articulo" href="index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'&amp;pag='.$pagina.'">'.$pagina.'</a> ';}
														}
													$temporal_cuerpo .= '</div>';
												}
											$arreglo_renglones[$posicion_cuerpo] = $temporal_cuerpo;
											if($permitir_ver_visitas=='si')
												{$arreglo_renglones[$posicion_visitas_cuerpo] = '<div class="visitas_articulo_completo">'.art_txt_visitas.': '.$visitas.'</div>';}
											if($per_ver_fec_actualiza=='si')
												{$arreglo_renglones[$posicion_fe_act_cuerpo] = '<div class="texto_actualizacion">'.art_txt_ultim_actu.': <br />'. $fecha_actualizacion.'&nbsp;'.art_txt_ultim_actu2.'&nbsp;'.$hora_actualizacion.'&nbsp;'.art_txt_ultim_actu3.'<br />'.art_txt_ultim_actu4.'&nbsp;'.$nombre_actualiza.'</div>';}
											for($a=1;$a<=8;$a++)
												{
													$renglon_temporal = $arreglo_renglones[$a];
													if($renglon_temporal!='')
														{ echo $renglon_temporal.$renglon_separacion;}
												}	
											if($permitir_calificar== 'si')
												{
													if($cantidad_votos!=0){$promedio = round($votos/$cantidad_votos);}
													else{$promedio = 0;}
													echo'<div class="votos_articulo_completo">'.art_txt_calica.'&nbsp;<strong>'.$promedio .'</strong>&nbsp;'.art_txt_calica1.'&nbsp;<strong>'.$cantidad_votos.'</strong>&nbsp;'.art_txt_calica2.'</div>';
													if(!isset($_GET["men"]) || ( $_GET["men"]!="1" and $_GET["men"]!="2" and $_GET["men"]!="3") )
														{
															echo '<form name="calificar_articulo" id="calificar_articulo" class="margen_cero" method="post" action="index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'">';
																echo '<div class="campos_calificiar_articulo">';
																	echo art_txt_calificar;
																	echo '<input type="radio" name="votos" id="votos_1" value="1" /><label for="votos_1">1</label><input type="radio" name="votos" id="votos_2" value="2" /><label for="votos_2">2</label><input type="radio" name="votos" id="votos_3" value="3" checked="checked"/><label for="votos_3">3</label><input type="radio" name="votos" id="votos_4" value="4" /><label for="votos_4">4</label><input type="radio" name="votos" id="votos_5" value="5" /><label for="votos_5">5</label>&nbsp;';
																	echo '<input type="submit" name="btn_guardar" value="'.art_btn_env_voto.'"  />';
																	echo '<input type="hidden" id="votar_articulo" name="votar_articulo" value = "si" />';
																	echo '<input type="hidden" id="redireccion" name="redireccion" value = "si" />';	
																	if($_GET["pag"]=="")
																		{ echo '<input type="hidden" id="direccion_regreso" name="direccion_regreso" value = "index.php?sec='.$sec.'&clave_articulo='.$clave_articulo.'" />';}
																	else
																		{
																			$pagina_tem = $_GET["pag"];
																			echo '<input type="hidden" name="direccion_regreso" value = "index.php?sec='.$sec.'&clave_articulo='.$clave_articulo.'&pag='.$pagina_tem.'" />';
																		}
																echo '</div>';
															echo '</form>';
														}
													elseif(isset($_GET["men"]) && (($_GET["men"]=="1") or ($_GET["men"]=="2") or ($_GET["men"]=="3")))
														{
															echo '<div class="mensaje_calificar">';
																if($_GET["men"]=="1"){echo art_txt_mensaje1;}
																elseif($_GET["men"]=="2"){echo art_txt_mensaje2;}
																elseif($_GET["men"]=="3"){echo art_txt_mensaje3;}
															echo '</div>';
														}
												}
											echo '<br />';
											if($permitir_comentarios=="si")
												{
													if(isset($_GET["men"]) &&  (($_GET["men"]=="4") or ($_GET["men"]=="5")))
														{
															echo '<div class="mensaje_comentario">';
															if($_GET["men"]=="4"){echo art_txt_mensaje4;}
															if($_GET["men"]=="5"){echo art_txt_mensaje5;}
															echo '</div>';
														}
													echo '<br /><script type="text/javascript">';
													echo ' function validar_form(formulario)
																{
																	if(formulario.nombre.value == "") 
																		{
																			alert("'.art_txt_java_1.'");
																			formulario.nombre.focus(); 	
																			return false;
																		}	
																	if(formulario.comentario.value == "") 
																		{
																			alert("'.art_txt_java_2.'");
																			formulario.comentario.focus(); 	
																			return false;
																		}
																	formulario.btn_guardar.style.visibility="hidden";
																	formulario.submit();
																} ';
													echo '</script>';
													echo '<div class="titulo_comentarios">'.art_txt_realice_comentario.'</div>';
													echo '<form id="comentario" name="comentario" method="post" action="index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'">';
														echo '<div class="celda_izquierda"><label for="nombre">'.art_txt_nombre.'</label>: </div><div class="celda_derecha"><input type = "text" id = "nombre" name = "nombre" size = "60" /></div>';
														echo '<div class="celda_izquierda"><label for="correo">'.art_txt_correo.'</label>: </div><div class="celda_derecha"><input type = "text" id = "correo" name = "correo" size = "60" /></div>';
														echo '<div class="celda_izquierda"><label for="web">'.art_txt_web.'</label>: </div><div class="celda_derecha"><em>http://</em><input type = "text" id = "web" name = "web" size = "52" /></div>';
														echo '<div class="celda_izquierda">'.art_txt_comentario.'</div><div class="celda_derecha"><textarea id="comentario" name="comentario" cols="40" rows="5"></textarea></div>';
														echo '<div class="boton_enviar_comentario">';
															echo '<input type="button" name="btn_guardar" value="'.art_btn_env_comentario.'" onclick= "return validar_form(this.form)" />';
															echo '<input type="hidden" name="comentar_articulo" value = "si" />';
															echo '<input type="hidden" name="redireccion" value = "si" />';	
															if($moderar_comentarios=='no')
																{ $situacion_comentario='cancelado'; }
															else
																{ $situacion_comentario='activo'; }
															echo '<input type="hidden" name="situacion" value = "'.$situacion_comentario.'" />';
															if($_GET["pag"]=='')
																{$cadena_adicional = ''; }
															else
																{
																	$pagina_tem = $_GET["pag"];
																	$cadena_adicional = '&pag='.$pagina_tem;
																}
															echo '<input type="hidden" name="direccion_regreso" value = "index.php?sec='.$sec.'&clave_articulo='.$clave_articulo.$cadena_adicional.'" />';
														echo '</div>';
													echo '</form>';
													$consulta_comentarios = "select nombre, web, comentario, fecha, hora from nazep_zmod_articulos_comentarios  where clave_articulo = '$clave_articulo' and situacion = 'activo'";
													$res_com = mysql_query($consulta_comentarios);
													$can_com = mysql_num_rows($res_com);
													echo '<div class="titulo_comentarios_res"><a name="comentarios" id="comentarios"></a> '.art_txt_titu_com.': <strong>('.$can_com.')</strong></div>';
													while($ren_com = mysql_fetch_array($res_com))
														{
															$nombre = $ren_com["nombre"];
															$web = $ren_com["web"];
															$comentario = $ren_com["comentario"];
															$fecha = $ren_com["fecha"];
															$fecha = FunGral::fechaNormal($fecha);
															$hora = $ren_com["hora"];
															echo'<div class="comentario_mensaje">';
																if($web!="")
																	{ echo '<a href="http://'.$web.'" target="_blank"><strong>'.$nombre.'</strong></a>'; }
																else
																	{ echo '<strong>'.$nombre.'</strong>'; }
																echo '<br />'.$fecha.' - '.$hora .' Hrs. <br /><br />'.$comentario;
															echo '</div>';
															echo '<div class="renglon_vacio_articulo"></div>';	
														}
												}
										echo '</div>';
										$visita = "update nazep_zmod_articulos set visitas = visitas+1 where clave_articulo = '$clave_articulo'";
										if (!@mysql_query($visita))
											{ echo art_txt_novisitas; }
									}
								else
									{ HtmlVista::ContenidoNoDisponible($ubicacion_tema); }
							}
						else
							{ HtmlVista::contenido_no_disponible($ubicacion_tema); }
					}
				elseif($can_con!="")
					{						
						if(($ver_buscador=='si') and ( (isset($_GET["dia_i"]) && isset($_GET["mes_i"]) && isset($_GET["ano_i"])&& isset($_GET["dia_t"]) && isset($_GET["mes_t"])&& isset($_GET["ano_t"])) && ($_GET["dia_i"]!= "") and ($_GET["mes_i"]!="") and ($_GET["ano_i"]!= "") and ($_GET["dia_t"]!="") and ($_GET["mes_t"]!="") and ($_GET["ano_t"]!="")))
							{
								$dia=date('d');
								$mes=date('m');
								$ano=date('Y');						
								$dia_i = $_GET["dia_i"];
								$mes_i = $_GET["mes_i"];
								$ano_i = $_GET["ano_i"];
								$dia_t = $_GET["dia_t"];
								$mes_t = $_GET["mes_t"];
								$ano_t = $_GET["ano_t"];
								$pasa_contenido = true;
								if(!is_numeric($dia_i))
									 $dia_i = $dia;
								if(!is_numeric($mes_i))
									 $mes_i = $mes;
								if(!is_numeric($ano_i))
									 $ano_i = $ano;
								if(!is_numeric($dia_t))
									 $dia_t = $dia;
								if(!is_numeric($mes_t))
									 $mes_t = $mes;
								if(!is_numeric($ano_t))
									 $ano_t = $ano;
								
								$clave_tema = $_GET["clave_tema"];
								if($clave_tema =='')
									$clave_tema = 0;
								elseif(!is_numeric($clave_tema))
									$clave_tema = 0;
									 								
								if($clave_tema>0)
									{
										$con_nom_tem = "select nombre from nazep_zmod_articulos_temas where clave_tema = '$clave_tema'";
										$res_nom_tem = mysql_query($con_nom_tem);
										$ren_nom_tem = mysql_fetch_array($res_nom_tem);
										$nombre_tema_resultado = $ren_nom_tem["nombre"];
										$cadena_tema = " and clave_tema = '$clave_tema'";
									}
								else
									{
										$cadena_tema = '';
										$nombre_tema_resultado = 'Todos';
									}

								$fecha_ini_c = $ano_i."-".$mes_i."-".$dia_i;
								$fecha_ini = FunGral::$formato_fecha_lista($fecha_ini_c);
								$fecha_fin_c = $ano_t."-".$mes_t."-".$dia_t;
								$fecha_fin = FunGral::$formato_fecha_lista($fecha_fin_c);
								
								$con_total_art = "select clave_articulo from nazep_zmod_articulos 
								where clave_tipo = '$clave_tipo' and situacion = 'activo'
								and fecha_articulo >= '$fecha_ini_c' and fecha_articulo	<= '$fecha_fin_c'
								".$cadena_tema.' '.$cadena_adicional;
								
								$con_part_art = "select clave_articulo, titulo, resumen_$tipo_resumen_ver, 
								hora_creacion, lugar_articulo, fecha_articulo, numero_articulo, visitas, clave_tema,
								nombre_actualiza, fecha_actualizacion, hora_actualizacion
								from nazep_zmod_articulos 
								where clave_tipo = '$clave_tipo' and situacion = 'activo'
								and fecha_articulo >= '$fecha_ini_c' and fecha_articulo	<= '$fecha_fin_c'
								".$cadena_tema.' '.$cadena_adicional."order by fecha_articulo desc, numero_articulo desc, hora_creacion desc";
								
								echo '<div id="centro_contenido_art" class="centro_contenido_gral">';
									echo '<div class="tit_res_busca_art">'.art_txt_titu_res_bus.'</div>';
									echo '<div class="tit_res_busca_art2">De '.$fecha_ini.' a '.$fecha_fin.'</div>';
									echo '<div class="tit_res_busca_art3">'.art_txt_titu_res_bus2.$nombre_tema_resultado.'</div>';
									echo '<div class="renglon_vacio_articulo"></div>';
								echo'</div>';
							}
						else
							{								
								$con_total_art ="select clave_articulo from nazep_zmod_articulos  where clave_tipo = '$clave_tipo' and situacion = 'activo' ".$cadena_adicional;
								$con_part_art = "select clave_articulo, titulo, resumen_$tipo_resumen_ver, 
								hora_creacion, lugar_articulo, fecha_articulo, numero_articulo, visitas, clave_tema, nombre_actualiza, fecha_actualizacion, hora_actualizacion
								from nazep_zmod_articulos 
								where clave_tipo = '$clave_tipo' and situacion = 'activo'".$cadena_adicional." order by fecha_articulo desc, numero_articulo desc, hora_creacion desc";
							}
						$res_total = mysql_query($con_total_art);
						$can_total = mysql_num_rows($res_total);
						$cantidad_resultados = $cantidad_art_mostrar;
						$pasa_contenido = true;
						
						if(!isset($_GET["pagina"])  ||  $_GET["pagina"]=='')
							{
								$pagina= 1;
								$inicio = 0;
							}
						else
							{
								$pagina = $_GET["pagina"];
								if(!is_numeric($pagina))
									{
										$pasa_contenido = false;
										$pag_con = 1;
										$inicio = 0;											
									}
								else
									{
										$pasa_contenido = true;
										$inicio = ($pagina - 1) * $cantidad_resultados;
									}
							}
						if($pasa_contenido)
							{
								$total_paginas = ceil($can_total/$cantidad_resultados);
								$con_part_art .= " limit $inicio, $cantidad_resultados";
								$res_part_art = mysql_query($con_part_art);
								$cantidad_art_parcial = mysql_num_rows($res_part_art);								
								echo '<div id="centro_contenido_art" class="centro_contenido_gral">';
									$cuerpo_listado = '';								
									while($ren_part_art = mysql_fetch_array($res_part_art))
										{
											$clave_articulo = $ren_part_art["clave_articulo"];
											$titulo = stripslashes($ren_part_art["titulo"]);
											$resumen = stripslashes($ren_part_art["resumen_".$tipo_resumen_ver]);
											$lugar_articulo = stripslashes($ren_part_art["lugar_articulo"]);
											$hora_creacion = $ren_part_art["hora_creacion"];
											$fecha_articulo = $ren_part_art["fecha_articulo"];
											$fecha_articulo = FunGral::$formato_fecha_lista($fecha_articulo);
											$numero_articulo = $ren_part_art["numero_articulo"];
											$visitas = $ren_part_art["visitas"];	
											$clave_tema_art = $ren_part_art["clave_tema"];
											$nombre_actualiza = $ren_part_art["nombre_actualiza"];
											$fecha_actualizacion = $ren_part_art["fecha_actualizacion"];
											$hora_actualizacion = $ren_part_art["hora_actualizacion"];
											$renglon_separacion = '<div class="renglon_vacio_articulo"></div>';
											if($tipo_separacion_lista=="linea")
												{$separacion_lista = '<hr class="separacion_hr_lista_articulos" />';}
											else
												{$separacion_lista = '&nbsp;';}
											$renglon_separacion_articulo = '<div  class="renglon_sep_lista">'.$separacion_lista.'</div>';
											$div_enlace_titulo = '';
											if($permitir_ver_cuerpo=="si" and $partes_enlace_cuerpo_array["0"] == "1")
												{ $div_enlace_titulo .= ' id ="div_titulo_articulo_lista" class = "div_titulo_articulo_lista" onclick="javascript:location.href=\'index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'\';"'; }
											$arreglo_renglones[$posicion_titulo_lista] = 
											'<div class="titulo_articulo_lista"><div '.$div_enlace_titulo.'>'.$titulo.'</div></div>';
											if(($permitir_ver_temas_lista=="si") and ($usar_tema=="si"))
												{
													$con_temas = "select nombre from nazep_zmod_articulos_temas where clave_tema = '$clave_tema_art'";
													$res_temas = mysql_query($con_temas);
													$ren_temas = mysql_fetch_array($res_temas);
													$nombre_tema = stripslashes($ren_temas["nombre"]);
													$arreglo_renglones[$posicion_tema_lista] = '<div class="tema_articulo_lista">'.art_txt_tema_solo.''.$nombre_tema.'</div>';
												}
											$div_enlace_numero = '';
											if($permitir_ver_cuerpo=="si" and $partes_enlace_cuerpo_array["3"] == "4")
												{ $div_enlace_numero = 'id ="div_numero_articulo_lista" class = "div_numero_articulo_lista" onclick="javascript:location.href=\'index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'\';"';	 }
											if($permitir_ver_numero_lista=="si")
												{ $arreglo_renglones[$posicion_numero_lista] = '<div class="numero_articulo_lista"><div '.$div_enlace_numero.'>'.$nombre_tipo.art_txt_numero_corto.$numero_articulo.'</div></div>'; }
											if(($ver_lugar_lista=="no") and ($ver_fecha_lista=="no") and ($ver_hora_lista =="no"))
												{$temporal_fecha= '';}
											else
												{
													$temporal_fecha = '<div class="fecha_articulo_lista">';
													if($ver_lugar_lista=="si")
														 $temporal_fecha .= $lugar_articulo.'&nbsp;'; 
													if($ver_fecha_lista=="si")
														$temporal_fecha .= $fecha_articulo.'&nbsp;';
													if($ver_hora_lista =="si")
														$temporal_fecha .= $hora_creacion.'&nbsp;'.art_txt_ultim_actu3;
													$temporal_fecha .= '</div>';
													$arreglo_renglones[$posicion_fecha_lugar_lista] = $temporal_fecha;
												}
											$div_enlace_resumen = '';
											if($permitir_ver_cuerpo=="si" and $partes_enlace_cuerpo_array["1"] == "2")
												{$div_enlace_resumen = 'id ="div_resumen_articulo_lista" class = "div_resumen_articulo_lista" onclick="javascript:location.href=\'index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'\';"';	}
											$arreglo_renglones[$posicion_resumen_lista] = 
											'<div class="resumen_articulo_lista_enlace"><div '.$div_enlace_resumen.'>'.$resumen.'</div></div>';
											if($permitir_ver_cuerpo=="si" and $partes_enlace_cuerpo_array["2"] == "3")
												{
													$arreglo_renglones[$posicion_resumen_lista] .=  '<div class="renglon_vacio_articulo"></div>'.
													'<div class="leer_articulo_lista"> <a class="leer_mas_articulo" href="index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'">'.art_txt_leer.'</a></div>';
												}
											if($permitir_ver_visitas_lista=="si")
												{ $arreglo_renglones[$posicion_visitas_lista] = '<div class="visitas_articulo_lista">'.art_txt_visitas.'&nbsp;'.$visitas.'</div>';}
											if($per_ver_fec_actualiza_lista=="si")
												{ $arreglo_renglones[$posicion_fe_act_lista] = '<div class="ultima_actualizacion_articulo_lista">'.art_txt_ultim_actu.': <br />'. $fecha_actualizacion.'&nbsp;'.art_txt_ultim_actu2.'&nbsp;'.$hora_actualizacion.'&nbsp;'.art_txt_ultim_actu3.'<br />'.art_txt_ultim_actu4.'&nbsp;'.$nombre_actualiza.'</div>';}
											for($a=1;$a<=7;$a++)
												{
													$renglon_temporal = $arreglo_renglones[$a];
													if($renglon_temporal!="")
														{ $cuerpo_listado .= $renglon_temporal.$renglon_separacion; }
												}
											$cuerpo_listado .= $renglon_separacion_articulo;
										}
									if($ver_buscador=='si')
										{
											if($posicion_buscador=='abajo')
												{echo $cuerpo_listado;}
											$dia=date('d');
											$mes=date('m');
											$ano=date('Y');	
											$arreglo_meses = FunGral::MesesNumero();	
											echo '<form name="buscar_articulo" id="buscar_articulo" method="get" action="index.php?sec='.$sec.'">';	
												echo '<input type="hidden" name="sec" value = "'.$sec.'" />';
												echo '<div id="fec_bus_ini_art" class="div_fec_bus">'.art_txt_fec_bus_ini.'&nbsp;'.$nombre_tipo.'&nbsp;';
													echo dia.'&nbsp;<select id ="dia_i" name = "dia_i">';
													for ($a = 1; $a<=31; $a++)
														{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' > '.$a.' </option>';}
													echo '</select>&nbsp;';
													echo mes.'&nbsp;<select id = "mes_i" name = "mes_i">';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $arreglo_meses[$b] .'</option>';}
													echo '</select>&nbsp;';
													echo ano.'&nbsp;<select id = "ano_i" name = "ano_i">';
													for ($c=$ano-10; $c<=$ano+10; $c++)
														{echo '<option value = "'.$c.'" '; if ($ano == $c) {echo ' selected="selected" ';} echo '>'.$c.'</option>';}
													echo '</select>';
												echo '</div>';
												echo '<div id="fec_bus_fin_art" class="div_fec_bus">'.art_txt_fec_bus_fin.'&nbsp;'.$nombre_tipo.'&nbsp;';
													echo dia.'&nbsp;<select name = "dia_t">';
													for ($a = 1; $a<=31; $a++)
														{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' > '.$a.' </option>';}
													echo '</select>&nbsp;';
													echo mes.'&nbsp;<select name = "mes_t">';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $arreglo_meses[$b] .'</option>';}
													echo '</select>&nbsp;';
													echo ano.'&nbsp;<select name = "ano_t">';
													for ($c=$ano-10; $c<=$ano+10; $c++)
														{echo '<option value = "'.$c.'" '; if ($ano == $c) {echo ' selected="selected" ';} echo '> '.$c.'</option>';}
													echo '</select>&nbsp;';
												echo '</div>';
												if($usar_tema=="si")
													{
														echo '<div id="tipo_bus_fin_art" class="div_tip_bus">';
															$con_temas ="select nombre, clave_tema from nazep_zmod_articulos_temas where clave_tipo = '$clave_tipo' and situacion = 'activo'";
															$res_temas = mysql_query($con_temas);
															echo art_txt_tema_bus.'&nbsp;'.$nombre_tipo.'&nbsp;';
															echo '<select id ="clave_tema" name = "clave_tema"><option value = "0" >Todos ...</option>';
																while($ren_temas = mysql_fetch_array($res_temas))
																	{
																		$nombre = stripslashes($ren_temas["nombre"]);
																		$clave_tema_b = $ren_temas["clave_tema"];
																		echo '<option value = "'.$clave_tema_b.'" >'.$nombre.'</option>';
																	}
															echo '</select>';
														echo '</div>';
													}
												echo '<div id="boton_buscar" class="div_btn_buscar_vista" > <input type="submit" name="btn_buscar_articulo" value="'.art_btn_buscar.'" /></div>';
											echo '</form>';
											if($posicion_buscador=='arriba')
												{echo $cuerpo_listado;}
											if ($total_paginas > 1)
												{
													echo '<div id="paginacion_lista_titulo" class="titulo_paginacion_lista_articulos" >'.titulo_pag_list_articulos.'</div>';
													echo '<div id="paginacion_lista_numeros" class="celda_paginacion_articulos_lista" >';		
														for ($i=1;$i<=$total_paginas;$i++)
															{
																if ($pagina == $i)		
																	echo '<span class="numero_pagina_seleccionado_articulo">&nbsp;'.$pagina.'&nbsp;</span>';
																else
																	echo ' <a title="'.art_txt_pagina.' #'.$i.'" class="enlace_paginado_articulo" href="index.php?sec='.$sec.'&amp;dia_i='.$dia_i.'&amp;mes_i='.$mes_i.'&amp;ano_i='.$ano_i.'&amp;dia_t='.$dia_t.'&amp;mes_t='.$mes_t.'&amp;ano_t='.$ano_t.'&amp;clave_tema='.$clave_tema.'&amp;pagina='.$i.'">'.$i.'</a> ';
															}
													echo '</div>';
												}
										}
									else
										{
											echo $cuerpo_listado;
											if ($total_paginas > 1)
												{
													echo '<div id="paginacion_lista_titulo" class="titulo_paginacion_lista_articulos" >'.titulo_pag_list_articulos.'</div>';
													echo '<div id="paginacion_lista_numeros" class="celda_paginacion_articulos_lista" >';
														for ($i=1;$i<=$total_paginas;$i++)
															{
																if ($pagina == $i)
																	echo '<span class="numero_pagina_seleccionado_articulo">&nbsp;'.$pagina.'&nbsp;</span>';
																else
																	echo ' <a title="'.art_txt_pagina.' #'.$i.'" class="enlace_paginado_articulo" href="index.php?sec='.$sec.'&amp;pagina='.$i.'">'.$i.'</a> ';
															}
													echo '</div>';
												}
										}
								echo '</div>';
							}
						else
							{HtmlVista::ContenidoNoDisponible($ubicacion_tema);}
					}
				else
					{echo 'Se Requiere Configurar el M&oacute;dulo de Articulos Paginados';	}
			}	
		function vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$con_configuracion ="select clave_tipo, nombre, cantidad_art_mostrar, posicion_titulo_lista, posicion_titulo_cuerpo,
				usar_tema, permitir_ver_temas_lista, permitir_ver_temas_cuerpo, posicion_tema_lista, posicion_tema_cuerpo,
				permitir_ver_numero_lista, permitir_ver_numero, posicion_numero_lista, posicion_numero_cuerpo, 
				ver_fecha_lista, formato_fecha_lista, ver_hora_lista, ver_lugar_lista, 
				ver_fecha_cuerpo, formato_fecha_cuerpo, ver_hora_cuerpo, ver_lugar_cuerpo, posicion_fecha_lugar_lista, posicion_fecha_lugar_cuerpo,
				tipo_resumen_ver, permitir_ver_resumen_cuerpo, posicion_resumen_lista, posicion_resumen_cuerpo,  
				permitir_ver_cuerpo, partes_enlace_cuerpo, posicion_cuerpo, 
				permitir_ver_visitas_lista, permitir_ver_visitas, posicion_visitas_lista, posicion_visitas_cuerpo, 
				per_ver_fec_actualiza_lista, per_ver_fec_actualiza, posicion_fe_act_lista, posicion_fe_act_cuerpo, 
				permitir_caducar, permitir_calificar, permitir_comentarios, moderar_comentarios, permitir_comentarios_lista,
				ver_buscador, tipo_separacion_lista from nazep_zmod_articulos_tipos where clave_seccion = '$sec'";
				$cadena_adicional=  "";
				$res_configuracion = mysql_query($con_configuracion);
				$ren_configuracion = mysql_fetch_array($res_configuracion);
				$can_con = mysql_num_rows($res_configuracion);
				$clave_tipo =  $ren_configuracion["clave_tipo"];
				$nombre_tipo = $ren_configuracion["nombre"];
				$cantidad_art_mostrar = $ren_configuracion["cantidad_art_mostrar"];
				$posicion_titulo_lista = $ren_configuracion["posicion_titulo_lista"];
				$posicion_titulo_cuerpo = $ren_configuracion["posicion_titulo_cuerpo"];
				$usar_tema = $ren_configuracion["usar_tema"];
				$permitir_ver_temas_lista = $ren_configuracion["permitir_ver_temas_lista"];
				$permitir_ver_temas_cuerpo = $ren_configuracion["permitir_ver_temas_cuerpo"];
				$posicion_tema_lista = $ren_configuracion["posicion_tema_lista"];
				$posicion_tema_cuerpo = $ren_configuracion["posicion_tema_cuerpo"];
				$permitir_ver_numero_lista = $ren_configuracion["permitir_ver_numero_lista"];
				$permitir_ver_numero = $ren_configuracion["permitir_ver_numero"];
				$posicion_numero_lista = $ren_configuracion["posicion_numero_lista"];
				$posicion_numero_cuerpo = $ren_configuracion["posicion_numero_cuerpo"];
				$ver_fecha_lista = $ren_configuracion["ver_fecha_lista"];
				$formato_fecha_lista = $ren_configuracion["formato_fecha_lista"];
				$ver_hora_lista = $ren_configuracion["ver_hora_lista"];
				$ver_lugar_lista = $ren_configuracion["ver_lugar_lista"];
				$ver_fecha_cuerpo = $ren_configuracion["ver_fecha_cuerpo"];
				$formato_fecha_cuerpo = $ren_configuracion["formato_fecha_cuerpo"];
				$ver_hora_cuerpo = $ren_configuracion["ver_hora_cuerpo"];
				$ver_lugar_cuerpo = $ren_configuracion["ver_lugar_cuerpo"];
				$posicion_fecha_lugar_lista = $ren_configuracion["posicion_fecha_lugar_lista"];
				$posicion_fecha_lugar_cuerpo = $ren_configuracion["posicion_fecha_lugar_cuerpo"];
				$tipo_resumen_ver = $ren_configuracion["tipo_resumen_ver"];
				$permitir_ver_resumen_cuerpo = $ren_configuracion["permitir_ver_resumen_cuerpo"];
				$posicion_resumen_lista = $ren_configuracion["posicion_resumen_lista"];
				$posicion_resumen_cuerpo = $ren_configuracion["posicion_resumen_cuerpo"];
				$permitir_ver_cuerpo = $ren_configuracion["permitir_ver_cuerpo"];
				$partes_enlace_cuerpo = $ren_configuracion["partes_enlace_cuerpo"];
				$partes_enlace_cuerpo_array = explode(",", $partes_enlace_cuerpo);
				$posicion_cuerpo = $ren_configuracion["posicion_cuerpo"];
				$permitir_ver_visitas_lista = $ren_configuracion["permitir_ver_visitas_lista"];
				$permitir_ver_visitas = $ren_configuracion["permitir_ver_visitas"];
				$posicion_visitas_lista = $ren_configuracion["posicion_visitas_lista"];
				$posicion_visitas_cuerpo = $ren_configuracion["posicion_visitas_cuerpo"];
				$per_ver_fec_actualiza_lista = $ren_configuracion["per_ver_fec_actualiza_lista"];
				$per_ver_fec_actualiza = $ren_configuracion["per_ver_fec_actualiza"];
				$posicion_fe_act_lista = $ren_configuracion["posicion_fe_act_lista"];
				$posicion_fe_act_cuerpo = $ren_configuracion["posicion_fe_act_cuerpo"];
				$permitir_caducar = $ren_configuracion["permitir_caducar"];
				$permitir_calificar = $ren_configuracion["permitir_calificar"];
				$permitir_comentarios = $ren_configuracion["permitir_comentarios"];
				$moderar_comentarios = $ren_configuracion["moderar_comentarios"];
				$permitir_comentarios_lista = $ren_configuracion["permitir_comentarios_lista"];
				$ver_buscador = $ren_configuracion["ver_buscador"];
				$tipo_separacion_lista = $ren_configuracion["tipo_separacion_lista"];
				if($permitir_caducar =="si")
					{
						$hoy = date('Y-m-d');
						$cadena_adicional= " and fecha_inicio <= '$hoy' and fecha_fin >= '$hoy' ";
					}
				if(isset($_GET["clave_articulo"]) &&  $_GET["clave_articulo"]!="" and $permitir_ver_cuerpo == "si")
					{
						$clave_articulo = $_GET["clave_articulo"];
						$pag_con = $_GET["pag"];
						
						if($pag_con == '')
							$pag_con = 1;
							
						if((is_numeric($clave_articulo)) && (is_numeric($pag_con))  && ($clave_articulo>0) )
							{
								$con_articulo = "select a.fecha_actualizacion, a.nombre_actualiza, a.hora_actualizacion, a.fecha_articulo, a.lugar_articulo, a.titulo,
								a.numero_articulo, a.visitas, a.cantidad_votos, a.votos, ap.texto, a.clave_tema, a.hora_creacion, a.resumen_$tipo_resumen_ver
								from nazep_zmod_articulos  a, nazep_zmod_articulos_paginas ap
								where a.clave_articulo = ap.clave_articulo and a.clave_articulo = '$clave_articulo'
								and a.situacion = 'activo' and ap.situacion = 'activo' and ap.pagina = '$pag_con' $cadena_adicional";
								$res_articulo = mysql_query($con_articulo);
								$ren_articulo = mysql_fetch_array($res_articulo);
								$can_pagina = mysql_num_rows($res_articulo);
								if($can_pagina>0)
									{								
										$nombre_actualiza = $ren_articulo["nombre_actualiza"];
										$fecha_actualizacion = $ren_articulo["fecha_actualizacion"];
										$fecha_actualizacion = FunGral::fechaNormal($fecha_actualizacion);
										$hora_actualizacion = $ren_articulo["hora_actualizacion"];
										$fecha_articulo = $ren_articulo["fecha_articulo"];
										$fecha_articulo = FunGral::$formato_fecha_cuerpo($fecha_articulo);
										$clave_tema = $ren_articulo["clave_tema"];
										$hora_creacion = $ren_articulo["hora_creacion"];
										$lugar_articulo = stripslashes($ren_articulo["lugar_articulo"]);
										$titulo = stripslashes($ren_articulo["titulo"]);
										$numero_articulo = $ren_articulo["numero_articulo"];
										$visitas = $ren_articulo["visitas"];
										$cantidad_votos = $ren_articulo["cantidad_votos"];
										$votos = $ren_articulo["votos"];
										$texto = stripslashes($ren_articulo["texto"]);
										$resumen = stripslashes($ren_articulo["resumen_".$tipo_resumen_ver]);
										echo '<div id="centro_contenido_art_print" class="div_contenido_principal_print">';
										$renglon_separacion = '<div class="renglon_vacio_articulo"></div>';
										$arreglo_renglones[$posicion_titulo_cuerpo] = '<div class="titulo_articulo_completo">'.$titulo.'</div>';
										if(($permitir_ver_temas_cuerpo=="si") and ($usar_tema  =="si"))
											{
												$con_tema = "select nombre from nazep_zmod_articulos_temas where clave_tema = '$clave_tema'";
												$res_tema = mysql_query($con_tema);
												$ren_tema = mysql_fetch_array($res_tema);
												$nombre_tema = stripslashes($ren_tema["nombre"]);	
												$arreglo_renglones[$posicion_tema_cuerpo] = '<div class="tema_articulo_completo">'.art_txt_tema.': '.$nombre_tema.'</div>'; 
											}
										if($permitir_ver_numero == "si")
											{$arreglo_renglones[$posicion_numero_cuerpo] ='<div class="numero_articulo_completo">'.art_txt_numero.': '.$numero_articulo.'</div>';}
										if(($ver_fecha_cuerpo=="no")and ($ver_hora_cuerpo=="no")and($ver_lugar_cuerpo=="no"))
											{$temporal_lug_fec_hor = '';}
										else
											{
												$temporal_lug_fec_hor = '<div class="fecha_articulo_completo">';
												if($ver_lugar_cuerpo=="si")
													{ $temporal_lug_fec_hor .= $lugar_articulo.'&nbsp;'; }
												if($ver_fecha_cuerpo=="si")
													{ $temporal_lug_fec_hor .= $fecha_articulo.'&nbsp;'; }
												if($ver_hora_cuerpo=="si")
													{ $temporal_lug_fec_hor .= $hora_creacion.'&nbsp;'; }
												$temporal_lug_fec_hor .= '</div>';
												$arreglo_renglones[$posicion_fecha_lugar_cuerpo] =$temporal_lug_fec_hor;
											}
										if($permitir_ver_resumen_cuerpo == "si")
											{$arreglo_renglones[$posicion_resumen_cuerpo] = '<div class="resumen_articulo_completo">'.$resumen.'</div>';}
										$temporal_cuerpo ='<div class="cuerpo_articulo_completo">'.$texto.'</div>';
										$consulta_contenido_pag = "select pagina from nazep_zmod_articulos_paginas where clave_articulo = '$clave_articulo' and situacion = 'activo' order by pagina";
										$res_con_pag = mysql_query($consulta_contenido_pag);
										$cantidad_con = mysql_num_rows($res_con_pag);
										if($cantidad_con!="0" and $cantidad_con!="1")
											{
												$temporal_cuerpo .= '<div class="titulo_paginacion_articulos">'.art_txt_titu_pag.'</div><div class="celda_paginacion_articulos">';
												while($ren_con = mysql_fetch_array($res_con_pag))
													{
														$pagina = $ren_con["pagina"];
														if($pag_con == $pagina)
															{$temporal_cuerpo .= '<span class="numero_pagina_seleccionado_articulo">&nbsp;'.$pagina.'&nbsp;</span>';}
														else
															{$temporal_cuerpo .=' <a title="'.art_txt_pagina.' #'.$pagina.'" class="enlace_paginado_articulo" href="index.php?sec='.$sec.'&amp;clave_articulo='.$clave_articulo.'&amp;pag='.$pagina.'">'.$pagina.'</a> ';}
													}
												$temporal_cuerpo .= '</div>';
											}
										$arreglo_renglones[$posicion_cuerpo] = $temporal_cuerpo;
										if($permitir_ver_visitas=="si")
											{$arreglo_renglones[$posicion_visitas_cuerpo] = '<div class="visitas_articulo_completo">'.art_txt_visitas.': '.$visitas.'</div>';}
										if($per_ver_fec_actualiza=="si")
											{$arreglo_renglones[$posicion_fe_act_cuerpo] = '<div class="texto_actualizacion">'.art_txt_ultim_actu.': <br />'. $fecha_actualizacion.'&nbsp;'.art_txt_ultim_actu2.'&nbsp;'.$hora_actualizacion.'&nbsp;'.art_txt_ultim_actu3.'<br />'.art_txt_ultim_actu4.'&nbsp;'.$nombre_actualiza.'</div>';}
										for($a=1;$a<=8;$a++)
											{
												$renglon_temporal = $arreglo_renglones[$a];
												if($renglon_temporal!="")
													{ echo $renglon_temporal.$renglon_separacion; }
											}
										if($permitir_calificar=="si")
											{
												if($cantidad_votos!=0){$promedio = round($votos/$cantidad_votos);}
												else{$promedio = 0;}
												echo'<div class="votos_articulo_completo">'.art_txt_calica.'&nbsp;<strong>'.$promedio .'</strong>&nbsp;'.art_txt_calica1.'&nbsp;<strong>'.$cantidad_votos.'</strong>&nbsp;'.art_txt_calica2.'</div>';
											}
										if($permitir_comentarios=="si")
											{
												$consulta_comentarios = "select nombre, web, comentario, fecha, hora
												from nazep_zmod_articulos_comentarios where clave_articulo = '$clave_articulo' and situacion = 'activo'";
												$res_com = mysql_query($consulta_comentarios);
												$can_com = mysql_num_rows($res_com);
												echo '<div class="titulo_comentarios_res">'.art_txt_titu_com.': <strong>'.$can_com.'</strong></div>';
													while($ren_com = mysql_fetch_array($res_com))
														{
															$nombre = $ren_com["nombre"];
															$web = $ren_com["web"];
															$comentario = $ren_com["comentario"];
															$fecha = $ren_com["fecha"];
															$fecha = FunGral::fechaNormal($fecha);
															$hora = $ren_com["hora"];
															echo'<div class="comentario_mensaje">';
																if($web!="")
																	{ echo '<a href="http://'.$web.'" target="_blank"><strong>'.$nombre.'</strong></a>'; }
																else
																	{ echo '<strong>'.$nombre.'</strong>'; }
																echo '<br />'.$fecha.' - '.$hora .' Hrs.<br /><br />'.$comentario;
															echo '</div><div class="renglon_vacio_articulo"></div>';
														}
												echo '</div>';
											}
									}
								else
									{HtmlVista::ContenidoNoDisponible($ubicacion_tema);}									
							}
						else
							{HtmlVista::ContenidoNoDisponible($ubicacion_tema);}
					}
				elseif($can_con!="")
					{
						if($ver_buscador=="si" and (@$_GET["dia_i"]!= "" and @$_GET["mes_i"]!="" and @$_GET["ano_i"]!=""  and @$_GET["dia_t"]!="" and @$_GET["mes_t"]!="" and @$_GET["ano_t"]!=""))
							{
								$dia=date('d');
								$mes=date('m');
								$ano=date('Y');						
								$dia_i = $_GET["dia_i"];
								$mes_i = $_GET["mes_i"];
								$ano_i = $_GET["ano_i"];
								$dia_t = $_GET["dia_t"];
								$mes_t = $_GET["mes_t"];
								$ano_t = $_GET["ano_t"];
								$pasa_contenido = true;
								if(!is_numeric($dia_i))
									 $dia_i = $dia;
								if(!is_numeric($mes_i))
									 $mes_i = $mes;
								if(!is_numeric($ano_i))
									 $ano_i = $ano;
								if(!is_numeric($dia_t))
									 $dia_t = $dia;
								if(!is_numeric($mes_t))
									 $mes_t = $mes;
								if(!is_numeric($ano_t))
									 $ano_t = $ano;
								$clave_tema = $_GET["clave_tema"];
								if($clave_tema =='')
									$clave_tema = 0;
								elseif(!is_numeric($clave_tema))
									$clave_tema = 0;
								if($clave_tema>"0")
									{
										$con_nom_tem = "select nombre from nazep_zmod_articulos_temas where clave_tema = '$clave_tema'";
										$res_nom_tem = mysql_query($con_nom_tem);
										$ren_nom_tem = mysql_fetch_array($res_nom_tem);
										$nombre_tema_resultado = $ren_nom_tem["nombre"];
										$cadena_tema = " and clave_tema = '$clave_tema'";
									}
								else
									{
										$cadena_tema = "";
										$nombre_tema_resultado = "Todos";
									}
								$fecha_ini_c = $ano_i."-".$mes_i."-".$dia_i;
								$fecha_ini = FunGral::$formato_fecha_lista($fecha_ini_c);
								$fecha_fin_c = $ano_t."-".$mes_t."-".$dia_t;
								$fecha_fin = FunGral::$formato_fecha_lista($fecha_fin_c);
								$con_total_art = "select clave_articulo from nazep_zmod_articulos
								where clave_tipo = '$clave_tipo' and situacion = 'activo' and fecha_articulo >= '$fecha_ini_c' and fecha_articulo	<= '$fecha_fin_c' ".$cadena_tema." ".$cadena_adicional;
								$con_part_art ="select clave_articulo, titulo, resumen_$tipo_resumen_ver, fecha_articulo
								from nazep_zmod_articulos  where clave_tipo = '$clave_tipo' and situacion = 'activo' and fecha_articulo >= '$fecha_ini_c' and fecha_articulo	<= '$fecha_fin_c' ".$cadena_tema." ".$cadena_adicional." order by fecha_articulo desc, numero_articulo desc";
								echo '<div id="centro_contenido_art_print" class="div_contenido_principal_print">';
									echo '<div class="tit_res_busca_art">'.art_txt_titu_res_bus.'</div>';
									echo '<div class="tit_res_busca_art2">De '.$fecha_ini.' a '.$fecha_fin.'</div>';
									echo '<div class="tit_res_busca_art3">'.art_txt_titu_res_bus2.$nombre_tema_resultado.'</div>';
									echo '<div class="renglon_vacio_articulo"></div>';
								echo'</div>';
							}
						else
							{
								$con_total_art ="select clave_articulo from nazep_zmod_articulos  where clave_tipo = '$clave_tipo' and situacion = 'activo' ".$cadena_adicional;
								$con_part_art ="select clave_articulo, titulo, resumen_$tipo_resumen_ver, 
								hora_creacion, lugar_articulo, fecha_articulo, numero_articulo, visitas, clave_tema, nombre_actualiza, fecha_actualizacion, hora_actualizacion
								from nazep_zmod_articulos  where clave_tipo = '$clave_tipo' and situacion = 'activo' ".$cadena_adicional."order by fecha_articulo desc, numero_articulo desc";
							}
						$res_total = mysql_query($con_total_art);
						$can_total = mysql_num_rows($res_total);
						$cantidad_resultados = $cantidad_art_mostrar;
						$pasa_contenido = true;
						if(!isset($_GET["pagina"])  ||  $_GET["pagina"]=="")
							{
								$pagina= 1;
								$inicio = 0;
							}
						else
							{
								$pagina = $_GET["pagina"];
								if(!is_numeric($pagina))
									{
										$pasa_contenido = false;
										$pag_con = 1;
										$inicio = 0;											
									}
								else
									{
										$pasa_contenido = true;
										$inicio = ($pagina - 1) * $cantidad_resultados;
									}
							}
						if($pasa_contenido)
							{
								$total_paginas = ceil($can_total/ $cantidad_resultados);
								$con_part_art .= " limit $inicio, $cantidad_resultados";
								$res_part_art = mysql_query($con_part_art);
								echo '<div id="centro_contenido_art_print" class="div_contenido_principal_print">';
									while($ren_part_art = mysql_fetch_array($res_part_art))
										{
											$clave_articulo = $ren_part_art["clave_articulo"];
											$titulo = $ren_part_art["titulo"];
											$resumen = $ren_part_art["resumen_".$tipo_resumen_ver];
											$lugar_articulo = $ren_part_art["lugar_articulo"];
											$hora_creacion = $ren_part_art["hora_creacion"];
											$fecha_articulo = $ren_part_art["fecha_articulo"];
											$fecha_articulo = FunGral::$formato_fecha_lista($fecha_articulo);
											$numero_articulo = $ren_part_art["numero_articulo"];
											$visitas = $ren_part_art["visitas"];	
											$clave_tema_art = $ren_part_art["clave_tema"];
											$nombre_actualiza = $ren_part_art["nombre_actualiza"];
											$fecha_actualizacion = $ren_part_art["fecha_actualizacion"];
											$hora_actualizacion = $ren_part_art["hora_actualizacion"];
											$renglon_separacion = '<div class="renglon_vacio_articulo"></div>';
											if($tipo_separacion_lista=="linea")
												{$separacion_lista = '<hr class="separacion_hr_lista_articulos" />';}
											else
												{$separacion_lista = '&nbsp;';}
											$renglon_separacion_articulo = '<div  class="renglon_sep_lista">'.$separacion_lista.'</div>';
											$div_enlace_titulo = '';
											$arreglo_renglones[$posicion_titulo_lista] = 
											'<div class="titulo_articulo_lista"><div '.$div_enlace_titulo.'>'.$titulo.'</div></div>';
											if(($permitir_ver_temas_lista=="si") and ($usar_tema=="si"))
												{
													$con_temas = "select nombre from nazep_zmod_articulos_temas where clave_tema = '$clave_tema_art'";
													$res_temas = mysql_query($con_temas);
													$ren_temas = mysql_fetch_array($res_temas);
													$nombre_tema = $ren_temas["nombre"];
													$arreglo_renglones[$posicion_tema_lista] = '<div class="tema_articulo_lista">'.art_txt_tema_solo.$nombre_tema.'</div>';
												}
											$div_enlace_numero = '';
											if($permitir_ver_numero_lista=="si")
												{ $arreglo_renglones[$posicion_numero_lista] = '<div class="numero_articulo_lista"><div '.$div_enlace_numero.'>'.$nombre_tipo.art_txt_numero_corto.$numero_articulo.'</div></div>'; }
											if(($ver_lugar_lista=="no") and ($ver_fecha_lista=="no") and ($ver_hora_lista =="no"))
												{$temporal_fecha= ''; }
											else
												{
													$temporal_fecha = '<div class="fecha_articulo_lista">';
													if($ver_lugar_lista=="si")
														{ $temporal_fecha .= $lugar_articulo.'&nbsp;'; }
													if($ver_fecha_lista=="si")
														{ $temporal_fecha .= $fecha_articulo.'&nbsp;'; }
													if($ver_hora_lista =="si")
														{ $temporal_fecha .= $hora_creacion.'&nbsp;'.art_txt_ultim_actu3; }
													$temporal_fecha .= '</div>';
													$arreglo_renglones[$posicion_fecha_lugar_lista] = $temporal_fecha;
												}
											$arreglo_renglones[$posicion_resumen_lista] = '<div class="resumen_articulo_lista_enlace">'.$resumen.'</div>';
											if($permitir_ver_visitas_lista=="si")
												{ $arreglo_renglones[$posicion_visitas_lista] = '<div class="visitas_articulo_lista">'.art_txt_visitas.'&nbsp;'.$visitas.'</div>';}
											if($per_ver_fec_actualiza_lista=="si")
												{ $arreglo_renglones[$posicion_fe_act_lista] = '<div class="ultima_actualizacion_articulo_lista">'.art_txt_ultim_actu.': <br />'. $fecha_actualizacion.'&nbsp;'.art_txt_ultim_actu2.'&nbsp;'.$hora_actualizacion.'&nbsp;'.art_txt_ultim_actu3.'<br />'.art_txt_ultim_actu4.'&nbsp;'.$nombre_actualiza.'</div>';}
											for($a=1;$a<=7;$a++)
												{
													$renglon_temporal = $arreglo_renglones[$a];
													if($renglon_temporal!="")
														{ echo $renglon_temporal.$renglon_separacion; }
												}
											echo $renglon_separacion_articulo;
										}							
									if ($total_paginas > 1)
										{
											echo '<div id="paginacion_lista_titulo" class="titulo_paginacion_lista_articulos" >'.titulo_pag_list_articulos.'</div>';
											echo '<div id="paginacion_lista_numeros" class="celda_paginacion_articulos_lista" >';
												for ($i=1;$i<=$total_paginas;$i++)
													{
														if ($pagina == $i)
															echo '<span class="numero_pagina_seleccionado_articulo">&nbsp;'.$pagina .'&nbsp;</span>';
														else
															echo ' '.$i.' ';
													}
											echo '</div>';
										}
								echo '</div>';	
							}
						else
							{HtmlVista::ContenidoNoDisponible($ubicacion_tema);}
					}
				else
					{echo 'Se Requiere Configurar el M&oacute;dulo de Articulos Paginados';	}
			}
	}
?>