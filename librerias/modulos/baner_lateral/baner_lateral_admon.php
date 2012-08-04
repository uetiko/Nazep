<?php
/*
Sistema: Nazep
Nombre archivo: baner_lateral_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de banner laterales
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_baner_lateral extends conexion
	{
		//Propiedads privadas para la direcci�n del archivo y nombre de la clase
		private $DirArchivo = '../librerias/modulos/baner_lateral/baner_lateral_admon.php';
		private $NomClase = 'clase_baner_lateral';
		function __construct()
			{
				include('../librerias/idiomas/'.FunGral::SaberIdioma().'/baner_lateral.php');
			} 
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo	
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::vigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{
						$con_confi = "select clave_baner_configuracion, nombre_baners
						from nazep_zmod_baner_configuracion
						where clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada'";
						$res_confi = mysql_query($con_confi);
						$can_confi = mysql_num_rows($res_confi);
						if($can_confi!='')
							{
								$ren_conf = mysql_fetch_array($res_confi);
								$nombre_baners = $ren_conf["nombre_baners"];
								
								HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'nuevo_baner_'.$clave_modulo,
											'Id'=>'nuevo_baner_'.$clave_modulo,
											'BText'=>bl_txt_btn_1.' '.$nombre_baners.' '.bl_txt_btn_2,
											'BName'=>'btn_nuevo_baner',
											'BId'=>'btn_nuevo_baner',
											'OpcOcultas' => array(
												'archivo' =>$this->DirArchivo,
												'clase' =>$this->NomClase,
												'metodo' =>'nuevo',
												'clave_modulo' =>$clave_modulo) ));	
															
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'modificar_baner_'.$clave_modulo,
									'Id'=>'modificar_baner_'.$clave_modulo,
									'BText'=>bl_txt_btn_3.' '.$nombre_baners.' '.bl_txt_btn_2,
									'BName'=>'btn_modificar_baner',
									'BId'=>'btn_modificar_baner',
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'modificar',
										'clave_modulo' =>$clave_modulo) ));	
										
								if($nivel==1 or $nivel==2)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'configurar_baner_'.$clave_modulo,
											'Id'=>'configurar_baner_'.$clave_modulo,
											'BText'=>configurar.' '.$nombre_baners,
											'BName'=>'btn_configurar_baner_'.$clave_modulo,
											'BId'=>'btn_configurar_baner_'.$clave_modulo,
											'OpcOcultas' => array(
												'archivo' =>$this->DirArchivo,
												'clase' =>$this->NomClase,
												'metodo' =>'configurar',
												'clave_modulo' =>$clave_modulo) ));	
									}
							}
						else
							{
								if($nivel==1 or $nivel==2)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'configurar_baner_'.$clave_modulo,
											'Id'=>'configurar_baner_'.$clave_modulo,
											'BText'=>configurar,
											'BName'=>'btn_configurar_baner_'.$clave_modulo,
											'BId'=>'btn_configurar_baner_'.$clave_modulo,
											'OpcOcultas' => array(
												'archivo' =>$this->DirArchivo,
												'clase' =>$this->NomClase,
												'metodo' =>'configurar',
												'estado' =>'nuevo',
												'clave_modulo' =>$clave_modulo) ));	
									}
							}
					}
				else
					{echo '<br />'.bl_txt_avi_no_act;}
			}
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{
				$situacion = FunGral::vigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{	
						$con_conf ="select clave_baner_configuracion, nombre_baners from nazep_zmod_baner_configuracion where clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada'";
						$res_conf = mysql_query($con_conf);
						$ren_conf = mysql_fetch_array($res_conf);
						$clave_baner_configuracion = $ren_conf["clave_baner_configuracion"];
						if($nivel==1 or $nivel==2)
							{
								$nombre_baners = $ren_conf["nombre_baners"];
								$con_baner = "select clave_baner from nazep_zmod_baner where clave_baner_configuracion = '$clave_baner_configuracion' and situacion = 'nuevo'";
								$conexion = $this->conectarse();
								$res_ban = mysql_query($con_baner);
								$cantidad = mysql_num_rows($res_ban);
								if($cantidad!=0)
									{
										HtmlAdmon::AccesoMetodo(array(
													'ClaveSeccion'=>$clave_seccion_enviada,
													'name'=>'baner_pendiente_'.$clave_modulo,
													'Id'=>'baner_pendiente_'.$clave_modulo,
													'BText'=>$nombre_baners.' '.bl_txt_btn_4,
													'BName'=>'btn_baner_pendiente_'.$clave_modulo,
													'BId'=>'btn_baner_pendiente_'.$clave_modulo,
													'OpcOcultas' => array(
														'archivo' =>$this->DirArchivo,
														'clase' =>$this->NomClase,
														'metodo' =>'nuevo_pendiente',
														'clave_modulo' =>$clave_modulo) ));
									}
								$con_baner1 = "select b.clave_baner  from nazep_zmod_baner b, nazep_zmod_baner_cambios bc where  b.clave_baner_configuracion = '$clave_baner_configuracion' and bc.situacion = 'pendiente' and b.clave_baner = bc.clave_baner";
								$res_ban1 = mysql_query($con_baner1);
								$cantidad1 = mysql_num_rows($res_ban1);
								if($cantidad1 !=0)
									{
										HtmlAdmon::AccesoMetodo(array(
													'ClaveSeccion'=>$clave_seccion_enviada,
													'name'=>'baner_pendiente_cambio_'.$clave_modulo,
													'Id'=>'baner_pendiente_cambio_'.$clave_modulo,
													'BText'=>$nombre_baners.' '.bl_txt_btn_5,
													'BName'=>'btn_baner_pendiente_cambio_'.$clave_modulo,
													'BId'=>'btn_baner_pendiente_cambio_'.$clave_modulo,
													'OpcOcultas' => array(
														'archivo' =>$this->DirArchivo,
														'clase' =>$this->NomClase,
														'metodo' =>'cambios_pendientes',
														'clave_modulo' =>$clave_modulo) ));
									}
							}
						$conexion = $this->conectarse();
						$con_baner2 = "select bc.clave_baner from nazep_zmod_baner b, nazep_zmod_baner_cambios bc where  b.clave_baner = bc.clave_baner  and b.clave_baner_configuracion = '$clave_baner_configuracion'";	
						$res_ban2 = mysql_query($con_baner2);
						$cantidad2 = mysql_num_rows($res_ban2);
						$this->desconectarse($conexion);
						if($cantidad2 !=0)
							{
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'baner_cambios_realizado_'.$clave_modulo,
									'Id'=>'baner_cambios_realizado_'.$clave_modulo,
									'BText'=>bl_txt_btn_6.' '.$nombre_baners,
									'BName'=>'btn_baner_cambios_realizado_'.$clave_modulo,
									'BId'=>'btn_baner_cambios_realizado_'.$clave_modulo,
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'cambios_realizados',
										'clave_baner_configuracion' =>$clave_baner_configuracion,
										'clave_modulo' =>$clave_modulo) ));
							}
					}
				else
					{ echo '<br />'.bl_txt_avi_no_act_cam; }
			}	
// ------------------------------ Fin de funciones para controlar las funciones del m�dulo
// ------------------------------ Inicio de funciones para controlar la modificaci�n de la informaci�n del m�dulo	
		function configurar($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$nombre_baners = addslashes($_POST["nombre_baners"]);
						$nombre_baners = strip_tags($nombre_baners);
						$cantidad_mostrar = $_POST["cantidad_mostrar"];
						$ver_texto_titulo = $_POST["ver_texto_titulo"];						
						$texto_titulo = addslashes($_POST["texto_titulo"]);
						$texto_titulo = strip_tags($texto_titulo);
						$ver_imagen_titulo = $_POST["ver_imagen_titulo"];
						$imagen_titulo = $_POST["imagen_titulo"];
						$ver_texto_ver_mas = $_POST["ver_texto_ver_mas"];
						$texto_ver_mas = addslashes($_POST["texto_ver_mas"]);
						$texto_ver_mas = strip_tags($texto_ver_mas);
						$ver_imagen_ver_mas = $_POST["ver_imagen_ver_mas"];
						$imagen_ver_mas = $_POST["imagen_ver_mas"];
						$seccion_ver_mas = $_POST["seccion_ver_mas"];
						$ver_imagen_balazo = $_POST["ver_imagen_balazo"];
						$ubicacion_imagen_balazo = $_POST["ubicacion_imagen_balazo"];
						$ver_texto_balazo = $_POST["ver_texto_balazo"];
						$texto_balazo = $_POST["texto_balazo"];
						$texto_balazo = strip_tags($texto_balazo);
						$color_fondo_lateral = $_POST["color_fondo_lateral"];
						$alin_balazo = $_POST["alin_balazo"];
						$clave_modulo = $_POST["clave_modulo"];
						$clave_seccion = $_POST["clave_seccion"];
						$estado = $_POST["estado"];
						if($estado=="nuevo")
							{
								$consulta = "insert into nazep_zmod_baner_configuracion
								(clave_modulo, clave_seccion, nombre_baners, cantidad_mostrar, texto_titulo, ver_texto_titulo, imagen_titulo, 
								ver_imagen_titulo, texto_ver_mas, ver_texto_ver_mas, imagen_ver_mas, ver_imagen_ver_mas, seccion_ver_mas, ubicacion_imagen_balazo, ver_imagen_balazo,
								texto_balazo, ver_texto_balazo, alin_balazo, color_fondo_lateral)
								values
								('$clave_modulo', '$clave_seccion', '$nombre_baners', '$cantidad_mostrar','$texto_titulo ', '$ver_texto_titulo','$imagen_titulo',
								 '$ver_imagen_titulo', '$texto_ver_mas','$ver_texto_ver_mas', '$imagen_ver_mas', '$ver_imagen_ver_mas', '$seccion_ver_mas','$ubicacion_imagen_balazo','$ver_imagen_balazo',
								 '$texto_balazo', '$ver_texto_balazo','$alin_balazo','$color_fondo_lateral')";
							}
						elseif($estado=="modificar")
							{
								$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
								$consulta = "update nazep_zmod_baner_configuracion
								set nombre_baners = '$nombre_baners', cantidad_mostrar = '$cantidad_mostrar', texto_titulo = '$texto_titulo', 
								ver_texto_titulo = '$ver_texto_titulo', imagen_titulo = '$imagen_titulo', ver_imagen_titulo = '$ver_imagen_titulo',
								texto_ver_mas = '$texto_ver_mas', ver_texto_ver_mas = '$ver_texto_ver_mas', imagen_ver_mas = '$imagen_ver_mas', 
								ver_imagen_ver_mas ='$ver_imagen_ver_mas', seccion_ver_mas = '$seccion_ver_mas', ubicacion_imagen_balazo = '$ubicacion_imagen_balazo',
								ver_imagen_balazo = '$ver_imagen_balazo', texto_balazo = '$texto_balazo', ver_texto_balazo = '$ver_texto_balazo',
								alin_balazo = '$alin_balazo', color_fondo_lateral = '$color_fondo_lateral'
								where clave_baner_configuracion = '$clave_baner_configuracion'";
							}
						$paso = false;
						$conexion = $this->conectarse();
						if (!@mysql_query($consulta))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;	
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{ echo "termino-,*-$formulario_final"; }
					}
				else
					{
						$estado = $_POST["estado"];
						$clave_modulo =  $_POST["clave_modulo"];
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion(bl_txt_tit_con);
						echo '<script type="text/javascript">';
						echo ' $(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_configuracion_baner");
									});						
								function validar_form(formulario)
									{
										if(formulario.nombre_baners.value == "") 
											{
												alert("'.bl_js_1.'")
												formulario.nombre_baners.focus();
												return false;
											}
										if(formulario.cantidad_mostrar.value == "") 
											{
												alert("'.bl_js_2.'")
												formulario.cantidad_mostrar.focus();
												return false;
											}
										if(formulario.ver_texto_titulo.value == "SI")
											{
												if(formulario.texto_titulo.value == "") 
													{
														alert("'.bl_js_3.'")
														formulario.texto_titulo.focus();
														return false;
													}
												if(formulario.ver_imagen_titulo.value == "SI")
													{
														alert("'.bl_js_4.'")
														formulario.ver_imagen_titulo.focus();
														return false;
													}
											}
										if(formulario.ver_imagen_titulo.value == "SI")
											{
												if(formulario.imagen_titulo.value == "") 
													{
														alert("'.bl_js_5.'")
														formulario.imagen_titulo.focus();
														return false;
													}
											}
										if(formulario.ver_texto_ver_mas.value == "SI")
											{
												if(formulario.texto_ver_mas.value == "") 
													{
														alert("'.bl_js_6.'")
														formulario.texto_ver_mas.focus();
														return false;
													}
												if(formulario.ver_imagen_ver_mas.value == "SI")
													{
														alert("'.bl_js_7.'")
														formulario.ver_imagen_ver_mas.focus();
														return false;
													}
											}
										if(formulario.ver_imagen_ver_mas.value == "SI")
											{
												if(formulario.imagen_ver_mas.value == "") 
													{
														alert("'.bl_js_8.'")
														formulario.ver_imagen_ver_mas.focus();
														return false
													}
											}
										if(formulario.ver_imagen_balazo.value == "SI")
											{
												if(formulario.ubicacion_imagen_balazo.value == "") 
													{
														alert("'.bl_js_9.'");
														formulario.ubicacion_imagen_balazo.focus();
														return false;
													}	
												if(formulario.ver_texto_balazo.value == "SI")
													{
														alert("'.bl_js_10.'");
														formulario.ver_texto_balazo.focus();
														return false;
													}
											}
										if(formulario.ver_texto_balazo.value == "SI")
											{
												if(formulario.texto_balazo.value == "") 
													{
														alert("'.bl_js_11.'");
														formulario.texto_balazo.focus();
														return false;
													}
											}
										if(formulario.color_fondo_lateral.value == "") 
											{
												alert("'.bl_js_12.'");
												formulario.color_fondo_lateral.focus();
												return false;
											}
										formulario.btn_guardar.style.visibility="hidden";
									}';
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_baner_lateral"/>';
							echo '<input type="hidden" name="metodo" value = "configurar" />';	
							echo '<input type="hidden" name="estado" value = "modificar" />';
							echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
						echo '</form>';	
						echo '<form name="frm_configuracion_baner" id="frm_configuracion_baner" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
						if($estado == "nuevo")
							{
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td>'.bl_txt_nom_banns.'</td><td><input type = "text" name = "nombre_baners" size = "60" /></td></tr>';
									echo '<tr><td>'.bl_txt_can_mos_banns.'</td>';
										echo '<td><input type = "text" name = "cantidad_mostrar" size = "5" onkeypress="return solo_num(event)" title ="'.tit_solo_numeros.'" /></td>';
									echo '</tr>';
									echo '<tr><td><hr /></td><td><hr /></td></tr>';
									echo '<tr><td>'.bl_txt_ver_tit_text.'</td><td>';
											echo '<input type="radio" name="ver_texto_titulo" id ="ver_texto_titulo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input checked="checked" type="radio" name="ver_texto_titulo" id ="ver_texto_titulo_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_tit_text.'</td>';
										echo '<td><input type = "text" name = "texto_titulo" size = "60" /></td>';
									echo '</tr>';	
									echo '<tr>';
										echo '<td>'.bl_txt_ver_tit_img.'</td>';
										echo '<td>';
											echo '<input type="radio" name="ver_imagen_titulo" id ="ver_imagen_titulo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input checked="checked" type="radio" name="ver_imagen_titulo" id ="ver_imagen_titulo_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ubi_tit_img.'</td>';
										echo '<td><input type = "text" name = "imagen_titulo" size = "60" /></td>';
									echo '</tr>';
									echo '<tr><td><hr /></td><td><hr /></td></tr>';
									echo '<tr><td>'.bl_txt_ver_enl.'</td>';
										echo '<td>';
											echo '<input type="radio" name="ver_texto_ver_mas" id ="ver_texto_ver_mas_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input checked="checked" type="radio" name="ver_texto_ver_mas" id ="ver_texto_ver_mas_si" value="SI"  /> '.si.'&nbsp;';										
										echo '</td>';
									echo '</tr>';	
									echo '<tr><td>'.bl_txt_enl_text.'</td>';
										echo '<td><input type = "text" name = "texto_ver_mas" size = "60" /></td>';
									echo '</tr>';	
									echo '<tr>';
										echo '<td>'.bl_txt_ver_enl_img.'</td><td>';
											echo '<input                   type="radio" name="ver_imagen_ver_mas" id ="ver_imagen_ver_mas_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input checked="checked" type="radio" name="ver_imagen_ver_mas" id ="ver_imagen_ver_mas_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ubi_enl_img.'</td>';
										echo '<td><input type = "text" name = "imagen_ver_mas" size = "60" /></td>';
									echo '</tr>';
									$con_sec = "select clave_seccion, nombre from nazep_secciones
									where situacion = 'activo' order by nombre";
									$res_sec_b = mysql_query($con_sec);
									echo '<tr>';
										echo '<td>'.bl_txt_ubi_sec_enl.'</td>';
										echo '<td>';
											echo '<select name = "seccion_ver_mas">';
												while($ren = mysql_fetch_array($res_sec_b))
													{
														$clave_seccion_b = $ren["clave_seccion"];
														$nombre  = $ren["nombre"];
														echo '<option value = "'.$clave_seccion_b.'"  '; if ($clave_seccion_b == 1) {echo ' selected="selected" ';} echo ' >'.$nombre.'</option>';
													}
											echo '</select>';
										echo '</td>';
									echo '</tr>';
									echo '<tr><td><hr /></td><td><hr /></td></tr>';	
									echo '<tr><td>'.bl_txt_ver_bal_tex.'</td><td>';
											echo '<input                   type="radio" name="ver_texto_balazo" id ="ver_texto_balazo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input checked="checked" type="radio" name="ver_texto_balazo" id ="ver_texto_balazo_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';	
									echo '<tr><td>'.bl_txt_bal_text.'</td><td><input type = "text" name = "texto_balazo" size = "60" /></td></tr>';
									echo '<tr><td>'.bl_txt_ver_bal_img.'</td><td>';
											echo '<input                   type="radio" name="ver_imagen_balazo" id ="ver_imagen_balazo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input checked="checked" type="radio" name="ver_imagen_balazo" id ="ver_imagen_balazo_si" value="SI"  /> '.si.'&nbsp;';										
										echo '</td>';
									echo '</tr>';
									echo '<tr><td>'.bl_txt_ubi_bal_img.'</td><td><input type = "text" name = "ubicacion_imagen_balazo" size = "60" /></td></tr>';
									echo '<tr><td><hr /></td><td><hr /></td></tr>';	
									echo '<tr><td>'.bl_txt_ali_hor.'</td><td>';
											echo '<select name = "alin_balazo">';
												echo '<option value = "top" >'.arriba.'</option>';
												echo '<option value = "middle" >'.centro.'</option>';
												echo '<option value = "bottom" >'.abajo.'</option>';
											echo '</select>';
										echo '</td>';
									echo '</tr>';
									echo '<tr><td>'.bl_txt_col_tab.'</td><td>';
											echo '#<input type = "text" name = "color_fondo_lateral" size = "20" /> RGB Hexadecimal ejemplo: <strong>FFFFFF</strong>';
										echo '</td>';
									echo '</tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
											echo '<input type="hidden" name="metodo" value = "configurar" />';	
											echo '<input type="hidden" name="estado" value = "nuevo" />';
											echo '<input type="hidden" name="guardar" value = "si" />';
											echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
											echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
											echo '<input type="submit" name="btn_guardar" value="'.guardar.'" onclick= "return validar_form(this.form)" />';
										echo '</td>';
									 echo '</tr>';
								echo '</table>';
							}
						else
							{
								$con_confi = "select * from nazep_zmod_baner_configuracion where clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada'";
								$res_confi = mysql_query($con_confi);
								$ren_confi = mysql_fetch_array($res_confi);
								$nombre_baners = $ren_confi["nombre_baners"];
								$cantidad_mostrar = $ren_confi["cantidad_mostrar"];
								$texto_titulo = $ren_confi["texto_titulo"];
								$ver_texto_titulo = $ren_confi["ver_texto_titulo"];
								$imagen_titulo = $ren_confi["imagen_titulo"];
								$ver_imagen_titulo = $ren_confi["ver_imagen_titulo"];
								$texto_ver_mas = $ren_confi["texto_ver_mas"];
								$ver_texto_ver_mas = $ren_confi["ver_texto_ver_mas"];
								$ver_imagen_ver_mas = $ren_confi["ver_imagen_ver_mas"];
								$imagen_ver_mas = $ren_confi["imagen_ver_mas"];
								$seccion_ver_mas = $ren_confi["seccion_ver_mas"];
								$ubicacion_imagen_balazo = $ren_confi["ubicacion_imagen_balazo"];
								$ver_imagen_balazo = $ren_confi["ver_imagen_balazo"];
								$texto_balazo = $ren_confi["texto_balazo"];
								$ver_texto_balazo = $ren_confi["ver_texto_balazo"];
								$alin_balazo = $ren_confi["alin_balazo"];
								$color_fondo_lateral = $ren_confi["color_fondo_lateral"];
								$clave_baner_configuracion = $ren_confi["clave_baner_configuracion"];
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td>'.bl_txt_nom_banns.'</td>';
										echo '<td><input type = "text" name = "nombre_baners" size = "60" value = "'.$nombre_baners.'" /></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_can_mos_banns.'</td>';
										echo '<td><input type = "text" name = "cantidad_mostrar" size = "5" value = "'.$cantidad_mostrar.'" onkeypress="return solo_num(event)"  title ="'.tit_solo_numeros.'" /></td>';
									echo '</tr>';
									echo '<tr><td colspan="2"><hr /></td></tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ver_tit_text.'</td>';
										echo '<td>';
											echo '<input '; if ($ver_texto_titulo == "NO") { echo 'checked="checked"'; } echo 'type="radio" name="ver_texto_titulo" id ="ver_texto_titulo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input '; if ($ver_texto_titulo == "SI") { echo 'checked="checked"'; } echo 'type="radio" name="ver_texto_titulo" id ="ver_texto_titulo_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_tit_text.'</td>';
										echo '<td><input type = "text" name = "texto_titulo" size = "60" value = "'.$texto_titulo.'" /></td>';
									echo '</tr>';	
									echo '<tr>';
										echo '<td>'.bl_txt_ver_tit_img.'</td>';
										echo '<td>';
											echo '<input '; if ($ver_imagen_titulo == "NO") { echo 'checked="checked"'; } echo 'type="radio" name="ver_imagen_titulo" id ="ver_imagen_titulo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input '; if ($ver_imagen_titulo == "SI") { echo 'checked="checked"'; } echo 'type="radio" name="ver_imagen_titulo" id ="ver_imagen_titulo_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ubi_tit_img.'</td>';
										echo '<td><input type = "text" name = "imagen_titulo" size = "60" value = "'.$imagen_titulo.'" /></td>';
									echo '</tr>';
									echo '<tr><td colspan="2"><hr /></td></tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ver_enl.'</td>';
										echo '<td>';
											echo '<input '; if ($ver_texto_ver_mas == "NO") { echo 'checked="checked"'; } echo 'type="radio" name="ver_texto_ver_mas" id ="ver_texto_ver_mas_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input '; if ($ver_texto_ver_mas == "SI") { echo 'checked="checked"'; } echo 'type="radio" name="ver_texto_ver_mas" id ="ver_texto_ver_mas_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_enl_text.'</td>';
										echo '<td><input type = "text" name = "texto_ver_mas" size = "60" value = "'.$texto_ver_mas.'" /></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ver_enl_img.'</td>';
										echo '<td>';
											echo '<input '; if ($ver_imagen_ver_mas == "NO") { echo 'checked="checked"'; } echo 'type="radio" name="ver_imagen_ver_mas" id ="ver_imagen_ver_mas_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input '; if ($ver_imagen_ver_mas == "SI") { echo 'checked="checked"'; } echo 'type="radio" name="ver_imagen_ver_mas" id ="ver_imagen_ver_mas_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ubi_enl_img.'</td>';
										echo '<td><input type = "text" name = "imagen_ver_mas" size = "60" value = "'.$imagen_ver_mas.'" /></td>';
									echo '</tr>';
									$con_sec = "select clave_seccion, nombre from nazep_secciones where situacion = 'activo' order by nombre";
									$res_sec_b = mysql_query($con_sec);
									echo '<tr>';
										echo '<td>'.bl_txt_ubi_sec_enl.'</td>';
										echo '<td>';
											echo '<select name = "seccion_ver_mas">';
												while($ren = mysql_fetch_array($res_sec_b))
													{
														$clave_seccion_b = $ren["clave_seccion"];
														$nombre  = $ren["nombre"];
														echo '<option value = "'.$clave_seccion_b.'"  '; if ($clave_seccion_b == $seccion_ver_mas) {echo ' selected="selected" ';} echo ' >'. $nombre.' </option>';
													}
											echo '</select>';
										echo '</td>';
									echo '</tr>';
									echo '<tr><td colspan="2"><hr /></td></tr>';
									echo '<tr>';
										echo '<td>'.bl_txt_ver_bal_tex.'</td>';
										echo '<td>';
											echo '<input '; if ($ver_texto_balazo == "NO") { echo 'checked="checked"'; } echo 'type="radio" name="ver_texto_balazo" id ="ver_texto_balazo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input '; if ($ver_texto_balazo == "SI") { echo 'checked="checked"'; } echo 'type="radio" name="ver_texto_balazo" id ="ver_texto_balazo_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';	
									echo '<tr><td>'.bl_txt_bal_text.'</td>';
										echo '<td><input type = "text" name = "texto_balazo" size = "60" value = "'.$texto_balazo.'"/></td>';
									echo '</tr>';
									echo '<tr><td>'.bl_txt_ver_bal_img.'</td>';
										echo '<td>';
											echo '<input '; if ($ver_imagen_balazo == "NO") { echo 'checked="checked"'; } echo 'type="radio" name="ver_imagen_balazo" id ="ver_imagen_balazo_no" value="NO"  /> '.no.'&nbsp;';
											echo '<input '; if ($ver_imagen_balazo == "SI") { echo 'checked="checked"'; } echo 'type="radio" name="ver_imagen_balazo" id ="ver_imagen_balazo_si" value="SI"  /> '.si.'&nbsp;';
										echo '</td>';
									echo '</tr>';
									echo '<tr><td>'.bl_txt_ubi_bal_img.'</td>';
										echo '<td><input type = "text" name = "ubicacion_imagen_balazo" size = "60" value = "'.$ubicacion_imagen_balazo.'" /></td>';
									echo '</tr>';
									echo '<tr><td colspan="2"><hr /></td></tr>';
									echo '<tr><td>'.bl_txt_ali_hor.'</td><td>';
											echo '<select name = "alin_balazo">';
												echo '<option value = "top" '; if ($alin_balazo == "top") { echo 'selected="selected"'; } echo ' >'.arriba.'</option>';
												echo '<option value = "middle" '; if ($alin_balazo == "middle") { echo 'selected="selected"'; } echo '>'.centro.'</option>';
												echo '<option value = "bottom" '; if ($alin_balazo == "bottom") { echo 'selected="selected"'; } echo '>'.abajo.'</option>';
											echo '</select>';
										echo '</td>';
									echo '</tr>';
									echo '<tr><td>'.bl_txt_col_tab.'</td>';
										echo '<td>#<input type = "text" name = "color_fondo_lateral" size = "20" value = "'.$color_fondo_lateral.'" /> RGB Hexadecimal ejemplo: <strong>FFFFFF</strong></td>';
									echo '</tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
											echo '<input type="hidden" name="metodo" value = "configurar" />';	
											echo '<input type="hidden" name="estado" value = "modificar" />';
											echo '<input type="hidden" name="guardar" value = "si" />'; 
											echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';	
											echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';		
											echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
											echo '<input type="submit" name="btn_guardar" value="'.guardar.'" onclick= "return validar_form(this.form)" />';
										echo '</td>';
									 echo '</tr>';
								echo '</table>';
							}
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function nuevo($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_seccion = $_POST["clave_seccion"];
						$clave_baner_configuracion  = $_POST["clave_baner_configuracion"];
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_fin = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];		
						$nombre_baner = $this->escapar_caracteres($_POST["nombre_baner"]);
						$nombre_baner = strip_tags($nombre_baner);
						$orden = $_POST["orden"];
						$descripcion = $this->escapar_caracteres($_POST["descripcion"]);
						$descripcion = strip_tags($descripcion);
						$enlace = $this->escapar_caracteres($_POST["enlace"]);
						$situacion_temporal = $_POST["situacion_temporal"];		
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];						
						if($correo=="")
							{
								$correo = $cor_user;
							}
						if($nombre=="")
							{
								$nombre = $nom_user;
							}
						$nombre = strip_tags($nombre);
						$situacion_gral = "nuevo";
						$sql_adicional = "null, '', '0000-00-00','00:00:00',";
						if($situacion_temporal == "activo")
							{
								$situacion_gral = "activo";
								$sql_adicional = "'$nick_user', '$ip', '$fecha_hoy', '$hora_hoy', ";
							}
						$insertar_enlace = "insert into nazep_zmod_baner
						(clave_baner_configuracion, situacion, fecha_inicio, fecha_fin, user_creacion, ip_creacion, fecha_creacion, hora_creacion,
						user_actualizacion, ip_actualizacion, fecha_actualizacion, hora_actualizacion, 
						nombre, orden, descripcion, enlace)
						values
						('$clave_baner_configuracion', '$situacion_gral', '$fecha_inicio', '$fecha_fin', '$nick_user', '$ip', '$fecha_hoy', '$hora_hoy',
						".$sql_adicional."
						'$nombre_baner', '$orden', '$descripcion', '$enlace')";	
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insertar_enlace))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;
								$clave_baner_db = mysql_insert_id();
								$sql_adicional .= "'Nuevo baner', '$nombre', '$correo', ";
								$insertar_enlace_cambio = "insert into
								nazep_zmod_baner_cambios
								(clave_baner, situacion, 
								nick_user_propone, ip_propone, fecha_propone, hora_propone, motivo_propone, nombre_propone, correo_propone,
								nick_user_decide, ip_decide, fecha_decide, hora_decide, motivo_decide, nombre_decide, correo_decide,
								nuevo_nombre, nuevo_orden, nuevo_situacion, nuevo_descripcion, nuevo_enlace, nuevo_fecha_inicio,nuevo_fecha_fin,
								anterior_nombre, anterior_orden, anterior_situacion, anterior_descripcion, anterior_enlace, anterior_fecha_inicio, anterior_fecha_fin)
								values
								('$clave_baner_db', '$situacion_gral', 
								'$nick_user','$ip', '$fecha_hoy', '$hora_hoy', 'Nuevo baner', '$nombre', '$correo',
								".$sql_adicional."
								'$nombre_baner', '$orden', 'nuevo', '$descripcion', '$enlace', '$fecha_inicio', '$fecha_fin',
								'$nombre_baner', '$orden', 'nuevo', '$descripcion', '$enlace', '$fecha_inicio', '$fecha_fin')";
								if (!@mysql_query($insertar_enlace_cambio))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}
								else
									{
										$paso = true;
									}
							}
						if($paso)
							{
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";	
							}
						else
							{
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						$this->desconectarse($conexion);
					}	
				else
					{
						$clave_modulo =  $_POST["clave_modulo"];	
						$conexion = $this->conectarse();
						$res_conf = mysql_query("select clave_baner_configuracion from nazep_zmod_baner_configuracion where clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada' ");
						$ren_conf = mysql_fetch_array($res_conf);
						$clave_baner_configuracion = $ren_conf["clave_baner_configuracion"];
						$variable_archivos = directorio_archivos."$clave_seccion_enviada/";
						$_SESSION["direccion_archivos"] = $variable_archivos;
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion(bl_txt_tit_bann." \"$nombre\"");
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_generar_nuevo_baner");
									});							
								function validar_form(formulario, valor_temporal, opcion)
									{
										formulario.formulario_final.value = opcion;
										formulario.situacion_temporal.value = valor_temporal;
										separador = "/";		
										fecha_ini = formulario.dia_i.value+"/"+formulario.mes_i.value+"/"+formulario.ano_i.value;
										fecha_fin = formulario.dia_t.value+"/"+formulario.mes_t.value+"/"+formulario.ano_t.value;
										
										if(!Comparar_Fecha(fecha_ini, fecha_fin))
											{
												alert("'.comparar_fecha_veri.'");
												formulario.dia_i.focus(); 
												return false;
											}
										if(!verificar_fecha(fecha_ini, separador))
											{
												alert("'.verificar_fecha_ini.'");
												formulario.dia_i.focus(); 
												return false;
											}
										if(!verificar_fecha(fecha_fin, separador))
											{
												alert("'.verificar_fecha_fin.'");
												formulario.dia_t.focus(); 
												return false;
											}
										if(formulario.nombre_baner.value == "") 
											{
												alert("'.bl_js_13.'");
												formulario.nombre_baner.focus();	
												return false;
											}
										if(formulario.orden.value == "") 
											{
												alert("'.bl_js_14.'")
												formulario.orden.focus();
												return false;
											}	
										if(formulario.descripcion.value == "") 
											{
												alert("'.bl_js_15.'");
												formulario.descripcion.focus();	
												return false;
											}
										valor_enlace = FCKeditorAPI.__Instances[\'enlace\'].GetHTML();
										formulario.enlace.value = valor_enlace; 
										if(formulario.enlace.value == "") 
											{
												alert("'.bl_js_16.'");
												location.href="#enlace_link";	
												return false;
											}
										formulario.btn_guardar1.style.visibility="hidden";
							';
							if($nivel == "1" or $nivel == "2")
								{
							echo '
										formulario.btn_guardar2.style.visibility="hidden";
										formulario.btn_guardar3.style.visibility="hidden";
								';
								}
							echo ' } ';
						echo '</script>';
						echo '<form name="regresar_pantalla" id="regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_baner_lateral"/>';
							echo '<input type="hidden" name="metodo" value = "nuevo" />';	
							echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
						echo '</form>';	
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="get" action="index.php" class="margen_cero">
							<input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
						echo '</form>';	
						echo '<form name="frm_generar_nuevo_baner" id="frm_generar_nuevo_baner" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>'.bl_txt_per_crea.'</td>';
									echo '<td><input type = "text" name = "nombre" size = "60" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.bl_txt_cor_crea.'</td>';
									echo '<td><input type = "text" name = "correo" size = "60" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>';
										echo fecha_ini_vig;	
									echo '</td>';
									echo '<td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										$areglo_meses = FunGral::MesesNumero();
										echo dia.'&nbsp;<select name = "dia_i">';
										for ($a = 1; $a<=31; $a++)
											{echo "<option value = \"$a\" "; if ($dia == $a) { echo 'selected="selected"'; } echo " > $a </option>";}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_i">';
											for ($b=1; $b<=12; $b++)
												{echo "<option value = \"$b\"  "; if ($mes == $b) {echo ' selected="selected" ';} echo " >". $areglo_meses[$b] ."</option>";}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_i">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{ echo "<option value = \"$b\" "; if ($ano == $b) {echo ' selected="selected" ';} echo "> $b</option>";}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.fecha_fin_vig.'</td>';

									echo '<td>';
										echo dia.'&nbsp;<select name = "dia_t">';
										for ($a = 1; $a<=31; $a++)
											{echo "<option value = \"$a\" "; if ($dia == $a) { echo 'selected="selected"'; } echo " > $a </option>";}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_t">';
											for ($b=1; $b<=12; $b++)
												{echo "<option value = \"$b\"  "; if ($mes == $b) {echo ' selected="selected" ';} echo " >". $areglo_meses[$b] ."</option>";}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_t">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{echo "<option value = \"$b\" "; if ($ano == $b) {echo ' selected="selected" ';} echo "> $b</option>";}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.bl_txt_nom_bann.'</td>';
									echo '<td><input type = "text" name = "nombre_baner" size = "60" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.bl_txt_ord_apa.'</td>';
									echo '<td><input type = "text" name = "orden" size = "5" onkeypress="return solo_num(event)" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.bl_txt_des_ban.'</td>';
									echo '<td><textarea name="descripcion" cols="50" rows="5"></textarea></td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>'.bl_txt_cue_ban.'</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>';
										echo '<a name="enlace_link" id="enlace_link"></a>';
										$oFCKeditor = new FCKeditor("enlace") ;
										$oFCKeditor->BasePath = "../librerias/fckeditor/";
										$oFCKeditor->ToolbarSet = "Default";
										$oFCKeditor->Width = "100%";
										$oFCKeditor->Height = "350";
										$oFCKeditor->Config["EditorAreaCSS"] = $ubi_tema."fck_editorarea.css";
										$oFCKeditor->Config["StylesXmlPath"] = $ubi_tema."fckstyles.xml";
										$oFCKeditor->Config['EnterMode'] = 'br';
										$oFCKeditor->Create();
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<input type="hidden" name="formulario_final" value = "" />';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
							echo '<input type="hidden" name="metodo" value = "nuevo" />';
							echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
							echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
							echo '<input type="hidden" name="guardar" value = "si" />';
							echo '<input type="hidden" name="situacion_temporal" value = "nuevo" />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="submit" name="btn_guardar1" value="'.guardar.'" onclick="return validar_form(this.form, \'nuevo\',\'recargar_pantalla\')" />';
									echo '</td>';
									if($nivel == "1" or $nivel == "2")
										{	
											echo '<td align ="center">';
												echo '<input type="submit" name="btn_guardar2" value="'.guardar_puliblicar.'"  onclick= "return validar_form(this.form, \'activo\',\'recargar_pantalla\')" />';
											echo '</td>';
										}
								echo '</tr>';
							echo '</table>';
								if($nivel == "1" or $nivel == "2")
									{	
										echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
											echo '<tr>';
												echo '<td align ="center">';
													echo '<input type="submit" name="btn_guardar3" value="'.guardar_pub_otro.'"  onclick= "return validar_form(this.form, \'activo\',\'regresar_pantalla\')" />';
												echo '</td>';
											echo '</tr>';
										echo '</table>';
									}
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function modificar($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$motivo = addslashes($_POST["motivo"]);
						$motivo = strip_tags($motivo);
						$nombre_baner = $this->escapar_caracteres($_POST["nombre_baner"]);
						$orden = $_POST["orden"];
						$situacion = $_POST["situacion"];
						$descripcion = $this->escapar_caracteres($_POST["descripcion"]);
						$descripcion = strip_tags($descripcion);
						$enlace = $this->escapar_caracteres($_POST["enlace"]);
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_fin = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
						$clave_baner = $_POST["clave_baner"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];	
						$situacion_temporal = $_POST["situacion_temporal"];	
						$clave_seccion = $_POST["clave_seccion"];			
						if($correo=="")
							{
								$correo = $cor_user;
							}
						if($nombre=="")
							{
								$nombre = $nom_user;
							}
						$nombre = strip_tags($nombre);
						$sql_adicional = "null, '', '0000-00-00', '00:00:00','', '','',";
						if($situacion_temporal=="activo")
							{
								$sql_adicional = "'$nick_user', '$ip', '$fecha_hoy', '$hora_hoy',  '$motivo', '$nombre', '$correo',";
							}
						$insert_cambio = "insert into nazep_zmod_baner_cambios
						(clave_baner, situacion, nick_user_propone, ip_propone, fecha_propone, hora_propone, motivo_propone, 
						nombre_propone, correo_propone,
						nick_user_decide, ip_decide, fecha_decide, hora_decide, motivo_decide, nombre_decide, correo_decide,
						nuevo_nombre, nuevo_orden, nuevo_situacion, nuevo_descripcion, nuevo_enlace, nuevo_fecha_inicio, nuevo_fecha_fin,
						anterior_nombre, anterior_orden, anterior_situacion, anterior_descripcion, anterior_enlace, 
						anterior_fecha_inicio, anterior_fecha_fin)
						select '$clave_baner', '$situacion_temporal', '$nick_user', '$ip', '$fecha_hoy', '$hora_hoy', '$motivo',
						'$nombre','$correo',
						".$sql_adicional."
						'$nombre_baner','$orden','$situacion','$descripcion','$enlace','$fecha_inicio', '$fecha_fin',
						nombre,orden,situacion,descripcion,enlace,fecha_inicio, fecha_fin
						from nazep_zmod_baner 
						where  clave_baner = '$clave_baner'";
						$paso = false;
						$conexion = $this->conectarse();
						if (!@mysql_query($insert_cambio))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}	
						else
							{	
								$paso = true;
								if($situacion_temporal=="activo")
									{
										$update="update nazep_zmod_baner set
										situacion = '$situacion', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', 
										user_actualizacion = '$nick_user', ip_actualizacion = '$ip', fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy', 
										nombre = '$nombre_baner', orden = '$orden', descripcion = '$descripcion', enlace = '$enlace'
										where clave_baner = '$clave_baner'";
										if (!@mysql_query($update))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 2;
											}
										else
											{
												$paso = true;
											}
									}
							}
						if($paso)
							{
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";	
							}
						else
							{
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
					}
				else
					{
						if(isset($_POST["clave_baner"]) &&  $_POST["clave_baner"]!="")
							{
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Modificar el banner de la secci&oacute;n \"$nombre\"");	
								$clave_baner = $_POST["clave_baner"];
								$clave_modulo = $_POST["clave_modulo"];
								$con_baner_cambios = "select clave_baners_cambios
								from nazep_zmod_baner b, nazep_zmod_baner_cambios bc
								where b.clave_baner = bc.clave_baner
								and bc.clave_baner = '$clave_baner' and (bc.situacion = 'pendiente' or bc.situacion = 'nuevo')";
								$conexion = $this->conectarse();
								$res_ban_cam = mysql_query($con_baner_cambios);
								$cant_baners = mysql_num_rows($res_ban_cam);
								if($cant_baners!="0")
									{
										echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
											echo '<tr>';
												echo '<td align = "center"><br /><strong>'.bl_txt_tiene_cambio_pen.'</strong><br /><br /></td>';
											echo '</tr>';
										echo '</table>';
										echo '<form name="reg_buscador" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
											echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
												echo '<tr>';
													echo '<td align="center">';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
														echo '<input type="hidden" name="metodo" value = "modificar" />';
														echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';
														echo '<input type="hidden" name="clave_modulo" value ="'.$clave_modulo.'" />';	
														echo '<a href="javascript:document.reg_buscador.submit()" class="regresar">';
														echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
														echo '<strong>'.bl_txt_reg_lis_ban.'</strong>';
														echo '</a>';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
										echo '</form>';
									}
								else
									{
										$variable_archivos = directorio_archivos."$clave_seccion_enviada/";
										$_SESSION["direccion_archivos"] = $variable_archivos;
										$con_doc ="select situacion, fecha_inicio, fecha_fin, nombre, orden, descripcion, enlace
										from nazep_zmod_baner
										where clave_baner = '$clave_baner'";
										$conexion = $this->conectarse();
										$res_con_doc = mysql_query($con_doc);
										$ren_con_doc = mysql_fetch_array($res_con_doc);
										$situacion = $ren_con_doc["situacion"];
										$fecha_inicio = $ren_con_doc["fecha_inicio"];
										list($ano_i, $mes_i, $dia_i) = explode("-",$fecha_inicio);
										$fecha_fin = $ren_con_doc["fecha_fin"];
										list($ano_t, $mes_t, $dia_t) = explode("-",$fecha_fin);
										$nombre = stripslashes($ren_con_doc["nombre"]);
										$orden = $ren_con_doc["orden"];
										$descripcion = stripslashes($ren_con_doc["descripcion"]);
										$enlace = stripslashes($ren_con_doc["enlace"]);
										echo '<script type="text/javascript">';
										echo '$(document).ready(function()
													{
														$.frm_elem_color("#FACA70","");
														$.guardar_valores("frm_modificar_baner");
													});
												function validar_form(formulario, situacion_temporal)
													{	
														formulario.situacion_temporal.value = situacion_temporal;
														if(formulario.motivo.value == "") 
															{
																alert("'.jv_campo_motivo.'");
																formulario.motivo.focus(); 	
																return false;
															}
														separador = "/";
														fecha_ini = formulario.dia_i.value+"/"+formulario.mes_i.value+"/"+formulario.ano_i.value;
														fecha_fin = formulario.dia_t.value+"/"+formulario.mes_t.value+"/"+formulario.ano_t.value;
														if(!Comparar_Fecha(fecha_ini, fecha_fin))
															{
																alert("'.comparar_fecha_veri.'");
																formulario.dia_i.focus(); 
																return false;
															}
														if(!verificar_fecha(fecha_ini, separador))
															{
																alert("'.verificar_fecha_ini.'");
																formulario.dia_i.focus(); 
																return false;
															}
														if(!verificar_fecha(fecha_fin, separador))
															{
																alert("'.verificar_fecha_fin.'");
																formulario.dia_t.focus(); 
																return false;
															}
														if(formulario.nombre_baner.value == "") 
															{
																alert("'.bl_js_13.'");
																formulario.nombre_baner.focus();
																return false;
															}
															
														if(formulario.orden.value == "") 
															{
																alert("'.bl_js_14.'")
																formulario.orden.focus();
																return false;
															}	
														if(formulario.descripcion.value == "") 
															{
																alert("'.bl_js_15.'");
																formulario.descripcion.focus();	
																return false;
															}
															
														valor_enlace = FCKeditorAPI.__Instances[\'enlace\'].GetHTML();
														formulario.enlace.value = valor_enlace; 
														if(formulario.enlace.value == "") 
															{
																alert("'.bl_js_16.'");
																location.href="#enlace_link";	
																return false;
															}	
														formulario.btn_guardar1.style.visibility="hidden";
													';
												if($nivel == "1" or $nivel == "2")
													{
												echo 'formulario.btn_guardar2.style.visibility="hidden";';
													}
												echo '}';
											echo '</script>';
										echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_baner_lateral"/>';
											echo '<input type="hidden" name="metodo" value = "modificar" />';	
											echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';	
											echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
										echo '</form>';	
										echo '<form name="frm_modificar_baner" id="frm_modificar_baner" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
											echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
												echo '<tr>';
													echo '<td>'.persona_cambio.'</td>';
													echo '<td><input type = "text" name = "nombre" size = "60" /></td>';
												echo '</tr>';
												echo '<tr>';
													echo '<td>'.correo_cambio.'</td>';
													echo '<td><input type = "text" name = "correo" size = "60" /></td>';
												echo '</tr>';
												echo '<tr><td width="500">'.motivo_cambio.'</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
												echo '<tr><td>'.fecha_ini_vig.'</td><td>';
														$areglo_meses = FunGral::MesesNumero();
														echo dia.'&nbsp;<select name ="dia_i">';
														for ($a = 1; $a<=31; $a++)
															{
																echo "<option value = \"$a\" "; if ($dia_i == $a) { echo 'selected'; } echo " > $a </option>";
															}
														echo '</select>&nbsp;';
														echo mes.'&nbsp;<select name = "mes_i">';
															for ($b=1; $b<=12; $b++)
																{
																	echo "<option value = \"$b\"  "; if ($mes_i == $b) {echo ' selected ';} echo " >". $areglo_meses[$b] ."</option>";
																}
														echo '</select>&nbsp;';
														echo ano.'&nbsp;<select name = "ano_i">';
															for ($b=$ano_i-10; $b<=$ano_i+10; $b++)
																{
																	echo "<option value = \"$b\" "; if ($ano_i == $b) {echo ' selected ';} echo "> $b</option>";
																}
														echo '</select>';
													echo '</td>';
												echo '</tr>';
												echo '<tr><td>'.fecha_fin_vig.'</td><td>';
														echo dia.'&nbsp;<select name = "dia_t">';
														for ($a = 1; $a<=31; $a++)
															{
																echo "<option value = \"$a\" "; if ($dia_t == $a) { echo 'selected'; } echo ' >'.$a.'</option>';
															}
														echo '</select>&nbsp;';
														echo mes.'&nbsp;<select name = "mes_t">';
															for ($b=1; $b<=12; $b++)
																{
																	echo "<option value = \"$b\"  "; if ($mes_t == $b) {echo ' selected ';} echo ' >'.$areglo_meses[$b] ."</option>";
																}
														echo '</select>&nbsp;';
														echo ano.'&nbsp;<select name = "ano_t">';
															for ($b=$ano_t-10; $b<=$ano_t+10; $b++)
																{
																	echo "<option value = \"$b\" "; if ($ano_t == $b) {echo ' selected ';} echo "> $b</option>";
																}
														echo '</select>';
													echo '</td>';
												echo '</tr>';
												echo '<tr><td>'.bl_txt_nom_bann.'</td><td>';
														echo '<input type = "text" name = "nombre_baner" size = "50" value ="'.$nombre.'" />';
													echo '</td>';
												echo '</tr>';
												echo '<tr><td>'.bl_txt_ord_apa.'</td><td>';
														echo '<input type = "text" name = "orden" size ="5" value ="'.$orden.'" OnKeyPress="return solo_num(event)" title ="'.tit_solo_numeros.'"/>';
													echo '</td>';
												echo '</tr>';
												echo '<tr><td>'.situacion.'</td><td>';
														echo '<select name = "situacion">';
															echo '<option value = "activo"  '; if ($situacion == "activo") { echo 'selected'; } echo ' >'.activo.'</option>';
															echo '<option value = "cancelado"  '; if ($situacion == "cancelado") { echo 'selected'; } echo '  >'.cancelado.'</option>';
														echo '</select>';
													echo '</td>';
												echo '</tr>';
												echo '<tr><td>'.bl_txt_des_ban.'</td><td>';
														echo '<textarea name="descripcion" cols="50" rows="5">'.$descripcion.'</textarea>';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
											echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
												echo '<tr><td>'.bl_txt_cue_ban.'</td></tr>';
												echo '<tr>';
													echo '<td>';
														echo '<a name="enlace_link" id="enlace_link"></a>';
														$oFCKeditor = new FCKeditor('enlace') ;
														$oFCKeditor->BasePath = '../librerias/fckeditor/';		
														$oFCKeditor->ToolbarSet = 'Default';
														$oFCKeditor->Value = $enlace;
														$oFCKeditor->Width = "100%";
														$oFCKeditor->Height = "350";	
														$oFCKeditor->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
														$oFCKeditor->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
														$oFCKeditor->Config['EnterMode'] = 'br';
														$oFCKeditor->Create();
													echo '</td>';
												echo '</tr>';
											echo '</table>';
											echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
											echo '<input type="hidden" name="metodo" value = "modificar" />';
											echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
											echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
											echo '<input type="hidden" name="guardar" value = "si" />';	
											echo '<input type="hidden" name="situacion_temporal" value = "pendiente" />';
											echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
												echo '<tr>';
													echo '<td align ="center">';
														echo '<input type="submit"  name="btn_guardar1" value="'.guardar_cambio.'"  onclick= "return validar_form(this.form,\'pendiente\')" />';
													echo '</td>';
													if($nivel == "1" or $nivel == "2")
														{	echo '<td align ="center">';
																echo '<input type="submit" name="btn_guardar2" value="'.guardar_cam_pub.'"  onclick= "return validar_form(this.form,\'activo\')" />';
															echo '</td>';
														}
												echo '</tr>';
											echo '</table>';
										echo '</form>';	
										HtmlAdmon::div_res_oper(array());
										echo '<form name="reg_buscador" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
											echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
												echo '<tr>';
													echo '<td align="center">';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
														echo '<input type="hidden" name="metodo" value = "modificar" />';
														echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';
														echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';	
														echo '<a href="javascript:document.reg_buscador.submit()" class="regresar">';
														echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
														echo '<strong>'.bl_txt_reg_lis_ban.'</strong></a>';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
										echo '</form>';
									}
							}
						else
							{
								$clave_modulo =  $_POST["clave_modulo"];
								$conexion = $this->conectarse();
								$res_conf = mysql_query("select clave_baner_configuracion from nazep_zmod_baner_configuracion where clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada' ");
								$ren_conf = mysql_fetch_array($res_conf);
								$clave_baner_configuracion = $ren_conf["clave_baner_configuracion"];
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion(bl_txt_tit_lis_ban." \"$nombre\"");	
								$consu_baner_total = "select clave_baner from nazep_zmod_baner where clave_baner_configuracion = '$clave_baner_configuracion'";
								$res_con_total = mysql_query($consu_baner_total);
								$cantidad_baners = mysql_num_rows($res_con_total);
								$cantidad_mostrar = 10;
								$pag_post = (isset($_POST["pag"]))?$_POST["pag"]:'';
								if($pag_post=='')
									{
										$pag = 1;
										$ini = 0;
									}
								else
									{
										$pag = $_POST["pag"];
										$ini = ($pag-1)*$cantidad_mostrar;
									}
								$total_paginas = ceil($cantidad_baners/$cantidad_mostrar);
								$consu_baner_total = "select clave_baner, situacion, nombre, fecha_creacion from nazep_zmod_baner
								where clave_baner_configuracion = '$clave_baner_configuracion ' order by fecha_creacion desc, hora_creacion desc
								limit $ini, $cantidad_mostrar";
								$res_ban_total = mysql_query($consu_baner_total);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><strong>'.bl_txt_nom_bann.'</strong></td>';
										echo '<td align = "center"><strong>'.fec_elabo.'</strong></td>';
										echo '<td align = "center"><strong>'.situacion.'</strong></td>';
										echo '<td align = "center"><strong>'.modificar.'</strong></td>';
									echo '</tr>';
									$contador = 0;
									while($ren = mysql_fetch_array($res_ban_total))
										{
											if(($contador%2)==0)
												{$color = 'bgcolor="#F9D07B"';}
											else
												{$color = '';}
											$clave_baner = $ren["clave_baner"];
											$situacion = $ren["situacion"];
											$nombre = stripslashes($ren["nombre"]);
											$fecha_creacion = $ren["fecha_creacion"];
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td '.$color.'>'.$fecha_creacion.'</td>';
												echo '<td '.$color.'>'.$situacion.'</td>';
												echo '<td align = "center" '.$color.'>';
													echo '<form name="mod_baner_lateral_'.$clave_baner.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
														echo '<input type="hidden" name="metodo" value = "modificar" />';	
														echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
														echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
														echo '<input type="Submit"  name="Submit" value="'.modificar.'" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															echo '<form name="pag_ban_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
																echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
																echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
																echo '<input type="hidden" name="metodo" value = "modificar" />';
																echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
																echo '<input type="hidden" name="pag" value = "'.$a.'" />';
															echo '</form>';
														}
												}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align = "center">';		
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															if($pag == $a)
																{ echo '<b>'.$a.'</b>'; }
															else
																{ echo '<a href="javascript:document.pag_ban_'.$a.'.submit()">'.$a.'</a>';}
														}
												}
										echo '</td>';
									echo '</tr>';
								echo '</table>';
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
							}
					}
			}
// ------------------------------ Fin de funciones para controlar la modificaci�n de la informaci�n del m�dulo
// ------------------------------ Inicio de funciones para controlar los cambios de la informaci�n del m�dulo
		function nuevo_pendiente($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_baners_cambios = $_POST["clave_baners_cambios"];
						$clave_baner = $_POST["clave_baner"];
						$publicar = $_POST["publicar"];
						$motivo = $_POST["motivo"];
						$motivo = strip_tags($motivo);
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						$clave_seccion = $_POST["clave_seccion"];
						if($correo=="")
							{$correo = $cor_user;}
						if($nombre=="")
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$update1 = "update nazep_zmod_baner_cambios
						set situacion = '$publicar', nick_user_decide = '$nick_user', ip_decide= '$ip', fecha_decide = '$fecha_hoy',
						hora_decide = '$hora_hoy', motivo_decide = '$motivo', nombre_decide = '$nombre',
						correo_decide = '$correo'
						where clave_baners_cambios = '$clave_baners_cambios' and clave_baner = '$clave_baner'";
						$update2 = "update nazep_zmod_baner set
						situacion = '$publicar', user_actualizacion = '$nick_user', ip_actualizacion = '$ip',
						fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy'
						where clave_baner = '$clave_baner'";
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($update1))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;
								if (!@mysql_query($update2))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}
								else
									{$paso = true;}
							}
						if($paso)
							{
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";	
							}
						else
							{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";	}
						$this->desconectarse($conexion);
					}
				else
					{
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						if(isset($_POST["clave_baners_cambios"]) && $_POST["clave_baners_cambios"]!="")
							{
								$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
								$clave_baners_cambios = $_POST["clave_baners_cambios"];
								$clave_baner = $_POST["clave_baner"];
								$con_elemento = "select nick_user_propone, fecha_propone, hora_propone, nuevo_nombre, nuevo_orden, 
								nuevo_situacion, nuevo_descripcion, nuevo_enlace, nuevo_fecha_inicio, nuevo_fecha_fin,
								nombre_propone, correo_proponefrom nazep_zmod_baner_cambios
								where clave_baners_cambios = '$clave_baners_cambios'  and clave_baner= '$clave_baner' and situacion = 'nuevo'";
								$conexion = $this->conectarse();
								$res_con_elemento = mysql_query($con_elemento);
								$ren_con_elemento = mysql_fetch_array($res_con_elemento);
								$nick_user_propone = $ren_con_elemento["nick_user_propone"];
								$fecha_propone = $ren_con_elemento["fecha_propone"];
								$fecha_propone  = FunGral::FechaNormal($fecha_propone);
								$hora_propone = $ren_con_elemento["hora_propone"];
								$nuevo_nombre = $ren_con_elemento["nuevo_nombre"];
								$nuevo_orden = $ren_con_elemento["nuevo_orden"];
								$nuevo_situacion = $ren_con_elemento["nuevo_situacion"];
								$nuevo_descripcion = $ren_con_elemento["nuevo_descripcion"];
								$nuevo_enlace = stripslashes($ren_con_elemento["nuevo_enlace"]);
								$nuevo_fecha_inicio = $ren_con_elemento["nuevo_fecha_inicio"];
								$nuevo_fecha_fin = $ren_con_elemento["nuevo_fecha_fin"];
								$nuevo_fecha_inicio  = FunGral::FechaNormal($nuevo_fecha_inicio);
								$nuevo_fecha_fin  = FunGral::FechaNormal($nuevo_fecha_fin);
								$nombre_propone = $ren_con_elemento["nombre_propone"];
								$correo_propone = $ren_con_elemento["correo_propone"];
								HtmlAdmon::titulo_seccion("Banner nuevo por autorizar");	
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td>Usuario que propone el banner</td><td width="480">'.$nick_user_propone.'</td></tr>';
									echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
									echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
									echo '<tr><td>Fecha realizado</td><td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td></tr>';
									echo '<tr><td>Nombre del banner</td><td>'.$nuevo_nombre.'</td></tr>';
									echo '<tr><td>Orden de aparici&oacute;n del banner</td><td>'.$nuevo_orden.'</td></tr>';
									echo '<tr><td>Situaci&oacute;n propuesta</td><td>'.$nuevo_situacion.'</td></tr>';
									echo '<tr><td>Descripci&oacute;n</td><td>'.$nuevo_descripcion.'</td></tr>';
									echo '<tr><td>Banner propuesto</td><td>'.$nuevo_enlace.'</td></tr>';
									echo '<tr><td>Fecha inicia vigencia</td><td>'.$nuevo_fecha_inicio.'</td></tr>';
									echo '<tr><td>Fecha termina vigencia</td><td>'.$nuevo_fecha_fin.'</td></tr>';
								echo '</table>';	
								echo '<script type="text/javascript">';
								echo '$(document).ready(function()
											{
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("frm_guardar_desicion");
											});
										function validar_form(formulario)
											{
												if(formulario.motivo.value == "") 
													{
														alert("El campo del motivo no puede quedar vac\u00EDo");
														formulario.motivo.focus();	
														return false
													}
												formulario.btn_guardar.style.visibility="hidden";	
												
											}';
								echo '</script>';	
								echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_baner_lateral"/>';
									echo '<input type="hidden" name="metodo" value = "nuevo_pendiente" />';
								echo '</form>';	
								echo '<form name="frm_guardar_desicion" id="frm_guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>Persona que toma la decisi&oacute;n</td><td><input type = "text" name = "nombre" size = "60" /></td></tr>';
										echo '<tr><td>Correo electr&oacute;nico del que decide</td><td><input type = "text" name = "correo" size = "60" /></td></tr>';
										echo '<tr>';
											echo '<td>&iquest;Publicar el banner?</td>';
											echo '<td>';
												echo '<select name = "publicar">';
													echo '<option value = "activo">'.si.'</option>';
													echo '<option value = "cancelado">'.no.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td width="600">Motivo de la decisi&oacute;n</td>';
											echo '<td><textarea name="motivo" cols="50" rows="5"></textarea></td>';
										echo '</tr>';
										echo '<tr><td>&nbsp;</td><td>';
												echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
												echo '<input type="hidden" name="metodo" value = "nuevo_pendiente" />';
												echo '<input type="hidden" name="clave_baners_cambios" value = "'.$clave_baners_cambios.'" />';
												echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
												echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="submit"  name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form><br />';
								HtmlAdmon::div_res_oper(array());
								echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
												echo '<input type="hidden" name="metodo" value = "nuevo_pendiente" />';	
												echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
												echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
												echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
												echo '<strong>Regresar al listado de nuevos banners</strong></a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
								$con_nue = "select b.nombre, b.fecha_creacion, b.clave_baner, bc.clave_baners_cambios, b.hora_creacion
								from nazep_zmod_baner b, nazep_zmod_baner_cambios bc 
								where b.clave_baner = bc.clave_baner and b.clave_baner_configuracion = '$clave_baner_configuracion' and
								bc.situacion = 'nuevo' ";
								$conexion = $this->conectarse();
								$res_con_nue = mysql_query($con_nue);
								$cantidad = mysql_num_rows($res_con_nue);
								HtmlAdmon::titulo_seccion("($cantidad) Nuevo(s) Banner(s) para la Secci&oacute;n \"$nombre\"");
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><b>Nombre del banner</b></td>';
										echo '<td align = "center"><b>Fecha de propuesta</b></td>';
										echo '<td align = "center"><b>Ver banner</b></td>';
									echo '</tr>';
									$contador = 0;
									while($ren_con_nue = mysql_fetch_array($res_con_nue))
										{
											if(($contador%2)==0)
												{$color = 'bgcolor="#F9D07B"';}
											else
												{$color = '';}
											$nombre = $ren_con_nue["nombre"];
											$fecha_creacion = $ren_con_nue["fecha_creacion"];
											$hora_creacion = $ren_con_nue["hora_creacion"];
											$fecha_creacion  = FunGral::FechaNormal($fecha_creacion);
											$clave_baner = $ren_con_nue["clave_baner"];
											$clave_baners_cambios = $ren_con_nue["clave_baners_cambios"];
											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td align = "center" '.$color.' >';
													echo "$fecha_creacion a las $hora_creacion hrs.";
												echo '</td>';
												echo '<td align = "center" '.$color.'>';
													echo '<form name="mod_baner_lateral_'.$clave_baner.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
														echo '<input type="hidden" name="metodo" value = "nuevo_pendiente" />';
														echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
														echo '<input type="hidden" name="clave_baners_cambios" value = "'.$clave_baners_cambios.'" />';
														echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
														echo '<input type="submit" name="Submit" value="Ver banner" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table><br />';
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));
							}
					}
			}
		function cambios_pendientes($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user) 
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$publicar = $_POST["publicar"];
						$motivo = $_POST["motivo"];
						$motivo = strip_tags($motivo);
						$clave_baners_cambios = $_POST["clave_baners_cambios"];
						$clave_baner = $_POST["clave_baner"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=="")
							{$correo = $cor_user;}
						if($nombre=="")
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$update_1 = "update nazep_zmod_baner_cambios
						set situacion = '$publicar', nick_user_decide = '$nick_user', fecha_decide = '$fecha_hoy',
						hora_decide = '$hora_hoy', ip_decide = '$ip', motivo_decide = '$motivo',
						nombre_decide = '$nombre', correo_decide = '$correo'
						where clave_baners_cambios= '$clave_baners_cambios'";
						$update_2 = "update nazep_zmod_baner b, nazep_zmod_baner_cambios bc
						set  b.user_actualizacion = '$nick_user', b.ip_actualizacion = '$ip', b.fecha_actualizacion = '$fecha_hoy',
						b.hora_actualizacion = '$hora_hoy', b.situacion = bc.nuevo_situacion, b.nombre = bc.nuevo_nombre, b.orden = bc.nuevo_orden, 
						b.descripcion = bc.nuevo_descripcion, b.enlace = bc.nuevo_enlace
						where b.clave_baner= '$clave_baner' and bc.clave_baners_cambios = '$clave_baners_cambios'";
						if($publicar == "cancelado")
							{
								$conexion = $this->conectarse();
								if (!@mysql_query($update_1))
									{
										$men = mysql_error();
										$error = 1;
										echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
									}
								else
									{echo "termino-,*-$formulario_final";}
								$this->desconectarse($conexion);
							}
						else
							{
								$conexion = $this->conectarse();
								mysql_query("START TRANSACTION;");
								if (!@mysql_query($update_1))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 1;
									}
								else
									{
										$paso = true;
										if (!@mysql_query($update_2))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 2;
											}
										else
											{$paso = true;}
									}	
								if($paso)
									{
										mysql_query("COMMIT;");
										echo "termino-,*-$formulario_final";
									}
								else
									{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
							}
					}
				else
					{
						if(( isset($_POST["clave_baner"]) && isset($_POST["clave_baners_cambios"])) &&  ($_POST["clave_baner"]!="" and $_POST["clave_baners_cambios"]!=""))
							{
								$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
								$clave_baner = $_POST["clave_baner"];	
								$clave_baners_cambios = $_POST["clave_baners_cambios"];
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Cambio al banner de la secci&oacute;n \"$nombre\"");
								$con_baner = "select nick_user_propone, fecha_propone, hora_propone, motivo_propone,
								nombre_propone, correo_propone,
								nuevo_nombre, nuevo_orden, nuevo_situacion, nuevo_descripcion, nuevo_enlace, 
								nuevo_fecha_inicio, nuevo_fecha_fin, anterior_nombre, anterior_orden, anterior_situacion, anterior_descripcion, anterior_enlace,
								anterior_fecha_inicio, anterior_fecha_fin from nazep_zmod_baner_cambios
								where clave_baners_cambios = '$clave_baners_cambios'  and clave_baner= '$clave_baner' and situacion = 'pendiente'";
								$conexion = $this->conectarse();
								$res_con_baner = mysql_query($con_baner);
								$ren_con_baner = mysql_fetch_array($res_con_baner);
								$nick_user_propone = $ren_con_baner["nick_user_propone"];
								$fecha_propone = $ren_con_baner["fecha_propone"];
								$fecha_propone  = FunGral::FechaNormal($fecha_propone);
								$hora_propone = $ren_con_baner["hora_propone"];
								$nuevo_nombre = $ren_con_baner["nuevo_nombre"];
								$nuevo_orden = $ren_con_baner["nuevo_orden"];
								$nuevo_situacion = $ren_con_baner["nuevo_situacion"];
								$nuevo_descripcion = $ren_con_baner["nuevo_descripcion"];
								$nuevo_enlace = stripslashes($ren_con_baner["nuevo_enlace"]);
								$nuevo_fecha_inicio_or = $ren_con_baner["nuevo_fecha_inicio"];
								$nuevo_fecha_fin_or = $ren_con_baner["nuevo_fecha_fin"];
								$motivo_propone = $ren_con_baner["motivo_propone"];
								$anterior_nombre = $ren_con_baner["anterior_nombre"];
								$anterior_orden = $ren_con_baner["anterior_orden"];
								$anterior_situacion = $ren_con_baner["anterior_situacion"];
								$anterior_descripcion = $ren_con_baner["anterior_descripcion"];
								$anterior_enlace = stripslashes($ren_con_baner["anterior_enlace"]);
								$anterior_fecha_inicio = $ren_con_baner["anterior_fecha_inicio"];
								$anterior_fecha_fin = $ren_con_baner["anterior_fecha_fin"];
								$nuevo_fecha_inicio  = FunGral::FechaNormal($nuevo_fecha_inicio_or);
								$nuevo_fecha_fin  = FunGral::FechaNormal($nuevo_fecha_fin_or);
								$anterior_fecha_inicio  = FunGral::FechaNormal($anterior_fecha_inicio);
								$anterior_fecha_fin  = FunGral::FechaNormal($anterior_fecha_fin);
								$nombre_propone = $ren_con_baner["nombre_propone"];
								$correo_propone = $ren_con_baner["correo_propone"];
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td>Usuario que propone</td><td>'.$nick_user_propone.'</td></tr>';
									echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
									echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
									echo '<tr><td>Fecha realizado</td><td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td></tr>';
									echo '<tr><td>Motivo del cambio</td><td>'.$motivo_propone.'</td></tr>';	
									echo '<tr><td><hr /></td><td><hr /></td></tr>';
									echo '<tr><td>Nuevo Nombre</td><td>'.$nuevo_nombre.'</td></tr>';
									echo '<tr><td>Nuevo Orden</td><td>'.$nuevo_orden.'</td></tr>';
									echo '<tr><td>Nueva Situaci&oacute;n</td><td>'.$nuevo_situacion.'</td></tr>';
									echo '<tr><td>Nueva Descripci&oacute;n</td><td>'.$nuevo_descripcion.'</td></tr>';
									echo '<tr><td>Nuevo Banner</td><td>'.$nuevo_enlace.'</td></tr>';
									echo '<tr><td>Nueva Fecha inicia vigencia</td><td>'.$nuevo_fecha_inicio.'</td></tr>';
									echo '<tr><td>Nueva Fecha termina vigencia</td><td>'.$nuevo_fecha_fin.'</td></tr>';
									echo '<tr><td><hr /></td><td><hr /></td></tr>';
									echo '<tr><td>Anterior Nombre</td><td>'.$anterior_nombre.'</td></tr>';
									echo '<tr><td>Anterior Orden</td><td>'.$anterior_orden.'</td></tr>';
									echo '<tr><td>Anterior Situaci&oacute;n</td><td>'.$anterior_situacion.'</td></tr>';
									echo '<tr><td>Anterior Descripci&oacute;n</td><td>'.$anterior_descripcion.'</td></tr>';
									echo '<tr><td>Anterior Banner</td><td>'.$anterior_enlace.'</td></tr>';
									echo '<tr><td>Anterior Fecha inicia vigencia</td><td>'.$anterior_fecha_inicio.'</td></tr>';
									echo '<tr><td>Anterior Fecha termina vigencia</td><td>'.$anterior_fecha_fin.'</td></tr>';
								echo '</table>';
								echo '<script type="text/javascript">';
								echo '$(document).ready(function()
											{									
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("frm_guardar_desicion");
											});								
										function validar_form(formulario)
											{
												if(formulario.motivo.value == "") 
													{
														alert("El campo del motivo no puede quedar vac\u00EDo");
														formulario.motivo.focus(); 	
														return false;
													}	
												formulario.btn_guardar.style.visibility="hidden";	
											}';
								echo '</script>';	
								echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_baner_lateral"/>';
									echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';
								echo '</form>';	
								echo '<form name="frm_guardar_desicion" id="frm_guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero"  >';
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>Persona que toma la decisi&oacute;n</td><td><input type = "text" name = "nombre" size="60" /></td></tr>';
										echo '<tr><td>Correo electr&oacute;nico del que decide</td><td><input type = "text" name = "correo" size = "60" /></td></tr>';
										echo '<tr><td>&iquest;Aplicar el cambio?</td>';
											echo '<td>';
												echo '<select name = "publicar">';
													echo '<option value = "activo">'.si.'</option>';
													echo '<option value = "cancelado">'.no.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td width="600">Motivo de la decisi&oacute;n</td>';
											echo '<td><textarea name="motivo" cols="50" rows="5"></textarea></td>';
										echo '</tr>';
										echo '<tr><td>&nbsp;</td>';
											echo '<td>';
												echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
												echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';
												echo '<input type="hidden" name="clave_baners_cambios" value = "'.$clave_baners_cambios.'" />';
												echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="submit"  name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form><br/>';
								HtmlAdmon::div_res_oper(array());
								echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
												echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';
												echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
												echo '<input type="hidden" name="clave_baner_configuracion" value ="'.$clave_baner_configuracion.'" />';
												echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
												echo '<strong>Regresar al listado de banners con cambios pendientes</strong></a>';
												echo '';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
								$consu_baner_total = "select b.clave_baner
								from nazep_zmod_baner b, nazep_zmod_baner_cambios  bc
								where b.clave_baner_configuracion = '$clave_baner_configuracion' and  b.clave_baner = bc.clave_baner
								and bc.situacion = 'pendiente'";
								$conexion = $this->conectarse();
								$res_con_total = mysql_query($consu_baner_total);
								$cantidad_baners = mysql_num_rows($res_con_total);
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("($cantidad_baners) Banner(s) con cambios pendientes por decidir la secci&oacute;n \"$nombre\"");
								$cantidad_mostrar = 10;
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
								$total_paginas = ceil($cantidad_baners/$cantidad_mostrar);
								$consu_baner_total = "select b.clave_baner, b.nombre, b.fecha_creacion, bc.fecha_propone, bc.clave_baners_cambios
								from nazep_zmod_baner b, nazep_zmod_baner_cambios  bc
								where b.clave_baner_configuracion = '$clave_baner_configuracion ' 
								and b.clave_baner = bc.clave_baner and bc.situacion = 'pendiente'
								order by b.fecha_creacion
								limit $ini, $cantidad_mostrar";
								$res_ban_total = mysql_query($consu_baner_total);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><b>Nombre del banner</b></td>';
										echo '<td align = "center"><b>Fecha de elaboraci&oacute;n</b></td>';
										echo '<td align = "center"><b>Fecha del cambio</b></td>';
										echo '<td align = "center"><b>Ver cambio</b></td>';
									echo '</tr>';
									$contador = 0;
									while($ren = mysql_fetch_array($res_ban_total))
										{
											if(($contador%2)=="0")
												{$color = 'bgcolor="#F9D07B"';	}
											else
												{$color = '';}
											$clave_baner = $ren["clave_baner"];
											$nombre = $ren["nombre"];
											$fecha_creacion = $ren["fecha_creacion"];
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											$fecha_propone = $ren["fecha_propone"];
											$fecha_propone = FunGral::FechaNormal($fecha_propone);
											$clave_baners_cambios = $ren["clave_baners_cambios"];
											echo '<tr><td '.$color.'>'.$nombre.'</td>';
												echo '<td '.$color.'>'.$fecha_creacion.'</td>';
												echo '<td '.$color.'>'.$fecha_propone.'</td>';
												echo '<td align = "center" '.$color.'>';
													echo '<form name="mod_baner_lateral_'.$clave_baner.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
														echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';	
														echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
														echo '<input type="hidden" name="clave_baners_cambios" value = "'.$clave_baners_cambios.'" />';
														echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
														echo '<input type="submit" name="Submit" value="Ver cambio" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															echo '<form name="pag_ban_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
																echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
																echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
																echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';
																echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
																echo '<input type="hidden" name="pag" value = "'.$a.'" />';
															echo '</form>';
														}
												}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align = "center">';		
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															if($pag == $a)
																{echo '<strong>'.$a.'</strong>';}
															else
																{echo '<a href="javascript:document.pag_ban_'.$a.'.submit()">'.$a.'</a>';}
														}
												}
										echo '</td>';
									echo '</tr>';
								echo '</table>';
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));
							}
					}
			}			
		function cambios_realizados($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["clave_baners_cambios"]) &&  $_POST["clave_baners_cambios"]!="")
					{
						$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
						$clave_baners_cambios = $_POST["clave_baners_cambios"];
						$nombre = $_POST["nombre"];
						$clave_baner = $_POST["clave_baner"];
						$con_baner = "select nick_user_propone, fecha_propone, hora_propone, motivo_propone,
						nombre_propone, correo_propone,  nick_user_decide, fecha_decide, hora_decide, motivo_decide,
						nombre_decide, correo_decide,  nuevo_nombre, nuevo_orden, nuevo_situacion, nuevo_descripcion, nuevo_enlace,  nuevo_fecha_inicio, nuevo_fecha_fin,
						anterior_nombre, anterior_orden, anterior_situacion, anterior_descripcion, anterior_enlace,
						anterior_fecha_inicio, anterior_fecha_fin, situacion from nazep_zmod_baner_cambios where clave_baners_cambios = '$clave_baners_cambios'";
						$conexion = $this->conectarse();
						$res_con_baner = mysql_query($con_baner);
						$ren_con_baner = mysql_fetch_array($res_con_baner);
						$nick_user_propone = $ren_con_baner["nick_user_propone"];
						$fecha_propone = $ren_con_baner["fecha_propone"];
						$fecha_propone  = FunGral::FechaNormal($fecha_propone);
						$hora_propone = $ren_con_baner["hora_propone"];
						$nick_user_decide = $ren_con_baner["nick_user_decide"];
						$fecha_decide = $ren_con_baner["fecha_decide"];
						$fecha_decide = FunGral::FechaNormal($fecha_decide);
						$hora_decide = $ren_con_baner["hora_decide"];
						$motivo_decide = $ren_con_baner["motivo_decide"];
						$nuevo_nombre = $ren_con_baner["nuevo_nombre"];
						$nuevo_orden = $ren_con_baner["nuevo_orden"];
						$nuevo_situacion = $ren_con_baner["nuevo_situacion"];
						$nuevo_descripcion = $ren_con_baner["nuevo_descripcion"];
						$nuevo_enlace = stripslashes($ren_con_baner["nuevo_enlace"]);
						$nuevo_fecha_inicio_or = $ren_con_baner["nuevo_fecha_inicio"];
						$nuevo_fecha_fin_or = $ren_con_baner["nuevo_fecha_fin"];
						$motivo_propone = $ren_con_baner["motivo_propone"];
						$anterior_nombre = $ren_con_baner["anterior_nombre"];
						$anterior_orden = $ren_con_baner["anterior_orden"];
						$anterior_situacion = $ren_con_baner["anterior_situacion"];
						$anterior_descripcion = $ren_con_baner["anterior_descripcion"];
						$anterior_enlace = stripslashes($ren_con_baner["anterior_enlace"]);
						$anterior_fecha_inicio = $ren_con_baner["anterior_fecha_inicio"];
						$anterior_fecha_fin = $ren_con_baner["anterior_fecha_fin"];
						$situacion = $ren_con_baner["situacion"];
						$nombre_propone = $ren_con_baner["nombre_propone"];
						$correo_propone = $ren_con_baner["correo_propone"];	
						$nombre_decide = $ren_con_baner["nombre_decide"];
						$correo_decide = $ren_con_baner["correo_decide"];
						$nuevo_fecha_inicio  = FunGral::FechaNormal($nuevo_fecha_inicio_or);
						$nuevo_fecha_fin  = FunGral::FechaNormal($nuevo_fecha_fin_or);
						$anterior_fecha_inicio  = FunGral::FechaNormal($anterior_fecha_inicio);
						$anterior_fecha_fin  = FunGral::FechaNormal($anterior_fecha_fin);
						HtmlAdmon::titulo_seccion("Cambio al baner: $nombre");
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Situaci&oacute;n del cambio</td><td>'.$situacion.'</td></tr>';
							echo '<tr><td>Usuario que propone</td><td>'.$nick_user_propone.'</td></tr>';	
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha que se propone el cambio</td><td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td></tr>';
							echo '<tr><td>Motivo del cambio</td><td>'.$motivo_propone.'</td></tr>';
							echo '<tr><td>Usuario que decide</td><td>'.$nick_user_decide.'</td></tr>';
							echo '<tr><td>Nombre de persona que decide</td><td>'.$nombre_decide.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que decide</td><td>'.$correo_decide.'</td></tr>';
							echo '<tr><td>Fecha de decisi&oacute;n</td><td>'.$fecha_decide.' a las '.$hora_decide.' hrs.</td></tr>';
							echo '<tr><td>Motivo de la decisi&oacute;n</td><td>'.$motivo_decide.'</td></tr>';
							echo '<tr><td><hr /></td><td><hr /></td></tr>';
							echo '<tr><td>Nuevo Nombre</td><td>'.$nuevo_nombre.'</td></tr>';
							echo '<tr><td>Nuevo Orden</td><td>'.$nuevo_orden.'</td></tr>';
							echo '<tr><td>Nueva Situaci&oacute;n</td><td>'.$nuevo_situacion.'</td></tr>';
							echo '<tr><td>Nueva Descripci&oacute;n</td><td>'.$nuevo_descripcion.'</td></tr>';
							echo '<tr><td>Nuevo Banner</td><td>'.$nuevo_enlace.'</td></tr>';
							echo '<tr><td>Nueva Fecha inicia vigencia</td><td>'.$nuevo_fecha_inicio.'</td></tr>';
							echo '<tr><td>Nueva Fecha termina vigencia</td><td>'.$nuevo_fecha_fin.'</td></tr>';
							echo '<tr><td><hr /></td><td><hr /></td></tr>';
							echo '<tr><td>Anterior Nombre</td><td>'.$anterior_nombre.'</td></tr>';
							echo '<tr><td>Anterior Orden</td><td>'.$anterior_orden.'</td></tr>';
							echo '<tr><td>Anterior Situaci&oacute;n</td><td>'.$anterior_situacion.'</td></tr>';
							echo '<tr><td>Anterior Descripci&oacute;n</td><td>'.$anterior_descripcion.'</td></tr>';
							echo '<tr><td>Anterior Banner</td><td>'.$anterior_enlace.'</td></tr>';
							echo '<tr><td>Anterior Fecha inicia vigencia</td><td>'.$anterior_fecha_inicio.'</td></tr>';
							echo '<tr><td>Anterior Fecha termina vigencia</td><td>'.$anterior_fecha_fin.'</td></tr>';
						echo '</table>';
						echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
										echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
										echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
										echo '<input type="hidden" name="clave_baner_configuracion" value ="'.$clave_baner_configuracion.'" />';
										echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
										echo '<b>Regresar al listado de cambios al Banner</b>';
										echo '</a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
				else
					{
						if(isset($_POST["clave_baner"]) && $_POST["clave_baner"]!="")
							{
								$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
								$nombre = $_POST["nombre"];
								$clave_baner = $_POST["clave_baner"];
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Listado de cambios realizados en el baner: $nombre");
								$consu_baner_total = "select b.clave_baner
								from nazep_zmod_baner b, nazep_zmod_baner_cambios  bc
								where b.clave_baner_configuracion = '$clave_baner_configuracion' and  b.clave_baner = bc.clave_baner and bc.clave_baner = '$clave_baner'";
								$conexion = $this->conectarse();
								$res_con_total = mysql_query($consu_baner_total);
								$cantidad_baners = mysql_num_rows($res_con_total);
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
								$total_paginas = ceil($cantidad_baners/$cantidad_mostrar);
								$consu_baner_total = "select b.clave_baner, b.fecha_creacion, bc.fecha_propone, bc.hora_propone,
								bc.clave_baners_cambios, bc.situacion, bc.fecha_decide, bc.hora_decide
								from nazep_zmod_baner b, nazep_zmod_baner_cambios  bc
								where b.clave_baner_configuracion = '$clave_baner_configuracion '  and b.clave_baner = bc.clave_baner and bc.clave_baner = '$clave_baner'
								order by b.fecha_creacion limit $ini, $cantidad_mostrar";
								$res_ban_total = mysql_query($consu_baner_total);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><b>Fecha del cambio</b></td>';
										echo '<td align = "center"><b>Fecha de la decisi&oacute;n</b></td>';
										echo '<td align = "center"><b>Situaci&oacute;n del cambio</b></td>';
										echo '<td align = "center"><b>Ver cambio</b></td>';
									echo '</tr>';
									$contador = 0;
									while($ren = mysql_fetch_array($res_ban_total))
										{
											$clave_baner = $ren["clave_baner"];
											$situacion = $ren["situacion"];
											$nombre = $ren["nombre"];
											$fecha_creacion = $ren["fecha_creacion"];
											$hora_propone = $ren["hora_propone"];
											$fecha_decide = $ren["fecha_decide"];
											$hora_decide = $ren["hora_decide"];
											$fecha_decide = FunGral::FechaNormal($fecha_decide);
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											$fecha_propone = $ren["fecha_propone"];
											$fecha_propone = FunGral::FechaNormal($fecha_propone);
											$clave_baners_cambios = $ren["clave_baners_cambios"];
											$situacion = $ren["situacion"];
											if(($contador%2)=="0")
												{$color = 'bgcolor="#F9D07B"';}
											else
												{$color = '';}
											echo '<tr>';
												echo '<td '.$color.'>'.$fecha_propone.' <br />a las '.$hora_propone.'</td>';
												echo '<td '.$color.'>'.$fecha_decide.'<br />a las '.$hora_decide.'</td>';
												echo '<td align = "center" '.$color.'>'.$situacion.'</td>';
												echo '<td align = "center" '.$color.'>';
													echo '<form name="cambio_'.$clave_baners_cambios.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
														echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
														echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
														echo '<input type="hidden" name="clave_baner_configuracion" value ="'.$clave_baner_configuracion.'" />';
														echo '<input type="hidden" name="clave_baners_cambios" value = "'.$clave_baners_cambios.'" />';
														echo '<input type="hidden" name="nombre" value = "'.$nombre.'" />';
														echo '<input type="submit" name="Submit" value="Ver cambio" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															echo '<form name="pag_ban_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
																echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
																echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
																echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
																echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
																echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
																echo '<input type="hidden" name="pag" value = "'.$a.'" />';
																echo '<input type="hidden" name="nombre" value = "'.$nombre.'" />';
															echo '</form>';
														}
												}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															if($pag == $a)
																{echo "<strong>$a</strong>";}
															else
																{echo '<a href="javascript:document.pag_ban_'.$a.'.submit()" >'.$a.'</a>';}
														}
												}
										echo '</td>';
									echo '</tr>';
								echo '</table>';
								echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
												echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
												echo '<input type="hidden" name="clave_baner_configuracion" value ="'.$clave_baner_configuracion.'" />';
												echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
												echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<b>Regresar al listado de banners</b>';
												echo '</a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								$clave_baner_configuracion = $_POST["clave_baner_configuracion"];
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Listado de banners de la secci&oacute;n \"$nombre\"");	
								$consu_baner_total = "select clave_baner from nazep_zmod_baner where clave_baner_configuracion = '$clave_baner_configuracion'";
								$conexion = $this->conectarse();
								$res_con_total = mysql_query($consu_baner_total);
								$cantidad_baners = mysql_num_rows($res_con_total);
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
								$total_paginas = ceil($cantidad_baners/$cantidad_mostrar);
								$consu_baner_total = "select clave_baner, situacion, nombre, fecha_creacion
								from nazep_zmod_baner where clave_baner_configuracion = '$clave_baner_configuracion ' order by fecha_creacion
								limit $ini, $cantidad_mostrar";
								$res_ban_total = mysql_query($consu_baner_total);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><strong>Nombre del banner</strong></td>';
										echo '<td align = "center"><strong>Fecha realizado</strong></td>';
										echo '<td align = "center"><strong>Situaci&oacute;n</strong></td>';
										echo '<td align = "center"><strong>Ver cambios realizados</strong></td>';
									echo '</tr>';
									$contador = 0;
									while($ren = mysql_fetch_array($res_ban_total))
										{
											if(($contador%2)=="0")
												{$color = 'bgcolor="#F9D07B"';}
											else
												{$color = '';}
											$clave_baner = $ren["clave_baner"];
											$situacion = $ren["situacion"];
											$nombre = $ren["nombre"];
											$fecha_creacion = $ren["fecha_creacion"];
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td '.$color.'>'.$fecha_creacion.'</td>';
												echo '<td align = "center" '.$color.'>'.$situacion.'</td>';
												echo '<td align = "center" '.$color.'>';
													echo '<form name="baner_'.$clave_baner.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
														echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
														echo '<input type="hidden" name="clave_baner_configuracion" value = "'.$clave_baner_configuracion.'" />';
														echo '<input type="hidden" name="clave_baner" value = "'.$clave_baner.'" />';
														echo '<input type="hidden" name="nombre" value = "'.$nombre.'" />';
														echo '<input type="submit" name="Submit" value="Ver cambios realizados" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															echo '<form name="pag_ban_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
																echo '<input type="hidden" name="archivo" value = "../librerias/modulos/baner_lateral/baner_lateral_admon.php" />';
																echo '<input type="hidden" name="clase" value = "clase_baner_lateral" />';
																echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
																echo '<input type="hidden" name="pag" value = "'.$a.'" />';
															echo '</form>';
														}
												}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															if($pag == $a)
																{ echo '<b>'.$a.'</b>'; }
															else
																{ echo '<a href="javascript:document.pag_ban_'.$a.'.submit()" >'.$a.'</a>'; }
														}
												}
										echo '</td>';
									echo '</tr>';
								echo '</table>';
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));
							}
					}
			}
// ------------------------------ Fin de funciones para controlar los cambios de la informaci�n del m�dulo			
	}
?>