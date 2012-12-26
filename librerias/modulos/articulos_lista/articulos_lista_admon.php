<?php
/*
Sistema: Nazep
Nombre archivo: articulos_lista_admon.php
Funci�n archivo: archivo para controlar la administraci�n del m�dulo de listado de art�culos
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_articulos_lista extends conexion
	{
		//Propiedads privadas para la direcci�n del archivo y nombre de la clase
		private $DirArchivo = '../librerias/modulos/articulos_lista/articulos_lista_admon.php';
		private $NomClase = 'clase_articulos_lista';
		function __construct($etapa='test')
			{
                            if($etapa=='usar')
                                {
                                    include('../librerias/idiomas/'.FunGral::SaberIdioma().'/articulos_lista.php');
                                }
			}	
// ------------------------------ Inicio de funciones para controlar las funciones del m�dulo	
		function op_modificar_central($clave_seccion_enviada, $nivel, $clave_modulo)
			{
				$situacion = FunGral::vigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == 'activo')
					{		
						$con_confi ="select clave_articulo_lista, nombre_articulos
						from nazep_zmod_articulos_lista where clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada'";
						$res_confi = mysql_query($con_confi);
						$can_confi = mysql_num_rows($res_confi);
						if($can_confi!='')
							{
								$ren_conf = mysql_fetch_array($res_confi);
								$nombre_articulos = $ren_conf["nombre_articulos"];
								if($nivel==1 or $nivel==2)
									{
										HtmlAdmon::AccesoMetodo(array(
													'ClaveSeccion'=>$clave_seccion_enviada,
													'name'=>'configurar_'.$clave_modulo,
													'Id'=>'configurar_'.$clave_modulo,
													'BText'=>configurar.' '.$nombre_articulos,
													'BName'=>'btn_configurar_lis_articulos_'.$clave_modulo,
													'BId'=>'btn_configurar_lis_articulos_'.$clave_modulo,
													'OpcOcultas' => array(
																	'archivo' =>$this->DirArchivo,
																	'clase' =>$this->NomClase,
																	'metodo' =>'configurar',
																	'estado' =>'modificar',
																	'clave_modulo' =>$clave_modulo) ));
									}
							}
						else
							{
								if($nivel==1 or $nivel==2)
									{
										HtmlAdmon::AccesoMetodo(array(
													'ClaveSeccion'=>$clave_seccion_enviada,
													'name'=>'configurar_'.$clave_modulo,
													'Id'=>'configurar_'.$clave_modulo,
													'BText'=>configurar,
													'BName'=>'btn_configurar_lis_articulos_'.$clave_modulo,
													'BId'=>'btn_configurar_lis_articulos_'.$clave_modulo,
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
					{echo '<br />'.lap_txt_avi_no_act;}
			}
		function op_cambios_central($clave_seccion_enviada, $nivel, $nombre_sec, $clave_modulo)
			{
				$situacion = FunGral::vigenciaModulo(array('clave_seccion'=>$clave_seccion_enviada,'clave_modulo'=>$clave_modulo));
				if($situacion == "activo")
					{echo '<br />'.avi_no_mod_mod;}
				else
					{echo '<br />'.lap_txt_avi_no_act_camb;}
			}	
// ------------------------------ Fin de funciones para controlar las funciones del m�dulo
// ------------------------------ Inicio de funciones para controlar la modificaci�n de la informaci�n del m�dulo	
		function configurar($nick_user, $nivel, $ubi_tema, $nom_user, $cor_user)
			{
				$clave_seccion_enviada = $_GET["clave_seccion"];
				if(isset($_POST["guardar"]) && $_POST["guardar"]=="si")
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_seccion_enlazar = $_POST["clave_seccion_enlazar"];
						$ver_nombre = $_POST["ver_nombre"];
						$nombre_articulos = $_POST["nombre_articulos"];
						$nombre_articulos = strip_tags($nombre_articulos);
						$orden_nombre = $_POST["orden_nombre"];
						$lado_nombre = $_POST["lado_nombre"];
						$enlace_nombre = $_POST["enlace_nombre"];
						$nom_por_col1 = $_POST["nom_por_col1"];
						$nom_por_col2 = $_POST["nom_por_col2"];
						$cantidad_listar = $_POST["cantidad_listar"];
						$ver_enlace_ver = $_POST["ver_enlace_ver"];
						$lado_enalce_ver = $_POST["lado_enalce_ver"];
						$enl_por_col1 = $_POST["enl_por_col1"];
						$enl_por_col2 = $_POST["enl_por_col2"];
						$ver_titulo = $_POST["ver_titulo"];
						$orden_titulo = $_POST["orden_titulo"];
						$lado_titulo = $_POST["lado_titulo"];
						$tit_por_col1 = $_POST["tit_por_col1"];
						$tit_por_col2 = $_POST["tit_por_col2"];
						$ver_numero = $_POST["ver_numero"];
						$orden_numero = $_POST["orden_numero"];
						$lado_numero = $_POST["lado_numero"];
						$num_por_col1 = $_POST["num_por_col1"];
						$num_por_col2 = $_POST["num_por_col2"];
						$ver_lugar = $_POST["ver_lugar"];
						$ver_fecha = $_POST["ver_fecha"];
						$orden_lugar_fecha = $_POST["orden_lugar_fecha"];
						$lado_lugar_fecha = $_POST["lado_lugar_fecha"];
						$lug_por_col1 = $_POST["lug_por_col1"];
						$lug_por_col2 = $_POST["lug_por_col2"];
						$ver_resumen_chico = $_POST["ver_resumen_chico"];
						$orden_resumen_chico = $_POST["orden_resumen_chico"];
						$resc_por_col1 = $_POST["resc_por_col1"];
						$resc_por_col2 = $_POST["resc_por_col2"];
						$ver_resumen_grande = $_POST["ver_resumen_grande"];
						$orden_resumen_graden = $_POST["orden_resumen_graden"];
						$resg_por_col1 = $_POST["resg_por_col1"];
						$resg_por_col2 = $_POST["resg_por_col2"];
						$estado = $_POST["estado"];
						$clave_seccion = $_POST["clave_seccion"];
						$clave_modulo = $_POST["clave_modulo"];
						if($estado=='nuevo')
							{
								$consulta = "insert into nazep_zmod_articulos_lista
								(clave_modulo, clave_seccion, clave_seccion_enlazar, nombre_articulos, ver_nombre, orden_nombre, lado_nombre, enlace_nombre,
								nom_por_col1, nom_por_col2, ver_enlace_ver,
								lado_enalce_ver, cantidad_listar, enl_por_col1, enl_por_col2, 
								ver_titulo, orden_titulo, lado_titulo,
								tit_por_col1, tit_por_col2, ver_numero, orden_numero, lado_numero, 
								num_por_col1, num_por_col2, ver_lugar, 
								ver_fecha, orden_lugar_fecha, lado_lugar_fecha, lug_por_col1, lug_por_col2, 
								ver_resumen_chico, orden_resumen_chico,  resc_por_col1, resc_por_col2, ver_resumen_grande, orden_resumen_graden, 
								resg_por_col1, resg_por_col2)
								values
								('$clave_modulo', '$clave_seccion_enviada', '$clave_seccion_enlazar', '$nombre_articulos', '$ver_nombre', '$orden_nombre', '$lado_nombre', '$enlace_nombre', 
								'$nom_por_col1', '$nom_por_col2','$ver_enlace_ver',
								'$lado_enalce_ver', '$cantidad_listar', '$enl_por_col1', '$enl_por_col2',
								'$ver_titulo', '$orden_titulo', '$lado_titulo',
								'$tit_por_col1', '$tit_por_col2', '$ver_numero', '$orden_numero', '$lado_numero', 
								'$num_por_col1', '$num_por_col2', '$ver_lugar',
								'$ver_fecha', '$orden_lugar_fecha', '$lado_lugar_fecha', '$lug_por_col1', '$lug_por_col2',
								'$ver_resumen_chico', '$orden_resumen_chico', '$resc_por_col1', '$resc_por_col2', 
								'$ver_resumen_grande', '$orden_resumen_graden','$resg_por_col1', '$resg_por_col2')";
							}
						elseif($estado=='modificar')
							{
								$clave_articulo_lista = $_POST["clave_articulo_lista"];
								$consulta = "update nazep_zmod_articulos_lista set
								clave_seccion_enlazar = '$clave_seccion_enlazar', nombre_articulos = '$nombre_articulos', ver_nombre = '$ver_nombre', 
								orden_nombre = '$orden_nombre', lado_nombre = '$lado_nombre', enlace_nombre = '$enlace_nombre', 
								nom_por_col1 = '$nom_por_col1', nom_por_col2 = '$nom_por_col2',
								ver_enlace_ver = '$ver_enlace_ver',
								lado_enalce_ver = '$lado_enalce_ver', cantidad_listar = '$cantidad_listar', 
								enl_por_col1 = '$enl_por_col1', enl_por_col2 ='$enl_por_col2',
								ver_titulo = '$ver_titulo', orden_titulo= '$orden_titulo', 
								lado_titulo = '$lado_titulo', tit_por_col1 = '$tit_por_col1', tit_por_col2 = '$tit_por_col2',
								ver_numero = '$ver_numero', orden_numero = '$orden_numero', lado_numero = '$lado_numero', 
								num_por_col1 = '$num_por_col1', num_por_col2 = '$num_por_col2', ver_lugar = '$ver_lugar',
								ver_fecha = '$ver_fecha', orden_lugar_fecha = '$orden_lugar_fecha', lado_lugar_fecha = '$lado_lugar_fecha',
								lug_por_col1 = '$lug_por_col1', lug_por_col2 = '$lug_por_col2', ver_resumen_chico = '$ver_resumen_chico',
								orden_resumen_chico = '$orden_resumen_chico', resc_por_col1 = '$resc_por_col1', resc_por_col2= '$resc_por_col2', 
								ver_resumen_grande = '$ver_resumen_grande', orden_resumen_graden = '$orden_resumen_graden', 
								resg_por_col1 = '$resg_por_col1', resg_por_col2 = '$resg_por_col2'
								where clave_articulo_lista = '$clave_articulo_lista'";
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
						$estado = (isset($_POST["estado"])) ?$_POST["estado"] :'nuevo';
						$clave_modulo =  $_POST["clave_modulo"];
						$nombre = HtmlAdmon::historial($clave_seccion_enviada);	
						HtmlAdmon::titulo_seccion(lap_txt_tit_conf);
						echo '<script type="text/javascript">';	
						echo '$(document).ready(function()
									{
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_configuracion_articulos");
									});
								function validar_form(formulario)
									{
										if(formulario.ver_nombre.value == "SI")
											{
												if(formulario.nombre_articulos.value == "") 
													{
														alert("'.lap_js_1.'");
														formulario.nombre_articulos.focus();
														return false;
													}
											}
										if(formulario.cantidad_listar.value == "") 
											{
												alert("'.lap_js_2.'");
												formulario.cantidad_listar.focus();
												return false;
											}
										formulario.btn_guardar.style.visibility="hidden";
									}';
						echo '</script>';	
						echo '<form name="recargar_pantalla"  id="recargar_pantalla"  method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero">';
							echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos_lista/articulos_lista_admon.php" />';
							echo '<input type="hidden" name="clase" value = "clase_articulos_lista"/>';
							echo '<input type="hidden" name="metodo" value = "configurar" />';
							echo '<input type="hidden" name="estado" value = "modificar" />';
							echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
						echo '</form>';	
						if($estado == 'nuevo')
							{
								$clave_seccion_enlazar = 1;
								$ver_nombre = 'SI';
								$nombre_articulos = '';
								$orden_nombre = 1;
								$lado_nombre = 'left';
								$enlace_nombre = 'SI';
								$nom_por_col1 = '0';
								$nom_por_col2 = '0';
								$cantidad_listar = '';
								$ver_enlace_ver = 'SI';
								$lado_enalce_ver = 'left';
								$enl_por_col1 = '0';
								$enl_por_col2 = '0';
								$ver_titulo = 'SI';
								$orden_titulo = 2;
								$lado_titulo = 'left';
								$tit_por_col1 = '0';
								$tit_por_col2 = '0';
								$ver_numero = 'SI';
								$orden_numero = 3;
								$lado_numero = 'left';
								$num_por_col1 = '0';
								$num_por_col2 = '0';
								$ver_lugar = 'SI';
								$ver_fecha = 'SI';
								$orden_lugar_fecha = 4;
								$lado_lugar_fecha = 'left';
								$lug_por_col1 = '0';
								$lug_por_col2 = '0';
								$ver_resumen_chico = 'SI';
								$orden_resumen_chico = 5;
								$resc_por_col1 = '0';
								$resc_por_col2 = '0';
								$ver_resumen_grande = 'SI';
								$orden_resumen_graden = 6;
								$resg_por_col1 = '0';
								$resg_por_col2 = '0';
								
								$clave_seccion = $clave_seccion_enviada;
								$clave_modulo = $clave_modulo;
								$clave_articulo_lista = '';								
							}
						elseif($estado == 'modificar')
							{	
								$con_con ="select * from nazep_zmod_articulos_lista where  clave_modulo = '$clave_modulo' and clave_seccion = '$clave_seccion_enviada'";
								$conexion = $this->conectarse();
								$res_con =mysql_query($con_con);
								$ren_con = mysql_fetch_array($res_con);
								$clave_seccion_enlazar = $ren_con["clave_seccion_enlazar"];
								$ver_nombre = $ren_con["ver_nombre"];
								$nombre_articulos = $ren_con["nombre_articulos"];
								$orden_nombre = $ren_con["orden_nombre"];
								$lado_nombre = $ren_con["lado_nombre"];
								$enlace_nombre = $ren_con["enlace_nombre"];
								$nom_por_col1 = $ren_con["nom_por_col1"];
								$nom_por_col2 = $ren_con["nom_por_col2"];
								$cantidad_listar = $ren_con["cantidad_listar"];
								$ver_enlace_ver = $ren_con["ver_enlace_ver"];
								$lado_enalce_ver = $ren_con["lado_enalce_ver"];
								$enl_por_col1 = $ren_con["enl_por_col1"];
								$enl_por_col2 = $ren_con["enl_por_col2"];
								$ver_titulo = $ren_con["ver_titulo"];
								$orden_titulo = $ren_con["orden_titulo"];
								$lado_titulo = $ren_con["lado_titulo"];
								$tit_por_col1 = $ren_con["tit_por_col1"];
								$tit_por_col2 = $ren_con["tit_por_col2"];
								$ver_numero = $ren_con["ver_numero"];
								$orden_numero = $ren_con["orden_numero"];
								$lado_numero = $ren_con["lado_numero"];
								$num_por_col1 = $ren_con["num_por_col1"];
								$num_por_col2 = $ren_con["num_por_col2"];
								$ver_lugar = $ren_con["ver_lugar"];
								$ver_fecha = $ren_con["ver_fecha"];
								$orden_lugar_fecha = $ren_con["orden_lugar_fecha"];
								$lado_lugar_fecha = $ren_con["lado_lugar_fecha"];
								$lug_por_col1 = $ren_con["lug_por_col1"];
								$lug_por_col2 = $ren_con["lug_por_col2"];
								$ver_resumen_chico = $ren_con["ver_resumen_chico"];
								$orden_resumen_chico = $ren_con["orden_resumen_chico"];
								$resc_por_col1 = $ren_con["resc_por_col1"];
								$resc_por_col2 = $ren_con["resc_por_col2"];
								$ver_resumen_grande = $ren_con["ver_resumen_grande"];
								$orden_resumen_graden = $ren_con["orden_resumen_graden"];
								$resg_por_col1 = $ren_con["resg_por_col1"];
								$resg_por_col2 = $ren_con["resg_por_col2"];
								$clave_seccion = $ren_con["clave_seccion"];
								$clave_modulo = $ren_con["clave_modulo"];
								$clave_articulo_lista = $ren_con["clave_articulo_lista"];	
							}
						echo '<form name="frm_configuracion_articulos" id="frm_configuracion_articulos" method="post" action="index.php?opc=111&amp;clave_seccion='.$clave_seccion_enviada.'" class="margen_cero" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								$con_sec = "select clave_seccion, nombre
								from nazep_secciones where situacion = 'activo'
								or situacion = 'oculto' order by nombre";
								$res_sec_b = mysql_query($con_sec);
								echo '<tr>';
									echo '<td>'.lap_txt_sec_art.'</td>';
									echo '<td>';
										echo '<select name = "clave_seccion_enlazar">';
											while($ren = mysql_fetch_array($res_sec_b))
												{
													$clave_seccion_b = $ren["clave_seccion"];
													$nombre  = $ren["nombre"];
													echo '<option value = "'.$clave_seccion_b.'"  '; if ($clave_seccion_b == $clave_seccion_enlazar) {echo ' selected="selected" ';} echo ' >'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';	
								echo '<tr>';
									echo '<td>'.lap_txt_ver_nom.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_nombre','ValorSeleccionado'=>$ver_nombre, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_nom_lis. '</td>';
									echo '<td><input type = "text" name = "nombre_articulos" size = "60" value ="'.$nombre_articulos.'"/></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ord_nom.'</td>';
									echo '<td>';
										echo '<select name = "orden_nombre">';
											echo '<option value = "1"  '; if ($orden_nombre == "1") { echo 'selected="selected"'; } echo ' >1</option>';
											echo '<option value = "2"  '; if ($orden_nombre == "2") { echo 'selected="selected"'; } echo ' >2</option>';
											echo '<option value = "3"  '; if ($orden_nombre == "3") { echo 'selected="selected"'; } echo ' >3</option>';
											echo '<option value = "4"  '; if ($orden_nombre == "4") { echo 'selected="selected"'; } echo ' >4</option>';
											echo '<option value = "5"  '; if ($orden_nombre == "5") { echo 'selected="selected"'; } echo ' >5</option>';
											echo '<option value = "6"  '; if ($orden_nombre == "6") { echo 'selected="selected"'; } echo ' >6</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_lad_nom.'</td>';
									echo '<td>';
										echo '<select name = "lado_nombre">';
											echo '<option value = "left"   '; if ($lado_nombre == "left") { echo 'selected="selected"'; } echo '>'.izquierda.'</option>';
											echo '<option value = "center"  '; if ($lado_nombre == "center") { echo 'selected="selected"'; } echo '>'.centro.'</option>';
											echo '<option value = "right"  '; if ($lado_nombre == "right") { echo 'selected="selected"'; } echo '>'.derecha.'</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_gen_enl_nom.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'enlace_nombre','ValorSeleccionado'=>$enlace_nombre, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_can_mos.'</td>';
									echo '<td>';
										echo '<input type = "text" name = "cantidad_listar" size = "5" onkeypress="return solo_num(event)" value = "'.$cantidad_listar.'" title ="'.tit_solo_numeros.'" />';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col1.'</td>';
									echo '<td>';
										echo '<select name = "nom_por_col1">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $nom_por_col1) { echo 'selected="selected"'; } echo '  >'.$a.'</option>';}												
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col2.'</td>';
									echo '<td>';
										echo '<select name = "nom_por_col2">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $nom_por_col2) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td colspan="2" ><hr /></td></tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ver_enl_ver.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_enlace_ver','ValorSeleccionado'=>$ver_enlace_ver, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_lad_enl_ver.'</td>';
									echo '<td>';
										echo '<select name = "lado_enalce_ver">';
											echo '<option value = "left"  '; if ($lado_enalce_ver == "left") { echo 'selected="selected"'; } echo '>'.izquierda.'</option>';
											echo '<option value = "center"  '; if ($lado_enalce_ver == "center") { echo 'selected="selected"'; } echo '>'.centro.'</option>';
											echo '<option value = "right"  '; if ($lado_enalce_ver == "right") { echo 'selected="selected"'; } echo '>'.derecha.'</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col1.'</td>';
									echo '<td>';
										echo '<select name = "enl_por_col1">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $enl_por_col1) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col2.'</td>';
									echo '<td>';
										echo '<select name = "enl_por_col2">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $enl_por_col2) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td colspan="2"><hr /></td></tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ver_tit.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_titulo','ValorSeleccionado'=>$ver_titulo, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ord_tit.'</td>';
									echo '<td>';
										echo '<select name = "orden_titulo">';
											echo '<option value = "1"  '; if ($orden_titulo == "1") { echo 'selected="selected"'; } echo '>1</option>';
											echo '<option value = "2"  '; if ($orden_titulo == "2") { echo 'selected="selected"'; } echo '>2</option>';
											echo '<option value = "3"  '; if ($orden_titulo == "3") { echo 'selected="selected"'; } echo '>3</option>';
											echo '<option value = "4"  '; if ($orden_titulo == "4") { echo 'selected="selected"'; } echo '>4</option>';
											echo '<option value = "5"  '; if ($orden_titulo == "5") { echo 'selected="selected"'; } echo '>5</option>';
											echo '<option value = "6"  '; if ($orden_titulo == "6") { echo 'selected="selected"'; } echo '>6</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_lad_tit.'</td>';
									echo '<td>';
										echo '<select name = "lado_titulo">';
											echo '<option value = "left"  '; if ($lado_titulo == "left") { echo 'selected="selected"'; } echo '>'.izquierda.'</option>';
											echo '<option value = "center"  '; if ($lado_titulo == "center") { echo 'selected="selected"'; } echo '>'.centro.'</option>';
											echo '<option value = "right"  '; if ($lado_titulo == "right") { echo 'selected="selected"'; } echo '>'.derecha.'</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col1.'</td>';
									echo '<td>';
										echo '<select name = "tit_por_col1">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $tit_por_col1) { echo 'selected="selected"'; } echo '  >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col2.'</td>';
									echo '<td>';
										echo '<select name = "tit_por_col2">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $tit_por_col2) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td colspan="2" ><hr /></td></tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ver_num.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_numero','ValorSeleccionado'=>$ver_numero, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ord_num.'</td>';
									echo '<td>';
										echo '<select name = "orden_numero">';
											echo '<option value = "1"  '; if ($orden_numero == "1") { echo 'selected="selected"'; } echo '>1</option>';
											echo '<option value = "2"  '; if ($orden_numero == "2") { echo 'selected="selected"'; } echo '>2</option>';
											echo '<option value = "3"  '; if ($orden_numero == "3") { echo 'selected="selected"'; } echo '>3</option>';
											echo '<option value = "4"  '; if ($orden_numero == "4") { echo 'selected="selected"'; } echo '>4</option>';
											echo '<option value = "5"  '; if ($orden_numero == "5") { echo 'selected="selected"'; } echo '>5</option>';
											echo '<option value = "6"  '; if ($orden_numero == "6") { echo 'selected="selected"'; } echo '>6</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_lad_num.'</td>';
									echo '<td>';
										echo '<select name = "lado_numero">';
											echo '<option value = "left"  '; if ($lado_numero == "left") { echo 'selected="selected"'; } echo '>'.izquierda.'</option>';
											echo '<option value = "center"  '; if ($lado_numero == "center") { echo 'selected="selected"'; } echo '>'.centro.'</option>';
											echo '<option value = "right"  '; if ($lado_numero == "right") { echo 'selected="selected"'; } echo '>'.derecha.'</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col1.'</td>';
									echo '<td>';
										echo '<select name = "num_por_col1">';
											for($a=0;$a<=100;$a++)
												{ echo '<option value = "'.$a.'" '; if ($a == $num_por_col1) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col2.'</td>';
									echo '<td>';
										echo '<select name = "num_por_col2">';
											for($a=0;$a<=100;$a++)
												{ echo '<option value = "'.$a.'" '; if ($a == $num_por_col2) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td colspan="2"><hr /></td></tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ver_lug.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_lugar','ValorSeleccionado'=>$ver_lugar, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';	
								echo '<tr>';
									echo '<td>'.lap_txt_ver_fec.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_fecha','ValorSeleccionado'=>$ver_fecha, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ord_lug_fec.'</td>';
									echo '<td>';
										echo '<select name = "orden_lugar_fecha">';
											echo '<option value = "1"  '; if ($orden_lugar_fecha == "1") { echo 'selected="selected"'; } echo '>1</option>';
											echo '<option value = "2"  '; if ($orden_lugar_fecha == "2") { echo 'selected="selected"'; } echo '>2</option>';
											echo '<option value = "3"  '; if ($orden_lugar_fecha == "3") { echo 'selected="selected"'; } echo '>3</option>';
											echo '<option value = "4"  '; if ($orden_lugar_fecha == "4") { echo 'selected="selected"'; } echo '>4</option>';
											echo '<option value = "5"  '; if ($orden_lugar_fecha == "5") { echo 'selected="selected"'; } echo '>5</option>';
											echo '<option value = "6"  '; if ($orden_lugar_fecha == "6") { echo 'selected="selected"'; } echo '>6</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_lad_lug_fec.'</td>';
									echo '<td>';
										echo '<select name = "lado_lugar_fecha">';
											echo '<option value = "left"  '; if ($lado_lugar_fecha == "left") { echo 'selected="selected"'; } echo '>'.izquierda.'</option>';
											echo '<option value = "center"  '; if ($lado_lugar_fecha == "center") { echo 'selected="selected"'; } echo '>'.centro.'</option>';
											echo '<option value = "right"  '; if ($lado_lugar_fecha == "right") { echo 'selected="selected"'; } echo '>'.derecha.'</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col1.'</td>';
									echo '<td>';
										echo '<select name = "lug_por_col1">';
											for($a=0;$a<=100;$a++)
												{ echo '<option value = "'.$a.'" '; if ($a == $lug_por_col1) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col2.'</td>';
									echo '<td>';
										echo '<select name = "lug_por_col2">';
											for($a=0;$a<=100;$a++)
												{ echo '<option value = "'.$a.'" '; if ($a == $lug_por_col2) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	 }
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td colspan="2" ><hr /></td></tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ver_resc.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_resumen_chico','ValorSeleccionado'=>$ver_resumen_chico, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ord_resc.'</td>';
									echo '<td>';
										echo '<select name = "orden_resumen_chico">';
											echo '<option value = "1"  '; if ($orden_resumen_chico == "1") { echo 'selected="selected"'; } echo '>1</option>';
											echo '<option value = "2"  '; if ($orden_resumen_chico == "2") { echo 'selected="selected"'; } echo '>2</option>';
											echo '<option value = "3"  '; if ($orden_resumen_chico == "3") { echo 'selected="selected"'; } echo '>3</option>';
											echo '<option value = "4"  '; if ($orden_resumen_chico == "4") { echo 'selected="selected"'; } echo '>4</option>';
											echo '<option value = "5"  '; if ($orden_resumen_chico == "5") { echo 'selected="selected"'; } echo '>5</option>';
											echo '<option value = "6"  '; if ($orden_resumen_chico == "6") { echo 'selected="selected"'; } echo '>6</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col1.'</td>';
									echo '<td>';
										echo '<select name = "resc_por_col1">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'"'; if ($a == $resc_por_col1) { echo 'selected="selected"'; } echo '  >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col2.'</td>';
									echo '<td>';
										echo '<select name = "resc_por_col2">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $resc_por_col2) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td colspan="2" ><hr /></td></tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ver_resg.'</td>';
									echo '<td>';
										HtmlAdmon::RadiosSiNO(array('NombreRadio'=>'ver_resumen_grande','ValorSeleccionado'=>$ver_resumen_grande, 'orden'=>'si-no'));
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_ord_resg.'</td>';
									echo '<td>';
										echo '<select name = "orden_resumen_graden">';
											echo '<option value = "1"  '; if ($orden_resumen_graden == "1") { echo 'selected="selected"'; } echo '>1</option>';
											echo '<option value = "2"  '; if ($orden_resumen_graden == "2") { echo 'selected="selected"'; } echo '>2</option>';
											echo '<option value = "3"  '; if ($orden_resumen_graden == "3") { echo 'selected="selected"'; } echo '>3</option>';
											echo '<option value = "4"  '; if ($orden_resumen_graden == "4") { echo 'selected="selected"'; } echo '>4</option>';
											echo '<option value = "5"  '; if ($orden_resumen_graden == "5") { echo 'selected="selected"'; } echo '>5</option>';
											echo '<option value = "6"  '; if ($orden_resumen_graden == "6") { echo 'selected="selected"'; } echo '>6</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col1.'</td>';
									echo '<td>';
										echo '<select name = "resg_por_col1">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $resg_por_col1) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>'.lap_txt_por_col2.'</td>';
									echo '<td>';
										echo '<select name = "resg_por_col2">';
											for($a=0;$a<=100;$a++)
												{echo '<option value = "'.$a.'" '; if ($a == $resg_por_col2) { echo 'selected="selected"'; } echo ' >'.$a.'</option>';	}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="archivo" value = "../librerias/modulos/articulos_lista/articulos_lista_admon.php" />';
										echo '<input type="hidden" name="clase" value = "clase_articulos_lista" />';
										echo '<input type="hidden" name="metodo" value = "configurar" />';	
										echo '<input type="hidden" name="estado" value = "'.$estado.'" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
										echo '<input type="hidden" name="clave_articulo_lista" value = "'.$clave_articulo_lista.'" />';		
										echo '<input type="hidden" name="clave_seccion" value = "'.$clave_seccion_enviada.'" />';
										echo '<input type="submit" name="btn_guardar" value="'.guardar.'" onclick= "return validar_form(this.form)" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
							echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';	
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						HtmlAdmon::boton_regreso(array('clave_usar'=>$clave_seccion_enviada,'texto'=>regresar_opc_mod));
					}
			}	
// ------------------------------ Fin de funciones para controlar la modificaci�n de la informaci�n del m�dulo
// ------------------------------ Inicio de funciones para controlar los cambios de la informaci�n del m�dulo
// ------------------------------ Fin de funciones para controlar los cambios de la informaci�n del m�dulo			
	}
?>