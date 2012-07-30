<?php
/*
Sistema: Nazep
Nombre archivo: administracion.php
Funci�n archivo: Generar toda la interfaz de administraci�n del sistema
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Julio 2010
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
include("../librerias/conexion.php");
include("../librerias/fckeditor/fckeditor.php");
include_once("../librerias/html.php");
include_once("../librerias/html_admon.php");
include_once("../librerias/FunGral.php");
class administracion extends conexion
	{
		var $nick_user;
		var $correo_user;
		var $nombre;
		var $nivel;
		var $sesion = "no"; 
		var $secciones;
		var $nombre_secciones;
		var $ubi_tema;
		var $ancho_pixeles;	
				
		function validar_usuario()
			{
				if(!isset($_POST["validar"]) || $_POST["validar"]=="")
					{
						echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
						$this->firma();
						echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">';
							if(@$_GET["cambiar"]=="contra")
								{
									echo '<head><title>::-:: '.titulo_camb_contra.' ::-::</title>';	
									echo '<link rel="STYLESHEET" type="text/css" href="estilos.css" />';
									echo '<link rel="SHORTCUT ICON" href="imagenes/favicon.ico" />
									<script type="text/javascript" src="../librerias/jquery/jquery-1.3.2.min.js"></script>
									<script type="text/javascript" src="../librerias/jquery/jquery_nazep_admon.js"></script>
									<script type="text/javascript">
									$(document).ready(function()
										{
											$.frm_elem_color("#FACA70","");
											$("#nick_usuario_contras").focus();
										});
									</script>';	
									echo '</head> <body>';
										echo '<form id="formulario_contras" name="formulario_contras" method="post" action="index.php" class="margen_cero">';
											echo '<div id="div_centro_registro" >';
												echo '<div id="registro_1" class="class_registro_1"><div id="registro_1_titulo" class="class_reg1_titulo" > Cambiar Contrase�a de un Usuario </div> </div>';
												echo '<div id="registro_2" class="class_registro_2">';
													echo '<div id="explicacion" class="class_explicacion">Ingrese su nombre de usuario, para que se enviado a su email la nueva contrase&ntilde;a</div>';
													echo '<div id="campos_form_bloqueo">';
														echo '<strong>Usuario:</strong> <input type= "text" name="nick_usuario_contras" id="nick_usuario_contras" />
														<input type="hidden" name="validar" value = "si" /><input type="hidden" name="cambiar" value = "contra" />
														<br/><br/><input type="submit" name="Submit" value="Enviar Usuario" />';
													echo '</div>';
													echo '<div id="div_regreso" class="regreso_form"><a href="index.php" title="Regresar" >Regresar</a></div>';
													echo '<div id="div_mensajes" class="div_error_registro" >';
														if($_GET["mensaje"]=="")
															$texto_mostrar='&nbsp;';
														elseif($_GET["mensaje"]==0)
															$texto_mostrar='El cambio de contrase�a fue exitoso';
														elseif($_GET["mensaje"]==1)
															$texto_mostrar='No existe ese usuario solicitado';
														elseif($_GET["mensaje"]==2)
															$texto_mostrar='No se logro actualizar los datos del usuario';
														elseif($_GET["mensaje"]==3)
															$texto_mostrar='No se logro mandar el correo electronico';
														echo $texto_mostrar;
													echo '</div>';
												echo '</div>';
												echo'<div id="registro_3" class="class_registro_3">';
													echo'<div id="img_logo" ><img src="imagenes/logo_solo.jpg" title="Nazep" alt="Nazep"/></div>';
												echo'</div>';
												echo '<div id="validador_registro"> ';
													echo '<a href="http://validator.w3.org/check?uri=referer">';
													if(file_exists("http://www.w3.org/Icons/valid-xhtml10"))
														{echo'<img class="imagenes_enlaces" src="http://www.w3.org/Icons/valid-xhtml10.gif" title="Valid XHTML 1.0 Transitional" alt="Valid XHTML 1.0 Transitional"  />';}
													else
														{ echo'<img class="imagenes_enlaces" src="imagenes/valid-xhtml10.gif" title="Valid XHTML 1.0 Transitional" alt="Valid XHTML 1.0 Transitional"   />';}
													echo '</a>';
												echo '</div>';
											echo '</div>';
										echo '</form>';
									
								}
							elseif(@$_GET["cambiar"]=="bloqueo")
								{
									echo '<head><title>::-:: '.titulo_camb_bloqueo.' ::-::</title>';	
									echo '<link rel="STYLESHEET" type="text/css" href="estilos.css" />';
									echo '<link rel="SHORTCUT ICON" href="imagenes/favicon.ico" />
									<script type="text/javascript" src="../librerias/jquery/jquery-1.3.2.min.js"></script>
									<script type="text/javascript" src="../librerias/jquery/jquery_nazep_admon.js"></script>
									<script type="text/javascript">
									$(document).ready(function()
										{									
											$.frm_elem_color("#FACA70","");
											$("#nick_usuario_bloqueo").focus();
										});
									</script>';			
									echo '</head> <body>';
										echo '<form id="formulario_bloqueo" name="formulario_bloqueo" method="post" action="index.php" class="margen_cero">';
											echo '<div id="div_centro_registro" >';
												echo '<div id="registro_1" class="class_registro_1"><div id="registro_1_titulo" class="class_reg1_titulo" > Desbloquer Cuenta de Usuario </div> </div>';
												echo '<div id="registro_2" class="class_registro_2">';
													echo '<div id="explicacion" class="class_explicacion">Ingrese su nombre de usuario, para que se desbloque su cuenta, como que se genere una nueva contrase&ntilde;a que ser� enviada a su e-mail</div>';
													echo '<div id="campos_form_bloqueo">';
														echo '<strong>Usuario:</strong> <input type= "text" name="nick_usuario_bloqueo" id="nick_usuario_bloqueo" />
														<input type="hidden" name="validar" value = "si" /><input type="hidden" name="cambiar" value = "bloqueo" />
														<br/><br/><input type="submit" name="Submit" value="Enviar Usuario" />';
													echo '</div>';
													echo '<div id="div_regreso" class="regreso_form"><a href="index.php" title="Regresar" >Regresar</a></div>';
													echo '<div id="div_mensajes" class="div_error_registro" >';
														if($_GET["mensaje"]=="")
															$texto_mostrar='&nbsp;';
														elseif($_GET["mensaje"]==0)
															$texto_mostrar='El desbloqueo fue exitoso';
														elseif($_GET["mensaje"]==1)
															$texto_mostrar='No existe ese usuario bloqueado';
														elseif($_GET["mensaje"]==2)
															$texto_mostrar='No se logro actualizar los datos del usuario';
														elseif($_GET["mensaje"]==3)
															$texto_mostrar='No se logro mandar el correo electronico';
														echo $texto_mostrar;
													echo '</div>';
												echo '</div>';
												echo'<div id="registro_3" class="class_registro_3"><div id="img_logo" ><img src="imagenes/logo_solo.jpg" title="Nazep" alt="Nazep"/></div></div>';
												echo '<div id="validador_registro"> ';
													echo '<a href="http://validator.w3.org/check?uri=referer">';
													if(file_exists("http://www.w3.org/Icons/valid-xhtml10"))
														{echo'<img class="imagenes_enlaces" src="http://www.w3.org/Icons/valid-xhtml10.gif" title="Valid XHTML 1.0 Transitional" alt="Valid XHTML 1.0 Transitional"  />';}
													else
														{ echo'<img class="imagenes_enlaces" src="imagenes/valid-xhtml10.gif" title="Valid XHTML 1.0 Transitional" alt="Valid XHTML 1.0 Transitional"   />';}
													echo '</a>';
												echo '</div>';
											echo '</div>';
										echo '</form>';
								}
							else
								{//formulario acceso
									echo '<head><title>::-:: '.titulo_acceso_admon.' ::-::</title>';	
									echo '<link rel="STYLESHEET" type="text/css" href="estilos.css" />';
									echo '<link rel="SHORTCUT ICON" href="imagenes/favicon.ico" />
									<script type="text/javascript" src="../librerias/jquery/jquery-1.3.2.min.js"></script>
									<script type="text/javascript" src="../librerias/jquery/jquery_nazep_admon.js"></script>
									<script type="text/javascript">
									$(document).ready(function()
										{
											$.frm_elem_color("#FACA70","");
											$("#nick_usuario").focus();
										});
									</script>';
									echo '</head> <body>';
										echo '<form id="formulario_acceso" name="formulario_acceso" method="post" action="index.php" class="margen_cero">';
										   echo '<div id="div_centro_registro">';
												echo '<div id="div_error_registro" class="div_error_registro" >';
													$error_de_usuario = @$_GET["error_usuario"];
													$intentos = htmlentities(@$_GET["intentos"]);
													$bloqueo = htmlentities(@$_GET["bloqueo"]);
													if($error_de_usuario  == "si") 
														echo error_acceso_admon;
													else
														echo '&nbsp;';
													if($intentos!=0)
														echo inten_error_acceso_admon." ".$intentos.inten_error_acceso_admon2;
													if($bloqueo!="")
														{
															$user = htmlentities($_GET["user"]);
															echo inten_error_acceso_admon3.$user.inten_error_acceso_admon4;
														}
												echo '</div>';
												echo '<div id="registro_1" class="class_registro_1"><div id="registro_1_titulo" class="class_reg1_titulo" > Ingreso al Administrador </div> </div>';
												echo '<div id="registro_2" class="class_registro_2">';
													echo '<div id="campo_usuario">Usuario <br/><input type= "text" name="nick_usuario" id="nick_usuario" /></div>';
													echo '<div id="campo_clave">Contrase&ntilde;a <br/><input type="password" id="pasword_usuario" name="pasword_usuario" /><br />';
													echo '<input type="hidden" name="validar" value = "si" /><br/><input type="submit" name="Submit" value="'.txt_enviar_user.'" /></div>';
												echo '</div>';
												echo'<div id="registro_3" class="class_registro_3">';
													echo'<div id="img_logo" ><img src="imagenes/logo_solo.jpg" title="Nazep" alt="Nazep"/></div>';
												echo'</div>';
												echo '<div id="div_perdio_contra" class="class_div_perdio_contra" >';
													echo '<a href="index.php?cambiar=contra" title="'.txt_perdio_contra.'" > '.txt_perdio_contra.'</a>';
												echo '</div>';
												echo '<div id="div_rec_bloqueo" class="class_div_rec_bloqueo" >';
													echo '<a href="index.php?cambiar=bloqueo" title="'.txt_bloqueo_user.'" > '.txt_bloqueo_user.'</a>';
												echo '</div>';
												echo '<div id="validador_registro"> ';
													echo '<a href="http://validator.w3.org/check?uri=referer">';
													if(file_exists("http://www.w3.org/Icons/valid-xhtml10"))
														{echo'<img class="imagenes_enlaces" src="http://www.w3.org/Icons/valid-xhtml10.gif" title="Valid XHTML 1.0 Transitional" alt="Valid XHTML 1.0 Transitional"  />';}
													else
														{ echo'<img class="imagenes_enlaces" src="imagenes/valid-xhtml10.gif" title="Valid XHTML 1.0 Transitional" alt="Valid XHTML 1.0 Transitional"   />';}
													echo '</a>';
												echo '</div>';
											echo '</div>';
										echo '</form>';
								}
							
							echo '</body>';
						echo '</html>';
					}
				elseif(isset($_POST["validar"]) && $_POST["validar"]=="si")
					{
						if(isset($_POST["cambiar"]) && $_POST["cambiar"]=="bloqueo")
							{
								$conexion = $this->conectarse();
								$nick_usuario = $_POST["nick_usuario_bloqueo"];
								$con_bloqueo = "select nick_user, nombre, email from nazep_usuarios_admon where nick_user = '$nick_usuario' and situacion='bloqueado'";
								$res_bloqueo = mysql_query($con_bloqueo);
								$cantidad_bloqueo = mysql_num_rows($res_bloqueo);
								$estado_proceso='fallo';
								$mensaje_error='0';
								if($cantidad_bloqueo!=0)
									{
										$ren_bloqueo=mysql_fetch_array($res_bloqueo);
										$alias_usuario =  $ren_bloqueo["nick_user"];
										$nombre_usuario = $ren_bloqueo["nombre"];
										$email_usuario = $ren_bloqueo["email"];
										$str = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
										$pass = '';
										for($i=0;$i<7;$i++) 
											{
												$pass .= substr($str,rand(0,55),1);
											}
										$pasword1 = md5($pass);
										$update_user="update nazep_usuarios_admon set pasword= '$pasword1', situacion='activo' where nick_user = '$nick_usuario' and situacion='bloqueado'";
										mysql_query("START TRANSACTION;");
										if (!@mysql_query($update_user))
											{	
												$estado_proceso ='fallo';
												$mensaje_error='2';
											}
										else
											{
												require("../librerias/phpmailer/class.phpmailer.php");
												$mail = new PHPMailer ();
												$mail->SetLanguage("es","../librerias/phpmailer/language/");
												$con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp,mensaje_nuevo_usuario_admon, url_sitio from nazep_configuracion";
												$res_con = mysql_query($con_conf);
												$ren_con = mysql_fetch_array($res_con);
												$envio_correo = $ren_con["envio_correo"];
												$servidor_smtp = $ren_con["servidor_smtp"];
												$user_smtp = $ren_con["user_smtp"];
												$pass_smtp	= $ren_con["pass_smtp"];
												$mensaje_nuevo_usuario_admon = $ren_con["mensaje_nuevo_usuario_admon"];
												$url_sitio = $ren_con["url_sitio"];
												$con_datos_user = "select nombre, email from nazep_usuarios_admon where nick_user = 'admin'";
												$res_datos = mysql_query($con_datos_user);
												$ren_datos = mysql_fetch_array($res_datos);
												$nombre_ad = $ren_datos["nombre"];
												$email_ad = $ren_datos["email"];
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
												$mail->From = $email_ad;
												$mail->FromName = " ".$nombre_ad." ";
												$mail->AddAddress ($email_usuario, $nombre_usuario);
												$mail->IsHTML(true);
												$mail->Subject = "Desbloqueo de Usuario";
												$mail->Body =
												"<strong>Hola $nombre</strong>
												<br/><br/>
												El Usuario ha sido desbloqueado y se le ha asiganado una nueva contrase�a
												<br /><br />
												Nick: $alias_usuario.
												<br />
												Pasword: $pass
												<br /><br />
												Direcci�n de administraci�n:
												<br /><br />
												$url_sitio/admon/index.php
												<br /><br /><br />
												Atentamente
												<br /><br />
												$nombre_ad"; 
												if(!$mail->Send()) 
													{
														$men = $mail->ErrorInfo;
														$paso = false;
														mysql_query("ROLLBACK;");
														$estado_proceso ='fallo';
														$mensaje_error='3';
													}
												else 
													{
														$estado_proceso ='paso';
														$mensaje_error='0';
													}
											}
									}
								else
									{
										$estado_proceso ='fallo';
										$mensaje_error='1';
									}
								header("Location:?cambiar=bloqueo&sit=$estado_proceso&mensaje=$mensaje_error");
							}
						elseif(isset($_POST["cambiar"]) && $_POST["cambiar"]=="contra")
							{
								$conexion = $this->conectarse();
								$nick_usuario = $_POST["nick_usuario_contras"];
								$con_bloqueo = "select nick_user, nombre, email from nazep_usuarios_admon where nick_user = '$nick_usuario' and situacion ='activo'";
								$res_bloqueo = mysql_query($con_bloqueo);
								$cantidad_bloqueo = mysql_num_rows($res_bloqueo);
								$estado_proceso='fallo';
								$mensaje_error='0';
								if($cantidad_bloqueo!=0)
									{
										$ren_bloqueo=mysql_fetch_array($res_bloqueo);
										$alias_usuario =  $ren_bloqueo["nick_user"];
										$nombre_usuario = $ren_bloqueo["nombre"];
										$email_usuario = $ren_bloqueo["email"];
										$str = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
										$pass = '';
										for($i=0;$i<7;$i++) 
											{
												$pass .= substr($str,rand(0,55),1);
											}
										$pasword1 = md5($pass);
										$update_user="update nazep_usuarios_admon set pasword= '$pasword1' where nick_user = '$nick_usuario' ";
										mysql_query("START TRANSACTION;");
										if (!@mysql_query($update_user))
											{	
												$estado_proceso ='fallo';
												$mensaje_error='2';
											}
										else
											{
												require("../librerias/phpmailer/class.phpmailer.php");
												$mail = new PHPMailer ();
												$mail->SetLanguage("es","../librerias/phpmailer/language/");
												$con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp, 
												mensaje_nuevo_usuario_admon, url_sitio from nazep_configuracion";
												$res_con = mysql_query($con_conf);
												$ren_con = mysql_fetch_array($res_con);
												$envio_correo = $ren_con["envio_correo"];
												$servidor_smtp = $ren_con["servidor_smtp"];
												$user_smtp = $ren_con["user_smtp"];
												$pass_smtp	= $ren_con["pass_smtp"];
												$mensaje_nuevo_usuario_admon = $ren_con["mensaje_nuevo_usuario_admon"];
												$url_sitio = $ren_con["url_sitio"];
												$con_datos_user = "select nombre, email from nazep_usuarios_admon where nick_user = 'admin'";
												$res_datos = mysql_query($con_datos_user);
												$ren_datos = mysql_fetch_array($res_datos);
												$nombre_ad = $ren_datos["nombre"];
												$email_ad = $ren_datos["email"];
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
												$mail->From = $email_ad;
												$mail->FromName = " ".$nombre_ad." ";
												$mail->AddAddress ($email_usuario, $nombre_usuario);
												$mail->IsHTML(true);
												$mail->Subject = "Cambio de Contrase�a de Usuario";
												$mail->Body =
												"<strong>Hola $nombre</strong>
												<br/><br/>
												El Usuario se le ha asiganado una nueva contrase�a
												<br /><br />
												Nick: $alias_usuario.
												<br />
												Pasword: $pass
												<br /><br />
												Direcci�n de administraci�n:
												<br /><br />
												$url_sitio/admon/index.php
												<br /><br /><br />
												Atentamente
												<br /><br />
												$nombre_ad"; 
												if(!$mail->Send()) 
													{
														$men = $mail->ErrorInfo;
														$paso = false;
														mysql_query("ROLLBACK;");
														$estado_proceso ='fallo';
														$mensaje_error='3';
													}
												else 
													{
														$estado_proceso ='paso';
														$mensaje_error='0';
													}
											}
									}
								else
									{
										$estado_proceso ='fallo';
										$mensaje_error='1';
									}
								header("Location:?cambiar=contra&sit=$estado_proceso&mensaje=$mensaje_error");
							}
						else
							{
								$nick_usuario = addslashes($_POST["nick_usuario"]);
								$pasword_usuario = $_POST["pasword_usuario"];
								$pasword_usuario = md5($pasword_usuario);
								$con_usuario = "select u.nick_user, u.nombre, u.nivel, us.clave_seccion, u.email from nazep_usuarios_admon u, nazep_usuarios_secciones_admon us
								where u.nick_user = '$nick_usuario' and u.pasword = '$pasword_usuario' 
								and u.situacion = 'activo' and us.situacion = 'activo' and u.nick_user = us.nick_user";
								$conexion = $this->conectarse();
								$resultado = mysql_query($con_usuario);
								$cantidad = mysql_num_rows($resultado);
								$ip_acceso= $_SERVER['REMOTE_ADDR'];
								$fecha_acceso = date("Y-m-d");
								$hora_acceso = date ("H:i:s");	
								$hora_unix = time();
								if ($cantidad != 0)
									{
										$con = 0;
										while($renglon = mysql_fetch_array($resultado))
											{
												$nick_user_t = $renglon["nick_user"];
												$nombre_t = $renglon["nombre"];
												$mail_t  = $renglon["email"];
												$nivel_t = $renglon["nivel"];
												$clave_seccion_t = $renglon["clave_seccion"];
												$this->nick_user = $nick_user_t;
												$this->nombre = $nombre_t;
												$this->nivel = $nivel_t;
												$this->correo_user = $mail_t;
												$this->sesion = "si"; 
												$this->secciones[$con] = $clave_seccion_t;
												$con++;
											}
										$con_config = 'select resolucion_ancho from nazep_configuracion where 1 limit 1';
										$res_config = mysql_query($con_config);
										$ren_config = mysql_fetch_array($res_config);
										$this->ancho_pixeles = $ren_config["resolucion_ancho"];
										$con_insetar = "insert into nazep_registro_acceso values('','$nick_usuario','$ip_acceso','$fecha_acceso','$hora_unix ','$hora_acceso','entro','admon')";
										if (!@mysql_query($con_insetar))
											{
												$men = mysql_error();
												echo "Error: ".$men;
											}
										else
											{
												$this->desconectarse($conexion);
												header("Location: index.php");
											}
										$this->desconectarse($conexion);
										header("Location: index.php");
									}	
								else
									{	
										$con_insetar = "insert into nazep_registro_acceso values('','$nick_usuario','$ip_acceso','$fecha_acceso','$hora_unix','$hora_acceso','fallo','admon')";
										if (!@mysql_query($con_insetar))
											{
												$men = mysql_error();
												echo "Error: ".$men;
											}
										else
											{
												$hora_unix_consulta = $hora_unix-10;
												$con_user_fallo= "select count(clave_acceso) as cantidad_fallos from nazep_registro_acceso  where estado_intento = 'fallo' and nick_user = '$nick_usuario' and fecha_intento  = '$fecha_acceso' and hora_unix >= '$hora_unix_consulta'";
												$res_user_fallo = mysql_query($con_user_fallo);
												$ren_user_fallo = mysql_fetch_array($res_user_fallo);
												$cantidad_fallos = $ren_user_fallo["cantidad_fallos"];
												if($cantidad_fallos>=5)
													{
														
														$cancelar_user = "update nazep_usuarios_admon set situacion = 'bloqueado' where nick_user = '$nick_usuario'";
														if (!@mysql_query($cancelar_user))
															{	
																$men = mysql_error();
																echo "Error: ".$men;
															}	
														else
															{ header("Location: index.php?error_usuario=si&user=$nick_usuario&bloqueo=si"); }
													}
												else
													{
														$this->desconectarse($conexion);
														header("Location: index.php?error_usuario=si&intentos=$cantidad_fallos");
														
													}
											}
									}
							}
					}
			}
//**********************************************
		function firma()
			{
				echo '
<!--
// ***************************************************************
// ********************** NAZEP **********************************
// *** Administrador de Contenidos Web ***
// *** Desarrollador Claudio Morales Godinez ***
// *** Correo: claudio@nazep.com.mx ***
// *** Sitio Web : http://www.nazep.com.mx ***
// *** V 0.2 ***
// ***************************************************************
-->';
			}
		function cabeza_html($opcion)
			{
				$conexion = $this->conectarse();
				$con_config = "select resolucion_ancho from nazep_configuracion";
				$res_config = mysql_query($con_config);
				$ren_config = mysql_fetch_array($res_config);
				$this->ancho_pixeles = $ren_config["resolucion_ancho"];
				echo '<?xml version="1.0" encoding="utf-8"?>';
				echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
				echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">';
					echo '<head>';
						echo '<title> .::. '.titulo_admon.' .::. </title>';
						echo '<link rel="SHORTCUT ICON" href="imagenes/favicon.ico" />
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<link rel="STYLESHEET" type="text/css" href="estilos.css" />
							<script type="text/javascript" src="../librerias/jquery/jquery-1.3.2.min.js"></script>
							<script type="text/javascript" src="../librerias/jquery/jquery_nazep_admon.js"></script>
						</head><body>';
			}
		function cabeza()
			{
				$nombre_tem = $this->nombre;
				$nivel_tem = $this->nivel;
				$niveles_tem = FunGral::niveles();
				$nivel_tem = $niveles_tem[$nivel_tem];
				echo '<div id ="marco_cabeza">&nbsp;<strong>'.$nombre_tem .'<br />&nbsp;'.$nivel_tem.'</strong></div> ';
				echo '<div id ="marco_cabeza_der_'.$this->ancho_pixeles.'"></div>';
			}
		function menu($opcion)
			{
				$ancho = 5;
				$contador= 2;
				$nivel_tem = $this->nivel;
				if($nivel_tem==1)
					{
						$ancho = 6;
						$contador= 3;
					}
				$medidas_ancho = round($this->ancho_pixeles/$ancho);
				echo '<div id ="menu_admon_'.$this->ancho_pixeles.'">';
					echo '<div style = "text-align:center; position:absolute; width:'.$medidas_ancho.'px; top:0px; left:0px; padding-top:7px;" >';
					echo '<a href="index.php" title=".: '.titulo_btn_incio.' :."><img src ="imagenes/inicio.gif" border="0" alt = "'.titulo_btn_incio.'" /></a></div>';
					echo '<div style = "text-align:center; position:absolute; width:'.$medidas_ancho.'px; top:0px; left:'.$medidas_ancho.'px; padding-top:7px;" >';
					echo '<a href="index.php?opc=1" title=".: '.titulo_btn_secciones.' :."><img src ="imagenes/secciones.gif" border="0" alt = "'.titulo_btn_secciones.'" /></a></div>';
					if($nivel_tem=="1")
						{
							echo '<div style = "text-align:center; position:absolute; width:'.$medidas_ancho.'px; top:0px; left:'.($medidas_ancho*2).'px; padding-top:7px;">';
							echo '<a href="index.php?opc=2" title=".: '.titulo_btn_configuracion.' :."><img src ="imagenes/configuracion.gif" border="0" alt = "'.titulo_btn_configuracion.'" /></a></div>';
						}
					echo '<div style = "text-align:center; position:absolute; width:'.$medidas_ancho.'px; top:0px; left:'.($medidas_ancho*$contador).'px; padding-top:7px;">';
						echo '<a href="index.php?opc=3" title=".: '.titulo_btn_config_user.' :."><img src="imagenes/usuario.gif" border="0"  alt = "'.titulo_btn_config_user.'" /></a></div>';
					$contador++;
					$cadena_adicional_vista = "";
					if( isset($_GET["opc"]) and ( ($_GET["opc"]=="111") or ($_GET["opc"]=="11") or ($_GET["opc"]=="12")) and (isset($_GET["clave_seccion"]) && $_GET["clave_seccion"]!=""))
						{
							$clave_seccion_vista = $_GET["clave_seccion"];
							$cadena_adicional_vista = "?sec=$clave_seccion_vista";
						}
					echo '<div style = "text-align:center; position:absolute; width:'.$medidas_ancho.'px; top:0px; left:'.($medidas_ancho*$contador).'px; padding-top:7px;">';
						echo '<a href="../index.php'.$cadena_adicional_vista.'" title=".: '.titulo_btn_vista_final.' :." target="_blank"><img src="imagenes/preview.gif" border="0"  alt = "'.titulo_btn_vista_final.'" /></a></div>';
					$contador++;
					echo '<div style = "text-align:center; position:absolute; width:'.$medidas_ancho.'px; top:0px; left:'.($medidas_ancho*$contador).'px; padding-top:7px; ">';
					echo '<a href="index.php?salir=si" title=".: '.titulo_btn_salir.' :."><img src ="imagenes/salida.gif" border="0"  alt = "'.titulo_btn_salir.'" /></a></div>';
				echo '</div>';
			}
		function cuerpo()
			{
				$conexion = $this->conectarse();
				$con_tema = "select t.ubicacion, c.lenguaje, c.titu_sitio from nazep_configuracion c, nazep_temas t where c.clave_tema = t.clave_tema";
				$res_con = mysql_query($con_tema);
				$ren_con = mysql_fetch_array($res_con);
				$ubicacion = $ren_con["ubicacion"];	
				$lenguaje = $ren_con["lenguaje"];
				$this->ubi_tema = directorio_temas.$ubicacion."/";
				include("../librerias/idiomas/$lenguaje/01_administracion.php");
				$this->desconectarse($conexion);
				if($this->sesion=='no')
					{ $this->validar_usuario(); 	}
				else
					{
						if(!isset($_GET["opc"]) or $_GET["opc"]==0 or $_GET["opc"]=="")
							{$opcion = 0;}
						else
							{
								$opcion = $_GET["opc"];
								if(!is_numeric($opcion))
									{$opcion = 0;}
								if($opcion<0)
									{$opcion = 0;}
							}
						if(isset($_GET["refrescar"]) && $_GET["refrescar"]=="si")
							{
								$this->refrescar();
							}
						elseif(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
							{
								$this->cuerpo_central($opcion);
							}
						elseif(isset($_GET["opc"]) && $_GET["opc"]=="4")
							{
								$this->cabeza_html($opcion);
								$this->firma();
								$this->cabeza();
								$this->menu($opcion);
								echo '<div id ="cuerpo_centro_'.$this->ancho_pixeles.'">';
								$this->cuerpo_error();
								$this->pie();
								echo '</div>';	
								$this->pie_html();
							}
						else
							{
								if(isset($_GET["opc"]) && $_GET["opc"]=="1111")
									{$this->refrescar_padre();}
								else
									{
										if(isset($_POST["formato_contenido"]) && $_POST["formato_contenido"] != "")
											{
												$this->cabeza_formato($_POST["formato_contenido"]);
												$this->cuerpo_central($opcion);
											}
										else
											{
												$this->cabeza_html($opcion);
												$this->firma();
												$this->cabeza();
												$this->menu($opcion);
												echo '<div id ="cuerpo_centro_'.$this->ancho_pixeles.'">';
												$this->cuerpo_central($opcion);
												$this->pie();	
												echo '</div>';
												$this->pie_html();
											}
									}
							}
					}
			}	
		function cabeza_formato($formato)
			{
				if($formato == "excel")
					{
						header("Content-type: application/vnd.ms-excel");
						header("Content-Disposition: attachment; filename=archivo_nazep.xls");
						header("Pragma: no-cache");
					}
				elseif($formato == "word")
					{
						header("Content-type: application/vnd.msword");
						header("Content-Disposition: attachment; filename=archivo_nazep.doc");
						header("Pragma: no-cache");
					}
			}
		function cuerpo_error()
			{
				if($_GET["tipo"]!='')
					{
						$tipo = $_GET["tipo"];
						$men = $_GET["men"];
						$erro = $_GET["erro"];
						HtmlAdmon::titulo_seccion("<strong>".erro_erro_db."</strong>");
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><strong>'.erro_tipo_error.': </strong>'.$tipo.'<td></td></tr>';
							echo '<tr><td><strong>'.erro_num_sent.': </strong>'.$men.'</td></tr>';
							echo '<tr><td><strong>'.erro_detalle.': </strong>'.$erro.'</td></tr>';
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" ><tr><td align ="center">';
								echo '<a href="index.php" class="regresar"><img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br /><strong>'.erro_reg_ini.'</strong></a>';
						echo '</td></tr></table>';
					}
				else
					{
						$tipo = $_POST["mensaje1"];
						$men = $_POST["mensaje2"];
						$erro = $_POST["mensaje3"];
						$modulo = $_POST["modulo"];
						$proceso = $_POST["proceso"];
						$clave_seccion = $_POST["clave_seccion"];
						$opc = $_POST["opc"];
						if($opc==11)
							{$tex_opc = 'Modificar';}
						else
							{$tex_opc = 'Control de Cambios';}
						$nombre_sec = HtmlAdmon::historial($clave_seccion);
						HtmlAdmon::titulo_seccion("<strong>".erro_erro_db."</strong>");
						echo'<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
							echo'<tr><td><strong> '.erro_sec_err.': </strong>'.$nombre_sec.'</td></tr>';
							echo'<tr><td><strong> '.erro_mod_err.': </strong>'.$modulo.'</td></tr>';
							echo'<tr><td><strong> '.erro_pro_err.': </strong>'.$proceso.'</td></tr>';
							echo'<tr><td><strong>'.erro_tip_err.': </strong>'.$tipo.'</td></tr>';
							echo'<tr><td><strong>'.erro_num_sen.': </strong>'.$men.'</td></tr>';
							echo'<tr><td><strong>'.erro_det_err.': </strong>'.$erro.'</td></tr>';
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align="center">';
								echo '<a href="index.php?opc='.$opc.'&amp;clave_seccion='.$clave_seccion.'" class="regresar">';
								echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
								echo '<strong>'.erro_regres_1.' '.$tex_opc.' '.erro_regres_2.' </strong></a>';
							echo'</td></tr>';
						echo '</table>';
					}
			}
		function cuerpo_central($opcion)
			{
				switch ($opcion) 
					{
						case 0:
							$this->incio_home();
						break;
						case 1:
							$this->secciones_home();
						break;
						case 11:
							$this->modificar_seccion();
						break;
						case 111:
							$this->cargar_modulos_modificacion();
						break;	
						case 12:
							$this->cambios_seccion();
						break;
						case 13:
							$this->crear_nueva_seccion();
						break;
						case 14:
							$this->estadisticas_seccion();
						break;
						case 2:
							$this->administracion_home();
						break;
						case 3:
							$this->datos_usuario();
						break;
						default:
					}
			}		
		function pie()
			{
				echo'<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0">';
					echo'<tr><td width="50%" >&nbsp;</td><td width="50%" >&nbsp;</td></tr>';
					echo'<tr><td height="20" width="50%" align = "right" valign="bottom">';
						echo'<a href="http://validator.w3.org/check?uri=referer">';
						if(file_exists("http://www.w3.org/Icons/valid-xhtml10"))
							echo'<img  border = "0" src="http://www.w3.org/Icons/valid-xhtml10.gif" alt="Valid XHTML 1.0 Transitional" height="31" width="88" />';
						else
							echo'<img  border = "0" src="imagenes/valid-xhtml10.gif" alt="Valid XHTML 1.0 Transitional" height="31" width="88" />';
						echo'</a>';
					echo '</td><td height="20" width="50%" align = "left" valign="bottom">';
						echo '<a href="http://www.nazep.com.mx" class="derechos" target="_blank" title="Portal oficial de nazep">Nazep</a><span class="derechos"> &copy;<br /> Todos los Derechos Reservados 2007<br />Claudio Morales Godinez</span>';
					echo '</td></tr>';
				echo '</table>';
			}
		function pie_html()
			{echo '</body></html>';	}
//********************************************************************
		function incio_home()
			{
				$cons_noticias = "select ver_noticias, ver_pag_inicio, pag_inicio, cant_noticias_admon from nazep_configuracion";
				$conexion = $this->conectarse();
				$res_con = mysql_query($cons_noticias);
				$ren_con = mysql_fetch_array($res_con);
				$ver_noticias = $ren_con["ver_noticias"];
				$ver_pag_inicio = $ren_con["ver_pag_inicio"];
				$pag_inicio = $ren_con["pag_inicio"];
				$can_noticias = $ren_con["cant_noticias_admon"];
				$con_comentarios = 
				"select count(com.clave_comentario_art), sec.nombre, tipoart.clave_seccion, tipoart.clave_tipo 
				from nazep_zmod_articulos_comentarios com, nazep_zmod_articulos art, nazep_zmod_articulos_tipos tipoart, nazep_secciones sec 
				where tipoart.clave_tipo = art.clave_tipo and art.clave_articulo = com.clave_articulo and sec.clave_seccion = tipoart.clave_seccion and com.leido = 'NO' group by  sec.clave_seccion";
				$res_datos = mysql_query($con_comentarios);
				$can_resultados = mysql_num_rows($res_datos);
				if($can_resultados>0)
					{
						echo '<div style="text-align:center;" ><strong>Comentarios en Art&iacute;culos sin leer</strong></div>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
						while($ren_datos = mysql_fetch_array($res_datos))
							{
								$nombre = $ren_datos["nombre"];
								$clave_seccion_art  = $ren_datos["clave_seccion"];
								$cantidad  = $ren_datos["count(com.clave_comentario_art)"];
								$clave_tipo_art  = $ren_datos["clave_tipo"];
								echo '<tr>';
									echo '<td align="right"> '.$nombre.'&nbsp;<strong>('.$cantidad.')</strong></td>';
									echo '<td align="left" width="50%">';
										echo '<form name="buscar_comentarios_estado" name="buscar_comentarios_estado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_art.'" class="margen_cero">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "admon_comentarios" />';
										echo '<input type="hidden" name="buscar" value ="si" />';
										echo '<input type="hidden" name="leido" value ="NO" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_art.'" />';
										echo '<input type="hidden" name="clave_tipo" value ="'.$clave_tipo_art.'" />';
										echo '<input type="submit" name="btn_buscar" value="Ver Comentarios" />';
										 echo '</form>';
									echo '</td>';
								echo '</tr>';
							}
						echo '</table>';
					}
				if(($ver_pag_inicio=="si") and ($_GET["clave_noticia_admon"]=="") )
					{echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"><tr><td align="center">'.$pag_inicio.'</td></tr><tr><td align="center"><hr /></td></tr></table>';}
				if($ver_noticias =='si')
					{
						if(isset($_GET["clave_noticia_admon"]) && $_GET["clave_noticia_admon"]!="")
							{
								$clave_noticia_admon = $_GET["clave_noticia_admon"];
								if (!is_numeric($clave_noticia_admon))
									$clave_noticia_admon=1;								
								if($clave_noticia_admon<0)
										$clave_noticia_admon=1;
								$con_noticia = "select fecha_noticia, titulo, cuerpo from nazep_noticias_admo where clave_noticia_admon = '$clave_noticia_admon'";
								$res_noticia = mysql_query($con_noticia);
								$ren_noticia = mysql_fetch_array($res_noticia);
								$fecha_noticia = $ren_noticia["fecha_noticia"];
								$fecha_noticia = FunGral::fechaNormal($fecha_noticia);
								$titulo = $ren_noticia["titulo"];
								$cuerpo = $ren_noticia["cuerpo"];
								HtmlAdmon::titulo_seccion(not_adm_tit_lis);
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0">';
									echo '<tr><td>&nbsp;</td></tr>';
									echo '<tr><td align="center"><strong>'.$titulo.'</strong></td></tr>';
									echo '<tr><td>&nbsp;</td></tr>';
									echo '<tr><td align="left">'.$fecha_noticia.'</td></tr>';
									echo '<tr><td>&nbsp;</td></tr>';
									echo '<tr><td align="left">'.$cuerpo.'</td></tr>';
									echo '<tr><td><hr /></td></tr>';
								echo '</table>';
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align ="center">';
										echo '<a href="index.php" class="regresar"><img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
										echo '<strong>'.not_adm_reg_lis.'</strong></a>';
									echo '</td></tr>';
								echo '</table>';
							}
						else
							{
								$con_not_li_t = "select clave_noticia_admon, titulo, resumen, fecha_noticia, hora_noticia
								from nazep_noticias_admo  where situacion = 'activo' order by fecha_noticia desc, hora_noticia desc";
								$res_not_li_t = mysql_query($con_not_li_t);
								$can_not_li_t = mysql_num_rows($res_not_li_t);
								if(!isset($_GET["clave_noticia_admon"]) || $_GET["pagina"]=="")
									{
										$pagina= 1;
										$inicio = 0;
									}
								else
									{
										$pagina = $_GET["pagina"];
										$inicio = ($pagina - 1) * $can_noticias;
									}
								$total_paginas = ceil($can_not_li_t/$can_noticias);
								
								$con_not_li = "select clave_noticia_admon, titulo, resumen, fecha_noticia, hora_noticia
								from nazep_noticias_admo where situacion = 'activo' order by fecha_noticia desc, hora_noticia desc  limit $inicio, $can_noticias";	
								$res_not_li = mysql_query($con_not_li);
								HtmlAdmon::titulo_seccion(not_adm_tit_lis);
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0">';
									echo '<tr><td>&nbsp;</td></tr>';
									while($ren = mysql_fetch_array($res_not_li))
										{
											$clave_noticia_admon = $ren["clave_noticia_admon"];
											$titulo = $ren["titulo"];
											$resumen = $ren["resumen"];
											$fecha_noticia = $ren["fecha_noticia"];
											$fecha_noticia = FunGral::fechaNormal($fecha_noticia);
											$hora_noticia = $ren["hora_noticia"];
											echo '<tr><td align="center"><strong>'.$titulo.'</strong></td></tr><tr><td>&nbsp;</td></tr>';
											echo '<tr><td align="left">'.$fecha_noticia.'<br />'.$hora_noticia.'</td></tr><tr><td>&nbsp;</td></tr>';
											echo '<tr><td align="left">'.$resumen.'</td></tr><tr><td>&nbsp;</td></tr>';
											echo '<tr><td align="left"><a href= "index.php?clave_noticia_admon='.$clave_noticia_admon.'">'.leer_mas.'</a></td></tr><tr><td><hr /></td></tr>';
										}
								echo '</table>';
								if($total_paginas > 1)
									{
										echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">';
											echo '<tr><td align = "center">'.pag_not.'</td></tr>';
											echo '<tr><td align = "center">';
											for ($i=1;$i<=$total_paginas;$i++)
												{
													if ($pagina == $i)		
														echo '&nbsp;<strong>'.$pagina.'</strong>&nbsp;';
													else
														echo '&nbsp;<a href="index.php?pagina='.$i.'">'.$i.'</a>&nbsp;';
												}
											echo '</td></tr>';
										echo '</table>';
									}
							}
					}
				echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0">';
					echo '<tr><td align="center"><br /><img src="imagenes/bienvenido.jpg" alt ="'.img_inicio.'"/></td></tr>';	
				echo '</table>';
			}
		function secciones_home()
			{		
				if($this->nivel==1)
					{
						$clave_seccion_tra = 1;
						if(isset($_GET["clave_seccion"]))
							{ $clave_seccion_tra = $_GET["clave_seccion"]; }								
						$consulta_nombres = "select nombre, clave_seccion, orden, situacion from nazep_secciones where clave_seccion_pertenece = '$clave_seccion_tra' order by orden";
						$conexion = $this->conectarse();
						$res_con = mysql_query($consulta_nombres);	
						$nombre = HtmlAdmon::historial($clave_seccion_tra);
						HtmlAdmon::titulo_seccion("".sepr_titulo_opcion." \"$nombre\"");	
						echo '<table width="'.$this->ancho_pixeles.'" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td width="10" align="center">'.sepr_titulo_orden.'</td>';
								echo '<td align="center">'.sepr_tabla_sec.'</td>';
								echo '<td align="center">'.sepr_titulo_situacion.'</td>';
								echo '<td align="center">'.sepr_titulo_listar.'</td>';
								echo '<td align="center">'.sepr_titulo_modificar.'</td>';
								echo '<td align="center">'.sepr_titulo_cambios.'</td>';
								echo '<td align="center">'.sepr_titulo_estadisticas.'</td>';
							echo '</tr>';
							if($clave_seccion_tra==1)
								{
									echo '<tr>';
										echo '<td align="center">0</td><td align = "center">'.sepr_tl_inicio.'</td><td>&nbsp;</td><td>&nbsp;</td>';
										echo '<td align = "center">';
											echo '<a href="index.php?opc=11&amp;clave_seccion=1">';
											echo '<img src="imagenes/cambios.gif" border = "0" alt="'.sepr_enlace_realizar_cambios.'" title = ".: '.sepr_enlace_realizar_cambios.' '.a_la_seccion.' '.sepr_tl_inicio.' :." /></a>';
										echo '</td>';
										echo '<td align = "center">';	
											echo '<a href="index.php?opc=12&amp;clave_seccion=1">';
											echo '<img src="imagenes/control_cambios.gif" border = "0" alt="'.sepr_enlace_control_cambios.'" title = ".: '.sepr_enlace_control_cambios.' '.de_la_seccion.' '.sepr_tl_inicio.' :." /></a>';
										echo '</td>';
										echo '<td align = "center">';	
											echo '<a href="index.php?opc=14&amp;clave_seccion=1">';
											echo '<img src="imagenes/estadisticas.gif" border = "0" alt="'.sepr_enlace_estadisticas.'" title = ".: '.sepr_enlace_estadisticas.' '.de_la_seccion.' '.sepr_tl_inicio.' :." /></a>';
										echo '</td>';
									echo '</tr>';
								}
								while($ren = mysql_fetch_array($res_con))
									{
										$nombre = $ren["nombre"];
										$clave_seccion =  $ren["clave_seccion"];
										$orden =  $ren["orden"];
										$situacion =  $ren["situacion"];
										echo '<tr>';
											echo '<td align="center">'.$orden.'</td>';	
											echo '<td align = "center">'.$nombre.'</td>';	
											echo '<td align="center">';
											if($situacion=="activo")
												echo '<img src="imagenes/activo.gif" border = "0" alt="'.activo.'" title = ".: '.activo.' :." />';
											elseif($situacion=="cancelado")
												echo '<img src="imagenes/cancelado.gif" border = "0" alt="'.cancelado.'" title = ".: '.cancelado.' :." />';
											elseif($situacion=="oculto")
												echo '<img src="imagenes/invisible.gif" border = "0" alt="'.oculto.'" title = ".: '.oculto.' :." />';
											echo'</td>';	
											echo '<td align = "center">';
												echo '<a href="index.php?opc=1&amp;clave_seccion='.$clave_seccion.'">';
												echo '<img src="imagenes/listar_subsecc.gif" border = "0" alt="'.sepr_enlace_listar_sub.'" title = ".: '.sepr_enlace_listar_sub.' '.de_la_seccion.' '.$nombre.' :." /></a>';
											echo '</td>';
											echo '<td align ="center">';
												echo '<a href="index.php?opc=11&amp;clave_seccion='.$clave_seccion.'">';
												echo '<img src="imagenes/cambios.gif" border = "0" alt="'.sepr_enlace_realizar_cambios.'" title = ".: '.sepr_enlace_realizar_cambios.' '.a_la_seccion.' '.$nombre.' :." /></a>';
											echo '</td>';
											echo '<td align ="center">';	
												echo '<a href="index.php?opc=12&amp;clave_seccion='.$clave_seccion.'">';
												echo '<img src="imagenes/control_cambios.gif" border = "0" alt="'.sepr_enlace_control_cambios.'" title = ".: '.sepr_enlace_control_cambios.' '.de_la_seccion.' '.$nombre.' :." /></a>';
											echo '</td>';
											echo '<td align="center">';	
												echo '<a href="index.php?opc=14&amp;clave_seccion='.$clave_seccion.'">';
												echo '<img src="imagenes/estadisticas.gif" border = "0" alt="'.sepr_enlace_estadisticas.'" title = ".: '.sepr_enlace_estadisticas.' '.de_la_seccion.' '.$nombre.' :." /></a>';
											echo '</td>';
										echo '</tr>';
									}
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td width="50"align="left"></td>';
								echo '<td align="left"><br />';
									$titulo_nuevo = sepr_tabla_sec;
									if($clave_seccion_tra != 1)										
										$titulo_nuevo = sepr_tabla_subsec;
									echo '<a href="index.php?opc=13&amp;clave_seccion='.$clave_seccion_tra.'" title=".: '.crear_nueva.' '.$titulo_nuevo.' :.">';
										echo '<img src="imagenes/nueva_secc.gif" border = "0" alt="'.sepr_enlace_estadisticas.'" title = ".: '.crear_nueva.' '.$titulo_nuevo.' :." /></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
						$con_seciones = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$clave_seccion_tra'";
						$res_sec = mysql_query($con_seciones);
						$ren = mysql_fetch_array($res_sec);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"];
						if($clave_seccion_pertenece=="")
							{$clave_seccion_pertenece=1;}
						else
							{
								echo '<br /><table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0">';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<a href="index.php?opc=1&amp;clave_seccion='.$clave_seccion_pertenece.'" class="regresar">';
											echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'"/><br /><strong>';
											echo sepr_enlace_regresar_secc;
											echo '</strong></a>';
										echo '</td>';
									echo '</tr>';
								echo '</table>';
							}
						$this->desconectarse($conexion);
					}
				else
					{
						$tem_secciones = $this->secciones;
						$cantidad = count($tem_secciones);
						for($a=0;$a<$cantidad;$a++)
							{
								$tem_con .= " clave_seccion = '".$tem_secciones[$a]."'" ;
								if($a<$cantidad-1)
									{ $tem_con .= ' or'; }
							}
						$consulta_nombres ="select nombre, clave_seccion from nazep_secciones where situacion != 'cancelado' and (".$tem_con.") ";
						$conexion = $this->conectarse();
						$res_con = mysql_query($consulta_nombres);
						HtmlAdmon::titulo_seccion(sepr_titulo_opcion);
						echo '<table width="'.$this->ancho_pixeles.'" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align ="center">'.sepr_tabla_sec.'</td><td align="center">'.sepr_titulo_modificar.'</td><td align="center">'.sepr_titulo_cambios.'</td></tr>';
							while($ren = mysql_fetch_array($res_con))
								{
									$nombre = $ren["nombre"];
									$clave_seccion =  $ren["clave_seccion"];
									echo '<tr><td>'.$nombre.'</td>';
										echo '<td align="center">';
											echo '<a href="index.php?opc=11&amp;clave_seccion='.$clave_seccion.'">';
												echo '<img src="imagenes/cambios.gif" border = "0" alt="'.sepr_enlace_realizar_cambios.'" title = ".: '.sepr_enlace_realizar_cambios.' '.a_la_seccion.' '.$nombre.' :." /></a>';
										echo '</td>';
										echo '<td align="center">';
											echo '<a href="index.php?opc=12&amp;clave_seccion='.$clave_seccion.'">';
												echo '<img src="imagenes/control_cambios.gif" border = "0" alt="'.sepr_enlace_control_cambios.'" title = ".: '.sepr_enlace_control_cambios.' '.de_la_seccion.' '.$nombre.' :." /></a>';
										echo '</td>';
									echo '</tr>';
								}
						echo '</table>';
						$this->desconectarse($conexion);
					}
			}
		function administracion_home()
			{
				$nivel_tem = $this->nivel;
				$user = $this->nick_user;
				$correo = $this->correo_user;
				if($nivel_tem ==1)
					{
						include("../librerias/configuracion_gral.php");
						if(isset($_POST["metodo"]) && $_POST["metodo"]!="")
							{ $metodo = $_POST["metodo"]; 	}
						else
							{ $metodo = 'opciones'; }
						$obj = new clase_configuracion();
						$obj->$metodo($user,$correo);
					}
				else
					{ $this->acceso_denegado(); }
			}
		function datos_usuario()
			{
				if(isset($_POST["guardar"]) && $_POST["guardar"]!="")
					{
						$formulario_final = $_POST["formulario_final"];
						$nick_user = $_POST["nick_user"];
						$pasword1 = $_POST["pasword1"];
						$pasword2 = $_POST["pasword2"];
						$nombre = $_POST["nombre"];
						$correo_electronico = $_POST["correo_electronico"];
						$direccion = $_POST["direccion"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$set = "nombre = '$nombre', email = '$correo_electronico', direccion = '$direccion', fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy', ip_actualizacion = '$ip'";
						if($pasword1 != "" and $pasword2 != "")
							{
								$pasword1 = md5($pasword1);
								$set .= ", pasword = '$pasword1' ";
							}
						$update = "update nazep_usuarios_admon set ". $set." where nick_user = '$nick_user'";
						$conexion = $this->conectarse();
						if (!@mysql_query($update))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{ echo "termino-,*-$formulario_final"; }
						$this->desconectarse($conexion);
					}
				else
					{
						HtmlAdmon::titulo_seccion(mous_titulo_sec);
						$nick_user = $this->nick_user;
						$con_datos ="select * from nazep_usuarios_admon	where nick_user = '$nick_user'";
						$conexion = $this->conectarse();
						$res_con = mysql_query($con_datos);
						$ren_con = mysql_fetch_array($res_con);
						$nick_user = $ren_con["nick_user"];
						$nombre = $ren_con["nombre"];
						$correo_electronico = $ren_con["email"];
						$direccion = $ren_con["direccion"];
						$clave_nivel = $ren_con["nivel"];
						$situacion = $ren_con["situacion"];
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("modificar_usuario");
									});							
								function validar_form(formulario, nombre_formulario)
									{
										if(formulario.pasword1.value != formulario.pasword2.value) 
											{
												alert("'.mous_alert_pas_dif.'")
												formulario.pasword1.focus();
												return false;
											}	
										if(formulario.nombre.value == "") 
											{
												alert("'.mous_alert_nom_vac.'")
												formulario.nombre.focus();
												return false;
											}
										if(formulario.correo_electronico.value == "") 
											{
												alert("'.mous_alert_cor_vac.'")
												formulario.correo_electronico.focus();
												return false;
											}
										correo = formulario.correo_electronico.value;	
										if(!isEmailAddress(correo))
											{
												alert("'.mous_alert_cor_inc.'");
												formulario.correo_electronico.focus();
												return false;
											}
										if(formulario.direccion.value == "") 
											{
												alert("'.mous_alert_dir_vac.'")
												formulario.direccion.focus();
												return false;
											}
										formulario.btn_guardar.style.visibility="hidden";
										formulario.formulario_final.value = nombre_formulario;
									}';
						echo '</script>';
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "3" /></form>';
						echo '<form name="modificar_usuario" id= "modificar_usuario"  method="post" action="index.php?opc=3" class="margen_cero">';
							echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0">';
								echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
								echo '<tr><td>'.mous_txt_nic_use.'</td><td>'.$nick_user.'</td></tr>';
								echo '<tr><td>'.mous_txt_nue_pas.'</td><td><input type="password" name="pasword1" size="40" /></td></tr>';
								echo '<tr><td>'.mous_txt_rep_pas.'</td><td><input type = "password" name ="pasword2" size = "40" /></td></tr>';
								echo '<tr><td>'.mous_txt_nom_use.'</td><td><input type="text" name="nombre" size="40" value="'.$nombre.'" /></td></tr>';
								echo '<tr><td>'.mous_txt_cor_use.'</td><td><input type="text" name="correo_electronico" size="40" value="'.$correo_electronico.'" /></td></tr>';
								echo '<tr><td>'.mous_txt_dir_use.'</td><td><textarea name="direccion" cols="30" rows="5">'.$direccion.'</textarea></td></tr>';
								echo '<tr><td>&nbsp;</td><td>';
									echo '<input type="hidden" name="formulario_final" value = "" />';
									echo '<input type="hidden" name="guardar" value="si" />';
									echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
									echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
									echo '<input type="submit" name="btn_guardar" value="'.mous_btn_guardar.'" onclick= "return validar_form(this.form,\'recargar_pantalla\')" /></td></tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
					}
			}
//**********************************************
		function crear_nueva_seccion()
			{
				if($this->nivel == 1)
					{
						if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")	
							{
								$user = $this->nick_user;
								$formulario_final = $_POST["formulario_final"];
								$clave_modulo = $_POST["clave_modulo"];
								$clave_seccion = $_POST["clave_seccion"];
								$orden = $_POST["orden"];
								$usar_descripcion = $_POST["usar_descripcion"];								
								$descripcion = addslashes($_POST["descripcion"]);								
								$usar_keywords = $_POST["usar_keywords"];
								$keywords = addslashes($_POST["keywords"]);								
								$descripcion = strip_tags($descripcion);								
								$usar_vigencia = $_POST["usar_vigencia"];
								$usar_vigencia_mod = $_POST["usar_vigencia_mod"];								
								$nombre  = addslashes($_POST["nombre"]);
								$nombre = strip_tags($nombre);
								$titulo = addslashes($_POST["titulo"]);
								$titulo = strip_tags($titulo);
								$imagen_secion = $_POST["imagen_secion"];
								$flash_secion = $_POST["flash_secion"];
								$ancho_medio = $_POST["ancho_medio"];
								$alto_medio = $_POST["alto_medio"];
								$tipo_titulo = $_POST["tipo_titulo"];	
								$tipo_contenido = $_POST["tipo_contenido"];
								$fecha_iniciar_vigencia = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
								$fecha_termina_vigencia = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
								$fecha_iniciar_vigencia_m = $_POST["ano_i_m"]."-".$_POST["mes_i_m"]."-".$_POST["dia_i_m"];
								$fecha_termina_vigencia_m = $_POST["ano_t_m"]."-".$_POST["mes_t_m"]."-".$_POST["dia_t_m"];
								$situacion = $_POST["situacion"];
								$fecha_hoy = date("Y-m-d");
								$hora_hoy = date ("H:i:s");
								$ip = $_SERVER['REMOTE_ADDR'];
								$protegida = $_POST["protegida"];
								$insert_seccion_1 ="insert into nazep_secciones set clave_seccion_pertenece = '$clave_seccion',
								user_creacion = '$user', fecha_creacion = '$fecha_hoy', hora_creacion = '$hora_hoy', ip_creacion= '$ip',
								user_actualiza = '$user', fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy', ip_actualizacion = '$ip',
								orden = '$orden', usar_descripcion  = '$usar_descripcion', descripcion = '$descripcion', usar_keywords = '$usar_keywords' , keywords = '$keywords' ,
								usar_vigencia = '$usar_vigencia', fecha_iniciar_vigencia = '$fecha_iniciar_vigencia', fecha_termina_vigencia = '$fecha_termina_vigencia',
								situacion = '$situacion', protegida = '$protegida', nombre = '$nombre', titulo='$titulo',
								imagen_secion='$imagen_secion', flash_secion = '$flash_secion', ancho_medio = '$ancho_medio', alto_medio = '$alto_medio',
								tipo_titulo = '$tipo_titulo', tipo_contenido = '$tipo_contenido' ";
								$paso = false;
								$conexion = $this->conectarse();
								mysql_query("START TRANSACTION;");
								if (!@mysql_query($insert_seccion_1))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 1;
									}
								else
									{
										$paso = true;
										$clave_seccion_db = mysql_insert_id();
										$insert_seccion_cam_1 ="insert into nazep_secciones_cambio set
										user_propone = '$user',
										fecha_creacion= '$fecha_hoy', hora_creacion= '$hora_hoy', ip_creacion= '$ip', 
										motivo_cambio ='".mot_nueva_sec."', clave_seccion = '$clave_seccion_db',
										nuevo_clave_seccion_pertenece = '$clave_seccion', nuevo_orden = '$orden', 
										nuevo_usar_descripcion = '$usar_descripcion', nuevo_descripcion = '$descripcion',
										nuevo_usar_keywords = '$usar_keywords', nuevo_keywords = '$keywords',
										nuevo_usar_vigencia = '$usar_vigencia', nuevo_fecha_iniciar_vigencia = '$fecha_iniciar_vigencia', 
										nuevo_fecha_termina_vigencia = '$fecha_termina_vigencia', nuevo_situacion ='$situacion', 
										nuevo_protegida = '$protegida', nuevo_nombre = '$nombre', nuevo_titulo = '$titulo', 
										nuevo_imagen_secion = '$imagen_secion', nuevo_flash_secion = '$flash_secion',
										nuevo_ancho_medio = '$ancho_medio', nuevo_alto_medio = '$alto_medio',
										nuevo_tipo_titulo = '$tipo_titulo', nuevo_tipo_contenido = '$tipo_contenido', 
										anterior_clave_seccion_pertenece = '$clave_seccion', anterior_orden = '$orden', 
										anterior_usar_descripcion = '$usar_descripcion', anterior_descripcion = '$descripcion', 
										anterior_usar_keyword = '$usar_keywords', anterior_keywords ='$keywords',
										anterior_usar_vigencia = '$usar_vigencia', anterior_fecha_iniciar_vigencia = '$fecha_iniciar_vigencia',
										anterior_fecha_termina_vigencia = '$fecha_termina_vigencia', anterior_situacion = '$situacion',
										anterior_protegida = '$protegida', anterior_nombre = '$nombre', anterior_titulo = '$titulo',
										anterior_imagen_secion = '$imagen_secion', anterior_flash_secion = '$flash_secion', 
										anterior_ancho_medio = '$ancho_medio', anterior_alto_medio = '$alto_medio',
										anterior_tipo_titulo = '$tipo_titulo',
										anterior_tipo_contenido = '$tipo_contenido'";										
										if (!@mysql_query($insert_seccion_cam_1))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 2;
											}
										else
											{
												$paso = true;
												$insert_sec_mod ="insert into nazep_secciones_modulos 
												(clave_seccion, clave_modulo, fecha_creacion, hora_creacion, ip_creacion, 
												fecha_actualizacion, hora_actualizacion, ip_actualizacion, posicion, orden, situacion,
												usar_vigencia_mod, fecha_inicio, fecha_fin)
												values 
												('$clave_seccion_db', '$clave_modulo', '$fecha_hoy', '$hora_hoy', '$ip',
												'$fecha_hoy', '$hora_hoy', '$ip', 'centro', '1', 'activo', 
												'$usar_vigencia_mod', '$fecha_iniciar_vigencia_m', '$fecha_termina_vigencia_m')";
												if (!@mysql_query($insert_sec_mod))
													{
														$men = mysql_error();
														mysql_query("ROLLBACK;");
														$paso = false;
														$error = 3;
													}
												else
													{
														$clave_secciones_modulos_db = mysql_insert_id();
														$paso = true;
														$insert_sec_mod_cam ="insert into nazep_secciones_modulos_cambio 
														(fecha_creacion, hora_creacion, ip_creacion, motivo_cambio, clave_secciones_modulos,
														nuevo_orden, nuevo_situacion, nuevo_usar_vigencia, nuevo_fecha_inicio,nuevo_fecha_fin, 
														anterior_orden, anterior_situacion, anterior_usar_vigencia, anterior_fecha_inicio, anterior_fecha_fin)
														values
														('$fecha_hoy', '$hora_hoy', '$ip', '".mot_nueva_sec_mod."','$clave_secciones_modulos_db',
														'1', 'activo', '$usar_vigencia_mod', '$fecha_iniciar_vigencia_m','$fecha_termina_vigencia_m',
														'1', 'activo', '$usar_vigencia_mod', '$fecha_iniciar_vigencia_m','$fecha_termina_vigencia_m')";
														if (!@mysql_query($insert_sec_mod_cam))
															{
																$men = mysql_error();
																mysql_query("ROLLBACK;");
																$paso = false;
																$error = 4;
															}
														else
															{ $paso = true; }
													}
											}
									}
								if($paso)
									{
										mysql_query("COMMIT;");
										echo "termino-,*-$formulario_final";
									}
								elseif($paso==false)
									{ echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
							}
						else
							{
								$clave_seccion_enviada  = $_GET["clave_seccion"];
								$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion(titulo_nueva_sec." $nombre_sec ");
								echo '<script type="text/javascript">';
								echo '$(document).ready(function()
											{									
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("frm_crear_seccion");
											});								
										function validar_form(formulario, nombre_formulario)
											{
												if(formulario.nombre.value == "") 
													{
														alert("'.verificar_nombre_seccion.'");
														formulario.nombre.focus(); 	
														return false;
													}
												if(formulario.tipo_titulo.options[0].selected)
													{
														if(formulario.titulo.value == "") 
															{
																alert("'.verificar_titulo_seccion.'");
																formulario.titulo.focus();	
																return false;
															}
													}
												if(formulario.tipo_titulo.options[1].selected)
													{
														if(formulario.imagen_secion.value == "") 
															{
																alert("'.verificar_imagen_seccion.'");
																formulario.imagen_secion.focus();	
																return false;
															}
													}
												if(formulario.tipo_titulo.options[2].selected)
													{
														if(formulario.flash_secion.value == "") 
															{
																alert("'.verificar_flash_seccion.'");
																formulario.flash_secion.focus();	
																return false;
															}
													}
												separador = "/";
												fecha_ini_m = formulario.dia_i_m.value+"/"+formulario.mes_i_m.value+"/"+formulario.ano_i_m.value;
												fecha_fin_m = formulario.dia_t_m.value+"/"+formulario.mes_t_m.value+"/"+formulario.ano_t_m.value;
												if(!Comparar_Fecha(fecha_ini_m, fecha_fin_m))
													{
														alert("'.comparar_fecha_veri.'");
														formulario.dia_i_m.focus(); 
														return false;
													}
												if(!verificar_fecha(fecha_ini_m, separador))
													{
														alert("'.verificar_fecha_ini.'");
														formulario.dia_i_m.focus(); 
														return false;
													}
												if(!verificar_fecha(fecha_fin_m, separador))
													{
														alert("'.verificar_fecha_fin.'");
														formulario.dia_t_m.focus(); 
														return false;
													}
												if(formulario.orden.value == "") 
													{
														alert("'.orden_sec_veri.'");
														formulario.orden.focus();
														return false;
													}
												if(formulario.descripcion.value == "") 
													{
														alert("'.desc_sec_veri.'");
														formulario.descripcion.focus();	
														return false;
													}
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
												formulario.btn_guardar.style.visibility="hidden";
												formulario.btn_guardar2.style.visibility="hidden";
												formulario.formulario_final.value = nombre_formulario;
											}';
								echo '</script>';	
								$dia=date('d');
								$mes=date('m');
								$ano=date('Y');	
								if($clave_seccion_enviada == 1)
									{$cadena = '';}
								else
									{$cadena = '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';}
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "1" />'.$cadena.'</form>';
								echo '<form name="regresar_pantalla" id= "regresar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "13" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" /></form>';
								echo '<form class="margen_cero" name="frm_crear_seccion" id="frm_crear_seccion" action="index.php?opc=13" method="post">';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0">';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td>'.nombre_seccion.'</td><td><input type="text" name ="nombre" id="txt_nombre" size ="53" /></td></tr>';
										echo '<tr><td>'.elemento_seccion.'</td><td><select name = "tipo_titulo" >';
											echo '<option value = "texto" >'.elem_texto.'</option><option value = "imagen" >'.elem_imagen.'</option><option value = "flash" >'.elem_flash.'</option></select></td></tr>';
										echo '<tr><td>'.titulo_seccion.'</td><td><textarea name="titulo" id= "txt_titulo" cols="40" rows="3" ></textarea></td></tr>';
										echo '<tr><td>'.imagen_seccion.'</td><td><input type="text" name ="imagen_secion" id="txt_imagen_seccion" size ="53"  /></td></tr>';
										echo '<tr><td>'.flash_seccion.'</td><td><input type="text" name ="flash_secion" id="txt_flash_seccion" size ="53" /></td></tr>';
										echo '<tr><td>'.ancho_alto_medios.'</td>';
											echo '<td>';
												echo ancho_medios.': <input onkeypress="return solo_num(event)" type="text" name ="ancho_medio" id="txt_ancho_medio" size ="10"  />&nbsp;&nbsp;';
												echo alto_medios.': <input onkeypress="return solo_num(event)" type="text" name ="alto_medio" id="txt_alto_medio" size ="10"  />';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.tipo_contenido_seccion.'</td><td>';
												echo '<input type="radio" name="tipo_contenido" id ="tipo_contenido_html" value="html" checked="checked" /> HTML&nbsp;';
												echo '<input type="radio" name="tipo_contenido" id ="tipo_contenido_xml"   value="xml"  /> XML&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.orden_sec.'</td>';
											echo '<td><input type = "text" name = "orden" id="txt_orden" size = "5" onkeypress="return solo_num(event)"  /></td>';
										echo '</tr>';
										echo '<tr><td>'.usar_desc_sec.'</td><td>';
												echo '<input type="radio" name="usar_descripcion" id ="usar_descripcion_no" value="no" checked="checked"  /> '.no.'&nbsp;';
												echo '<input type="radio" name="usar_descripcion" id ="usar_descripcion_si"   value="si" /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.desc_sec.'</td>';
											echo '<td><textarea name="descripcion" id="txt_descripcion" cols="40" rows="6" ></textarea></td>';
										echo '</tr>';
										echo '<tr><td>'.lbl_usar_keywords.'</td><td>';
												echo '<input type="radio" name="usar_keywords" id ="usar_keywords_no" value="no" checked="checked"  /> '.no.'&nbsp;';
												echo '<input type="radio" name="usar_keywords" id ="usar_keywords_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.lbl_keywords.'</td>';
											echo '<td><textarea name="keywords" id="txt_keywords" cols="40" rows="6"  ></textarea></td>';
										echo '</tr>';
										echo '<tr><td>'.caduca_sec_nueva.'</td><td>';
												echo '<input type="radio" name="usar_vigencia" id ="usar_vigencia_no" value="no" checked="checked"/> '.no.'&nbsp;';
												echo '<input type="radio" name="usar_vigencia" id ="usar_vigencia_si" value="si" /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fec_ini_sec.'</td><td>';
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name = "dia_i" >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' > '.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_i" >';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_i" >';
													for ($c=$ano-6; $c<=$ano+10; $c++)
														{ echo '<option value = "'.$c.'" '; if ($ano == $c) {echo ' selected="selected" ';} echo '>'.$c.'</option>'; }
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fec_fin_sec.'</td><td>';
												echo dia.'&nbsp;<select name = "dia_t" >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_t" >';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_t" >';
													for ($c=$ano-6; $c<=$ano+10; $c++)
														{echo '<option value = "'.$c.'" '; if ($ano == $c) {echo ' selected="selected" ';} echo '>'.$c.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.situacion_sec.'</td><td>';
												echo '<select name = "situacion" >';
													echo '<option value = "activo" >'.activo.'</option>';
													echo '<option value = "oculto" >'.oculto.'</option>';	
													echo '<option value = "cancelado" >'.cancelado.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.protecion_sec.'</td><td>';
												echo '<input type="radio" name="protegida" id ="protegida_no" value="no" checked="checked"  /> '.no.'&nbsp;';
												echo '<input type="radio" name="protegida" id ="protegida_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td align ="center"><strong>'.mod_sec_nueva.'</strong></td></tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td>'.mod_sec.'</td><td>';
												echo '<select name = "clave_modulo" >';
													$con_modulos ="select nombre, clave_modulo from nazep_modulos where tipo = 'central' and situacion = 'activo' order by nombre";
													$conexion = $this->conectarse();
													$res_modulos = mysql_query($con_modulos);
													while($ren_mod =mysql_fetch_array($res_modulos))
														{
															$clave_modulo = $ren_mod["clave_modulo"];
															$nombre = $ren_mod["nombre"];
															echo '<option value = "'.$clave_modulo.'" >'.$nombre.'</option>';
														}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.caduca_mod_sec_nueva.'</td>';
											echo '<td>';
												echo '<input type="radio" name="usar_vigencia_mod" id ="usar_vigencia_mod_no" value="no" checked="checked"  /> '.no.'&nbsp;';
												echo '<input type="radio" name="usar_vigencia_mod" id ="usar_vigencia_mod_si" value="si" /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fec_ini_mod_sec.'</td>';
											echo '<td>';
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name="dia_i_m" >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value ="'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_i_m" >';
												for ($b=1; $b<=12; $b++)
													{echo '<option value ="'.$b.'"'; if ($mes == $b) {echo ' selected="selected" ';} echo '>'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_i_m" >';
													for ($c=$ano-6; $c<=$ano+10; $c++)
														{echo '<option value="'.$c.'"'; if ($ano == $c) {echo 'selected="selected"';} echo '> '.$c.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fec_fin_mod_sec.'</td><td>';
												echo dia.'&nbsp;<select name ="dia_t_m" >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'"'; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'. $a.' </option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name ="mes_t_m" >';
												for ($b=1; $b<=12; $b++)
													{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name="ano_t_m" >';
												for ($c=$ano-6; $c<=$ano+10; $c++)
													{echo '<option value ="'.$c.'"'; if ($ano == $c) {echo ' selected="selected" ';} echo '>'.$c.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									echo '</table><br />';	
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align ="center">';
												echo '<input type="hidden" name="formulario_final" value = "" />';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "modificar_seccion_estructura" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="submit" name="btn_guardar" value="'.guardar_nue_sec.'"  onclick= "return validar_form(this.form, \'recargar_pantalla\')"/>';
												echo '<input type="submit" name="btn_guardar2" value="'.guardar_nue_sec2.'"  onclick= "return validar_form(this.form, \'regresar_pantalla\')"/>';
											echo '</td>';
										echo '</tr>';	
										echo '<tr><td align ="center">&nbsp;</td></tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								HtmlAdmon::boton_regreso(array('opc_regreso'=>'listado','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_nue_sec));
							}
					}	
				else
					{ $this->acceso_denegado(); }
			}
		function modificar_seccion_estructura()
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if($this->nivel == 1)
					{
						if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
							{
								$user = $this->nick_user;
								$formulario_final= $_POST["formulario_final"];
								$fecha_hoy = date("Y-m-d");
								$hora_hoy = date ("H:i:s");
								$ip = $_SERVER['REMOTE_ADDR'];
								$motivo_cambio =  addslashes($_POST["motivo_cambio"]);
								$motivo_cambio = strip_tags($motivo_cambio);
								$clave_seccion_pertenece = $_POST["clave_seccion_pertenece"];
								$orden = $_POST["orden"];
								$usar_vigencia = $_POST["usar_vigencia"];
								$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
								$fecha_termino = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];	
								$situacion = $_POST["situacion"];
								$protegida = $_POST["protegida"];
								$titulo =  addslashes($_POST["titulo"]);
								$titulo = strip_tags($titulo);
								$imagen_secion = $_POST["imagen_secion"];
								$flash_secion = $_POST["flash_secion"];
								$ancho_medio = $_POST["ancho_medio"];
								$alto_medio = $_POST["alto_medio"];
								$tipo_titulo = $_POST["tipo_titulo"];
								$tipo_contenido = $_POST["tipo_contenido"];
								$nombre =  addslashes($_POST["nombre"]);
								$nombre = strip_tags($nombre);
								$descripcion =  addslashes($_POST["descripcion"]);
								$descripcion = strip_tags($descripcion);	
								$usar_descripcion = $_POST["usar_descripcion"];
								$usar_keywords = $_POST["usar_keywords"];
								$keywords = $_POST["keywords"];
								$clave_seccion = $_POST["clave_seccion"];
								$insertar_cambio = "insert into nazep_secciones_cambio
								(user_propone, fecha_creacion, hora_creacion, ip_creacion, motivo_cambio, clave_seccion, 
								nuevo_clave_seccion_pertenece, nuevo_orden, 
								nuevo_usar_descripcion, nuevo_descripcion, nuevo_usar_keywords, nuevo_keywords, 
								nuevo_usar_vigencia, nuevo_fecha_iniciar_vigencia, 
								nuevo_fecha_termina_vigencia, nuevo_situacion,  nuevo_protegida, nuevo_nombre, nuevo_titulo,
								nuevo_imagen_secion, nuevo_flash_secion,nuevo_ancho_medio, nuevo_alto_medio,
								nuevo_tipo_titulo, nuevo_tipo_contenido,
								anterior_clave_seccion_pertenece, anterior_orden, 
								anterior_usar_descripcion, anterior_descripcion, anterior_usar_keyword, anterior_keywords,
								anterior_usar_vigencia, anterior_fecha_iniciar_vigencia,
								anterior_fecha_termina_vigencia, anterior_situacion,  anterior_protegida, anterior_nombre, anterior_titulo,
								anterior_imagen_secion, anterior_flash_secion, anterior_ancho_medio, anterior_alto_medio,
								anterior_tipo_titulo, anterior_tipo_contenido)
								select '$user', '$fecha_hoy','$hora_hoy','$ip','$motivo_cambio','$clave_seccion',
								'$clave_seccion_pertenece', '$orden', 
								'$usar_descripcion','$descripcion','$usar_keywords', '$keywords',
								'$usar_vigencia', '$fecha_inicio',
								'$fecha_termino', '$situacion', '$protegida', '$nombre', '$titulo',
								'$imagen_secion', '$flash_secion', '$ancho_medio', '$alto_medio',  '$tipo_titulo', '$tipo_contenido',
								clave_seccion_pertenece, orden, 
								usar_descripcion, descripcion, usar_keywords, keywords, 
								usar_vigencia, fecha_iniciar_vigencia, fecha_termina_vigencia, situacion, protegida, nombre, titulo, 
								imagen_secion, flash_secion, ancho_medio, alto_medio, tipo_titulo, tipo_contenido
								from nazep_secciones
								where clave_seccion = '$clave_seccion'";
								$update_seccion =
								"Update nazep_secciones set
								clave_seccion_pertenece = $clave_seccion_pertenece, user_actualiza = '$user', fecha_actualizacion = '$fecha_hoy',
								hora_actualizacion= '$hora_hoy', ip_actualizacion= '$ip', orden = '$orden',
								usar_descripcion = '$usar_descripcion', descripcion = '$descripcion', 
								usar_keywords = '$usar_keywords', keywords = '$keywords',  usar_vigencia = '$usar_vigencia', 
								fecha_iniciar_vigencia = '$fecha_inicio',
								fecha_termina_vigencia = '$fecha_termino', situacion = '$situacion', protegida = '$protegida',
								nombre = '$nombre', titulo= '$titulo', imagen_secion = '$imagen_secion', flash_secion = '$flash_secion',
								ancho_medio = '$ancho_medio', alto_medio = '$alto_medio', tipo_titulo ='$tipo_titulo', tipo_contenido = '$tipo_contenido'
								where clave_seccion = '$clave_seccion' ";
								$conexion = $this->conectarse();
								mysql_query("START TRANSACTION;");
								if (!@mysql_query($insertar_cambio))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 1;
									}
								else
									{
										$paso = true;
										if (!@mysql_query($update_seccion))
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
								elseif($paso==false)
									{echo "Error: Insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
							}
						else
							{
								$conexion = $this->conectarse();
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								$temporal = titulo_mod_est_sec." ".$nombre;
								HtmlAdmon::titulo_seccion($temporal);
								$con_sec = 	"select * from nazep_secciones where clave_seccion = '$clave_seccion_enviada' ";
								$res_con_sec = mysql_query($con_sec);
								$ren_con_sec = mysql_fetch_array($res_con_sec);
								$orden = $ren_con_sec["orden"];
								$descripcion = $ren_con_sec["descripcion"];
								$usar_vigencia = $ren_con_sec["usar_vigencia"];
								$fecha_iniciar_vigencia = $ren_con_sec["fecha_iniciar_vigencia"];
								$fecha_termina_vigencia = $ren_con_sec["fecha_termina_vigencia"];
								list($ano_i, $mes_i, $dia_i) = explode("-",$fecha_iniciar_vigencia);
								list($ano_t, $mes_t, $dia_t) = explode("-",$fecha_termina_vigencia);
								$situacion = $ren_con_sec["situacion"];
								$protegida = $ren_con_sec["protegida"];
								$clave_seccion_pertenece = $ren_con_sec["clave_seccion_pertenece"];
								$protegida = $ren_con_sec["protegida"];
								$usar_descripcion= $ren_con_sec["usar_descripcion"]; 
								$descripcion = $ren_con_sec["descripcion"];
								$usar_keywords  = $ren_con_sec["usar_keywords"];
								$keywords = $ren_con_sec["keywords"];
								$nombre = $ren_con_sec["nombre"];
								$titulo = $ren_con_sec["titulo"];
								$imagen_secion = $ren_con_sec["imagen_secion"];
								$flash_secion = $ren_con_sec["flash_secion"];
								$ancho_medio = $ren_con_sec["ancho_medio"];
								$alto_medio = $ren_con_sec["alto_medio"];
								$tipo_titulo = $ren_con_sec["tipo_titulo"];
								$tipo_contenido = $ren_con_sec["tipo_contenido"];
								$user_creacion = $ren_con_sec["user_creacion"];
								$fecha_creacion = $ren_con_sec["fecha_creacion"];
								$fecha_creacion = FunGral::fechaNormal($fecha_creacion);
								$hora_creacion = $ren_con_sec["hora_creacion"];
								$ip_creacion = $ren_con_sec["ip_creacion"];
								$user_actualiza = $ren_con_sec["user_actualiza"];
								$fecha_actualizacion = $ren_con_sec["fecha_actualizacion"];
								$fecha_actualizacion = FunGral::fechaNormal($fecha_actualizacion);
								$hora_actualizacion = $ren_con_sec["hora_actualizacion"];
								$ip_actualizacion = $ren_con_sec["ip_actualizacion"];
								echo '<script type="text/javascript">';
								echo '$(document).ready(function()
												{									
													$.frm_elem_color("#FACA70","");
													$.guardar_valores("frm_modificar_estructura");
												});	
										function validar_form(formulario, nombre_formulario)
											{													
												if(formulario.motivo_cambio.value == "") 
													{
														alert("'.jv_campo_motivo.'");
														formulario.motivo_cambio.focus();	
														return false;
													}
												if(formulario.nombre.value == "") 
													{
														alert("'.verificar_nombre_seccion.'");
														formulario.nombre.focus();	
														return false;
													}			
												if(formulario.tipo_titulo.options[0].selected)
													{
														if(formulario.titulo.value == "") 
															{
																alert("'.verificar_titulo_seccion.'");
																formulario.titulo.focus();	
																return false;
															}
													}
												if(formulario.tipo_titulo.options[1].selected)
													{
														if(formulario.imagen_secion.value == "") 
															{
																alert("'.verificar_imagen_seccion.'");
																formulario.imagen_secion.focus();
																return false;
															}
													}
												if(formulario.tipo_titulo.options[2].selected)
													{
														if(formulario.flash_secion.value == "") 
															{
																alert("'.verificar_flash_seccion.'");
																formulario.flash_secion.focus();
																return false;
															}
													}
												if(formulario.orden.value == "") 
													{
														alert("'.orden_sec_veri.'");
														formulario.orden.focus();
														return false;
													}
												if(formulario.descripcion.value == "") 
													{
														alert("'.desc_sec_veri.'");
														formulario.descripcion.focus();
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
												formulario.btn_guardar.style.visibility="hidden";
												formulario.btn_guardar2.style.visibility="hidden";
												formulario.formulario_final.value = nombre_formulario;
											}';
								echo '</script>';
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" /></form>';
								echo '<form name="regresar_pantalla" id= "regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "administracion.php" />';
									echo '<input type="hidden" name="clase" value = "administracion" />';
									echo '<input type="hidden" name="metodo" value = "modificar_seccion_estructura" />';								
								echo'</form>';								
								echo '<form class="margen_cero" id = "frm_modificar_estructura" name="frm_modificar_estructura" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td width="390">'.txt_usr_cre_sec.'</td><td>'.$user_creacion.'</td></tr>';
										echo '<tr><td>'.txt_fec_cre_sec.'</td><td>'.$fecha_creacion.' '.a_las.' '.$hora_creacion.' '.hrs.'</td></tr>';
										echo '<tr><td>'.txt_ip_cre_sec.'</td><td>'.$ip_creacion.'</td></tr>';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td>'.txt_usc_act_sec.'</td><td>'.$user_actualiza.'</td></tr>';
										echo '<tr><td>'.txt_fec_act_sec.'</td><td>'.$fecha_actualizacion.' '.a_las.' '.$hora_actualizacion.' '.hrs.'</td></tr>';
										echo '<tr><td>'.txt_ip_act_sec.'</td><td>'.$ip_actualizacion.'</td></tr>';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td>'.mot_cambio.'</td><td><textarea name="motivo_cambio" cols="40" rows="5"  ></textarea></td></tr>';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										$con_secciones = "select clave_seccion, nombre from nazep_secciones  where clave_seccion <> '$clave_seccion_enviada' order by clave_seccion_pertenece";
										$res_secciones = mysql_query($con_secciones);
										echo '<tr>';
											echo '<td width="390">'.clave_seccion.'</td>';
											echo '<td>';
												if($clave_seccion_pertenece=="")
													{ echo txt_sec_raiz.'<input type="hidden" name="clave_seccion_pertenece" value = "null" />'; }
												else
													{
														echo '<select name = "clave_seccion_pertenece"  >';
														while($ren_sec = mysql_fetch_array($res_secciones))
															{
																$clave_seccion_base = $ren_sec["clave_seccion"];
																$nombre_sec = $ren_sec["nombre"];
																echo '<option value = "'.$clave_seccion_base.'" '; if ($clave_seccion_base == $clave_seccion_pertenece) { echo 'selected="selected"'; } echo '  >'.$nombre_sec.'</option>';
															}
														echo '</select>';
													}
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.nombre_seccion.'</td>';
											echo '<td>';
												if($clave_seccion_pertenece=="")
													{ echo $nombre.'<input type="hidden" name="nombre" value = "'.$nombre.'" />'; }
												else
													{ echo '<input type = "text" name = "nombre" size = "53" value ="'.$nombre.'"  />'; }
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.elemento_seccion.'</td>';
											echo '<td>';
												echo '<select name = "tipo_titulo" >';
													echo '<option value = "texto"  '; if ($tipo_titulo == "texto") { echo 'selected="selected"'; } echo '  >'.elem_texto.'</option>';
													echo '<option value = "imagen" '; if ($tipo_titulo == "imagen") { echo 'selected="selected"'; } echo ' >'.elem_imagen.'</option>';	
													echo '<option value = "flash"  '; if ($tipo_titulo == "flash") { echo 'selected="selected"'; } echo ' >'.elem_flash.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';																				
										echo '<tr>';
											echo '<td>'.titulo_seccion.'</td>';
											echo '<td><textarea name="titulo" cols="40" rows="3" >'.$titulo.'</textarea></td>';
										echo '</tr>';
										echo '<tr><td>'.imagen_seccion.'</td><td><input type="text" name ="imagen_secion" id="txt_imagen_seccion" size ="53" value ="'.$imagen_secion.'"  /></td></tr>';
										echo '<tr><td>'.flash_seccion.'</td><td><input type="text" name ="flash_secion" id="txt_flash_seccion" size ="53" value ="'.$flash_secion.'"  /></td></tr>';										
										echo '<tr>';
											echo '<td>'.ancho_alto_medios.'</td>';
											echo '<td>';
												echo ancho_medios.': <input onkeypress="return solo_num(event)" type="text" name ="ancho_medio" id="txt_ancho_medio" size ="10" value ="'.$ancho_medio.'"  />&nbsp;&nbsp;';
												echo alto_medios.': <input onkeypress="return solo_num(event)" type="text" name ="alto_medio" id="txt_alto_medio" size ="10" value ="'.$alto_medio.'"  />';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.tipo_contenido_seccion.'</td>';
											echo '<td>';
												echo '<input '; if ($tipo_contenido == "html") { echo 'checked="checked"'; } echo 'type="radio" name="tipo_contenido" id ="tipo_contenido_html" value="html"  /> HTML&nbsp;';
												echo '<input '; if ($tipo_contenido == "xml") { echo 'checked="checked"'; } echo 'type="radio" name="tipo_contenido" id ="tipo_contenido_xml"   value="xml"  /> XML&nbsp;';
											echo '</td>';
										echo '</tr>';										
										echo '<tr>';
											echo '<td>'.orden_sec.'</td>';
											echo '<td>';
												if($clave_seccion_pertenece=="")
													{ echo $orden.'<input type="hidden" name="orden" value = "'.$orden.'" />'; }
												else
													{ echo '<input type = "text" name = "orden" size = "5" onkeypress="return solo_num(event)" value ="'.$orden.'"  />';}
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.usar_desc_sec.'</td>';
											echo '<td>';
												echo '<input '; if ($usar_descripcion == "no") { echo 'checked="checked"'; } echo ' type="radio" name="usar_descripcion" id ="usar_descripcion_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($usar_descripcion == "si") { echo 'checked="checked"'; } echo ' type="radio" name="usar_descripcion" id ="usar_descripcion_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.desc_sec.'</td><td><textarea name="descripcion" id="txt_descripcion" cols="40" rows="6" >'.$descripcion.'</textarea></td></tr>';
										echo '<tr>';
											echo '<td>'.lbl_usar_keywords.'</td><td>';
												echo '<input '; if ($usar_keywords == "no") { echo 'checked="checked"'; } echo ' type="radio" name="usar_keywords" id ="usar_keywords_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($usar_keywords == "si") { echo 'checked="checked"'; } echo ' type="radio" name="usar_keywords" id ="usar_keywords_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.lbl_keywords.'</td><td><textarea name="keywords" id="txt_keywords" cols="40" rows="6" >'.$keywords.'</textarea></td></tr>';
										echo '<tr><td>'.caduca_sec_nueva.'</td><td>';
												echo '<input '; if ($usar_vigencia == "no") { echo 'checked="checked"'; } echo ' type="radio" name="usar_vigencia" id ="usar_vigencia_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($usar_vigencia == "si") { echo 'checked="checked"'; } echo ' type="radio" name="usar_vigencia" id ="usar_vigencia_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.fec_ini_sec.'</td><td>';
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'<select name = "dia_i" >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value ="'.$a.'" '; if ($dia_i == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'<select name = "mes_i"  >';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes_i == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'<select name = "ano_i"  >';
													for ($b=$ano_i-6; $b<=$ano_i+10; $b++)
														{echo '<option value = "'.$b.'" '; if ($ano_i == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.fec_fin_sec.'</td>';
											echo '<td>';
												echo dia.'<select name = "dia_t"  >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia_t == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'<select name = "mes_t"  >';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes_t == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'<select name = "ano_t"  >';
													for ($b=$ano_i-6; $b<=$ano_i+10; $b++)
														{echo '<option value = "'.$b.'" '; if ($ano_t == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.situacion_sec.'</td>';
											echo '<td>';
												echo '<select name = "situacion" >';
													echo '<option value = "activo" '; if ($situacion == "activo") { echo 'selected="selected"'; } echo '  >'.activo.'</option>';
													echo '<option value = "oculto" '; if ($situacion == "oculto") { echo 'selected="selected"'; } echo '  >'.oculto.'</option>';
													echo '<option value = "cancelado" '; if ($situacion == "cancelado") { echo 'selected="selected"'; } echo '  >'.cancelado.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.protecion_sec.'</td>';
											echo '<td>';
												echo '<input '; if ($protegida == "no") { echo 'checked="checked"'; } echo '  type="radio" name="protegida" id ="protegida_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($protegida == "si") { echo 'checked="checked"'; } echo '  type="radio" name="protegida" id ="protegida_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
									echo '</table><br />';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align ="center" >';
												echo '<input type="hidden" name="formulario_final" value = "" />';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "modificar_seccion_estructura" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="submit" name="btn_guardar" value="'.guardar_mod_sec_est.'" onclick= "return validar_form(this.form,\'recargar_pantalla\')" />';
												echo '<input type="submit" name="btn_guardar2" value="'.guardar_mod_sec_est2.'" onclick= "return validar_form(this.form,\'regresar_pantalla\')" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>reg_mod_secc));
								$this->desconectarse($conexion); 
							}
					}
				else
					{$this->acceso_denegado();}	
			}			
		function modificar_modulo()
			{				
				if($this->nivel == "1")
					{
						$clave_seccion_enviada = $_GET["clave_seccion"];
						if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
							{
								$formulario_final = $_POST["formulario_final"];
								$fecha_hoy = date("Y-m-d");
								$hora_hoy = date ("H:i:s");
								$ip = $_SERVER['REMOTE_ADDR'];
								$clave_secciones_modulos = $_POST["clave_secciones_modulos"];
								$clave_seccion = $_POST["clave_seccion"];
								$clave_modulo = $_POST["clave_modulo"];
								$motivo_cambio = addslashes($_POST["motivo_cambio"]);
								$motivo_cambio = strip_tags($motivo_cambio);
								$posicion  = $_POST["posicion"];
								$orden = $_POST["orden"];
								$situacion = $_POST["situacion"];
								$usar_vigencia_mod = $_POST["usar_vigencia_mod"];
								$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
								$fecha_termino = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
								$persistencia = $_POST["persistencia"];
								$insert_mod = "insert into nazep_secciones_modulos_cambio
								(fecha_creacion, hora_creacion, ip_creacion, motivo_cambio, clave_secciones_modulos, 
								nuevo_posicion, nuevo_orden, nuevo_situacion, nuevo_usar_vigencia, nuevo_fecha_inicio, nuevo_fecha_fin, nuevo_persistencia, 
								anterior_posicion, anterior_orden, anterior_situacion, anterior_usar_vigencia, anterior_fecha_inicio, anterior_fecha_fin, anterior_persistencia)
								select '$fecha_hoy','$hora_hoy','$ip','$motivo_cambio', '$clave_secciones_modulos',
								'$posicion','$orden', '$situacion', '$usar_vigencia_mod', '$fecha_inicio', '$fecha_termino', '$persistencia',
								posicion, orden, situacion, usar_vigencia_mod, fecha_inicio, fecha_fin, persistencia
								from nazep_secciones_modulos
								where  clave_modulo = '$clave_modulo'";
								$update_mod = "update nazep_secciones_modulos set
								fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy', ip_actualizacion = '$ip',
								posicion = '$posicion', orden = '$orden', situacion= '$situacion', usar_vigencia_mod  = '$usar_vigencia_mod', 
								fecha_inicio= '$fecha_inicio', fecha_fin = '$fecha_termino',
								persistencia = '$persistencia'
								where clave_secciones_modulos= '$clave_secciones_modulos' and clave_seccion = '$clave_seccion' and 
								clave_modulo = '$clave_modulo'";
								$conexion = $this->conectarse();
								mysql_query("START TRANSACTION;");
								if (!@mysql_query($insert_mod))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 1;
									}
								else
									{
										$paso = true;
										if (!@mysql_query($update_mod))
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
									{echo "Error: insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
							}
						else
							{
								$conexion = $this->conectarse();
								$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
								HtmlAdmon::titulo_seccion(titulo_mod_modu_mod_sec);
								$clave_secciones_modulos = $_POST["clave_secciones_modulos"];
								$clave_seccion = $_POST["clave_seccion"];
								$clave_modulo = $_POST["clave_modulo"];
								$nombre_modulo =  $_POST["nombre_modulo"];	
								$consulta_modulo = "select sm.fecha_creacion, sm.hora_creacion, sm.ip_creacion, sm.fecha_actualizacion, sm.hora_actualizacion, sm.ip_actualizacion,
								sm.usar_vigencia_mod, sm.posicion, sm.orden, sm.situacion, sm.fecha_inicio, sm.fecha_fin, m.tipo, m.nombre, sm.persistencia
								from nazep_secciones_modulos sm, nazep_modulos  m
								where sm.clave_secciones_modulos = '$clave_secciones_modulos'
								and m.clave_modulo = sm.clave_modulo";
								$res_con_mod = mysql_query($consulta_modulo);
								$ren_con_mod = mysql_fetch_array($res_con_mod);
								$posicion = $ren_con_mod["posicion"];
								$orden = $ren_con_mod["orden"];
								$situacion = $ren_con_mod["situacion"];
								$fecha_inicio = $ren_con_mod["fecha_inicio"];
								$fecha_fin = $ren_con_mod["fecha_fin"];	
								$tipo =  $ren_con_mod["tipo"];
								$nombre = $ren_con_mod["nombre"];
								$persistencia = $ren_con_mod["persistencia"];
								$usar_vigencia_mod = $ren_con_mod["usar_vigencia_mod"];
								list($ano_i, $mes_i, $dia_i) = explode("-",$fecha_inicio);
								list($ano_t, $mes_t, $dia_t) = explode("-",$fecha_fin);
								$fecha_creacion = $ren_con_mod["fecha_creacion"];
								$fecha_creacion = FunGral::fechaNormal($fecha_creacion);								
								$hora_creacion = $ren_con_mod["hora_creacion"];
								$ip_creacion = $ren_con_mod["ip_creacion"];
								$fecha_actualizacion = $ren_con_mod["fecha_actualizacion"];
								$fecha_actualizacion = FunGral::fechaNormal($fecha_actualizacion);
								$hora_actualizacion = $ren_con_mod["hora_actualizacion"];
								$ip_actualizacion = $ren_con_mod["ip_actualizacion"];								
								echo '<script type="text/javascript">';
								echo '$(document).ready(function()
											{									
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("modificar_modulo");
											});									
										function validar_form(formulario, nombre_formulario)
											{
												if(formulario.motivo_cambio.value == "") 
													{
														alert("'.jv_campo_motivo.'");
														formulario.motivo_cambio.focus();	
														return false
													}
												if(formulario.orden.value == "") 
													{
														alert("'.orden_sec_veri.'")
														formulario.orden.focus();
														return false
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
												formulario.btn_guardar.style.visibility="hidden";
												formulario.formulario_final.value = nombre_formulario;
											}';
								echo '</script>';
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "administracion.php" />';
									echo '<input type="hidden" name="clase" value = "administracion" />';
									echo '<input type="hidden" name="metodo" value = "modificar_modulo" />';	
									echo '<input type="hidden" name="clave_secciones_modulos" value = "'.$clave_secciones_modulos.'" />';
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion.'" />';	
									echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
									echo '<input type="hidden" name="nombre_modulo" value = "'.$nombre_modulo.'" />';
								echo'</form>';								
								echo '<form class="margen_cero" name="modificar_modulo" id="modificar_modulo" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion.'">';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td >'.txt_fec_cre_sec.'</td><td>'.$fecha_creacion.' '.a_las.' '.$hora_creacion.' '.hrs.'</td></tr>';
										echo '<tr><td >'.txt_ip_cre_sec.'</td><td>'.$ip_creacion.'</td></tr>';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td>'.txt_fec_act_sec.'</td><td>'.$fecha_actualizacion.' '.a_las.' '.$hora_actualizacion.' '.hrs.'</td></tr>';
										echo '<tr><td>'.txt_ip_act_sec.'</td><td>'.$ip_actualizacion.'</td></tr>';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
										echo '<tr><td width="400">'.mot_cambio.'</td><td><textarea name="motivo_cambio" cols="50" rows="5" ></textarea></td></tr>';
										echo '<tr><td >&nbsp;</td><td>&nbsp;</td></tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>'.nom_mod_mod_sec.'</td><td>'.$nombre.'</td></tr>';
										echo '<tr><td>'.pos_mod.'</td><td>';
												echo '<select name = "posicion"  >';
													if($tipo == "central")
														{echo '<option value = "centro"  '; if ($posicion == "centro") { echo 'selected="selected"'; } echo '  >Centro</option>';}
													else
														{
															echo '<option value = "arriba"  '; if ($posicion == "arriba") { echo 'selected="selected"'; } echo '  >Arriba</option>';
															echo '<option value = "abajo"  '; if ($posicion == "abajo") { echo 'selected="selected"'; } echo '  >Abajo</option>';
															echo '<option value = "izquierda"  '; if ($posicion == "izquierda") { echo 'selected="selected"'; } echo '  >Izquierda</option>';
															echo '<option value = "derecha"  '; if ($posicion == "derecha") { echo 'selected="selected"'; } echo '  >Derecha</option>';
														}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.persistencia_mod.'</td><td>';
												echo '<select name = "persistencia" >';
													if($tipo=="central")
														{ echo '<option value = "no" >NO</option>';}
													else 
														{
															echo '<option value = "no" '; if ($persistencia == "no") { echo 'selected="selected"'; } echo '>NO</option>';
															echo '<option value = "si" '; if ($persistencia == "si") { echo 'selected="selected"'; } echo '>SI</option>';
														}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.orden_mod.'</td><td><input type = "text" name = "orden" size = "5" value ="'.$orden.'" onkeypress="return solo_num(event)"  /></td></tr>';
										echo '<tr><td>'.situacion_mod.'</td><td>';
												echo '<select name = "situacion"  >';
													echo '<option value = "activo" '; if ($situacion == "activo") { echo 'selected="selected"'; } echo '  >'.activo.'</option>';
													echo '<option value = "cancelado" '; if ($situacion == "cancelado") { echo 'selected="selected"'; } echo '  >'.cancelado.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.caduca_mod_sec_nueva.'</td><td>';
												echo '<input '; if ($usar_vigencia_mod == "no") { echo 'checked="checked"'; } echo ' type="radio" name="usar_vigencia_mod" id ="usar_vigencia_mod_no" value="no" /> '.no.'&nbsp;';
												echo '<input '; if ($usar_vigencia_mod == "si") { echo 'checked="checked"'; } echo '  type="radio" name="usar_vigencia_mod" id ="usar_vigencia_mod_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fec_ini_mod.'</td><td>';
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'<select name = "dia_i"  >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia_i == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'<select name = "mes_i"  >';
												for ($b=1; $b<=12; $b++)
													{echo '<option value = "'.$b.'"  '; if ($mes_i == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'<select name = "ano_i"  >';
												for ($b=$ano_i-6; $b<=$ano_i+10; $b++)
													{echo '<option value = "'.$b.'" '; if ($ano_i == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fec_fin_mod.'</td><td>';
												echo dia.'<select name = "dia_t"  >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia_t == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'<select name = "mes_t"  >';
												for ($b=1; $b<=12; $b++)
													{echo '<option value = "'.$b.'"  '; if ($mes_t == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'<select name = "ano_t"  >';
												for ($b=$ano_i-6; $b<=$ano_i+10; $b++)
													{echo '<option value = "'.$b.'" '; if ($ano_t == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align ="center">';
												echo '<input type="hidden" name="formulario_final" value = "" />';	
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "modificar_modulo" />';
												echo '<input type="hidden" name="clave_secciones_modulos" value = "'.$clave_secciones_modulos.'" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion.'" />';
												echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="submit" name="btn_guardar" value="'.guardar_mod_cam_sec.'" onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';	
								HtmlAdmon::div_res_oper(array());
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>reg_mod_secc));
							}
					}
				else
					{
						$this->acceso_denegado();
					}
			}			
		function ingresar_modulos()
			{
				if($this->nivel == "1")
					{
						if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
							{
								$formulario_final= $_POST["formulario_final"];
								$clave_modulo = $_POST["clave_modulo"];
								$posicion = $_POST["posicion"];
								$orden = $_POST["orden"];
								$situacion = $_POST["situacion"];
								$usar_vigencia_mod= $_POST["usar_vigencia_mod"];
								$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
								$fecha_termino = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];	
								$persistencia = $_POST["persistencia"];
								$clave_seccion =  $_POST["clave_seccion"];
								$fecha_hoy = date("Y-m-d");
								$hora_hoy = date("H:i:s");
								$ip = $_SERVER['REMOTE_ADDR'];
								$insert_mod_1 = "insert into nazep_secciones_modulos
								(clave_seccion, clave_modulo, fecha_creacion, hora_creacion, ip_creacion, fecha_actualizacion, 
								hora_actualizacion, ip_actualizacion, posicion, orden, situacion, usar_vigencia_mod, fecha_inicio, fecha_fin, persistencia )
								values
								('$clave_seccion','$clave_modulo','$fecha_hoy','$hora_hoy','$ip','0000-00-00',
								'00:00:00', '','$posicion','$orden','$situacion','$usar_vigencia_mod','$fecha_inicio','$fecha_termino', '$persistencia ')";
								$conexion = $this->conectarse();
								mysql_query("START TRANSACTION;");
								if (!@mysql_query($insert_mod_1))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 1;
									}
								else
									{
										$clave_secciones_modulos = mysql_insert_id();
										$insert_mod_2 = "insert into nazep_secciones_modulos_cambio
										(fecha_creacion, hora_creacion, ip_creacion, motivo_cambio, clave_secciones_modulos, 
										nuevo_posicion, nuevo_orden, nuevo_situacion, nuevo_usar_vigencia, nuevo_fecha_inicio, nuevo_fecha_fin, nuevo_persistencia,
										anterior_posicion, anterior_orden, anterior_situacion,anterior_usar_vigencia, anterior_fecha_inicio, anterior_fecha_fin, anterior_persistencia )
										values
										('$fecha_hoy','$hora_hoy','$ip','Nuevo M&oacute;dulo', '$clave_secciones_modulos',
										'$posicion', '$orden', '$situacion', '$usar_vigencia_mod', '$fecha_inicio', '$fecha_termino', '$persistencia',
										'$posicion', '$orden','$situacion','$usar_vigencia_mod','$fecha_inicio', '$fecha_termino', '$persistencia')";
										$paso = true;
										if (!@mysql_query($insert_mod_2))
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
										echo "Error: Insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";										
									}
								$this->desconectarse($conexion);
							}
						else
							{
								$tipo_modulo = $_POST["tipo_modulo"];
								$clave_seccion_enviada = $_POST["clave_seccion"];
								$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
								HtmlAdmon::titulo_seccion(titulo_agre_mod."&nbsp;\"$nombre_sec\"");
								echo '<script type="text/javascript">';
								echo '$(document).ready(function()
											{
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("modificar_modulo");
											});
										function validar_form(formulario, nombre_formulario)
											{
												 if (formulario.clave_modulo.selectedIndex==0){
													   alert("'.mod_sec_veri.'");
													   formulario.clave_modulo.focus();
													   return false;
													}												
												if(formulario.orden.value == "") 
													{
														alert("'.orden_sec_veri.'");
														formulario.orden.focus();
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
												formulario.btn_guardar.style.visibility="hidden";
												formulario.btn_guardar2.style.visibility="hidden";
												formulario.formulario_final.value = nombre_formulario;
											}';
								echo '</script>';
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" /></form>';
								echo '<form name="regresar_pantalla" id= "regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "administracion.php" />';
									echo '<input type="hidden" name="clase" value = "administracion" />';
									echo '<input type="hidden" name="metodo" value = "ingresar_modulos" />';
									echo '<input type="hidden" name="tipo_modulo" value = "'.$tipo_modulo.'" />';
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';								
								echo '</form>';
								echo '<form name="modificar_modulo" id = "modificar_modulo" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										$con_mod = "select clave_modulo, nombre, tipo
										from nazep_modulos where situacion = 'activo' and tipo = '$tipo_modulo' 
										and clave_modulo <> all (select clave_modulo from nazep_secciones_modulos where clave_seccion = '$clave_seccion_enviada' )
										order by nombre, tipo";
										$conexion = $this->conectarse();
										$res_mod = mysql_query($con_mod);
										echo '<tr><td>'.modulo_nombre.'</td><td>';
												echo '<select name = "clave_modulo">';
													echo '<option value = "0" >'.seleccione.'</option>';
													while($ren= mysql_fetch_array($res_mod))
														{
															$clave_modulo = $ren["clave_modulo"];
															$nombre = $ren["nombre"];
															$tipo = $ren["tipo"];	
															echo '<option value = "'.$clave_modulo.'" >'.$nombre.'</option>';
														}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.pos_mod.'</td>';
											echo '<td>';
												echo '<select name = "posicion" >';
													if($tipo_modulo=="central")
														{ echo '<option value = "centro" >'.centro.'</option>'; }
													else
														{
															echo '<option value = "arriba" >'.arriba.'</option>';
															echo '<option value = "abajo" >'.abajo.'</option>';
															echo '<option value = "izquierda" >'.izquierda.'</option>';
															echo '<option value = "derecha" >'.derecha.'</option>';
														}
												echo '</select>';
											echo '</td>';
										echo '</tr>';	
										echo '<tr><td>'.persistencia_mod.'</td><td>';
												echo '<select name = "persistencia" >';
													if($tipo_modulo=="central")
														{echo '<option value = "no" >'.no.'</option>';}
													else
														{ echo '<option value = "no" >'.no.'</option><option value = "si" >'.si.'</option>'; }
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.orden_mod.'</td><td><input type = "text" name = "orden" size = "5" onkeypress="return solo_num(event)" /></td></tr>';
										echo '<tr><td>'.situacion_mod.'</td><td>';
												echo '<select name = "situacion" >';
													echo '<option value = "activo" >'.activo.'</option>';
													echo '<option value = "cancelado" >'.cancelado.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';	
										echo '<tr><td>'.caduca_mod_sec_nueva.'</td><td>';
												echo '<input type="radio" name="usar_vigencia_mod" id ="usar_vigencia_mod_no" value="no" checked="checked"  /> '.no.'&nbsp;';
												echo '<input type="radio" name="usar_vigencia_mod" id ="usar_vigencia_mod_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										echo '<tr>';
											echo '<td>'.fec_ini_mod.'</td>';
											echo '<td>';
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'<select name = "dia_i" >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'<select name = "mes_i" >';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'<select name = "ano_i" >';
													for ($b=$ano-6; $b<=$ano+10; $b++)
														{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';	}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.fec_fin_mod.'</td>';
											echo '<td>';
												echo dia.'<select name = "dia_t" >';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.' </option>';}
												echo '</select>&nbsp;';
												echo mes.'<select name = "mes_t" >';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'<select name = "ano_t" >';
													for ($b=$ano-6; $b<=$ano+10; $b++)
														{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align ="center">';
												echo '<input type="hidden" name="formulario_final" value = "" />';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "ingresar_modulos" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="submit" name="btn_guardar" value="'.guardar_mod_nue_sec.'" onclick= "return validar_form(this.form,\'recargar_pantalla\')" />';
												echo '<input type="submit" name="btn_guardar2" value="'.guardar_mod_nue_sec2.'" onclick= "return validar_form(this.form, \'regresar_pantalla\')" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>reg_mod_secc));
							}
					}
				else
					{ $this->acceso_denegado(); }
			}
		function modificar_seccion()
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				$pasar = 'no';
				$arreglo_temporal = $this->secciones;
				$cantidad_secciones = count($arreglo_temporal);
				for($a=0;$a<$cantidad_secciones;$a++)
					{	
						if($arreglo_temporal[$a] == $clave_seccion_enviada)
							{$pasar = 'si';}
					}
				if($this->nivel==1)
					{$pasar = 'si';}
				if($pasar == 'si')
					{
						$conexion = $this->conectarse();
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(titulo_mod_sec);	
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798" >';
							echo '<tr><td align ="center"><strong>"'.$nombre.'"</strong></td></tr>';
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798" >';
							echo '<tr><td >&nbsp;</td></tr>';
							echo '<tr><td align ="center"><strong>'.list_mod_mod_sec.'</strong></td></tr>';
							echo '<tr><td >&nbsp;</td></tr>';
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"  bgcolor="#999798" >';
							echo '<tr><td width= "50%" align ="center"><strong>'.nom_mod_mod_sec.'</strong></td>';
								echo '<td width="50%" align ="center"><strong>'.opc_mod_mod_sec.'</strong></td></tr>';	
							echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
							$arreglo_modulos = $this->obtener_modulos($clave_seccion_enviada);
							$cantidad  = count($arreglo_modulos);
							$con_sec=0;
							for($a=0;$a<$cantidad;$a++)
								{	
									$situacion = $arreglo_modulos[$a][5];
									if($situacion=='activo')
										{
											$tipo = $arreglo_modulos[$a][6];
											if($a==0)
												{
													echo '</table>';
													echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"  bgcolor="#999798" >';
														echo '<tr><td align="center"><strong>'.mod_cent_mod_sec.'</strong></td></tr>';
													echo '</table>';
													echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"  bgcolor="#999798" >';
												}
											if(($tipo=='secundario') and ($con_sec == 0))
												{
													echo '</table>';
													echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"  bgcolor="#999798" >';
														echo '<tr><td align="center"><strong>'.mod_sec_mod_sec.'</strong></td></tr>';
													echo '</table>';
													echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"  bgcolor="#999798" >';
													$con_sec++;
												}
											$clave_modulo = $arreglo_modulos[$a][1];
											$nombre_modulo = $arreglo_modulos[$a][2];
											$archivo = "../librerias/modulos/".$arreglo_modulos[$a][3]."/".$arreglo_modulos[$a][3]."_admon.php";
											$clase = "clase_".$arreglo_modulos[$a][3];
											include_once($archivo);
											$obj = new $clase();																						
											$color = '#F89520';
											if( $a % 2 == 0)
												{
													$color = '#F7BB49';
												}
											echo '<tr>';
												echo '<td  width="50%" align ="center" valign="middle" bgcolor="'.$color.'">'.$nombre_modulo.'</td>';
												echo '<td width="50%" align ="center" valign="middle" bgcolor="'.$color.'">';	
													$obj->op_modificar_central($clave_seccion_enviada, $this->nivel, $clave_modulo);
												echo '</td>';
											echo '</tr>';
											echo '<tr><td >&nbsp;</td><td >&nbsp;</td></tr>';
										}
								}
							echo '<tr><td >&nbsp;</td><td >&nbsp;</td></tr>';
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#226E3F">&nbsp;</td></tr></table>';
						if($this->nivel=="1")
							{
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
									echo '<tr><td>&nbsp;</td></tr>';
									echo '<tr><td align ="center"><strong>'.conf_avan_mod_sec.'</strong></td></tr>';
									echo '<tr><td >&nbsp;</td></tr>';
								echo '</table>';
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"  bgcolor="#999798" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<form name="modificar_estructura" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "modificar_seccion_estructura" />';
												echo '<input type="submit" name="Submit" value="'.btn_mod_est_mod_sec.'" />';
											echo '</form>';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<form name="agregar_modulos_centrales" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "ingresar_modulos" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
												echo '<input type="hidden" name="tipo_modulo" value = "central" />';
												echo '<input type="submit" name="Submit" value="'.btn_agre1_mod_mod_sec.'" />';
											echo '</form>';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<form name="agregar_modulos_secundarios" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "ingresar_modulos" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
												echo '<input type="hidden" name="tipo_modulo" value = "secundario" />';
												echo '<input type="submit" name="Submit" value="'.btn_agre2_mod_mod_sec.'" />';
											echo '</form>';
										echo '</td>';
									echo '</tr>';
									echo '<tr><td align ="center">&nbsp;</td></tr>';
									for($a=0;$a<$cantidad;$a++)
										{
											$clave_modulo = $arreglo_modulos[$a][1];
											$nombre_modulo = $arreglo_modulos[$a][2];
											$clave_secciones_modulos = $arreglo_modulos[$a][4];
											echo '<tr>';
												echo '<td align ="center">';
													echo '<form name="modificar_modulo_'.$clave_modulo.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
														echo '<input type="hidden" name="archivo" value = "administracion.php" />';
														echo '<input type="hidden" name="clase" value = "administracion" />';
														echo '<input type="hidden" name="metodo" value = "modificar_modulo" />';	
														echo '<input type="hidden" name="clave_secciones_modulos" value = "'.$clave_secciones_modulos.'" />';
														echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
														echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
														echo '<input type="hidden" name="nombre_modulo" value = "'.$nombre_modulo.'" />';
														echo '<input type="submit" name="Submit" value="'.btn_mod_modu_mod_sec.': '.$nombre_modulo.'" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
										}
									$conexion = $this->conectarse();
									$con_seciones = " select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$clave_seccion_enviada'";
									$res_sec = mysql_query($con_seciones);
									$ren = mysql_fetch_array($res_sec);
									$clave_seccion_pertenece = $ren["clave_seccion_pertenece"];
									if($clave_seccion_pertenece=="")
										{$clave_seccion_pertenece=1;}
									$this->desconectarse($conexion);
									echo '<tr><td >&nbsp;</td></tr>';
								echo '</table>';
							}
						echo '<br />';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_pertenece, 'texto'=>regresar_nue_sec,'opc_regreso'=>'listado'));						
					}
				else
					{
						$this->acceso_denegado();
					}				
			}	
					
		function cargar_modulos_modificacion()
			{	
				$archivo = (isset($_POST["archivo"])) ?$_POST["archivo"]:'';
				$clase = (isset($_POST["clase"])) ?$_POST["clase"]:'';
				$funcion = (isset($_POST["metodo"])) ?$_POST["metodo"]:'';	
				if($archivo=='' and $clase == '' and $funcion =='')
					{
						echo '<br /><br />';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align ="center"><strong>'.error_cargar_mod.'</strong></td></tr>';
							echo '<tr><td align ="center"><br /><br /></td></tr>';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php" class="regresar">';
									echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
									echo '<strong>'.erro_reg_ini.'</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
				else
					{
						if($archivo=="administracion.php" and $clase == "administracion")
							{$this->$funcion();	}
						else
							{
								include_once($archivo);
								$obj = new $clase();
								$obj->$funcion($this->nick_user, $this->nivel, $this->ubi_tema, $this->nombre, $this->correo_user);
							}
					}
			}
			
		function cambios_seccion()
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				$pasar = "no";
				$arreglo_temporal = $this->secciones;
				$cantidad_secciones = count($arreglo_temporal);
				for($a=0;$a<$cantidad_secciones;$a++)
					{	
						if($arreglo_temporal[$a] == $clave_seccion_enviada)
							{$pasar = 'si';}
					}
				if($this->nivel==1)
					{$pasar = 'si';	}
					
				if($pasar == 'si')
					{
						$conexion = $this->conectarse();
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion(titulo_cambio_sec);
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
							echo '<tr><td align="center"><strong>"'.$nombre_sec.'"</strong></td></tr>';
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798" >';
							echo '<tr><td>&nbsp;</td></tr>';
							echo '<tr><td align ="center"><strong>'.list_mod_mod_sec.'</strong></td></tr>';
							echo '<tr><td>&nbsp</td></tr>';
						echo '</table>';
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
							echo '<tr><td width="50%" align="center"><strong>'.nom_mod_mod_sec.'</strong></td><td width="50%" align="center"><strong>'.opc_mod_mod_sec.'</strong></td></tr>';
							echo '<tr><td >&nbsp;</td><td >&nbsp;</td></tr>';
						$arreglo_modulos = $this->obtener_modulos($clave_seccion_enviada);
						$cantidad  = count($arreglo_modulos);
						$con_sec=0;
						for($a=0;$a<$cantidad;$a++)
							{
								$situacion = $arreglo_modulos[$a][5];
								if($situacion=="activo")
									{
										$clave_modulo = $arreglo_modulos[$a][1];
										$nombre_modulo = $arreglo_modulos[$a][2];
										$archivo = "../librerias/modulos/".$arreglo_modulos[$a][3]."/".$arreglo_modulos[$a][3]."_admon.php";
										$clase = "clase_".$arreglo_modulos[$a][3];
										$tipo = $arreglo_modulos[$a][6];
										if($a==0)
											{
												echo '</table>';
												echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
													echo '<tr><td align="center"><strong>'.mod_cent_mod_sec.'</strong></td></tr>';
												echo '</table>';
												echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
											}
										if(($tipo=='secundario') and ($con_sec == 0))
											{
												echo '</table>';
												echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
													echo '<tr><td align="center"><strong>'.mod_sec_mod_sec.'</strong></td></tr>';
												echo '</table>';
												echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
												$con_sec++;
											}
										include_once($archivo);
										$obj = new $clase();
										$color = "#F89520";
										if( $a % 2 == 0)
											{ $color = '#F7BB49'; }
										echo '<tr>';
											echo '<td width="50%" align="center" bgcolor="'.$color.'">'.$nombre_modulo.'</td>';	
											echo '<td width="50%" align="center" bgcolor="'.$color.'">';	
												$obj->op_cambios_central($clave_seccion_enviada, $this->nivel, $nombre_sec, $clave_modulo);
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
									}
							}
						echo '</table>';
						$conexion = $this->conectarse();	
						$con_seciones = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$clave_seccion_enviada'";
						$res_sec = mysql_query($con_seciones);
						$ren = mysql_fetch_array($res_sec);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"];
						if($clave_seccion_pertenece=='')
							{$clave_seccion_pertenece=1;}	
						echo '<br />';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_pertenece,'texto'=>regresar_nue_sec,'opc_regreso'=>'listado'));
					}
				else
					{
						$this->acceso_denegado();
					}
			}
		function obtener_modulos($clave_seccion)
			{
				$con_mod = "select m.nombre_archivo, m.nombre, m.clave_modulo, sm.clave_secciones_modulos, sm.situacion, m.tipo
				from nazep_secciones_modulos sm, nazep_modulos m
				where clave_seccion = '$clave_seccion' and sm.clave_modulo = m.clave_modulo order by m.tipo, sm.orden";
				$res_con = mysql_query($con_mod);
				$con = 0;
				while($ren = mysql_fetch_array($res_con))
					{
						$arreglo_modulos[$con][1] = $ren["clave_modulo"];
						$arreglo_modulos[$con][2] = $ren["nombre"];
						$arreglo_modulos[$con][3] = $ren["nombre_archivo"];
						$arreglo_modulos[$con][4] = $ren["clave_secciones_modulos"];
						$arreglo_modulos[$con][5] = $ren["situacion"];
						$arreglo_modulos[$con][6] = $ren["tipo"];
						$con++;
					}			
				return $arreglo_modulos;
			}
		function estadisticas_seccion()
			{
				$clave_seccion_tra = $_GET["clave_seccion"];
				if(isset($_POST["estadisticas"]) && $_POST["estadisticas"]=="visita")
					{
						$nombre = HtmlAdmon::historial($clave_seccion_tra);
						$clave_seccion_tra = $_POST["clave_seccion"];
						HtmlAdmon::titulo_seccion(txt_vis_de." \"$nombre\" ");
						if(isset($_POST["buscar"]) && $_POST["buscar"] == 'si')
							{
								$formato_contenido = $_POST["formato_contenido"];
								$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
								$fecha_termino = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
								$fecha_inicio_f = FunGral::fechaNormal($fecha_inicio);
								$fecha_termino_f = FunGral::fechaNormal($fecha_termino);
								$clave_seccion  = $_POST["clave_seccion"];
								$con_seccion = "select visita, fecha from nazep_v_visitas_simple where clave_seccion = '$clave_seccion' and fecha >='$fecha_inicio' and fecha <='$fecha_termino'";	
								$conexion = $this->conectarse();
								$res_visitas = mysql_query($con_seccion);
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align ="center">'.txt_vis_per.' <br />'.de.' '.$fecha_inicio_f .'<br />'.a.' '.$fecha_termino_f.' <br /><br /></td></tr>';
								echo '</table>';
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td>'.fecha.'</td><td width="500">'.txt_vis_cant.'</td></tr>';
									while($ren_vis = mysql_fetch_array($res_visitas))
										{	
											$visita = $ren_vis["visita"];
											$fecha = $ren_vis["fecha"];
											$fecha = FunGral::fechaNormal($fecha);	
											echo '<tr><td>'.$fecha.'</td><td>'.$visita.'</td></tr>';
										}
								echo '</table>';
								if($formato_contenido=="")
									{
										echo '<form name="reg_buscador" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_tra.'">';
											echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0"  align = "center">';
												echo '<tr>';
													echo '<td align="center">';
														echo '<input type="hidden" name="archivo" value = "administracion.php" />';
														echo '<input type="hidden" name="clase" value = "administracion" />';
														echo '<input type="hidden" name="metodo" value = "estadisticas_seccion" />';
														echo '<input type="hidden" name="estadisticas" value = "visita" />';
														echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_tra.'" />';
														echo '<a href="javascript:document.reg_buscador.submit()" class="regresar">';
														echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
														echo '<strong>'.txt_vis_reg_bus.'</strong></a>';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
										echo '</form>';
									}
							}
						else
							{
								echo '<script type="text/javascript">';
								echo 'function validar_form(formulario, formato)
											{
												if(formato == "excel")
													{
														formulario.target = "_blank";	
													}
												formulario.formato_contenido.value = formato;
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
												formulario.submit();
											}';		
								echo '</script>';
								echo '<form id="buscar_visitas" name="buscar_visitas" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_tra.'">';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td>'.fecha_ini_bus.'</td><td>';
												$dia=date('d');
												$mes=date('m');
												$ano=date('Y');
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name = "dia_i">';
													for ($a = 1; $a<=31; $a++)
														{ echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>'; }
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_i">';
													for ($b=1; $b<=12; $b++)
														{ echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>'; }
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_i">';
													for ($b=$ano-6; $b<=$ano+10; $b++)
														{ echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>'; }
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fecha_fin_bus.'</td><td>';
												echo dia.'&nbsp;<select name = "dia_t">';
													for ($a = 1; $a<=31; $a++)
														{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_t">';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_t">';
													for ($b=$ano-6; $b<=$ano+10; $b++)
														{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "estadisticas_seccion" />';
												echo '<input type="hidden" name="buscar" value = "si" />';
												echo '<input type="hidden" name="estadisticas" value = "visita" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_tra.'" />';
												echo '<input type="hidden" name="formato_contenido" value = "" />';
												echo '<input type="submit" name="btn_buscar" value="'.txt_vis_buscar.'" onclick= "return validar_form(this.form, \'\')" />';
												echo '<input type="submit" name="btn_buscar_excel" value="'.txt_vis_buscar_excel.'" onclick= "return validar_form(this.form, \'excel\')" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::boton_regreso(array('opc_regreso'=>'estadisticas', 
								'clave_usar'=>$clave_seccion_tra,'texto'=>regresar_opc_mod));
							}
					}
				elseif(isset($_POST["estadisticas"]) && $_POST["estadisticas"]=="recomendar")
					{
						$nombre = HtmlAdmon::historial($clave_seccion_tra);
						$clave_seccion_tra = $_POST["clave_seccion"];
						HtmlAdmon::titulo_seccion(txt_rec_de." \"$nombre\"");	
						if(isset($_POST["clave_recomendar"]) && $_POST["clave_recomendar"]!='')
							{
								$ano_i = $_POST["ano_i"];
								$mes_i = $_POST["mes_i"];
								$dia_i = $_POST["dia_i"];
								$ano_t = $_POST["ano_t"];
								$mes_t = $_POST["mes_t"];
								$dia_t = $_POST["dia_t"];
								$clave_recomendar = $_POST["clave_recomendar"];
								$con_recome ="select * from nazep_zmod_recomendar where clave_recomendar = '$clave_recomendar'";
								$conexion = $this->conectarse();
								$res_recome = mysql_query($con_recome);
								$ren_recome = mysql_fetch_array($res_recome);
								$fecha = $ren_recome["fecha"];
								$fecha = FunGral::fechaNormal($fecha);
								$hora = $ren_recome["hora"];
								$ip = $ren_recome["ip"];
								$enlace = $ren_recome["enlace"];
								$nombre_envia = $ren_recome["nombre_envia"];
								$correo_envia = $ren_recome["correo_envia"];
								$nombre_recibe = $ren_recome["nombre_recibe"];
								$correo_recibe = $ren_recome["correo_recibe"];
								$comentario = $ren_recome["comentario"];
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" ><tr><td align ="center">'.txt_recomendacion.'</td></tr></table>';
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td>'.fecha.'</td><td>'.$fecha.' a las '.$hora.' hrs.</td></tr>';
									echo '<tr><td>'.txt_rec_ip.'</td><td>'.$ip.'</td></tr>';
									echo '<tr><td>'.txt_rec_enl.'</td><td>'.$enlace.'</td></tr>';
									echo '<tr><td>'.txt_rec_nom_env.'</td><td>'.$nombre_envia.'</td></tr>';
									echo '<tr><td>'.txt_rec_cor_env.'</td><td>'.$correo_envia.'</td></tr>';
									echo '<tr><td>'.txt_rec_nom_rec.'</td><td>'.$nombre_recibe.'</td></tr>';
									echo '<tr><td>'.txt_rec_cor_rec.'</td><td>'.$correo_recibe.'</td></tr>';
									echo '<tr><td>'.txt_rec_com_env.'</td><td>'.$comentario.'</td></tr>';
								echo '</table>';
								echo '<form name="reg_buscador" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_tra.'">';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "estadisticas_seccion" /';
												echo '<input type="hidden" name="buscar" value = "si" />';
												echo '<input type="hidden" name="nombre" value = "'.$nombre.'" />';
												echo '<input type="hidden" name="estadisticas" value = "recomendar" />';
												echo '<input type="hidden" name="ano_i" value = "'.$ano_i.'" />';
												echo '<input type="hidden" name="mes_i" value = "'.$mes_i.'" />';
												echo '<input type="hidden" name="dia_i" value = "'.$dia_i.'" />';
												echo '<input type="hidden" name="ano_t" value = "'.$ano_t.'" />';
												echo '<input type="hidden" name="mes_t" value = "'.$mes_t.'" />';
												echo '<input type="hidden" name="dia_t" value = "'.$dia_t.'" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_tra.'" />';
												echo '<a href="javascript:document.reg_buscador.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<strong>'.txt_rec_reg_lis.'</strong></a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}				
						elseif(isset($_POST["buscar"]) && $_POST["buscar"]=="si")
							{
								$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
								$fecha_termino = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
								$ano_i = $_POST["ano_i"];
								$mes_i = $_POST["mes_i"];
								$dia_i = $_POST["dia_i"];
								$ano_t = $_POST["ano_t"];
								$mes_t = $_POST["mes_t"];
								$dia_t = $_POST["dia_t"];
								$fecha_inicio_f = FunGral::fechaNormal($fecha_inicio);
								$fecha_termino_f = FunGral::fechaNormal($fecha_termino);
								$clave_seccion  = $_POST["clave_seccion"];
								$con_seccion = "select enlace, fecha, clave_recomendar from nazep_zmod_recomendar  where clave_seccion = '$clave_seccion' and fecha >='$fecha_inicio' and fecha <='$fecha_termino'";
								$conexion = $this->conectarse();	
								$res_recomendar = mysql_query($con_seccion);
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align ="center">'.txt_rec_per.' <br />'.de.' '.$fecha_inicio_f.' <br />'.a.' '.$fecha_termino_f.' <br /><br /></td></tr>';
								echo '</table>';
								echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td>'.fecha.'</td><td>'.txt_rec_enl.'</td><td>'.txt_rec_ver_det.'</td></tr>';
									$contador = 0;
									while($ren_vis = mysql_fetch_array($res_recomendar))
										{	
											if(($contador%2)==0)
												$color = 'bgcolor="#F9D07B"';
											else
												$color = '';
											$enlace = $ren_vis["enlace"];
											$fecha = $ren_vis["fecha"];
											$clave_recomendar = $ren_vis["clave_recomendar"];
											$fecha = FunGral::fecha_normal($fecha);	
											echo '<tr>';
												echo '<td '.$color.'>'.$fecha.'</td><td '.$color.'>'.$enlace.'</td>';
												echo '<td '.$color.'>';
													echo '<form name="ver_detalle" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_tra.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "administracion.php" />';
														echo '<input type="hidden" name="clase" value = "administracion" />';
														echo '<input type="hidden" name="metodo" value = "estadisticas_seccion" />';
														echo '<input type="hidden" name="clave_recomendar" value = "'.$clave_recomendar.'" />';
														echo '<input type="hidden" name="estadisticas" value = "recomendar" />';
														echo '<input type="hidden" name="ano_i" value = "'.$ano_i.'" />';
														echo '<input type="hidden" name="mes_i" value = "'.$mes_i.'" />';
														echo '<input type="hidden" name="dia_i" value = "'.$dia_i.'" />';
														echo '<input type="hidden" name="ano_t" value = "'.$ano_t.'" />';
														echo '<input type="hidden" name="mes_t" value = "'.$mes_t.'" />';
														echo '<input type="hidden" name="dia_t" value = "'.$dia_t.'" />';
														echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion.'" />';
														echo '<input type="submit" name="Submit" value="'.txt_rec_ver_det.'" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table>';
								HtmlAdmon::boton_regreso(array('tipo'=>'avanzado',
								'opc_regreso'=>'estadisticas',
								'clave_usar'=>$clave_seccion_tra,'texto'=>txt_rec_reg_bus,
									'OpcOcultas'=>array('archivo'=>'administracion.php',
										'clase'=>'administracion',
										'metodo'=>'estadisticas_seccion',
										'estadisticas'=>'recomendar',
										'clave_seccion'=>$clave_seccion_tra)));
							}
						else
							{
								echo '<script type="text/javascript">';
								echo 'function validar_form(formulario)
										{
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
											formulario.submit();
										}';
								echo '</script>';
								echo '<form name="buscar_recomendaciones" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_tra.'">';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>'.fecha_ini_bus.'</td><td>';
												$dia=date('d');
												$mes=date('m');
												$ano=date('Y');
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name = "dia_i">';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_i">';
												for ($b=1; $b<=12; $b++)
													{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_i">';
												for ($b=$ano-6; $b<=$ano+10; $b++)
													{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fecha_fin_bus.'</td>';
											echo '<td>';
												echo dia.'&nbsp;<select name = "dia_t">';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_t">';
												for ($b=1; $b<=12; $b++)
													{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo '>'.$areglo_meses[$b].'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_t">';
												for ($b=$ano-6; $b<=$ano+10; $b++)
													{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';	}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="archivo" value = "administracion.php" />';
												echo '<input type="hidden" name="clase" value = "administracion" />';
												echo '<input type="hidden" name="metodo" value = "estadisticas_seccion" />';
												echo '<input type="hidden" name="buscar" value = "si" />';
												echo '<input type="hidden" name="estadisticas" value = "recomendar" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_tra.'" />';
												echo '<input type="submit" name="btn_guardar" value="'.txt_rec_buscar.'" onclick= "return validar_form(this.form)" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_tra,'opc_regreso'=>'estadisticas',
								'texto'=>txt_regresar_estadisticas));
							}
					}
				else
					{
						$conexion = $this->conectarse();
						$nombre = HtmlAdmon::historial($clave_seccion_tra);
						HtmlAdmon::titulo_seccion("Estad&iacute;sticas de \"$nombre\"");
						echo '<table width="'.$this->ancho_pixeles.'" border="0" cellspacing="0" cellpadding="0" bgcolor="#999798">';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<form name="verificar_visitas" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_tra.'" method="post" >';
										echo '<input type="hidden" name="archivo" value = "administracion.php" />';
										echo '<input type="hidden" name="clase" value = "administracion" />';
										echo '<input type="hidden" name="metodo" value = "estadisticas_seccion" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_tra.'" />';
										echo '<input type="hidden" name="estadisticas" value = "visita" />';
										echo '<input type="submit" name="Submit" value="'.txt_verificar_visita.'" />';
									echo '</form>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<form name="verificar_recomendaciones" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_tra.'" method="post" >';
										echo '<input type="hidden" name="archivo" value = "administracion.php" />';
										echo '<input type="hidden" name="clase" value = "administracion" />';
										echo '<input type="hidden" name="metodo" value = "estadisticas_seccion" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_tra.'" />';
										echo '<input type="hidden" name="estadisticas" value = "recomendar" />';
										echo '<input type="submit" name="Submit" value="'.txt_verificar_recome.'" />';
									echo '</form>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
						$conexion = $this->conectarse();
						$con_seciones = "select clave_seccion_pertenece  from nazep_secciones where clave_seccion = '$clave_seccion_tra'";
						$res_sec = mysql_query($con_seciones);
						$ren = mysql_fetch_array($res_sec);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"];
						if($clave_seccion_pertenece=="")
							{$clave_seccion_pertenece=1;}
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_pertenece,'opc_regreso'=>'1','texto'=>txt_regresar_listado));
					}
			}
	}
session_start();  
$sesion_temporal_admon = md5(nombre_base."administracion");
if (!isset($_SESSION[$sesion_temporal_admon])) 
	{
		$_SESSION[$sesion_temporal_admon] = new administracion();
	}
?>