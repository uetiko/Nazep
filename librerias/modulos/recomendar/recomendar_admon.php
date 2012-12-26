<?php
/*
Sistema: Nazep
Nombre archivo: recomendar_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de recomendar el sitio
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_recomendar extends conexion
	{
		private $DirArchivo = '../librerias/modulos/recomendar/recomendar_admon.php';
		private $NomClase = 'clase_recomendar';		
		function __construct($etapa='test')
			{
                            if($etapa=='usar')
                                {
                                    include_once('../librerias/idiomas/'.FunGral::SaberIdioma().'/recomendar.php');
                                }
			} 
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == "activo")
					{
						HtmlAdmon::AccesoMetodo(array(
							'ClaveSeccion'=>$clave_seccion_enviada,
							'name'=>'ver_recomendaciones',
							'Id'=>'ver_recomendaciones',
							'BText'=>reco_btn_1_ve_rec,
							'BName'=>'btn_ver_recomendaciones',
							'BId'=>'btn_ver_recomendaciones',
							'OpcOcultas' => array(
								'archivo' =>$this->DirArchivo,
								'clase' =>$this->NomClase,
								'metodo' =>'ver_recomendaciones') ));							
						if($nivel=="1")
							{
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'conf_recomendaciones',
									'Id'=>'conf_recomendaciones',
									'BText'=>reco_btn_2_conf,
									'BName'=>'btn_conf_recomendaciones',
									'BId'=>'btn_conf_recomendaciones',
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'configurar_recomenaciones') ));
							}
					}
				else
					{ echo '<br />'.reco_mens_mod_no_act_modi; 	}
			}
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{ echo '<br />'.avi_no_mod_mod; }
// ------------------------------ Fin de funciones para controlar las funciones del m�dulo
// ------------------------------ Inicio de funciones para controlar la modificaci�n de la informaci�n del m�dulo			
		function configurar_recomenaciones($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$asunto = $_POST["asunto"];
						$introduccion = $_POST["introduccion"];
						$mensaje = $_POST["mensaje"];
						$mensaje = strip_tags($mensaje);
						$despedida = $_POST["despedida"];
						$ancho_nom1 = $_POST["ancho_nom1"];
						$ancho_cor1 = $_POST["ancho_cor1"];
						$ancho_nom2 = $_POST["ancho_nom2"];
						$ancho_cor2 = $_POST["ancho_cor2"];
						$ancho_mens = $_POST["ancho_mens"];
						$alto_mens = $_POST["alto_mens"];
						$clave_seccion = $_POST["clave_seccion"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$update = "update nazep_zmod_recomendar_conf set user_actualiza = '$nick_user', ip_actualiza = '$ip', fecha_actualiza = '$fecha_hoy', hora_acutaliza = '$hora_hoy',
						asunto = '$asunto', introduccion = '$introduccion', mensaje = '$mensaje', despedida = '$despedida', ancho_nom1 = '$ancho_nom1',
						ancho_cor1 = '$ancho_cor1', ancho_nom2 = '$ancho_nom2', ancho_cor2 = '$ancho_cor2', ancho_mens = '$ancho_mens', alto_mens = '$alto_mens',
						alto_mens = '$alto_mens'";
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
				else
					{
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(reco_txt_tit_con);	
						$con_con ="select * from nazep_zmod_recomendar_conf";
						$res_con = mysql_query($con_con);
						$ren_con = mysql_fetch_array($res_con);
						$asunto = $ren_con["asunto"];
						$introduccion = $ren_con["introduccion"];
						$mensaje = $ren_con["mensaje"];
						$despedida = $ren_con["despedida"];
						$ancho_nom1 = $ren_con["ancho_nom1"];
						$ancho_cor1 = $ren_con["ancho_cor1"];
						$ancho_nom2 = $ren_con["ancho_nom2"];
						$ancho_cor2 = $ren_con["ancho_cor2"];
						$ancho_mens = $ren_con["ancho_mens"];
						$alto_mens = $ren_con["alto_mens"];
						$user_actualiza = $ren_con["user_actualiza"];
						$ip_actualiza = $ren_con["ip_actualiza"];
						$fecha_actualiza = $ren_con["fecha_actualiza"];
						$hora_acutaliza  = $ren_con["hora_acutaliza"];
						echo '<script type="text/javascript">';
						echo ' 	$(document).ready(function()
								{									
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_configurar_recome");
								});							
							function validar_form(formulario)
								{
									if(formulario.asunto.value == "") 
										{
											alert("'.reco_js_1.'");
											formulario.asunto.focus(); 	
											return false;
										}
									if(formulario.introduccion.value == "") 
										{
											alert("'.reco_js_2.'");
											formulario.introduccion.focus();
											return false;
										}
									if(formulario.mensaje.value == "") 
										{
											alert("'.reco_js_3.'");
											formulario.mensaje.focus(); 	
											return false;
										}	
									if(formulario.despedida.value == "") 
										{
											alert("'.reco_js_4.'");
											formulario.despedida.focus(); 
											return false;
										}	
									formulario.btn_guardar.style.visibility="hidden";
								} ';
						echo '</script>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>'.user_actua.'</td><td>'.$user_actualiza.'</td></tr>';
							echo '<tr><td>'.fecha_actua.'</td><td>'.$fecha_actualiza.' a las '.$hora_acutaliza.' Hrs.'.'</td></tr>';
							echo '<tr><td>'.ip_actua.'</td><td>'.$ip_actualiza.'</td></tr>';
						echo '</table>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/recomendar/recomendar_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_recomendar"/>';
							echo '<input type="hidden" name="metodo" value = "configurar_recomenaciones" />';
						echo '</form>';
						echo '<form name="frm_configurar_recome" id="frm_configurar_recome" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.reco_txt_tex_asu.'</td><td><input type = "text" name = "asunto" size = "40" value= "'.$asunto.'"/></td></tr>';
								echo '<tr><td>'.reco_txt_int_men.'</td><td><input type = "text" name = "introduccion" size = "40" value= "'.$introduccion.'"/></td></tr>';
								echo '<tr><td>'.reco_txt_text_dir.'</td><td><textarea name="mensaje" cols="35" rows="5">'.$mensaje.'</textarea></td></tr>';
								echo '<tr><td>'.reco_txt_text_des.'</td><td><textarea name="despedida" cols="35" rows="5">'.$despedida.'</textarea></td></tr>';
								echo '<tr><td>'.reco_txt_anc_nom.'</td><td><input type = "text" name = "ancho_nom1" size = "10" onkeypress="return solo_num(event)"  value= "'.$ancho_nom1.'"/></td></tr>';
								echo '<tr><td>'.reco_txt_anc_cor.'</td><td><input type = "text" name = "ancho_cor1" size = "10" onkeypress="return solo_num(event)" value= "'.$ancho_cor1.'"/></td></tr>';
								echo '<tr><td>'.reco_txt_anc_nom_r.'</td><td><input type = "text" name = "ancho_nom2" size = "10" onkeypress="return solo_num(event)" value= "'.$ancho_nom2.'" /></td></tr>';
								echo '<tr><td>'.reco_txt_anc_cor_r.'</td><td><input type = "text" name = "ancho_cor2" size = "10" onkeypress="return solo_num(event)" value= "'.$ancho_cor2.'" /></td></tr>';
								echo '<tr><td>'.reco_txt_anc_men.'</td><td><input type = "text" name = "ancho_mens" size = "10" onkeypress="return solo_num(event)" value= "'.$ancho_mens.'"/></td></tr>';
								echo '<tr><td>'.reco_txt_alt_men.'</td><td><input type = "text" name = "alto_mens" size = "10" onkeypress="return solo_num(event)" value= "'.$alto_mens.'"/></td></tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/recomendar/recomendar_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_recomendar" />';
										echo '<input type="hidden" name="metodo" value = "configurar_recomenaciones" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
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
		function ver_recomendaciones($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["buscar"]) && $_POST["buscar"]=="si")
					{
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_fin = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(reco_txt_tit_lis_rec);
						$con_reco ="select s.nombre, r.fecha, r.hora, r.nombre_envia, r.correo_envia, r.nombre_recibe, r.correo_recibe, r.comentario
						from nazep_zmod_recomendar r, nazep_secciones s 
						where r.fecha >= '$fecha_inicio' and r.fecha <= '$fecha_fin' and r.clave_seccion = s.clave_seccion";
						$conexion = $this->conectarse();
						$res_reco = mysql_query($con_reco);
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td><strong>'.fecha.'</strong></td>';
								echo '<td><strong>'.reco_txt_sec_rec.'</strong></td>';
								echo '<td><strong>'.reco_txt_per_env.'</strong></td>';
								echo '<td><strong>'.reco_txt_per_rec.'</strong></td>';
								echo '<td><strong>'.reco_txt_com_env.'</strong></td>';
							echo '</tr>';
							$contador = 0;
							while($ren_reco = mysql_fetch_array($res_reco))
								{
									if(($contador%2)==0)
										{$color = 'bgcolor="#F9D07B"';}
									else
										{ $color = ''; }
									$nombre = $ren_reco["nombre"];
									$fecha = $ren_reco["fecha"];
									$fecha = $this->fecha_normal($fecha);
									$hora = $ren_reco["hora"];
									$nombre_envia = $ren_reco["nombre_envia"];
									$correo_envia = $ren_reco["correo_envia"];
									$nombre_recibe = $ren_reco["nombre_recibe"];
									$correo_recibe = $ren_reco["correo_recibe"];
									$comentario = $ren_reco["comentario"];
									echo '<tr>';
										echo '<td '.$color.'>'.$fecha.'<br />'.$hora.'Hrs. </td>';
										echo '<td '.$color.'>'.$nombre.'</td>';
										echo '<td '.$color.'>'.$nombre_envia.'<br />'.$correo_envia.'</td>';
										echo '<td '.$color.'>'.$nombre_recibe.'<br />'.$correo_recibe.'</td>';
										echo '<td '.$color.'>'.$comentario.'</td>';
									echo '</tr>';
									$contador++;
								}
						echo '</table>';
						echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/recomendar/recomendar_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_recomendar" />';
										echo '<input type="hidden" name="metodo" value = "ver_recomendaciones" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
										echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
										echo '<strong>'.reco_txt_reg_bus_rec.'</strong></a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
				else
					{
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(reco_txt_tit_bus_rec);
						echo '<form name="buscar_recomendaciones" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>'.fecha_ini_bus.'</td>';
									echo '<td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										$areglo_meses = FunGral::MesesNumero();								
										echo dia.'&nbsp;<select name = "dia_i">';
										for ($a = 1; $a<=31; $a++)
											 {echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' >'.$a.'</option>'; }
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_i">';
											for ($b=1; $b<=12; $b++)
												{ echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected"  ';} echo ' >'. $areglo_meses[$b] .'</option>'; }
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_i">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{ echo '<option value = "'.$b.'" '; if ($ano == $b) {echo '  selected="selected"  ';} echo '> '.$b.'</option>'; }
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.fecha_fin_bus.'</td>';
									echo '<td>';
										echo dia.'&nbsp;<select name = "dia_t">';
										for ($a = 1; $a<=31; $a++)
											 {echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' >'.$a.'</option>'; }
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_t">';
											for ($b=1; $b<=12; $b++)
												{ echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>'; }
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_t">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{ echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>'; }
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/recomendar/recomendar_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_recomendar" />';
							echo '<input type="hidden" name="metodo" value = "ver_recomendaciones" />';
							echo '<input type="hidden" name="buscar" value = "si" />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td><input type="submit" name="btn_guardar" value="'.buscar.'" /></td></tr></table>';
						echo '</form>';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
	}
?>