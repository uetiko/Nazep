<?php
/*
Sistema: Nazep
Nombre archivo: articulos_lista_vista.php
Función archivo: archivo para la visualización del módulo de artículos
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_articulos_lista extends conexion
	{	
		function clase_articulos_lista()
			{
				include('librerias/idiomas/'.FunGral::SaberIdioma().'/articulos_lista.php');
			}	
		function vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario)
			{}
		function vista_redireccion($sec, $ubicacion_tema, $nick_usuario)
			{}
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$con_configuracion = " select * from nazep_zmod_articulos_lista where clave_modulo = '$clave_modulo' and clave_seccion = '$sec'";
				$res_configuracion = mysql_query($con_configuracion);
				$ren_con = mysql_fetch_array($res_configuracion);
				$can_con = mysql_num_rows($res_configuracion);
				$clave_seccion_enlazar = $ren_con["clave_seccion_enlazar"];
				$ver_nombre = $ren_con["ver_nombre"];
				$nom_por_col1  = $ren_con["nom_por_col1"];
				$nom_por_col12 = $ren_con["nom_por_col12"];
				$enl_por_col1 = $ren_con["enl_por_col1"];
				$enl_por_col2 = $ren_con["enl_por_col2"];
				$tit_por_col1 = $ren_con["tit_por_col1"];
				$tit_por_col2 = $ren_con["tit_por_col2"];
				$num_por_col1 = $ren_con["num_por_col1"];
				$num_por_col2 = $ren_con["num_por_col2"];
				$lug_por_col1 = $ren_con["lug_por_col1"];
				$lug_por_col2 = $ren_con["lug_por_col2"];
				$resc_por_col1 = $ren_con["resc_por_col1"];
				$resc_por_col2 = $ren_con["resc_por_col2"];
				$resg_por_col1 = $ren_con["resg_por_col1"];
				$resg_por_col2 = $ren_con["resg_por_col2"];
				$nombre_articulos = $ren_con["nombre_articulos"];
				$orden_nombre = $ren_con["orden_nombre"];
				$lado_nombre = $ren_con["lado_nombre"];
				$enlace_nombre = $ren_con["enlace_nombre"];
				$cantidad_listar = $ren_con["cantidad_listar"];
				$ver_enlace_ver = $ren_con["ver_enlace_ver"];
				$lado_enalce_ver = $ren_con["lado_enalce_ver"];
				$arreglo_dato[0] = '';
				$arreglo_lado[0] = '';

				$ver_titulo = $ren_con["ver_titulo"];
				$orden_titulo = $ren_con["orden_titulo"];
				$lado_titulo = $ren_con["lado_titulo"];
				if($ver_titulo=='SI')
					{
						$arreglo_dato[$orden_titulo]= 'titulo';
						$arreglo_lado[$orden_titulo] = $lado_titulo;
					}
				$ver_numero = $ren_con["ver_numero"];
				$orden_numero = $ren_con["orden_numero"];
				$lado_numero = $ren_con["lado_numero"];
				if($ver_numero=='SI')
					{
						$arreglo_dato[$orden_numero]= "numero_articulo";
						$arreglo_lado[$orden_numero] = $lado_numero;
					}
				$ver_lugar = $ren_con["ver_lugar"];
				$ver_fecha = $ren_con["ver_fecha"];
				$orden_lugar_fecha = $ren_con["orden_lugar_fecha"];
				$lado_lugar_fecha = $ren_con["lado_lugar_fecha"];
				if($ver_fecha=='SI')
					{
						$arreglo_dato[$orden_lugar_fecha] .= "fecha";
						$arreglo_lado[$orden_lugar_fecha] = $lado_lugar_fecha;
					}
				if($ver_lugar=='SI')
					{
						$arreglo_dato[$orden_lugar_fecha] .= "lugar";
						$arreglo_lado[$orden_lugar_fecha] = $lado_lugar_fecha;
					}
				$ver_resumen_chico = $ren_con["ver_resumen_chico"];
				$orden_resumen_chico = $ren_con["orden_resumen_chico"];
				if($ver_resumen_chico=='SI')
					{
						$arreglo_dato[$orden_resumen_chico] = "resumen_chico";
					}
				$ver_resumen_grande = $ren_con["ver_resumen_grande"];
				$orden_resumen_graden = $ren_con["orden_resumen_graden"];
				if($ver_resumen_grande=='SI')
					{
						$arreglo_dato[$orden_resumen_graden] = "resumen_grande";
					}
				$cantidad_arreglo = count($arreglo_dato);
				$con_tipo = "select  permitir_caducar, clave_tipo, formato_fecha_lista from nazep_zmod_articulos_tipos where clave_seccion = '$clave_seccion_enlazar'";
				$res_tipo = mysql_query($con_tipo);
				$ren_tipo = mysql_fetch_array($res_tipo);
				$permitir_caducar = $ren_tipo["permitir_caducar"];
				$clave_tipo = $ren_tipo["clave_tipo"];
				$formato_fecha_lista = $ren_tipo["formato_fecha_lista"];
				$cadena_adicional = ' ';
				if($permitir_caducar =='si')
					{
						$hoy = date('Y-m-d');
						$cadena_adicional= " and fecha_inicio <= '$hoy' and fecha_fin >= '$hoy' ";
					}
				$con_part_art = "select clave_articulo, titulo, resumen_chico, 
				resumen_grande, numero_articulo, titulo, lugar_articulo, fecha_articulo
				from nazep_zmod_articulos 
				where clave_tipo = '$clave_tipo' and situacion = 'activo'
				".$cadena_adicional."
				order by fecha_articulo desc, numero_articulo desc
				limit 0, $cantidad_listar";	
				
				$res_part_art = mysql_query($con_part_art);
				echo '<div id="centro_contenido_list_art" class="centro_contenido_gral">';
					if($can_con != '')
						{
							$renglon_separacion = '<div class="separacion_elementos"> </div>';
							if($ver_nombre=="SI")
								{
									$porcentaje_medio_nom = 100-(($nom_por_col1+$nom_por_col2)*2);
									$temporal_lado = $arreglo_lado[$a];
									$esp1='';
									if($resc_por_col1>0){$esp1='&nbsp;';}
									$esp2='';
									if($resc_por_col2>0){$esp2='&nbsp;';}
									echo '<div style=" width:'.$nom_por_col1.'%; float:left;">'.$esp1.'</div>';
									echo '<div style=" width:'.$nom_por_col2.'%; float:left;" class="nombre_art_listado_lado" >'.$esp2.'</div>';
									echo '<div style=" width:'.$porcentaje_medio_nom.'%; float:left;" class="nombre_art_listado" >';
										if($enlace_nombre=="SI")
											{ echo '<a href="index.php?sec='.$clave_seccion_enlazar.'" title="'.$nombre_articulos.'" >'.$nombre_articulos.'</a>'; }
										else
											{ echo $nombre_articulos; }
									echo '</div>';
									echo '<div style=" width:'.$nom_por_col2.'%; float:left;" class="nombre_art_listado_lado" >'.$esp2.'</div>';
									echo '<div style=" width:'.$nom_por_col1.'%; float:left;">'.$esp1.'</div>';
									echo '<div class="separacion_titulos"></div>';
								}						
							while($ren_part_art = mysql_fetch_array($res_part_art))
								{
									for($a=1;$a<=$cantidad_arreglo;$a++)
										{
											$temporal = $arreglo_dato[$a];
											if($temporal == "resumen_chico")
												{
													$porcentaje_medio_resc = 100-(($resc_por_col1+$resc_por_col2)*2);
													$resumen_chico = stripslashes($ren_part_art["resumen_chico"]);
													$esp1='';
													if($resc_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($resc_por_col2>0){$esp2='&nbsp;';}
													echo $renglon_separacion;
													echo '<div style=" width:'.$resc_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$resc_por_col2.'%; float:left;" class="res_chi_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$porcentaje_medio_resc.'%; float:left;" class="res_chi_art_listado" >';
														echo $resumen_chico;
													echo '</div>';
													echo '<div style=" width:'.$resc_por_col2.'%; float:left;" class="res_chi_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$resc_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo $renglon_separacion;
												}
											elseif($temporal == "resumen_grande")
												{
													$porcentaje_medio_resg = 100-(($resg_por_col1+$resg_por_col2)*2);
													$resumen_grande = stripslashes($ren_part_art["resumen_grande"]);
													$esp1='';
													if($resg_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($resg_por_col2>0){$esp2='&nbsp;';}
													echo $renglon_separacion;	
													echo '<div style=" width:'.$resg_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$resg_por_col2.'%; float:left;" class="res_gran_art_listado_lado" >'.$esp2.'</div>';		
													echo '<div style=" width:'.$porcentaje_medio_resg.'%; float:left; " class="res_gran_art_listado" >';
														echo $resumen_grande;
													echo '</div>';
													echo '<div style=" width:'.$resg_por_col1.'%; float:left;" class="res_gran_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$resg_por_col2.'%; float:left;">'.$esp1.'</div>';
													echo $renglon_separacion;
												}
											elseif((ereg("fecha",$temporal))or(ereg("lugar",$temporal)))
												{
													$porcentaje_medio_lug = 100-($lug_por_col1+$lug_por_col2);
													$temporal_lado = $arreglo_lado[$a]; 
													$lugar_articulo = $ren_part_art["lugar_articulo"];
													$fecha_articulo = $ren_part_art["fecha_articulo"];
													$fecha_articulo = FunGral::$formato_fecha_lista($fecha_articulo);
													
													$esp1='';
													if($lug_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($lug_por_col2>0){$esp2='&nbsp;';}
													
													echo $renglon_separacion;
													echo '<div style=" width:'.$lug_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$lug_por_col2.'%; float:left;" class="lug_fech_art_listado_lado" >'.$esp2.'</div>';		
													echo '<div style=" width:'.$porcentaje_medio_lug.'%; float:left; text-align:'.$temporal_lado.';" class="lug_fech_art_listado" >';
 														if(ereg("lugar",$temporal))
															{ echo $lugar_articulo.", "; }
														if(ereg("fecha",$temporal))
															{ echo $fecha_articulo; }
													echo '</div>';
													echo '<div style=" width:'.$lug_por_col2.'%; float:left;" class="lug_fech_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$lug_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo $renglon_separacion;
												}
											elseif($temporal == "titulo")
												{
													$porcentaje_medio_tit = 100-(($tit_por_col1+$tit_por_col2)*2);
													$titulo = stripslashes($ren_part_art["titulo"]);
													$temporal_lado = $arreglo_lado[$a];
													$esp1='';
													if($lug_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($lug_por_col2>0){$esp2='&nbsp;';}
													
													echo $renglon_separacion;
													echo '<div style=" width:'.$tit_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$tit_por_col2.'%; float:left;" class="titulo_art_listado_lado" >'.$esp2.'</div>';		
													echo '<div style=" width:'.$porcentaje_medio_tit.'%; float:left; text-align:'.$temporal_lado.';" class="titulo_art_listado" >';
														echo $titulo;
													echo '</div>';
													echo '<div style=" width:'.$tit_por_col2.'%; float:left;" class="titulo_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$tit_por_col1.'%; float:left;">'.$esp1.'</div>';		
													echo $renglon_separacion;
												}
											elseif($temporal == "numero_articulo")
												{
													$porcentaje_medio_num = 100-(($num_por_col1+$num_por_col2)*2);
													
													$numero = $ren_part_art["numero_articulo"];
													$temporal_lado = $arreglo_lado[$a];
													$esp1='';
													if($lug_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($lug_por_col2>0){$esp2='&nbsp;';}
													echo $renglon_separacion;
													$porcentaje_medio_num = 100-($num_por_col1+$num_por_col2);
													echo '<div style=" width:'.$num_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$num_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';		
													echo '<div style=" width:'.$porcentaje_medio_num.'%; float:left; text-align:'.$temporal_lado.';" class="num_art_listado" >';
														echo lap_txt_numero.$numero;
													echo '</div>';
													echo '<div style=" width:'.$num_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$num_por_col1.'%; float:left;">'.$esp1.'</div>';		
													echo $renglon_separacion;
												}
										}
									if($ver_enlace_ver=="SI")
										{
											$porcentaje_medio_enl = 100-(($enl_por_col1+$enl_por_col2)*2);
											$clave_articulo = $ren_part_art["clave_articulo"];
											$esp1='';
											if($lug_por_col1>0){$esp1='&nbsp;';}
											$esp2='';
											if($lug_por_col2>0){$esp2='&nbsp;';}
											
											echo $renglon_separacion;	
											$porcentaje_medio_enl = 100-($enl_por_col1+$enl_por_col2);
											echo '<div style=" width:'.$enl_por_col1.'%; float:left;">'.$esp1.'</div>';
											echo '<div style=" width:'.$enl_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';		
											echo '<div style=" width:'.$porcentaje_medio_enl.'%; float:left; text-align:'.$lado_enalce_ver.';" class="ler_mas_art_listado" >';
												echo '<a href="index.php?sec='.$clave_seccion_enlazar.'&amp;clave_articulo='.$clave_articulo.'" >';
												echo lap_txt_leer_mas;
												echo '</a>';
											echo '</div>';
											echo '<div style=" width:'.$enl_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';
											echo '<div style=" width:'.$enl_por_col1.'%; float:left;">'.$esp1.'</div>';		
											echo $renglon_separacion;
										}
									echo '<div class="separacion_registros"> </div>';
								}
							
						}
					else
						{
							echo '<div id="div_configuracion_lista" class="configuracion_lista">'.lap_txt_nec_configurar.'</div>';		
						}
				echo '</div>';
			}	
		function vista_print($sec, $ubicacion_tema, $nick_usuario,$clave_modulo)
			{
				$con_configuracion = " select * from nazep_zmod_articulos_lista where clave_modulo = '$clave_modulo' and clave_seccion = '$sec'";
				$res_configuracion = mysql_query($con_configuracion);
				$ren_con = mysql_fetch_array($res_configuracion);
				$can_con = mysql_num_rows($res_configuracion);
				$clave_seccion_enlazar = $ren_con["clave_seccion_enlazar"];
				$ver_nombre = $ren_con["ver_nombre"];
				$nom_por_col1  = $ren_con["nom_por_col1"];
				$nom_por_col12 = $ren_con["nom_por_col12"];
				$enl_por_col1 = $ren_con["enl_por_col1"];
				$enl_por_col2 = $ren_con["enl_por_col2"];
				$tit_por_col1 = $ren_con["tit_por_col1"];
				$tit_por_col2 = $ren_con["tit_por_col2"];
				$num_por_col1 = $ren_con["num_por_col1"];
				$num_por_col2 = $ren_con["num_por_col2"];
				$lug_por_col1 = $ren_con["lug_por_col1"];
				$lug_por_col2 = $ren_con["lug_por_col2"];
				$resc_por_col1 = $ren_con["resc_por_col1"];
				$resc_por_col2 = $ren_con["resc_por_col2"];
				$resg_por_col1 = $ren_con["resg_por_col1"];
				$resg_por_col2 = $ren_con["resg_por_col2"];
				$nombre_articulos = $ren_con["nombre_articulos"];
				$orden_nombre = $ren_con["orden_nombre"];
				$lado_nombre = $ren_con["lado_nombre"];
				$enlace_nombre = $ren_con["enlace_nombre"];
				$cantidad_listar = $ren_con["cantidad_listar"];
				$ver_enlace_ver = $ren_con["ver_enlace_ver"];
				$lado_enalce_ver = $ren_con["lado_enalce_ver"];
				
				$arreglo_dato[0] = "";
				$arreglo_lado[0] = "";
				
				$ver_titulo = $ren_con["ver_titulo"];
				$orden_titulo = $ren_con["orden_titulo"];
				$lado_titulo = $ren_con["lado_titulo"];
				if($ver_titulo=="SI")
					{
						$arreglo_dato[$orden_titulo]= "titulo";
						$arreglo_lado[$orden_titulo] = $lado_titulo;
					}
				$ver_numero = $ren_con["ver_numero"];
				$orden_numero = $ren_con["orden_numero"];
				$lado_numero = $ren_con["lado_numero"];
				if($ver_numero=="SI")
					{
						$arreglo_dato[$orden_numero]= "numero_articulo";
						$arreglo_lado[$orden_numero] = $lado_numero;
					}
				$ver_lugar = $ren_con["ver_lugar"];
				$ver_fecha = $ren_con["ver_fecha"];
				$orden_lugar_fecha = $ren_con["orden_lugar_fecha"];
				$lado_lugar_fecha = $ren_con["lado_lugar_fecha"];
				if($ver_fecha=="SI")
					{
						$arreglo_dato[$orden_lugar_fecha] .= "fecha";
						$arreglo_lado[$orden_lugar_fecha] = $lado_lugar_fecha;
					}
				if($ver_lugar=="SI")
					{
						$arreglo_dato[$orden_lugar_fecha] .= "lugar";
						$arreglo_lado[$orden_lugar_fecha] = $lado_lugar_fecha;
					}
				$ver_resumen_chico = $ren_con["ver_resumen_chico"];
				$orden_resumen_chico = $ren_con["orden_resumen_chico"];
				if($ver_resumen_chico=="SI")
					{
						$arreglo_dato[$orden_resumen_chico] = "resumen_chico";
					}
				$ver_resumen_grande = $ren_con["ver_resumen_grande"];
				$orden_resumen_graden = $ren_con["orden_resumen_graden"];
				
				if($ver_resumen_grande=="SI")
					{
						$arreglo_dato[$orden_resumen_graden] = "resumen_grande";
					}
				$cantidad_arreglo = count($arreglo_dato);
				$con_tipo = "select  permitir_caducar, clave_tipo, formato_fecha_lista
				from nazep_zmod_articulos_tipos
				where clave_seccion = '$clave_seccion_enlazar'";
				$res_tipo = mysql_query($con_tipo);
				$ren_tipo = mysql_fetch_array($res_tipo);
				$permitir_caducar = $ren_tipo["permitir_caducar"];
				$clave_tipo = $ren_tipo["clave_tipo"];
				$formato_fecha_lista = $ren_tipo["formato_fecha_lista"];
				$cadena_adicional = " ";
				if($permitir_caducar =="si")
					{
						$hoy = date('Y-m-d');
						$cadena_adicional= " and fecha_inicio <= '$hoy' and fecha_fin >= '$hoy' ";
					}
				$con_part_art = "select clave_articulo, titulo, resumen_chico, resumen_grande, numero_articulo, titulo, lugar_articulo, fecha_articulo
				from nazep_zmod_articulos 
				where clave_tipo = '$clave_tipo' and situacion = 'activo'
				".$cadena_adicional."
				order by fecha_articulo desc, numero_articulo desc
				limit 0, $cantidad_listar";
				$res_part_art = mysql_query($con_part_art);
				echo '<div id="centro_contenido_list_art_print" class="centro_contenido_gral_print">';
					if($can_con != "")
						{
							$renglon_separacion = '<div class="separacion_elementos"> </div>';
							if($ver_nombre=="SI")
								{
									$porcentaje_medio_nom = 100-(($nom_por_col1+$nom_por_col2)*2);
									$temporal_lado = $arreglo_lado[$a];
									$esp1='';
									if($resc_por_col1>0){$esp1='&nbsp;';}
									$esp2='';
									if($resc_por_col2>0){$esp2='&nbsp;';}
									echo '<div style=" width:'.$nom_por_col1.'%; float:left;">'.$esp1.'</div>';
									echo '<div style=" width:'.$nom_por_col2.'%; float:left;" class="nombre_art_listado_lado" >'.$esp2.'</div>';
									echo '<div style=" width:'.$porcentaje_medio_nom.'%; float:left;" class="nombre_art_listado" >';
										echo $nombre_articulos;
									echo '</div>';
									echo '<div style=" width:'.$nom_por_col2.'%; float:left;" class="nombre_art_listado_lado" >'.$esp2.'</div>';
									echo '<div style=" width:'.$nom_por_col1.'%; float:left;">'.$esp1.'</div>';
									echo '<div class="separacion_titulos"></div>';
								}
							while($ren_part_art = mysql_fetch_array($res_part_art))
								{
									for($a=1;$a<=$cantidad_arreglo;$a++)
										{
											$temporal = $arreglo_dato[$a];
											if($temporal == "resumen_chico")
												{
													$porcentaje_medio_resc = 100-(($resc_por_col1+$resc_por_col2)*2);
													$resumen_chico = stripslashes($ren_part_art["resumen_chico"]);	
													$esp1='';
													if($resc_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($resc_por_col2>0){$esp2='&nbsp;';}
													echo $renglon_separacion;
													echo '<div style=" width:'.$resc_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$resc_por_col2.'%; float:left;" class="res_chi_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$porcentaje_medio_resc.'%; float:left;" class="res_chi_art_listado" >';
														echo $resumen_chico;
													echo '</div>';
													echo '<div style=" width:'.$resc_por_col2.'%; float:left;" class="res_chi_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$resc_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo $renglon_separacion;
												}
											elseif($temporal == "resumen_grande")
												{
													$porcentaje_medio_resg = 100-(($resg_por_col1+$resg_por_col2)*2);
													$resumen_grande = stripslashes($ren_part_art["resumen_grande"]);
													$esp1='';
													if($resg_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($resg_por_col2>0){$esp2='&nbsp;';}
													echo $renglon_separacion;	
													echo '<div style=" width:'.$resg_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$resg_por_col2.'%; float:left;" class="res_gran_art_listado_lado" >'.$esp2.'</div>';		
													echo '<div style=" width:'.$porcentaje_medio_resg.'%; float:left; " class="res_gran_art_listado" >';
														echo $resumen_grande;
													echo '</div>';
													echo '<div style=" width:'.$resg_por_col1.'%; float:left;" class="res_gran_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$resg_por_col2.'%; float:left;">'.$esp1.'</div>';
													echo $renglon_separacion;
												}
											elseif((ereg("fecha",$temporal))or(ereg("lugar",$temporal)))
												{
													$porcentaje_medio_lug = 100-($lug_por_col1+$lug_por_col2);
													$temporal_lado = $arreglo_lado[$a]; 
													$lugar_articulo = $ren_part_art["lugar_articulo"];
													$fecha_articulo = $ren_part_art["fecha_articulo"];
													$fecha_articulo = $this->$formato_fecha_lista($fecha_articulo);
													
													$esp1='';
													if($lug_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($lug_por_col2>0){$esp2='&nbsp;';}
													
													echo $renglon_separacion;
													echo '<div style=" width:'.$lug_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$lug_por_col2.'%; float:left;" class="lug_fech_art_listado_lado" >'.$esp2.'</div>';		
													echo '<div style=" width:'.$porcentaje_medio_lug.'%; float:left; text-align:'.$temporal_lado.';" class="lug_fech_art_listado" >';
														if(ereg("lugar",$temporal))
															{ echo $lugar_articulo.", "; }
														if(ereg("fecha",$temporal))
															{ echo $fecha_articulo; }
													echo '</div>';
													echo '<div style=" width:'.$lug_por_col2.'%; float:left;" class="lug_fech_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$lug_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo $renglon_separacion;
												}
											elseif($temporal == "titulo")
												{
													$porcentaje_medio_tit = 100-(($tit_por_col1+$tit_por_col2)*2);
													$titulo = stripslashes($ren_part_art["titulo"]);
													$temporal_lado = $arreglo_lado[$a];
													$esp1='';
													if($lug_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($lug_por_col2>0){$esp2='&nbsp;';}
													
													echo $renglon_separacion;
													echo '<div style=" width:'.$tit_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$tit_por_col2.'%; float:left;" class="titulo_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$porcentaje_medio_tit.'%; float:left; text-align:'.$temporal_lado.';" class="titulo_art_listado" >';
														echo $titulo;
													echo '</div>';
													echo '<div style=" width:'.$tit_por_col2.'%; float:left;" class="titulo_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$tit_por_col1.'%; float:left;">'.$esp1.'</div>';		
													echo $renglon_separacion;
												}
											elseif($temporal == "numero_articulo")
												{
													$porcentaje_medio_num = 100-(($num_por_col1+$num_por_col2)*2);
													
													$numero = $ren_part_art["numero_articulo"];
													$temporal_lado = $arreglo_lado[$a];
													$esp1='';
													if($lug_por_col1>0){$esp1='&nbsp;';}
													$esp2='';
													if($lug_por_col2>0){$esp2='&nbsp;';}
													echo $renglon_separacion;
													$porcentaje_medio_num = 100-($num_por_col1+$num_por_col2);
													echo '<div style=" width:'.$num_por_col1.'%; float:left;">'.$esp1.'</div>';
													echo '<div style=" width:'.$num_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$porcentaje_medio_num.'%; float:left; text-align:'.$temporal_lado.';" class="num_art_listado" >';
														echo lap_txt_numero.$numero;
													echo '</div>';
													echo '<div style=" width:'.$num_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';
													echo '<div style=" width:'.$num_por_col1.'%; float:left;">'.$esp1.'</div>';		
													echo $renglon_separacion;
												}
										}
									if($ver_enlace_ver=="SI")
										{
											$porcentaje_medio_enl = 100-(($enl_por_col1+$enl_por_col2)*2);
											$clave_articulo = $ren_part_art["clave_articulo"];
											$esp1='';
											if($lug_por_col1>0){$esp1='&nbsp;';}
											$esp2='';
											if($lug_por_col2>0){$esp2='&nbsp;';}
											
											echo $renglon_separacion;	
											$porcentaje_medio_enl = 100-($enl_por_col1+$enl_por_col2);
											echo '<div style=" width:'.$enl_por_col1.'%; float:left;">'.$esp1.'</div>';
											echo '<div style=" width:'.$enl_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';
											echo '<div style=" width:'.$porcentaje_medio_enl.'%; float:left; text-align:'.$lado_enalce_ver.';" class="ler_mas_art_listado" >';
												echo lap_txt_leer_mas;
											echo '</div>';
											echo '<div style=" width:'.$enl_por_col2.'%; float:left;" class="num_art_listado_lado" >'.$esp2.'</div>';
											echo '<div style=" width:'.$enl_por_col1.'%; float:left;">'.$esp1.'</div>';		
											echo $renglon_separacion;
										}
									echo '<div class="separacion_registros"> </div>';
								}
						}
					else
						{
							echo '<div id="div_configuracion_lista" class="configuracion_lista">'.lap_txt_nec_configurar.'</div>';
						}
				echo '</div>';
			}
	}
?>