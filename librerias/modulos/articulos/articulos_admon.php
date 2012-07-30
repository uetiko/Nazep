<?php
/*
Sistema: Nazep
Nombre archivo: articulos_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de art�culos
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_articulos extends conexion
	{
		//Propiedads privadas para la direcci�n del archivo y nombre de la clase
		private $DirArchivo = '../librerias/modulos/articulos/articulos_admon.php';
		private $NomClase = 'clase_articulos';
		function __construct()
			{
				include('../librerias/idiomas/'.FunGral::SaberIdioma().'/articulos.php');
			} 
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{
						$con_tipo ="select clave_tipo, usar_tema from nazep_zmod_articulos_tipos  where clave_seccion = '$clave_seccion_enviada' and situacion = 'activo'";
						$res_tipo = mysql_query($con_tipo);
						$can_tipo = mysql_num_rows($res_tipo);
						if($can_tipo!='')
							{
								$ren_art = mysql_fetch_array($res_tipo);
								$clave_tipo = $ren_art["clave_tipo"];
								$usar_tema = $ren_art["usar_tema"];
								HtmlAdmon::AccesoMetodo(
									array('ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'frm_crear_articulo', 'Id'=>'frm_crear_articulo',
									'BText'=>btn_1_crear_art, 'BName'=>'btn_crear_articulo',
									'BId'=>'btn_crear_articulo',
									'OpcOcultas' => array('archivo' =>$this->DirArchivo, 
									'clase' =>$this->NomClase, 'metodo' =>'crear_articulo',
									'clave_tipo' =>$clave_tipo) ));
									
								HtmlAdmon::AccesoMetodo(array('ClaveSeccion'=>$clave_seccion_enviada,
									'name'=>'frm_modificar_articulo', 'id'=>'frm_modificar_articulo',
									'BText'=>btn_2_mod_art, 'BName'=>'btn_modificar_articulo',
									'BId'=>'btn_modificar_articulo',
									'OpcOcultas' => array( 
									'archivo' =>$this->DirArchivo,
									'clase' =>$this->NomClase,
									'metodo' =>'modificar_articulo',
									'clave_tipo' =>$clave_tipo) ));
											
								if(($usar_tema=='si') and (($nivel==1) or ($nivel==2)))
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_crear_tema', 'id'=>'frm_crear_tema',
											'BText'=>btn_5_crear_tema,'BName'=>'btn_crear_tema',
											'BId'=>'btn_crear_tema',
											'OpcOcultas' => array(
											'archivo' =>$this->DirArchivo,
											'clase' =>$this->NomClase, 
											'metodo' =>'nuevo_temas',
											'clave_tipo' =>$clave_tipo) ));	
																	
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_modificar_tema',
											'id'=>'frm_modificar_tema',
											'BText'=>btn_6_mod_tema,
											'BName'=>'btn_modificar_temas_art',
											'BId'=>'btn_modificar_temas_art',
											'OpcOcultas' => array(
											'archivo' =>$this->DirArchivo,
											'clase' =>$this->NomClase,
											'metodo' =>'modificar_temas_art',
											'clave_tipo' =>$clave_tipo) ));
									}
								if($nivel==1)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_modificar_tipo',
											'id'=>'frm_modificar_tipo',
											'BText'=>btn_3_conf_art,
											'BName'=>'btn_modificar_tipo',
											'BId'=>'btn_modificar_tipo',
											'OpcOcultas' => array(
											'archivo' =>$this->DirArchivo,
											'clase' =>$this->NomClase,
											'metodo' =>'modificar_tipo',
											'operacion' =>'modificar') ));	
																
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_administrar_comentarios',
											'id'=>'frm_administrar_comentarios',
											'BText'=>btn_4_conf_com_art,
											'BName'=>'btn_administrar_comentarios',
											'BId'=>'btn_administrar_comentarios',
											'OpcOcultas' => array(
											'archivo' =>$this->DirArchivo,'clase' =>$this->NomClase,'metodo' =>'admon_comentarios') ));
									}
							}
						else
							{
								if($nivel==1)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_crear_tema',
											'id'=>'frm_crear_tema',
											'BText'=>btn_7_conf_tipo,
											'BName'=>'btn_crear_articulo',
											'BId'=>'btn_crear_articulo',
											'OpcOcultas' => array(
											'archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase, 'metodo' =>'modificar_tipo', 'operacion' =>'nuevo') ));	
									}
								else
									{echo'Se requiere configurar el m&oacute;dulo para ingresar nuevos art&iacute;culos';}
							}
					}
				else
					{echo '<br />'.mens_mod_no_act_modi;}
			}
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{
				$situacion = FunGral::VigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{	
						if($nivel==1 or $nivel==2)
							{
								$con_cotenido = " select a.clave_articulo from nazep_zmod_articulos a, nazep_zmod_articulos_tipos  at 
								where a.clave_tipo = at.clave_tipo and at.clave_seccion = '$clave_seccion_enviada'	and a.situacion = 'nuevo'";
								$conexion = $this->conectarse();
								$res = mysql_query($con_cotenido);
								$cantidad = mysql_num_rows($res);
								if($cantidad!=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_nuevo_articulo',
											'id'=>'frm_nuevo_articulo',
											'BText'=>btn_8_nue_art_pen,
											'BName'=>'btn_articulos_nuevos',
											'BId'=>'btn_articulos_nuevos',
											'OpcOcultas' => array(
											'archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase,
											'metodo' =>'articulos_nuevos') ));	
									}
								$con_cotenido1 ="select a.clave_articulo from nazep_zmod_articulos a, nazep_zmod_articulos_tipos  at, nazep_zmod_articulos_cambios  ac
								where a.clave_tipo = at.clave_tipo and at.clave_seccion = '$clave_seccion_enviada' and a.clave_articulo= ac.clave_articulo and ac.situacion = 'pendiente'";
								$res1 = mysql_query($con_cotenido1);
								$cantidad1 = mysql_num_rows($res1);
								if($cantidad1 !=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_cambios_pen_art',
											'id'=>'frm_cambios_pen_art',
											'BText'=>btn_9_cam_pen,
											'BName'=>'btn_cambios_nuevos_articulo',
											'BId'=>'btn_cambios_nuevos_articulo',
											'OpcOcultas' => array( 'archivo' =>$this->DirArchivo, 'clase' =>$this->NomClase,
											'metodo' =>'cambios_nuevos_articulo') ));
									}
								$con_cotenido1 = "select a.clave_articulo from nazep_zmod_articulos a, nazep_zmod_articulos_tipos  at, nazep_zmod_articulos_cambios  ac
								where a.clave_tipo = at.clave_tipo and at.clave_seccion = '$clave_seccion_enviada' and a.clave_articulo= ac.clave_articulo and ac.situacion = 'nueva_pagina'";
								$res1 = mysql_query($con_cotenido1);
								$cantidad1 = mysql_num_rows($res1);
								if($cantidad1 !=0)
									{
										HtmlAdmon::AccesoMetodo(array(
											'ClaveSeccion'=>$clave_seccion_enviada,
											'name'=>'frm_articulos_pag_pendiente',
											'id'=>'frm_articulos_pag_pendiente',
											'BText'=>btn_10_pag_pen,
											'BName'=>'btn_paginas_pendientes',
											'BId'=>'btn_paginas_pendientes',
											'boton_elementos_ocultas' => array('archivo' =>$this->DirArchivo,'clase' =>$this->NomClase,
											'metodo' =>'paginas_pendientes') ));
									}
							}
					}
				else
					{echo '<br />'.mens_mod_no_act_camb;}
			}
// ------------------------------ Fin de M�todos para controlar las funciones del m�dulo		
// ------------------------------ Inicio de M�todos para controlar la modificaci�n de la informaci�n del m�dulo
		function modificar_tipo($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{ 	
						$operacion = FunGral::_Post("operacion");
						
						$formulario_final = FunGral::_Post("formulario_final");
		
						$clave_tipo = $_POST["clave_tipo"];
						
						$partes_enlace_cuerpo_tit = FunGral::_Post("partes_enlace_cuerpo_tit");					
						if($partes_enlace_cuerpo_tit==""){$partes_enlace_cuerpo_tit=0;}
							
						$partes_enlace_cuerpo_res = FunGral::_Post("partes_enlace_cuerpo_res");						
						if($partes_enlace_cuerpo_res==""){$partes_enlace_cuerpo_res=0;}
												
						$partes_enlace_cuerpo_ler = FunGral::_Post("partes_enlace_cuerpo_ler");						
						if($partes_enlace_cuerpo_ler==""){$partes_enlace_cuerpo_ler=0;}
						
						$partes_enlace_cuerpo_num = FunGral::_Post("partes_enlace_cuerpo_num");
						if($partes_enlace_cuerpo_num==""){$partes_enlace_cuerpo_num=0;}
						
						$partes_enlace_cuerpo = $partes_enlace_cuerpo_tit.','.$partes_enlace_cuerpo_res.','.$partes_enlace_cuerpo_ler.','.$partes_enlace_cuerpo_num;
						$arreglo_datos["partes_enlace_cuerpo"] = $partes_enlace_cuerpo;	
						$arreglo_datos["user_actualiza"] = $nick_user;
						$arreglo_datos["ip_actualizacion"] = $_SERVER['REMOTE_ADDR'];
						$arreglo_datos["fecha_actualizacion"] = date("Y-m-d");
						$arreglo_datos["hora_actualizacion"] = date("H:i:s");
						foreach($_POST as $indice=>$valor)
							{
								if(($indice != "archivo") and ($indice!="clase") and ($indice!="metodo") and ($indice!="guardar") and ($indice!="operacion")
									and ($indice!="clave_seccion") and ($indice!="btn_guardar")	
									and ($indice!="partes_enlace_cuerpo_tit")and ($indice!="partes_enlace_cuerpo_res")
									and ($indice!="partes_enlace_cuerpo_ler")and ($indice!="partes_enlace_cuerpo_num")
									and ($indice!="clave_tipo")and ($indice!="formulario_final"))
									{
										if( ($indice=="nombre") or
										    ($indice=="descripcion"))
											{$valor = strip_tags($valor);}
										$arreglo_datos[$indice] = $valor;
									}
							}
						if( $operacion == 'nuevo')
							{
								$arreglo_datos["situacion "] = "activo";
								$arreglo_datos["clave_seccion"] = $_POST["clave_seccion"];
								$consulta = $this->crear_insert_simple($arreglo_datos, "nazep_zmod_articulos_tipos");								
							}
						elseif($operacion =='modificar')
							{$consulta = $this->crear_update_simple($arreglo_datos, "nazep_zmod_articulos_tipos", " clave_tipo = '$clave_tipo';");}
						$conexion = $this->conectarse();
						if (!@mysql_query($consulta))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;	
								echo "Error: Insertar en la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}	
						else
							{echo "termino-,*-$formulario_final";}
					}
				else
					{
						$clave_tipo = FunGral::_Post("clave_tipo");
						$operacion = FunGral::_Post("operacion");
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion(ap_txt_tit_mod_tipo);
						$ren_art = array();
						if($operacion=="modificar")
							{
								$con_art = "select * from nazep_zmod_articulos_tipos where clave_seccion= '$clave_seccion_enviada'";
								$conexion = $this->conectarse();
								$res_art = mysql_query($con_art);
								$ren_art = mysql_fetch_array($res_art);
							}
						echo '<script type="text/javascript">';	
						echo '$(document).ready(function()
								{
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_modificar_tema");
								});						
							function validar_form(formulario, nombre_formulario)
								{
									if(formulario.nombre.value == "") 
										{
											alert("'.ap_js_3.'");
											formulario.nombre.focus(); 	
											return false;
										}
									if(formulario.cantidad_art_mostrar.value == "") 
										{
											alert("'.ap_js_4.'");
											formulario.cantidad_art_mostrar.focus(); 	
											return false;
										}
									if(formulario.descripcion.value == "") 
										{
											alert("'.ap_js_5.'");
											formulario.descripcion.focus(); 	
											return false;
										}
									formulario.btn_guardar.style.visibility="hidden";
									formulario.formulario_final.value = nombre_formulario;
								}';
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="metodo" value = "modificar_tipo" />';
							echo '<input type="hidden" name="operacion" value = "modificar" />';
						echo '</form>';
						echo '<form name="frm_modificar_tema" id="frm_modificar_tema" method="post"  action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							if($operacion=="modificar")
								{							
									echo '<tr><td width="2%">&nbsp;</td><td>'.user_actua.'</td><td>'.$ren_art["user_actualiza"].'</td></tr>';
									$hora_actualizacion = $ren_art["hora_actualizacion"];
									$fecha_actualizacion = $ren_art["fecha_actualizacion"];
									$fecha_actualizacion = FunGral::fechaNormal($fecha_actualizacion);
									echo '<tr><td width="2%">&nbsp;</td><td>'.fecha_actua.'</td><td>'.$fecha_actualizacion.' a las '.$hora_actualizacion.' Hrs.</td></tr>';
									echo '<tr><td>&nbsp;</td><td>'.ip_actua.'</td><td>'.$ren_art["ip_actualizacion"].'</td></tr>';
								}
								echo '<tr><td>&nbsp;</td><td>'.ap_txt_nom_tipo.'</td><td><input type = "text" name = "nombre" size = "40" value = "'.FunGral::_ValorArray($ren_art,"nombre").'" /></td></tr>';
								echo '<tr><td>&nbsp;</td><td>'.ap_txt_can_list.'</td><td><input type = "text" name = "cantidad_art_mostrar" size = "5" OnKeyPress="return solo_num(event)" value = "'.FunGral::_ValorArray($ren_art,"cantidad_art_mostrar").'"/></td></tr>';
								echo '<tr><td>&nbsp;</td><td>'.ap_txt_des_tipo.'</td><td><textarea name="descripcion" cols="35" rows="5">'.FunGral::_ValorArray($ren_art,"descripcion").'</textarea></td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td bgcolor="#F9D07B" >&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_pos_titulo_lis.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "posicion_titulo_lista">';
											for($a=1;$a<=7; $a++)
												{echo '<option '; if ( ($a == FunGral::_ValorArray($ren_art,"posicion_titulo_lista"))  or (FunGral::_ValorArray($ren_art,"posicion_titulo_lista") =='' and $a==1) ) { echo ' selected="selected" '; } echo ' value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td>&nbsp;</td><td >'.ap_txt_pos_titulo_cuer.'</td><td >';
										echo '<select name = "posicion_titulo_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if (($a == FunGral::_ValorArray($ren_art,"posicion_titulo_cuerpo"))  or (FunGral::_ValorArray($ren_art,"posicion_titulo_cuerpo") =='' and $a==1)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_usa_tem.'</td><td bgcolor="#F9D07B">';									
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'usar_tema','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"usar_tema"), 'orden'=>'no-si' ));									
								echo '</td></tr>';
								echo '<tr><td width="2%">&nbsp;</td><td>'.ap_txt_usa_tem_lis.'</td><td>';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_temas_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_temas_lista"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B" >&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_usa_tem_cue.'</td><td  bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_temas_cuerpo','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_temas_cuerpo"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td>&nbsp;</td><td >'.ap_txt_pos_tema_lis.'</td><td >';
										echo '<select name = "posicion_tema_lista">';
											for($a=1;$a<=7; $a++)
												{echo '<option '; if (($a == FunGral::_ValorArray($ren_art,"posicion_tema_lista"))  or (FunGral::_ValorArray($ren_art,"posicion_tema_lista")=='' and $a==2)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B" >&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_pos_tema_cuer.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "posicion_tema_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if (($a == FunGral::_ValorArray($ren_art,"posicion_tema_cuerpo"))  or (FunGral::_ValorArray($ren_art,"posicion_tema_cuerpo") =='' and $a==2)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td >&nbsp;</td><td>'.ap_txt_per_num_list.'</td><td>';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_numero_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_numero_lista"), 'orden'=>'no-si'));
								
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_per_num.'</td><td bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_numero','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_numero"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_pos_num_lis.'</td><td >';
										echo '<select name = "posicion_numero_lista">';
											for($a=1;$a<=7; $a++)
												{echo '<option '; if ($a == $ren_art["posicion_numero_lista"] or (FunGral::_ValorArray($ren_art,"posicion_numero_lista") =="" and $a==3) ) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B" >&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_pos_num_cuer.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "posicion_numero_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if ($a == $ren_art["posicion_numero_cuerpo"] or (FunGral::_ValorArray($ren_art,"posicion_numero_cuerpo") =="" and $a==3)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_ver_fec_lis.'</td><td >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_fecha_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"ver_fecha_lista"), 'orden'=>'no-si'));
								echo '</td></tr>';
								$arreglo_clave =  FunGral::ArregloClaveFechas();
								$arreglo_nombre = FunGral::ArregloNombreFechas();
								$can_arreglos = count($arreglo_nombre);
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_for_fec_l.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "formato_fecha_lista">';
											for($a=0;$a<$can_arreglos; $a++)
												{
													$tem1 = $arreglo_clave[$a];
													$tem2 = $arreglo_nombre[$a];
													echo '<option '; if ($tem1 == FunGral::_ValorArray($ren_art,"formato_fecha_lista")) { echo ' selected="selected" '; } echo ' value = "'.$tem1.'" >'.$tem2.'</option>';
												}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td>&nbsp;</td><td>'.ap_txt_ver_hor_lis.'</td><td>';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_hora_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"ver_hora_lista"), 'orden'=>'no-si'));
								echo '</td></tr>';	
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_ver_lug_lis.'</td><td bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_lugar_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"ver_lugar_lista"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_ver_fec_cue.'</td><td >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_fecha_cuerpo','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"ver_fecha_cuerpo"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B" >&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_for_fec_c.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "formato_fecha_cuerpo">';
											for($a=0;$a<$can_arreglos; $a++)
												{
													$tem1 = $arreglo_clave[$a];
													$tem2 =  $arreglo_nombre[$a];
													echo '<option '; if ($tem1 == FunGral::_ValorArray($ren_art,"formato_fecha_cuerpo")) { echo ' selected="selected" '; } echo ' value = "'.$tem1.'" >'.$tem2.'</option>';
												}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_ver_hor_cue.'</td><td  >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_hora_cuerpo','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"ver_hora_cuerpo"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_ver_lug_cue.'</td><td  bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_lugar_cuerpo','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"ver_lugar_cuerpo"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_pos_lugfechor_lis.'</td><td >';
										echo '<select name = "posicion_fecha_lugar_lista">';
											for($a=1;$a<=7; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_fecha_lugar_lista") or (FunGral::_ValorArray($ren_art,"posicion_fecha_lugar_lista") =="" and $a==4)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B" >&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_pos_lugfechor_cuer.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "posicion_fecha_lugar_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_fecha_lugar_cuerpo") or (FunGral::_ValorArray($ren_art,"posicion_fecha_lugar_cuerpo") =="" and $a==4)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_tip_res.'</td><td >';
										echo '<input '; if (FunGral::_ValorArray($ren_art,"tipo_resumen_ver")  == 'chico' or FunGral::_ValorArray($ren_art,"tipo_resumen_ver") == "") { echo 'checked="checked"'; } echo ' type="radio" name="tipo_resumen_ver" id ="tipo_resumen_ver_chico"  value="chico"  /> Chico&nbsp;';
										echo '<input '; if (FunGral::_ValorArray($ren_art,"tipo_resumen_ver")  == 'grande') { echo 'checked="checked"'; } echo ' type="radio" name="tipo_resumen_ver" id ="tipo_resumen_ver_grande" value="grande"  /> Grande&nbsp;';																	
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_usa_res_cue.'</td><td  bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_resumen_cuerpo','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_resumen_cuerpo"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_pos_res_lis.'</td><td >';
										echo '<select name = "posicion_resumen_lista">';
											for($a=1;$a<=7; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_resumen_lista") or (FunGral::_ValorArray($ren_art,"posicion_resumen_lista") =="" and $a==5)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_pos_res_cuer.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "posicion_resumen_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_resumen_cuerpo") or (FunGral::_ValorArray($ren_art,"posicion_resumen_cuerpo") =="" and $a==5)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td  width="2%">&nbsp;</td><td >'.ap_txt_per_cuerpo.'</td><td>';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_cuerpo','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_cuerpo"), 'orden'=>'no-si'));
								echo '</td></tr>';
								$partes_enlace_cuerpo = FunGral::_ValorArray($ren_art,"partes_enlace_cuerpo"); 
								$partes_enlace_cuerpo_array = explode(",", $partes_enlace_cuerpo);
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_per_enl_cuerpo.'</td><td bgcolor="#F9D07B">';
										echo '<input '; if ($partes_enlace_cuerpo_array[0] == "1") { echo 'checked="checked"'; } echo 'type="checkbox" name="partes_enlace_cuerpo_tit" id ="partes_enlace_cuerpo_tit" value="1"  /> T&iacute;tulo &nbsp;';
										echo '<input '; if ($partes_enlace_cuerpo_array[1] == "2") { echo 'checked="checked"'; } echo 'type="checkbox" name="partes_enlace_cuerpo_res" id ="partes_enlace_cuerpo_res" value="2"  /> Resumen &nbsp;';
										echo '<input '; if ($partes_enlace_cuerpo_array[2] == "3" or $partes_enlace_cuerpo_array[2] == "" ) { echo 'checked="checked"'; } echo ' type="checkbox" name="partes_enlace_cuerpo_ler" id ="partes_enlace_cuerpo_ler" value="3"  /> Leer m&aacute;s &nbsp;';
										echo '<input '; if ($partes_enlace_cuerpo_array[3] == "4") { echo 'checked="checked"'; } echo ' type="checkbox" name="partes_enlace_cuerpo_num" id ="partes_enlace_cuerpo_num" value="4"   /> N&uacute;mero &nbsp;';
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_pos_cuer_cuer.'</td><td >';
										echo '<select name = "posicion_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if ($a == $ren_art["posicion_cuerpo"] or ($ren_art["posicion_cuerpo"] =="" and $a==6)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td bgcolor="#F9D07B" width="2%">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_per_vis_list.'</td><td bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_visitas_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_visitas_lista"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td width="2%">&nbsp;</td><td >'.ap_txt_per_vis.'</td><td >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_ver_visitas','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_ver_visitas"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_pos_vis_lis.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "posicion_visitas_lista">';
											for($a=1;$a<=7; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_visitas_lista")or (FunGral::_ValorArray($ren_art,"posicion_visitas_lista") =="" and $a==6)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td>&nbsp;</td><td>'.ap_txt_pos_vis_cuer.'</td><td >';
										echo '<select name = "posicion_visitas_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_visitas_cuerpo") or (FunGral::_ValorArray($ren_art,"posicion_visitas_cuerpo") =="" and $a==7)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_per_fe_act_list.'</td><td bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'per_ver_fec_actualiza_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"per_ver_fec_actualiza_lista"), 'orden'=>'no-si'));
								echo '</td></tr>';	
								echo '<tr><td width="2%">&nbsp;</td><td >'.ap_txt_per_fe_act.'</td><td >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'per_ver_fec_actualiza','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"per_ver_fec_actualiza"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_pos_fe_act_lis.'</td><td bgcolor="#F9D07B">';
										echo '<select name = "posicion_fe_act_lista">';
											for($a=1;$a<=7; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_fe_act_lista") or (FunGral::_ValorArray($ren_art,"posicion_fe_act_lista") =="" and $a==7)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td>&nbsp;</td><td>'.ap_txt_pos_fe_act_cuer.'</td><td >';
										echo '<select name = "posicion_fe_act_cuerpo">';
											for($a=1;$a<=8; $a++)
												{echo '<option '; if ($a == FunGral::_ValorArray($ren_art,"posicion_fe_act_cuerpo") or (FunGral::_ValorArray($ren_art,"posicion_fe_act_cuerpo") =="" and $a==8)) { echo ' selected="selected" '; } echo 'value = "'.$a.'" >'.$a.'</option>';}
										echo '</select>';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_per_caducidad.'</td><td bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_caducar','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_caducar"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_per_cal.'</td><td >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_calificar','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_calificar"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_per_com.'</td><td bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_comentarios','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_comentarios"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_per_mod_com.'</td><td >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'moderar_comentarios','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"moderar_comentarios"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B">'.ap_txt_per_com_list.'</td><td bgcolor="#F9D07B">';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'permitir_comentarios_lista','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"permitir_comentarios_lista"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_ver_bus.'</td><td >';
									HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_buscador','ValorSeleccionado'=>FunGral::_ValorArray($ren_art,"ver_buscador"), 'orden'=>'no-si'));
								echo '</td></tr>';
								echo '<tr><td bgcolor="#F9D07B">&nbsp;</td><td bgcolor="#F9D07B" >'.ap_txt_pos_bus.'</td><td bgcolor="#F9D07B" >';
										echo '<input '; if (FunGral::_ValorArray($ren_art,"posicion_buscador") == "arriba") { echo 'checked="checked"'; } echo 'type="radio" name="posicion_buscador" id ="posicion_buscador_arriba" value="arriba"  /> '.arriba.'&nbsp;';
										echo '<input '; if (FunGral::_ValorArray($ren_art,"posicion_buscador")== "abajo"   or FunGral::_ValorArray($ren_art,"posicion_buscador") == "") { echo 'checked="checked"'; } echo 'type="radio" name="posicion_buscador" id ="posicion_buscador_avajo" value="abajo"  /> '.abajo.'&nbsp;';
								echo '</td></tr>';
								echo '<tr><td >&nbsp;</td><td >'.ap_txt_tip_separa.'</td><td >';
										echo '<input '; if (FunGral::_ValorArray($ren_art,"tipo_separacion_lista")  == "linea"  or $ren_art["tipo_separacion_lista"] == "") { echo 'checked="checked"'; } echo 'type="radio" name="tipo_separacion_lista" id ="tipo_separacion_lista_linea" value="linea"   /> L&iacute;nea &nbsp;';
										echo '<input '; if (FunGral::_ValorArray($ren_art,"tipo_separacion_lista")  == "nada") { echo 'checked="checked"'; } echo 'type="radio" name="tipo_separacion_lista" id ="tipo_separacion_lista_nada" value="nada"  /> Ninguna &nbsp;';
								echo '</td></tr>';
								echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';								
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "modificar_tipo" />';
										echo '<input type="hidden" name="operacion" value = "'.$operacion.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
										echo '<input type="hidden" name="clave_tipo" value = "'.FunGral::_ValorArray($ren_art,"clave_tipo").'" />';	
										echo '<input type="submit" name="btn_guardar" value="'.guardar.'"  onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());						
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function nuevo_temas($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_tipo = $_POST["clave_tipo"];
						$clave_seccion = $_POST["clave_seccion"];
						$nombre = addslashes($_POST["nombre"]);
						$nombre = strip_tags($nombre);
						$situacion = $_POST["situacion"];
						$descripcion =  strip_tags(mysql_real_escape_string($_POST["descripcion"]));	
						$inser_tipo = "insert into nazep_zmod_articulos_temas values('', '$clave_tipo','$situacion','$nombre', '$descripcion')";
						$conexion = $this->conectarse();
						if (!@mysql_query($inser_tipo))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: Insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{echo "termino-,*-$formulario_final";}
					}
				else
					{
						$clave_tipo = $_POST["clave_tipo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(ap_txt_tit_nue_tema);
						echo '
							<script type="text/javascript">
							';
						echo ' 
							$(document).ready(function()
								{
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_nuevo_tema");
								});							
							function validar_form(formulario, nombre_formulario)
								{
								
									if(formulario.nombre.value == "") 
										{
											alert("'.ap_js_1.'");
											formulario.nombre.focus(); 	
											return false;
										}
									if(formulario.descripcion.value == "") 
										{
											alert("'.ap_js_2.'");
											formulario.descripcion.focus(); 
											return false;
										}
									formulario.btn_guardar.style.visibility="hidden";
									formulario.btn_guardar2.style.visibility="hidden";
									formulario.formulario_final.value = nombre_formulario;
								} ';
						echo '</script>';
						echo '<form name="regresar_pantalla" id="regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="metodo" value = "nuevo_temas" />';
						echo '</form>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="get" action="index.php" class="margen_cero">
							<input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
						echo '</form>';						
						echo '<form name="frm_nuevo_tema" id="frm_nuevo_tema" method="post"  action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.ap_txt_nom_tema.'</td><td><input type = "text" name = "nombre" size = "40" /></td></tr>';
								echo '<tr><td>'.situacion.'</td><td>';
										echo '<select name = "situacion"><option value = "activo" >'.activo.'</option><option value = "cancelado" >'.cancelado.'</option></select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>'.ap_txt_des_tema.'</td><td><textarea name="descripcion" cols="35" rows="5"></textarea></td></tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "nuevo_temas" />';	
										echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';		
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="submit" name="btn_guardar" value="'.guardar.'"  onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
										echo '<input type="submit" name="btn_guardar2" value="'.guardar_cam_otro.'"  onclick= "return validar_form(this.form, \'regresar_pantalla\')" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function modificar_temas_art($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_tema = $_POST["clave_tema"];
						$nombre = addslashes($_POST["nombre"]);
						$nombre = strip_tags($nombre);
						$situacion = $_POST["situacion"];
						$descripcion = addslashes($_POST["descripcion"]);
						$descripcion = strip_tags($descripcion);
						$clave_seccion = $_POST["clave_seccion"];
						$update = "update nazep_zmod_articulos_temas set nombre = '$nombre', situacion ='$situacion', descripcion = '$descripcion' where clave_tema = '$clave_tema'";
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
				elseif(isset($_POST["clave_tema"]) && $_POST["clave_tema"]!="")
					{	
						$clave_tema = $_POST["clave_tema"];
						$clave_tipo = $_POST["clave_tipo"];
						$conexion = $this->conectarse();
						$con_tipo = "select * from nazep_zmod_articulos_temas where clave_tema = '$clave_tema'";
						$res_tipo = mysql_query($con_tipo);
						$ren_tipo = mysql_fetch_array($res_tipo);
						$situacion = $ren_tipo["situacion"];
						$nombre = $ren_tipo["nombre"];
						$descripcion = $ren_tipo["descripcion"];
						HtmlAdmon::titulo_seccion(ap_txt_tit_mod_tema);
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
								{
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_modificar_tema");
								});							
							function validar_form(formulario, nombre_formulario)
								{
									if(formulario.nombre.value == "") 
										{
											alert("'.ap_js_1.'");
											formulario.nombre.focus(); 
											return false;
										}
									if(formulario.descripcion.value == "") 
										{
											alert("'.ap_js_2.'");
											formulario.descripcion.focus(); 
											return false;
										}
									formulario.btn_guardar.style.visibility="hidden";
									formulario.formulario_final.value = nombre_formulario;
								}';
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="clave_tema" value = "'.$clave_tema.'" />';
							echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
							echo '<input type="hidden" name="metodo" value = "modificar_temas_art" />';
						echo '</form>';
						echo '<form name="frm_modificar_tema" id="frm_modificar_tema" method="post"  action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.ap_txt_nom_tema.'</td><td><input type = "text" name = "nombre" size = "40" value = "'.$nombre.'"/></td></tr>';
								echo '<tr><td>'.situacion.'</td><td>';
										echo '<select name = "situacion">';
											echo '<option value ="activo" '; if ($situacion == "activo") { echo 'selected'; } echo ' >'.activo.'</option>';
											echo '<option value = "cancelado" '; if ($situacion == "cancelado") { echo 'selected'; } echo ' >'.cancelado.'</option>';													
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>'.ap_txt_des_tema.'</td><td><textarea name="descripcion" cols="35" rows="5">'.$descripcion.'</textarea></td></tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "modificar_temas_art" />';	
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
										echo '<input type="hidden" name="clave_tema" value = "'.$clave_tema.'" />';
										echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
										echo '<input type="submit" name="btn_guardar" value="'.guardar.'"  onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>ap_txt_reg_bus_tem,
							'OpcOcultas'=>array('archivo'=>$this->DirArchivo,
							'clase'=>$this->NomClase,'metodo'=>'modificar_temas_art','clave_tipo'=>$clave_tipo)));
					}
				else
					{
						$clave_tipo = $_POST["clave_tipo"];
						$conexion = $this->conectarse();
						$con_tem = "select nombre, clave_tema, situacion from nazep_zmod_articulos_temas where clave_tipo = '$clave_tipo'";
						$res_tem = mysql_query($con_tem);
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						$con_sec = mysql_num_rows($res_tem);
						HtmlAdmon::titulo_seccion("($con_sec) ".ap_txt_tit_bus_tem);
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
							echo'<tr>';
								echo '<td align = "center"><strong>'.ap_txt_nom_tema.'</strong></td>';
								echo '<td align = "center"><strong>'.situacion.'</strong></td>';
								echo '<td align = "center"><strong>'.modificar.'</strong></td>';	
							echo'</tr>';	
							$contador = 0;
							while($ren_total = mysql_fetch_array($res_tem))
								{
									if(($contador%2)==0)
										{ $color = 'bgcolor="#F9D07B"'; }
									else
										{ $color = ''; }
									$nombre = $ren_total["nombre"];
									$clave_tema = $ren_total["clave_tema"];
									$situacion = $ren_total["situacion"];
									echo'<tr>';
										echo '<td align = "center" '.$color.'>'.$nombre.'</td>';
										echo '<td align = "center" '.$color.'>'.$situacion.'</td>';
										echo '<td align = "center" '.$color.'>';
											echo '<form name="buscar_tema_'.$clave_tema.'" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
												echo '<input type="hidden" name="metodo" value = "modificar_temas_art" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="clave_tema" value = "'.$clave_tema.'" />';
												echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
												echo '<input type="submit" name="btn_modificar" value="'.modificar.'" />';
											echo '</form>';
										echo '</td>';
									echo'</tr>';
									$contador++;
								}
						echo '</table><br />';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function crear_articulo($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$nombre_propone = $this->escapar_caracteres($_POST["nombre_propone"]);	
						$nombre_propone = strip_tags($nombre_propone);
						$correo_propone = $_POST["correo_propone"];
						$fecha_inicio = $_POST["ano_i"].'-'.$_POST["mes_i"].'-'.$_POST["dia_i"];
						$fecha_termino = $_POST["ano_t"].'-'.$_POST["mes_t"].'-'.$_POST["dia_t"];
						$clave_tipo = $_POST["clave_tipo"];
						$fecha_articulo = $_POST["ano"].'-'.$_POST["mes"].'-'.$_POST["dia"];
						$lugar_articulo = $this->escapar_caracteres($_POST["lugar_articulo"]);
						$lugar_articulo = strip_tags($lugar_articulo);
						$numero_articulo = $_POST["numero_articulo"];
						$situacion_temporal = $_POST["situacion_temporal"];
						$titulo = $this->escapar_caracteres($_POST["titulo"]);
						$titulo = strip_tags($titulo);
						$resumen_chico = $this->escapar_caracteres($_POST["resumen_chico"]);
						$resumen_grande = $this->escapar_caracteres($_POST["resumen_grande"]);
						$clave_tema = $_POST["clave_tema"];
						$cuerpo = $this->escapar_caracteres($_POST["cuerpo"]);
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$clave_seccion = $_POST["clave_seccion"];	
						if($correo_propone=='')
							{$correo_propone = $cor_user;}
						if($nombre_propone=='')
							{$nombre_propone = $nom_user;}
						$nombre_propone = strip_tags($nombre_propone);
						if($situacion_temporal=='nuevo')
							{$cadena_adicional =  " '','','','', '0000-00-00','00:00:00', ";}
						elseif($situacion_temporal=='activo')
							{$cadena_adicional =  " '$nick_user', '$nombre_propone', '$correo_propone','$ip','$fecha_hoy','$hora_hoy', ";}
						$conexion = $this->conectarse();
						$insertar_1 ="insert into nazep_zmod_articulos 
						(clave_tipo, situacion, user_creacion, nombre_creacion, correo_creacion, ip_creacion, fecha_creacion, hora_creacion,
						user_actualiza, nombre_actualiza, correo_actualiza, ip_actualizacion, fecha_actualizacion, hora_actualizacion, 
						fecha_inicio, fecha_fin, fecha_articulo, lugar_articulo,
						titulo, numero_articulo, resumen_chico, resumen_grande,  visitas, cantidad_votos, votos, clave_tema) values
						('$clave_tipo', '$situacion_temporal', '$nick_user','$nombre_propone', '$correo_propone','$ip','$fecha_hoy','$hora_hoy',
						".$cadena_adicional."
						'$fecha_inicio', '$fecha_termino', '$fecha_articulo', '$lugar_articulo','$titulo','$numero_articulo', '$resumen_chico','$resumen_grande','0','0','0' , '$clave_tema')";
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insertar_1))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}
						else
							{
								if($situacion_temporal=='nuevo')
									{$cadena_adicional2 = " '', '', '', '', '0000-00-00', '00:00:00', '', ";}
								elseif($situacion_temporal=="activo")
									{$cadena_adicional2 = " '$nick_user', '$nombre_propone', '$correo_propone', 'Nueva art�culo', '$fecha_hoy','$hora_hoy', '$ip', ";}
								$paso = true;
								$clave_articulo_db = mysql_insert_id();
								$insertar_2 = "insert into nazep_zmod_articulos_cambios (clave_articulo, situacion,
								user_propone, nombre_propone, correo_propone, motivo_propone, fecha_propone, hora_propone, ip_poropone,
								user_decide, nombre_decide, correo_decide, motivo_decide, fecha_decide, hora_decide, ip_decide, 
								nuevo_situacion, nuevo_fecha_inicio, nuevo_fecha_fin, nuevo_fecha_articulo, 
								nuevo_lugar_articulo, nuevo_titulo, nuevo_numero_articulo,nuevo_resumen_chico,nuevo_resumen_grande,nuevo_clave_tema,
								anterior_situacion, anterior_fecha_inicio, anterior_fecha_fin, anterior_fecha_articulo, 
								anterior_lugar_articulo, anterior_titulo, anterior_numero_articulo, anterior_resumen_chico, 
								anterior_resumen_grande, anterior_clave_tema) values ('$clave_articulo_db','$situacion_temporal',
								'$nick_user', '$nombre_propone', '$correo_propone', 'Nueva art�culo', '$fecha_hoy','$hora_hoy', '$ip',
								".$cadena_adicional2."
								'nuevo', '$fecha_inicio', '$fecha_termino', '$fecha_articulo',
								'$lugar_articulo','$titulo','$numero_articulo', '$resumen_chico','$resumen_grande','$clave_tema',
								'nuevo', '$fecha_inicio', '$fecha_termino', '$fecha_articulo',
								'$lugar_articulo','$titulo','$numero_articulo', '$resumen_chico','$resumen_grande','$clave_tema')";
								if (!@mysql_query($insertar_2))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}
								else
									{
										$paso = true;
										$clave_articulo_cambios_db = mysql_insert_id();
										$insertar_3 = "insert into nazep_zmod_articulos_paginas 
										(clave_articulo, situacion, pagina, texto) values ('$clave_articulo_db','$situacion_temporal','1', '$cuerpo')";
										if (!@mysql_query($insertar_3))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 3;
											}
										else
											{
												$paso = true;
												$clave_articulo_pagina_db = mysql_insert_id();
												$insertar_4 = "insert into nazep_zmod_articulos_paginas_cambios (clave_articulo_cambios, clave_articulo_pagina, 
												nuevo_situacion, nuevo_pagina, nuevo_texto,anterior_situacion, anterior_pagina, anterior_texto)
												values ('$clave_articulo_cambios_db','$clave_articulo_pagina_db','$situacion_temporal','1', '$cuerpo', '$situacion_temporal','1', '$cuerpo')";
												if (!@mysql_query($insertar_4))
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
							{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}	
						$this->desconectarse($conexion);
					}
				else
					{
						$clave_tipo= $_POST["clave_tipo"];
						$con_tipo ="select usar_tema, permitir_caducar from nazep_zmod_articulos_tipos where clave_tipo = '$clave_tipo'";
						$conexion = $this->conectarse();
						$res_tipo = mysql_query($con_tipo);
						$ren_tipo = mysql_fetch_array($res_tipo);
						$usar_tema = $ren_tipo["usar_tema"]; 
						$permitir_caducar = $ren_tipo["permitir_caducar"]; 
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(ap_txt_tit_nue_art);						
						$variable_archivos = directorio_archivos."$clave_seccion_enviada/";
						$_SESSION["direccion_archivos"] = $variable_archivos;
						echo '
							<script type="text/javascript">
						 	$(document).ready(function()
								{
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_nuevo_articulo");
								});
							function validar_form(formulario, valor_temporal, nombre_formulario)
								{
									formulario.situacion_temporal.value = valor_temporal;
									if(formulario.nombre_propone.value.length > "240") 
										{
											alert("'.ap_js_6.'");
											formulario.nombre_propone.focus(); 
											return false;
										}
									if(formulario.correo_propone.value.length > "240") 
										{
											longitud_campo = formulario.correo_propone.value.length;
											alert("'.ap_js_7.'");
											formulario.correo_propone.focus(); 
											return false;
										}
									separador = "/";
									fecha = formulario.dia.value+"/"+formulario.mes.value+"/"+formulario.ano.value;
									if(!verificar_fecha(fecha, separador))
										{
											alert("'.ap_js_8.'");
											formulario.dia.focus(); 
											return false;
										}  ';
									if($permitir_caducar=="si")
										{
										echo ' fecha_ini = formulario.dia_i.value+"/"+formulario.mes_i.value+"/"+formulario.ano_i.value;
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
												} ';
										}
									if($usar_tema=='si')
										{
											echo 'if (formulario.clave_tema.selectedIndex==0){
														   alert("'.ap_js_9.'")
														   formulario.clave_tema.focus()
														   return false;
														}';
										}
									echo ' 
									valor_titulo = FCKeditorAPI.__Instances[\'titulo\'].GetHTML();
									alert("cc-"+valor_titulo+"-");
									formulario.titulo.value = valor_titulo; 
									if(formulario.titulo.value == "&nbsp;") 
										{
											alert("'.ap_js_10.'");
											location.href="#titulo_link";
											return false;
										}
									valor_resumen = FCKeditorAPI.__Instances[\'resumen_chico\'].GetHTML();
									formulario.resumen_chico.value = valor_resumen;
									if(formulario.resumen_chico.value == "&nbsp;") 
										{
											alert("'.ap_js_11.'");
											location.href="#resumen_chico_link";	
											return false;
										}
									valor_resumen_grande = FCKeditorAPI.__Instances[\'resumen_grande\'].GetHTML();
									formulario.resumen_grande.value = valor_resumen_grande; 
									valor_cuerpo = FCKeditorAPI.__Instances[\'cuerpo\'].GetHTML();
									formulario.cuerpo.value = valor_cuerpo;
									formulario.btn_guardar1.style.visibility = "hidden";  ';
								if($nivel == 1 or $nivel == 2)
									{
										echo ' formulario.btn_guardar2.style.visibility = "hidden"; 
										formulario.btn_guardar3.style.visibility = "hidden";';
									}
								echo ' formulario.formulario_final.value = nombre_formulario;
									} ';
						echo '</script>';
						echo '<form name="regresar_pantalla" id="regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="metodo" value = "crear_articulo" />';
							echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
						echo '</form>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="get" action="index.php" class="margen_cero">
						<input type="hidden" name="opc" value = "11" /><input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
						echo '</form>';
						echo '<form name="frm_nuevo_articulo" id="frm_nuevo_articulo" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';						
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								$con_tipos ="select clave_tipo, nombre from  nazep_zmod_articulos_tipos where clave_seccion = '$clave_seccion_enviada'";
								$conexion = $this->conectarse();
								$res_tipos = mysql_query($con_tipos);
								$ren_tipos = mysql_fetch_array($res_tipos);
								$clave_tipo = $ren_tipos["clave_tipo"];
								$nombre = $ren_tipos["nombre"];
								echo '<tr><td>'.ap_txt_tip_art.'</td><td><input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />'.$nombre.'</td></tr>';
								echo '<tr><td>'.ap_txt_pers_pro.'</td><td><input type = "text" name = "nombre_propone" size = "60" /></td></tr>';
								echo '<tr><td>'.ap_txt_cor_pro.'</td><td><input type = "text" name = "correo_propone" size = "60" /></td></tr>';
								if($permitir_caducar=="si")
									{
										echo '<tr><td>'.fecha_ini_vig.'</td><td>';
												$dia=date('d');
												$mes=date('m');
												$ano=date('Y');
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name = "dia_i">';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected="selected"'; } echo ' > '.$a.' </option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_i">';
												for ($b=1; $b<=12; $b++)
													{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'.$areglo_meses[$b].'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_i">';
												for ($b=$ano-10; $b<=$ano+10; $b++)
													{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>'.fecha_fin_vig.'</td><td>';
												echo dia.'&nbsp;<select name = "dia_t">';
												for ($a = 1; $a<=31; $a++)
													{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' >'.$a.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes_t">';
													for ($b=1; $b<=12; $b++)
														{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano_t">';
													for ($b=$ano-10; $b<=$ano+10; $b++)
														{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '> '.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									}
								echo '<tr><td bgcolor="#999798" height="3"></td>';
								if($permitir_caducar=='no')
									{	
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										echo '<input type="hidden" name="dia_i" value = "'.$dia.'" /><input type="hidden" name="mes_i" value = "'.$mes.'" /><input type="hidden" name="ano_i" value = "'.$ano.'" />';
										echo '<input type="hidden" name="dia_t" value = "'.$dia.'" /><input type="hidden" name="mes_t" value = "'.$mes.'" /><input type="hidden" name="ano_t" value = "'.$ano.'" />';
									}
								if($usar_tema=='no')
									{echo '<input type="hidden" name="clave_tema" value = "0" />';}
								echo '<td bgcolor="#999798" ></td><td bgcolor="#999798" ></td></tr>';
								if($usar_tema=='si')
									{
										$con_temas = "select nombre, clave_tema from nazep_zmod_articulos_temas where clave_tipo = '$clave_tipo' and situacion = 'activo'";
										$res_temas = mysql_query($con_temas);
										echo '<tr><td>'.ap_txt_tem_art.'</td><td>';
												echo '<select name = "clave_tema">';
													echo '<option value = "0" >'.seleccione.'</option>';
													while($ren_temas = mysql_fetch_array($res_temas))
														{
															$nombre = $ren_temas["nombre"];
															$clave_tema = $ren_temas["clave_tema"];
															echo '<option value = "'.$clave_tema.'" >'.$nombre.'</option>';
														}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									}
								echo '<tr><td>'.ap_txt_fec_art.'</td><td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										$arreglo_meses = FunGral::MesesNumero();
										echo dia.'&nbsp;<select name = "dia">';
										for ($d = 1; $d<=31; $d++)
											{echo '<option value = "'.$d.'" '; if ($dia == $d) { echo ' selected="selected" '; } echo ' >'.$d.'</option>';}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes">';
										for ($m=1; $m<=12; $m++)
											{echo '<option value = "'.$m.'"  ';  if ($mes == $m) {echo ' selected="selected" ';}  echo ' >'. $arreglo_meses[$m] .' </option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano">';
											for ($a=$ano-10; $a<=$ano+10; $a++)
												{echo '<option value = "'.$a.'" '; if ($ano == $a) {echo ' selected="selected" ';} echo '>'.$a.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>'.ap_txt_lug_art.'</td><td><input type = "text" name = "lugar_articulo" size = "60" /></td></tr>';
								echo '<tr><td>'.ap_txt_num_art.'</td><td><input type = "text" name = "numero_articulo" size = "5" OnKeyPress="return solo_num(event)" /></td></tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td align="center"><a name="titulo_link" id="titulo_link"></a><strong>'.ap_txt_tit_art.'</strong></td></tr>';
								echo '<tr><td>';
									$oFCKeditor1 = new FCKeditor("titulo") ;
									$oFCKeditor1->BasePath = "../librerias/fckeditor/";
									$oFCKeditor1->ToolbarSet = "texto_simple";
									$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
									$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
									$oFCKeditor1->Config['EnterMode'] = '<br>';
									$oFCKeditor1->Width = "100%";
									$oFCKeditor1->Height = "90";
									$oFCKeditor1->Value = '&nbsp;';	
									$oFCKeditor1->Create();
								echo '</td></tr>';
								echo '<tr><td align="center"><a name="resumen_chico_link" id="resumen_chico_link"></a><strong>'.ap_txt_resc_art.'</strong></td></tr>';
								echo '<tr><td>';
									$oFCKeditor22 = new FCKeditor("resumen_chico") ;
									$oFCKeditor22->BasePath = "../librerias/fckeditor/";
									$oFCKeditor22->ToolbarSet = "Default";
									$oFCKeditor22->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
									$oFCKeditor22->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
									$oFCKeditor22->Config['EnterMode'] = '<br>';
									$oFCKeditor22->Width = "100%";
									$oFCKeditor22->Height = "250";
									$oFCKeditor22->Value = '&nbsp;';	
									$oFCKeditor22->Create();
								echo '</td></tr>';
								echo '<tr><td align="center"><a name="resumen_grande_link" id="resumen_grande_link"></a><strong>'.ap_txt_resg_art.'</strong></td></tr>';
								echo '<tr><td>';
									$oFCKeditor2 = new FCKeditor("resumen_grande") ;
									$oFCKeditor2->BasePath = "../librerias/fckeditor/";
									$oFCKeditor2->ToolbarSet = "Default";
									$oFCKeditor2->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
									$oFCKeditor2->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
									$oFCKeditor2->Width = "100%";
									$oFCKeditor2->Height = "250";
									$oFCKeditor2->Value = '&nbsp;';
									$oFCKeditor2->Create();
								echo '</td></tr>';
								echo '<tr><td align="center"><a name="cuerpo_link" id="cuerpo_link"></a><strong>'.ap_txt_cuer_art.'</strong></td></tr>';
								echo '<tr><td>';
									$oFCKeditor3 = new FCKeditor("cuerpo") ;
									$oFCKeditor3->BasePath = "../librerias/fckeditor/";
									$oFCKeditor3->ToolbarSet = "Default";
									$oFCKeditor3->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
									$oFCKeditor3->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
									$oFCKeditor3->Width = "100%";
									$oFCKeditor3->Height = "450";
									$oFCKeditor3->Value = '&nbsp;';
									$oFCKeditor3->Create();
								echo '</td></tr>';
							echo '</table>';
							echo '<input type="hidden" name="formulario_final" value = "" />';	
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="metodo" value = "crear_articulo" />';
							echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';	
							echo '<input type="hidden" name="guardar" value = "si" />';
							echo '<input type="hidden" name="situacion_temporal" value = "nuevo" />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td align="center"><input type="submit" name="btn_guardar1" value="'.guardar.'" onclick= "return validar_form(this.form,\'nuevo\', \'recargar_pantalla\')" /></td>';
									if($nivel == "1" or $nivel == "2")
										{echo '<td align="center"><input type="submit" name="btn_guardar2" value="'.guardar_puliblicar.'" onclick= "return validar_form(this.form,\'activo\', \'recargar_pantalla\')" /></td>';}
							echo '</tr></table>';
							if($nivel == "1" or $nivel == "2")
								{echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td align="center"><input type="submit" name="btn_guardar3" value="'.guardar_pub_otro.'" onclick= "return validar_form(this.form,\'activo\', \'regresar_pantalla\')" /></td></tr></table>';}
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
		function modificar_articulo($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{ 
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_articulo = $_POST["clave_articulo"];
						$nombre_propone = $this->escapar_caracteres($_POST["nombre_propone"]);		
						$nombre_propone = strip_tags($nombre_propone);
						$correo_propone = $_POST["correo_propone"];
						$motivo = $this->escapar_caracteres($_POST["motivo"]);
						$motivo = strip_tags($motivo);
						$situacion = $_POST["situacion"];
						$fecha_inicio = $_POST["ano_i"].'-'.$_POST["mes_i"].'-'.$_POST["dia_i"];
						$fecha_termino = $_POST["ano_t"].'-'.$_POST["mes_t"].'-'.$_POST["dia_t"];	
						$fecha_articulo = $_POST["ano"].'-'.$_POST["mes"].'-'.$_POST["dia"];
						$lugar_articulo = $this->escapar_caracteres($_POST["lugar_articulo"]);
						$lugar_articulo = strip_tags($lugar_articulo);
						$numero_articulo = $_POST["numero_articulo"];
						$situacion_temporal = $_POST["situacion_temporal"];
						$titulo = $this->escapar_caracteres($_POST["titulo"]);
						$titulo = strip_tags($titulo);
						$resumen_chico = $this->escapar_caracteres($_POST["resumen_chico"]);
						$resumen_grande = $this->escapar_caracteres($_POST["resumen_grande"]);
						$paginas = $_POST["paginas"];
						$clave_seccion = $_POST["clave_seccion"];
						$clave_tema = $_POST["clave_tema"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						if($correo_propone=="")
							{$correo_propone = $cor_user;}
						if($nombre_propone=="")
							{$nombre_propone = $nom_user;}
						$nombre_propone = strip_tags($nombre_propone);
						if($situacion_temporal=="pendiente")
							{$cadena_adicional = " '', '', '', '', '0000-00-00', '00:00:00', '', ";}
						elseif($situacion_temporal=="activo")
							{	$cadena_adicional =  " '$nick_user', '$nombre_propone', '$correo_propone', '$motivo', '$fecha_hoy', '$hora_hoy', '$ip', ";}
						$insert = "insert into nazep_zmod_articulos_cambios 
						(clave_articulo, situacion, user_propone, nombre_propone, correo_propone, motivo_propone, fecha_propone, hora_propone, ip_poropone, 
						user_decide, nombre_decide, correo_decide, motivo_decide, fecha_decide, hora_decide, ip_decide, 
						
						nuevo_situacion, nuevo_fecha_inicio, nuevo_fecha_fin, nuevo_fecha_articulo, nuevo_lugar_articulo,
						nuevo_titulo, nuevo_numero_articulo, nuevo_resumen_chico,nuevo_resumen_grande,nuevo_clave_tema, 
						
						anterior_situacion, anterior_fecha_inicio, anterior_fecha_fin, anterior_fecha_articulo, anterior_lugar_articulo,
						anterior_titulo, anterior_numero_articulo, anterior_resumen_chico, anterior_resumen_grande, anterior_clave_tema)
						
						select 
						'$clave_articulo', '$situacion_temporal', '$nick_user', '$nombre_propone', '$correo_propone', '$motivo', '$fecha_hoy', '$hora_hoy', '$ip', 
						".$cadena_adicional."
						'$situacion', '$fecha_inicio', '$fecha_termino','$fecha_articulo', '$lugar_articulo',
						'$titulo','$numero_articulo', '$resumen_chico','$resumen_grande','$clave_tema',
						
						situacion, fecha_inicio, fecha_fin, fecha_articulo, lugar_articulo, 
						titulo, numero_articulo, resumen_chico, resumen_grande, clave_tema from nazep_zmod_articulos where clave_articulo = '$clave_articulo'";
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insert))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;	
								$clave_articulo_cambios_db = mysql_insert_id();
								for($a=1;$a<=$paginas;$a++)
									{
										$clave_articulo_pagina = $_POST["clave_articulo_pagina_".$a];
										$pagina = $_POST["pagina_".$a];
										$texto  = $this->escapar_caracteres($_POST["conte_texto_".$a]);
										$situacion_p = $_POST["situacion_".$a];		
										$insert_2 = "insert into nazep_zmod_articulos_paginas_cambios 
										(clave_articulo_cambios, clave_articulo_pagina, nuevo_situacion, nuevo_pagina, nuevo_texto, 
										anterior_situacion, anterior_pagina, anterior_texto) select '$clave_articulo_cambios_db','$clave_articulo_pagina', 
										'$situacion_p', '$pagina', '$texto', situacion, pagina, texto  from nazep_zmod_articulos_paginas where clave_articulo_pagina = '$clave_articulo_pagina'";
										if (!@mysql_query($insert_2))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = '2_'.$a;
												
											}	
										else
											{$paso = true;}
									}
								if($situacion_temporal=="activo")
									{
										$update1 = "update nazep_zmod_articulos 
										set situacion = '$situacion', user_actualiza = '$nick_user', nombre_actualiza = '$nombre_propone', correo_actualiza = '$correo_propone',
										 ip_actualizacion = '$ip', fecha_actualizacion = '$fecha_hoy',
										hora_actualizacion = '$hora_hoy', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_termino', fecha_articulo = '$fecha_articulo', 
										lugar_articulo = '$lugar_articulo',
										titulo = '$titulo', numero_articulo = '$numero_articulo', resumen_chico = '$resumen_chico', resumen_grande = '$resumen_grande',
										clave_tema = '$clave_tema' where clave_articulo = '$clave_articulo'";
										if (!@mysql_query($update1))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 3;
											}
										else
											{
												$paso = true;
												for($a=1;$a<=$paginas;$a++)
													{
														$clave_articulo_pagina = $_POST["clave_articulo_pagina_".$a];	
														$pagina = $_POST["pagina_".$a];
														$texto  = $this->escapar_caracteres($_POST["conte_texto_".$a]);
														$situacion_p1 = $_POST["situacion_".$a];	
														$update2 = "update nazep_zmod_articulos_paginas set situacion = '$situacion_p1', pagina = '$pagina', texto = '$texto' where clave_articulo_pagina = '$clave_articulo_pagina'";
														if (!@mysql_query($update2))
															{
																$men = mysql_error();
																mysql_query("ROLLBACK;");
																$paso = false;
																$error =  '4_'.$a;
															}
														else
															{$paso = true;}
													}
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
				elseif(isset($_POST["articulo"]) && $_POST["articulo"]=="si")
					{
						$clave_tipo= $_POST["clave_tipo"];
						$con_tipo ="select usar_tema, permitir_caducar from nazep_zmod_articulos_tipos where clave_tipo = '$clave_tipo'";
						$conexion = $this->conectarse();
						$res_tipo = mysql_query($con_tipo);
						$ren_tipo = mysql_fetch_array($res_tipo);
						$usar_tema = $ren_tipo["usar_tema"]; 
						$permitir_caducar = $ren_tipo["permitir_caducar"];
						$clave_articulo = $_POST["clave_articulo"];
						$fecha_articulo_i = $_POST["fecha_articulo_i"];
						$fecha_articulo_t = $_POST["fecha_articulo_t"];
						$clave_tipo = $_POST["clave_tipo"];
						list($ano_i_b, $mes_i_b, $dia_i_b) = explode('-',$fecha_articulo_i);
						list($ano_t_b, $mes_t_b, $dia_t_b) = explode('-',$fecha_articulo_t);
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("Modificar un Art&iacute;culo");	
						$consulta_pendiente ="select clave_articulo_cambios from nazep_zmod_articulos_cambios where clave_articulo = '$clave_articulo' and (situacion = 'pendiente' or situacion = 'nuevo' or situacion= 'nueva_pagina')";
						$conexion = $this->conectarse();
						$res_pendiente = mysql_query($consulta_pendiente);
						$can_pendiente = mysql_num_rows($res_pendiente);
						if($can_pendiente!='')
							{
								echo '<br /><table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center"><tr><td align = "center">'.ap_txt_tiene_cambio_pen.'</td><tr></table>';
								HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>reg_res_bus,
									'OpcOcultas'=>array('archivo'=>$this->DirArchivo, 'clase'=>$this->NomClase,'metodo'=>'modificar_articulo', 'articulo'=>'si',
									'clave_articulo'=>$clave_articulo, 'ano_i_b'=>$ano_i_b, 'mes_i_b'=>$mes_i_b,'dia_i_b'=>$dia_i_b,
									'ano_t_b'=>$ano_t_b, 'mes_t_b'=>$mes_t_b,'dia_t_b'=>$dia_t_b, 'clave_tipo'=>$clave_tipo, 'usar_tema'=>$usar_tema)));
							}
						else
							{
								$con_articulo_total ="select a.situacion, a.fecha_articulo, a.lugar_articulo, a.titulo, a.numero_articulo,  
								a.fecha_inicio, a.fecha_fin, a.resumen_chico, a.resumen_grande, at.nombre as nombre_tipo, a.clave_tema
								from nazep_zmod_articulos a, nazep_zmod_articulos_tipos  at where clave_articulo = '$clave_articulo' and a.clave_tipo = at.clave_tipo";
								$res_articulo = mysql_query($con_articulo_total);
								$ren_articulo = mysql_fetch_array($res_articulo);
								$situacion = $ren_articulo["situacion"];
								$fecha_articulo = $ren_articulo["fecha_articulo"];
								list($ano, $mes, $dia) = explode('-',$fecha_articulo);
								$lugar_articulo = stripslashes($ren_articulo["lugar_articulo"]);
								$titulo = stripslashes($ren_articulo["titulo"]);
								$numero_articulo = $ren_articulo["numero_articulo"];
								$fecha_inicio = $ren_articulo["fecha_inicio"];
								list($ano_i, $mes_i, $dia_i) = explode('-',$fecha_inicio);
								$fecha_fin = $ren_articulo["fecha_fin"];
								list($ano_t, $mes_t, $dia_t) = explode('-',$fecha_fin);
								$resumen_chico = stripslashes($ren_articulo["resumen_chico"]);
								$resumen_grande = stripslashes($ren_articulo["resumen_grande"]);
								$nombre_tipo = $ren_articulo["nombre_tipo"];
								$clave_tema = $ren_articulo["clave_tema"];
								$variable_archivos = directorio_archivos."$clave_seccion_enviada/";
								$_SESSION["direccion_archivos"] = $variable_archivos;	
								echo '<script type="text/javascript">';	
								echo ' $(document).ready(function()
										{
											$.frm_elem_color("#FACA70","");
											$.guardar_valores("frm_modificar_articulo");
										});
									function validar_form(formulario, situacion_temporal_f, nombre_formulario)
										{
											formulario.situacion_temporal.value = situacion_temporal_f;
											formulario.formulario_final.value = nombre_formulario;											
											if(formulario.nombre_propone.value.length > "240") 
												{
													alert("'.ap_js_6.'");
													formulario.nombre_propone.focus(); 
													return false;
												}
											if(formulario.correo_propone.value.length > "240") 
												{
													longitud_campo = formulario.correo_propone.value.length;
													alert("'.ap_js_7.'");
													formulario.correo_propone.focus(); 
													return false;
												}
											if(formulario.motivo.value == "") 
												{
													alert("'.jv_campo_motivo.'");
													formulario.motivo.focus(); 	
													return false;
												}
											
											separador = "/";	
											fecha = formulario.dia.value+"/"+formulario.mes.value+"/"+formulario.ano.value;
											if(!verificar_fecha(fecha, separador))
												{
													alert("'.ap_js_8.'");
													formulario.dia.focus(); 
													return false;
												}
											';	
										if($permitir_caducar=='si')
											{
												echo ' fecha_ini = formulario.dia_i.value+"/"+formulario.mes_i.value+"/"+formulario.ano_i.value;
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
														} ';
											}
										if($usar_tema=='si')
											{
												echo ' if (formulario.clave_tema.selectedIndex==0){
															   alert("'.ap_js_9.'")
															   formulario.clave_tema.focus();
															   return false;
															} ';
											}
										$cons_con_detalle_paginas = "select clave_articulo_pagina from nazep_zmod_articulos_paginas
										where clave_articulo = '$clave_articulo' order by pagina";
										$res_con_detalle_paginas = mysql_query($cons_con_detalle_paginas);
										$can_paginas = mysql_num_rows($res_con_detalle_paginas);
										for($aa = 1; $aa<=$can_paginas; $aa++)
											{
												echo ' valor_pag_'.$aa.' = FCKeditorAPI.__Instances[\'conte_texto_'.$aa.'\'].GetHTML();
														formulario.conte_texto_'.$aa.'.value = valor_pag_'.$aa.'; ';
											}
										echo '
											valor_titulo = FCKeditorAPI.__Instances[\'titulo\'].GetHTML();
											formulario.titulo.value = valor_titulo; 
											if(formulario.titulo.value == "") 
												{
													alert("'.ap_js_10.'");
													location.href=\'#titulo_link\';	
													return false;
												}
											valor_resumen = 		FCKeditorAPI.__Instances[\'resumen_chico\'].GetHTML();
											formulario.resumen_chico.value = valor_resumen; 
											if(formulario.resumen_chico.value == "") 
												{
													alert("'.ap_js_11.'");
													location.href=\'#resumen_chico_link\';	
													return false;
												}
											formulario.btn_guardar1.style.visibility="hidden";	
											document.agregar_pagina.btn_agregar_pagina.style.visibility="hidden"; ';
										if($nivel == 1 or $nivel == 2)
											{
										echo 'formulario.btn_guardar2.style.visibility="hidden";';
											}
										echo '										
										}';
								echo '</script>';
								echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
									echo '<input type="hidden" name="metodo" value = "modificar_articulo" />';	
									echo '<input type="hidden" name="articulo" value = "si" />';
									echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
									echo '<input type="hidden" name="fecha_articulo_i" value = "'.$fecha_articulo_i.'" />';
									echo '<input type="hidden" name="fecha_articulo_t" value = "'.$fecha_articulo_t.'" />';	
									echo '<input type="hidden" name="clave_tipo" value ="'.$clave_tipo.'" />';
									echo '<input type="hidden" name="usar_tema" value = "'.$usar_tema.'" />';
								echo '</form>';	
								echo '<form name="regresar_pantalla" id="regresar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
									echo '<input type="hidden" name="metodo" value = "modificar_articulo" />';
									echo '<input type="hidden" name="buscar" value ="si" />';
									echo '<input type="hidden" name="ano_i" value ="'.$ano_i_b.'" />';
									echo '<input type="hidden" name="mes_i" value ="'.$mes_i_b.'" />';
									echo '<input type="hidden" name="dia_i" value ="'.$dia_i_b.'" />';
									echo '<input type="hidden" name="ano_t" value ="'.$ano_t_b.'" />';
									echo '<input type="hidden" name="mes_t" value ="'.$mes_t_b.'" />';
									echo '<input type="hidden" name="dia_t" value ="'.$dia_t_b.'" />';
									echo '<input type="hidden" name="clave_tipo" value ="'.$clave_tipo.'" />';
									echo '<input type="hidden" name="usar_tema" value = "'.$usar_tema.'" />';
								echo '</form>';
								echo '<form name="frm_modificar_articulo" id="frm_modificar_articulo" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>'.persona_cambio.'</td><td><input type = "text" name = "nombre_propone" size = "60" /></td></tr>';
										echo '<tr><td>'.correo_cambio.'</td><td><input type = "text" name = "correo_propone" size = "60" /></td></tr>';
										echo '<tr><td>'.motivo_cambio.'</td><td><textarea name="motivo" cols="45" rows="5"></textarea></td></tr>';
										echo '<tr><td>'.situacion.'</td><td>';
												echo '<select name = "situacion">1';
													echo '<option value ="activo"  '; if ($situacion == "activo") { echo ' selected="selected" '; } echo ' >'.activo.'</option>';
													echo '<option value = "cancelado"  '; if ($situacion == "cancelado") { echo ' selected="selected" '; } echo ' >'.cancelado.'</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';	
										if($permitir_caducar=="si")
											{
												echo '<tr><td>'.fecha_ini_vig.'</td><td>';
														$areglo_meses = FunGral::MesesNumero();
														echo dia.'&nbsp;<select name = "dia_i">';
														for ($a = 1; $a<=31; $a++)
															{echo '<option value = "'.$a.'" '; if ($dia_i == $a) { echo 'selected="selected"'; } echo ' >'.$a.' </option>';}
														echo '</select>&nbsp;';
														echo mes.'&nbsp;<select name = "mes_i">';
															for ($b=1; $b<=12; $b++)
																{echo '<option value = "'.$b.'"  '; if ($mes_i == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
														echo '</select>&nbsp;';
														echo ano.'&nbsp;<select name = "ano_i">';
															for ($b=$ano-10; $b<=$ano_i+10; $b++)
																{echo '<option value = "'.$b.'\" '; if ($ano_i == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
														echo '</select>';
													echo '</td>';
												echo '</tr>';
												echo '<tr>';
													echo '<td>'.fecha_fin_vig.'</td>';
													echo '<td>';
														echo dia.'&nbsp;<select name = "dia_t">';
														for ($a = 1; $a<=31; $a++)
															{echo '<option value = "'.$a.'" '; if ($dia_t == $a) { echo ' selected="selected" '; } echo ' > '.$a.' </option>';}
														echo '</select>&nbsp;';
														echo mes.'&nbsp;<select name = "mes_t">';
															for ($b=1; $b<=12; $b++)
																{echo '<option value = "'.$b.'"  '; if ($mes_t == $b) {echo ' selected="selected" ';} echo ' >'. $areglo_meses[$b] .'</option>';}
														echo '</select>&nbsp;';
														echo ano.'&nbsp;<select name = "ano_t">';
															for ($b=$ano-10; $b<=$ano_t+10; $b++)
																{echo '<option value = "'.$b.'" '; if ($ano_t == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
														echo '</select>';
													echo '</td>';
												echo '</tr>';
											}
										echo '<tr><td bgcolor="#999798" height="3"></td><td bgcolor="#999798" >';
										if($permitir_caducar=="no")
											{	
												echo '<input type="hidden" name="dia_i" value = "'.$dia_i.'" />';
												echo '<input type="hidden" name="mes_i" value = "'.$mes_i.'" />';
												echo '<input type="hidden" name="ano_i" value = "'.$ano_i.'" />';
												echo '<input type="hidden" name="dia_t" value = "'.$dia_t.'" />';
												echo '<input type="hidden" name="mes_t" value = "'.$mes_t.'" />';
												echo '<input type="hidden" name="ano_t" value = "'.$ano_t.'" />';
											}
										if($usar_tema=="no")
											{echo '<input type="hidden" name="clave_tema" value = "0" />';}
										echo '</td><td bgcolor="#999798" ></td></tr>';
										if($usar_tema=="si")
											{
												$con_temas = "select nombre, clave_tema from nazep_zmod_articulos_temas where clave_tipo = '$clave_tipo' and situacion = 'activo'";
												$res_temas = mysql_query($con_temas);
												echo '<tr><td>'.ap_txt_tem_art.'</td><td>';
														echo '<select name = "clave_tema">';
															echo '<option value = "0" >'.seleccione.'</option>';
															while($ren_temas = mysql_fetch_array($res_temas))
																{
																	$nombre = $ren_temas["nombre"];
																	$clave_tema_b = $ren_temas["clave_tema"];
																	echo '<option value = "'.$clave_tema_b.'"';
																	 if ($clave_tema_b == $clave_tema) { echo ' selected="selected" '; } echo '  >'.$nombre.'</option>';
																}
														echo '</select>';
													echo '</td>';
												echo '</tr>';
											}
										echo '<tr><td>'.ap_txt_tip_art.'</td><td>'.$nombre_tipo.'</td></tr>';
										echo '<tr><td>'.ap_txt_fec_art.'</td><td>';
												$arreglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name = "dia">';
												for ($d = 1; $d<=31; $d++)
													{echo '<option value = "'.$d.'" '; if ($dia == $d) { echo 'selected="selected"'; } echo ' >'.$d.'</option>';}
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes">';
												for ($m=1; $m<=12; $m++)
													{echo '<option value = "'.$m.'"  ';if ($mes == $m) {echo ' selected="selected" ';} echo ' >'. $arreglo_meses[$m] .' </option>';}
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano">';
													for ($a=$ano-10; $a<=$ano+10; $a++)
														{echo '<option value = "'.$a.'" '; if ($ano == $a) {echo ' selected="selected" ';}  echo ' >'.$a.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.ap_txt_lug_art.'</td>';;
											echo '<td><input type = "text" name = "lugar_articulo" size = "60" value= "'.$lugar_articulo.'" /></td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>'.ap_txt_num_art.'</td>';
											echo '<td><input type = "text" name = "numero_articulo" size = "5" onkeypress="return solo_num(event)" value= "'.$numero_articulo.'" /></td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td align="center"><a name="titulo_link" id="titulo_link"></a><strong>'.ap_txt_tit_art.'</strong></td></tr>';		
										echo '<tr>';
											echo '<td>';
												$oFCKeditor1 = new FCKeditor("titulo") ;
												$oFCKeditor1->BasePath = "../librerias/fckeditor/";		
												$oFCKeditor1->ToolbarSet = "texto_simple";
												$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
												$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
												$oFCKeditor1->Width = "100%";
												$oFCKeditor1->Height = "90";
												$oFCKeditor1->Value = $titulo;	
												$oFCKeditor1->Create();	
											echo '</td>';
										echo '</tr>';
										echo '<tr><td align="center"><a name="resumen_chico_link" id="resumen_chico_link"></a><strong>'.ap_txt_resc_art.'</strong></td></tr>';
										echo '<tr><td>';
												$oFCKeditor2 = new FCKeditor("resumen_chico") ;
												$oFCKeditor2->BasePath = "../librerias/fckeditor/";
												$oFCKeditor2->ToolbarSet = "Default";
												$oFCKeditor2->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
												$oFCKeditor2->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
												$oFCKeditor2->Width = "100%";
												$oFCKeditor2->Height = "250";	
												$oFCKeditor2->Value = $resumen_chico;
												$oFCKeditor2s->Create();
										echo '</td></tr>';
										echo '<tr><td align="center"><a name="resumen_grande_link" id="resumen_grande_link"></a><strong>'.ap_txt_resg_art.'</strong></td></tr>';
										echo '<tr>';
											echo '<td>';
												$oFCKeditor3 = new FCKeditor("resumen_grande") ;
												$oFCKeditor3->BasePath = "../librerias/fckeditor/";
												$oFCKeditor3->ToolbarSet = "Default";
												$oFCKeditor3->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
												$oFCKeditor3->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
												$oFCKeditor3->Width = "100%";
												$oFCKeditor3->Height = "250";
												$oFCKeditor3->Value = $resumen_grande;	
												$oFCKeditor3->Create();	
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									$cons_con_detalle = "select clave_articulo_pagina, pagina, texto, situacion from nazep_zmod_articulos_paginas where clave_articulo = '$clave_articulo' order by pagina";	
									$res = mysql_query($cons_con_detalle);
									$con = 1;
									while($ren = mysql_fetch_array($res))
										{
											$pagina = $ren["pagina"];
											$texto = stripslashes($ren["texto"]);
											$clave_articulo_pagina =  $ren["clave_articulo_pagina"];
											$situacion_texto = $ren["situacion"];
											echo '<input type="hidden" name="clave_articulo_pagina_'.$con.'" value = "'.$clave_articulo_pagina.'" />';
											echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
												echo '<tr><td align="center"><strong>'.ap_txt_con_pag.$pagina.'</strong></td></tr>';;
												echo '<tr><td>'.ap_txt_num_pag.$pagina.'<input type = "hidden" name = "pagina_'.$con.'" size = "5" value ="'.$pagina.'"  /></td></tr>';
												echo '<tr>';
													echo '<td align="center">'.ap_txt_sit_pag.$pagina;
														echo '<select name = "situacion_'.$con.'">';
															echo '<option value ="activo"  '; if ($situacion_texto == "activo") { echo 'selected'; } echo ' >'.activo.'</option>';
															echo '<option value = "cancelado"  '; if ($situacion_texto == "cancelado") { echo 'selected'; } echo ' >'.cancelado.'</option>';
														echo '</select>';
													echo '</td>';
												echo '</tr>';
												echo '<tr>';
													echo '<td>';
														echo '<a name="texto_link_'.$con.'" id="texto_link_'.$con.'"></a>';
														$oFCKeditor[$con] = new FCKeditor("conte_texto_$con");
														$oFCKeditor[$con]->BasePath = '../librerias/fckeditor/';
														$oFCKeditor[$con]->Value = $texto;
														$oFCKeditor[$con]->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
														$oFCKeditor[$con]->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
														$oFCKeditor[$con]->Width = "100%";
														$oFCKeditor[$con]->Height = "500";
														$oFCKeditor[$con]->Create();
													echo '</td>';
												echo '</tr>';
											echo '</table>';
											$con++;
										}
									$con--;
									echo '<input type="hidden" name="formulario_final" value = "" />';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
									echo '<input type="hidden" name="metodo" value = "modificar_articulo" />';
									echo '<input type="hidden" name="paginas" value = "'.$con.'" />';
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
									echo '<input type="hidden" name="clave_articulo" value ="'.$clave_articulo.'" />';	
									echo '<input type="hidden" name="guardar" value = "si" />';
									echo '<input type="hidden" name="situacion_temporal" value ="pendiente" />';
									echo '<input type="hidden" name="usar_tema" value = "'.$usar_tema.'" />';
									echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="submit" name="btn_guardar1" value="'.guardar_cambio.'" onclick= "return validar_form(this.form,\'pendiente\', \'regresar_pantalla\')" />';
											echo '</td>';
											if($nivel == 1 or $nivel == 2)
												{echo '<td align="center"><input type="submit" name="btn_guardar2" value="'.guardar_cam_pub.'" onclick= "return validar_form(this.form,\'activo\', \'recargar_pantalla\')" /></td>';}
										echo '</tr>';	
									echo '</table>';
								echo '</form>';	
								echo '<hr />';	
								echo '<form name="agregar_pagina" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" class="margen_cero"/>';
												echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
												echo '<input type="hidden" name="metodo" value = "nueva_pagina_articulo" />';
												echo '<input type="hidden" name="clave_tipo" value ="'.$clave_tipo.'" />';
												echo '<input type="hidden" name="clave_articulo" value ="'.$clave_articulo.'" />';	
												echo '<input type="hidden" name="ano_i" value ="'.$ano_i_b.'" />';
												echo '<input type="hidden" name="mes_i" value ="'.$mes_i_b.'" />';
												echo '<input type="hidden" name="dia_i" value ="'.$dia_i_b.'" />';
												echo '<input type="hidden" name="ano_t" value ="'.$ano_t_b.'" />';
												echo '<input type="hidden" name="mes_t" value ="'.$mes_t_b.'" />';
												echo '<input type="hidden" name="dia_t" value ="'.$dia_t_b.'" />';
												echo '<input type="hidden" name="usar_tema" value = "'.$usar_tema.'" />';
												echo '<input type="submit" name="btn_agregar_pagina" value="'.btn_agre_pag.'" />';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
								echo '<hr />';
								HtmlAdmon::div_res_oper(array());
								HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>reg_res_bus,
									'OpcOcultas'=>array( 'archivo'=>$this->DirArchivo,
									'clase'=>$this->NomClase, 'metodo'=>'modificar_articulo',
									'buscar'=>'si','ano_i'=>$ano_i_b, 'mes_i'=>$mes_i_b,'dia_i'=>$dia_i_b,
									'ano_t'=>$ano_t_b, 'mes_t'=>$mes_t_b,'dia_t'=>$dia_t_b,'clave_tipo'=>$clave_tipo, 'usar_tema'=>$usar_tema )));
							}
					}
				elseif(isset($_POST["buscar"]) && $_POST["buscar"]=="si")
					{
						$fecha_articulo_i = $_POST["ano_i"].'-'.$_POST["mes_i"].'-'.$_POST["dia_i"];
						$fecha_articulo_t = $_POST["ano_t"].'-'.$_POST["mes_t"].'-'.$_POST["dia_t"];		
						$clave_tipo = $_POST["clave_tipo"];
						$conexion = $this->conectarse();
						$con_articulos_total ="select clave_articulo, situacion, titulo, resumen_chico from nazep_zmod_articulos 
						where fecha_articulo >= '$fecha_articulo_i' and fecha_articulo <= '$fecha_articulo_t' and clave_tipo = '$clave_tipo' order by fecha_creacion desc";
						$res_con_articulos = mysql_query($con_articulos_total);
						$can_total_noticias = mysql_num_rows($res_con_articulos);
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(ap_txt_tit_art_enc." ($can_total_noticias)");
						$fecha_i = FunGral::fechaNormal($fecha_articulo_i);
						$fecha_t = FunGral::fechaNormal($fecha_articulo_t);
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center"><tr><td align="center"><strong>'.de.' '.$fecha_i.' '.a.' '.$fecha_t.'</strong></td></tr></table><br />';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
							echo'<tr>';
								echo '<td align = "center"><strong>'.ap_txt_tit_art.'</strong></td>';
								echo '<td align = "center"><strong>'.situacion.'</strong></td>';
								echo '<td align = "center"><strong>'.ap_txt_resumen.'</strong></td>';
								echo '<td align = "center"><strong>'.modificar.'</strong></td>';
							echo'</tr>';
							$contador = 0;
							while($ren_total = mysql_fetch_array($res_con_articulos))
								{
									$clave_articulo = $ren_total["clave_articulo"];
									$titulo = $ren_total["titulo"];
									$situacion = $ren_total["situacion"];
									$resumen = stripslashes($ren_total["resumen_chico"]);
									if(($contador%2)==0)
										{$color = 'bgcolor="#F9D07B"';}
									else
										{$color = '';}
									echo'<tr>';
										echo '<td '.$color.'>'.$titulo.'</td>';
										echo '<td align = "center" '.$color.'>'.$situacion.'</td>';
										echo '<td '.$color.'>'.$resumen.'</td>';
										echo '<td align = "center" '.$color.'>';
											echo '<form name="buscar_articulo_'.$clave_articulo.'" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
												echo '<input type="hidden" name="metodo" value = "modificar_articulo" />';
												echo '<input type="hidden" name="articulo" value = "si" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
												echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
												echo '<input type="hidden" name="fecha_articulo_i" value = "'.$fecha_articulo_i.'" />';
												echo '<input type="hidden" name="fecha_articulo_t" value = "'.$fecha_articulo_t.'" />';
												echo '<input type="submit" name="btn_modificar" value="'.modificar.'" />';
											echo '</form>';
										echo '</td>';
									echo'</tr>';
									$contador++;
								}
						echo '</table><br />';
						HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>ap_txt_reg_bus_art,
							'OpcOcultas'=>array( 'archivo'=>$this->DirArchivo,
							'clase'=>$this->NomClase, 'metodo'=>'modificar_articulo',
							'clave_seccion_enviada'=>$clave_seccion_enviada, 'clave_tipo'=>$clave_tipo)));
					}
				else
					{
						$clave_tipo= $_POST["clave_tipo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(ap_txt_tit_bus_art);
						echo '<br /><form name="buscar_articulo" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>'.fecha_ini_bus.'</td><td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										$arreglo_meses = FunGral::MesesNumero();
										echo dia.'&nbsp;<select name = "dia_i">';
										for ($a = 1; $a<=31; $a++)
											{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' > '.$a.' </option>';}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_i">';
											for ($b=1; $b<=12; $b++)
												{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'.$arreglo_meses[$b].'</option>';	}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_i">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td >'.fecha_fin_bus.'</td><td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										echo dia.'&nbsp;<select name = "dia_t">';
										for ($a = 1; $a<=31; $a++)
											{echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' >'.$a.'</option>';}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_t">';
										for ($b=1; $b<=12; $b++)
											{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'.$arreglo_meses[$b].'</option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_t">';
										for ($b=$ano-10; $b<=$ano+10; $b++)
											{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
										echo '</select>&nbsp;';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';	
									echo '<td align="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "modificar_articulo" />';
										echo '<input type="hidden" name="buscar" value ="si" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';
										echo '<input type="hidden" name="clave_tipo" value ="'.$clave_tipo.'" />';
										echo '<input type="submit" name="btn_buscar" value="'.buscar.'" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}			
		function nueva_pagina_articulo($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_articulo = $_POST["clave_articulo"];
						$nombre_propone = $this->escapar_caracteres($_POST["nombre_propone"]);
						
						$nombre_propone = strip_tags($nombre_propone);
						$correo_propone = $_POST["correo_propone"];
						$clave_seccion = $_POST["clave_seccion"];
						$motivo = $this->escapar_caracteres($_POST["motivo"]);
						$motivo = strip_tags($motivo);
						$pagina = $_POST["pagina"];
						$texto = $this->escapar_caracteres($_POST["texto"]);
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$situacion_temporal = $_POST["situacion_temporal"];
						$ip = $_SERVER['REMOTE_ADDR'];	
						if($correo_propone=="")
							{$correo_propone = $cor_user;}
						if($nombre_propone=="")
							{$nombre_propone = $nom_user;}	
						$nombre_propone = strip_tags($nombre_propone);
						$sql_adicional = "null, '', '', '', '0000-00-00','00:00:00', ''";	
						$situacion_detalle = "pendiente";
						if($situacion_temporal=="activo")
							{
								$sql_adicional = "'$nick_user', '$nombre_propone', '$correo_propone', 'nueva p�gina: $motivo',  '$fecha_hoy', '$hora_hoy', '$ip' ";
								$situacion_detalle = "activo";
							}	
						$insertar = "insert into nazep_zmod_articulos_cambios 
						(clave_articulo, situacion, 
						user_propone, nombre_propone, correo_propone, motivo_propone, fecha_propone, hora_propone, ip_poropone, 
						user_decide, nombre_decide, correo_decide, motivo_decide, fecha_decide, hora_decide, ip_decide)
						values
						('$clave_articulo', '$situacion_temporal',
						'$nick_user', '$nombre_propone', '$correo_propone', 'nueva p�gina: $motivo',  '$fecha_hoy', '$hora_hoy', '$ip',
						".$sql_adicional.")";
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");	
						if (!@mysql_query($insertar))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}	
						else
							{
								$paso = true;
								$clave_articulo_cambios_db = mysql_insert_id();		
								$con_pag = "select pagina from nazep_zmod_articulos_paginas where clave_articulo = '$clave_articulo'";
								$res_pag = mysql_query($con_pag);
								$can_pag = mysql_num_rows($res_pag);
								$can_pag++;
								$insertar2 ="insert into nazep_zmod_articulos_paginas 
								(clave_articulo, situacion, pagina, texto) values ('$clave_articulo', '$situacion_detalle','$can_pag', '$texto')";
								if (!@mysql_query($insertar2))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}	
								else
									{
										$paso = true;
										$clave_articulo_pagina_db = mysql_insert_id();
										$insert3 = "insert into nazep_zmod_articulos_paginas_cambios (clave_articulo_cambios, clave_articulo_pagina, 
										nuevo_situacion, nuevo_pagina, nuevo_texto)
										values('$clave_articulo_cambios_db','$clave_articulo_pagina_db', '$situacion_detalle','$can_pag', '$texto')";
										if (!@mysql_query($insert3))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = "3";
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
							{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";	}
					}
				else
					{
						$usar_tema = $_POST["usar_tema"];
						$clave_tipo= $_POST["clave_tipo"];
						$clave_articulo = $_POST["clave_articulo"];	
						$ano_i = $_POST["ano_i"];
						$mes_i = $_POST["mes_i"];
						$dia_i = $_POST["dia_i"];
						$ano_t = $_POST["ano_t"];
						$mes_t = $_POST["mes_t"];
						$dia_t = $_POST["dia_t"];
						$fecha_articulo_i = $_POST["ano_i"].'-'.$_POST["mes_i"].'-'.$_POST["dia_i"];
						$fecha_articulo_t = $_POST["ano_t"].'-'.$_POST["mes_t"].'-'.$_POST["dia_t"];	
						$clave_tipo = $_POST["clave_tipo"];
						$con_veri = "select clave_articulo_cambios from nazep_zmod_articulos_cambios 
						where clave_articulo = '$clave_articulo' and (situacion = 'pendiente' or situacion = 'nueva_pagina' or situacion = 'nuevo')";
						$conexion = $this->conectarse();
						$res = mysql_query($con_veri);
						$cantidad = mysql_num_rows($res);
						if($cantidad!=0)
							{
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align = "center"><br /><strong>'.ap_txt_tiene_pag_pen.'</strong><br /><br /></td></tr>';
								echo '</table>';
								HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>ap_txt_reg_art,
																'OpcOcultas'=>array('archivo'=>$this->DirArchivo,
																					'clase'=>$this->NomClase, 'metodo'=>'modificar_articulo', 'articulo'=>'si',
																					'clave_articulo'=>$clave_articulo, 'fecha_articulo_i'=>$fecha_articulo_i, 'fecha_articulo_t'=>$fecha_articulo_t,
																					'clave_tipo'=>$clave_tipo, 'usar_tema'=>$usar_tema, 'dia_t'=>$dia_t )));
							}
						else
							{							
								$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
								HtmlAdmon::titulo_seccion(ap_txt_tit_agr_pag);
								$con_titulo = "select titulo from nazep_zmod_articulos where clave_articulo = '$clave_articulo'";
								$conexion = $this->conectarse();
								$res_titulo = mysql_query($con_titulo);
								$ren_titulo = mysql_fetch_array($res_titulo);
								$titulo = $ren_titulo["titulo"];
								echo '<script type="text/javascript">';
								echo'$(document).ready(function()
										{
											$.frm_elem_color("#FACA70","");
											$.guardar_valores("crear_nueva_pagina");
										});
									function validar_form(formulario, situacion_temporal, opcion, nombre_formulario)
										{
											formulario.situacion_temporal.value = situacion_temporal;
											if(formulario.motivo.value == "") 
												{
													alert("'.jv_campo_motivo.'");
													formulario.motivo.focus(); 	
													return false;
												}
											if(opcion=="regresar")
												{document.recargar_pantalla.funcion.value="nueva_pagina_articulo";}
											valor_texto = FCKeditorAPI.__Instances[\'texto\'].GetHTML();
											formulario.texto.value = valor_texto; 												
											formulario.btn_guardar1.style.visibility="hidden";
								';
								if($nivel == '1' or $nivel == '2')
									{
											echo ' formulario.btn_guardar2.style.visibility="hidden";
											formulario.btn_guardar3.style.visibility="hidden"; ';
									}
										echo 'formulario.formulario_final.value = nombre_formulario;
										}';
								echo '</script>';
								echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
									echo '<input type="hidden" name="metodo" value = "modificar_articulo" />';	
									echo '<input type="hidden" name="articulo" value ="si" />';
									echo '<input type="hidden" name="clave_articulo" value ="'.$clave_articulo.'" />';	
									echo '<input type="hidden" name="fecha_articulo_i" value = "'.$fecha_articulo_i.'" />';
									echo '<input type="hidden" name="fecha_articulo_t" value = "'.$fecha_articulo_t.'" />';	
									echo '<input type="hidden" name="ano_i" value ="'.$ano_i.'" />';
									echo '<input type="hidden" name="mes_i" value ="'.$mes_i.'" />';
									echo '<input type="hidden" name="dia_i" value ="'.$dia_i.'" />';
									echo '<input type="hidden" name="ano_t" value ="'.$ano_t.'" />';
									echo '<input type="hidden" name="mes_t" value ="'.$mes_t.'" />';
									echo '<input type="hidden" name="dia_t" value ="'.$dia_t.'" />';
									echo '<input type="hidden" name="usar_tema" value = "'.$usar_tema.'" />';
									echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
								echo '</form>';
								echo '<form name="refrescar_pantalla" id="refrescar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
									echo '<input type="hidden" name="metodo" value = "modificar_articulo" />';	
									echo '<input type="hidden" name="buscar" value ="si" />';
									echo '<input type="hidden" name="ano_i" value ="'.$ano_i.'" />';
									echo '<input type="hidden" name="mes_i" value ="'.$mes_i.'" />';
									echo '<input type="hidden" name="dia_i" value ="'.$dia_i.'" />';
									echo '<input type="hidden" name="ano_t" value ="'.$ano_t.'" />';
									echo '<input type="hidden" name="mes_t" value ="'.$mes_t.'" />';
									echo '<input type="hidden" name="dia_t" value ="'.$dia_t.'" />';
									echo '<input type="hidden" name="usar_tema" value = "'.$usar_tema.'" />';
									echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
								echo '</form>';								
								echo '<form name="crear_nueva_pagina" id="crear_nueva_pagina" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td align="center"><strong>'.ap_txt_tit_art.'</strong></td></tr>';
										echo '<tr><td align="center">'.$titulo.'</td></tr>';
									echo '</table>';
									echo '<hr />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>'.persona_cambio.'</td><td><input type="text" name ="nombre_propone" size="60" /></td></tr>';
										echo '<tr><td>'.correo_cambio.'</td><td><input type ="text" name ="correo_propone" size="60" /></td></tr>';
										echo '<tr><td>'.motivo_cambio.'</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>'.ap_txt_cuer_new_pag.'</td></tr>';
										echo '<tr>';
											echo '<td>';
												echo '<a name="texto_link" id="texto_link"></a>';
												$oFCKeditor1 = new FCKeditor("texto");
												$oFCKeditor1->BasePath = '../librerias/fckeditor/';		
												$oFCKeditor1->Value = $texto;
												$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema.'fck_editorarea.css';
												$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema.'fckstyles.xml';
												$oFCKeditor1->Width = "100%";
												$oFCKeditor1->Height = "500";
												$oFCKeditor1->Create();
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<input type="hidden" name="formulario_final" value = "" />';	
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
									echo '<input type="hidden" name="metodo" value = "nueva_pagina_articulo" />';	
									echo '<input type="hidden" name="guardar" value = "si" />';	
									echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
									echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
									echo '<input type="hidden" name="situacion_temporal" value = "nueva_pagina" />';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="submit" name="btn_guardar1" value="'.guardar.'" onclick= "return validar_form(this.form,\'nueva_pagina\',\'salir\', \'refrescar_pantalla\')" />';
											echo '</td>';
											if($nivel == "1" or $nivel == "2")
												{echo '<td align="center"><input type="submit" name="btn_guardar2" value="'.guardar_puliblicar.'" onclick= "return validar_form(this.form,\'activo\',\'salir\', \'recargar_pantalla\')" /></td>';}
										echo '</tr>';
									echo '</table>';
									if($nivel == 1 or $nivel == 2)
										{
											echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td align="center">';
												echo '<input type="submit" name="btn_guardar3" value="'.guardar_pub_otro.'" onclick= "return validar_form(this.form,\'activo\',\'regresar\', \'recargar_pantalla\')" />';
											echo '</td></tr></table>';
										}
								echo '</form>';
								HtmlAdmon::div_res_oper(array());								
								HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>ap_txt_reg_art,
									'OpcOcultas'=>array( 
									'archivo'=>$this->DirArchivo,
									'clase'=>$this->NomClase, 'metodo'=>'modificar_articulo',
									'articulo'=>'si', 'clave_articulo'=>$clave_articulo,
									'fecha_articulo_i'=>$fecha_articulo_i, 'fecha_articulo_t'=>$fecha_articulo_t,
									'clave_tipo'=>$clave_tipo, 'usar_tema'=>$usar_tema, 'dia_t'=>$dia_t, 'clave_tipo'=>$clave_tipo )));
							}
					}
			}
		function admon_comentarios($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_seccion = $_POST["clave_seccion"];
						$clave_comentario = $_POST["clave_comentario"];
						$situacion = FunGral::_Post("situacion");
						$leido = FunGral::_Post("leido");
						$cadena_set = '';
						if($situacion!='')
							{$cadena_set=" situacion = '$situacion' ";}
						elseif($leido!='')
							{$cadena_set =" leido = '$leido' ";}
						$update = "update nazep_zmod_articulos_comentarios set $cadena_set where clave_comentario_art = '$clave_comentario'";
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
				elseif(isset($_POST["buscar"]) &&  $_POST["buscar"]=="si")
					{													
						$tipo_busqueda = $_POST["tipo_busqueda"];
						$leido = $_POST["leido"];
						$clave_tipo = $_POST["clave_tipo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(ap_txt_tit_comen);
						$con_total = "select art.titulo,
						com.clave_comentario_art, com.situacion, com.fecha, com.hora, com.nombre, com.correo, com.web, com.comentario, com.ip, com.leido
						from  nazep_zmod_articulos_comentarios  com,
						nazep_zmod_articulos art
						where art.clave_articulo = com.clave_articulo and art.clave_tipo = '$clave_tipo' and leido like '$leido'";
						$conexion = $this->conectarse();
						$res_total = mysql_query($con_total);
						$can_comen = mysql_num_rows($res_total);
						$cantidad_mostrar = 10;
						$pag=0;
						$ini = 0;
						if(FunGral::_Post("pag")=='')
							{
								$pag = 1;
								$ini = 0;
							}
						else
							{
								$pag = FunGral::_PostLimpioInt("pag");
								$ini = ($pag-1)*$cantidad_mostrar;
							}
						$total_paginas = ceil($can_comen/$cantidad_mostrar);	
						$consulta_des = "select art.titulo,
						com.clave_comentario_art, com.situacion, com.fecha, com.hora, com.nombre, com.correo, com.web, com.comentario, com.ip, com.leido
						from  nazep_zmod_articulos_comentarios  com,
						nazep_zmod_articulos art
						where art.clave_articulo = com.clave_articulo and art.clave_tipo = '$clave_tipo' and leido like '$leido'
						order by art.clave_articulo desc, fecha desc, hora desc limit $ini, $cantidad_mostrar";
						$res_des = mysql_query($consulta_des);
						$res_des2 = mysql_query($consulta_des);
						echo '<script type="text/javascript">';
						while($ren2 = mysql_fetch_array($res_des2))
							{
								$clave_comentario_art = $ren2["clave_comentario_art"];
								echo '$(document).ready(function()
										{ $.guardar_valores("cambiar_comentario_'.$clave_comentario_art.'");
										  $.guardar_valores("lectura_comentario_'.$clave_comentario_art.'");
										 });	';								
							}
						echo '</script>';
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
							echo '<input type="hidden" name="clave_tipo" value = "'.$clave_tipo.'" />';
							echo '<input type="hidden" name="leido" value ="'.$leido.'" />';
							echo '<input type="hidden" name="tipo_busqueda" value ="'.$tipo_busqueda.'" />';							
							echo '<input type="hidden" name="buscar" value = "si" />';
							echo '<input type="hidden" name="metodo" value = "admon_comentarios" />';
							echo '<input type="hidden" name="pag" value = "'.$pag.'" />';	
						echo '</form>';	
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align = "center"><strong>Titulo Articulo</strong></td>';
								echo '<td align = "center"><strong>'.autor.'</strong></td>';
								echo '<td align = "center"><strong>'.fec_elabo.'</strong></td>';
								echo '<td align = "center"><strong>'.situacion.'</strong></td>';
								echo '<td align = "center"><strong>&iquest;Leido?</strong></td>';
								echo '<td align = "center"><strong>'.ap_txt_comentario.'</strong></td>';
								echo '<td align = "center"><strong>'.modificar.'</strong></td>';
							echo '</tr>';
							$contador = 0;
							while($ren_des = mysql_fetch_array($res_des))
								{	
									if(($contador%2)==0)
										{$color = 'bgcolor="#F9D07B"';}
									else
										{$color = '';}								
									$clave_comentario = $ren_des["clave_comentario_art"];
									$situacion = $ren_des["situacion"];
									$fecha = $ren_des["fecha"];
									$fecha = FunGral::FechaNormalCorta($fecha);
									$hora = $ren_des["hora"];
									$nombre = $ren_des["nombre"];
									$correo = $ren_des["correo"];
									$web = $ren_des["web"];
									$comentario = $ren_des["comentario"];
									$ip = $ren_des["ip"];
									$leido_comen = $ren_des["leido"];
									$titulo  = $ren_des["titulo"];
									echo '<tr>';
										echo '<td align = "center"  '.$color.'>'.$titulo.'</td>';
										echo '<td align = "left"  '.$color.'>'.$nombre;
											if($correo!='')
												{echo '<br />'.$correo;}
											if($web!='')
												{echo '<br /><a href="http://'.$web.'" target="_blank">Web</a>';}
											echo '<br />IP: '.$ip;
										echo '</td>';	
										echo '<td align = "center"  '.$color.'>'.$fecha.'<br />'.$hora.'</td>';
										echo '<td align = "center"  '.$color.'>'.$situacion.'</td>';
										echo '<td align = "center"  '.$color.'>'.$leido_comen.'</td>';
										echo '<td align = "left" '.$color.'>'.$comentario.'</td>';
										echo '<td align = "center"  '.$color.'>';
											echo '<form name="cambiar_comentario_'.$clave_comentario.'" id="cambiar_comentario_'.$clave_comentario.'" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
												echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
												echo '<input type="hidden" name="metodo" value = "admon_comentarios" />';	
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="clave_comentario" value = "'.$clave_comentario.'" />';
												if($situacion=="activo")
													{echo '<input type="hidden" name="situacion" value = "cancelado" /><input type="submit" name="btn_modificar" value="'.cancelar.'"  />';}
												elseif($situacion=="cancelado")
													{echo '<input type="hidden" name="situacion" value = "activo" /><input type="submit" name="btn_modificar" value="'.activar.'"  />';}
											echo '</form>';	
											echo '<form name="lectura_comentario_'.$clave_comentario.'" id="lectura_comentario_'.$clave_comentario.'" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
												echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
												echo '<input type="hidden" name="metodo" value = "admon_comentarios" />';	
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
												echo '<input type="hidden" name="clave_comentario" value = "'.$clave_comentario.'" />';
												if($leido_comen=="SI")
													{echo '<input type="hidden" name="leido" value = "NO" /><input type="submit" name="btn_modificar" value="Marcar NO LEIDO"  />';}
												else if($leido_comen=="NO")
													{echo '<input type="hidden" name="leido" value = "SI" /><input type="submit" name="btn_modificar" value="Marcar SI LEIDO"  />';}
											echo '</form>';											
										echo '</td>';
									echo '</tr>';
									$contador++;
								}
							echo '</table>';
							HtmlAdmon::div_res_oper(array());
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align = "center">';
										if($total_paginas >1)
											{
												for($a=1;$a<=$total_paginas;$a++)
													{
														echo '<form name="pag_com_'.$a.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
															echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
															echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
															echo '<input type="hidden" name="metodo" value = "admon_comentarios" />';
															echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
															echo '<input type="hidden" name="buscar" value = "si" />';
															echo '<input type="hidden" name="pag" value = "'.$a.'" />';	
															echo '<input type="hidden" name="leido" value ="'.$leido.'" />';															
															echo '<input type="hidden" name="clave_tipo" value ="'.$clave_tipo.'" />';
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
															{echo '<a href="javascript:document.pag_com_'.$a.'.submit()">'.$a.'</a>';}
													}
											}
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,'texto'=>ap_txt_reg_bus_art,
							'OpcOcultas'=>array( 'archivo'=>$this->DirArchivo,'clase'=>$this->NomClase, 
							'metodo'=>'admon_comentarios', 'clave_seccion'=>$clave_seccion_enviada )));
					}
				else
					{
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion(ap_txt_tit_bus_art);
						$con_lista ="select clave_tipo from nazep_zmod_articulos_tipos where clave_seccion = '$clave_seccion_enviada'";
						$conexion = $this->conectarse();
						$res_lista = mysql_query($con_lista);
						$ren_lista = mysql_fetch_array($res_lista);
						$clave_tipo = $ren_lista["clave_tipo"];
						echo '<br /><form name="buscar_comentarios_estado" name="buscar_comentarios_estado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>Situaci&oacute;n del Comentario</td><td>';
										echo '<select name = "leido">';
											echo '<option value = "%"  > TODOS </option>';
											echo '<option value = "SI"  > SI LEIDO </option>';
											echo '<option value = "NO" selected="selected"  > NO LEIDO </option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table><br />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';	
									echo '<td align="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "admon_comentarios" />';
										echo '<input type="hidden" name="buscar" value ="si" />';
										echo '<input type="hidden" name="tipo_busqueda" value ="leido" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';
										echo '<input type="hidden" name="clave_tipo" value ="'.$clave_tipo.'" />';
										echo '<input type="submit" name="btn_buscar" value="'.buscar.'" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::boton_regreso(array('tipo_boton_reg'=>'sencillo','clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}
// ------------------------------ Inicio de funciones para controlar los cambios de la informaci�n del m�dulo			
		function articulos_nuevos($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_seccion = $_POST["clave_seccion"];
						$clave_articulo = $_POST["clave_articulo"];
						$clave_articulo_cambios = $_POST["clave_articulo_cambios"];
						$nombre = $_POST["nombre"];
						$correo = $_POST["correo"];
						$publicar = $_POST["publicar"];
						$motivo = $this->escapar_caracteres($_POST["motivo"]);
						$motivo = strip_tags($motivo);
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						if($correo=='')
							{$correo = $cor_user;}
						if($nombre=='')
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$conexion = $this->conectarse();
						$update1 ="update nazep_zmod_articulos 
						set user_actualiza = '$nick_user', nombre_actualiza = '$nombre', correo_actualiza = '$correo', ip_actualizacion= '$ip', 
						fecha_actualizacion= '$fecha_hoy', hora_actualizacion= '$hora_hoy', situacion = '$publicar' where clave_articulo = '$clave_articulo'";
						$update2 ="update nazep_zmod_articulos_paginas  set situacion = '$publicar' where clave_articulo = '$clave_articulo'";
						$update3 ="update nazep_zmod_articulos_cambios 
						set user_decide= '$nick_user', nombre_decide= '$nombre', correo_decide = '$correo', motivo_decide = '$motivo',
						fecha_decide = '$fecha_hoy', hora_decide = '$hora_hoy', ip_decide = '$ip', situacion = '$publicar' where clave_articulo_cambios = '$clave_articulo_cambios'";
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
				elseif(isset($_POST["clave_articulo"]) && $_POST["clave_articulo"]!="")
					{
						$clave_articulo = $_POST["clave_articulo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("Detalles del nuevo art&iacute;culo");	
						$consulta_art ="select ac.clave_articulo_cambios, ac.user_propone, ac.nombre_propone, ac.correo_propone, ac.motivo_propone, 
						ac.fecha_propone, ac.hora_propone, ac.nuevo_fecha_inicio, ac.nuevo_fecha_fin, ac.nuevo_fecha_articulo, ac.nuevo_lugar_articulo,  
						ac.nuevo_titulo, ac.nuevo_numero_articulo, ac.nuevo_resumen_chico, ac.nuevo_resumen_grande, apc.nuevo_pagina, apc.nuevo_texto
						from nazep_zmod_articulos_cambios ac, nazep_zmod_articulos_paginas_cambios apc where ac.clave_articulo_cambios = apc.clave_articulo_cambios and
						ac.clave_articulo = '$clave_articulo' and ac.situacion = 'nuevo'";		
						$conexion = $this->conectarse();
						$res_con = mysql_query($consulta_art);
						$ren_con = mysql_fetch_array($res_con);
						$clave_articulo_cambios = $ren_con["clave_articulo_cambios"];
						$user_propone = $ren_con["user_propone"];			
						$nombre_propone = $ren_con["nombre_propone"];	
						$correo_propone = $ren_con["correo_propone"];	
						$fecha_propone = $ren_con["fecha_propone"];	
						$fecha_propone = FunGral::fechaNormal($fecha_propone);
						$hora_propone = $ren_con["hora_propone"];
						$nuevo_fecha_inicio = $ren_con["nuevo_fecha_inicio"];	
						$nuevo_fecha_inicio = FunGral::fechaNormal($nuevo_fecha_inicio);
						$nuevo_fecha_fin = $ren_con["nuevo_fecha_fin"];	
						$nuevo_fecha_fin = FunGral::fechaNormal($nuevo_fecha_fin);
						$nuevo_fecha_articulo = $ren_con["nuevo_fecha_articulo"];	
						$nuevo_fecha_articulo = FunGral::fechaNormal($nuevo_fecha_articulo);
						$nuevo_lugar_articulo = stripslashes($ren_con["nuevo_lugar_articulo"]);	
						$nuevo_titulo = stripslashes($ren_con["nuevo_titulo"]);	
						$nuevo_numero_articulo = $ren_con["nuevo_numero_articulo"];	
						$nuevo_resumen_chico = stripslashes($ren_con["nuevo_resumen_chico"]);	
						$nuevo_resumen_grande = stripslashes($ren_con["nuevo_resumen_grande"]);	
						$nuevo_pagina = $ren_con["nuevo_pagina"];	
						$nuevo_texto = stripslashes($ren_con["nuevo_texto"]);	
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Usuario que propone el contenido</td><td width="480">'.$user_propone.'</td></tr>';
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha en la que se propone el art&iacute;culo</td><td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td></tr>';
							echo '<tr><td>Fecha inicio vigencia</td><td>'.$nuevo_fecha_inicio.'</td></tr>';
							echo '<tr><td>Fecha fin vigencia</td><td>'.$nuevo_fecha_fin.'</td></tr>';	
							echo '<tr><td>Fecha del art&iacute;culo</td><td>'.$nuevo_fecha_articulo.'</td></tr>';
							echo '<tr><td>Lugar de art&iacute;culo</td><td>'.$nuevo_lugar_articulo.'</td></tr>';
							echo '<tr><td>N&uacute;mero de art&iacute;culo</td><td>'.$nuevo_numero_articulo.'</td></tr>';
						echo '</table>';
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align="center"><strong>T&iacute;tulo del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$nuevo_titulo.'</td></tr>';
							echo '<tr><td align="center"><strong>Resumen chico del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$nuevo_resumen_chico.'</td></tr>';
							echo '<tr><td align="center"><strong>Resumen grande del art&iacute;culo</strong></td></tr>';
							echo '<tr><td>'.$nuevo_resumen_grande.'</td></tr>';
							echo '<tr><td align="center"><strong>Texto del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$nuevo_texto.'</td></tr>';
						echo '</table>';
						echo'<br /><hr /><br />';
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
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="metodo" value = "articulos_nuevos" />';
						echo '</form>';	
						echo '<form name="frm_guardar_desicion" id="frm_guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>Persona que toma la decisi&oacute;n</td><td><input type = "text" name = "nombre" size = "60" /></td></tr>';
								echo '<tr><td>Correo electr&oacute;nico del que decide</td><td><input type ="text" name ="correo" size = "60" /></td></tr>';
								echo '<tr><td>&iquest;Publicar el art&iacute;culo?</td><td>';
										echo '<select name = "publicar"><option value = "activo">SI</option><option value = "cancelado">NO</option></select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td width="600">Motivo de la decisi&oacute;n</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';		
								echo '<tr>';		
									echo '<td align="center">';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';	
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "articulos_nuevos" />';;
										echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_articulo_cambios" value = "'.$clave_articulo_cambios.'" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<form name="reg_listado" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';		
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "articulos_nuevos" />';
										echo '<input type="hidden" name="clave_seccion" value ="'.$clave_seccion_enviada.'" />';	
										echo '<a href="javascript:document.reg_listado.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="'.img_regresar.'" /><br />';
										echo '<strong>Regresar al listado de nuevos art&iacute;culos</strong></a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
				else
					{	
						$consulta_nuevas = "select a.clave_articulo, a.fecha_articulo, a.titulo, a.resumen_chico
						from nazep_zmod_articulos a, nazep_zmod_articulos_tipos  at 
						where a.clave_tipo = at.clave_tipo and at.clave_seccion = '$clave_seccion_enviada' 
						and a.situacion = 'nuevo' order by a.fecha_creacion";
						$conexion = $this->conectarse();
						$res_cons_nuevas = mysql_query($consulta_nuevas);
						$cantidad = mysql_num_rows($res_cons_nuevas);
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("($cantidad) Nuevos Art&iacute;culos para la Secci&oacute;n \"$nombre_sec\"");
						echo '<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align="center"><strong>Fecha del art&iacute;culo</strong></td><td align="center"><strong>T&iacute;tulo del art&iacute;culo</strong></td>';
								echo '<td align="center"><strong>Resumen chico</strong></td><td align="center"><strong>Ver art&iacute;culo</strong></td></tr>';
							$contador = 0;
							while($ren_articulos = mysql_fetch_array($res_cons_nuevas))
								{
									if(($contador%2)==0)
										{$color = 'bgcolor="#F9D07B"';}
									else
										{$color = '';}
									$clave_articulo = $ren_articulos["clave_articulo"];
									$titulo = stripslashes($ren_articulos["titulo"]);
									$fecha_articulo = $ren_articulos["fecha_articulo"];
									$fecha_articulo = FunGral::FechaNormalCorta($fecha_articulo);
									$resumen_chico = stripslashes($ren_articulos["resumen_chico"]);
									echo '<tr>';
										echo '<td align="left" '.$color.'>'.$fecha_articulo.'</td>';
										echo '<td align="center" '.$color.'>'.$titulo.'</td>';
										echo '<td align="left" '.$color.'>'.$resumen_chico.'</td>';
										echo '<td align="center" '.$color.'>';	
										echo '<form name="mod_articulos_nuevos_'.$clave_articulo.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" class="margen_cero">';
											echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
											echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
											echo '<input type="hidden" name="metodo" value = "articulos_nuevos" />';
											echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
											echo '<input type="submit" name="Submit" value="Ver art&iacute;culo" />';
										echo '</form>';		
										echo '</td>';
									echo '</tr>';
									$contador++;
								}
						echo '</table>';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));
					}
			}
		function cambios_nuevos_articulo($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$publicar = $_POST["publicar"];
						$contador =  $_POST["contador"];	
						$clave_articulo_cambios	 =  $_POST["clave_articulo_cambios"];
						$clave_articulo =  $_POST["clave_articulo"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$motivo = $_POST["motivo"];	
						$motivo = strip_tags($motivo);
						$clave_seccion 	 = $_POST["clave_seccion"];
						$correo = $_POST["correo"];
						$nombre = $_POST["nombre"];
						if($correo=="")
							{$correo = $cor_user;}
						if($nombre=="")
							{$nombre = $nom_user;}
						$nombre = strip_tags($nombre);
						$update_1 = "update nazep_zmod_articulos_cambios set situacion = '$publicar', user_decide = '$nick_user', fecha_decide = '$fecha_hoy', 
						hora_decide = '$hora_hoy', ip_decide = '$ip', motivo_decide = '$motivo', nombre_decide = '$nombre', correo_decide = '$correo'
						where clave_articulo_cambios = '$clave_articulo_cambios'";
						if($publicar == "cancelado")
							{
								$conexion = $this->conectarse();
								if (!@mysql_query($update_1))
									{
										$men = mysql_error();
										$error = 1;
										header("Location: index.php?opc=1111&tipo=1&men=$error&erro=$men");
									}
								else
									{ header("Location: index.php?opc=1111&valor=paso"); }
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
										$update_2 = "update nazep_zmod_articulos a, nazep_zmod_articulos_cambios ac
										set a.situacion = ac.nuevo_situacion, a.user_actualiza = '$nick_user', a.nombre_actualiza = '$nombre',
										a.correo_actualiza = '$correo', a.ip_actualizacion = '$ip', a.fecha_actualizacion = '$fecha_hoy' ,
										a.hora_actualizacion = '$hora_hoy', a.fecha_inicio = ac.nuevo_fecha_inicio ,
										a.fecha_fin = ac.nuevo_fecha_fin, a.fecha_articulo = ac.nuevo_fecha_articulo, 
										a.lugar_articulo = ac.nuevo_lugar_articulo, a.titulo = ac.nuevo_titulo,
										a.numero_articulo = ac.nuevo_numero_articulo, a.resumen_chico = ac.nuevo_resumen_chico,
										a.resumen_grande = ac.nuevo_resumen_grande  where a.clave_articulo = '$clave_articulo' and  ac.clave_articulo_cambios = '$clave_articulo_cambios'";
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
														$clave_articulo_pagina = $_POST["clave_articulo_pagina_".$a];
														$clave_articulos_paginas_cambios = $_POST["clave_articulos_paginas_cambios_".$a];
														$update3 = "update nazep_zmod_articulos_paginas ap, nazep_zmod_articulos_paginas_cambios  apc set
														ap.situacion = apc.nuevo_situacion, ap.pagina = apc.nuevo_pagina, ap.texto = apc.nuevo_texto
														where ap.clave_articulo_pagina = '$clave_articulo_pagina' and apc.clave_articulos_paginas_cambios = '$clave_articulos_paginas_cambios'";
														if (!@mysql_query($update3))
															{
																$men = mysql_error();
																mysql_query("ROLLBACK;");
																$paso = false;
																$error = '3_'.$a;
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
				elseif(isset($_POST["clave_articulo"]) &&  $_POST["clave_articulo"]!="")
					{
						$clave_articulo = $_POST["clave_articulo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("Detalles del cambio al art&iacute;culo");	
						$consulta_art = "select ac.clave_articulo_cambios, ac.user_propone, ac.nombre_propone, ac.correo_propone, ac.motivo_propone, 
						ac.fecha_propone, ac.hora_propone, ac.nuevo_fecha_inicio, 
						ac.nuevo_fecha_fin, ac.nuevo_fecha_articulo, ac.nuevo_lugar_articulo,  
						ac.nuevo_titulo, ac.nuevo_numero_articulo, ac.nuevo_resumen_chico, ac.nuevo_resumen_grande,
						ac.anterior_fecha_inicio, ac.anterior_fecha_fin, ac.anterior_fecha_articulo, ac.anterior_lugar_articulo,
						ac.anterior_titulo, ac.anterior_numero_articulo, ac.anterior_resumen_chico, ac.anterior_resumen_grande
						from nazep_zmod_articulos_cambios ac  where ac.clave_articulo = '$clave_articulo' and ac.situacion = 'pendiente'";	
						$conexion = $this->conectarse();
						$res_con = mysql_query($consulta_art);
						$ren_con = mysql_fetch_array($res_con);	
						$clave_articulo_cambios = $ren_con["clave_articulo_cambios"];
						$user_propone = $ren_con["user_propone"];
						$nombre_propone = $ren_con["nombre_propone"];	
						$correo_propone = $ren_con["correo_propone"];
						$motivo_propone = stripslashes($ren_con["motivo_propone"]);
						$fecha_propone = $ren_con["fecha_propone"];	
						$fecha_propone = FunGral::fechaNormal($fecha_propone);
						$hora_propone = $ren_con["hora_propone"];
						$nuevo_fecha_inicio = $ren_con["nuevo_fecha_inicio"];
						$nuevo_fecha_inicio = FunGral::fechaNormal($nuevo_fecha_inicio);
						
						$nuevo_fecha_fin = $ren_con["nuevo_fecha_fin"];
						$nuevo_fecha_fin = FunGral::fechaNormal($nuevo_fecha_fin);
						
						$nuevo_fecha_articulo = $ren_con["nuevo_fecha_articulo"];
						$nuevo_fecha_articulo = FunGral::fechaNormal($nuevo_fecha_articulo);
						
						$nuevo_lugar_articulo = stripslashes($ren_con["nuevo_lugar_articulo"]);
						$nuevo_titulo = stripslashes($ren_con["nuevo_titulo"]);	
						$nuevo_numero_articulo = $ren_con["nuevo_numero_articulo"];
						$nuevo_resumen_chico = stripslashes($ren_con["nuevo_resumen_chico"]);
						$nuevo_resumen_grande = stripslashes($ren_con["nuevo_resumen_grande"]);
						
						$anterior_fecha_inicio = $ren_con["anterior_fecha_inicio"];	
						$anterior_fecha_inicio = FunGral::fechaNormal($anterior_fecha_inicio);
						$anterior_fecha_fin = $ren_con["anterior_fecha_fin"];	
						$anterior_fecha_fin = FunGral::fechaNormal($anterior_fecha_fin);
						$anterior_fecha_articulo = $ren_con["anterior_fecha_articulo"];	
						$anterior_fecha_articulo = FunGral::fechaNormal($anterior_fecha_articulo);
						$anterior_lugar_articulo = stripslashes($ren_con["anterior_lugar_articulo"]);
						$anterior_titulo = stripslashes($ren_con["anterior_titulo"]);	
						$anterior_numero_articulo = $ren_con["anterior_numero_articulo"];
						$anterior_resumen_chico = stripslashes($ren_con["anterior_resumen_chico"]);
						$anterior_resumen_grande = stripslashes($ren_con["anterior_resumen_grande"]);
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Usuario que propone el contenido</td><td width="480">'.$user_propone.'</td></tr>';
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Motivo del cambio</td><td>'.$motivo_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha en la que se propone el cambio</td><td>'.$fecha_propone.' a las '.$hora_propone.' hrs.</td></tr>';
							echo '<tr><td><hr /></td><td><hr /></td></tr>';
							echo '<tr><td>Nueva Fecha inicio vigencia</td><td>'.$nuevo_fecha_inicio.'</td></tr>';
							echo '<tr><td>Nueva Fecha fin vigencia</td><td>'.$nuevo_fecha_fin.'</td></tr>';
							echo '<tr><td>Nueva Fecha del art&iacute;culo</td><td>'.$nuevo_fecha_articulo.'</td></tr>';
							echo '<tr><td>Nuevo Lugar de art&iacute;culo</td><td>'.$nuevo_lugar_articulo.'</td></tr>';
							echo '<tr><td>Nuevo N&uacute;mero de art&iacute;culo</td><td>'.$nuevo_numero_articulo.'</td></tr>';
							echo '<tr><td colspan="2" ><hr /></td></tr>';
							echo '<tr><td>Anterior Fecha inicio vigencia</td><td>'.$nuevo_fecha_inicio.'</td></tr>';
							echo '<tr><td>Anterior Fecha fin vigencia</td><td>'.$nuevo_fecha_fin.'</td></tr>';
							echo '<tr><td>Anterior Fecha del art&iacute;culo</td><td>'.$nuevo_fecha_articulo.'</td></tr>';
							echo '<tr><td>Anterior Lugar de art&iacute;culo</td><td>'.$nuevo_lugar_articulo.'</td></tr>';
							echo '<tr><td>Anterior N&uacute;mero de art&iacute;culo</td><td>'.$nuevo_numero_articulo.'</td></tr>';
						echo '</table>';							
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align="center"><strong>Nuevo T&iacute;tulo del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$nuevo_titulo.'</td></tr>';
							echo '<tr><td align="center"><strong>Nuevo Resumen chico del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$nuevo_resumen_chico.'</td></tr>';
							echo '<tr><td align="center"><strong>Nuevo Resumen grande del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$nuevo_resumen_grande.'</td></tr>';
							echo '<tr><td align="center"><hr /></td></tr>';
							echo '<tr><td align="center"><strong>Anterior T&iacute;tulo del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$anterior_titulo.'</td></tr>';
							echo '<tr><td align="center"><strong>Anterior Resumen chico del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$anterior_resumen_chico.'</td></tr>';
							echo '<tr><td align="center"><strong>Anterior Resumen grande del art&iacute;culo</strong></td></tr>';
							echo '<tr><td >'.$anterior_resumen_grande.'</td></tr>';
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
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="metodo" value = "cambios_nuevos_articulo" />';
						echo '</form>';
						echo '<form name="frm_guardar_desicion" id="frm_guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<input type="hidden" name="clave_articulo_cambios" value = "'.$clave_articulo_cambios.'" />';
							echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
							echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
							$con_detalle = "select * from nazep_zmod_articulos_paginas_cambios where  clave_articulo_cambios = '$clave_articulo_cambios' order by anterior_pagina ";	
							$res = mysql_query($con_detalle);
							$con = 1;
							while($ren = mysql_fetch_array($res))
								{
									$clave_articulos_paginas_cambios = $ren["clave_articulos_paginas_cambios"];
									$clave_articulo_pagina = $ren["clave_articulo_pagina"];	
									$nuevo_pagina = $ren["nuevo_pagina"];
									$nuevo_texto = $ren["nuevo_texto"];
									$nuevo_situacion = $ren["nuevo_situacion"];
									$anterior_pagina = stripslashes($ren["anterior_pagina"]);
									$anterior_texto = stripslashes($ren["anterior_texto"]);
									$anterior_situacion = $ren["anterior_situacion"];	
									echo '<input type="hidden" name="clave_articulo_pagina_'.$con.'" value = "'.$clave_articulo_pagina.'">';
									echo '<input type="hidden" name="clave_articulos_paginas_cambios_'.$con.'" value = "'.$clave_articulos_paginas_cambios.'">';
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>P&aacute;gina anterior</td><td >'.$anterior_pagina.'</td></tr>';
										echo '<tr><td>Situaci&oacute;n anterior</td><td>'.$anterior_situacion.'</td></tr>';
									echo '</table>';	
									echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" ><tr><td>Texto anterior</td></tr><tr><td>'.$anterior_texto.'</td></tr></table>';
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
								echo '<tr><td>&iquest;Aplicar el cambio?</td>';	
								echo '<td><select name = "publicar"><option value = "activo">SI</option><option value = "cancelado">NO</option></select></td></tr>';
								echo '<tr><td >Motivo de la decisi&oacute;n</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
								echo '<tr><td>&nbsp;</td>';	
									echo '<td>';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "cambios_nuevos_articulo" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="hidden" name="contador" value = "'.$con.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form><br/>';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,
							'texto'=>'Regresar listado de art&iacute;culos con cambios pendientes',
							'OpcOcultas'=>array( 'archivo'=>$this->DirArchivo,
							'clase'=>$this->NomClase, 'metodo'=>'cambios_nuevos_articulo',
							'clave_seccion'=>$clave_seccion_enviada, 'paginas_contenido'=>$paginas_contenido )));
					}
				else
					{
						$consulta_nuevas = "select a.clave_articulo, a.fecha_articulo, a.titulo, a.resumen_chico from nazep_zmod_articulos a, nazep_zmod_articulos_tipos  at, nazep_zmod_articulos_cambios  ac
						where a.clave_tipo = at.clave_tipo and at.clave_seccion = '$clave_seccion_enviada' and a.clave_articulo= ac.clave_articulo and ac.situacion = 'pendiente'";
						$conexion = $this->conectarse();
						$res_cons_nuevas = mysql_query($consulta_nuevas);
						$cantidad = mysql_num_rows($res_cons_nuevas);
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("($cantidad) Art&iacute;culos con cambios para la Secci&oacute;n \"$nombre_sec\"");
						echo '<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr><td align="center"><strong>Fecha del art&iacute;culo</strong></td><td align="center"><strong>T&iacute;tulo del art&iacute;culo</strong></td>';
								echo '<td align="center"><strong>Resumen chico</strong></td><td align="center"><strong>Ver art&iacute;culo</strong></td></tr>';
							$contador = 0;
							while($ren_articulos = mysql_fetch_array($res_cons_nuevas))
								{
									if(($contador%2)==0)
										{$color = 'bgcolor="#F9D07B"';}
									else
										{$color = '';}
									$clave_articulo = $ren_articulos["clave_articulo"];
									$titulo = $ren_articulos["titulo"];
									$fecha_articulo = $ren_articulos["fecha_articulo"];
									$fecha_articulo = FunGral::FechaNormalCorta($fecha_articulo);
									$resumen_chico = stripslashes($ren_articulos["resumen_chico"]);
									echo '<tr>';
										echo '<td align="left" '.$color.'>'.$fecha_articulo.'</td>';
										echo '<td align="center" '.$color.'>'.$titulo.'</td>';	
										echo '<td align="left" '.$color.'>'.$resumen_chico.'</td>';
										echo '<td align="center" '.$color.'>';	
											echo '<form name="camb_articulos_'.$clave_articulo.'" action="index.php?opc=111&clave_seccion='.$clave_seccion_enviada.'" method="post"  class="margen_cero">';
												echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
												echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
												echo '<input type="hidden" name="metodo" value = "cambios_nuevos_articulo" />';
												echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
												echo '<input type="submit" name="Submit" value="Ver art&iacute;culo" />';
											echo '</form>';		
										echo '</td>';
									echo '</tr>';	
									$contador++;
								}	
						echo '</table>';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));
					}
			}
		function paginas_pendientes($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$publicar = $_POST["publicar"];
						$motivo = $_POST["motivo"];
						$motivo = strip_tags($motivo);
						$clave_seccion = $_POST["clave_seccion"];
						$clave_articulo = $_POST["clave_articulo"];
						$clave_articulo_cambios = $_POST["clave_articulo_cambios"];
						$clave_articulos_paginas_cambios = $_POST["clave_articulos_paginas_cambios"];
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
						$update1 ="update nazep_zmod_articulos_cambios  set user_decide = '$nick_user', nombre_decide= '$nombre', correo_decide = '$correo',
						motivo_decide = '$motivo', fecha_decide = '$fecha_hoy', hora_decide = '$hora_hoy', ip_decide = '$ip', situacion = '$publicar' where clave_articulo_cambios = '$clave_articulo_cambios'";
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
								$update_2 = "update nazep_zmod_articulos_paginas set  situacion = '$publicar' where clave_articulo = '$clave_articulo'";
								if (!@mysql_query($update_2))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}
								else
									{$paso = true; }
							}
						if($paso)
							{
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";
							}
						else
							{echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
					}
				elseif(isset($_POST["clave_articulo"]) &&  $_POST["clave_articulo"]!="")
					{
						$clave_articulo = $_POST["clave_articulo"];
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion("Detalles de la nueva p&aacute;gina del art&iacute;culo");	
						$consulta_art = "select pc.nuevo_pagina, pc.nuevo_texto, a.user_propone, a.clave_articulo_cambios, pc.clave_articulos_paginas_cambios,
						a.nombre_propone, a.correo_propone, a.motivo_propone, a.fecha_propone, a.hora_propone
						from nazep_zmod_articulos_cambios a, nazep_zmod_articulos_paginas_cambios  pc
						where a.clave_articulo_cambios = pc.clave_articulo_cambios and a.clave_articulo = '$clave_articulo' and a.situacion = 'nueva_pagina'";
						$conexion = $this->conectarse();
						$res = mysql_query($consulta_art);
						$ren = mysql_fetch_array($res);
						$nuevo_pagina = $ren["nuevo_pagina"];
						$nuevo_texto = stripslashes($ren["nuevo_texto"]);	
						$user_propone = $ren["user_propone"];
						$nombre_propone = $ren["nombre_propone"];
						$correo_propone = $ren["correo_propone"];
						$motivo_propone = $ren["motivo_propone"];
						$fecha_propone = $ren["fecha_propone"];
						$hora_propone = $ren["hora_propone"];
						$clave_articulo_cambios = $ren["clave_articulo_cambios"];	
						$clave_articulos_paginas_cambios = $ren["clave_articulos_paginas_cambios"];
						echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
							echo '<tr><td>Usuario que propone el cambio</td><td width="400">'.$user_propone.'</td></tr>';
							echo '<tr><td>Nombre de persona que propone</td><td>'.$nombre_propone.'</td></tr>';
							echo '<tr><td>Correo electr&oacute;nico del que propone</td><td>'.$correo_propone.'</td></tr>';
							echo '<tr><td>Fecha en la que se propone el cambio</td><td>'.$fecha_propone.'</td></tr>';
							echo '<tr><td>Hora en la que se propone el cambio</td><td>'.$hora_propone.'</td></tr>';
							echo '<tr><td>Motivo por el se que se propone el cambio</td><td>'.$motivo_propone.'</td></tr>';
						echo '</table><br /><br />';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td>P&aacute;gina</td><td width="600">'.$nuevo_pagina.'</td></tr></table>';
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td align = "center"><strong>Texto para la p&aacute;gina</strong></td></tr><tr><td>'.$nuevo_texto.'</td></tr></table>';
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
									} ';
						echo '</script>';	
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
							echo '<input type="hidden" name="metodo" value = "paginas_pendientes" />';
						echo '</form>';	
						echo '<form name="frm_guardar_desicion" id="frm_guardar_desicion" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>Persona que toma la decisi&oacute;n</td><td><input type = "text" name = "nombre" size = "50" /></td></tr>';
								echo '<tr><td>Correo electr&oacute;nico del que decide</td><td><input type = "text" name = "correo" size = "60" /></td></tr>';
								echo '<tr><td>&iquest;Aceptar la nueva p&aacute;gina?</td><td><select name = "publicar"><option value = "activo">SI</option><option value = "cancelado">NO</option></select></td></tr>';
								echo '<tr><td>Motivo de la decisi&oacute;n</td><td><textarea name="motivo" cols="50" rows="5"></textarea></td></tr>';
								echo '<tr><td>&nbsp;</td><td>';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';	
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos"/>';
										echo '<input type="hidden" name="metodo" value = "paginas_pendientes" />';
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" />';
										echo '<input type="hidden" name="clave_articulo_cambios" value = "'.$clave_articulo_cambios.'" />';
										echo '<input type="hidden" name="clave_articulos_paginas_cambios" value = "'.$clave_articulos_paginas_cambios.'" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar decisi&oacute;n" onclick= "return validar_form(this.form)" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form><br />';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('tipo'=>'avanzado','clave_usar'=>$clave_seccion_enviada,
								'texto'=>'Regresar listado de art&iacute;culos con cambios pendientes',
								'OpcOcultas'=>array( 'archivo'=>$this->DirArchivo,
								'clase'=>$this->NomClase, 'metodo'=>'paginas_pendientes',
								'clave_seccion'=>$clave_modulo, 'paginas_contenido'=>$clave_seccion_enviada )));
					}
				else
					{
						$consulta_nuevas = "select a.clave_articulo, a.fecha_articulo, a.titulo, a.resumen_chico from nazep_zmod_articulos a, nazep_zmod_articulos_tipos  at, nazep_zmod_articulos_cambios ac
						where a.clave_tipo = at.clave_tipo and at.clave_seccion = '$clave_seccion_enviada' and a.clave_articulo= ac.clave_articulo and ac.situacion = 'nueva_pagina'";
						$conexion = $this->conectarse();
						$res_cons_nuevas = mysql_query($consulta_nuevas);
						$cantidad = mysql_num_rows($res_cons_nuevas);
						$nombre_sec = HtmlAdmon::historial($clave_seccion_enviada);
						HtmlAdmon::titulo_seccion("($cantidad) P&aacute;ginas nuevas pendientes para los art&iacute;culos");
						echo '<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td align="center"><strong>Fecha del art&iacute;culo</strong></td><td align="center"><strong>T&iacute;tulo del art&iacute;culo</strong></td>';
								echo '<td align="center"><strong>Resumen chico</strong></td><td align="center"><strong>Ver nueva p&aacute;gina</strong></td></tr>';
							$contador = 0;
							while($ren_articulos = mysql_fetch_array($res_cons_nuevas))
								{
									if(($contador%2)==0)
										{$color = 'bgcolor="#F9D07B"';}
									else
										{$color = '';}
									$clave_articulo = $ren_articulos["clave_articulo"];
									$titulo = stripslashes($ren_articulos["titulo"]);
									$fecha_articulo = $ren_articulos["fecha_articulo"];
									$fecha_articulo = FunGral::FechaNormalCorta($fecha_articulo);
									$resumen_chico = stripslashes($ren_articulos["resumen_chico"]);
									echo '<tr><td align="left" '.$color.'>'.$fecha_articulo.'</td><td align="center" '.$color.'>'.$titulo.'</td><td align="left" '.$color.'>'.$resumen_chico.'</td>';			
									echo '<td align="center" '.$color.'><form name="mod_noticias_'.$clave_articulo.'" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" method="post" >';
									echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos/articulos_admon.php" />';
									echo '<input type="hidden" name="clase" value = "clase_articulos"/><input type="hidden" name="metodo" value = "paginas_pendientes" />';
									echo '<input type="hidden" name="clave_articulo" value = "'.$clave_articulo.'" /><input type="submit" name="Submit" value="Ver nueva p&aacute;gina" />';
									echo '</form></td></tr>';
									$contador++;
								}
						echo '</table>';
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'opc_regreso'=>'cambios','texto'=>regresar_opc_cam));
					}
			}
	} 
?>