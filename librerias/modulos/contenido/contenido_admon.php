<?php
/*
Sistema: Nazep
Nombre archivo: contenido_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de contenido html
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_contenido extends conexion
	{
		
		private $DirArchivo = '../librerias/modulos/contenido/contenido_admon.php';
		private $NomClase = 'clase_contenido';
		function __construct($etapa='test')
			{
                            if($etapa=='usar')
                                {
                                    include('../librerias/idiomas/'.FunGral::SaberIdioma().'/contenido.php');
                                }
			}
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::vigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{
				   
						$con_cotenido = "select clave_contenido from nazep_zmod_contenido where clave_seccion = '$clave_seccion_enviada'  and clave_modulo = '$clave_modulo'";
						$res = mysql_query($con_cotenido);
						$cantidad = mysql_num_rows($res);
						if($cantidad!=0)
							{
								$ren_contenido = mysql_fetch_array($res);
								$clave_contenido = $ren_contenido["clave_contenido"];
								$cons_con_detalle = "select pagina, clave_contenido_detalle from nazep_zmod_contenido_detalle where clave_contenido = '$clave_contenido' order by pagina";
								$res_con_detalle = mysql_query($cons_con_detalle);
								while($ren_pagina = mysql_fetch_array($res_con_detalle))
									{
										$clave_contenido_detalle = $ren_pagina["clave_contenido_detalle"];
										$pagina = $ren_pagina["pagina"];
										$arreglo_paginas[$pagina] = $pagina;
									}
								$select_paginas = html::select(array('name'=>'paginas_contenido','id'=>'paginas_contenido',
													'presentacion'=>'return','opcionselect'=>$arreglo_paginas));								
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'frm_modificar_contenido',
									'Id'=>'frm_modificar_contenido',
									'BText'=>cont_btn_1_mod_con,
									'BName'=>'btn_modificar_contenido',
									'BId'=>'btn_modificar_contenido',
									'OpcAntes'=>$select_paginas,
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'modificar_contenido',
										'clave_modulo' =>$clave_modulo) ));									
							}
						else
							{
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'frm_crear_contenido',
									'Id'=>'frm_crear_contenido',
									'BText'=>cont_btn_2_crear_con,
									'BName'=>'btn_crear_contenido',
									'BId'=>'btn_crear_contenido',
									'OpcOcultas' => array(
										'archivo' =>$this->DirArchivo,
										'clase' =>$this->NomClase,
										'metodo' =>'crear_contenido',
										'clave_modulo' =>$clave_modulo) ));	
							}
					}
				else
					{
						echo '<br />'.cont_mens_mod_no_act_modi;
					}
			}
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{
				$situacion = FunGral::vigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{	
						if($nivel==1 or $nivel==2)
							{
								$con_cotenido = "select clave_contenido from nazep_zmod_contenido 
								where clave_seccion = '$clave_seccion_enviada' and situacion = 'nuevo' and clave_modulo = '$clave_modulo'";
								$conexion = $this->conectarse();
								$res = mysql_query($con_cotenido);
								$cantidad = mysql_num_rows($res);
								if($cantidad!=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_con_pendiente',
											'Id'=>'frm_con_pendiente',
											'BText'=>cont_btn_3_con__nue_pen,
											'BName'=>'btn_con_pendiente',
											'BId'=>'btn_con_pendiente',
											'OpcOcultas' => array(
												'archivo' =>$this->DirArchivo,
												'clase' => $this->NomClase,
												'metodo' =>'contenido_nuevo_pendiente',
												'clave_modulo' =>$clave_modulo) ));											
									}
								$con_cotenido1 = "select cc.clave_contenido from nazep_zmod_contenido c, nazep_zmod_contenido_cambios cc 
								where  c.clave_contenido = cc.clave_contenido  and c.clave_seccion = '$clave_seccion_enviada' and cc.situacion = 'pendiente'
								and c.clave_modulo = '$clave_modulo'";	
								$res1 = mysql_query($con_cotenido1);
								$cantidad1 = mysql_num_rows($res1);
								if($cantidad1 !=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_cambios_pen',
											'Id'=>'frm_cambios_pen',
											'BText'=>cont_btn_4_con_pen,
											'BName'=>'btn_cambios_pen',
											'BId'=>'btn_cambios_pen',
											'OpcOcultas' => array(
												'archivo' =>$this->DirArchivo,
												'clase' =>$this->NomClase,
												'metodo' =>'cambios_pendientes',
												'clave_modulo' =>$clave_modulo) ));
									}
								$con_cotenido1 = "select cc.clave_contenido from nazep_zmod_contenido c, nazep_zmod_contenido_cambios cc
								where  c.clave_contenido = cc.clave_contenido  and c.clave_seccion = '$clave_seccion_enviada' and cc.situacion = 'nueva_pagina'
								and c.clave_modulo = '$clave_modulo'";	
								$res1 = mysql_query($con_cotenido1);
								$cantidad1 = mysql_num_rows($res1);
								if($cantidad1 !=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_pag_pendiente',
											'Id'=>'frm_pag_pendiente',
											'BText'=>cont_btn_5_pag_pen,
											'BName'=>'btn_pag_pendiente',
											'BId'=>'btn_pag_pendiente',
											'OpcOcultas' => array(
												'archivo' =>$this->DirArchivo,
												'clase' =>$this->NomClase,
												'metodo' =>'pagina_pendiente',
												'clave_modulo' =>$clave_modulo) ));
									}
								$this->desconectarse($conexion);
							}
						$conexion = $this->conectarse();
						$con_cotenido2 = "select cc.clave_contenido from nazep_zmod_contenido c, nazep_zmod_contenido_cambios cc
						where  c.clave_contenido = cc.clave_contenido  and c.clave_seccion = '$clave_seccion_enviada'";	
						$res2 = mysql_query($con_cotenido2);
						$cantidad2 = mysql_num_rows($res2);
						$this->desconectarse($conexion);
						if($cantidad2!=0)
							{
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'frm_cam_realizados',
									'Id'=>'frm_pag_cam_realizados',
									'BText'=>cont_btn_6_cam_real,
									'BName'=>'btn_cam_realizados',
									'BId'=>'btn_pag_cam_realizados',
									'OpcOcultas' => array(
										'archivo' =>'../librerias/modulos/contenido/contenido_admon.php',
										'clase' =>'clase_contenido',
										'metodo' =>'cambios_realizados',
										'clave_modulo' =>$clave_modulo) ));
							}
					}
				else
					{echo '<br />'.cont_mens_mod_no_act_camb;}
			}
// ------------------------------ Fin de funciones para controlar las funciones del m�dulo
// ------------------------------ Inicio de funciones para controlar la modificaci�n de la informaci�n del m�dulo
		function crear_contenido($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				//permite crear un nuevo contenido Web al analisar que no existia ninguno
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_seccion = $_POST["clave_seccion"];
						$clave_modulo= $_POST["clave_modulo"];
						$ver_actualizacion = $_POST["ver_actualizacion"];
						$usar_caducidad = $_POST["usar_caducidad"];
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_termino = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
						$texto = $this->escapar_caracteres($_POST["texto"]);
						$situacion_temporal = $_POST["situacion_temporal"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $this->escapar_caracteres($_POST["nombre"]);
						if($correo=='')
							{$correo = $cor_user;}
						if($nombre=='')
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$situacion_gral = 'nuevo';
						$situacion_detalle = 'pendiente';
						$sql_adicional = "null, '0000-00-00','00:00:00', '', '', '','',";
						if($situacion_temporal == "activo")
							{
								$situacion_gral = "activo";
								$situacion_detalle = "activo";
								$sql_adicional = "'$nick_user', '$fecha_hoy', '$hora_hoy', '$ip', 'contenido nuevo autorizado', '$nombre', '$correo',";
							}
						$insert_texto_1 = "
						insert into nazep_zmod_contenido 
						(clave_seccion, clave_modulo, situacion, ver_actualizacion, usar_caducidad, fecha_incio, fecha_fin, user_creacion, fecha_creacion, hora_creacion, ip_creacion,
						 user_actualizacion, fecha_actualizacion, hora_actualizacion, ip_actualizacion, nombre_actualizacion, correo_actualizacion)
						values
						('$clave_seccion','$clave_modulo', '$situacion_gral', '$ver_actualizacion','$usar_caducidad', '$fecha_inicio', '$fecha_termino','$nick_user','$fecha_hoy', '$hora_hoy', '$ip',
						'$nick_user', '$fecha_hoy', '$hora_hoy', '$ip', '$nombre', '$correo')";
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insert_texto_1))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;
								$clave_contenido_db = mysql_insert_id();
								$insert_texto_cam = "insert into nazep_zmod_contenido_cambios 
								(clave_contenido, situacion, nick_user_propone, fecha_propone, hora_propone, ip_propone, 
								motivo_propone, nombre_propone, correo_propone,
								nick_user_decide, fecha_decide, hora_decide, ip_decide, motivo_decide, 
								nombre_decide, correo_decide, 
								nuevo_situacion, nuevo_ver_actualizacion, nuevo_usar_caducidad, nuevo_fecha_incio, nuevo_fecha_fin, 
								anterior_situacion,	anterior_ver_actualizacion, anterior_usar_caducidad, anterior_fecha_incio, anterior_fecha_fin)
								values
								('$clave_contenido_db', '$situacion_temporal', '$nick_user', '$fecha_hoy', '$hora_hoy', '$ip',
								'Contenido html nuevo', '$nombre', '$correo',	
								".$sql_adicional."							
								'nuevo','$ver_actualizacion','$usar_caducidad','$fecha_inicio', '$fecha_termino',
								'nuevo','$ver_actualizacion','$usar_caducidad','$fecha_inicio', '$fecha_termino')";
								if (!@mysql_query($insert_texto_cam))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}
								else
									{
										$clave_contenido_cambios_db = mysql_insert_id();
										$paso = true;	
										$insert_texto_cam = "insert into nazep_zmod_contenido_detalle
										(clave_contenido, pagina, texto, situacion) values
										('$clave_contenido_db','1','$texto','$situacion_detalle')";	
										if (!@mysql_query($insert_texto_cam))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 3;
											}
										else
											{
												$clave_contenido_detalle_db  = mysql_insert_id();
												$paso = true;
												$insert_texto_cam_1 = "insert into nazep_zmod_contenido_detalle_cambios
												(clave_contenido_cambios, clave_contenido_detalle, nuevo_pagina, nuevo_texto, nuevo_situacion, 
												anterior_pagina, anterior_texto, anterior_situacion) values
												('$clave_contenido_cambios_db', '$clave_contenido_detalle_db', '1', '$texto',
												'$situacion_detalle', '1', '$texto','$situacion_detalle')";
												
												if (!@mysql_query($insert_texto_cam_1))
													{
														$men = mysql_error();
														mysql_query("ROLLBACK;");
														$paso = false;
														$error = 4;
													}
												else
													{$paso = true;}
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
						$this->desconectarse($conexion);
					}
				else
					{
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						$clave_modulo= $_POST["clave_modulo"];
						$variable_archivos = directorio_archivos."$clave_seccion_enviada/";
						$_SESSION["direccion_archivos"] = $variable_archivos;
						HtmlAdmon::titulo_seccion(cont_txt_tit_nue_con." \"$nombre_sec\"");			
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_generar_contenido");
									});				
								function validar_form(formulario, valor_temporal, nombre_formulario)
									{	
										formulario.formulario_final.value = nombre_formulario;
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
										valor_texto = FCKeditorAPI.__Instances[\'texto\'].GetHTML();
										formulario.texto.value = valor_texto; 
										if(formulario.texto.value == "") 
											{
												alert("'.cont_js_1.'")
												location.href=\'#texto_link\';	
												return false;
											}
										formulario.btn_guardar1.style.visibility="hidden";
							';
							if($nivel == 1 or $nivel == 2)
								{
									echo 'formulario.btn_guardar2.style.visibility="hidden";';
								}
							echo '
									}
							';
						echo '</script>';
						echo '<form name="regresar_pantalla" id="regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_contenido"/>';
							echo '<input type="hidden" name="metodo" value = "modificar_contenido" />';
							echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
							echo '<input type="hidden" name="paginas_contenido" value = "1" />';
						echo '</form>';
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" /></form>';						

						echo '<form name="frm_generar_contenido" id="frm_generar_contenido" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.cont_txt_per_pro.'</td><td><input type = "text" name = "nombre" size = "60" /></td></tr>';
								echo '<tr><td>'.cont_txt_cor_pro.'</td><td><input type = "text" name = "correo" size = "60" /></td></tr>';
								echo '<tr><td>'.cont_txt_ver_fec_ac.'</td><td>';
										echo '<input type="radio" name="ver_actualizacion" id ="ver_actualizacion_si" value="SI"  /> '.si.'&nbsp;';
										echo '<input type="radio" name="ver_actualizacion" id ="ver_actualizacion_no" value="NO" checked="checked"  /> '.no.'&nbsp;';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>'.cont_txt_usar_cad_cont.'</td><td>';
										echo '<input type="radio" name="usar_caducidad" id ="usar_caducidad_si" value="SI"  /> '.si.'&nbsp;';
										echo '<input type="radio" name="usar_caducidad" id ="usar_caducidad_no" value="NO" checked="checked"  /> '.no.'&nbsp;';
									echo '</td>';
								echo '</tr>';								
								echo '<tr><td>'.fecha_ini_vig.'</td><td>';
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
												{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'.$areglo_meses[$b] .'</option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_i">';
											for ($c=$ano-10; $c<=$ano+10; $c++)
												{echo '<option value = "'.$c.'" '; if ($ano == $c) {echo ' selected="selected" ';} echo '>'.$c.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.fecha_fin_vig.'</td>';
									echo '<td>';
										echo dia.'&nbsp;<select name = "dia_t">';
										for ($a = 1; $a<=31; $a++)
											{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo '> '.$a.' </option>';}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_t">';
											for ($b=1; $b<=12; $b++)
												{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_t">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td align="center"><strong>'.cont_txt_con_html.'</strong></td></tr>';
								echo '<tr><td><a name="texto_link" id="texto_link"></a>';
										$oFCKeditor1 = new FCKeditor("texto") ;
										$oFCKeditor1->BasePath = "../librerias/fckeditor/";		
										$oFCKeditor1->ToolbarSet = "Default";
										$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
										$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
										$oFCKeditor1->Width = "100%";
										$oFCKeditor1->Height = "500";	
										$oFCKeditor1->Create();	
								echo '</td></tr>';
							echo '</table>';
							echo '<input type="hidden" name="formulario_final" value = "" />';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_contenido" />';
							echo '<input type="hidden" name="metodo" value = "crear_contenido" />';
							echo '<input type="hidden" name="guardar" value = "si" />';
							echo '<input type="hidden" name="situacion_temporal" value = "nuevo" />';
							echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
							echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align="center"><input type="submit" name="btn_guardar1" value="'.guardar.'" onclick="return validar_form(this.form,\'nuevo\',\'recargar_pantalla\')" /></td>';
									if($nivel == 1 or $nivel == 2)
										{echo '<td align="center"><input type="submit" name="btn_guardar2" value="'.guardar_puliblicar.'" onclick= "return validar_form(this.form,\'activo\', \'regresar_pantalla\')" /></td>';}
								echo '</tr>';
							echo '</table>';
						echo '</form>';	
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}				
			}
		function modificar_contenido($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				//modificar una pagina de un contenido ya creado
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_termino = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
						$situacion_total = $_POST["situacion_total"];
						$ver_actualizacion = $_POST["ver_actualizacion"];
						$usar_caducidad = $_POST["usar_caducidad"];

						$clave_seccion = $_POST["clave_seccion"];
						$clave_modulo= $_POST["clave_modulo"];
						$clave_contenido = $_POST["clave_contenido"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$motivo = $this->escapar_caracteres($_POST["motivo"]);
						$motivo = strip_tags($motivo);
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						$situacion_temporal = $_POST["situacion_temporal"];	
						if($correo=="")
							{$correo = $cor_user;}
						if($nombre=="")
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$sql_adicional = "null, '0000-00-00','00:00:00', '', '', '','',";
						if($situacion_temporal=="activo")
							{$sql_adicional = "'$nick_user', '$fecha_hoy', '$hora_hoy', '$ip', '$motivo', '$nombre', '$correo',";}
						$insert_camb = "insert into nazep_zmod_contenido_cambios 
						(clave_contenido, situacion, nick_user_propone, fecha_propone, hora_propone, ip_propone, motivo_propone,
						nombre_propone, correo_propone,
						nick_user_decide, fecha_decide, hora_decide, ip_decide, motivo_decide,
						nombre_decide, correo_decide,
						nuevo_situacion, nuevo_ver_actualizacion, nuevo_usar_caducidad, nuevo_fecha_incio, nuevo_fecha_fin, 
						anterior_situacion, anterior_ver_actualizacion, anterior_usar_caducidad, anterior_fecha_incio, anterior_fecha_fin)					
						select '$clave_contenido', '$situacion_temporal','$nick_user', '$fecha_hoy', '$hora_hoy', '$ip', '$motivo',
						'$nombre','$correo',
						".$sql_adicional."
						'$situacion_total', '$ver_actualizacion', '$usar_caducidad', '$fecha_inicio', '$fecha_termino',
						situacion, ver_actualizacion, usar_caducidad, fecha_incio, fecha_fin
						from nazep_zmod_contenido 
						where clave_contenido = '$clave_contenido'";
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insert_camb))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}	
						else
							{
								$paso = true;
								$clave_contenido_cambios_db = mysql_insert_id();
								$clave_contenido_detalle  = $_POST["clave_contenido_detalle"];
								$pagina = $_POST["pagina"];
								$texto  = $this->escapar_caracteres($_POST["conte_texto"]);
								$situacion_p = $_POST["situacion"];
								$insert_con_cam = "insert into nazep_zmod_contenido_detalle_cambios
								(clave_contenido_cambios, clave_contenido_detalle, nuevo_pagina, nuevo_texto, nuevo_situacion,
								anterior_pagina, anterior_texto, anterior_situacion)
								select '$clave_contenido_cambios_db', '$clave_contenido_detalle',
								'$pagina', '$texto', '$situacion_p', pagina, texto, situacion
								from nazep_zmod_contenido_detalle
								where clave_contenido_detalle = '$clave_contenido_detalle'";
								if (!@mysql_query($insert_con_cam))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = "2";
									}	
								else
									{$paso = true;}
								if($situacion_temporal=="activo")
									{
										$update_2 = "update nazep_zmod_contenido
										set situacion = '$situacion_total', ver_actualizacion = '$ver_actualizacion', usar_caducidad ='$usar_caducidad', 
										fecha_incio = '$fecha_inicio', fecha_fin = '$fecha_termino',
										user_actualizacion = '$nick_user', fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy',
										ip_actualizacion = '$ip', nombre_actualizacion = '$nombre', correo_actualizacion = '$correo'
										where clave_contenido = '$clave_contenido' and clave_modulo = '$clave_modulo'";
										if (!@mysql_query($update_2))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 3;
											}
										else
											{
												$paso = true;

												$clave_contenido_detalle = $_POST["clave_contenido_detalle"];
												$pagina = $_POST["pagina"];
												$situacion = $_POST["situacion"];
												$texto =  $this->escapar_caracteres($_POST["conte_texto"]);
												$update3 = "update nazep_zmod_contenido_detalle  set pagina = '$pagina', texto = '$texto', situacion = '$situacion' 
												where clave_contenido_detalle = '$clave_contenido_detalle'";
												if (!@mysql_query($update3))
													{
														$men = mysql_error();
														mysql_query("ROLLBACK;");
														$paso = false;
														$error =  "4";
													}
												else
													{$paso = true;}
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
						$this->desconectarse($conexion);
					}
				else
					{
						$paginas_contenido= $_POST["paginas_contenido"];
						$clave_modulo= $_POST["clave_modulo"];						
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion("Modificar contenido html de la secci&oacute;n \"$nombre_sec\"");
						$con_veri = "select cc.clave_contenido_cambios from nazep_zmod_contenido_cambios cc, nazep_zmod_contenido c
						where c.clave_seccion = '$clave_seccion_enviada' and c.clave_modulo = '$clave_modulo' and 
						(cc.situacion = 'pendiente' or cc.situacion = 'nueva_pagina'  or cc.situacion = 'nuevo')
						and c.clave_contenido = cc.clave_contenido";
						$conexion = $this->conectarse();
						$res = mysql_query($con_veri);
						$cantidad = mysql_num_rows($res);
						$this->desconectarse($conexion);
						if($cantidad!=0)
							{
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align="center"><br /><strong>'.cont_txt_tiene_cambio_pen.'</strong><br /><br /></td></tr>';
								echo '</table>';
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));								
							}
						else
							{
								$variable_archivos = directorio_archivos."$clave_seccion_enviada/";
								$_SESSION["direccion_archivos"] = $variable_archivos;	
								$con_contenido = "select fecha_incio, fecha_fin, situacion, ver_actualizacion, usar_caducidad, clave_contenido 
								from nazep_zmod_contenido where clave_seccion = '$clave_seccion_enviada' and clave_modulo = '$clave_modulo'";
								$conexion = $this->conectarse();
								$res_contenido  = mysql_query($con_contenido);
								$ren = mysql_fetch_array($res_contenido);
								$fecha_incio = $ren["fecha_incio"];
								list($ano_i, $mes_i, $dia_i) = explode("-",$fecha_incio);
								$fecha_fin = $ren["fecha_fin"];
								list($ano_t, $mes_t, $dia_t) = explode("-",$fecha_fin);
								$situacion_total = $ren["situacion"];
								$ver_actualizacion = $ren["ver_actualizacion"];
								$usar_caducidad  = $ren["usar_caducidad"];
								$clave_contenido =  $ren["clave_contenido"];								
								echo '
								<script type="text/javascript">
								';
								echo'
								$(document).ready(function()
										{
											$.frm_elem_color("#FACA70","");
											$.guardar_valores("frm_modificar_contenido");
										});
									function validar_form(formulario, situacion_temporal, nombre_formulario)
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
											valorTemporal = FCKeditorAPI.__Instances[\'conte_texto\'].GetHTML();
											formulario.conte_texto.value = valorTemporal;
											formulario.btn_guardar1.style.visibility="hidden";
											formulario.btn_guardar1a.style.visibility="hidden";
											document.crear_nueva_pagina.btn_nueva_pagina.style.visibility="hidden";
				
								';
									if($nivel == 1 or $nivel == 2)
										{
											echo 'formulario.btn_guardar2.style.visibility="hidden";
											formulario.btn_guardar2a.style.visibility="hidden";';
										}
								echo '
											formulario.formulario_final.value = nombre_formulario;
										}
								';
								echo '</script>';
								echo '<form name="regresar_pantalla" id="regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_contenido"/>';
									echo '<input type="hidden" name="metodo" value = "modificar_contenido" />';
									echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
									echo '<input type="hidden" name="paginas_contenido" value = "'.$paginas_contenido.'" />';
								echo '</form>';	
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" /></form>';
								
								echo '<form name="frm_modificar_contenido" id="frm_modificar_contenido" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero"  >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td width="400">'.persona_cambio.'</td><td><input type ="text" name = "nombre" size = "60" /></td></tr>';
										echo '<tr><td>'.correo_cambio.'</td><td><input type = "text" name = "correo" size = "60" /></td></tr>';
										echo '<tr><td>'.motivo_cambio.'</td><td><textarea name="motivo" cols="45" rows="5"></textarea></td></tr>';
										echo '<tr><td>'.situacion.'</td><td>';
												echo '<input type="radio" name="situacion_total" id ="situacion_act" value="activo"  '; if ($situacion_total == "activo") { echo 'checked="checked"'; } echo '/> '.activo.'&nbsp;';
												echo '<input type="radio" name="situacion_total" id ="situacion_no" value="cancelado"   '; if ($situacion_total == "cancelado") { echo 'checked="checked"'; } echo '/> '.cancelado.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.cont_txt_ver_fec_ac.'</td><td>';
												echo '<input type="radio" name="ver_actualizacion" id ="ver_actualizacion_si" value="SI"  '; if ($ver_actualizacion == "SI") { echo 'checked="checked"'; } echo '/> '.si.'&nbsp;';
												echo '<input type="radio" name="ver_actualizacion" id ="ver_actualizacion_no" value="NO"   '; if ($ver_actualizacion == "NO") { echo 'checked="checked"'; } echo '/> '.no.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.cont_txt_usar_cad_cont.'</td><td>';
												echo '<input type="radio" name="usar_caducidad" id ="usar_caducidad_si" value="SI"  '; if ($usar_caducidad == "SI") { echo 'checked="checked"'; } echo ' /> '.si.'&nbsp;';
												echo '<input type="radio" name="usar_caducidad" id ="usar_caducidad_no" value="NO"  '; if ($usar_caducidad == "NO") { echo 'checked="checked"'; } echo ' /> '.no.'&nbsp;';										
											echo '</td>';
										echo '</tr>';										
										echo '<tr><td>'.fecha_ini_vig.'</td>';
											echo '<td>';
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name = "dia_i">';
												for ($a = 1; $a<=31; $a++)
													{ echo '<option value = "'.$a.'" '; if ($dia_i == $a) { echo 'selected="selected"'; } echo ' >'.$a.'</option>'; }
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_i">';
												for ($b=1; $b<=12; $b++)
													{ echo '<option value = "'.$b.'"  '; if ($mes_i == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>'; }
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_i">';
												for ($c=$ano_i-10; $c<=$ano_i+10; $c++)
													{ echo '<option value = "'.$c.'" '; if ($ano_i == $c) {echo ' selected="selected" ';} echo '>'.$c.'</option>'; }
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fecha_fin_vig.'</td>';
											echo '<td>';
												echo dia.'&nbsp;<select name = "dia_t">';
												for ($a = 1; $a<=31; $a++)
													{ echo '<option value = "'.$a.'" '; if ($dia_t == $a) { echo 'selected'; } echo '>'.$a.'</option>'; }
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_t">';
												for ($b=1; $b<=12; $b++)
													{ echo '<option value = "'.$b.'"  '; if ($mes_t == $b) {echo 'selected ';} echo '>'.$areglo_meses[$b].'</option>'; }
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_t">';
												for ($c=$ano_t-10; $c<=$ano_t+10; $c++)
													{echo '<option value = "'.$c.'" '; if ($ano_t == $c) {echo ' selected ';} echo '>'.$c.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="submit" name="btn_guardar1a" value="'.guardar.'" onclick= "return validar_form(this.form,\'pendiente\', \'recargar_pantalla\')" />';
											echo '</td>';
											if($nivel == 1 or $nivel == 2)
												{echo '<td align="center"><input type="submit" name="btn_guardar2a" value="'.guardar_puliblicar.'" onclick= "return validar_form(this.form,\'activo\', \'regresar_pantalla\')" /></td>';}
										echo '</tr>';
									echo '</table><br/>';									
									$cons_con_detalle = "select clave_contenido_detalle, pagina, texto, situacion from nazep_zmod_contenido_detalle
									where clave_contenido = '$clave_contenido' and pagina ='$paginas_contenido' ";
									$res = mysql_query($cons_con_detalle);
									$con = 1;
									$ren = mysql_fetch_array($res);
										
									$pagina = $ren["pagina"];
									$texto = stripslashes($ren["texto"]);
									$clave_contenido_detalle_base =  $ren["clave_contenido_detalle"];
									$situacion_texto = $ren["situacion"];
									echo '<input type="hidden" name="clave_contenido_detalle" value = "'.$clave_contenido_detalle_base.'" />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td align="center"><strong>'.cont_txt_con_html_pag.' '.$pagina.'</strong></td></tr>';
										echo '<tr><td width="377">'.cont_txt_num_pag.' '.$pagina.'<input type = "hidden" name = "pagina" size = "5" value ="'.$pagina.'" /></td></tr>';
										echo '<tr><td align="center">'.cont_txt_sit_pag.' '.$pagina.'&nbsp;&nbsp;';
												echo '<input type="radio" name="situacion" id ="situacion_act" value="activo"  '; if ($situacion_texto == "activo") { echo 'checked="checked"'; } echo '/> '.activo.'&nbsp;';
												echo '<input type="radio" name="situacion" id ="situacion_no" value="cancelado"   '; if ($situacion_texto == "cancelado") { echo 'checked="checked"'; } echo '/> '.cancelado.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td><a name="texto_link" id="texto_link"></a>';
											$texto = ($texto!='')?$texto:'&nbsp;'; 
											$oFCKeditor[$con] = new FCKeditor("conte_texto");
											$oFCKeditor[$con]->BasePath = '../librerias/fckeditor/';		
											$oFCKeditor[$con]->Value = $texto;
											$oFCKeditor[$con]->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
											$oFCKeditor[$con]->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
											$oFCKeditor[$con]->Width = "100%";
											$oFCKeditor[$con]->Height = "500";
											$oFCKeditor[$con]->Create();
										echo '</td></tr>';
									echo '</table>';
									echo '<input type="hidden" name="formulario_final" value = "" />';
									echo '<input type="hidden" name="clave_contenido" value = "'.$clave_contenido.'" />';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_contenido" />';
									echo '<input type="hidden" name="metodo" value = "modificar_contenido" />';
									echo '<input type="hidden" name="guardar" value = "si" />';
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
									echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
									echo '<input type="hidden" name="situacion_temporal" value = "pendiente" />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="submit" name="btn_guardar1" value="'.guardar.'" onclick= "return validar_form(this.form,\'pendiente\', \'recargar_pantalla\')" />';
											echo '</td>';
											if($nivel == 1 or $nivel == 2)
												{echo '<td align="center"><input type="submit" name="btn_guardar2" value="'.guardar_puliblicar.'" onclick= "return validar_form(this.form,\'activo\', \'regresar_pantalla\')" /></td>';}
										echo '</tr>';
									echo '</table>';
								echo '</form>';
									echo '<hr />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<form id="crear_nueva_pagina"  name="crear_nueva_pagina" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
													echo '<input type="hidden" name="archivo" value ="../librerias/modulos/contenido/contenido_admon.php" />';
													echo '<input type="hidden" name="clase" value = "clase_contenido" />';
													echo '<input type="hidden" name="metodo" value = "nueva_pagina" />';
													echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
													echo '<input type="hidden" name="paginas_contenido" value = "'.$paginas_contenido.'" />';
													echo '<input type="submit" name="btn_nueva_pagina" value="'.cont_btn_7_cre_pag.'" />';
												echo '</form>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								HtmlAdmon::div_res_oper(array());
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));								
								$this->desconectarse($conexion);
							}
					}
			}
		function nueva_pagina($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{	
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_contenido = $_POST["clave_contenido"];
						$clave_seccion = $_POST["clave_seccion"];
						$clave_modulo = $_POST["clave_modulo"];
						//$situacion = $_POST["situacion"];
						$texto = $this->escapar_caracteres($_POST["texto"]);
						$situacion_pagina = $_POST["situacion_pagina"];
						//echo "*******$situacion_pagina";
						
						$situacion_contenido = $_POST["situacion_contenido"];
						$fecha_incio = $_POST["fecha_incio"];
						$fecha_fin = $_POST["fecha_fin"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$motivo = $this->escapar_caracteres($_POST["motivo"]); 
						$motivo = strip_tags($motivo);
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=="")
							{$correo = $cor_user;}
						if($nombre=="")
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$sql_adicional = "null, '0000-00-00','00:00:00', '', '', '','',";	
						//$situacion_detalle = "pendiente";
						if($situacion_pagina=="activo")
							{
								$sql_adicional = "'$nick_user', '$fecha_hoy', '$hora_hoy', '$ip', '$motivo', '$nombre', '$correo',";
								$situacion_detalle = "activo";
							}
						$insertar_cam = "insert into nazep_zmod_contenido_cambios
						(clave_contenido, situacion, nick_user_propone, fecha_propone, hora_propone, ip_propone,
						motivo_propone, nombre_propone, correo_propone,
						nick_user_decide, fecha_decide, hora_decide, ip_decide, motivo_decide,
						nombre_decide, correo_decide,
						nuevo_situacion, nuevo_fecha_incio, nuevo_fecha_fin, anterior_situacion, anterior_fecha_incio, 
						anterior_fecha_fin)
						values
						('$clave_contenido', '$situacion_pagina', '$nick_user','$fecha_hoy', '$hora_hoy', '$ip',
						'Creaci&oacute;n de nueva p&aacute;gina: $motivo', '$nombre', '$correo',
						".$sql_adicional."
						'$situacion_contenido', '$fecha_incio', '$fecha_fin', '$situacion_contenido', '$fecha_incio',
						'$fecha_fin')";
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insertar_cam))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}	
						else
							{
								$con_pag = "select pagina  from nazep_zmod_contenido_detalle where clave_contenido = '$clave_contenido'";
								$res_pag = mysql_query($con_pag);
								$can_pag = mysql_num_rows($res_pag);
								$can_pag++;
								
								$paso = true;
								$clave_contenido_cambios_db = mysql_insert_id();
								$insert_con_de = "insert into nazep_zmod_contenido_detalle 
								(clave_contenido, pagina, texto, situacion) 
								values ('$clave_contenido', '$can_pag', '$texto', '$situacion_pagina')";	
								if (!@mysql_query($insert_con_de))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}	
								else
									{
										$paso = true;
										$clave_contenido_detalle_db = mysql_insert_id();
										$insert_con_de_ca = "insert into nazep_zmod_contenido_detalle_cambios
										(clave_contenido_cambios, clave_contenido_detalle,
										 nuevo_pagina, nuevo_texto,nuevo_situacion,
										 anterior_pagina, anterior_texto, anterior_situacion)
										values
										('$clave_contenido_detalle_db', '$clave_contenido_detalle_db',
										'$can_pag','$texto','$situacion_pagina',
										'$can_pag','$texto','$situacion_pagina')";
										if (!@mysql_query($insert_con_de_ca))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 3;
											}	
										else
											{$paso = true;}
									}
							}
						if($paso)
							{
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";	
							}
						else
							{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
						  
						 
					}
				else
					{
						$paginas_contenido= $_POST["paginas_contenido"];	
						$clave_modulo= $_POST["clave_modulo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion("Crear nueva p&aacute;gina");
						$con_veri = "select cc.clave_contenido_cambios, cc.situacion, c.clave_seccion, cc.clave_contenido
						from nazep_zmod_contenido_cambios cc, nazep_zmod_contenido c where c.clave_contenido = cc.clave_contenido
						and(cc.situacion = 'pendiente' or cc.situacion = 'nueva_pagina' or cc.situacion = 'nuevo')
						and c.clave_seccion = '$clave_seccion_enviada' and c.clave_modulo = '$clave_modulo'";
						$conexion = $this->conectarse();
						$res = mysql_query($con_veri);
						$cantidad = mysql_num_rows($res);
						if($cantidad!=0)
							{
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align = "center"><br /><strong>'.cont_txt_tiene_pag_pen.'</strong><br /><br /></td></tr>';
								echo '</table>';
								HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>cont_txt_reg_cont,
																'OpcOcultas'=>array(
																					'archivo'=>'../librerias/modulos/contenido/contenido_admon.php',
																					'clase'=>'clase_contenido',
																					'metodo'=>'modificar_contenido',
																					'clave_modulo'=>$clave_modulo
																					)));
							}
						else
							{
								$consulta_clave = "select clave_contenido, situacion, fecha_incio, fecha_fin  
								from nazep_zmod_contenido where clave_seccion = '$clave_seccion_enviada' and clave_modulo = '$clave_modulo'";
								$res_con_dos = mysql_query($consulta_clave);
								$ren_clave = mysql_fetch_array($res_con_dos);
								$clave_contenido = $ren_clave["clave_contenido"];	
								$situacion = $ren_clave["situacion"];
								$fecha_incio = $ren_clave["fecha_incio"];
								$fecha_fin	 = $ren_clave["fecha_fin"];
								echo '<script type="text/javascript">';
								echo ' $(document).ready(function()
										{									
											$.frm_elem_color("#FACA70","");
											$.guardar_valores("frm_nueva_pagina");
										});								
									function validar_form(formulario, situacion_temporal, opcion, nombre_formulario)
										{
											formulario.situacion_pagina.value = situacion_temporal;
											
											valor_pag = FCKeditorAPI.__Instances[\'texto\'].GetHTML();
											formulario.texto.value = valor_pag;
																						
											if(formulario.motivo.value == "") 
												{
													alert("'.jv_campo_motivo.'");
													formulario.motivo.focus(); 	
													return false;
												}
											if(opcion=="regresar")
												{
													document.regresar_pantalla.metodo.value="nueva_pagina";
												}
											formulario.btn_guardar1.style.visibility="hidden";
								';
								if($nivel == 1 or $nivel == 2)
									{
											echo '
											formulario.btn_guardar2.style.visibility="hidden";
											formulario.btn_guardar3.style.visibility="hidden";';
									}
								echo '
											formulario.formulario_final.value = nombre_formulario;
										}';
								echo '</script>';	
								echo '<form name="regresar_pantalla" id="regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_contenido"/>';
									echo '<input type="hidden" name="metodo" value = "modificar_contenido" />';
									echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
									echo '<input type="hidden" name="paginas_contenido" value = "'.$paginas_contenido.'" />';
								echo '</form>';	
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero"><input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" /></form>';
								echo '<form name="frm_nueva_pagina" id="frm_nueva_pagina" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="formulario_final" value = "" />';
									echo '<input type="hidden" name="clave_contenido" value = "'.$clave_contenido.'" />';
									echo '<input type="hidden" name="situacion_contenido" value = "'.$situacion.'" />';
									echo '<input type="hidden" name="fecha_incio" value = "'.$fecha_incio.'" />';
									echo '<input type="hidden" name="fecha_fin" value = "'.$fecha_fin.'" />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>'.cont_txt_per_pro_pag.'</td><td><input type="text" name ="nombre" size="60" /></td></tr>';
										echo '<tr><td>'.cont_txt_cor_pro.'</td><td><input type ="text" name ="correo" size ="60" /></td></tr>';
										echo '<tr><td>'.cont_txt_mot_pro_pag.'</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td>';
												echo '<a name="texto_link" id="texto_link"></a>';
												$oFCKeditor1 = new FCKeditor("texto") ;
												$oFCKeditor1->BasePath = "../librerias/fckeditor/";		
												$oFCKeditor1->ToolbarSet = "Default";
												$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
												$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
												$oFCKeditor1->Width = "100%";
												$oFCKeditor1->Height = "500";
												$oFCKeditor1->Create();	
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_contenido" />';
									echo '<input type="hidden" name="metodo" value = "nueva_pagina" />';
									echo '<input type="hidden" name="guardar" value = "si" />';
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
									echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
									echo '<input type="hidden" name="situacion_pagina" value = "nueva_pagina" />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center"><input type="submit" name="btn_guardar1" value="'.guardar.'" onclick= "return validar_form(this.form,\'nueva_pagina\',\'salir\', \'recargar_pantalla\')" /></td>';
											if($nivel == 1 or $nivel == 2)
												{echo '<td align="center"><input type="submit" name="btn_guardar2" value="'.guardar_puliblicar.'" onclick= "return validar_form(this.form,\'activo\',\'salir\', \'regresar_pantalla\')" /></td>';}
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											if($nivel == 1 or $nivel == 2)
												{echo '<td align="center"><input type="submit" name="btn_guardar3" value="'.guardar_pub_otro.'" onclick= "return validar_form(this.form,\'activo\',\'regresar\', \'regresar_pantalla\')" /></td>';}
										echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','opc_regreso'=>'metodo','clave_usar'=>$clave_seccion_enviada,'texto'=>cont_txt_reg_cont,
																'OpcOcultas'=>array(
																					'archivo'=>'../librerias/modulos/contenido/contenido_admon.php',
																					'clase'=>'clase_contenido',
																					'metodo'=>'modificar_contenido',
																					'clave_modulo'=>$clave_modulo,
																					'paginas_contenido'=>$paginas_contenido
																					)));
							}
					}
			}
// ------------------------------ Fin de funciones para controlar la modificaci�n de la informaci�n del m�dulo
// ------------------------------ Inicio de funciones para controlar los cambios de la informaci�n del m�dulo			
		function contenido_nuevo_pendiente($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$publicar = $_POST["publicar"];
						$motivo = $this->escapar_caracteres($_POST["motivo"]);
						$motivo = strip_tags($motivo);
						$clave_seccion = $_POST["clave_seccion"];
						$clave_contenido = $_POST["clave_contenido"];
						$clave_contenido_cambios = $_POST["clave_contenido_cambios"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=='')
							{$correo = $cor_user;}
						if($nombre=='')
							{$nombre = $nom_user;}	
						$nombre = strip_tags($nombre);
						$conexion = $this->conectarse();
						$update1 = "update nazep_zmod_contenido set situacion = '$publicar', user_actualizacion = '$nick_user',
						fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy', ip_actualizacion = '$ip',
						nombre_actualizacion = '$nombre', correo_actualizacion = '$correo'where clave_contenido = '$clave_contenido';";
						$update2 = 
						"update nazep_zmod_contenido_detalle set situacion = '$publicar'where clave_contenido = '$clave_contenido'; ";
						$update3 ="update nazep_zmod_contenido_cambios set nick_user_decide = '$nick_user', fecha_decide = '$fecha_hoy',
						hora_decide = '$hora_hoy', ip_decide = '$ip', situacion = '$publicar', motivo_decide = '$motivo', 
						nombre_decide = '$nombre', correo_decide = '$correo' where clave_contenido_cambios = '$clave_contenido_cambios';";
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
									{
										$paso = true;
										if (!@mysql_query($update3))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 3;
											}
										else
											{$paso = true;}
									}
							}
						if($paso)
							{
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";
							}
						else
							{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
						$this->desconectarse($conexion);
					}
				else
					{
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						$clave_modulo= $_POST["clave_modulo"];
						HtmlAdmon::titulo_seccion("Nuevo contenido html de la secci&oacute;n \"$nombre_sec\"");
						$cons = "select cc.nick_user_propone, cc.fecha_propone, cc.hora_propone, cc.nuevo_fecha_incio, cc.nuevo_fecha_fin,
						cd.nuevo_texto, cd.nuevo_pagina, cc.clave_contenido_cambios, c.clave_contenido, cc.nombre_propone, cc.correo_propone, cc.nuevo_situacion, c.ver_actualizacion
						from nazep_zmod_contenido c,nazep_zmod_contenido_cambios cc, nazep_zmod_contenido_detalle_cambios cd 
						where c.clave_contenido = cc.clave_contenido and cd.clave_contenido_cambios = cc.clave_contenido_cambios	and 
						c.clave_seccion = '$clave_seccion_enviada' and c.clave_modulo = '$clave_modulo' and cc.situacion = 'nuevo'";
						$conexion = $this->conectarse();
						$res_con = mysql_query($cons);
						$ren_con = mysql_fetch_array($res_con);
						$nick_user_propone = $ren_con["nick_user_propone"];
						$ver_actualizacion = $ren_con["ver_actualizacion"];
						$fecha_propone = $ren_con["fecha_propone"];
						$fecha_propone = FunGral::fechaNormal($fecha_propone);
						$hora_propone = $ren_con["hora_propone"];
						$nuevo_fecha_incio = $ren_con["nuevo_fecha_incio"];
						$nuevo_fecha_incio_larga = FunGral::fechaNormal($nuevo_fecha_incio);
						$nuevo_fecha_fin = $ren_con["nuevo_fecha_fin"];
						$nuevo_fecha_fin_larga = FunGral::fechaNormal($nuevo_fecha_fin);
						$nuevo_situacion = $ren_con["nuevo_situacion"];
						$nuevo_texto = stripslashes($ren_con["nuevo_texto"]);
						$nuevo_pagina = $ren_con["nuevo_pagina"];
						$clave_contenido_cambios = $ren_con["clave_contenido_cambios"];
						$clave_contenido = $ren_con["clave_contenido"];
						$nombre_propone = $ren_con["nombre_propone"];
						$correo_propone = $ren_con["correo_propone"];
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Usuario que propone el contenido</td><td width="480">'.$nick_user_propone.'</td></tr>';
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha en la que se propone el contenido</td><td>'.$fecha_propone.' a las '.$hora_propone.'hrs.</td></tr>';
							echo '<tr><td>Ver fecha de &uacute;ltima actualizaci&oacute;n</td><td>'.$ver_actualizacion.'</td></tr>';
							echo '<tr><td>Fecha de inicio de vigencia del contenido</td><td>'.$nuevo_fecha_incio_larga.'</td></tr>';
							echo '<tr><td>Fecha de termino de vigencia del contenido</td><td>'.$nuevo_fecha_fin_larga.'</td></tr>';
						echo '</table>';
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align = "center">Contenido propuesto para la secci&oacute;n</td></tr><tr><td>'.$nuevo_texto.'</td></tr>';
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
												alert("El campo del motivo no puede quedar vac�o");
												formulario.motivo.focus(); 	
												return false;
											}	
										formulario.btn_guardar.style.visibility="hidden";
									}';
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=12&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
						echo '</form>';	
						echo '<form name="frm_guardar_desicion" id="frm_guardar_desicion"  method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>Persona que toma la decisi&oacute;n</td><td><input type = "text" name = "nombre" size = "60" /></td></tr>';
								echo '<tr><td>Correo electr&oacute;nico del que decide</td><td><input type ="text" name ="correo" size = "60" /></td></tr>';
								echo '<tr><td>&iquest;Publicar el contenido?</td><td>';
										echo '<select name = "publicar">';
											echo '<option value = "activo">SI</option>';
											echo '<option value = "cancelado">NO</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td width="600">Motivo de la decisi&oacute;n</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
								echo '<tr><td>&nbsp;</td><td>';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contenido" />';
										echo '<input type="hidden" name="metodo" value = "contenido_nuevo_pendiente" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="hidden" name="clave_contenido" value = "'.$clave_contenido.'"/>';
										echo '<input type="hidden" name="clave_contenido_cambios" value = "'.$clave_contenido_cambios.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form><br />';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('opc_regreso'=>'cambios','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_cam));
					}
			}
		function cambios_pendientes($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$publicar = $_POST["publicar"];
						$contador =  $_POST["contador"];
						$clave_contenido_cambios = $_POST["clave_contenido_cambios"];
						$clave_contenido = $_POST["clave_contenido"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$motivo = $_POST["motivo"];	
						$motivo = strip_tags($motivo);
						$clave_seccion 	 = $_POST["clave_seccion"];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=='')
							{$correo = $cor_user;}
						if($nombre=='')
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$update_1 = "update nazep_zmod_contenido_cambios set situacion = '$publicar', nick_user_decide = '$nick_user', fecha_decide = '$fecha_hoy', 
						hora_decide = '$hora_hoy', ip_decide = '$ip', motivo_decide = '$motivo', nombre_decide = '$nombre', correo_decide = '$correo'
						where clave_contenido_cambios = '$clave_contenido_cambios'";
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
										$update_2 = "update nazep_zmod_contenido c, nazep_zmod_contenido_cambios cc
										set c.situacion = cc.nuevo_situacion, c.ver_actualizacion  = cc.nuevo_ver_actualizacion,
										c.fecha_incio = cc.nuevo_fecha_incio, c.fecha_fin = cc.nuevo_fecha_fin, c.user_actualizacion = '$nick_user',
										c.fecha_actualizacion = '$fecha_hoy', c.hora_actualizacion = '$hora_hoy', c.ip_actualizacion = '$ip',
										c.nombre_actualizacion = '$nombre', c.correo_actualizacion = '$correo' 
										where cc.clave_contenido_cambios  = '$clave_contenido_cambios' 
										and c.clave_contenido = '$clave_contenido'";
										if (!@mysql_query($update_2))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 2;
											}
										else
											{
												$paso = true;
												for($a=1;$a<=$contador;$a++)
													{
														$clave_contenido_detalle = $_POST["clave_contenido_detalle_".$a];
														$clave_contenido_detalle_cambios = $_POST["clave_contenido_detalle_cambios_".$a];
														$update3 = "update
														nazep_zmod_contenido_detalle cd, nazep_zmod_contenido_detalle_cambios  cdc
														set cd.pagina = cdc.nuevo_pagina, cd.texto = cdc.nuevo_texto, cd.situacion = cdc.nuevo_situacion
														where cd.clave_contenido_detalle = '$clave_contenido_detalle' and 
														cdc.clave_contenido_detalle_cambios = '$clave_contenido_detalle_cambios'";
														if (!@mysql_query($update3))
															{
																$men = mysql_error();
																mysql_query("ROLLBACK;");
																$paso = false;
																$error = "3_".$a;
															}
														else
															{$paso = true;}
													}
											}
									}
								if($paso)
									{
										mysql_query("COMMIT;");
										echo "termino-,*-$formulario_final";	
									}
								else
									{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
								$this->desconectarse($conexion);
							}
					}
				else
					{
						$clave_modulo= $_POST["clave_modulo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("Cambio propuesto del contenido html de la secci&oacute;n \"$nombre_sec\"");
						$cons = "select c.clave_contenido, cc.motivo_propone,cc.nick_user_propone, cc.fecha_propone, cc.hora_propone, 
						cc.nuevo_situacion, cc.nuevo_fecha_incio, cc.nuevo_fecha_fin,cc.anterior_situacion, cc.anterior_fecha_incio, cc.anterior_fecha_fin,
						cc.clave_contenido_cambios,cc.nombre_propone, cc.correo_propone,cc.nuevo_ver_actualizacion, cc.anterior_ver_actualizacion
						from nazep_zmod_contenido c,nazep_zmod_contenido_cambios cc where c.clave_contenido = cc.clave_contenido and c.clave_seccion = '$clave_seccion_enviada' and 
						c.clave_modulo = '$clave_modulo' and cc.situacion = 'pendiente'";	
						$conexion = $this->conectarse();
						$res_con = mysql_query($cons);
						$ren_con = mysql_fetch_array($res_con);
						$nick_user_propone = $ren_con["nick_user_propone"];
						$fecha_propone = $ren_con["fecha_propone"];
						$fecha_propone = FunGral::fechaNormal($fecha_propone);
						$hora_propone = $ren_con["hora_propone"];
						$motivo_proponer  = $ren_con["motivo_propone"];
						$nuevo_fecha_incio = $ren_con["nuevo_fecha_incio"];
						$nuevo_fecha_incio_exte = FunGral::fechaNormal($nuevo_fecha_incio);
						$nuevo_fecha_fin = $ren_con["nuevo_fecha_fin"];
						$nuevo_fecha_fin_exte = FunGral::fechaNormal($nuevo_fecha_fin);
						$nuevo_situacion = $ren_con["nuevo_situacion"];	
						$nuevo_ver_actualizacion = $ren_con["nuevo_ver_actualizacion"];
						$anterior_fecha_fin = $ren_con["anterior_fecha_fin"];
						$anterior_fecha_fin = FunGral::fechaNormal($anterior_fecha_fin);
						$anterior_fecha_incio = $ren_con["anterior_fecha_incio"];
						$anterior_fecha_incio = FunGral::fechaNormal($anterior_fecha_incio);
						$anterior_situacion = $ren_con["anterior_situacion"];
						$anterior_ver_actualizacion = $ren_con["anterior_ver_actualizacion"];
						$clave_contenido_cambios = $ren_con["clave_contenido_cambios"];
						$clave_contenido = $ren_con["clave_contenido"];	
						$nombre_propone = $ren_con["nombre_propone"];
						$correo_propone = $ren_con["correo_propone"];
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Usuario que propone el cambio</td><td width="400">'.$nick_user_propone.'</td></tr>';
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha en la que se propone el cambio</td><td>'.$fecha_propone.'</td></tr>';
							echo '<tr><td>Hora en la que se propone el cambio</td><td>'.$hora_propone.'</td></tr>';
							echo '<tr><td>Motivo por el se que se propone el cambio</td><td>'.$motivo_proponer.'</td></tr>';
						echo '</table>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align = "center">Cambios propuestos</td></tr>';
						echo '</table>';
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Nueva fecha de inicio de vigencia del contenido</td><td>'.$nuevo_fecha_incio_exte.'</td></tr>';
							echo '<tr><td>Nueva fecha de termino de vigencia del contenido</td><td>'.$nuevo_fecha_fin_exte.'</td></tr>';	
							echo '<tr><td>Nueva situaci&oacute;n del contenido</td><td>'.$nuevo_situacion.'</td></tr>';
							echo '<tr><td>Nuevo valor para ver fecha de &uacute;ltima actualizaci&oacute;n</td><td>'.$nuevo_ver_actualizacion.'</td></tr>';
							echo '<tr><td>Anterior fecha de inicio de vigencia del contenido</td><td>'.$anterior_fecha_incio.'</td></tr>';	
							echo '<tr><td>Anterior fecha de termino de vigencia del contenido</td><td>'.$anterior_fecha_fin.'</td></tr>';	
							echo '<tr><td>Anterior situaci&oacute;n del contenido</td><td>'.$anterior_situacion.'</td></tr>';	
							echo '<tr><td>Anterior valor para ver fecha de &uacute;ltima actualizaci&oacute;n</td><td>'.$anterior_ver_actualizacion.'</td></tr>';
						echo '</table>';
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("guardar_desicion");
									});							
								function validar_form(formulario)
									{
										if(formulario.motivo.value == "") 
											{
												alert("El campo del motivo no puede quedar vac�o");
												formulario.motivo.focus();
												return false;
											}	
										formulario.btn_guardar.style.visibility="hidden";
									}';
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=12&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero"></form>';
						echo '<form name="guardar_desicion" id="guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero"  >';
							echo '<input type="hidden" name="clave_contenido_cambios" value = "'.$clave_contenido_cambios.'" />';
							echo '<input type="hidden" name="clave_contenido" value = "'.$clave_contenido.'" />';
							$con_detalle ="select * from nazep_zmod_contenido_detalle_cambios where  clave_contenido_cambios = '$clave_contenido_cambios' order by anterior_pagina";
							$res = mysql_query($con_detalle);
							$con = 1;
							while($ren = mysql_fetch_array($res))
								{
									$clave_contenido_detalle = $ren["clave_contenido_detalle"];
									$clave_contenido_detalle_cambios = $ren["clave_contenido_detalle_cambios"];
									$nuevo_pagina = $ren["nuevo_pagina"];
									$nuevo_texto = stripslashes($ren["nuevo_texto"]);
									$nuevo_situacion = $ren["nuevo_situacion"];
									$anterior_pagina = $ren["anterior_pagina"];
									$anterior_texto = stripslashes($ren["anterior_texto"]);
									$anterior_situacion = $ren["anterior_situacion"];	
									echo '<input type="hidden" name="clave_contenido_detalle_'.$con.'" value = "'.$clave_contenido_detalle.'">';
									echo '<input type="hidden" name="clave_contenido_detalle_cambios_'.$con.'" value = "'.$clave_contenido_detalle_cambios.'">';
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>P&aacute;gina anterior</td><td  width="600">'.$anterior_pagina.'</td></tr>';
										echo '<tr><td>Situaci&oacute;n anterior</td><td>'.$anterior_situacion.'</td></tr>';
									echo '</table>';
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>Texto anterior</td></tr><tr><td>'.$anterior_texto.'</td></tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td><hr /></td></tr></table>';
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>P&aacute;gina nueva</td><td width="600">'.$nuevo_pagina.'</td></tr>';
										echo '<tr><td>Situaci&oacute;n nueva</td><td>'.$nuevo_situacion.'</td></tr>';
									echo '</table>';
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" ><tr><td>Texto nuevo</td></tr><tr><td>'.$nuevo_texto.'</td></tr></table>';
									$con++;
								}
							$con--;
							$this->desconectarse($conexion);
							echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>Persona que toma la decisi&oacute;n</td><td><input type = "text" name = "nombre" size ="60" /></td></tr>';
								echo '<tr><td>Correo electr&oacute;nico del que decide</td><td><input type = "text" name = "correo" size = "60" /></td></tr>';
								echo '<tr><td>&iquest;Aplicar el cambio?</td><td>';
										echo '<select name = "publicar">';
											echo '<option value = "activo">SI</option>';
											echo '<option value = "cancelado">NO</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td width="600">Motivo de la decisi&oacute;n</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
								echo '<tr><td>&nbsp;</td>';	
									echo '<td>';
									echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_contenido" />';
									echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
									echo '<input type="hidden" name="contador" value = "'.$con.'" />';
									echo '<input type="hidden" name="guardar" value = "si" />';
									echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form><br />';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('opc_regreso'=>'cambios','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_cam));
					}
			}
		function pagina_pendiente($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$publicar = $_POST["publicar"];
						$motivo = $_POST["motivo"];
						$motivo = strip_tags($motivo);
						$clave_seccion = $_POST["clave_seccion"];
						$clave_contenido_cambios = $_POST["clave_contenido_cambios"];
						$clave_contenido_detalle = $_POST["clave_contenido_detalle"];
						$clave_contenido_detalle_cambios =  $_POST["clave_contenido_detalle_cambios"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=='')
							{$correo = $cor_user;}
						if($nombre=='')
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$update_1 ="update  nazep_zmod_contenido_cambios set situacion = '$publicar', nick_user_decide = '$nick_user', fecha_decide = '$fecha_hoy',
						hora_decide = '$hora_hoy', ip_decide = '$ip', motivo_decide = '$motivo', nombre_decide = '$nombre', correo_decide = '$correo'
						where clave_contenido_cambios = '$clave_contenido_cambios'";
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
								$update_2 = "update nazep_zmod_contenido_detalle set  situacion = '$publicar'
								where clave_contenido_detalle = '$clave_contenido_detalle'";
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
				else
					{
						$clave_modulo= $_POST["clave_modulo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("P&aacute;gina nueva propuesta al contenido de la secci&oacute;n \"$nombre_sec\"");
						$con_pag = "select c.clave_contenido, 
						ccam.clave_contenido_cambios,  cdet.clave_contenido_detalle,
						cdcam.clave_contenido_detalle_cambios,
						cdcam.nuevo_pagina,
						cdcam.nuevo_texto,
						cdcam.nuevo_situacion,
						ccam.nick_user_propone,
						ccam.nombre_propone,
						ccam.correo_propone,
						ccam.fecha_propone,
						ccam.hora_propone,
						ccam.motivo_propone
						from
						nazep_zmod_contenido c,  
						nazep_zmod_contenido_cambios ccam,
						nazep_zmod_contenido_detalle cdet, 
						nazep_zmod_contenido_detalle_cambios cdcam
						where 
							c.clave_contenido = ccam.clave_contenido
						and c.clave_contenido = cdet.clave_contenido
						and cdet.clave_contenido_detalle = cdcam.clave_contenido_detalle 
						and cdet.situacion = 'nueva_pagina' 
						and ccam.situacion = 'nueva_pagina' 
						and c.clave_modulo = '$clave_modulo' 
						and c.clave_seccion = '$clave_seccion_enviada'";
						
						$conexion = $this->conectarse();
						$res = mysql_query($con_pag);
						$ren = mysql_fetch_array($res);
						
						$nuevo_pagina = $ren["nuevo_pagina"];
						$nuevo_texto = stripslashes($ren["nuevo_texto"]);
						$nuevo_situacion = $ren["nuevo_situacion"];
						$clave_contenido_cambios = $ren["clave_contenido_cambios"];
						$clave_contenido_detalle = $ren["clave_contenido_detalle"];
						$clave_contenido_detalle_cambios  = $ren["clave_contenido_detalle"];
						$nick_user_propone = $ren["nick_user_propone"];
						$nombre_propone = $ren["nombre_propone"];
						$correo_propone = $ren["correo_propone"];
						$fecha_propone = $ren["fecha_propone"];
						$hora_propone = $ren["hora_propone"];
						$motivo_proponer = $ren["motivo_propone"];
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Usuario que propone el cambio</td><td width="400">'.$nick_user_propone.'</td></tr>';
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha en la que se propone el cambio</td><td>'.$fecha_propone.'</td></tr>';
							echo '<tr><td>Hora en la que se propone el cambio</td><td>'.$hora_propone.'</td></tr>';
							echo '<tr><td>Motivo por el se que se propone el cambio</td><td>'.$motivo_proponer.'</td></tr>';
						echo '</table>';
						echo '<br /><br />';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>P&aacute;gina</td><td width="600">'.$nuevo_pagina.'</td></tr>';
							echo '<tr><td>Situci&oacute;n</td><td>'.$nuevo_situacion.'</td></tr>';
						echo '</table>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align = "center"><strong>Texto para la p&aacute;gina</strong></td></tr><tr><td>'.$nuevo_texto.'</td></tr>';
						echo '</table>';
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("guardar_desicion");
									});							
								function validar_form(formulario)
									{
										if(formulario.motivo.value == "") 
											{
												alert("El campo del motivo no puede quedar vac�o");
												formulario.motivo.focus();
												return false;
											}	
										formulario.btn_guardar.style.visibility="hidden";
									}';
						echo '</script>';	
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=12&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero"></form>';
						echo '<form name="guardar_desicion" id="guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>Persona que toma la decisi&oacute;n</td><td><input type = "text" name = "nombre" size = "50"  /></td></tr>';
								echo '<tr><td>Correo electr&oacute;nico del que decide</td><td><input type = "text" name = "correo" size = "60" /></td></tr>';
								echo '<tr><td>&iquest;Aceptar la nueva p&aacute;gina?</td><td>';
										echo '<select name = "publicar">';
											echo '<option value = "activo">SI</option>';
											echo '<option value = "cancelado">NO</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td width="600">Motivo de la decisi&oacute;n</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
								echo '<tr><td>&nbsp;</td><td>';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_contenido" />';
										echo '<input type="hidden" name="metodo" value = "pagina_pendiente" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_contenido_cambios" value = "'.$clave_contenido_cambios.'" />';
										echo '<input type="hidden" name="clave_contenido_detalle" value = "'.$clave_contenido_detalle.'" />';
										echo '<input type="hidden" name="clave_contenido_detalle_cambios" value = "'.$clave_contenido_detalle_cambios.'" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form><br />';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('opc_regreso'=>'cambios','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_cam));
					}
			}
		function cambios_realizados($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["clave_contenido_cambios"]) && $_POST["clave_contenido_cambios"]!="")
					{
						$clave_contenido_cambios = $_POST["clave_contenido_cambios"]; 
						$cons = "select c.clave_contenido, cc.situacion, cc.motivo_propone, cc.nombre_propone, cc.correo_propone,
						cc.nombre_propone, cc.correo_propone, cc.nick_user_propone, cc.fecha_propone, cc.hora_propone, 
						cc.nick_user_decide, cc.fecha_decide, cc.hora_decide, cc.motivo_decide, cc.nombre_decide, cc.correo_decide,
						cc.nuevo_situacion, cc.nuevo_fecha_incio, cc.nuevo_fecha_fin, cc.anterior_situacion, cc.anterior_fecha_incio, cc.anterior_fecha_fin,
						cc.clave_contenido_cambios, cc.nuevo_ver_actualizacion, cc.anterior_ver_actualizacion
						from nazep_zmod_contenido c, nazep_zmod_contenido_cambios cc
						where  c.clave_contenido = cc.clave_contenido and cc.clave_contenido_cambios = '$clave_contenido_cambios'";	
						$conexion = $this->conectarse();
						$res_con = mysql_query($cons);
						$ren_con = mysql_fetch_array($res_con);
						$nick_user_propone = $ren_con["nick_user_propone"];
						$fecha_propone = $ren_con["fecha_propone"];
						$fecha_propone = FunGral::fechaNormal($fecha_propone);
						$hora_propone = $ren_con["hora_propone"];
						$motivo_proponer  = $ren_con["motivo_propone"];
						$nick_user_decide  = $ren_con["nick_user_decide"];
						$fecha_decide  = $ren_con["fecha_decide"];
						$fecha_decide = FunGral::fechaNormal($fecha_decide);
						$hora_decide  = $ren_con["hora_decide"];
						$motivo_decide  = $ren_con["motivo_decide"];
						$nuevo_fecha_incio = $ren_con["nuevo_fecha_incio"];
						$nuevo_fecha_incio_exte = FunGral::fechaNormal($nuevo_fecha_incio);
						$nuevo_fecha_fin = $ren_con["nuevo_fecha_fin"];
						$nuevo_fecha_fin_exte = FunGral::fechaNormal($nuevo_fecha_fin);
						$nuevo_situacion = $ren_con["nuevo_situacion"];	
						$nuevo_ver_actualizacion = $ren_con["nuevo_ver_actualizacion"];
						$anterior_fecha_fin = $ren_con["anterior_fecha_fin"];
						$anterior_fecha_fin = FunGral::fechaNormal($anterior_fecha_fin);
						$anterior_fecha_incio = $ren_con["anterior_fecha_incio"];
						$anterior_fecha_incio = FunGral::fechaNormal($anterior_fecha_incio);
						$anterior_situacion = $ren_con["anterior_situacion"];
						$anterior_ver_actualizacion = $ren_con["anterior_ver_actualizacion"];
						$clave_contenido_cambios = $ren_con["clave_contenido_cambios"];
						$clave_contenido = $ren_con["clave_contenido"];	
						$situacion = $ren_con["situacion"];	
						$nombre_propone = $ren_con["nombre_propone"];
						$correo_propone = $ren_con["correo_propone"];
						$nombre_decide = $ren_con["nombre_decide"];
						$correo_decide = $ren_con["correo_decide"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion("Cambio al contenido html de la secci&oacute;n: $nombre_sec");
						echo '<br /><br /><table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Situaci&oacute;n del cambio</td><td width="400">'.$situacion.'</td></tr>';
							echo '<tr><td>Usuario que propone el cambio</td><td >'.$nick_user_propone.'</td></tr>';
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha en la que se propone el cambio</td><td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td></tr>';	
							echo '<tr><td>Motivo por el se que se propone el cambio</td><td>'.$motivo_proponer.'</td></tr>';
							echo '<tr><td>Usuario que decide</td><td>'.$nick_user_decide.'</td></tr>';
							echo '<tr><td>Nombre de persona que decide</td><td>'.$nombre_decide.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que decide</td><td>'.$correo_decide.'</td></tr>';
							echo '<tr><td>Fecha de la decisi&oacute;n</td><td>'.$fecha_decide.' a las '.$hora_decide.' hrs. </td></tr>';	
							echo '<tr><td>Motivo de la decisi&oacute;n</td><td>'.$motivo_decide.'</td></tr>';
						echo '</table>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align = "center"><br/><strong>Cambios realizados</strong><br/><br/></td></tr>';
						echo '</table>';
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Nueva fecha de inicio de vigencia del contenido</td><td>'.$nuevo_fecha_incio_exte.'</td></tr>';
							echo '<tr><td>Nueva fecha de termino de vigencia del contenido</td><td>'.$nuevo_fecha_fin_exte.'</td></tr>';
							echo '<tr><td>Nueva situaci&oacute;n del contenido</td><td>'.$nuevo_situacion.'</td></tr>';
							echo '<tr><td>Nuevo valor para Ver fecha de &uacute;ltima actualizaci&oacute;n</td><td>'.$nuevo_ver_actualizacion.'</td></tr>';
							echo '<tr><td>Anterior fecha de inicio de vigencia del contenido</td><td>'.$anterior_fecha_incio.'</td></tr>';
							echo '<tr><td>Anterior fecha de termino de vigencia del contenido</td><td>'.$anterior_fecha_fin.'</td></tr>';
							echo '<tr><td>Anterior situaci&oacute;n del contenido</td><td>'.$anterior_situacion.'</td></tr>';
							echo '<tr><td>Anterior valor para Ver fecha de &uacute;ltima actualizaci&oacute;n</td><td>'.$anterior_ver_actualizacion.'</td></tr>';
						echo '</table><br /><br />';
						$con_detalle ="select * from nazep_zmod_contenido_detalle_cambios where  clave_contenido_cambios = '$clave_contenido_cambios' order by anterior_pagina";	
						$res = mysql_query($con_detalle);
						$con = 1;
						while($ren = mysql_fetch_array($res))
							{
								$clave_contenido_detalle = $ren["clave_contenido_detalle"];
								$nuevo_pagina = $ren["nuevo_pagina"];
								$nuevo_texto = stripslashes($ren["nuevo_texto"]);
								$nuevo_situacion = $ren["nuevo_situacion"];
								$anterior_pagina = $ren["anterior_pagina"];
								$anterior_texto = stripslashes($ren["anterior_texto"]);
								$anterior_situacion = $ren["anterior_situacion"];
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align = "center"><strong>Cambios en la p&aacute;gina No.'. $con.'</strong></td></tr>';
								echo '</table>';
								echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
									echo '<tr><td><strong>N&uacute;mero de p&aacute;gina anterior</strong></td><td width="500">'.$anterior_pagina.'</td></tr>';
									echo '<tr><td><strong>Situaci&oacute;n anterior</strong></td><td>'.$anterior_situacion.'</td></tr>';
								echo '</table>';	
								echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align = "center">Texto anterior</td></tr><tr><td>'.$anterior_texto.'</td></tr>';	
								echo '</table>';
								echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
									echo '<tr><td><strong>N&uacute;mero de p&aacute;gina Nueva</strong></td><td width="500">'.$nuevo_pagina.'</td></tr>';
									echo '<tr><td><strong>Situaci&oacute;n nueva</strong></td><td>'.$nuevo_situacion.'</td></tr>';
								echo '</table>';	
								echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align = "center"><strong>Texto nuevo</strong></td></tr><tr><td>'.$nuevo_texto.'</td></tr>';	
								echo '</table>';
								$con++;	
								echo'<br /><br />';
							}
						HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>cont_txt_reg_list_cam,
							'OpcOcultas'=>array(
								'archivo'=>$this->DirArchivo,
								'clase'=>$this->NomClase,
								'metodo'=>'cambios_realizados',
								'clave_seccion'=>$clave_seccion_enviada,
								'nombre_sec'=>$nombre_sec)));
					}
				else
					{
						$con_cam_con = "select cc.clave_contenido_cambios from nazep_zmod_contenido_cambios cc, nazep_zmod_contenido c where c.clave_contenido = cc.clave_contenido and clave_seccion = '$clave_seccion_enviada' ";	
						$conexion = $this->conectarse();
						$res_cam_con = mysql_query($con_cam_con);
						$cantidad_con = mysql_num_rows($res_cam_con);
						$cantidad_mostrar = 10;
						$pos_pag = (isset($_POST["pag"])) ?$_POST["pag"]:''; 
						if($pos_pag =='')
							{
								$pag = 1;
								$ini = 0;
							}
						else
							{
								$pag = $_POST["pag"];
								$ini = ($pag-1)*$cantidad_mostrar;
							}
						$total_paginas = ceil($cantidad_con/$cantidad_mostrar);
						$con_cam_con_total = "select cc.clave_contenido_cambios,  cc.fecha_propone, cc.hora_propone, cc.fecha_decide, cc.hora_decide, cc.situacion 
						from nazep_zmod_contenido_cambios cc, nazep_zmod_contenido c where c.clave_contenido = cc.clave_contenido and clave_seccion = '$clave_seccion_enviada' limit $ini, $cantidad_mostrar";	
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("($cantidad_con) Cambios realizados al contenido html de la secci&oacute;n: $nombre_sec");
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';	
								echo '<td align = "center"><strong>Fecha del cambio</strong></td>';
								echo '<td align = "center"><strong>Fecha de la decisi&oacute;n</strong></td>';
								echo '<td align = "center"><strong>Situaci&oacute;n del cambio</strong></td>';
								echo '<td align = "center"><strong>Ver cambio</strong></td>';
							echo '</tr>';
						$res_con_cam_t = mysql_query($con_cam_con_total);
						$contador = 0;
						while($ren_cam_t = mysql_fetch_array($res_con_cam_t))
							{
								if(($contador%2)==0)
									{$color = 'bgcolor="#F9D07B"';}
								else
									{$color = '';}
								$clave_contenido_cambios = $ren_cam_t["clave_contenido_cambios"];
								$fecha_propone = $ren_cam_t["fecha_propone"];
								$fecha_propone = FunGral::fechaNormal($fecha_propone);
								$hora_propone = $ren_cam_t["hora_propone"];
								$fecha_decide = $ren_cam_t["fecha_decide"];
								$fecha_decide = FunGral::fechaNormal($fecha_decide);
								$hora_decide = $ren_cam_t["hora_decide"];
								$situacion = $ren_cam_t["situacion"];
								echo '<tr>';	
									echo '<td '.$color.'>'.$fecha_propone .'<br /> a las '.$hora_propone.'</td>';
									echo '<td  '.$color.'>'.$fecha_decide.'<br /> a las '.$hora_decide.'</td>';
									echo '<td align ="center"  '.$color.'>'.$situacion.'</td>';
									echo '<td align = "center"  '.$color.'>';
										echo '<form name="ver_cambio_'.$clave_contenido_cambios.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_contenido" />';
											echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
											echo '<input type="hidden" name="nombre_sec" value = "'.$nombre_sec.'" />';
											echo '<input type="hidden" name="clave_contenido_cambios" value = "'.$clave_contenido_cambios.'" />';
											echo '<input type="submit" name="Submit" value="Ver cambio" />';
										echo '</form>';
									echo '</td>';
								echo '</tr>';
								$contador++;
							}
						echo '</table>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align = "center">';
								if($total_paginas >1)
									{
										for($a=1;$a<=$total_paginas;$a++)
											{
												echo '<form name="pag_con_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
													echo '<input type="hidden" name="archivo" value = "../librerias/modulos/contenido/contenido_admon.php" />';
													echo '<input type="hidden" name="clase" value = "clase_contenido" />';
													echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
													echo '<input type="hidden" name="nombre_sec" value = "'.$nombre_sec.'" />';
													echo '<input type="hidden" name="pag" value = "'.$a.'" />';
												echo '</form>';
											}
									}
							echo '</td></tr><tr><td align = "center">';		
								if($total_paginas >1)
									{
										for($a=1;$a<=$total_paginas;$a++)
											{
												if($pag == $a)
													{echo '<strong>'.$a.'</strong>';}
												else
													{echo '<a href="javascript:document.pag_con_'.$a.'.submit()">'.$a.'</a>';}
											}
									}
							echo '</td></tr>';
						echo '</table>';
						HtmlAdmon::boton_regreso(array('opc_regreso'=>'cambios','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_cam));
					}
			}
// ------------------------------ Fin de funciones para controlar los cambios de la informaci�n del m�dulo
	}
?>