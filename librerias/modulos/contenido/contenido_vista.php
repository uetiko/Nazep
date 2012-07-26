<?php
/*
Sistema: Nazep
Nombre archivo: contenido_vista.php
Función archivo: archivo para controlar la vista final del módulo contenido html
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_contenido extends conexion
	{
		function __construct()
			{
				include('librerias/idiomas/'.FunGral::SaberIdioma().'/contenido.php');
			} 
		function vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{}
		function vista_buscador_mini($frase_buscar)
			{
				$frase_buscar = strip_tags($frase_buscar);
				$arreglo_palabras = explode(" ", $frase_buscar);
				$cantidad_palabras = count($arreglo_palabras);	
				$hoy = date('Y-m-d');
				$cadena = '';
				for($a=0; $a<$cantidad_palabras; $a++)
					{
						$tem = $arreglo_palabras[$a];
						if($tem!="")
							{ $cadena .= " cd.texto like '%$tem%' "; }
						$contador = $a+1;
						$proxima = $arreglo_palabras[$contador];
						if(($contador<$cantidad_palabras) && ($proxima!="") )
							{ $cadena .= " or "; }
					}
				$consulta_buscar = "select s.clave_seccion, s.titulo
				from nazep_secciones s, nazep_zmod_contenido c, nazep_zmod_contenido_detalle cd
				where s.clave_seccion = c.clave_seccion and c.clave_contenido = cd.clave_contenido
				and c.situacion = 'activo' and c.fecha_incio <= '$hoy' and c.fecha_fin >= '$hoy' and ($cadena)";
				$res_con = mysql_query($consulta_buscar);
				$can_res = mysql_num_rows($res_con);
				$cantidad_mostrar = 10;
				if($_POST["pag"]=='')
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
				$consulta_buscar_secc = "select s.clave_seccion, s.titulo, cd.pagina
				from nazep_secciones s, nazep_zmod_contenido c, nazep_zmod_contenido_detalle cd
				where s.clave_seccion = c.clave_seccion and c.clave_contenido = cd.clave_contenido
				and c.situacion = 'activo' and c.fecha_incio <= '$hoy' and c.fecha_fin >= '$hoy'
				and ($cadena)
				order by c.fecha_actualizacion
				limit $ini, $cantidad_mostrar";	
				$res_con_sec = mysql_query($consulta_buscar_secc);
				echo '<div id="centro_contenido" class="centro_contenido_gral">';
					echo '<div id="div_titulo_res_ava" class="titulo_res_ava" >';
						echo contenido_txt_titu_buscador.' (<strong>'.$can_res.'</strong>) '.contenido_txt_titu_buscador2;
						echo '<br />'.contenido_txt_frase.': <strong>'.$frase_buscar.'</strong>';
						echo '<br /><br />'.contenido_txt_men_busca;
					echo '</div>';
					while($ren_con = mysql_fetch_array($res_con_sec))
						{
							$clave_seccion = $ren_con["clave_seccion"];
							$titulo = $ren_con["titulo"];
							$pagina =  $ren_con["pagina"];
							echo '<div id="res_bus_con_'.$clave_seccion.'" class="res_bus_con" >';
								echo contenido_txt_bus_sec.'
								<strong>'.$titulo.'</strong><br />
								'.contenido_txt_bus_pag.'&nbsp;<strong>'.$pagina.'</strong><br />';
								echo '<a href="index.php?sec='.$clave_seccion.'&amp;pag='.$pagina.'">'.contenido_txt_bus_ir.'</a><hr />';
							echo '</div>';
						}
					echo '<div id="div_pag_res_con" class="pag_res_con" >';
						if($total_paginas >1)
							{
								for($a=1;$a<=$total_paginas;$a++)
									{
										$clave_seccion_a = $_GET["sec"];
										echo '<form name="paginas_'.$a.'" action="index.php?sec='.$clave_seccion_a.'" method="post" >';
											echo '<input type="hidden" name = "pag" value = "'.$a.'"  ><br />';
											echo '<input type="hidden" name="buscador" value = "mini" />';
											echo '<input type="hidden" name="resultados" value = "si" />';
											echo '<input type="hidden" name = "frase" value = "'.$frase.'" />';
										echo '</form>';
									}
								for($b=1;$b<=$total_paginas;$b++)
									{
										if($pag==$b)
											{echo '<strong><u>'.$pag.'</u></strong>';}
										else
											{echo '<a href="javascript:document.paginas_'.$b.'.submit()">'.$b.'</a>';}
									}
							}
					echo '</div>';
				
				echo '</div>';
			}
		function vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario)
			{
				if(@$_POST["resultados"]== "" or (@$_POST["resultados"]=="si" and @$_POST["frase"] == "")  )
					{
						echo '<div id="centro_contenido" class="centro_contenido_gral">';
							echo '<div id="div_titulo_buscador_contenido" class="titulo_buscador_contenido">'.contenido_txt_titu_buscador1.'</div>';
							echo '<div id="div_formulario_buscador_contenido" class="formulario_buscador_contenido">';
								echo '<form name="buscador" action="index.php?sec='.$sec.'" method="post" >';
									echo contenido_txt_bus_texto.'&nbsp;';
									echo '<input type = "text" name = "frase" size = "40" /> &nbsp;';
									echo '<select name = "metodo">';
										echo '<option value = "exacto" >'.contenido_txt_fra_exa.'</option>';	
										echo '<option value = "palabra" >'.contenido_txt_palabra.'</option>';
									echo '</select>';
									echo '<input type="hidden" name = "resultados" value ="si" />';
									echo '<input type="hidden" name = "archivo" value = "contenido" />';
									echo '<input type="submit" name="btn_buscar" value="'.contenido_btn_buscar.'" />';
								echo '</form>';	
							echo '</div>';
						echo '</div>';
					}
				elseif(isset($_POST["resultados"]) && $_POST["resultados"]=="si")
					{
						$hoy = date('Y-m-d');
						$frase = $_POST["frase"];
						$frase = strip_tags($frase);
						$metodo = $_POST["metodo"];
						if($metodo=="exacto")
							{ $cadena = " cd.texto like '%$frase%' "; }
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
						$consulta_buscar = "select s.clave_seccion
						from nazep_secciones s, nazep_zmod_contenido c, nazep_zmod_contenido_detalle cd
						where s.clave_seccion = c.clave_seccion and c.clave_contenido = cd.clave_contenido
						and c.situacion = 'activo' and c.fecha_incio <= '$hoy' and c.fecha_fin >= '$hoy'
						and ($cadena)";
						$res_con = mysql_query($consulta_buscar);
						$can_res = mysql_num_rows($res_con);
						$cantidad_mostrar = 10;
						if($_POST["pag"]=='')
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
						$consulta_buscar_secc = "select s.clave_seccion, s.titulo, cd.pagina
						from nazep_secciones s, nazep_zmod_contenido c, nazep_zmod_contenido_detalle cd
						where s.clave_seccion = c.clave_seccion and c.clave_contenido = cd.clave_contenido
						and c.situacion = 'activo' and c.fecha_incio <= '$hoy' and c.fecha_fin >= '$hoy'
						and ($cadena)
						order by c.fecha_actualizacion
						limit $ini, $cantidad_mostrar";
						$res_con_sec = mysql_query($consulta_buscar_secc);	
						
						echo '<div id="centro_contenido" class="centro_contenido_gral">';
							echo '<div id="div_titulo_res_ava" class="titulo_res_ava" >'; 
								echo contenido_txt_titu_buscador.' (<strong>'.$can_res.'</strong>) '.contenido_txt_titu_buscador2;
								echo '<br />'.contenido_txt_frase.': <strong>'.$frase.'</strong>';
							echo '</div>';
							while($ren_con = mysql_fetch_array($res_con_sec))
								{
									$clave_seccion = $ren_con["clave_seccion"];
									$titulo = $ren_con["titulo"];
									$pagina =  $ren_con["pagina"];
									echo '<div id="res_bus_con_'.$clave_seccion.'" class="res_bus_con" >';
										echo contenido_txt_bus_sec.'
										<strong>'.$titulo.'</strong><br />
										'.contenido_txt_bus_pag.'&nbsp;<strong>'.$pagina.'</strong><br />';
										echo '<a href="index.php?sec='.$clave_seccion.'&amp;pag='.$pagina.'">'.contenido_txt_bus_ir.'</a><hr />';
									echo '</div>';
								}
							echo '<div id="div_pag_res_con" class="pag_res_con" >';
								if($total_paginas >1)
									{
										for($a=1;$a<=$total_paginas;$a++)
											{
												$clave_buscador = $_GET["sec"];
												echo '<form name="buscador_mini_'.$a.'" action="index.php?sec='.$clave_buscador.'" method="post" >';
													echo '<input type="hidden" name="resultados" value = "si" />';
													echo '<input type="hidden" name = "frase" value = "'.$frase.'" />';
													echo '<input type="hidden" name = "pag" value = "'.$a.'" />';
													echo '<input type="hidden" name = "archivo" value = "contenido" />';
													echo '<input type="hidden" name = "metodo" value = "'.$metodo.'" />';
												echo '</form>';
											}
										for($b=1;$b<=$total_paginas;$b++)
											{
												if($pag==$b)
													{ echo '<strong><u>'.$pag.'</u></strong>'; }
												else
													{ echo ' <a href="javascript:document.buscador_mini_'.$b.'.submit()">'.$b.'</a> '; }
											}
									}
							echo '</div>';
						echo '</div>';
					}
			}
		function vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$fecha_hoy = date('Y-m-d');
				$con_con_gral = "select clave_contenido from nazep_zmod_contenido where situacion = 'activo' and clave_seccion = '$sec'
				and ( case usar_caducidad  when 'SI' then fecha_incio <= '$fecha_hoy' and fecha_fin >= '$fecha_hoy' else 1 end) and clave_modulo = '$clave_modulo'";
				$res_gral = mysql_query($con_con_gral);
				$can = mysql_num_rows($res_gral);
				if($can!="0")
					{
						$pag_con = $_GET["pagina"];
						$pasa_contenido = true;
						if($pag_con == '')
							{
								$pasa_contenido = true;
								$pag_con = 1;								
							}
						else
							{
								if(!is_numeric($pag_con))
									{
										$pasa_contenido = false;
										$pag_con = 1;										
									}
								else
									{ $pasa_contenido = true; }
							}
						$consulta_contenido_texto = "select cd.texto, c.nombre_actualizacion, c.fecha_actualizacion, c.hora_actualizacion, c.ver_actualizacion
						from nazep_zmod_contenido c, nazep_zmod_contenido_detalle cd where cd.situacion = 'activo' and c.situacion = 'activo' and clave_seccion= '$sec' and
						c.clave_contenido = cd.clave_contenido and
						c.clave_modulo = '$clave_modulo' and ( case c.usar_caducidad  when 'SI' then c.fecha_incio <= '$fecha_hoy' and c.fecha_fin >= '$fecha_hoy' else 1 end)
						and cd.pagina = '$pag_con'";
						$res_con_texto = mysql_query($consulta_contenido_texto);	
						$ren_texto = mysql_fetch_array($res_con_texto);							
						$can_pag = mysql_num_rows($res_con_texto);
						if($can_pag>0 and $pasa_contenido)
							{
								$texto = stripslashes($ren_texto["texto"]);
								$ver_actualizacion = $ren_texto["ver_actualizacion"];
								$nombre_actualizacion = $ren_texto["nombre_actualizacion"];
								$fecha_actualizacion = $ren_texto["fecha_actualizacion"];
								$fecha_actualizacion = FunGral::fechaNormal($fecha_actualizacion);
								$hora_actualizacion =  $ren_texto["hora_actualizacion"];
								echo '<div class="div_contenido_principal_print" >'.$texto.'</div>';
								if($ver_actualizacion == 'SI')
									{
										echo '<div class="renglon_vacio_contenido"></div>';
										echo '<div class="texto_actualizacion">';
											echo contenido_txt_ultim_actu.': <br />'.
											$fecha_actualizacion.'&nbsp;'.contenido_txt_ultim_actu2.'&nbsp;'.
											$hora_actualizacion.'&nbsp;'.contenido_txt_ultim_actu3.'<br />'.contenido_txt_ultim_actu4.'&nbsp;'.$nombre_actualizacion;
										echo '</div>';
									}
							}
						else
							{HtmlVista::ContenidoNoDisponible($ubicacion_tema);}
					}
				else
					{HtmlVista::ContenidoNoDisponible($ubicacion_tema);}
			}
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$fecha_hoy = date('Y-m-d');
				$con_con_gral = "select clave_contenido from nazep_zmod_contenido where situacion = 'activo' and clave_seccion = '$sec' 
				and ( case usar_caducidad  when 'SI' then fecha_incio <= '$fecha_hoy' and fecha_fin >= '$fecha_hoy' else 1 end) and clave_modulo = '$clave_modulo'";
				$res_gral = mysql_query($con_con_gral);
				$can = mysql_num_rows($res_gral);
				if($can!=0)
					{
						$pag_con = (isset($_GET["pagina"])) ?$_GET["pagina"] :'';
						$pasa_contenido = true;
						if($pag_con == '')
							{
								$pasa_contenido = true;
								$pag_con = 1;								
							}
						else
							{
								if(!is_numeric($pag_con))
									{
										$pasa_contenido = false;
										$pag_con = 1;										
									}
								else
									{
										$pasa_contenido = true;
									}
							}
						$consulta_contenido_texto = " select cd.texto, c.fecha_actualizacion, c.hora_actualizacion, c.ver_actualizacion, nombre_actualizacion
						from nazep_zmod_contenido c, nazep_zmod_contenido_detalle cd
						where cd.situacion = 'activo' and c.situacion = 'activo' and clave_seccion= '$sec' and
						c.clave_modulo = '$clave_modulo' and c.clave_contenido = cd.clave_contenido 
						and ( case c.usar_caducidad  when 'SI' then c.fecha_incio <= '$fecha_hoy' and c.fecha_fin >= '$fecha_hoy' else 1 end)
						and cd.pagina = '$pag_con'";
						
						$res_con_texto = mysql_query($consulta_contenido_texto);	
						$ren_texto = mysql_fetch_array($res_con_texto);
						$can_pag = mysql_num_rows($res_con_texto);
						if($can_pag>0 and $pasa_contenido)
							{
								$texto = stripslashes($ren_texto["texto"]);
								$fecha_actualizacion = $ren_texto["fecha_actualizacion"];
								$fecha_actualizacion = FunGral::fechaNormal($fecha_actualizacion);
								$hora_actualizacion =  $ren_texto["hora_actualizacion"];	
								$ver_actualizacion =  $ren_texto["ver_actualizacion"];
								$nombre_actualizacion =  $ren_texto["nombre_actualizacion"];
								echo '<div id="centro_contenido" class="centro_contenido_gral">';
									echo '<div class="div_contenido_principal">'.$texto.'</div>';
									$consulta_contenido_pag = "select cd.pagina from nazep_zmod_contenido c, nazep_zmod_contenido_detalle cd
									where cd.situacion = 'activo' and c.situacion = 'activo' and clave_seccion= '$sec' and
									c.clave_modulo = '$clave_modulo' and 
									c.clave_contenido = cd.clave_contenido 
									and ( case c.usar_caducidad  when 'SI' then c.fecha_incio <= '$fecha_hoy' and c.fecha_fin >= '$fecha_hoy' else 1 end)
									order by pagina";
									$res_con_pag = mysql_query($consulta_contenido_pag);
									$cantidad_con = mysql_num_rows($res_con_pag);
									if($cantidad_con!=0 and $cantidad_con!=1)
										{
											echo '<div class="renglon_vacio_contenido"></div>';
											echo '<div class="titulo_paginacion_contenido">'.titulo_pag_contenido.'</div>';
											echo '<div class="celda_paginacion_contenido">';
												while($ren_con = mysql_fetch_array($res_con_pag))
													{
														$pagina = $ren_con["pagina"];
														if($pag_con == $pagina)
															{ echo '<span class="numero_pagina_seleccionado_contenido"> '.$pagina.' </span>';
															}
														else
															{ echo ' <a title="'.contenido_txt_bus_pag.' #'.$pagina.'"  class="enlace_paginado_contenido" href="index.php?sec='.$sec.'&amp;pagina='.$pagina.'">'.$pagina.'</a> ';}
													}
											echo '</div>';
										}		
									if($ver_actualizacion == 'SI')
										{
											echo '<div class="renglon_vacio_contenido"></div>';
											echo '<div class="texto_actualizacion">';
												echo contenido_txt_ultim_actu.': <br />'.
												$fecha_actualizacion.'&nbsp;'.contenido_txt_ultim_actu2.'&nbsp;'.
												$hora_actualizacion.'&nbsp;'.contenido_txt_ultim_actu3.'<br />'.contenido_txt_ultim_actu4.'&nbsp;'.$nombre_actualizacion;
											echo '</div>';
										}
								echo '</div>';								
							}
						else
							{
								HtmlVista::ContenidoNoDisponible($ubicacion_tema);
							}
						
					}
				else
					{
						HtmlVista::ContenidoNoDisponible($ubicacion_tema);
					}
			}
	}
?>