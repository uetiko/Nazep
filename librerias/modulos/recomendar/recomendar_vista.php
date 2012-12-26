<?php
/*
Sistema: Nazep
Nombre archivo: recomendar_vista.php
Función archivo: archivo para controlar la vista final del m�dulo de recomendar
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_recomendar extends conexion
	{
		function __construct()
			{
                            include_once('librerias/idiomas/'.FunGral::SaberIdioma().'/recomendar.php');
			}
		function vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				$direccion_regreso = $_POST["direccion_regreso"]; 
				$conexion = $this->conectarse();
				
                                $con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp from nazep_configuracion";
				$con_configurar ="select asunto, introduccion, mensaje, despedida from nazep_zmod_recomendar_conf";
				$res_configurar = mysql_query($con_configurar);
				$ren_configurar = mysql_fetch_array($res_configurar);
				$asunto = $ren_configurar["asunto"];
				$introduccion	 = $ren_configurar["introduccion"];
				$mensaje = $ren_configurar["mensaje"];
				$despedida = $ren_configurar["despedida"];	
				$res_con = mysql_query($con_conf);
				$ren_con = mysql_fetch_array($res_con);
				$envio_correo = $ren_con["envio_correo"];
				$servidor_smtp = $ren_con["servidor_smtp"];
				$user_smtp = $ren_con["user_smtp"];
				$pass_smtp	= $ren_con["pass_smtp"];
				$mensaje_recomendar = $ren_con["mensaje_recomendar"];
				$sesion_temporal = md5(nombre_base);
				$nueva_usar = $_SESSION[$sesion_temporal]->direccion_recomendar_g;
				$_SESSION[$sesion_temporal]->direccion_recomendar_g="index.php";
				$direccion = $nueva_usar;
				$clave_seccion = $_SESSION[$sesion_temporal]->clave_recomendar_g;
				$_SESSION[$sesion_temporal]->clave_recomendar_g=1;
				
				$nombre_envia = $_POST["nombre_envia"];
				$correo_envia = $_POST["correo_envia"];
				$nombre_recibe = $_POST["nombre_recibe"];
				$correo_recibe = $_POST["correo_recibe"];
				$comentario = $_POST["comentario"];
				$sec_recomendar = $_POST["sec_recomendar"];
                                
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
				$mail->From = $correo_envia;
				$mail->FromName = " ".$nombre_envia." ";
				$mail->AddAddress ($correo_recibe,$nombre_recibe);
				$mail->IsHTML(true);
				$mail->Subject = $asunto;
				$mail->Body = "
				$introduccion<br />
				<strong>$nombre_recibe</strong>
				<br /><br />
				$mensaje<br /><br />
				<br />
				$direccion
				<br /><br />
				$comentario
				<br /><br />
				$despedida";
				if(!$mail->Send())
					{
						$men = $mail->ErrorInfo;
						$paso = false;
						$error=1;
					}
				else 
					{
						$conexion = $this->conectarse();
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$insert = "insert into nazep_zmod_recomendar 
						(clave_seccion, fecha, hora, ip, enlace, nombre_envia, correo_envia, 
						nombre_recibe, correo_recibe, comentario)
						values
						('$clave_seccion','$fecha_hoy', '$hora_hoy', '$ip', '$direccion','$nombre_envia','$correo_envia',
						'$nombre_recibe', '$correo_recibe', '$comentario')";
						if (!@mysql_query($insert))
							{
								$men = mysql_error();
								$paso = false;
								$error = 2;
							}
						else
							{ $paso = true; }
					}
				if($paso)
					 echo 'termino-'; 
				else
					{
                                            if($error==1)
                                                    echo 'fallo-No se pudo enviar la Recomendación';
                                            else
                                                    echo 'fallo-Se envio la Recomendación, pero no se registro';
					}
			}
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
                            $con_con ="select ancho_nom1, ancho_cor1, ancho_nom2, ancho_cor2, ancho_mens, alto_mens from nazep_zmod_recomendar_conf";
                            $res_con = mysql_query($con_con);
                            $ren_con = mysql_fetch_array($res_con);
                            $ancho_nom1 = $ren_con["ancho_nom1"];
                            $ancho_cor1 = $ren_con["ancho_cor1"];
                            $ancho_nom2 = $ren_con["ancho_nom2"];
                            $ancho_cor2 = $ren_con["ancho_cor2"];
                            $ancho_mens = $ren_con["ancho_mens"];
                            $alto_mens = $ren_con["alto_mens"];
                            $con_conf = 'select url_sitio from nazep_configuracion';
                            $res_con = mysql_query($con_conf);
                            $ren_con = mysql_fetch_array($res_con);	
                            $url_sitio = $ren_con[url_sitio];
                            $direccion = $_GET["direccion"];
                            $clave_seccion_recomendar = $_GET["clave_seccion_recomendar"];

                            $dir_referencia = $_SERVER['HTTP_REFERER'];
                            $arreglo_uno = explode("?", $dir_referencia);
                            $primer_dir = $arreglo_uno[0];
                            $segund_dir = $arreglo_uno[1];
                            if($_GET["recomendar"]=='si')
                                {
                                    $direccion =$dir_referencia;
                                    $arreglo_sec = explode("sec=",$segund_dir);
                                    $clave_seccion_recomendar = $arreglo_sec[1];					
                                }
                            else
                                {
                                    $direccion = $url_sitio.'/index/index.php?sec=1';
                                    $clave_seccion_recomendar = 1;						
                                }
                            $sesion_temporal = md5(nombre_base);
                            $_SESSION[$sesion_temporal]->direccion_recomendar_g = $direccion;
                            $_SESSION[$sesion_temporal]->clave_recomendar_g = $clave_seccion_recomendar;
                            echo '<script type="text/javascript">';
                            echo '
                                            function validar_form(formulario)
                                                    {
                                                            if(formulario.nombre_envia.value == "") 
                                                                    {
                                                                            alert("'.reco_txt_java_1.'");
                                                                            formulario.nombre_envia.focus();
                                                                            return false;
                                                                    }
                                                            if(formulario.correo_envia.value == "") 
                                                                    {
                                                                            alert("'.reco_txt_java_2.'");
                                                                            formulario.correo_envia.focus();
                                                                            return false;
                                                                    }
                                                            correo_envia_d = formulario.correo_envia.value;	
                                                            if(!isEmailAddress(correo_envia_d))
                                                                    {
                                                                            alert("'.reco_txt_java_3.'");
                                                                            formulario.correo_envia.focus();
                                                                            return false;
                                                                    }
                                                            if(formulario.nombre_recibe.value =="") 
                                                                    {
                                                                            alert("'.reco_txt_java_4.'");
                                                                            formulario.nombre_recibe.focus();
                                                                            return false;
                                                                    }	
                                                            if(formulario.correo_recibe.value == "") 
                                                                    {
                                                                            alert("'.reco_txt_java_5.'");
                                                                            formulario.correo_recibe.focus();
                                                                            return false;
                                                                    }
                                                            correo_recibe_d = formulario.correo_recibe.value;	
                                                            if(!isEmailAddress(correo_recibe_d))
                                                                    {
                                                                            alert("'.reco_txt_java_6.'");
                                                                            formulario.correo_recibe.focus();
                                                                            return false;
                                                                    }	
                                                    }
                                            $(document).ready(function()
                                                    {	
                                                            $.frm_elem_color("#FACA70","");
                                                            $.guardar_datos_limpiar("recomendar_portal","'.$ubicacion_tema.'","La Recomendaci&oacute;n se Realizo exitosamente");
                                                    });			
                                    ';
                            echo '</script>';	
                            echo '<div id="div_resultado_operacion" style=" font-weight:bold; text-align:center;"> </div> ';
                            echo '<div id="centro_contenido_recomendar" class="centro_contenido_gral">';
                                    if(isset($_GET["men"]) &&  $_GET["men"]=="1")
                                            {echo '<div id="div_recomendar_mensaje_uno" class="recomendar_mensaje_uno" >'.reco_txt_men_1.'</div>';}
                                    elseif(isset($_GET["men"]) && $_GET["men"]=="2")
                                            {echo '<div id="div_recomendar_mensaje_uno" class="recomendar_mensaje_dos" >'.reco_txt_men_2.'</div>';}
                                    echo '<div id="div_recomendar_texto_dir" class="recomendar_texto_dir" >'.reco_txt_dir_reco.'</div>';
                                    echo '<div id="div_recomendar_enlace_dir" class="recomendar_enlace_dir" >'.$direccion.'</div>';
                                    $renglo_separacion = '<div class="recomendar_ren_vacio" ></div>';
                                    echo '<form id="recomendar_portal" name="recomendar_portal" method="post" action="index.php?sec='.$sec.'" >';
                                            echo '<input type="hidden" name="redireccion" value = "si" />';	
                                            echo '<input type="hidden" name="clave_seccion_recomendar" value = "'.$clave_seccion_recomendar.'" />';	
                                            echo '<input type="hidden" name="direccion_regreso" value = "index.php?sec='.$sec.'" />';
                                            echo '<input type="hidden" name="enviar" value = "si" />';
                                            echo '<div id="div_recomendar_col_texto_uno_uno"  class="recomendar_col_texto_uno" >'.reco_txt_nom_envi.'</div>';
                                            echo '<div id="div_recomendar_col_texto_dos_uno"  class="recomendar_col_texto_dos" ><input type = "text" name = "nombre_envia" size = "'.$ancho_nom1.'" /></div>';
                                            echo $renglo_separacion;
                                            echo '<div id="div_recomendar_col_texto_uno_dos"  class="recomendar_col_texto_uno" >'.reco_txt_cor_envi.'</div>';
                                            echo '<div id="div_recomendar_col_texto_dos_dos"  class="recomendar_col_texto_dos" >';
                                                    echo'<input type = "text" name = "correo_envia" size = "'.$ancho_cor1.'" onkeyup="recomendar_portal.correo_envia.value = recomendar_portal.correo_envia.value.toLowerCase();" />';
                                            echo'</div>';
                                            echo $renglo_separacion;
                                            echo '<div id="div_recomendar_col_texto_uno_tres"  class="recomendar_col_texto_uno" >'.reco_txt_nom_reci.'</div>';
                                            echo '<div id="div_recomendar_col_texto_dos_tres"  class="recomendar_col_texto_dos" ><input type = "text" name = "nombre_recibe" size = "'.$ancho_nom2.'" /></div>';
                                            echo $renglo_separacion;
                                            echo '<div id="div_recomendar_col_texto_uno_cuatro"  class="recomendar_col_texto_uno" >'.reco_txt_cor_reci.'</div>';
                                            echo '<div id="div_recomendar_col_texto_dos_cuatro"  class="recomendar_col_texto_dos" >';
                                                    echo'<input type = "text" name = "correo_recibe" size = "'.$ancho_cor2.'" onkeyup="recomendar_portal.correo_recibe.value = recomendar_portal.correo_recibe.value.toLowerCase();" />';
                                            echo'</div>';
                                            echo $renglo_separacion;
                                            echo '<div id="div_recomendar_col_texto_uno_cinco"  class="recomendar_col_texto_uno" >'.reco_txt_mensaje.'</div>';
                                            echo '<div id="div_recomendar_col_texto_dos_cinco"  class="recomendar_col_texto_dos" ><textarea name="comentario" cols="'.$ancho_mens.'" rows="'.$alto_mens.'"></textarea></div>';
                                            echo $renglo_separacion;
                                            echo '<div id="div_recomendar_boton_enviar" class="recomendar_boton_enviar">';
                                                    echo '<input type="submit"  name="btn_guardar" value="'.reco_btn_enviar.'" onclick= "return validar_form(this.form)" />';
                                            echo '</div>';
                                    echo '</form>';
                            echo'</div>';
			}
		function vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{}
		function vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario)
			{}
	}
?>