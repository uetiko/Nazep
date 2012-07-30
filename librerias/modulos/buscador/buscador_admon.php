<?php
/*
Sistema: Nazep
Nombre archivo: buscador_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de buscador
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Diciembre 2009
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_buscador extends conexion
	{
		private $DirArchivo = '../librerias/modulos/buscador/buscador_admon.php';
		private $NomClase = 'clase_buscador';
		function __construct()
			{
				include('../librerias/idiomas/'.FunGral::SaberIdioma().'/buscador.php');
			}		
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo	
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{
						HtmlAdmon::AccesoMetodo(array(
							'ClaveSeccion'=>$clave_seccion_enviada,
							'name'=>'frm_nuevo_reg_buscador',
							'Id'=>'frm_nuevo_reg_buscador',
							'BText'=>'Registrar un nuevo m&oacute;dulo para el buscador',
							'BName'=>'btn_nuevo_reg_buscador',
							'BId'=>'btn_nuevo_reg_buscador',
							'OpcOcultas' => array( 'archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase, 'metodo' =>'nuevo') ));	

						HtmlAdmon::AccesoMetodo(array(
							'ClaveSeccion'=>$clave_seccion_enviada,
							'name'=>'frm_modificar_reg_buscador',
							'Id'=>'frm_modificar_reg_buscador',
							'BText'=>'Modificar un registro de un m&oacute;dulo del buscador',
							'BName'=>'btn_modificar_reg_buscador',
							'BId'=>'btn_modificar_reg_buscador',
							'OpcOcultas' => array('archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase, 'metodo' =>'modificar') ));	
					}
				else
					{ echo '<br />El m&oacute;dulo no se encuentra Activo <br /> por lo que no se puede modificar o generar nuevos registros al buscador<br /><br />';}
			}		
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{	
						if($nivel==1 or $nivel==2)
							{
								$con_sit_1 = "select clave_buscador from nazep_zmod_buscador where situacion = 'nuevo'";
								$conexion = $this->conectarse();
								$res_sit_1 = mysql_query($con_sit_1);
								$cantidad = mysql_num_rows($res_sit_1);
								if($cantidad!=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_nuevos_pendientes',
											'Id'=>'frm_nuevos_pendientes',
											'BText'=>'M&oacute;dulos nuevos pendientes de autorizar',
											'BName'=>'btn_nuevos_pendientes',
											'BId'=>'btn_nuevos_pendientes',
											'OpcOcultas' => array('archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase, 'metodo' =>'nuevo_pendiente') ));	
									}
								$con_sit_2 = "select b.clave_buscador from nazep_zmod_buscador b, nazep_zmod_buscador_cambios bc where bc.situacion = 'pendiente' and b.clave_buscador = bc.clave_buscador ";
								$res_sit_2 = mysql_query($con_sit_2);
								$cantidad_2 = mysql_num_rows($res_sit_2);
								if($cantidad_2 !=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_cambios_pendientes',
											'Id'=>'frm_cambios_pendientes',
											'BText'=>'Cambios pendientes a autorizar',
											'BName'=>'btn_cambios_pendientes',
											'BId'=>'btn_cambios_pendientes',
											'OpcOcultas' => array('archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase, 'metodo' =>'cambios_pendientes') ));
									}
							}
						$conexion = $this->conectarse();
						$con_sit_3 =  " select bc.clave_buscador from nazep_zmod_buscador b, nazep_zmod_buscador_cambios bc where b.clave_buscador = bc.clave_buscador";	
						$res_sit_3 = mysql_query($con_sit_3);
						$cantidad_3 = mysql_num_rows($res_sit_3);
						$this->desconectarse($conexion);
						if($cantidad_3 !=0)
							{
								HtmlAdmon::AccesoMetodo(array(
									'ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'frm_cambios_realizados',
									'Id'=>'frm_cambios_realizados',
									'BText'=>'Cambios realizados',
									'BName'=>'btn_cambios_realizados',
									'BId'=>'btn_cambios_realizados',
									'OpcOcultas' => array('archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase, 'metodo' =>'cambios_realizados') ));
							}
					}
				else
					{echo '<br />El m&oacute;dulo no se encuentra Activo <br /> por lo que no se puede ver los cambios';}
					
			}		
// ------------------------------ Fin de funciones para controlar las funciones del m�dulo

// ------------------------------ Inicio de funciones para controlar la modificaci�n de la informaci�n del m�dulo				
		function nuevo($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$clave_seccion = $_POST["clave_seccion"];
						$clave_modulo = $_POST["clave_modulo"];
						$situacion_temporal = $_POST["situacion_temporal"];
						
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_fin = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=="")
							{$correo = $cor_user;}
						if($nombre=="")
							{$nombre = $nom_user;}
						$situacion_gral = "nuevo";
						$sql_adicional = "null, '', '0000-00-00','00:00:00',";
						if($situacion_temporal == "activo")
							{
								$situacion_gral = "activo";
								$sql_adicional = "'$nick_user', '$ip', '$fecha_hoy', '$hora_hoy', ";
							}
						$ins_buscador ="insert into nazep_zmod_buscador
						(situacion, fecha_inicio, fecha_fin, 
						user_creacion, ip_creacion, fecha_creacion, hora_creacion, 
						user_actualizacion, ip_actualizacion, fecha_actualizacion,  hora_actualizacion,
						clave_modulo)
						values('$situacion_gral', '$fecha_inicio', '$fecha_fin', '$nick_user', '$ip', '$fecha_hoy', '$hora_hoy',
						".$sql_adicional."  '$clave_modulo')";
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($ins_buscador))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;
								$clave_buscador_db = mysql_insert_id();
								$sql_adicional .= "'Nuevo m�dulo', '$nombre', '$correo', ";
								$insertar_buscador_cambio = "insert into nazep_zmod_buscador_cambios
								(clave_buscador, situacion, nick_user_propone, ip_propone, fecha_propone, hora_propone,
								motivo_propone, nombre_propone, correo_propone,
								nick_user_decide, ip_decide, fecha_decide, hora_decide, motivo_decide, nombre_decide, correo_decide,
								nuevo_situacion, nuevo_fecha_inicio, nuevo_fecha_fin, 
								anterior_situacion, anterior_fecha_inicio, anterior_fecha_fin)
								values('$clave_buscador_db', '$situacion_gral', '$nick_user', '$ip', '$fecha_hoy', '$hora_hoy', 
								'M&oacute;dulo nuevo', '$nombre', '$correo',
								".$sql_adicional."								
								'nuevo', '$fecha_inicio', '$fecha_fin',
								'nuevo', '$fecha_inicio', '$fecha_fin')";	
								
								if (!@mysql_query($insertar_buscador_cambio))							
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
								header("Location:  index.php?opc=11&clave_seccion=$clave_seccion");	
							}
						else
							{
								header("Location:  index.php?opc=4&tipo=1&men=$error&erro=$men");
							}
						$this->desconectarse($conexion);												
					}
				else
					{
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion("Ingresar un m&oacute;dulo al buscador");
						echo '<script type="text/javascript">';
						echo "function validar_form(formulario, valor_temporal)
									{			
										formulario.situacion_temporal.value = valor_temporal;	
										separador = \"/\";		
										fecha_ini = formulario.dia_i.value+\"/\"+formulario.mes_i.value+\"/\"+formulario.ano_i.value;
										fecha_fin = formulario.dia_t.value+\"/\"+formulario.mes_t.value+\"/\"+formulario.ano_t.value;
										if(!Comparar_Fecha(fecha_ini, fecha_fin))
											{
												alert(\"".comparar_fecha_veri."\");
												formulario.dia_i.focus(); 
												return false
											}												
										if(!verificar_fecha(fecha_ini, separador))
											{
												alert(\"".verificar_fecha_ini."\");
												formulario.dia_i.focus(); 
												return false														
											}												
										if(!verificar_fecha(fecha_fin, separador))
											{
												alert(\"".verificar_fecha_fin."\");
												formulario.dia_t.focus(); 
												return false														
											}											
										formulario.btn_guardar1.style.visibility='hidden';
							";
							if($nivel == "1" or $nivel == "2")
								{								
							echo   "formulario.btn_guardar2.style.visibility='hidden';";
								}
							echo"       if(alert('Deber� dar click en el bot�n de Aceptar para guardar el nuevo m�dulo al buscador'))
										formulario.submit();
									}
							";
						echo '</script>';							
						echo '<form name="ingresar_modulo" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>Persona que propone el m&oacute;dulo</td>';
									echo '<td><input type = "text" name = "nombre" size = "60" /></td>';											
								echo '</tr>';								
								echo '<tr>';
									echo '<td>Correo electr&oacute;nico del que propone</td>';
									echo '<td><input type = "text" name = "correo" size = "60" /></td>';											
								echo '</tr>';														
								echo '<tr>';																		
									echo '<td>Fecha de inicio de vigencia</td>';
									echo '<td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');												
										$areglo_meses = FunGral::MesesNumero();									
										echo dia.'&nbsp;<select name = "dia_i">';
										for ($a = 1; $a<=31; $a++)
											{
												echo "<option value = \"$a\" "; if ($dia == $a) { echo "selected"; } echo " > $a </option>";
											}
										echo "</select>&nbsp;";
										echo mes.'&nbsp;<select name = "mes_i">';
											for ($b=1; $b<=12; $b++)
												{
													echo "<option value = \"$b\"  "; if ($mes == $b) {echo " selected ";} echo " >". $areglo_meses[$b] ."</option>";
												}
										echo '</select>&nbsp;';											
										echo ano.'&nbsp;<select name = "ano_i">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{
													echo "<option value = \"$b\" "; if ($ano == $b) {echo " selected ";} echo "> $b</option>";
												}
										echo '</select>';													
									echo '</td>';																						
								echo '</tr>';								
								echo '<tr>';																		
									echo '<td>Fecha de fin de vigencia</td>';									
									echo '<td>';									
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
								echo '<tr>';
									echo '<td>'.modulo_nombre.'</td>';
									echo '<td>';
											$con_mod = "select clave_modulo, nombre, tipo from nazep_modulos
											where situacion = 'activo' and tipo = 'central'
											and clave_modulo <> all(select clave_modulo from nazep_zmod_buscador)
											and nombre_archivo <> 'buscador'order by nombre, tipo";				
										echo '<select name = "clave_modulo">';
											$res_mod = mysql_query($con_mod);										
											while($ren= mysql_fetch_array($res_mod))
												{
													$clave_modulo = $ren["clave_modulo"];
													$nombre = $ren["nombre"];
													$tipo = $ren["tipo"];	
													echo "<option value = \"$clave_modulo\" >$nombre - TIPO: $tipo</option>";
												}
										echo '</select>';
									echo '</td>';											
								echo '</tr>';						
								echo '<tr>';
									echo '<td>';		
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_buscador" />';
										echo '<input type="hidden" name="metodo" value = "nuevo" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';														
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="situacion_temporal" value = "nuevo" />';
										echo '<input type="submit" name="btn_guardar1" value="Guardar nuevo m&oacute;dulo" onclick= "return validar_form(this.form, \'nuevo\')" />';
									if($nivel == 1 or $nivel == 2)
										{
											echo '<input type="submit" name="btn_guardar2" value="Guardar y autorizar nuevo m&oacute;dulo" onclick= "return validar_form(this.form, \'activo\')" />';
										}
										
									echo '</td>';
								echo '</tr>';							
							echo '</table>';
						echo '</form>';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));																														
					}				
			}
		function modificar($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$motivo = $_POST["motivo"];
						$situacion = $_POST["situacion"];
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_fin = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
						$clave_buscador = $_POST["clave_buscador"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];	
						$clave_seccion = $_POST["clave_seccion"];
						$situacion_temporal  = $_POST["situacion_temporal"];
						if($correo=='')
							{ $correo = $cor_user;}
						if($nombre=='')
							{$nombre = $nom_user;}
						$sql_adicional = "null, '', '0000-00-00', '00:00:00','', '','',";					
						if($situacion_temporal=="activo")
							{$sql_adicional = "'$nick_user', '$ip', '$fecha_hoy', '$hora_hoy',  '$motivo', '$nombre', '$correo',";}							
						$insert_cambio ="insert into nazep_zmod_buscador_cambios
						(clave_buscador, situacion, nick_user_propone, ip_propone, fecha_propone, hora_propone,
						motivo_propone, nombre_propone, correo_propone,  
						nick_user_decide, ip_decide, fecha_decide, hora_decide, motivo_decide, nombre_decide, correo_decide,
						nuevo_situacion, nuevo_fecha_inicio, nuevo_fecha_fin, 
						anterior_situacion, anterior_fecha_inicio, anterior_fecha_fin)
						select '$clave_buscador','$situacion_temporal','$nick_user', '$ip', '$fecha_hoy', '$hora_hoy',
						'$motivo', '$nombre', '$correo',
						".$sql_adicional."
						'$situacion', '$fecha_inicio', '$fecha_fin',
						situacion, fecha_inicio, fecha_fin
						from nazep_zmod_buscador 
						where  clave_buscador = '$clave_buscador'";	
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
										$update="update nazep_zmod_buscador 
										set situacion = '$situacion', fecha_inicio  = '$fecha_inicio', fecha_fin = '$fecha_fin', 
										user_actualizacion = '$nick_user', 
										ip_actualizacion = '$ip', fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy'
										where clave_buscador = '$clave_buscador'";
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
								header("Location:  index.php?opc=11&clave_seccion=$clave_seccion");	
							}
						else
							{
								header("Location:  index.php?opc=4&tipo=1&men=$error&erro=$men");
							}																						
					}
				else
					{
						if(isset($_POST["clave_buscador"]) && $_POST["clave_buscador"]!="")
							{
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Modificar el m&oacute;dulo del buscador");		
								$clave_buscador = $_POST["clave_buscador"];		
								$con_baner_cambios = "select clave_buscador_cambios
								from nazep_zmod_buscador b, nazep_zmod_buscador_cambios bc
								where b.clave_buscador = bc.clave_buscador
								and bc.clave_buscador = '$clave_buscador'
								and (bc.situacion = 'pendiente' or bc.situacion = 'nuevo')";
								$conexion = $this->conectarse();
								$res_ban_cam = mysql_query($con_baner_cambios);
								$cant_baners = mysql_num_rows($res_ban_cam);
								if($cant_baners!="0")
									{
										echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
											echo '<tr>';
												echo '<td align = "center">';
													echo '<br /><strong>No se puede realizar cambios en el m&oacute;dulo<br /> hasta que se DECIDA acerca del cambio anterior</strong><br /><br />';
												echo '</td>';
											echo '</tr>';					 
										echo '</table>';	
										echo '<form name="reg_buscador" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';						
											echo '<table width="777" border="0" cellspacing="0" cellpadding="0"  align = "center">';
												echo '<tr>';								
													echo '<td align="center">';																		
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_buscador" />';
														echo '<input type="hidden" name="metodo" value = "modificar" />';								
														echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
														echo '<a href="javascript:document.reg_buscador.submit()" class="regresar">';
														echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
														echo '<b>Regresar al listado de m&oacute;dulos</b></a>';
													echo '</td>';							
												echo '</tr>';
											echo '</table>';
										echo '</form>';																				
									}
								else
									{
										$con_doc ="select b.situacion, b.fecha_inicio, b.fecha_fin, b.clave_modulo, m.nombre
										from nazep_zmod_buscador b, nazep_modulos m where clave_buscador = '$clave_buscador' and b.clave_modulo = m.clave_modulo";																																
										$conexion = $this->conectarse();
										$res_con_doc = mysql_query($con_doc);
										$ren_con_doc = mysql_fetch_array($res_con_doc);
										$nombre = $ren_con_doc["nombre"];
										$situacion = $ren_con_doc["situacion"];
										$fecha_inicio = $ren_con_doc["fecha_inicio"];
										list($ano_i, $mes_i, $dia_i) = explode("-",$fecha_inicio);
										$fecha_fin = $ren_con_doc["fecha_fin"];
										list($ano_t, $mes_t, $dia_t) = explode("-",$fecha_fin);
										echo '<script type="text/javascript">';										
										echo "function validar_form(formulario, situacion_temporal)
													{		
														formulario.situacion_temporal.value = situacion_temporal;
														if(formulario.motivo.value == \"\") 
															{
																alert(\"El campo del motivo no puede quedar vac�o\");
																formulario.motivo.focus(); 
																return false
															}														
														separador = \"/\";		
														fecha_ini = formulario.dia_i.value+\"/\"+formulario.mes_i.value+\"/\"+formulario.ano_i.value;
														fecha_fin = formulario.dia_t.value+\"/\"+formulario.mes_t.value+\"/\"+formulario.ano_t.value;														
														if(!Comparar_Fecha(fecha_ini, fecha_fin))
															{
																alert(\"".comparar_fecha_veri."\");
																formulario.dia_i.focus(); 
																return false
															}												
														if(!verificar_fecha(fecha_ini, separador))
															{
																alert(\"".verificar_fecha_ini."\");
																formulario.dia_i.focus(); 
																return false														
															}												
														if(!verificar_fecha(fecha_fin, separador))
															{
																alert(\"".verificar_fecha_fin."\");
																formulario.dia_t.focus(); 
																return false														
															}	
														formulario.btn_guardar1.style.visibility='hidden';
													";
												if($nivel == 1 or $nivel == 2)
													{														
												echo "	formulario.btn_guardar2.style.visibility='hidden';";
													}
												echo "
														if(alert('Deber� dar un click en bot�n de Aceptar para guardar el cambio'))
														formulario.submit();															
													}
											";																						
										echo '</script>';
										echo '<form name="modificar" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
											echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
												echo '<tr>';
													echo '<td>Persona que propone el cambio</td>';
													echo '<td><input type = "text" name = "nombre" size = "60" /></td>';
												echo '</tr>';								
												echo '<tr>';
													echo '<td>Correo electr&oacute;nico del que propone</td>';
													echo '<td><input type = "text" name = "correo" size = "60" /></td>';
												echo '</tr>';											
												echo '<tr>';
													echo '<td width="500">Motivo de la modificaci&oacute;n</td>';								
													echo '<td><textarea name="motivo" cols="50" rows="5"></textarea></td>';							
												echo '</tr>';
												echo '<tr>';
													echo '<td>Nombre del m&oacute;dulo</td>';
													echo '<td>'.$nombre.'</td>';					
												echo '</tr>';												
												echo '<tr>';
													echo '<td>Situaci&oacute;n del m&oacute;dulo</td>';
													echo '<td>';
														echo '<select name = "situacion">';
															echo "<option value = \"activo\"  "; if ($situacion == "activo") { echo "selected"; } echo " >".activo."</option>";
															echo "<option value = \"cancelado\"  "; if ($situacion == "cancelado") { echo "selected"; } echo "  >".cancelado."</option>";
														echo '</select>';
													echo '</td>';						
												echo '</tr>';																					
												echo '<tr>';																		
													echo '<td>Fecha de inicio de vigencia</td>';
													echo '<td>';
														$areglo_meses = FunGral::MesesNumero();									
														echo dia.'&nbsp;<select name = "dia_i">';											
														for ($a = 1; $a<=31; $a++)
															{
																echo "<option value = \"$a\" "; if ($dia_i == $a) { echo "selected"; } echo " > $a </option>";
															}
														echo '</select>&nbsp;';
														echo mes.'&nbsp;<select name = "mes_i">';											
															for ($b=1; $b<=12; $b++)
																{
																	echo "<option value = \"$b\"  "; if ($mes_i == $b) {echo " selected ";} echo " >". $areglo_meses[$b] ."</option>";
																}
														echo '</select>&nbsp;';											
														echo ano.'&nbsp;<select name = "ano_i">';
															for ($b=$ano_i-10; $b<=$ano_i+10; $b++)
																{
																	echo "<option value = \"$b\" "; if ($ano_i == $b) {echo " selected ";} echo "> $b</option>";
																}
														echo '</select>';													
													echo '</td>';																						
												echo '</tr>';								
												echo '<tr>';																		
													echo '<td>Fecha de fin de vigencia</td>';									
													echo '<td>';									
														echo dia.'&nbsp;<select name = "dia_t">';											
														for ($a = 1; $a<=31; $a++)
															{
																echo "<option value = \"$a\" "; if ($dia_t == $a) { echo "selected"; } echo " > $a </option>";
															}
														echo '</select>&nbsp;';
														echo mes.'&nbsp;<select name = "mes_t">';											
															for ($b=1; $b<=12; $b++)
																{
																	echo "<option value = \"$b\"  "; if ($mes_t == $b) {echo " selected ";} echo " >". $areglo_meses[$b] ."</option>";
																}
														echo '</select>&nbsp;';											
														echo ano.'&nbsp;<select name = "ano_t">';
															for ($b=$ano_t-10; $b<=$ano_t+10; $b++)
																{
																	echo "<option value = \"$b\" "; if ($ano_t == $b) {echo " selected ";} echo "> $b</option>";
																}
														echo '</select>';
													echo '</td>';																						
												echo '</tr>';
											echo '</table>';	
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_buscador" />';
											echo '<input type="hidden" name="metodo" value = "modificar" />';															
											echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
											echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';
											echo '<input type="hidden" name="guardar" value = "si" />';
											echo '<input type="hidden" name="situacion_temporal" value = "pendiente" />';											
											echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';											
												echo '<tr>';
													echo '<td>';
														echo '<input type="submit" name="btn_guardar1" value="Guardar cambio"  onclick= "return validar_form(this.form,\'pendiente\')" />';
													if($nivel == "1" or $nivel == "2")
														{															
															echo '<input type="submit" name="btn_guardar2" value="Guardar y autorizar cambio"  onclick= "return validar_form(this.form,\'activo\')" />';
														}
													echo '</td>';
												echo '</tr>';
											echo '</table>';
										echo '</form>';	
										echo '<br />';
										echo '<form name="reg_buscador" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';						
											echo '<table width="777" border="0" cellspacing="0" cellpadding="0"  align = "center">';
												echo '<tr>';								
													echo '<td align="center">';																		
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_buscador" />';
														echo '<input type="hidden" name="metodo" value = "modificar" />';								
														echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
														echo '<a href="javascript:document.reg_buscador.submit()" class="regresar">';
														echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
														echo '<b>Regresar al listado de m&oacute;dulos</b></a>';										
													echo '</td>';							
												echo '</tr>';
											echo '</table>';
										echo '</form>';																							
									}										
							}
						else
							{
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Listado de m&oacute;dulos del buscador");								
								$con_doc_total = " select clave_buscador from nazep_zmod_buscador ";
								$conexion = $this->conectarse();
								$res_con_total = mysql_query($con_doc_total);
								$cantidad_doc = mysql_num_rows($res_con_total);
								$con_doc = " select b.clave_buscador, b.situacion, b.fecha_creacion, m.nombre from nazep_zmod_buscador b, nazep_modulos m
								where m.clave_modulo = b.clave_modulo order by fecha_creacion  ";	
								$res_doc_total = mysql_query($con_doc);
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><b>Nombre del m&oacute;dulo</b></td>';
										echo '<td align = "center"><b>Fecha realizado</b></td>';
										echo '<td align = "center"><b>Situaci&oacute;n</b></td>';
										echo '<td align = "center"><b>Modificar</b></td>';
									echo '</tr>';
									$contador = 0;								
									while($ren = mysql_fetch_array($res_doc_total))
										{
											if(($contador%2)=="0")
												{ $color = 'bgcolor="#F9D07B"';}
											else
												{ $color = '';}										
											$clave_buscador = $ren["clave_buscador"];
											$situacion = $ren["situacion"];
											$nombre = $ren["nombre"];
											$fecha_creacion = $ren["fecha_creacion"];
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											echo '<tr>';
												echo '<td  '.$color.'>'.$nombre.'</td>';
												echo '<td  '.$color.'>'.$fecha_creacion.'</td>';
												echo '<td  '.$color.'>'.$situacion.'</td>';
												echo '<td align = "center"  '.$color.'>';
													echo '<form name="mod_buscador_'.$clave_buscador.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_buscador" />';
														echo '<input type="hidden" name="metodo" value = "modificar" />';	
														echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';
														echo '<input type="submit" name="Submit" value="Modificar m&oacute;dulo" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
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
						$clave_buscador_cambios = $_POST["clave_buscador_cambios"];
						$clave_buscador = $_POST["clave_buscador"];	
						$clave_seccion  = $_POST["clave_seccion"];					
						$publicar =  $_POST["publicar"];
						$motivo =   $_POST["motivo"];					
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];						
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=='')
							{ $correo = $cor_user; }
						if($nombre=='')
							{ $nombre = $nom_user; }
						$update1 = " update nazep_zmod_buscador_cambios
						set situacion = '$publicar', nick_user_decide = '$nick_user', ip_decide= '$ip', fecha_decide = '$fecha_hoy',
						hora_decide = '$hora_hoy', motivo_decide = '$motivo', nombre_decide = '$nombre',
						correo_decide = '$correo'
						where clave_buscador_cambios = '$clave_buscador_cambios' and clave_buscador = '$clave_buscador' ";						
						$update2 = " update nazep_zmod_buscador set
						situacion = '$publicar', user_actualizacion = '$nick_user', ip_actualizacion = '$ip',
						fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy'
						where clave_buscador = '$clave_buscador'";	
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
									{
										$paso = true;									
									}							
							}
						if($paso)
							{
								mysql_query("COMMIT;");									
								header("Location:  index.php?opc=12&clave_seccion=$clave_seccion_enviada ");	
							}
						else
							{
								header("Location:  index.php?opc=4&tipo=1&men=$error&erro=$men");
							}																			
						$this->desconectarse($conexion);												
							
													
					}
				else
					{				
						if(isset($_POST["clave_buscador_cambios"]) && $_POST["clave_buscador_cambios"]!="")
							{
								$clave_buscador_cambios = $_POST["clave_buscador_cambios"];
								$clave_buscador = $_POST["clave_buscador"];
								$con_elemento = " select nick_user_propone, fecha_propone, hora_propone,
								nuevo_situacion,  nuevo_fecha_inicio, nuevo_fecha_fin, nombre_propone, correo_propone								
								from nazep_zmod_buscador_cambios
								where clave_buscador_cambios = '$clave_buscador_cambios'  and clave_buscador= '$clave_buscador' 
								and situacion = 'nuevo' 	";		
								$conexion = $this->conectarse();
								$res_con_elemento = mysql_query($con_elemento);
								$ren_con_elemento = mysql_fetch_array($res_con_elemento);
								$nick_user_propone = $ren_con_elemento["nick_user_propone"];
								$fecha_propone = $ren_con_elemento["fecha_propone"];
								$fecha_propone  = FunGral::FechaNormal($fecha_propone);
								$hora_propone = $ren_con_elemento["hora_propone"];
								$nuevo_situacion = $ren_con_elemento["nuevo_situacion"];
								$nuevo_fecha_inicio = $ren_con_elemento["nuevo_fecha_inicio"];
								$nuevo_fecha_fin = $ren_con_elemento["nuevo_fecha_fin"];								
								$nuevo_fecha_inicio  = FunGral::FechaNormal($nuevo_fecha_inicio);
								$nuevo_fecha_fin  = FunGral::FechaNormal($nuevo_fecha_fin);
								$nombre_propone = $ren_con_elemento["nombre_propone"];
								$correo_propone = $ren_con_elemento["correo_propone"];	
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("M&oacute;dulo nuevo");																
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td>Usuario que propone el m&oacute;dulo</td>';
										echo '<td width="480">'.$nick_user_propone.'</td>';							
									echo '</tr>';
									echo '<tr>';
										echo '<td>Nombre de persona que propone</td>';
										echo '<td>'.$nombre_propone.'</td>';						
									echo '</tr>';								
									echo '<tr>';
										echo '<td>Correo electr&oacute;nico del que propone</td>';
										echo '<td>'.$correo_propone.'</td>';							
									echo '</tr>';
									echo '<tr>';
										echo '<td>Fecha realizado</td>';
										echo '<td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td>';									
									echo '</tr>';
									echo '<tr>';
										echo '<td>Situaci&oacute;n propuesta</td>';
										echo '<td>'.$nuevo_situacion.'</td>';							
									echo '</tr>';
									echo '<tr>';
										echo '<td>Fecha inicia vigencia</td>';
										echo '<td>'.$nuevo_fecha_inicio.'</td>';									
									echo '</tr>';
									echo '<tr>';
										echo '<td>Fecha termina vigencia</td>';
										echo '<td>'.$nuevo_fecha_fin.'</td>';									
									echo '</tr>';
								echo '</table>';	
								echo '<script type="text/javascript">';
								echo "function validar_form(formulario)
											{
												if(formulario.motivo.value == \"\") 
													{
														alert(\"El campo del motivo no puede quedar vac�o\");
														formulario.motivo.focus();	
														return false
													}	
												formulario.btn_guardar.style.visibility='hidden';
												if(alert('Deber� dar click en el bot�n de Aceptar para guardar la decisi�n'))
												formulario.submit();																				
											}";														
								echo '</script>';									
								echo '<form name="guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';								
									echo "<table width=\"777\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" >";
										echo '<tr>';
											echo '<td>Persona que toma la decisi&oacute;n</td>';
											echo '<td><input type = "text" name = "nombre" size = \"60" /></td>';													
										echo '</tr>';								
										echo '<tr>';
											echo '<td>Correo electr&oacute;nico del que decide</td>';
											echo '<td><input type = "text" name = "correo" size = "60" /></td>';											
										echo '</tr>';									
										echo '<tr>';
											echo '<td>�Publicar el m&oacute;dulo?</td>';
											echo '<td>';
												echo '<select name = "publicar">';
													echo '<option value = "activo">SI</option>';
													echo '<option value = "cancelado">NO</option>';													
												echo '</select>';
											echo '</td>';																
										echo '</tr>';
										echo '<tr>';
											echo '<td width="600">Motivo de la decisi&oacute;n</td>';									
											echo '<td><textarea name="motivo" cols="50" rows="5"></textarea></td>';								
										echo '</tr>';
										echo '<tr>';
											echo '<td>&nbsp;</td>';	
											echo '<td>';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_buscador" />';
											echo '<input type="hidden" name="metodo" value = "nuevo_pendiente" />';
											
											echo '<input type="hidden" name="clave_buscador_cambios" value = "'.$clave_buscador_cambios.'" />';
											echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';										
											echo '<input type="hidden" name="guardar" value = "si" />';	
											echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';										
											echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
											echo '</td>';																
										echo '</tr>';																							
									echo '</table>';													
								echo '</form>';
								echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';						
									echo '<table width="777" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';								
											echo '<td align="center">';																		
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_buscador" />';
											echo '<input type="hidden" name="metodo" value = "nuevo_pendiente" />';								
												echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
												echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<b>Regresar al listado de nuevos m&oacute;dulos pendientes</b></a>';										
											echo '</td>';							
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{							
								$con_nue = "select m.nombre, b.fecha_creacion, b.hora_creacion, b.clave_buscador, bc.clave_buscador_cambios
								from nazep_zmod_buscador b, nazep_zmod_buscador_cambios bc, nazep_modulos m
								where b.clave_buscador = bc.clave_buscador 
								and m.clave_modulo = b.clave_modulo and bc.situacion = 'nuevo' ";
								$conexion = $this->conectarse();
								$res_con_nue = mysql_query($con_nue);
								$can_mod = mysql_num_rows($res_con_nue);
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("($can_mod) Nuevo(s) M&oacute;dulo(s) pendientes para el buscador");									
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><b>Nombre del m&oacute;dulo</b></td>';
										echo '<td align = "center"><b>Fecha de propuesta</b></td>';
										echo '<td align = "center"><b>Ver m&oacute;dulo</b></td>';																
									echo '</tr>';	
									$contador = 0;				 								
									while($ren_con_nue = mysql_fetch_array($res_con_nue))
										{
											if(($contador%2)==0)
												{$color = 'bgcolor="#F9D07B"';
												}
											else
												{$color = '';}											
											$nombre = $ren_con_nue["nombre"];
											$fecha_creacion = $ren_con_nue["fecha_creacion"];
											$hora_creacion = $ren_con_nue["hora_creacion"];
											$fecha_creacion  = FunGral::FechaNormal($fecha_creacion);
											$clave_buscador = $ren_con_nue["clave_buscador"];
											$clave_buscador_cambios = $ren_con_nue["clave_buscador_cambios"];
																					
											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td align = "center" '.$color.'>';
													echo "$fecha_creacion a las $hora_creacion hrs.";
												echo '</td>';
												echo '<td align = "center" '.$color.'>';
													echo '<form name="mod_buscador_'.$clave_buscador.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_buscador" />';
														echo '<input type="hidden" name="metodo" value = "nuevo_pendiente" />';
														echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';
														echo '<input type="hidden" name="clave_buscador_cambios" value = "'.$clave_buscador_cambios.'" />';
														echo '<input type="submit" name="Submit" value="Ver m&oacute;dulo" />';
													echo '</form>';		
												echo '</td>';																
											echo '</tr>';	
											$contador++;
										}																				
								echo '</table>';
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));															
							}						
					}
			}
		function cambios_pendientes($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$nuevo_situacion = $_POST["nuevo_situacion"];
						$nuevo_fecha_inicio = $_POST["nuevo_fecha_inicio"];
						$nuevo_fecha_fin = $_POST["nuevo_fecha_fin"];
						$publicar = $_POST["publicar"];
						$motivo = $_POST["motivo"];
						$clave_buscador_cambios = $_POST["clave_buscador_cambios"];
						$clave_buscador = $_POST["clave_buscador"];												
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=='')
							{$correo = $cor_user;}
						if($nombre=='')
							{$nombre = $nom_user;}	
						$update_1 = "update nazep_zmod_buscador_cambios
						set situacion = '$publicar', nick_user_decide = '$nick_user', fecha_decide = '$fecha_hoy',
						hora_decide = '$hora_hoy', ip_decide = '$ip', motivo_decide = '$motivo',
						nombre_decide = '$nombre', correo_decide = '$correo'
						where clave_buscador_cambios = '$clave_buscador_cambios'";	
						
						$update_2 = "update nazep_zmod_buscador b, nazep_zmod_buscador_cambios  bc
						set b.situacion= bc.nuevo_situacion, b.fecha_inicio = bc.nuevo_fecha_inicio, b.fecha_fin = bc.nuevo_fecha_fin,
						b.user_actualizacion = '$nick_user', b.ip_actualizacion='$ip', b.fecha_actualizacion='$fecha_hoy',
						b.hora_actualizacion = '$hora_hoy'						
						where b.clave_buscador = '$clave_buscador' and bc.clave_buscador_cambios = '$clave_buscador_cambios'";		
						if($publicar == "cancelado")
							{
								$conexion = $this->conectarse();
								if (!@mysql_query($update_1))							
									{
										$men = mysql_error();
										$error = 1;
										header("Location:  index.php?opc=4&tipo=1&men=$error&erro=$men");
																				
									}
								else
									{
										header("Location:  index.php?opc=12$&clave_seccion=$clave_seccion_enviada");									
									}
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
											{
												$paso = true;	
											}								
									}	
								if($paso)
									{
										mysql_query("COMMIT;");												
										header("Location:  index.php?opc=12&clave_seccion=$clave_seccion_enviada");	
									}
								else
									{									
										header("Location:  index.php?opc=4&tipo=1&men=$error&erro=$men");
									}															
							}																
					}
				else
					{
						if( (isset($_POST["clave_buscador"]) && isset($_POST["clave_buscador_cambios"])) && ($_POST["clave_buscador"]!="" and $_POST["clave_buscador_cambios"]!=""))
							{
								$clave_buscador = $_POST["clave_buscador"];	
								$clave_buscador_cambios = $_POST["clave_buscador_cambios"];
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Cambio al m&oacute;dulo del buscador");	
								$con_doc = "select nick_user_propone, fecha_propone, hora_propone, motivo_propone, nombre_propone, correo_propone,								
								nuevo_situacion, nuevo_fecha_inicio, nuevo_fecha_fin,								
								anterior_situacion,	anterior_fecha_inicio, anterior_fecha_fin from nazep_zmod_buscador_cambios
								where clave_buscador_cambios = '$clave_buscador_cambios'  and clave_buscador= '$clave_buscador'  and situacion = 'pendiente'";		
								$conexion = $this->conectarse();
								$res_con_doc = mysql_query($con_doc);
								$ren_con_doc = mysql_fetch_array($res_con_doc);
								$nick_user_propone = $ren_con_doc["nick_user_propone"];
								$fecha_propone = $ren_con_doc["fecha_propone"];
								$fecha_propone  = FunGral::FechaNormal($fecha_propone);
								$hora_propone = $ren_con_doc["hora_propone"];
								$nuevo_situacion = $ren_con_doc["nuevo_situacion"];
								$nuevo_fecha_inicio_or = $ren_con_doc["nuevo_fecha_inicio"];
								$nuevo_fecha_fin_or = $ren_con_doc["nuevo_fecha_fin"];								
								$motivo_propone = $ren_con_doc["motivo_propone"];
								$anterior_situacion = $ren_con_doc["anterior_situacion"];
								$anterior_fecha_inicio = $ren_con_doc["anterior_fecha_inicio"];
								$anterior_fecha_fin = $ren_con_doc["anterior_fecha_fin"];
								$nuevo_fecha_inicio  = FunGral::FechaNormal($nuevo_fecha_inicio_or);
								$nuevo_fecha_fin  = FunGral::FechaNormal($nuevo_fecha_fin_or);
								$anterior_fecha_inicio  = FunGral::FechaNormal($anterior_fecha_inicio);
								$anterior_fecha_fin  = FunGral::FechaNormal($anterior_fecha_fin);
								$nombre_propone = $ren_con_doc["nombre_propone"];
								$correo_propone = $ren_con_doc["correo_propone"];	
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td>Usuario que propone</td><td>'.$nick_user_propone.'</td></tr>';
									echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
									echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';										
									echo '<tr><td>Fecha realizado</td><td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td></tr>';
									echo '<tr>';
										echo '<td>Motivo del cambio</td>';
										echo '<td>'.$motivo_propone.'</td>';									
									echo '</tr>';	
									echo '<tr><td><hr /></td><td><hr /></td></tr>';
									echo '<tr>';
										echo '<td>Nueva Situaci&oacute;n</td>';
										echo '<td>'.$nuevo_situacion.'</td>';									
									echo '</tr>';								
									echo '<tr>';
										echo '<td>Nueva Fecha inicia vigencia</td>';
										echo '<td>'.$nuevo_fecha_inicio.'</td>';									
									echo '</tr>';
									echo '<tr>';
										echo '<td>Nueva Fecha termina vigencia</td>';
										echo '<td>'.$nuevo_fecha_fin.'</td>';									
									echo '</tr>';	
									echo '<tr><td><hr /></td><td><hr /></td></tr>';																			
									echo '<tr>';
										echo '<td>Anterior Situaci&oacute;n</td>';
										echo '<td>'.$anterior_situacion.'</td>';									
									echo '</tr>';								
									echo '<tr>';
										echo '<td>Anterior Fecha inicia vigencia</td>';
										echo '<td>'.$anterior_fecha_inicio.'</td>';									
									echo '</tr>';
									echo '<tr>';
										echo '<td>Anterior Fecha termina vigencia</td>';
										echo '<td>'.$anterior_fecha_fin.'</td>';									
									echo '</tr>';									
								echo '</table>';	
								echo '<script type="text/javascript">';
								echo "function validar_form(formulario)
											{
												if(formulario.motivo.value == \"\") 
													{
														alert(\"El campo del motivo no puede quedar vac�o\");
														formulario.motivo.focus(); 	
														return false
													}	
												formulario.btn_guardar.style.visibility='hidden';
												if(alert('Deber� dar click en el bot�n de Aceptar para guardar la decisi�n'))
												formulario.submit();																					
											}";	
								echo '</script>';
								echo '<form name="guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';								
									echo '<table width="777" border="1" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td>Persona que toma la decisi&oacute;n</td>';
											echo '<td><input type = "text" name = "nombre" size="60" /></td>';											
										echo '</tr>';								
										echo '<tr>';
											echo '<td>Correo electr&oacute;nico del que decide</td>';
											echo '<td><input type = "text" name = "correo" size = "60" /></td>';											
										echo '</tr>';										
										echo '<tr>';
											echo '<td>�Aplicar el cambio?</td>';
											echo '<td>';
												echo '<select name = "publicar">';
													echo '<option value = "activo">SI</option>';
													echo '<option value = "cancelado">NO</option>';													
												echo '</select>';
											echo '</td>';																
										echo '</tr>';
										echo '<tr>';
											echo '<td width="600">Motivo de la decisi&oacute;n</td>';								
											echo '<td><textarea name="motivo" cols="50" rows="5"></textarea></td>';								
										echo '</tr>';
										echo '<tr>';
											echo '<td>&nbsp;</td>';	
											echo '<td>';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_buscador" />';
											echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';											
											echo '<input type="hidden" name="clave_buscador_cambios" value = "'.$clave_buscador_cambios.'" />';
											echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';
											echo '<input type="hidden" name="guardar" value = "si" />';
											echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';											
											echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
											echo '</td>';																
										echo '</tr>';																							
									echo '</table>';													
								echo '</form>';
								echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';						
									echo '<table width="777" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';								
											echo '<td align="center">';																		
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_buscador" />';
												echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';									
												echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
												echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<b>Regresar al listado de m&oacute;dulos con cambios pendientes</b></a>';
											echo '</td>';							
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{	
								$consu_doc_total = "select b.clave_buscador
								from nazep_zmod_buscador b, nazep_zmod_buscador_cambios  bc
								where b.clave_buscador = bc.clave_buscador and bc.situacion = 'pendiente'";
								$conexion = $this->conectarse();
								$res_con_total = mysql_query($consu_doc_total);
								$cantidad_doc = mysql_num_rows($res_con_total);
								$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
								HtmlAdmon::titulo_seccion("($cantidad_doc) M&oacute;dulo(s) con cambios pendientes por decidir");
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
								$total_paginas = ceil($cantidad_doc/$cantidad_mostrar);
								$consu_doc = " select m.nombre, b.fecha_creacion, b.clave_buscador, bc.clave_buscador_cambios, bc.fecha_propone
								from nazep_zmod_buscador b, nazep_zmod_buscador_cambios bc, nazep_modulos m
								where b.clave_buscador = bc.clave_buscador 
								and m.clave_modulo = b.clave_modulo and bc.situacion = 'pendiente'";						
								$res_doc_total = mysql_query($consu_doc);
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center"><b>Nombre del m&oacute;dulo</b></td>';
										echo '<td align = "center"><b>Fecha realizado</b></td>';
										echo '<td align = "center"><b>Fecha del cambio</b></td>';										
										echo '<td align = "center"><b>Ver cambio</b></td>';
									echo '</tr>';
									$contador = 0;								
									while($ren = mysql_fetch_array($res_doc_total))
										{
											if(($contador%2)=="0")
												{$color = 'bgcolor="#F9D07B"';}
											else
												{$color = '';}											
											$clave_buscador = $ren["clave_buscador"];
											$nombre = $ren["nombre"];
											$fecha_creacion = $ren["fecha_creacion"];
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											$fecha_propone = $ren["fecha_propone"];
											$fecha_propone = FunGral::FechaNormal($fecha_propone);
											$clave_buscador_cambios = $ren["clave_buscador_cambios"];

											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td '.$color.'>'.$fecha_creacion.'</td>';
												echo '<td '.$color.'>'.$fecha_propone.'</td>';											
												echo '<td align = "center" '.$color.'>';
													echo '<form name="mod_buscador_'.$clave_buscador.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_buscador" />';
														echo '<input type="hidden" name="metodo" value = "cambios_pendientes" />';														
														echo '<input type="hidden" name="clave_buscador_cambios" value ="'.$clave_buscador_cambios.'" />';
														echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';
														echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
														echo '<input type="submit" name="Submit" value="Ver cambio" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';	
											$contador++;										
											
										}
								echo '</table>';
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															echo '<form name="pag_ban_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
																echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
																echo '<input type="hidden" name="clase" value = "clase_buscador" />';
																echo '<input type="hidden" name="metodo" value = "cambios_pendientes" >';
																echo '<input type="hidden" name="pag" value = "'.$a.'" >';
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
																{
																	echo '<b>'.$a.'</b>';
																}
															else
																{
																	echo '<a href="javascript:document.pag_ban_'.$a.'.submit()">'.$a.'</a>';																
																}
														}													
												}																	
										echo '</td>';
									echo '</tr>';									
								echo '</table>';							
							}						
					}				
			}
		function cambios_realizados($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["clave_buscador_cambios"]) && $_POST["clave_buscador_cambios"] !="")
					{
						$clave_buscador_cambios = $_POST["clave_buscador_cambios"];
						$clave_buscador = $_POST["clave_buscador"];
						$nombre = $_POST["nombre"];
						$con_doc = " select nick_user_propone, fecha_propone, hora_propone, motivo_propone, nombre_propone, correo_propone, 
						nick_user_decide, fecha_decide, hora_decide, motivo_decide, nombre_decide, correo_decide, 
						nuevo_situacion, nuevo_fecha_inicio, nuevo_fecha_fin,						
						anterior_situacion,	anterior_fecha_inicio, anterior_fecha_fin, situacion						
						from nazep_zmod_buscador_cambios where clave_buscador_cambios = '$clave_buscador_cambios'  ";						
						$conexion = $this->conectarse();
						$res_con_doc = mysql_query($con_doc);
						$ren_con_doc = mysql_fetch_array($res_con_doc);
						$nick_user_propone = $ren_con_doc["nick_user_propone"];
						$fecha_propone = $ren_con_doc["fecha_propone"];
						$fecha_propone  = FunGral::FechaNormal($fecha_propone);
						$hora_propone = $ren_con_doc["hora_propone"];
						
						$nick_user_decide = $ren_con_doc["nick_user_decide"];
						$fecha_decide = $ren_con_doc["fecha_decide"];
						$fecha_decide = FunGral::FechaNormal($fecha_decide);
						$hora_decide = $ren_con_doc["hora_decide"];
						$motivo_decide = $ren_con_doc["motivo_decide"];
						
						
						$nuevo_situacion = $ren_con_doc["nuevo_situacion"];
						$nuevo_fecha_inicio_or = $ren_con_doc["nuevo_fecha_inicio"];
						$nuevo_fecha_fin_or = $ren_con_doc["nuevo_fecha_fin"];
						
						$motivo_propone = $ren_con_doc["motivo_propone"];
						

						$anterior_situacion = $ren_con_doc["anterior_situacion"];
						$anterior_fecha_inicio = $ren_con_doc["anterior_fecha_inicio"];
						$anterior_fecha_fin = $ren_con_doc["anterior_fecha_fin"];

						$situacion = $ren_con_doc["situacion"];
						$nombre_propone = $ren_con_doc["nombre_propone"];
						$correo_propone = $ren_con_doc["correo_propone"];	
						$nombre_decide = $ren_con_doc["nombre_decide"];
						$correo_decide = $ren_con_doc["correo_decide"];								
						
						$nuevo_fecha_inicio  = FunGral::FechaNormal($nuevo_fecha_inicio_or);
						$nuevo_fecha_fin  = FunGral::FechaNormal($nuevo_fecha_fin_or);
						$anterior_fecha_inicio  = FunGral::FechaNormal($anterior_fecha_inicio);
						$anterior_fecha_fin  = FunGral::FechaNormal($anterior_fecha_fin);
						HtmlAdmon::titulo_seccion("Cambio al m&oacute;dulo: $nombre");	
						echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Situaci&oacute;n del cambio</td><td>'.$situacion.'</td></tr>';
							echo '<tr><td>Usuario que propone</td><td>'.$nick_user_propone.'</td></tr>';	
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';													
							echo '<tr><td>Fecha que se propone el cambio</td><td>'.$fecha_propone.' a las'.$hora_propone.'hrs.</td></tr>';
							echo '<tr>';
								echo '<td>Motivo del cambio</td><td>'.$motivo_propone.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>Usuario que decide</td><td>'.$nick_user_decide.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>Nombre de persona que decide</td><td>'.$nombre_decide.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>Correo electr&oacute;nico del que decide</td><td>'.$correo_decide.'</td>';							
							echo '</tr>';							
							echo '<tr>';
								echo '<td>Fecha de decisi&oacute;n</td><td>'.$fecha_decide.' a las '.$hora_decide.' hrs.</td>';										
							echo '</tr>';
							echo '<tr>';
								echo '<td>Motivo de la decisi&oacute;n</td><td>'.$motivo_decide.'</td>';										
							echo '</tr>';	
							echo '<tr><td><hr /></td><td><hr /></td></tr>';										
							echo '<tr>';
								echo '<td>Nueva Situaci&oacute;n</td><td>'.$nuevo_situacion.'</td>';									
							echo '</tr>';
							echo '<tr>';
								echo '<td>Nueva Fecha inicia vigencia</td><td>'.$nuevo_fecha_inicio.'</td>';									
							echo '</tr>';
							echo '<tr>';
								echo '<td>Nueva Fecha termina vigencia</td><td>'.$nuevo_fecha_fin.'</td>';
							echo '</tr>';	
							echo '<tr><td><hr /></td><td><hr /></td></tr>';									
							echo '<tr>';
								echo '<td>Anterior Situaci&oacute;n</td><td>'.$anterior_situacion.'</td>';								
							echo '</tr>';
							echo '<tr>';
								echo '<td>Anterior Fecha inicia vigencia</td><td>'.$anterior_fecha_inicio.'</td>';								
							echo '</tr>';
							echo '<tr>';
								echo '<td>Anterior Fecha termina vigencia</td><td>'.$anterior_fecha_fin.'</td>';									
							echo '</tr>';									
						echo '</table>';
						echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';						
							echo '<table width="777" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';								
									echo '<td align="center">';																		
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_buscador" />';										
										echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';	
										echo "<input type=\"hidden\" name=\"clave_buscador\" value = \"$clave_buscador\" />";	
										echo "<input type=\"hidden\" name=\"nombre\" value = \"$nombre\" />";									
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
										echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
										echo '<b>Regresar al listado cambios a los m&oacute;dulos</b>';
										echo '</a>';										
									echo '</td>';							
								echo '</tr>';
							echo '</table>';
						echo '</form>';																	
					}
				else
					{
						if(isset($_POST["clave_buscador"]) && $_POST["clave_buscador"]!="")
							{
								$nombre = $_POST["nombre"];
								$clave_buscador = $_POST["clave_buscador"];
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Listado de cambios realizados en el m&oacute;dulo: $nombre");
								$con_doc =" select b.clave_buscador from nazep_zmod_buscador b, nazep_zmod_buscador_cambios  bc
								where b.clave_buscador = bc.clave_buscador and bc.clave_buscador = '$clave_buscador' ";
								$conexion = $this->conectarse();
								$res_con = mysql_query($con_doc);
								$cantidad_doc = mysql_num_rows($res_con);
								$cantidad_mostrar = 10;
								$pag_post = (isset($_POST["pag"])) ?$_POST["pag"]:'';
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
								$total_paginas = ceil($cantidad_doc/$cantidad_mostrar);
								$con_doc_total ="select b.clave_buscador, b.fecha_creacion, bc.fecha_propone, bc.hora_propone,
								bc.clave_buscador_cambios, bc.situacion, bc.fecha_decide, bc.hora_decide
								from nazep_zmod_buscador b, nazep_zmod_buscador_cambios  bc
								where b.clave_buscador = bc.clave_buscador and bc.clave_buscador = '$clave_buscador'
								order by b.fecha_creacion
								limit $ini, $cantidad_mostrar";							
								$res_ban_total = mysql_query($con_doc_total);
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';	
										echo '<td align = "center"><b>Fecha del cambio</b></td>';
										echo '<td align = "center"><b>Fecha de la decisi&oacute;n</b></td>';
										echo '<td align = "center"><b>Situaci&oacute;n del cambio</b></td>';																														
										echo '<td align = "center"><b>Ver cambio</b></td>';
									echo '</tr>';
									$contador = 0;								
									while($ren = mysql_fetch_array($res_ban_total))
										{
											if(($contador%2)=="0")
												{$color = 'bgcolor="#F9D07B"';}
											else
												{$color = '';}										
											$clave_buscador = $ren["clave_buscador"];
											$situacion = $ren["situacion"];
											$fecha_creacion = $ren["fecha_creacion"];
											$hora_propone = $ren["hora_propone"];
											$fecha_decide = $ren["fecha_decide"];
											$hora_decide = $ren["hora_decide"];
											$fecha_decide = FunGral::FechaNormal($fecha_decide);
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											$fecha_propone = $ren["fecha_propone"];
											$fecha_propone = FunGral::FechaNormal($fecha_propone);
											$clave_buscador_cambios = $ren["clave_buscador_cambios"];
											$situacion = $ren["situacion"];
											echo '<tr>';	
												echo '<td '.$color.'>';
													echo "$fecha_propone <br />a las $hora_propone";
												echo '</td>';
												echo '<td '.$color.'>';
													echo "$fecha_decide <br />a las $hora_decide";
												echo '</td>';
												echo '<td align="center" '.$color.'>';
													echo "$situacion";
												echo '</td>';
												echo '<td align="center" '.$color.'>';
													echo '<form name="mod_buscador_'.$clave_buscador_cambios.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_buscador" />';
														echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';	
														echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';
														echo '<input type="hidden" name="clave_buscador_cambios" value = "'.$clave_buscador_cambios.'" />';
														echo '<input type="hidden" name="nombre" value = "'.$nombre.'" />';
														echo '<input type="submit" name="Submit" value="Ver cambio" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';											
											$contador++;
										}
								echo '</table>';
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															echo '<form name="pag_ban_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
																echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
																echo '<input type="hidden" name="clase" value = "clase_buscador" />';
																echo "<input type=\"hidden\" name=\"funcion\" value = \"cambios_realizados\" >";	
																echo "<input type=\"hidden\" name=\"clase_buscador\" value = \"$clase_buscador\" >";
																echo "<input type=\"hidden\" name=\"pag\" value = \"$a\" >";	
																
																echo "<input type=\"hidden\" name=\"nombre\" value = \"$nombre\" >";
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
																{echo '<b>'.$a.'<b>';}
															else
																{echo '<a href="javascript:document.pag_ban_'.$a.'.submit()">'.$a.'</a>';}
														}													
												}																	
										echo '</td>';
									echo '</tr>';									
								echo '</table>';
								echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';						
									echo '<table width="777" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';								
											echo '<td align="center">';																		
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_buscador" />';
												echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';									
												echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
												echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<b>Regresar al listado de m&oacute;dulos</b>';
												echo '</a>';										
											echo '</td>';							
										echo '</tr>';
									echo '</table>';
								echo '</form>';																
							}							
						else
							{
								$nombre = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion("Listado de m&oacute;dulos del buscador");	
								$con_doc_total ="select clave_buscador from nazep_zmod_buscador";
								$conexion = $this->conectarse();
								$res_con = mysql_query($con_doc_total);
								$cantidad_doc = mysql_num_rows($res_con);
								$cantidad_mostrar = 10;
								$pag_post = (isset($_POST["pag"])) ?$_POST["pag"]:'';
								if( $pag_post =='')
									{
										$pag = 1;
										$ini = 0;
									}
								else
									{
										$pag = $_POST["pag"];
										$ini = ($pag-1)*$cantidad_mostrar;									
									}
								$total_paginas = ceil($cantidad_doc/$cantidad_mostrar);
								$consu_doc_total = "select m.nombre, b.fecha_creacion, b.clave_buscador, b.situacion
								from nazep_zmod_buscador b,  nazep_modulos m
								where m.clave_modulo = b.clave_modulo order by b.fecha_creacion limit $ini, $cantidad_mostrar";								
								$res_doc_total = mysql_query($consu_doc_total);
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = \"center\"><b>Nombre del m&oacute;dulo</b></td>';
										echo '<td align = "center"><b>Fecha realizado</b></td>';
										echo '<td align = "center"><b>Situaci&oacute;n</b></td>';
										echo '<td align = "center"><b>Ver cambios realizados</b></td>';
									echo '</tr>';	
									$contador = 0;						
									while($ren = mysql_fetch_array($res_doc_total))
										{
											if(($contador%2)=="0")
												{$color = 'bgcolor="#F9D07B"';}
											else
												{$color = '';}										
											$clave_buscador = $ren["clave_buscador"];
											$situacion = $ren["situacion"];
											$nombre = $ren["nombre"];
											$fecha_creacion = $ren["fecha_creacion"];
											$fecha_creacion = FunGral::FechaNormal($fecha_creacion);
											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td '.$color.'>'.$fecha_creacion.'</td>';
												echo '<td align = "center" '.$color.'>'.$situacion.'</td>';
												echo '<td align = "center" '.$color.'>';
													echo '<form name="mod_buscador_'.$clave_buscador.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
														echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
														echo '<input type="hidden" name="clase" value = "clase_buscador" />';
														echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';	
														echo '<input type="hidden" name="clave_buscador" value = "'.$clave_buscador.'" />';	
														echo '<input type="hidden" name="nombre" value = "'.$nombre.'" />';																		
														echo '<input type="submit" name="Submit" value="Ver cambios realizados" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';											
											$contador++;
										}
								echo '</table>';
								echo '<table width="777" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											if($total_paginas >1)
												{
													for($a=1;$a<=$total_paginas;$a++)
														{
															echo '<form name="pag_ban_'.$a.'" action="index.php?opc=111&clave_seccion='.$clave_seccion_enviada.'" method="post" >';
																echo '<input type="hidden" name="archivo" value = "../librerias/modulos/buscador/buscador_admon.php" />';
																echo '<input type="hidden" name="clase" value = "clase_buscador" />';
																echo '<input type="hidden" name="metodo" value = "cambios_realizados" />';
																echo '<input type="hidden" name="pag" value = "'.$a.'" />';
															echo '</form>';
														}													
												}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td align="center">';		
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
								HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));
							}					
					}				
			}
// ------------------------------ Fin de funciones para controlar los cambios de la informaci�n del m�dulo
	}
?>