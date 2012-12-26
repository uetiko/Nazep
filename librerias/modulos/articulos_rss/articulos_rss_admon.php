<?php
/*
Sistema: Nazep
Nombre archivo: articulos_rss_admon.php
Funci�n archivo: archivo para controlar la vista final del m�dulo de rss de los articulos
Fecha creaci�n: mayo 2009
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_articulos_rss extends conexion
	{
		//Propiedads privadas para la direcci�n del archivo y nombre de la clase
		private $DirArchivo = '../librerias/modulos/articulos_rss/articulos_rss_admon.php';
		private $NomClase = 'clase_articulos_rss';
		function __construct($etapa='test')
			{
                            if($etapa=='usar')
                                {
                                    include('../librerias/idiomas/'.FunGral::SaberIdioma().'/articulos_rss.php');
                                }
			}	
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == "activo")
					{
						$con_confi ="select clave_articulo_rss, nombre_rss from nazep_zmod_articulos_rss where clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada'";	
						$res_confi = mysql_query($con_confi);
						$can_confi = mysql_num_rows($res_confi);
						if($can_confi!='')
							{
								$ren_conf = mysql_fetch_array($res_confi);
								$nombre_rss = $ren_conf["nombre_rss"];
								$estado_enviar = 'modificar';
							}
						else
							{
								$nombre_rss = 'Nuevo listado de RSS';
								$estado_enviar = 'nuevo';
							}
						if($nivel==1 or $nivel==2)
							{
								HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'configurar_rss_'.$clave_modulo,
											'Id'=>'configurar_rss_'.$clave_modulo,
											'BText'=>configurar.' '.$nombre_rss,
											'BName'=>'btn_configurar_lis_articulos_'.$clave_modulo,
											'BId'=>'btn_configurar_lis_articulos_'.$clave_modulo,
											'OpcOcultas' => array('archivo' =>$this->DirArchivo,
															'clase' =>$this->NomClase,
															'metodo' =>'configurar',
															'estado' =>$estado_enviar,
															'clave_modulo' =>$clave_modulo) ));											
							}
					}
			}
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{
				$situacion = FunGral::vigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{echo '<br />'.avi_no_mod_mod;}
				else
					{echo '<br />'.rssart_txt_avi_no_act;}
			}		
// ------------------------------ Fin de funciones para controlar las funciones del m�dulo
// ------------------------------ Inicio de funciones para controlar la modificaci�n de la informaci�n del m�dulo
		function configurar($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$arreglo_datos["user_creacion"] = $nick_user;
						$arreglo_datos["ip_creacion"] = $_SERVER['REMOTE_ADDR'];
						$arreglo_datos["fecha_creacion"] = date("Y-m-d");
						$arreglo_datos["hora_creacion"] = date ("H:i:s");
						$arreglo_datos["user_actualizacion"] = $nick_user;
						$arreglo_datos["ip_actualizacion"] = $_SERVER['REMOTE_ADDR'];
						$arreglo_datos["fecha_actualizacion"] = date("Y-m-d");
						$arreglo_datos["hora_actualizacion"] = date("H:i:s");
						foreach($_POST as $indice=>$valor)
							{
								if(($indice != "archivo") and ($indice!="clase") and ($indice!="metodo") and ($indice!="guardar") 
								and ($indice!="clave_seccion") and ($indice!="btn_guardar") and ($indice!="estado")
								and ($indice!="clave_modulo")and ($indice!="clave_articulo_rss")and ($indice!="formulario_final"))
									{
										if($indice == "nombre_rss")
											{$valor = strip_tags($valor);}
										$arreglo_datos[$indice] = $valor;
									}
							}
						if($_POST["estado"]=='nuevo')
							{	
								$arreglo_datos["clave_seccion"] = $_POST["clave_seccion"];
								$arreglo_datos["clave_modulo"] = $_POST["clave_modulo"];
								$consulta = $this->crear_insert_simple($arreglo_datos, "nazep_zmod_articulos_rss");}
						elseif($_POST["estado"]=="modificar")
							{$consulta = $this->crear_update_simple($arreglo_datos, "nazep_zmod_articulos_rss", " clave_articulo_rss = '".$_POST["clave_articulo_rss"]."';");}
						$conexion = $this->conectarse();
						if (!@mysql_query($consulta))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}	
						else
							{	
								$paso = true;
								echo "termino-,*-$formulario_final";
							}
					}
				else
					{
						$estado = $_POST["estado"];
						$clave_modulo =  $_POST["clave_modulo"];
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion(rssart_txt_tit_conf);
						echo '<script type="text/javascript">';	
						echo '$(document).ready(function()
								{
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("configuracion_rss_articulos");
								});
							function validar_form(formulario)
								{
									if(formulario.nombre_rss.value == "") 
										{
											alert("'.rssart_js_1.'");
											formulario.nombre_rss.focus(); 	
											return false;
										}
									if(formulario.enlace_rss.value == "") 
										{
											alert("'.rssart_js_2.'");
											formulario.enlace_rss.focus(); 	
											return false;
										}
									if(formulario.lenguaje.value == "") 
										{
											alert("'.rssart_js_3.'");
											formulario.lenguaje.focus(); 	
											return false;
										}
									if(formulario.descripcion.value == "") 
										{
											alert("'.rssart_js_4.'");
											formulario.descripcion.focus(); 	
											return false;
										}
									if(formulario.cantidad_mostrar.value == "") 
										{
											alert("'.rssart_js_5.'");
											formulario.cantidad_mostrar.focus(); 	
											return false;
										}
									formulario.btn_guardar.style.visibility="hidden";
								} ';
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';														
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos_rss/articulos_rss_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos_rss"/>';
							echo '<input type="hidden" name="metodo" value = "configurar" />';	
							echo '<input type="hidden" name="estado" value = "modificar" />';
							echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
						echo '</form>';		
						echo '<form name="configuracion_rss_articulos" id="configuracion_rss_articulos" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
						if($estado == "modificar")
							{
								$con_mod_rss = " select * from nazep_zmod_articulos_rss where clave_modulo= '$clave_modulo' and clave_seccion = '$clave_seccion_enviada'";
								$conexion = $this->conectarse();
								$res_con_mod_rss = mysql_query($con_mod_rss);
								$ren_con_mod = mysql_fetch_array($res_con_mod_rss);
								$clave_seccion_enlazar = $ren_con_mod["clave_seccion_enlazar"];
							}
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							$con_sec ="select s.clave_seccion, s.nombre  as nombre_seccion from nazep_secciones s, nazep_secciones_modulos sm, nazep_modulos m
							where s.clave_seccion = sm.clave_seccion and sm.clave_modulo = m.clave_modulo
							and m.nombre_archivo = 'articulos' and (s.situacion = 'activo' or s.situacion = 'oculto') order by s.nombre";	
							$res_sec_b = mysql_query($con_sec);
							echo '<tr>';
								echo '<td>'.rssart_txt_sec_art.'</td>';
								echo '<td>';
									echo '<select name = "clave_seccion_enlazar" >';
										while($ren = mysql_fetch_array($res_sec_b))
											{
												$clave_seccion_b = $ren["clave_seccion"];
												$nombre  = $ren["nombre_seccion"];	
												if($estado == "modificar")
												{echo '<option value = "'.$clave_seccion_b.'" '; if ($clave_seccion_b == $ren_con_mod["clave_seccion_enlazar"]) {echo ' selected ';} echo ' >'.$nombre.'</option>';}
												else
												{echo '<option value = "'.$clave_seccion_b.'" '; if ($clave_seccion_b == 1) {echo ' selected ';} echo ' >'.$nombre.'</option>';}
											}
									echo '</select>';
								echo '</td>';
							echo '</tr>';	
							echo '<tr><td>'.rssart_txt_nom_rss.'</td><td>';
									if($estado == "modificar")
									{echo '<input value ="'.$ren_con_mod["nombre_rss"].'"  type = "text" name = "nombre_rss" size = "60"  />';}
									else
									{echo '<input type = "text" name = "nombre_rss" size = "60"  />';}
								echo '</td>';
							echo '</tr>';	
							echo '<tr><td>'.rssart_txt_enlace_rss.'</td><td>';
									if($estado == "modificar")
									{echo '<input value ="'.$ren_con_mod["enlace_rss"].'" type = "text" name = "enlace_rss" size = "60"  />';}
									else
									{echo '<input type = "text" name = "enlace_rss" size = "60"  />';}
								echo '</td>';
							echo '</tr>';
							echo '<tr><td>'.rssart_txt_leng_rss.'</td><td>';
									if($estado == "modificar")
									{echo '<input value ="'.$ren_con_mod["lenguaje"].'" type = "text" name = "lenguaje" size = "60"  />';}
									else
									{echo '<input type = "text" name = "lenguaje" size = "60"  />';}
								echo '</td>';
							echo '</tr>';
							echo '<tr><td>'.rssart_txt_des_rss.'</td>';
								echo '<td>';
									echo '<textarea name="descripcion" cols="35" rows="5"  >';
									if($estado == "modificar")
									{echo $ren_con_mod["descripcion"];}
									echo'</textarea>';
								echo '</td>';
							echo '</tr>';
							echo '<tr><td>'.rssart_txt_can_mos.'</td><td>';
									if($estado == "modificar")
									{echo '<input value ="'.$ren_con_mod["cantidad_mostrar"].'" type = "text" name = "cantidad_mostrar" size = "5" OnKeyPress="return solo_num(event)" title ="'.tit_solo_numeros.'"  />';}
									else
									{echo '<input type = "text" name = "cantidad_mostrar" size = "5" OnKeyPress="return solo_num(event)" title ="'.tit_solo_numeros.'"  />';}
								echo '</td>';
							echo '</tr>';
							echo '<tr><td>'.rssart_txt_ver_com.'</td><td>';
									if($estado == "modificar")
									{echo '<input '; if ($ren_con_mod["permitir_ver_comentarios"] == "no") { echo 'checked="checked"'; } echo 'type="radio" name="permitir_ver_comentarios" id ="permitir_ver_comentarios_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input '; if ($ren_con_mod["permitir_ver_comentarios"] == "si") { echo 'checked="checked"'; } echo 'type="radio" name="permitir_ver_comentarios" id ="permitir_ver_comentarios_si" value="si"  /> '.si.'&nbsp;';}
									else
									{echo '<input type="radio" name="permitir_ver_comentarios" id ="permitir_ver_comentarios_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input type="radio" name="permitir_ver_comentarios" id ="permitir_ver_comentarios_si" value="si"  /> '.si.'&nbsp;';}
								echo '</td>';
							echo '</tr>';
							echo '<tr><td>'.rssart_txt_ver_aut.'</td><td>';
									if($estado == 'modificar')
									{echo '<input '; if ($ren_con_mod["ver_autor"] == "no") { echo 'checked="checked"'; } echo 'type="radio" name="ver_autor" id ="ver_autor_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input '; if ($ren_con_mod["ver_autor"] == "si") { echo 'checked="checked"'; } echo 'type="radio" name="ver_autor" id ="ver_autor_si" value="si"  /> '.si.'&nbsp;';}
									else
									{echo '<input type="radio" name="ver_autor" id ="ver_autor_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input type="radio" name="ver_autor" id ="ver_autor_si" value="si"  /> '.si.'&nbsp;';}
								echo '</td>';
							echo '</tr>';
							echo '<tr><td>'.rssart_txt_tipo_aut.'</td><td>';
									echo '<select name = "tipo_autor_ver" >';
									if($estado == "modificar")
										{echo '<option value = "nombre" '; if ($ren_con_mod["tipo_autor_ver"] == "nombre") {echo ' selected ';} echo '>'.rssart_txt_nombre.'</option>';
										echo '<option value = "nick" '; if ($ren_con_mod["tipo_autor_ver"] == "nick") {echo ' selected ';} echo '>'.rssart_txt_nick.'</option>';}
									else
										{echo '<option value = "nombre" >'.rssart_txt_nombre.'</option>';
										echo '<option value = "nick" >'.rssart_txt_nick.'</option>';}
									echo '</select>';
								echo '</td>';
							echo '</tr>';
							echo '<tr><td>'.rssart_txt_ver_tema.'</td><td>';
									if($estado == "modificar")
									{echo '<input '; if ($ren_con_mod["usar_tema"] == "no") { echo 'checked="checked"'; } echo 'type="radio" name="usar_tema" id ="usar_tema_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input '; if ($ren_con_mod["usar_tema"] == "si") { echo 'checked="checked"'; } echo 'type="radio" name="usar_tema" id ="usar_tema_si" value="si"  /> '.si.'&nbsp;';}
									else
									{echo '<input type="radio" name="usar_tema" id ="usar_tema_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input type="radio" name="usar_tema" id ="usar_tema_si" value="si"  /> '.si.'&nbsp;';}
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td >'.rssart_txt_tip_res.'</td><td>';
									if($estado == "modificar")
									{echo '<input '; if ($ren_con_mod["tipo_resumen_ver"] == "chico") { echo 'checked="checked"'; } echo ' type="radio" name="tipo_resumen_ver" id ="tipo_resumen_ver_chico"  value="chico"  /> Chico&nbsp;';
									echo '<input '; if ($ren_con_mod["tipo_resumen_ver"] == "grande") { echo 'checked="checked"'; } echo ' type="radio" name="tipo_resumen_ver" id ="tipo_resumen_ver_grande" value="grande"  /> Grande&nbsp;';}
									else
									{echo '<input checked="checked" type="radio" name="tipo_resumen_ver" id ="tipo_resumen_ver_chico"  value="chico"  /> Chico&nbsp;';
									echo '<input type="radio" name="tipo_resumen_ver" id ="tipo_resumen_ver_grande" value="grande"  /> Grande&nbsp;';}
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.rssart_txt_cad_art.'</td>';
								echo '<td>';
									if($estado == "modificar")
									{echo '<input '; if ($ren_con_mod["permitir_caducar"] == "no") { echo 'checked="checked"'; } echo 'type="radio" name="permitir_caducar" id ="permitir_caducar_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input '; if ($ren_con_mod["permitir_caducar"] == "si") { echo 'checked="checked"'; } echo 'type="radio" name="permitir_caducar" id ="permitir_caducar_si" value="si"  /> '.si.'&nbsp;';}
									else
									{echo '<input type="radio" name="permitir_caducar" id ="permitir_caducar_no" value="no" checked="checked"  /> '.no.'&nbsp;';
									echo '<input type="radio" name="permitir_caducar" id ="permitir_caducar_si" value="si"  /> '.si.'&nbsp;';}
								echo '</td>';
							echo '</tr>';
						echo '</table>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';	
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos_rss/articulos_rss_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos_rss" />';
									echo '<input type="hidden" name="metodo" value = "configurar" />';	
									if($estado == "modificar")
									{echo '<input type="hidden" name="estado" value = "modificar" />';
									echo '<input type="hidden" name="clave_articulo_rss" value = "'.$ren_con_mod["clave_articulo_rss"].'" />';}
									else{echo '<input type="hidden" name="estado" value = "nuevo" />';}
									echo '<input type="hidden" name="guardar" value = "si" />';
									echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';		
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
									echo '<input type="submit" name="btn_guardar" value="'.guardar.'" onclick= "return validar_form(this.form)" />';
								echo '</td>';
							 echo '</tr>';	
						echo '</table>';
						echo '</form>';	
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
	}
?>