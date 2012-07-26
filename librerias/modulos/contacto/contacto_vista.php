<?php
/*
Sistema: Nazep
Nombre archivo: contacto_vista.php
Función archivo: archivo para controlar la vista final del módulo de contacto
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_contacto extends conexion
	{
		function __construct()
			{
				include('librerias/idiomas/'.FunGral::SaberIdioma().'/contacto.php');
			}	
		function vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario)
			{}	
		function vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$con_confi = 'select * from nazep_zmod_contacto_configuracion';
				$conexion = $this->conectarse();
				$res_con = mysql_query($con_confi);
				$ren_con = mysql_fetch_array($res_con);
				$pedir_tema = $ren_con["pedir_tema"];
				$pedir_nombre_compuesto = $ren_con["pedir_nombre_compuesto"];
				$pedir_nombre_largo = $ren_con["pedir_nombre_largo"];
				$pedir_correo = $ren_con["pedir_correo"];
				$pedir_sitio_web = $ren_con["pedir_sitio_web"];
				$pedir_telefono = $ren_con["pedir_telefono"];
				$pedir_fax = $ren_con["pedir_fax"];
				$pedir_direccion = $ren_con["pedir_direccion"];
				$pedir_pais = $ren_con["pedir_pais"];
				$pedir_mensaje = $ren_con["pedir_mensaje"];
				$enviar_correo = $ren_con["enviar_correo"];
				$correo_recibe = $ren_con["correo_recibe"];
				$nombre_recibe = $ren_con["nombre_recibe"];
				$fecha_hoy = date("Y-m-d");
				$hora_hoy = date("H:i:s");
				$ip = $_SERVER['REMOTE_ADDR'];
				$insert1 = "insert into nazep_zmod_contacto ( clave_contacto, fecha, hora, ip, contestado, ver_acciones ";
				$insert2 = " values ( '', '$fecha_hoy', '$hora_hoy', '$ip', 'no', 'no' ";
				$texto_enviar = '';
				if($pedir_tema == "si")
					{
						$insert1 .= ", clave_contacto_tema ";
						$clave_contacto_tema = $_POST["clave_contacto_tema"];
						$tem_clave_tema = explode("-", $clave_contacto_tema);
						$clave_contacto_tema = $tem_clave_tema[0];
						$nombre_tema = $tem_clave_tema[1];
						$insert2 .= ", '$clave_contacto_tema' ";
						$texto_enviar .= com_txt_pedir_tema.": $nombre_tema<br />";
					}
				if($pedir_nombre_compuesto == "si")
					{
						$insert1 .= ", nombre, ap_pat, ap_mat ";
						$nombre = addslashes($_POST["nombre"]);
						$nombre = strip_tags($nombre);
						$ap_pat = addslashes($_POST["ap_pat"]);
						$ap_pat = strip_tags($ap_pat);
						$ap_mat = addslashes($_POST["ap_mat"]);
						$ap_mat = strip_tags($ap_mat);
						$insert2 .= ", '$nombre', '$ap_pat', '$ap_mat' ";
						$texto_enviar .= com_txt_nombre.": $nombre<br />";
						$texto_enviar .= com_txt_ape_pa.": $ap_pat<br />";
						$texto_enviar .= com_txt_ape_ma.": $ap_mat<br />";
					}
				if($pedir_nombre_largo == "si")
					{
						$insert1 .= ", nombre_completo ";
						$nombre_completo = addslashes($_POST["nombre_completo"]);
						$nombre_completo = strip_tags($nombre_completo);
						$insert2 .= ", '$nombre_completo' ";
						$texto_enviar .= com_txt_pedir_nombre_largo.": $nombre_completo<br />";
					}
				if($pedir_correo == "si")
					{
						$insert1 .= ", correo_electronico ";
						$correo_electronico = $_POST["correo_electronico"];
						$insert2 .= ", '$correo_electronico' ";	
						$texto_enviar .= com_txt_pedir_correo.": $correo_electronico<br />";
					}
				if($pedir_sitio_web == "si")
					{
						$insert1 .= ", sitio_web ";
						$sitio_web = $_POST["sitio_web"];
						$insert2 .= ", '$sitio_web' ";	
						$texto_enviar .= com_txt_pedir_sitio_web.": $sitio_web<br />";
					}
				if($pedir_telefono == "si")
					{
						$insert1 .= ", telefono ";
						$telefono = $_POST["telefono"];
						$insert2 .= ", '$telefono' ";
						$texto_enviar .= com_txt_pedir_telefono.": $telefono<br />";
					}
				if($pedir_fax == "si")
					{
						$insert1 .= ", fax ";
						$fax = $_POST["fax"];
						$insert2 .= ", '$fax' ";	
						$texto_enviar .= com_txt_pedir_fax.": $fax<br />";
					}	
				if($pedir_direccion == "si")
					{
						$insert1 .= ", direccion ";
						$direccion = addslashes($_POST["direccion"]);
						$direccion = strip_tags($direccion);
						$insert2 .= ", '$direccion' ";	
						$texto_enviar .= com_txt_pedir_direccion.": $direccion<br />";
					}
				if($pedir_pais == "si")
					{
						$insert1 .= ", clave_pais ";
						$clave_pais = $_POST["clave_pais"];
						$tem_clave_pais = explode("-", $clave_pais);
						$clave_pais = $tem_clave_pais[0];
						$nombre_pais =  $tem_clave_pais[1];
						$insert2 .= ", '$clave_pais' ";
						$texto_enviar .= com_txt_pedir_pais.": $nombre_pais<br />";
					}
				if($pedir_mensaje == "si")
					{
						$insert1 .= ", mensaje ";
						$mensaje = addslashes($_POST["mensaje"]);
						$mensaje = strip_tags($mensaje);
						$insert2 .= ", '$mensaje' ";
						$texto_enviar .= com_txt_pedir_mensaje.": $mensaje<br />";
					}
				$insert1 .= ' ) ';
				$insert2 .= ')';
				$total_insert = $insert1.$insert2;
				if (!@mysql_query($total_insert))
					{
						$paso = false;
						$men = 2;
					}
				else
					{
						$paso = true;
						$men = 1;
					}
				if($enviar_correo == "si")
					{
						if($paso == true)
							{
								$con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp from nazep_configuracion";
								$conexion = $this->conectarse();
								$res_con = mysql_query($con_conf);
								$ren_con = mysql_fetch_array($res_con);
								$envio_correo = $ren_con["envio_correo"];
								$servidor_smtp = $ren_con["servidor_smtp"];
								$user_smtp = $ren_con["user_smtp"];
								$pass_smtp	= $ren_con["pass_smtp"];
								$con_usar_admin ="select nombre, email from nazep_usuarios_admon  where nick_user = 'admin'";
								$res_con_u = mysql_query($con_usar_admin);
								$ren_con_u = mysql_fetch_array($res_con_u);
								$nombre = $ren_con_u["nombre"];
								$email = $ren_con_u["email"];
								require("librerias/phpmailer/class.phpmailer.php");
								$mail = new PHPMailer ();
								$mail->SetLanguage("es","librerias/phpmailer/language/");
								if($envio_correo =="smtp")
									{
										$mail->IsSMTP();
										$mail->Host = $servidor_smtp;
										$mail->SMTPAuth = true;     
										$mail->Username = $user_smtp; 
										$mail->Password = $pass_smtp; 
										$mail->Mailer  = "smtp";	
									}
								if($servidor_smtp=="ssl://smtp.gmail.com")
									{	
										$mail->Port = 465;
									}
								$mail->From = $email;
								$mail->FromName = $nombre;
								$mail->AddAddress($correo_recibe, $nombre_recibe);
								$mail->IsHTML(true);
								$mail->Subject = "Mensaje de Contacto";
								$mail->Body = $texto_enviar;
								if(!$mail->Send()) 
									{
										$paso = false;
										$men = 3;
									}
								else
									{
										$paso = true;
										$men = 1;
									}
							}
					}
				if($paso)
					{ echo 'termino-';  }
				else
					{
						if($men==1)
							echo 'fallo-No se pudo registrar el mensaje';
						else
							echo 'fallo-Se registro el mensaje, pero no se pudo enviar por correo';
					}
			}	
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)		
			{
				$con_confi = "select * from nazep_zmod_contacto_configuracion";
				$conexion = $this->conectarse();
				$res_con = mysql_query($con_confi);
				$ren_con = mysql_fetch_array($res_con);	
				$pedir_tema = $ren_con["pedir_tema"];
				$pedir_nombre_compuesto = $ren_con["pedir_nombre_compuesto"];
				$pedir_nombre_largo = $ren_con["pedir_nombre_largo"];
				$pedir_correo = $ren_con["pedir_correo"];
				$pedir_sitio_web = $ren_con["pedir_sitio_web"];
				$pedir_telefono = $ren_con["pedir_telefono"];
				$pedir_fax = $ren_con["pedir_fax"];
				$pedir_direccion = $ren_con["pedir_direccion"];
				$pedir_pais = $ren_con["pedir_pais"];
				$pedir_mensaje = $ren_con["pedir_mensaje"];
				$obligar_tema = $ren_con["obligar_tema"];
				$obligar_nombre_compuesto = $ren_con["obligar_nombre_compuesto"];
				$obligar_nombre_largo = $ren_con["obligar_nombre_largo"];
				$obligar_correo = $ren_con["obligar_correo"];
				$obligar_sitio_web = $ren_con["obligar_sitio_web"];
				$obligar_telefono = $ren_con["obligar_telefono"];
				$obligar_fax = $ren_con["obligar_fax"];
				$obligar_direccion = $ren_con["obligar_direccion"];
				$obligar_pais = $ren_con["obligar_pais"];
				$obligar_mensaje = $ren_con["obligar_mensaje"];
				$pais_defecto = $ren_con["pais_defecto"];
				echo '<script type="text/javascript">';
				echo ' $(document).ready(function()
							{	
								$.frm_elem_color("#FACA70","");
								$.guardar_datos_limpiar("enviar_comentario","'.$ubicacion_tema.'","El envio del contacto se realizo exitosamente");
							});	
						function validar_form(formulario)
							{ ';
								if($pedir_nombre_compuesto == "si")
									{
										if($obligar_nombre_compuesto == "si")
											{
												echo ' if(formulario.nombre.value == "") 
															{
																alert("'.com_valida_nombre.'");
																formulario.nombre.focus();
																return false;
															}
														if(formulario.ap_pat.value == "") 
															{
																alert("'.com_valida_ape_pa.'");
																formulario.ap_pat.focus();
																return false;
															}
														if(formulario.ap_mat.value == "") 
															{
																alert("'.com_valida_ape_ma.'");
																formulario.ap_mat.focus();
																return false;
															} ';
											}
									
									}
								if($pedir_nombre_largo == "si")
									{
										if($obligar_nombre_largo == "si")
											{
												echo 'if(formulario.nombre_completo.value == "") 
															{
																alert("'.com_valida_nombre_largo.'")
																formulario.nombre_completo.focus();
																return false
															}';
											}
									}
								if($pedir_correo == "si")
									{
										if($obligar_correo == "si")
											{
												echo 'if(formulario.correo_electronico.value == "") 
															{
																alert("'.com_valida_correo.'");
																formulario.correo_electronico.focus();
																return false;
															}';
											}
										echo 'correo = formulario.correo_electronico.value;
												if(!isEmailAddress(correo))
													{
														alert("'.com_valida_correo2.'");
														formulario.correo_electronico.focus();
														return false;
													}';
									}
								if($pedir_sitio_web == "si")
									{
										if($obligar_sitio_web == "si")
											{
												echo 'if(formulario.sitio_web.value == "") 
															{
																alert("'.com_valida_sitio_web.'");
																formulario.sitio_web.focus();
																return false;
															}';
											}
									}
								if($pedir_telefono == 'si')
									{
										if($obligar_telefono == 'si')
											{
												echo 'if(formulario.telefono.value == "") 
															{
																alert("'.com_valida_telefono.'");
																formulario.telefono.focus();
																return false;
															}';
											}
									}	
								if($pedir_fax == 'si')
									{
										if($obligar_fax == 'si')
											{
												echo 'if(formulario.fax.value == "") 
															{
																alert("'.com_valida_fax.'");
																formulario.fax.focus();
																return false;
															}';
											}
									}
								if($pedir_direccion == 'si')
									{
										if($obligar_direccion == 'si')
											{
												echo 'if(formulario.direccion.value == "") 
															{
																alert("'.com_valida_direccion.'");
																formulario.direccion.focus();
																return false;
															}';
											}
									}	
								if($pedir_mensaje == 'si')
									{
										if($obligar_mensaje == 'si')
											{
												echo 'if(formulario.mensaje.value == "") 
															{
																alert("'.com_valida_mensaje.'");
																formulario.mensaje.focus();
																return false;
															}';
											}
									}
					echo ' } ';
				echo '</script>';	
				echo '<div id="div_resultado_operacion" style=" font-weight:bold; text-align:center;"> </div> ';
				  echo '<div id="centro_contacto" class="centro_contenido_gral">';		
					echo '<div id="div_contacto_titulo" class="contacto_titulo" >'.com_txt_titulo_formulario.'</div>';
					$renglo_separacion = '<div class="contacto_ren_vacio" ></div>';
					echo '<form name="enviar_comentario" id="enviar_comentario" method="post" action="index.php?sec='.$sec.'" >';
						echo '<input type="hidden" name="redireccion" value = "si" />';
							if($pedir_tema == 'si')
								{
									$con_tema = "select nombre, clave_contacto_tema from nazep_zmod_contacto_temas where situacion = 'activo'";
									$res_tema = mysql_query($con_tema);
									echo '<div id="div_cotacto_uno_uno" class="cotacto_uno" >'.com_txt_pedir_tema.'</div>';
									echo '<div id="div_cotacto_uno_dos" class="cotacto_dos">';
										echo '<select name = "clave_contacto_tema">';
											while($ren_tema = mysql_fetch_array($res_tema))
												{
													$nombre = $ren_tema["nombre"];
													$clave_contacto_tema = $ren_tema["clave_contacto_tema"];
													echo '<option value = "'.$clave_contacto_tema.'-'.$nombre.'" >'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</div>';
									echo $renglo_separacion;
								}
							if($pedir_nombre_compuesto == "si")
								{
									$asterisco = '';
									if($obligar_nombre_compuesto=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_dos_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_nombre.'</div>';
									echo '<div id="div_cotacto_dos_dos" class="cotacto_dos"><input type = "text" name = "nombre" class="inp_cont_nombre" /></div>';
									echo $renglo_separacion;
									echo '<div id="div_cotacto_dos_unoa" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_ape_pa.'</div>';
									echo '<div id="div_cotacto_dos_dosa" class="cotacto_dos"><input type = "text" name = "ap_pat" class="inp_cont_ap_pat" /></div>';
									echo $renglo_separacion;
									echo '<div id="div_cotacto_dos_unob" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_ape_ma.'</div>';
									echo '<div id="div_cotacto_dos_dosb" class="cotacto_dos"><input type = "text" name = "ap_mat" class="inp_cont_ap_mat" /></div>';
									echo $renglo_separacion;
								}
							if($pedir_nombre_largo == "si")
								{
									$asterisco = '';
									if($obligar_nombre_largo=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_tres_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_pedir_nombre_largo.'</div>';
									echo '<div id="div_cotacto_tres_dos" class="cotacto_dos"><input type = "text" name = "nombre_completo" class="inp_cont_nombre_completo" /></div>';
									echo $renglo_separacion;
								}	
							if($pedir_correo == "si")
								{
									$asterisco = '';
									if($obligar_correo=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_tresa_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_pedir_correo.'</div>';
									echo '<div id="div_cotacto_tresa_dos" class="cotacto_dos">';
										echo '<input type = "text" name = "correo_electronico" class="inp_cont_correo_electronico" onkeyup="enviar_comentario.correo_electronico.value = enviar_comentario.correo_electronico.value.toLowerCase();" />';
									echo '</div>';
									echo $renglo_separacion;
								}
							if($pedir_sitio_web == "si")
								{
									$asterisco = '';
									if($obligar_sitio_web=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_cuatro_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_pedir_sitio_web.'</div>';
									echo '<div id="div_cotacto_cuatro_dos" class="cotacto_dos"><input type = "text" name = "sitio_web" class="inp_cont_sitio_web" /></div>';
									echo $renglo_separacion;
								}
							if($pedir_telefono == "si")
								{
									$asterisco = '';
									if($obligar_telefono=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_cinco_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_pedir_telefono.'</div>';
									echo '<div id="div_cotacto_cinco_dos" class="cotacto_dos"><input type = "text" name = "telefono" class="inp_cont_telefono" /></div>';
									echo $renglo_separacion;
								}
							if($pedir_fax == "si")
								{
									$asterisco = '';
									if($obligar_fax=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_seis_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_pedir_fax.'</div>';
									echo '<div id="div_cotacto_seis_dos" class="cotacto_dos"><input type = "text" name = "fax" class="inp_cont_fax" /></div>';
									echo $renglo_separacion;
								}
							if($pedir_direccion == "si")
								{
									$asterisco = '';
									if($obligar_direccion=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_siete_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_pedir_direccion.'</div>';
									echo '<div id="div_cotacto_siete_dos" class="cotacto_dos"><input type = "text" name = "direccion" class="inp_cont_direccion" /></div>';
									echo $renglo_separacion;
								}
							if($pedir_pais == "si")
								{
									$con_tema = "select clave_pais, nombre from nazep_paises where situacion = 'activo' and clave_pais > '1' order by nombre ";
									$res_tema = mysql_query($con_tema);
									echo '<div id="div_cotacto_ocho_uno" class="cotacto_uno" >&nbsp;'.com_txt_pedir_pais.'</div>';
									echo '<div id="div_cotacto_ocho_dos" class="cotacto_dos">';
										echo '<select name = "clave_pais">';
											while($ren_tema = mysql_fetch_array($res_tema))
												{
													$nombre = $ren_tema["nombre"];
													$clave_pais = $ren_tema["clave_pais"];
													echo '<option value = "'.$clave_pais.'-'.$nombre.'" '; if ($clave_pais == $pais_defecto) { echo 'selected="selected"  '; } echo '>'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</div>';
									echo $renglo_separacion;
								}
							if($pedir_mensaje == "si")
								{
									$asterisco = '';
									if($obligar_mensaje=='si')
										{ $asterisco = '(*)'; }
									echo '<div id="div_cotacto_nueve_uno" class="cotacto_uno" >'.$asterisco.'&nbsp;'.com_txt_pedir_mensaje.'</div>';
									echo '<div id="div_cotacto_nueve_dos" class="cotacto_dos"><textarea name="mensaje" class="txt_cont_mensaje" rows="0" cols="0" ></textarea></div>';
									echo $renglo_separacion;
								}
						echo '<div id="div_contacto_campos_obl" class="contacto_campos_obl" >'.com_txt_campos_obligatorios.'</div>';
						echo '<div id="div_contacto_btn" class="contacto_btn" >';
							echo '<input type="hidden" name="enviar" value = "si" />';
							echo '<input type="submit" name="btn_guardar" value="'.com_btn_enviar.'" onclick= "return validar_form(this.form)" />';	
						echo '</div>';
					echo '</form>';
				echo '</div>';
			}
		function vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{}
	}
?>