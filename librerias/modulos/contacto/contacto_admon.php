<?php
/*
Sistema: Nazep
Nombre archivo: contacto_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de contacto
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_contacto extends conexion
	{
		private $DirArchivo = '../librerias/modulos/contacto/contacto_admon.php';
		private $NomClase = 'clase_contacto';		
		function clase_contacto()
			{
				include('../librerias/idiomas/'.FunGral::SaberIdioma().'/contacto.php');
			}	
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == "activo")
					{
						HtmlAdmon::AccesoMetodo(array(
							'ClaveSeccion'=>$clave_seccion_enviada,
							'name'=>'ver_mensajes',
							'Id'=>'ver_mensajes',
							'BText'=>con_txt_btn_1,
							'BName'=>'btn_ver_mensajes',
							'BId'=>'btn_ver_mensajes',
							'OpcOcultas' => array(
											'archivo' =>$this->DirArchivo,
											'clase' =>$this->NomClase,
											'metodo' =>'ver_mensajes') ));							
						if($nivel=="1")
							{
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'configurar_mensajes',
									'Id'=>'configurar_mensajes',
									'BText'=>con_txt_btn_2,
									'BName'=>'btn_configurar_mensajes',
									'BId'=>'btn_configurar_mensajes',
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'configurar') ));							
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'nuevo_tema',
									'Id'=>'nuevo_tema',
									'BText'=>con_txt_btn_3,
									'BName'=>'btn_nuevo_tema',
									'BId'=>'btn_nuevo_tema',
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'nuevo_tema') ));
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'modificar_tema',
									'Id'=>'modificar_tema',
									'BText'=>'Modificar un tema de contacto',
									'BName'=>'btn_modificar_tema',
									'BId'=>'btn_modificar_tema',
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'modficar_tema') ));
							}
					}
				else
					{ echo '<br />'.con_txt_avi_no_act; }
			}
		function op_cambios_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == "activo")
					{ echo '<br />'.con_txt_avi_camb; }
				else
					{ echo '<br />'.con_txt_avi_no_act_cam; }	
			}
// ------------------------------ Fin de funciones para controlar las funciones del m�dulo
// ------------------------------ Inicio de funciones para controlar la modificaci�n de la informaci�n del m�dulo
		function ver_mensajes($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						if($_POST["enviar"]=="si")
							{
								$fecha_hoy = date("Y-m-d");
								$hora_hoy = date("H:i:s");
								$ip = $_SERVER['REMOTE_ADDR'];
								$texto_contestacion = $_POST["texto_contestacion"];
								$correo_recibe = $_POST["correo_electronico"];
								$nombre_recibe = $_POST["nombre"];
								$clave_contacto = $_POST["clave_contacto"];
								$clave_seccion = $_POST["clave_seccion"];	
								$conexion = $this->conectarse();
								$con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp from nazep_configuracion";
								$res_con = mysql_query($con_conf);
								$ren_con = mysql_fetch_array($res_con);
								$envio_correo = $ren_con["envio_correo"];
								$servidor_smtp = $ren_con["servidor_smtp"];
								$user_smtp = $ren_con["user_smtp"];
								$pass_smtp	= $ren_con["pass_smtp"];
								$con_usar_admin = "select nombre, email from nazep_usuarios_admon where nick_user = 'admin' ";
								$res_con_u = mysql_query($con_usar_admin);
								$ren_con_u = mysql_fetch_array($res_con_u);
								$nombre = $ren_con_u["nombre"];
								$email = $ren_con_u["email"];
								require("../librerias/phpmailer/class.phpmailer.php");
								$mail = new PHPMailer ();
								$mail->SetLanguage("es","../librerias/phpmailer/language/");
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
									{$mail->Port = 465;}
								$mail->From = $email;
								$mail->FromName = $nombre;
								$mail->AddAddress($correo_recibe, $nombre_recibe);
								$mail->IsHTML(true);
								$mail->Subject = "Respuesta al mensaje";
								$mail->Body = $texto_contestacion;		
								if(!$mail->Send()) 
									{
										$paso = false;
										$men = $mail->ErrorInfo;
										$error = "2";
									}
								else
									{
										$paso = true;		
										$update = "update nazep_zmod_contacto 
										set contestado = 'si', texto_contestacion = '$texto_contestacion', fecha_contestacion = '$fecha_hoy',
										hora_contestacion = '$hora_hoy', ip_contestacion = '$ip', user_contestacion = '$nick_user'
										where clave_contacto = '$clave_contacto'"; 
										if (!@mysql_query($update))
											{
												$men = mysql_error();
												$paso = false;
												$error = "1";
											}	
										else
											{ $paso = true;	 }
									}	
								if($paso)
									{echo "termino-,*-$formulario_final"; }
								else
									{ echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men"; }
							}
						elseif($_POST["enviar"]=="no")
							{
								$acciones_tomadas=$_POST["acciones_tomadas"];
								$fecha_hoy = date("Y-m-d");
								$hora_hoy = date("H:i:s");
								$ip = $_SERVER['REMOTE_ADDR'];
								$clave_contacto = $_POST["clave_contacto"];	
								$clave_seccion = $_POST["clave_seccion"];
								$update_enviar = "update nazep_zmod_contacto  set ver_acciones = 'si', acciones_tomadas = '$acciones_tomadas', fecha_acciones = '$fecha_hoy',
								hora_acciones = '$hora_hoy', ip_acciones = '$ip', user_acciones = '$nick_user'
								where clave_contacto = '$clave_contacto'"; 
								$conexion = $this->conectarse();
								if (!@mysql_query($update_enviar))
									{
										$men = mysql_error();
										$paso = false;
										$error = "1";
										echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
									}	
								else
									{echo "termino-,*-$formulario_final"; }
							}
					}
				elseif(FunGral::_Post("clave_contacto")!="")
					{
						$clave_contacto = FunGral::_PostLimpioInt("clave_contacto");
						$fecha_mensaje_i = $_POST["fecha_mensaje_i"];
						$fecha_mensaje_t = $_POST["fecha_mensaje_t"];	
						list($ano_i_b, $mes_i_b, $dia_i_b) = explode("-",$fecha_mensaje_i);
						list($ano_t_b, $mes_t_b, $dia_t_b) = explode("-",$fecha_mensaje_t);
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion(con_txt_tit_det_men);
						$con_conf = "select texto_contestacion from nazep_zmod_contacto_configuracion";
						$res_conf = mysql_query($con_conf);
						$ren_conf = mysql_fetch_array($res_conf);
						$texto_contestacion_base = $ren_conf["texto_contestacion"];
						$con_mensaje = "select t.nombre as nombre_tema, p.nombre as nombre_pais, c.fecha, c.hora, c.ip, c.nombre, 
						c.ap_pat, c.ap_mat, c.nombre_completo, c.correo_electronico, c.sitio_web, c.telefono, c.fax, c.direccion,
						c.mensaje, c.contestado, c.texto_contestacion, c.fecha_contestacion, c.hora_contestacion, c.ip_contestacion, 
						c.user_contestacion, c.ver_acciones, c.fecha_acciones, c.hora_acciones, c.ip_acciones, c.acciones_tomadas 
						from  nazep_zmod_contacto c, nazep_zmod_contacto_temas t, nazep_paises p
						where c.clave_pais = p.clave_pais and c.clave_contacto_tema = t.clave_contacto_tema and clave_contacto = '$clave_contacto'";
						$conexion = $this->conectarse();
						$res_men = mysql_query($con_mensaje);
						$ren_men = mysql_fetch_array($res_men);
						$nombre_tema = $ren_men["nombre_tema"];
						$nombre_pais = $ren_men["nombre_pais"];
						$fecha = $ren_men["fecha"];
						$hora = $ren_men["hora"];
						$ip = $ren_men["ip"];
						$nombre = $ren_men["nombre"];
						$ap_pat = $ren_men["ap_pat"];
						$ap_mat = $ren_men["ap_mat"];
						$nombre_completo = $ren_men["nombre_completo"];
						$correo_electronico = $ren_men["correo_electronico"];
						$sitio_web = $ren_men["sitio_web"];
						$telefono = $ren_men["telefono"];
						$fax = $ren_men["fax"];
						$direccion = $ren_men["direccion"];
						$mensaje = $ren_men["mensaje"];
						$fecha_acciones  = $ren_men["fecha_acciones"];
						$fecha_acciones = FunGral::fechaNormal($fecha_acciones);
						$hora_acciones = $ren_men["hora_acciones"];
						$ip_acciones = $ren_men["ip_acciones"];
						$ver_acciones  = $ren_men["ver_acciones"];
						$acciones_tomadas = $ren_men["acciones_tomadas"];
						$contestado = $ren_men["contestado"];
						$texto_contestacion = $ren_men["texto_contestacion"];
						$fecha_contestacion = $ren_men["fecha_contestacion"];
						$fecha_contestacion = FunGral::fechaNormal($fecha_contestacion);
						$hora_contestacion = $ren_men["hora_contestacion"];
						$ip_contestacion = $ren_men["ip_contestacion"];
						$user_contestacion = $ren_men["user_contestacion"];
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>'.con_txt_tip_men.'</td><td>'.$nombre_tema.'</td></tr>';
							echo '<tr><td>'.nombre.'</td><td>'.$nombre.'</td></tr>';
							echo '<tr><td>'.ape_pat.'</td><td>'.$ap_pat.'</td></tr>';
							echo '<tr><td>'.ape_mat.'</td><td>'.$ap_mat.'</td></tr>';
							echo '<tr><td>'.nom_completo.'</td><td>'.$nombre_completo.'</td></tr>';
							echo '<tr><td>'.correo_ele.'</td><td>'.$correo_electronico.'</td></tr>';
							echo '<tr><td>'.sitio_web.'</td><td>'.$sitio_web.'</td></tr>';
							echo '<tr><td>'.telefono.'</td><td>'.$telefono.'</td></tr>';
							echo '<tr><td>'.fax.'</td><td>'.$fax.'</td></tr>';	
							echo '<tr><td>'.direccion.'</td><td>'.$direccion.'</td></tr>';
							echo '<tr><td>'.pais.'</td><td>'.$nombre_pais.'</td></tr>';
							echo '<tr><td>'.con_txt_men_enviado.'</td><td>'.$mensaje.'</td></tr>';	
							echo '<tr><td><hr /></td><td><hr /></td></tr>';
						echo '</table>';
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
								{	
									$.frm_elem_color("#FACA70","");';
						if($ver_acciones == "no")
							{echo '$.guardar_valores("frm_guardar_acciones");'; }
						if($contestado =="no")
							{ echo '$.guardar_valores("contestar_recomendaciones");'; }
						echo '});</script>';
						if($ver_acciones == "no")
							{
								echo '<script type="text/javascript">';
								echo ' function validar_form_acciones(formulario)
										{
											if(formulario.acciones_tomadas.value=="")
												{
													alert("'.con_js_1.'");
													formulario.acciones_tomadas.focus(); 	
													return false;
												}
										} ';
								echo '</script>';
								echo '<form name="frm_guardar_acciones" id="frm_guardar_acciones" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero"  >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td align="center"><strong>'.con_txt_acc_toma.'</strong></td></tr>';
										echo '<tr><td align="center"><textarea name="acciones_tomadas" cols="70" rows="5"></textarea></td></tr>';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_contacto" />';
												echo '<input type="hidden" name="metodo" value = "ver_mensajes" />';
												echo '<input type="hidden" name="clave_contacto" value = "'.$clave_contacto.'" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="enviar" value = "no" />';
												echo '<input type="submit" value="'.guardar.'" onclick= "return validar_form_acciones(this.form)"  />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						elseif($ver_acciones =="si")
							{
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align="center"><strong>'.con_txt_acc_tomadas.'</strong></td></tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
									echo '<tr><td>'.con_txt_fec_acci.'</td><td>'.$fecha_acciones.'</td></tr>';
									echo '<tr><td>'.con_txt_hrs_acci.'</td><td>'.$hora_acciones.'</td></tr>';
									echo '<tr><td>'.con_txt_acc_guar.'</td><td>'.$acciones_tomadas.'</td></tr>';
								echo '</table>';
							}
						echo '<hr />';
						if($contestado =="no")
							{
								echo '<script type="text/javascript">';
								echo ' function validar_form_enviar(formulario)
										{
											if(formulario.correo_electronico.value=="")
												{
													alert("'.con_js_2.'");	
													return false;
												}
										}';
								echo '</script>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align="center"><strong>'.con_txt_enviar_correo.'</strong></td></tr>';
								echo '</table>';
								echo '<form name="contestar_recomendaciones" id="contestar_recomendaciones"  method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td align="left">'.con_txt_nom_dest.'</td><td align="left">';
												$tem_nom = "$nombre&nbsp;$ap_pat&nbsp;$ap_mat";
												echo '<input type="radio" name="nombre" value="'.$tem_nom.'" checked="checked" />&nbsp;'.$tem_nom.'<br />';
												echo '<input type="radio" name="nombre" value="'.$nombre_completo.'" />&nbsp;'.$nombre_completo.'';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td align="left">'.con_txt_cor_dest.'</td><td align="left">';
												echo $correo_electronico.'<input type="hidden" name="correo_electronico" value = "'.$correo_electronico.'" />';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td align="left">'.con_txt_men_envi.'</td><td align="left">';
												echo '<textarea name="texto_contestacion" cols="45" rows="5">'.$texto_contestacion_base.'</textarea>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_contacto" />';
												echo '<input type="hidden" name="metodo" value = "ver_mensajes" />';
												echo '<input type="hidden" name="clave_contacto" value = "'.$clave_contacto.'" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';	
												echo '<input type="hidden" name="enviar" value = "si" />';
												echo '<input type="submit" value="'.con_txt_envi_cor.'"  onclick= "return validar_form_enviar(this.form)"/>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						elseif($contestado =="si")
							{
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align="center"><strong>'.con_txt_tit_corr_envi.'</strong></td></tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
									echo '<tr><td>'.con_txt_fec_env.'</td><td>'.$fecha_contestacion.'</td></tr>';
									echo '<tr><td>'.con_txt_hrs_env.'</td><td>'.$hora_contestacion.'</td></tr>';
									echo '<tr><td>'.con_txt_msj_env.'</td><td>'.$texto_contestacion.'</td></tr>';
								echo '</table>';
							}
							
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_contacto"/>';
							echo '<input type="hidden" name="metodo" value = "ver_mensajes" />';	
							echo '<input type="hidden" name="clave_contacto" value = "'.$clave_contacto.'" />';
							echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
							echo '<input type="hidden" name="fecha_mensaje_i" value = "'.$fecha_mensaje_i.'" />';
							echo '<input type="hidden" name="fecha_mensaje_t" value = "'.$fecha_mensaje_t.'" />';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<form name="regresar_resultados_articulos" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contacto" />';
										echo '<input type="hidden" name="metodo" value = "ver_mensajes" />';	
										echo '<input type="hidden" name="buscar" value ="si" />';
										echo '<input type="hidden" name="ano_i" value ="'.$ano_i_b.'" />';
										echo '<input type="hidden" name="mes_i" value ="'.$mes_i_b.'" />';
										echo '<input type="hidden" name="dia_i" value ="'.$dia_i_b.'" />';
										echo '<input type="hidden" name="ano_t" value ="'.$ano_t_b.'" />';
										echo '<input type="hidden" name="mes_t" value ="'.$mes_t_b.'" />';
										echo '<input type="hidden" name="dia_t" value ="'.$dia_t_b.'" />';
										echo '<a href="javascript:document.regresar_resultados_articulos.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
										echo '<strong>'.reg_res_bus.'</strong>';
										echo '</a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
				elseif(FunGral::_Post("buscar")=='si')
					{
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_fin = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];	
						$fecha_i = FunGral::fechaNormal($fecha_inicio);
						$fecha_t = FunGral::fechaNormal($fecha_fin);
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(con_txt_tit_msj_enco);
						$con_men = "select clave_contacto, fecha, hora, mensaje, contestado, ver_acciones
						from  nazep_zmod_contacto where fecha >= '$fecha_inicio' and fecha <= '$fecha_fin'";
						$conexion = $this->conectarse();
						$res_reco = mysql_query($con_men);	
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
							echo '<tr><td align="center"><strong>'.de.' '.$fecha_i.' '.a.' '.$fecha_t.'</strong></td></tr>';
						echo '</table>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td><strong>'.fecha.'/'.hora.'</strong></td>';
								echo '<td><strong>'.con_txt_contestado.'</strong></td>';
								echo '<td><strong>'.con_txt_msj_acc_gua.'</strong></td>';
								echo '<td><strong>'.mensaje.'</strong></td>';
								echo '<td><strong>'.con_txt_ver_men.'</strong></td>';
							echo '</tr>';	
							$contador = 0;
							while($ren_reco = mysql_fetch_array($res_reco))
								{
									if(($contador%2)=="0")
										{ $color = 'bgcolor="#F9D07B"'; }
									else
										{ $color = ''; }
									$clave_contacto = $ren_reco["clave_contacto"];
									$fecha = $ren_reco["fecha"];
									$fecha = FunGral::FechaNormalCorta($fecha);
									$hora = $ren_reco["hora"];
									$mensaje = $ren_reco["mensaje"];
									$contestado = $ren_reco["contestado"];
									$ver_acciones = $ren_reco["ver_acciones"];
									echo '<tr><td '.$color.'>'.$fecha.'<br />'.$hora.' Hrs.</td>';
										echo '<td '.$color.'>'.$contestado.'</td>';
										echo '<td '.$color.'>'.$ver_acciones.'</td>';
										echo '<td '.$color.'>'.$mensaje.'</td>';
										echo '<td '.$color.'>';
											echo '<form name="mod_contacto_men_'.$clave_contacto.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_contacto" />';
												echo '<input type="hidden" name="metodo" value = "ver_mensajes" />';
												echo '<input type="hidden" name="clave_contacto" value = "'.$clave_contacto.'" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
												echo '<input type="hidden" name="fecha_mensaje_i" value = "'.$fecha_inicio.'" />';
												echo '<input type="hidden" name="fecha_mensaje_t" value = "'.$fecha_fin.'" />';
												echo '<input type="submit" name="Submit" value="'.ver.'" />';
											echo '</form>';
										echo '</td>';
									echo '</tr>';
									$contador++;
								}
						echo '</table>';
						echo '<form name="reg_buscador" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contacto" />';
										echo '<input type="hidden" name="metodo" value = "ver_mensajes" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
										echo '<a href="javascript:document.reg_buscador.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
										echo '<strong>'.con_txt_reg_bus.'</strong></a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
				else
					{
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(con_txt_tit_bus_men);
						echo '<form name="generar_nuevo_baner" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.fecha_ini_bus.'</td><td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										$areglo_meses = FunGral::MesesNumero();;
										echo dia.'&nbsp;<select name = "dia_i">';
										for ($a = 1; $a<=31; $a++)
											{echo "<option value = \"$a\" "; if ($dia == $a) { echo "selected"; } echo " > $a </option>";}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_i">';
											for ($b=1; $b<=12; $b++)
												{echo "<option value = \"$b\"  "; if ($mes == $b) {echo " selected ";} echo " >". $areglo_meses[$b] ."</option>";}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_i">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{echo "<option value = \"$b\" "; if ($ano == $b) {echo " selected ";} echo "> $b</option>";}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>'.fecha_fin_bus.'</td><td>';
										echo dia.'&nbsp;<select name = "dia_t">';
										for ($a = 1; $a<=31; $a++)
											{echo "<option value = \"$a\" "; if ($dia == $a) { echo "selected"; } echo " > $a </option>";}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_t">';
											for ($b=1; $b<=12; $b++)
												{echo "<option value = \"$b\"  "; if ($mes == $b) {echo " selected ";} echo " >". $areglo_meses[$b] ."</option>";}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_t">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{echo "<option value = \"$b\" "; if ($ano == $b) {echo " selected ";} echo "> $b</option>";}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_contacto" />';
							echo '<input type="hidden" name="metodo" value = "ver_mensajes" />';
							echo '<input type="hidden" name="buscar" value = "si" />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td align ="center"><input type="submit" name="btn_buscar" value="'.buscar.'" /></td></tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::boton_regreso(array('tipo_boton_reg'=>'sencillo','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}	
		function configurar($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$enviar_correo = $_POST["enviar_correo"];
						$correo_recibe  = $_POST["correo_recibe"];
						$nombre_recibe  = $_POST["nombre_recibe"];
						$texto_contestacion = addslashes($_POST["texto_contestacion"]);
						$texto_contestacion = strip_tags($texto_contestacion);
						$pedir_tema = $_POST["pedir_tema"];
						$pedir_nombre_compuesto = $_POST["pedir_nombre_compuesto"];
						$pedir_nombre_largo = $_POST["pedir_nombre_largo"];
						$pedir_correo = $_POST["pedir_correo"];
						$pedir_sitio_web = $_POST["pedir_sitio_web"];
						$pedir_telefono = $_POST["pedir_telefono"];
						$pedir_fax = $_POST["pedir_fax"];
						$pedir_direccion = $_POST["pedir_direccion"];
						$pedir_pais = $_POST["pedir_pais"];
						$pedir_mensaje = $_POST["pedir_mensaje"];
						$obligar_nombre_compuesto = $_POST["obligar_nombre_compuesto"];
						$obligar_nombre_largo = $_POST["obligar_nombre_largo"];
						$obligar_correo = $_POST["obligar_correo"];
						$obligar_sitio_web = $_POST["obligar_sitio_web"];
						$obligar_telefono = $_POST["obligar_telefono"];
						$obligar_fax = $_POST["obligar_fax"];
						$obligar_direccion = $_POST["obligar_direccion"];
						$obligar_mensaje = $_POST["obligar_mensaje"];
						$clave_seccion =  $_POST["clave_seccion"];
						$pais_defecto =  $_POST["pais_defecto"];
						$update ="update nazep_zmod_contacto_configuracion
						set enviar_correo = '$enviar_correo', correo_recibe = '$correo_recibe', nombre_recibe= '$nombre_recibe', texto_contestacion = '$texto_contestacion',
						pedir_tema = '$pedir_tema', pedir_nombre_compuesto = '$pedir_nombre_compuesto', pedir_nombre_largo = '$pedir_nombre_largo', pedir_correo = '$pedir_correo',
						pedir_sitio_web = '$pedir_sitio_web', pedir_telefono= '$pedir_telefono', pedir_fax = '$pedir_fax', pedir_direccion = '$pedir_direccion',
						pedir_pais = '$pedir_pais', pedir_mensaje = '$pedir_mensaje', obligar_nombre_compuesto = '$obligar_nombre_compuesto', obligar_nombre_largo = '$obligar_nombre_largo',
						obligar_correo = '$obligar_correo', obligar_sitio_web = '$obligar_sitio_web', obligar_telefono = '$obligar_telefono', obligar_fax = '$obligar_fax', 
						obligar_direccion = '$obligar_direccion', obligar_mensaje = '$obligar_mensaje', pais_defecto = '$pais_defecto'";
						$conexion = $this->conectarse();
						if (!@mysql_query($update))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;	
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}	
						else
							{echo "termino-,*-$formulario_final";}
					}
				else
					{
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(con_txt_tit_confi);
						$con_con = "select * from nazep_zmod_contacto_configuracion";
						$conexion = $this->conectarse();
						$res_con = mysql_query($con_con);
						$ren_con = mysql_fetch_array($res_con);
						$enviar_correo = $ren_con["enviar_correo"];
						$correo_recibe  = $ren_con["correo_recibe"];
						$nombre_recibe  = $ren_con["nombre_recibe"];
						$texto_contestacion = $ren_con["texto_contestacion"];
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
						$obligar_nombre_compuesto = $ren_con["obligar_nombre_compuesto"];
						$obligar_nombre_largo = $ren_con["obligar_nombre_largo"];
						$obligar_correo = $ren_con["obligar_correo"];
						$obligar_sitio_web = $ren_con["obligar_sitio_web"];
						$obligar_telefono = $ren_con["obligar_telefono"];
						$obligar_fax = $ren_con["obligar_fax"];
						$obligar_direccion = $ren_con["obligar_direccion"];
						$obligar_mensaje = $ren_con["obligar_mensaje"];
						$pais_defecto = $ren_con["pais_defecto"];
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_configurar_contacto");
									});
								function validar_form(formulario)
									{
										if(formulario.enviar_correo.value == "si")
											{
												if(formulario.correo_recibe.value == "") 
													{
														alert("'.con_js_3.'");
														formulario.correo_recibe.focus(); 	
														return false;
													}
												correo = formulario.correo_recibe.value;
												if(!isEmailAddress(correo))
													{
														alert("'.mous_alert_cor_inc.'");
														formulario.correo_electronico.focus();
														return false;
													}
												if(formulario.nombre_recibe.value == "") 
													{
														alert("'.con_js_4.'");
														formulario.nombre_recibe.focus(); 	
														return false;
													}
											}
										if(formulario.texto_contestacion.value == "") 
											{
												alert("'.con_js_5.'");
												formulario.texto_contestacion.focus(); 	
												return false;
											}
										formulario.btn_guardar.style.visibility="hidden";
									}';
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla"  method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_contacto"/>';
							echo '<input type="hidden" name="metodo" value = "configurar" />';
						echo '</form>';
						echo '<form name="frm_configurar_contacto" id="frm_configurar_contacto" method="post"  action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td align ="left">'.con_txt_env_corr.'</td>';
									echo '<td align ="left">';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'enviar_correo','ValorSeleccionado'=>$enviar_correo, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_corr_env.'</td>';
									echo '<td align ="left"><input type = "text" name = "correo_recibe" size = "50" onkeyup="configurar_contacto.correo_recibe.value = configurar_contacto.correo_recibe.value.toLowerCase();" value="'.$correo_recibe.'"/></td>';
								echo '</tr>';	
								echo '<tr><td>'.con_txt_nom_reci.'</td>';
								echo '<td><input type = "text" name = "nombre_recibe" size = "50" value="'.$nombre_recibe.'" /></td></tr>';
								echo '<tr><td>'.con_txt_tex_base.'</td>';
								echo '<td><textarea name="texto_contestacion" cols="35" rows="5">'.$texto_contestacion.'</textarea></td></tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_ped_tema.'</td>';
									echo '<td align ="left" bgcolor="#F9D07B">';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_tema','ValorSeleccionado'=>$pedir_tema, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';	
								echo '<tr><td align ="left">'.con_txt_ped_nom_com.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_nombre_compuesto','ValorSeleccionado'=>$pedir_nombre_compuesto, 'orden'=>'si-no')); 
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_obl_nom_com.'</td><td align ="left" bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_nombre_compuesto','ValorSeleccionado'=>$obligar_nombre_compuesto, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_ped_nom_completo.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_nombre_largo','ValorSeleccionado'=>$pedir_nombre_largo, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_obl_nom_completo.'</td><td align ="left" bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_nombre_largo','ValorSeleccionado'=>$obligar_nombre_largo, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_ped_corr.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_correo','ValorSeleccionado'=>$pedir_correo, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_obl_corr.'</td><td align ="left" bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_correo','ValorSeleccionado'=>$obligar_correo, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';	
								echo '<tr><td align ="left">'.con_txt_ped_sit.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_sitio_web','ValorSeleccionado'=>$pedir_sitio_web, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td align ="left" bgcolor="#F9D07B">'.con_txt_obl_sit.'</td><td align ="left" bgcolor="#F9D07B">';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_sitio_web','ValorSeleccionado'=>$obligar_sitio_web, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_ped_tel.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_telefono','ValorSeleccionado'=>$pedir_telefono, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_obl_tel.'</td><td align ="left" bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_telefono','ValorSeleccionado'=>$obligar_telefono, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_ped_fax.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_fax','ValorSeleccionado'=>$pedir_fax, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_obl_fax.'</td><td align ="left" bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_fax','ValorSeleccionado'=>$obligar_fax, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_ped_dir.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_direccion','ValorSeleccionado'=>$pedir_direccion, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_obl_dir.'</td><td align ="left" bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_direccion','ValorSeleccionado'=>$obligar_direccion, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_ped_pais.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_pais','ValorSeleccionado'=>$pedir_pais, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left" bgcolor="#F9D07B">'.con_txt_ped_msj.'</td><td align ="left" bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'pedir_mensaje','ValorSeleccionado'=>$pedir_mensaje, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_obl_msj.'</td><td align ="left">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'obligar_mensaje','ValorSeleccionado'=>$obligar_mensaje, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align ="left">'.con_txt_pais_def.'</td><td align ="left">';
										echo '<select name = "pais_defecto">';
											$con_tema = "select clave_pais, nombre from nazep_paises where situacion = 'activo'  and clave_pais > '1' order by nombre ";
											$res_tema = mysql_query($con_tema);
											while($ren_tema = mysql_fetch_array($res_tema))
												{
													$nombre = $ren_tema["nombre"];
													$clave_pais_base = $ren_tema["clave_pais"];
													echo '<option value = "'.$clave_pais_base.'" '; if ($clave_pais_base == $pais_defecto) { echo 'selected'; } echo ' >'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contacto" />';
										echo '<input type="hidden" name="metodo" value = "configurar" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="submit" name="btn_guardar" value="'.guardar.'"  onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';	
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('tipo_boton_reg'=>'sencillo','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function nuevo_tema($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];			
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_seccion = $_POST["clave_seccion"];
						$nombre = addslashes($_POST["nombre"]);
						$nombre = strip_tags($nombre);
						$descripcion = addslashes($_POST["descripcion"]);
						$descripcion = strip_tags($descripcion);
						$situacion = $_POST["situacion"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$insert = "insert into nazep_zmod_contacto_temas  values('','$nombre','$descripcion','$situacion', '$nick_user','$ip', '$fecha_hoy', '$hora_hoy', '$nick_user','$ip', '$fecha_hoy', '$hora_hoy')";
						$conexion = $this->conectarse();
						if (!@mysql_query($insert))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}	
						else
							{echo "termino-,*-$formulario_final"; }
					}
				else
					{
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(con_txt_tit_nue_tem);	
						echo '<script type="text/javascript">';	
						echo ' $(document).ready(function()
								{
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_nuevo_tema");
								});
							function validar_form(formulario, opcion)
								{
									if(formulario.nombre.value == "") 
										{
											alert("'.con_js_6.'");
											formulario.nombre.focus(); 	
											return false
										}
									if(opcion=="salir")
										{
											document.recargar_pantalla.archivo.value="";
											document.recargar_pantalla.clase.value="";
											document.recargar_pantalla.metodo.value="";
											document.recargar_pantalla.action = "index.php?opc=11&clave_seccion='.$clave_seccion_enviada.'";
											document.recargar_pantalla.post = "GET";
										}
									formulario.btn_guardar1.style.visibility="hidden";
									formulario.btn_guardar2.style.visibility="hidden";
								} ';
						echo '</script>';	
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_contacto"/>';
							echo '<input type="hidden" name="metodo" value = "nuevo_tema" />';
						echo '</form>';	
						
						
						echo '<form name="frm_nuevo_tema" id="frm_nuevo_tema" method="post"  action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';						
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.con_txt_nom_tem.'</td><td><input type = "text" name = "nombre" size = "40" /></td></tr>';
								echo '<tr><td>'.con_txt_des_tem.'</td><td><textarea name="descripcion" cols="35" rows="5"></textarea></td></tr>';
								echo '<tr><td>'.situacion.'</td><td>';
										echo '<select name = "situacion">';
											echo '<option value = "activo" >'.activo.'</option>';
											echo '<option value = "cancelado" >'.cancelado.'</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contacto" />';
										echo '<input type="hidden" name="metodo" value = "nuevo_tema" />';	
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
										echo '<input type="submit" name="btn_guardar1" value="'.guardar.'"  onclick= "return validar_form(this.form,\'salir\')" />';
									echo '</td>';
									echo '<td align="center">';	
										echo '<input type="submit" name="btn_guardar2" value="'.guardar_cam_otro.'"  onclick= "return validar_form(this.form,\'regresar\')" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';	
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('tipo_boton_reg'=>'sencillo','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function modficar_tema($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_contacto_tema = $_POST["clave_contacto_tema"];
						$clave_seccion = $_POST["clave_seccion"];
						$nombre = addslashes($_POST["nombre"]);
						$nombre = strip_tags($nombre);
						$descripcion = addslashes($_POST["descripcion"]);
						$descripcion = strip_tags($descripcion);
						$situacion = $_POST["situacion"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$update = "update  nazep_zmod_contacto_temas
						set nombre= '$nombre', descripcion = '$descripcion', situacion = '$situacion',
						user_actualiza = '$nick_user', ip_actualizacion = '$ip', fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy' where clave_contacto_tema = '$clave_contacto_tema'";
						$conexion = $this->conectarse();
						if (!@mysql_query($update))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;		
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{ echo "termino-,*-$formulario_final"; }
					}
				elseif(isset($_POST["clave_contacto_tema"]) &&  $_POST["clave_contacto_tema"]!="")
					{
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(con_txt_tit_mod_tem);
						$clave_contacto_tema = $_POST["clave_contacto_tema"];
						$con_tema = "select nombre, descripcion, situacion from nazep_zmod_contacto_temas where clave_contacto_tema = '$clave_contacto_tema'";
						$conexion = $this->conectarse();
						$res_tema = mysql_query($con_tema);
						$ren_tema = mysql_fetch_array($res_tema);
						$nombre = $ren_tema["nombre"];
						$descripcion = $ren_tema["descripcion"];
						$situacion = $ren_tema["situacion"];
						echo '<script type="text/javascript">';
						echo ' $(document).ready(function()
								{
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_modificar_tema");
								});
							function validar_form(formulario)
								{
									if(formulario.nombre.value == "") 
										{
											alert("'.con_js_6.'");
											formulario.nombre.focus(); 	
											return false;
										}
									formulario.btn_guardar.style.visibility="hidden";
								} ';
						echo '</script>';	
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_contacto"/>';
							echo '<input type="hidden" name="metodo" value = "modficar_tema" />';
							echo '<input type="hidden" name="clave_contacto_tema" value = "'.$clave_contacto_tema.'" />';
						echo '</form>';
						echo '<form name="frm_modificar_tema" id="frm_modificar_tema" method="post"  action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.con_txt_nom_tem.'</td><td><input type = "text" name = "nombre" size = "40" value ="'.$nombre.'" /></td></tr>';
								echo '<tr><td>'.con_txt_des_tem.'</td><td><textarea name="descripcion" cols="35" rows="5">'.$descripcion.'</textarea></td></tr>';
								echo '<tr><td>'.situacion.'</td><td>';
										echo '<select name = "situacion">';
											echo '<option value ="activo"  '; if ($situacion == "activo") { echo 'selected'; } echo ' >'.activo.'</option>';
											echo '<option value = "cancelado"  '; if ($situacion == "cancelado") { echo 'selected'; } echo ' >'.cancelado.'</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contacto" />';
										echo '<input type="hidden" name="metodo" value = "modficar_tema" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="hidden" name="clave_contacto_tema" value = "'.$clave_contacto_tema.'" />';
										echo '<input type="submit" name="btn_guardar" value="'.guardar.'"  onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';	
						HtmlAdmon::div_res_oper(array());
						echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contacto" />';
										echo '<input type="hidden" name="metodo" value = "modficar_tema" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
										echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
										echo '<strong>'.con_txt_reg_lis_tem.'</strong></a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
				else
					{
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(con_txt_tit_lis_tem);
						$consu_temas = "select clave_contacto_tema, nombre, situacion from nazep_zmod_contacto_temas ";
						$conexion = $this->conectarse();
						$res_temas = mysql_query($consu_temas);
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
							echo'<tr><td align = "center"><strong>'.con_txt_nom_tem.'</strong></td>';
								echo '<td align = "center"><strong>'.situacion.'</strong></td>';
								echo '<td align = "center"><strong>'.modificar.'</strong></td></tr>';
							$contador = 0;
							while($ren_tema = mysql_fetch_array($res_temas))
								{
									if(($contador%2)=="0")
										{$color = 'bgcolor="#F9D07B"';}
									else
										{$color = '';}	
									$clave_contacto_tema = $ren_tema["clave_contacto_tema"];
									$nombre = $ren_tema["nombre"];
									$situacion = $ren_tema["situacion"];
									echo'<tr><td align = "center">'.$nombre.'</td><td align = "center">'.$situacion.'</td>';
										echo '<td align = "center">';
											echo '<form name="modificar_temas_'.$clave_contacto_tema.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contacto/contacto_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_contacto" />';
												echo '<input type="hidden" name="metodo" value = "modficar_tema" />';
												echo '<input type="hidden" name="clave_contacto_tema" value = "'.$clave_contacto_tema.'" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="submit" name="Submit" value="'.modificar.'" />';
											echo '</form>';
										echo '</td>';
									echo'</tr>';
								}
							echo '</table>';
							HtmlAdmon::boton_regreso(array('tipo_boton_reg'=>'sencillo','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
// ------------------------------ Fin de funciones para controlar la modificaci�n de la informaci�n del m�dulo
	}
?>