<?php
/*
Sistema: Nazep
Nombre archivo: configuracion_gral.php
Función archivo: Genera las opciones para configurar el sistema en forma general
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class clase_configuracion extends conexion
	{
		function opciones($user,$correo)
			{
						HtmlAdmon::titulo_seccion("Configuraci&oacute;n del Administrador Nazep");
						html::div(array('presentacion'=>'echo', 'tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',							
											'opcionNavega'=>'2',
											'name'=>'nueva_noticia',
											'Id'=>'nueva_noticia',
											'BText'=>'Ingresar nueva noticia del administrador',
											'BName'=>'btn_nueva_noticia',
											'OpcOcultas' => array('metodo' =>'nuevo_noticia_admon') ))
										));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'modifica_noticia',
											'Id'=>'modifica_noticia',
											'BText'=>'Modifica una noticia del administrador',
											'BName'=>'btn_mod_noticia',
											'OpcOcultas' => array('metodo' =>'modificar_noticia_admon')))
							));
						html::hr(array('presentacion'=>'echo','id'=>'hr_01'));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'nuevo_user',
											'Id'=>'<strong>nuevo_user</strong>',											
											'BText'=>'Ingresar nuevo usuario al sistema de administraci&oacute;n',
											'BName'=>'btn_nuevo_user',
											'OpcOcultas' => array('metodo' =>'nuevo_usuario_admon')
											))
							));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'modificar_user',
											'Id'=>'modificar_user',
											'BText'=>'Modificar un usuario del sistema de administraci&oacute;n',
											'BName'=>'btn_modificar_user',
											'OpcOcultas' => array('metodo' =>'modificar_usuario_admon')
											))
							));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'registro_accesos',
											'Id'=>'registro_accesos',
											'BText'=>'Registro de accesos al sistema',
											'BName'=>'btn_registro_accesos',
											'OpcOcultas' => array('metodo' =>'registro_accesos')
											))
							));
							
						html::hr(array('presentacion'=>'echo','id'=>'hr_02'));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'nuevo_user_vista',
											'Id'=>'nuevo_user_vista',
											'BText'=>'Ingresar nuevo usuario del portal',
											'BName'=>'btn_nuevo_user_vista',
											'OpcOcultas' => array('metodo' =>'nuevo_usuario_vista')
											))
							));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'modificar_user_vista',
											'Id'=>'modificar_user_vista',
											'BText'=>'Modificar usuario del portal',
											'BName'=>'btn_modificar_user_vista',
											'OpcOcultas' => array('metodo' =>'modificar_usuario_vista')
											))
							));	

						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'configurar_user_final',
											'Id'=>'configurar_user_final',
											'BText'=>'Configuraci&oacute;n usuario del portal',
											'BName'=>'btn_configurar_user_vista',
											'OpcOcultas' => array('metodo' =>'configurar_usuario_vista')
											))
							));							
								
						html::hr(array('presentacion'=>'echo','id'=>'hr_03'));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'nuevo_modulo',
											'Id'=>'nuevo_modulo',
											'BText'=>'Ingresar nuevo m&oacute;dulo al sistema',
											'BName'=>'btn_nuevo_modulo',
											'OpcOcultas' => array('metodo' =>'nuevo_modulo')
											))
							));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'modificar_modulo',
											'Id'=>'modificar_modulo',
											'BText'=>'Modifiar m&oacute;dulo del sistema',
											'BName'=>'btn_modificar_modulo',
											'OpcOcultas' => array('metodo' =>'modificar_modulo')
											))
							));
						html::hr(array('presentacion'=>'echo','id'=>'hr_04'));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'nuevo_tema',
											'Id'=>'nuevo_tema',
											'BText'=>'Ingresar nuevo tema al sistema',
											'BName'=>'btn_nuevo_tema',
											'OpcOcultas' => array('metodo' =>'nuevo_tema')
											))
							));					
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'modificar_tema',
											'Id'=>'modificar_tema',
											'BText'=>'Modificar temas',
											'BName'=>'btn_nuevo_tema',
											'OpcOcultas' => array('metodo' =>'modificar_tema')
											))
							));
						html::hr(array('presentacion'=>'echo','id'=>'hr_05'));
						html::div(array('presentacion'=>'echo','tipo'=>'inifin', 'style'=>' text-align:center;', 'contenido'=>
							HtmlAdmon::AccesoMetodo(array(
											'presentacion'=>'return',
											'opcionNavega'=>'2',
											'name'=>'configuracion',
											'Id'=>'configuracion',
											'BText'=>'Configuraci&oacute;n general',
											'BName'=>'btn_configuracion',
											'OpcOcultas' => array('metodo' =>'configuracion')
											))
							));					
			}
		function nuevo_noticia_admon($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$situacion = $_POST["situacion"];
						$titulo = $_POST["titulo"];
						$resumen = $_POST["resumen"];
						$cuerpo = $_POST["cuerpo"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$insertar_noticia = "insert into nazep_noticias_admo
						(nick_user_crea, fecha_noticia, hora_noticia, ip_creacion, situacion, 
						titulo, resumen, cuerpo, visitas)
						values ('$user','$fecha_hoy','$hora_hoy','$ip','$situacion','$titulo','$resumen','$cuerpo','0')";
						$conexion = $this->conectarse();
						if (!@mysql_query($insertar_noticia))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: Insertar en la base de datos, la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{ echo "termino-,*-$formulario_final"; }
						$this->desconectarse($conexion);
					}
				else
					{
						$variable_archivos = directorio_archivos."0/";
						$_SESSION["direccion_archivos"] = $variable_archivos;
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("nuevo_noticia_admon");
									});							
								function validar_form(formulario, nombre_formulario)
									{
										valor_titulo = FCKeditorAPI.__Instances["titulo"].GetHTML();
										formulario.titulo.value = valor_titulo; 										
										if(formulario.titulo.value == "")
											{
												alert("El campo del T\u00EDtulo de la noticia no puede quedar vac\u00EDo");
												location.href="#titulo_link";	
												return false;
											}
										valor_resumen = FCKeditorAPI.__Instances["resumen"].GetHTML();
										formulario.resumen.value = valor_resumen; 
										if(formulario.resumen.value == "") 
											{
												alert("El campo del Resumen de la noticia no puede quedar vac\u00EDo");
												location.href="#resumen_link";
												return false;
											}
										valor_cuerpo = FCKeditorAPI.__Instances["cuerpo"].GetHTML();
										formulario.cuerpo.value = valor_cuerpo; 
										if(formulario.cuerpo.value == "") 
											{
												alert("El campo del Cuerpo de la noticia no puede quedar vac\u00EDo");
												location.href="#cuerpo_link";	
												return false
											}
										formulario.btn_guardar.style.visibility="hidden";
										formulario.btn_guardar2.style.visibility="hidden";
										formulario.formulario_final.value = nombre_formulario;
									}';
						echo '</script>';
						HtmlAdmon::titulo_seccion("Ingresar una nueva noticia al administrador");
						echo '<form name="regresar_pantalla" id= "regresar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
						echo '<input type="hidden" name="metodo" value = "nuevo_noticia_admon" />';
						echo '</form>';	
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="get" action="index.php" class="margen_cero">';
						echo '<input type="hidden" name="opc" value = "2" />';
						echo '</form>';						
						$ubi_tema_admon = "temas/nazep/";
						echo '<form name="nuevo_noticia_admon" id="nuevo_noticia_admon" method="post" action="index.php?opc=2" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>Situaci&oacute;n de la noticia</td>';
									echo '<td>';
										echo 'Activa <input type="radio" name="situacion" value="activo" checked="checked" /> ';
										echo 'Cancelada <input type="radio" name="situacion" value="cancelado"  /> ';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td align="center"><a name="titulo_link" id="titulo_link"></a><br />T&iacute;tulo de la noticia</td></tr>';
								echo '<tr>';
									echo '<td>';
										$oFCKeditor1 = new FCKeditor("titulo") ;
										$oFCKeditor1->BasePath = "../librerias/fckeditor/";		
										$oFCKeditor1->ToolbarSet = "texto_simple";
										$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
										$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';	
										$oFCKeditor1->Config['EnterMode'] = '<br>';
										$oFCKeditor1->Width = "100%";
										$oFCKeditor1->Height = "90";
										$oFCKeditor1->Create();	
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align="center"><a name="resumen_link" id="resumen_link"></a><br />Resumen de la noticia</td></tr>';
								echo '<tr>';
									echo '<td>';
										$oFCKeditor2 = new FCKeditor("resumen");
										$oFCKeditor2->BasePath = "../librerias/fckeditor/";
										$oFCKeditor2->ToolbarSet = "Default";
										$oFCKeditor2->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
										$oFCKeditor2->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';
										$oFCKeditor2->Config['EnterMode'] = '<br>';
										$oFCKeditor2->Width = "100%";
										$oFCKeditor2->Height = "250";
										$oFCKeditor2->Create();	
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align="center"><a name="cuerpo_link" id="cuerpo_link"></a><br />Cuerpo de la noticia</td></tr>';
								echo '<tr>';
									echo '<td>';
										$oFCKeditor3 = new FCKeditor("cuerpo") ;
										$oFCKeditor3->BasePath = "../librerias/fckeditor/";
										$oFCKeditor3->ToolbarSet = "Default";
										$oFCKeditor3->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
										$oFCKeditor3->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';
										$oFCKeditor3->Config['EnterMode'] = '<br>';
										$oFCKeditor3->Width = "100%";
										$oFCKeditor3->Height = "450";
										$oFCKeditor3->Create();	
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="metodo" value = "nuevo_noticia_admon" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar nueva noticia" onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
										echo '<input type="submit" name="btn_guardar2" value="Guardar nueva noticia y crear otra" onclick= "return validar_form(this.form, \'regresar_pantalla\')" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php?opc=2" class="regresar">';
									echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
									echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
			}
		function modificar_noticia_admon($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$situacion = $_POST["situacion"];
						$titulo = $_POST["titulo"];
						$resumen = $_POST["resumen"];
						$cuerpo = $_POST["cuerpo"];
						$clave_noticia_admon = $_POST["clave_noticia_admon"];
						$update = "update nazep_noticias_admo
						set situacion = '$situacion', titulo = '$titulo', 
						resumen= '$resumen', cuerpo = '$cuerpo' where clave_noticia_admon = '$clave_noticia_admon'";
						$conexion = $this->conectarse();
						if (!@mysql_query($update))
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
					
						if(FunGral::_Post("clave_noticia_admon")!="")
							{
								$clave_noticia_admon = $_POST["clave_noticia_admon"];
								$variable_archivos = directorio_archivos."0/";
								$_SESSION["direccion_archivos"] = $variable_archivos;
								echo '<script type="text/javascript">
										$(document).ready(function()
											{
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("modificar_noticia_admon");
											});
										function validar_form(formulario)
											{
												valor_titulo = FCKeditorAPI.__Instances[\'titulo\'].GetHTML();
												formulario.titulo.value = valor_titulo; 
												if(formulario.titulo.value == "") 
													{
														alert("El campo del T\u00EDtulo de la noticia no puede quedar vac\u00EDo");
														location.href=\'#titulo_link\';	
														return false
													}
												valor_resumen = FCKeditorAPI.__Instances[\'resumen\'].GetHTML();
												formulario.resumen.value = valor_resumen; 
												if(formulario.resumen.value == "") 
													{
														alert("El campo del Resumen de la noticia no puede quedar vac\u00EDo");
														location.href=\'#resumen_link\';
														return false
													}
													
												valor_cuerpo = FCKeditorAPI.__Instances[\'cuerpo\'].GetHTML();
												formulario.cuerpo.value = valor_cuerpo; 
												if(formulario.cuerpo.value == "") 
													{
														alert("El campo del Cuerpo de la noticia no puede quedar vac\u00EDo");
														location.href=\'#cuerpo_link\';	
														return false
													}
												formulario.btn_guardar.style.visibility="hidden";
											}';
								echo '</script>';
								HtmlAdmon::titulo_seccion("Modificar la Noticia");
								$consulta_noticia = "select situacion, titulo, resumen, cuerpo from nazep_noticias_admo where clave_noticia_admon = '$clave_noticia_admon'";
								$conexion = $this->conectarse();
								$res_consulta = mysql_query($consulta_noticia);
								$ren_consulta = mysql_fetch_array($res_consulta);
								$situacion = $ren_consulta["situacion"];
								$titulo	= $ren_consulta["titulo"];
								$resumen = $ren_consulta["resumen"];
								$cuerpo = $ren_consulta["cuerpo"];
								$ubi_tema_admon = "temas/nazep/";
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
								echo '<input type="hidden" name="metodo" value = "modificar_noticia_admon" />';
								echo '<input type="hidden" name="clave_noticia_admon" value = "'.$clave_noticia_admon.'" />';
								echo '</form>';									
								echo '<form name="modificar_noticia_admon" id="modificar_noticia_admon" method="post" action="index.php?opc=2" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td>Situaci&oacute;n de la noticia</td>';
											echo '<td>';
												echo 'Activa <input type="radio" name="situacion" value="activo"  '; if ($situacion == "activo") { echo ' checked="checked" '; } echo ' /> ';
												echo 'Cancelada <input type="radio" name="situacion" value="cancelado"  '; if ($situacion == "cancelado") { echo ' checked="checked" '; } echo '  /> ';											
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td align="center"><a name="titulo_link" id="titulo_link"></a><br />T&iacute;tulo de la noticia</td></tr>';
										echo '<tr>';
											echo '<td>';
												$oFCKeditor1 = new FCKeditor("titulo") ;
												$oFCKeditor1->BasePath = "../librerias/fckeditor/";		
												$oFCKeditor1->ToolbarSet = "texto_simple";
												$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
												$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';
												$oFCKeditor1->Config['EnterMode'] = 'br';
												$oFCKeditor1->Width = "100%";
												$oFCKeditor1->Height = "90";
												$oFCKeditor1->Value = $titulo;	
												$oFCKeditor1->Create();	
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td align="center"><a name="resumen_link" id="resumen_link"></a><br />Resumen de la noticia</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>';
												$oFCKeditor2 = new FCKeditor("resumen") ;
												$oFCKeditor2->BasePath = "../librerias/fckeditor/";		
												$oFCKeditor2->ToolbarSet = "Default";
												$oFCKeditor2->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
												$oFCKeditor2->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';
												$oFCKeditor2->Width = "100%";
												$oFCKeditor2->Height = "250";
												$oFCKeditor2->Value = $resumen;	
												$oFCKeditor2->Create();
											echo '</td>';
										echo '</tr>';
										echo '<tr><td align="center"><a name="cuerpo_link" id="cuerpo_link"></a><br />Cuerpo de la noticia</td></tr>';
										echo '<tr>';
											echo '<td>';
												$oFCKeditor3 = new FCKeditor("cuerpo") ;
												$oFCKeditor3->BasePath = "../librerias/fckeditor/";
												$oFCKeditor3->ToolbarSet = "Default";
												$oFCKeditor3->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
												$oFCKeditor3->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';
												$oFCKeditor3->Width = "100%";
												$oFCKeditor3->Height = "450";
												$oFCKeditor3->Value = $cuerpo;
												$oFCKeditor3->Create();	
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="clave_noticia_admon" value = "'.$clave_noticia_admon.'" />';
												echo '<input type="hidden" name="metodo" value = "modificar_noticia_admon" />';
												echo '<input type="submit" name="btn_guardar" value="Guardar cambio en la noticia" onclick="return validar_form(this.form)" />';	
											echo '</td>';
										 echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								echo '<form name="reg_noticias" method="post" action="index.php?opc=2">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="metodo" value = "modificar_noticia_admon" />';
												echo '<a href="javascript:document.reg_noticias.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<strong>Regresar al listado de noticias</strong></a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								HtmlAdmon::titulo_seccion("Listado de noticias");
								$cons_gral = "select clave_noticia_admon from nazep_noticias_admo";
								$conexion = $this->conectarse();
								$res_gral = mysql_query($cons_gral);
								$can_tot_gral = mysql_num_rows($res_gral);
								$cantidad_resultados = 10;
								$pagina=0;
								if(FunGral::_Get("pagina")=='')
									{
										$pagina= 1;
										$inicio = 0;
									}
								else
									{
										$pagina = FunGral::_GetLimpioInt("pagina");
										$inicio = ($pagina - 1) * $cantidad_resultados;
									}
								$total_paginas = ceil($can_tot_gral/ $cantidad_resultados);	
								$con_pag = "select clave_noticia_admon, fecha_noticia, situacion, titulo
								from nazep_noticias_admo order by fecha_noticia limit $inicio, $cantidad_resultados";
								$res_pag = mysql_query($con_pag);
								$contador = 0;
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td><strong>T&iacute;tulo</strong></td>';
										echo '<td><strong>Fecha</strong></td>';
										echo '<td><strong>Situaci&oacute;n</strong></td>';
										echo '<td><strong>Modificar</strong></td>';
									echo '</tr>';
									while($ren_p = mysql_fetch_array($res_pag))
										{
											if(($contador%2)==0)
												{ $color = 'bgcolor="#F9D07B"'; }
											else
												{ $color = ''; }
											$clave_noticia_admon = $ren_p["clave_noticia_admon"];
											$fecha_noticia = $ren_p["fecha_noticia"];
											$fecha_noticia = FunGral::FechaNormal($fecha_noticia);
											$situacion = $ren_p["situacion"];
											$titulo = $ren_p["titulo"];
											echo '<tr>';
												echo '<td '.$color.'>'.$titulo.'</td >';
												echo '<td '.$color.'>'.$fecha_noticia.'</td >';
												echo '<td '.$color.'>'.$situacion.'</td>';
												echo '<td '.$color.'>';
													echo '<form name="modificar_noticia_'.$clave_noticia_admon.'" action="index.php?opc=2" method="post" class="margen_cero" >';
														echo '<input type="hidden" name="metodo" value = "modificar_noticia_admon" />';
														echo '<input type="hidden" name="clave_noticia_admon" value = "'.$clave_noticia_admon.'" />';
														echo '<input type="submit" name="Submit" value="ir" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align = "center">';
										if ($total_paginas > 1)
											{
												for ($i=1;$i<=$total_paginas;$i++)
													{
														echo '<form name="not_p_'.$i.'" action="index.php?opc=2&amp;pagina='.$i.'" method="post" >';
															echo '<input type="hidden" name="metodo" value = "modificar_noticia_admon" />';
														echo '</form>';
													}
											}
									echo '</td></tr>';
									echo '<tr>';
										echo '<td align = center>';
										if ($total_paginas > 1)
											{
												for ($i=1;$i<=$total_paginas;$i++)
													{
														if ($pagina == $i)
															echo '<strong><u>'.$i.'</u></strong>';
														else
															echo '<a title="Pagina # '.$i.'" href="javascript:document.not_p_'.$i.'.submit()">'.$i.'</a>';
														
														echo '&nbsp;';
													}
											}
										echo '</td>';
									echo '</tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<a href="index.php?opc=2" class="regresar">';
											echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
											echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
										echo '</td>';
									echo '</tr>';
								echo '</table>';
							}
					}
			}
		function nuevo_usuario_admon($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_seccion = $_POST["clave_seccion"];
						$nick_user = $_POST["nick_user_admon"];
						$nombre = $_POST["nombre"];
						$correo_electronico = $_POST["correo_electronico"];
						$direccion = $_POST["direccion"];
						$clave_nivel = $_POST["clave_nivel"];
						$situacion = $_POST["situacion"];
						$tipo_guardar  = $_POST["tipo_guardar"];
						if($tipo_guardar == "guardar")
							{
								$pasword1 = $_POST["pasword1_admon"];
								$pasword1 = md5($pasword1);
							}
						elseif($tipo_guardar == "enviar")
							{
								$str = "ABCDEFGHJLMNPQRSTUVWXYZabcdefghijmnpqrstuvwxyz23456789";
								$pass = "";
								for($i=0;$i<7;$i++) 
									{
										$pass .= substr($str,rand(0,53),1);
									}
								$pasword1 = md5($pass);
							}
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$insert_user = "insert into nazep_usuarios_admon
						(nick_user, pasword, nombre, email, direccion, nivel, situacion, fecha_creacion, hora_creacion,
						ip_creacion, fecha_actualizacion, hora_actualizacion, ip_actualizacion)
						values('$nick_user','$pasword1', '$nombre', '$correo_electronico','$direccion','$clave_nivel',
						'$situacion', '$fecha_hoy', '$hora_hoy', '$ip', '$fecha_hoy', '$hora_hoy', '$ip')";
						$insert_clave ="insert into nazep_usuarios_secciones_admon 
						(fecha_creacion, hora_creacion, ip_creacion, nick_user, clave_seccion, situacion)
						values
						('$fecha_hoy', '$hora_hoy', '$ip', '$nick_user', '$clave_seccion', '$situacion')";
						$paso = false;
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insert_user))
							{
								$men = mysql_error();
								mysql_query("ROLLBACK;");
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;
								if (!@mysql_query($insert_clave))
									{
										$men = mysql_error();
										mysql_query("ROLLBACK;");
										$paso = false;
										$error = 2;
									}
								else
									{
										$paso = true;
										if($tipo_guardar == 'guardar')
											{}
										elseif($tipo_guardar == 'enviar')
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
												$mail->AddAddress ($correo_electronico,$nombre);
												$mail->IsHTML(true);
												$mail->Subject = "Nuevo usuario administrativo";
												$mail->Body =
												"<strong>Hola $nombre</strong>
												<br><br>
												$mensaje_nuevo_usuario_admon
												<br /><br />
												Nick: $nick_user
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
													}
												else 
													{
														$paso = true;
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
							{echo "Error: <strong>$error</strong> <br/> con el siguiente mensaje: $men";}
						$this->desconectarse($conexion);
					}
				else
					{
						echo '<script type="text/javascript">';
						echo ' $(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("nuevo_usuario_admon");
									});							
								function validar_form(formulario, tipo, nombre_formulario)
									{
										formulario.tipo_guardar.value = tipo;
										if(formulario.nick_user_admon.value == "") 
											{
												alert("El campo nick del usuario no puede quedar vac\u00EDo")
												formulario.nick_user_admon.focus();
												return false;
											}
										if(tipo=="guardar")
											{
												if(formulario.pasword1_admon.value == "")
													{
														alert("El campo password no puede quedar vac\u00EDo");
														formulario.pasword1_admon.focus();
														return false;
													}
												if(formulario.pasword2_admon.value == "") 
													{
														alert("El campo repetir password no puede quedar vac\u00EDo");
														formulario.pasword2_admon.focus();
														return false;
													}
												if(formulario.pasword1_admon.value != formulario.pasword2_admon.value) 
													{
														alert("Los campos de pasword son diferentes ingresar datos iguales");
														formulario.pasword1_admon.focus();
														return false;
													}
											}
										if(formulario.nombre.value == "")
											{
												alert("El campo nombre completo no puede quedar vac\u00EDo");
												formulario.nombre.focus();
												return false;
											}
										if(formulario.correo_electronico.value == "")
											{
												alert("El campo correo electr\u00F3nico no puede quedar vac\u00EDo");
												formulario.correo_electronico.focus();
												return false;
											}
										correo = formulario.correo_electronico.value;
										if(!isEmailAddress(correo))
											{
												alert("Ingresar una direcci\u00F3n de correo electr\u00F3nico v\u00E1lida");
												formulario.correo_electronico.focus();
												return false;
											}
										if(formulario.direccion.value == "")
											{
												alert("El campo direcci\u00F3n no puede quedar vac\u00EDo")
												formulario.direccion.focus();
												return false;
											}
										formulario.btn_guardar1.style.visibility="hidden";
										formulario.btn_guardar2.style.visibility="hidden";
									}';
						echo '</script>';	
						$con_secc ="select clave_seccion, nombre from nazep_secciones where situacion = 'activo' or situacion = 'oculto' order by nombre";
						$conexion = $this->conectarse();
						$res_con = mysql_query($con_secc);
						HtmlAdmon::titulo_seccion("Ingresar un nuevo usuario al administrador");
						echo '<form name="recargar_pantalla" id="recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
							echo '<input type="hidden" name="metodo" value = "nuevo_usuario_admon" />';
						echo '</form>';						
						echo '<form name="nuevo_usuario_admon" id="nuevo_usuario_admon" method="post" action="index.php?opc=2">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td width="270">Secci&oacute;n que adminsitrar&aacute;</td>';
									echo '<td>';
										echo '<select name = "clave_seccion">';
											while($row= mysql_fetch_array($res_con))
												{
													$clave_seccion = $row["clave_seccion"];
													$nombre_seccion = $row["nombre"];
													echo '<option value = '.$clave_seccion.'>'.$nombre_seccion .'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>Nick del usuario</td><td><input type = "text" autocomplete="off" name = "nick_user_admon" size = "40" /></td></tr>';
								echo '<tr><td>Password del usuario</td><td><input type = "password" autocomplete="off" name = "pasword1_admon" size = "40" /></td></tr>';
								echo '<tr><td>Repetir password del usuario</td><td><input type = "password" autocomplete="off" name = "pasword2_admon" size = "40" /></td></tr>';
								echo '<tr><td>Nombre completo del usuario</td><td><input type = "text" name = "nombre" size = "60" /></td></tr>';
								echo '<tr><td>Correo electr&oacute;nico</td><td><input type = "text" name = "correo_electronico" size = "60" /></td></tr>';
								echo '<tr><td>Direcci&oacute;n</td><td><textarea name="direccion" cols="40" rows="5"></textarea></td></tr>';
								echo '<tr><td>Tipo de usuario</td><td>';
										echo 'Admnistrador<input type="radio" name="clave_nivel" value="1" checked="checked" /> ';
										echo 'Editor <input type="radio" name="clave_nivel" value="2"  /> ';
										echo 'Capturista <input type="radio" name="clave_nivel" value="3"  /> ';											
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>Situaci&oacute;n</td><td>';
									echo 'Activo <input type="radio" name="situacion" value="activo" checked="checked" /> ';
									echo 'Cancelado <input type="radio" name="situacion" value="cancelado"  /> ';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="metodo" value = "nuevo_usuario_admon" />';
										echo '<input type="hidden" name="tipo_guardar" value = "guardar" />';
										echo '<input type="submit" name="btn_guardar1" value="Guardar nuevo usuario" onclick= "return validar_form(this.form, \'guardar\')" />';
									echo '</td><td>';
										echo '<input type="submit" name="btn_guardar2" value="Generar password, nuevo usuario y enviar a su correo" onclick= "return validar_form(this.form, \'enviar\')" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php?opc=2" class="regresar"><img src="imagenes/atras.gif" align="middle" border="0" alt ="atras" /><br />';
									echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
			}
		function registro_accesos($user, $correo)
			{
				if(FunGral::_Post("opcion_2")=='si')
					{
						if(FunGral::_Post("exportar")=='si')
							{
								$consulta_registro = "select nick_user, ip_acceso , fecha_intento, hora_intento, estado_intento
								from nazep_registro_acceso  where  tipo_intento = 'admon' order by fecha_intento, hora_intento desc ";
								$conexion = $this->conectarse();
								$res_registro = mysql_query($consulta_registro);
								$can_registros = mysql_num_rows($res_registro);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
									echo '<tr>';
										echo '<td align="center"><strong>Nombre de usuario</strong></td>';	
										echo '<td align="center"><strong>Ip de acceso</strong></td>';	
										echo '<td align="center"><strong>Fecha de inteto</strong></td>';	
										echo '<td align="center"><strong>Hora de intento</strong></td>';	
										echo '<td align="center"><strong>Estado del intento</strong></td>';	
									echo '</tr>';	
									$contador=0;
									while($ren_registro = mysql_fetch_array($res_registro))
										{
											if(($contador%2)==0)
												$color = 'bgcolor="#F9D07B"';
											else
												$color = '';									
											$nick_user = $ren_registro["nick_user"];
											$ip_acceso = $ren_registro["ip_acceso"];
											$fecha_intento = $ren_registro["fecha_intento"];
											$fecha_intento = FunGral::FechaNormalDMA($fecha_intento);									
											$hora_intento = $ren_registro["hora_intento"];
											$estado_intento = $ren_registro["estado_intento"];
											if($estado_intento=="fallo")
												$temporal_class ='style="color:#FF0000"';
											else
												$temporal_class ='style="color:#008000"';
											echo '<tr>';
												echo '<td '.$color.' align="left">'.$nick_user.'</td>';	
												echo '<td '.$color.' align="left">'.$ip_acceso.'</td>';	
												echo '<td '.$color.' align="left">'.$fecha_intento.'</td>';	
												echo '<td '.$color.' align="left">'.$hora_intento.' Hrs.</td>';	
												echo '<td '.$color.' '.$temporal_class.'align="left"><strong>'.$estado_intento.'</strong></td>';	
											echo '</tr>';
											$contador++;
										}
								echo '</table><br/>';								
							}
						elseif(FunGral::_Post("guardar")=='si')
							{
								$formulario_final = $_POST["formulario_final"];		
								$con_borradro="truncate table nazep_registro_acceso";
								$conexion = $this->conectarse();
								mysql_query("START TRANSACTION;");
								if (!@mysql_query($con_borradro))
									{
										$men = mysql_error();
										echo "Error: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
									}
								else
									{ echo "termino-,*-$formulario_final"; }
							}
					}
				elseif(FunGral::_Post("buscar")=='si')
					{
						$fecha_inicio = $_POST["ano_i"]."-".$_POST["mes_i"]."-".$_POST["dia_i"];
						$fecha_fin = $_POST["ano_t"]."-".$_POST["mes_t"]."-".$_POST["dia_t"];
						HtmlAdmon::titulo_seccion("Registro de Acesos al Sistema");
						$fecha_i = FunGral::FechaNormal($fecha_inicio);
						$fecha_t = FunGral::FechaNormal($fecha_fin);						
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
							echo '<tr><td align="center"><strong>'.de.' '.$fecha_i.' '.a.' '.$fecha_t.'</strong></td></tr>';
						echo '</table><br/>';
						$consulta_registro = "select nick_user, ip_acceso , fecha_intento, hora_intento, estado_intento
						from nazep_registro_acceso  where fecha_intento >= '$fecha_inicio' and fecha_intento <= '$fecha_fin' and tipo_intento = 'admon' 
						order by fecha_intento, hora_intento desc ";
						$conexion = $this->conectarse();
						$res_registro = mysql_query($consulta_registro);
						$can_registros = mysql_num_rows($res_registro);
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
							echo '<tr>';
								echo '<td align="center"><strong>Nombre de usuario</strong></td>';	
								echo '<td align="center"><strong>Ip de acceso</strong></td>';	
								echo '<td align="center"><strong>Fecha de inteto</strong></td>';	
								echo '<td align="center"><strong>Hora de intento</strong></td>';	
								echo '<td align="center"><strong>Estado del intento</strong></td>';	
							echo '</tr>';	
							$contador=0;
							while($ren_registro = mysql_fetch_array($res_registro))
								{
									if(($contador%2)==0)
										$color = 'bgcolor="#F9D07B"';
									else
										$color = '';								
									$nick_user = $ren_registro["nick_user"];
									$ip_acceso = $ren_registro["ip_acceso"];
									$fecha_intento = $ren_registro["fecha_intento"];
									$fecha_intento = FunGral::FechaNormalDMA($fecha_intento);									
									$hora_intento = $ren_registro["hora_intento"];
									$estado_intento = $ren_registro["estado_intento"];
									if($estado_intento=="fallo")
										$temporal_class ='style="color:#FF0000"';
									else
										$temporal_class ='style="color:#008000"';
									echo '<tr>';
										echo '<td '.$color.' align="left">'.$nick_user.'</td>';	
										echo '<td '.$color.' align="left">'.$ip_acceso.'</td>';	
										echo '<td '.$color.' align="left">'.$fecha_intento.'</td>';	
										echo '<td '.$color.' align="left">'.$hora_intento.' Hrs.</td>';	
										echo '<td '.$color.' '.$temporal_class.'align="left"><strong>'.$estado_intento.'</strong></td>';	
									echo '</tr>';
									$contador++;
								}
						echo '</table><br/>';
						echo '<form name="reg_buscador_reg" method="post" action="index.php?opc=2" class="margen_cero">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="metodo" value = "registro_accesos" />';
										echo '<a href="javascript:document.reg_buscador_reg.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
										echo '<strong>Regresar al Buscador de Registros</strong></a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
				else
					{
						HtmlAdmon::titulo_seccion("Buscar Registros de Acceso al Sistema");
						echo '<script type="text/javascript">';
						echo '$(document).ready(function()
									{									
										$.guardar_valores("borrar_registro");
									});
								function validar_borrado()
									{
										var respuesta = confirm("Esta petici\u00F3n borrara de manera definitiva todo el registro \n \u00BFDesa Continuar?");
										if(respuesta)
											{ return true; 	}
										else
											{ return false; }
									}';
						echo '</script>';										
						echo '<form name="buscar_registro" id="buscar_registro" method="post"  action="index.php?opc=2" class="margen_cero" >';
							echo '<input type="hidden" name="metodo" value = "registro_accesos" />';						
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>'.fecha_ini_bus.'</td>';
									echo '<td>';
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
												{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'.$arreglo_meses[$b].'</option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_i">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{ echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td >'.fecha_fin_bus.'</td>';
									echo '<td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										echo dia.'&nbsp;<select name = "dia_t">';
											for ($a = 1; $a<=31; $a++)
												{ echo '<option value = "'.$a.'" '; if ($dia == $a) { echo ' selected="selected" '; } echo ' >'.$a.'</option>';}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes_t">';
											for ($b=1; $b<=12; $b++)
												{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected="selected" ';} echo ' >'.$arreglo_meses[$b].'</option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano_t">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{ echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected="selected" ';} echo '>'.$b.'</option>';}
										echo '</select>&nbsp;';
									echo '</td>';
								echo '</tr>';
							echo '</table><br />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';	
									echo '<td align="center">';
										echo '<input type="hidden" name="buscar" value ="si" />';
										echo '<input type="submit" name="btn_buscar" value="'.buscar.'" />';
									echo '</td>';
								echo '</tr>';
							echo '</table>';							
						echo '</form>';
						echo '<hr />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';	
									echo '<td align="center">';
										echo '<form name="exportar_registros" id="exportar_registros" method="post" target="_blank" action="index.php?opc=2" class="margen_cero" >';
											echo '<input type="hidden" name="exportar" value ="si" />';
											echo '<input type="hidden" name="formato_contenido" value ="excel" />';
											echo '<input type="hidden" name="opcion_2" value ="si" />';
											echo '<input type="submit" name="btn_buscar" value="Exportar todo el registro a excel" />';
											echo '<input type="hidden" name="metodo" value = "registro_accesos" />';											
										echo '</form>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';	
									echo '<td align="center">';
										echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
											echo '<input type="hidden" name="metodo" value = "registro_accesos" />';
											echo '<input type="hidden" name="mensaje_borrado" value = "Finalizo" />';
										echo '</form>';		
										if(FunGral::_Post("mensaje_borrado")=="Finalizo")
											{ echo 'El registro de acceso ha sido Borrado exitosamente'; }
										echo '<form name="borrar_registro" id="borrar_registro" method="post"  action="index.php?opc=2" class="margen_cero" >';

											echo '<input type="submit" onclick= "return validar_borrado()" name="btn_borrar" value="Borrar todo el registro" />';
											echo '<input type="hidden" name="opcion_2" value ="si" />';
											echo '<input type="hidden" name="guardar" value ="si" />';
											echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
											echo '<input type="hidden" name="metodo" value = "registro_accesos" />';
										echo '</form>';
									echo '</td>';
								echo '</tr>';								
							echo '</table>';			
						HtmlAdmon::div_res_oper(array());
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php?opc=2" class="regresar">';
									echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
									echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
			}
		function modificar_usuario_admon($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$nick_user = $_POST["nick_user"];
						$pasword1 = $_POST["pasword1"];
						$pasword2 = $_POST["pasword2"];
						$nombre = $_POST["nombre"];
						$correo_electronico = $_POST["correo_electronico"];
						$direccion = $_POST["direccion"];
						$clave_nivel = $_POST["clave_nivel"];
						$situacion = $_POST["situacion"];
						$tipo_guardar =  $_POST["tipo_guardar"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");		
						$ip = $_SERVER['REMOTE_ADDR'];
						if($tipo_guardar=="enviar")
							{
								$str = "ABCDEFGHJLMNPQRSTUVWXYZabcdefghijmnpqrstuvwxyz23456789";
								$pass = "";
								for($i=0;$i<7;$i++) 
									{
										$pasword1 .= substr($str,rand(0,53),1);
									}
								$pasword_fin = md5($pasword1);
								$set = " pasword = '$pasword_fin' ";
							}
						else
							{
								$set = "nombre = '$nombre', email = '$correo_electronico', direccion = '$direccion', nivel = '$clave_nivel',
								situacion = '$situacion', 
								fecha_actualizacion = '$fecha_hoy', hora_actualizacion = '$hora_hoy', ip_actualizacion = '$ip'";
								if($pasword1 != "" and $pasword2 != "")
									{
										$pasword_fin = md5($pasword1);
										$set .= ", pasword = '$pasword_fin' ";
									}
							}
						$update = "update nazep_usuarios_admon set ". $set."where nick_user = '$nick_user'";
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($update))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;	
								
								if($tipo_guardar=="enviar")
									{
										require("../librerias/phpmailer/class.phpmailer.php");
										$mail = new PHPMailer ();
										$mail->SetLanguage("es","../librerias/phpmailer/language/");
										$con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp, mensaje_nuevo_usuario_admon, url_sitio from nazep_configuracion";
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
										$mail->AddAddress ($correo_electronico,$nombre);
										$mail->IsHTML(true);
										$mail->Subject = "Cambio de contrase�a";
										$mail->Body =
										"<strong>Hola $nombre</strong>
										<br /><br />
										Tu nueva nick es:
										<br /><br />
										$nick_user
										<br /><br />
										Tu nueva contrase�a es:
										<br /><br />
										$pasword1
										<br /><br />
										Direcci�n de administraci�n:
										<br /><br />
										$url_sitio/admon/index.php
										<br /><br /><br />
										Atentamente
										<br /><br />
										$nombre_ad
										"; 
										if(!$mail->Send()) 
											{
												$men = $mail->ErrorInfo;
												$paso = false;
												mysql_query("ROLLBACK;");
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
							{ echo "Error: <strong>$error</strong> <br/> con el siguiente mensaje: $men"; }
						$this->desconectarse($conexion);
					}
				else
					{
						if(FunGral::_Post("nick_user")!="")
							{
								$ini = $_POST["ini"];
								$nick_user = $_POST["nick_user"];
								$con_datos = " select * from nazep_usuarios_admon where nick_user = '$nick_user'";
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
								echo ' $(document).ready(function()
											{									
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("modificar_usuario_admon");
											});									
										function validar_form(formulario, tipo, nombre_formulario)
											{
												formulario.tipo_guardar.value = tipo;
												if(tipo == "guardar")
													{
														if(formulario.pasword1.value != formulario.pasword2.value) 
															{
																alert("Los campos de pasword son diferentes ingresar datos iguales");
																formulario.pasword1.focus();
																return false;
															}	
														if(formulario.nombre.value == "") 
															{
																alert("El campo nombre completo no puede quedar vac\u00EDo");
																formulario.nombre.focus();
																return false;
															}
														if(formulario.correo_electronico.value == "") 
															{
																alert("El campo correo electr�nico no puede quedar vac\u00EDo");
																formulario.correo_electronico.focus();
																return false;
															}
														correo = formulario.correo_electronico.value;	
														if(!isEmailAddress(correo))
															{
																alert("Ingresar una direcci\u00F3n de correo electr\u00F3nico v\u00E1lida");
																formulario.correo_electronico.focus();
																return false;
															}
														if(formulario.direccion.value == "") 
															{
																alert("El campo direcci\u00F3n no puede quedar vac\u00EDo");
																formulario.direccion.focus();
																return false;
															}
													}
												formulario.btn_guardar1.style.visibility="hidden";
												formulario.btn_guardar2.style.visibility="hidden";
												formulario.formulario_final.value = nombre_formulario;
											}';
								echo '</script>';
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
									echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
									echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
									echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
								echo '</form>';
								HtmlAdmon::titulo_seccion("Modificar datos del usuario");								
								echo '<form name="modificar_usuario_admon" id="modificar_usuario_admon" method="post" action="index.php?opc=2" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td width="250">Nick del usuario</td><td>'.$nick_user.'</td></tr>';
										echo '<tr><td>Nuevo password del usuario</td><td><input type = "password" name = "pasword1" size = "40" /></td></tr>';
										echo '<tr><td>Repetir nuevo password del usuario</td><td><input type = "password" name = "pasword2" size = "40" /></td></tr>';
										echo '<tr><td>Nombre completo del usuario</td><td><input type = "text" name = "nombre" size = "60" value ="'.$nombre.'" /></td></tr>';
										echo '<tr><td>Correo electr&oacute;nico</td><td><input type = "text" name = "correo_electronico" size = "60" value ="'.$correo_electronico.'" /></td></tr>';
										echo '<tr><td>Direcci&oacute;n</td><td><textarea name="direccion" cols="40" rows="5">'.$direccion.'</textarea></td></tr>';
										echo '<tr>';
											echo '<td>Tipo de usuario</td>';
											echo '<td>';
												echo '<select name = "clave_nivel">';
													echo '<option value = "1" '; if ($clave_nivel == "1") {echo ' selected="selected" ';} echo ' > Admnistrador  </option>';
													echo '<option value = "2" '; if ($clave_nivel == "2") {echo ' selected="selected" ';} echo ' > Editor  </option>';
													echo '<option value = "3" '; if ($clave_nivel == "3") {echo ' selected="selected" ';} echo ' > Capturista  </option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Situaci&oacute;n</td>';
											echo '<td>';
												echo '<select name = "situacion">';
													echo '<option value = "activo"  '; if ($situacion == "activo") {echo ' selected="selected" ';} echo ' > Activo </option>';
													echo '<option value = "cancelado"  '; if ($situacion == "cancelado") {echo ' selected="selected" ';} echo ' > Suspendido </option>';
													echo '<option value = "bloqueado"  '; if ($situacion == "bloqueado") {echo ' selected="selected" ';} echo ' > Bloqueado </option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td>';
												echo '<input type="hidden" name="formulario_final" value = "" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
												echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
												echo '<input type="hidden" name="tipo_guardar" value = "guardar" />';
												echo '<input type="submit" name="btn_guardar1" value="Guardar cambios" onclick= "return validar_form(this.form, \'guardar\', \'recargar_pantalla\')" />';
											echo '</td>';
											echo '<td><input type="submit" name="btn_guardar2" value="Generar nuevo password y enviar por correo" onclick= "return validar_form(this.form, \'enviar\', \'recargar_pantalla\')" /></td>';
										 echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								echo '<form name="reg_noticias" method="post" action="index.php?opc=2" class="margen_cero">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
												echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
												echo '<a href="javascript:document.reg_noticias.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<strong>Regresar al listado de Usuarios</strong></a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								HtmlAdmon::titulo_seccion("Listado de usuarios del sistema");
								$conexion = $this->conectarse();
								if(FunGral::_Post("ini")!="")
									{ $ini = FunGral::_Post("ini"); }
								else
									{ $ini = 'a'; 	}	
								$abc = FunGral::AbecedarioMin();
								$cantidad = count($abc);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td>';
									for($a=0;$a<$cantidad;$a++)
										{
											$tem = $abc[$a];
											echo '<form name="user_pag_'.$a.'" action="index.php?opc=2" method="post" class="margen_cero">';
												echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
												echo '<input type="hidden" name="ini" value = "'.$tem.'" />';
											echo '</form>';
										}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
									for($a=0;$a<$cantidad;$a++)
										{
											echo '<td align = "center">';
												$tem = $abc[$a];
												$con_user = "select * from nazep_usuarios_admon where nick_user like '$tem%'";
												$res_user = mysql_query($con_user);
												$can_user = mysql_num_rows($res_user);
												if($tem==$ini)
													{
														$con_user_actual = $con_user;
														$cantidad_user = $can_user;
													}
												if($can_user!="")
													{ echo '<a href="javascript:document.user_pag_'.$a.'.submit()">'.$tem.'</a>'; }
											echo '</td>';
										}
									 echo '</tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td >&nbsp;</td></tr>';
									echo '<tr><td align = "center" >Usuarios que comienzan con la letra <strong>'.$ini.'</strong>('.$cantidad_user.')</td></tr>';
									echo '<tr><td align = "center" >&nbsp;</td></tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td><strong>Nick</strong></td>';
										echo '<td><strong>Nivel</strong></td>';
										echo '<td><strong>Situaci&oacute;n</strong></td>';
									echo '</tr>';
									$niveles_user = FunGral::niveles();
									$res_user_actual = mysql_query($con_user_actual);
									$contador = 0;
									while($ren = mysql_fetch_array($res_user_actual))
										{
											if(($contador%2)==0)
												{ $color = 'bgcolor="#F9D07B"'; }
											else
												{ $color = ''; }
											$nick_user = $ren["nick_user"];
											$nivel = $ren["nivel"];
											$situacion = $ren["situacion"];
											echo '<tr>';
												echo '<td '.$color.'>'.$nick_user.'</td>';
												echo '<td '.$color.'>'.$niveles_user[$nivel].'</td>';
												echo '<td '.$color.'>'.$situacion.'</td>';
												echo '<td '.$color.'>';
													echo '<form class="margen_cero" name="moficar_datos_'.$nick_user.'" action="index.php?opc=2" method="post" >';
														echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
														echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
														echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
														echo '<input type="submit" name="Submit" value="Modificar datos" />';
													echo '</form>';
												echo '</td>';
												echo '<td '.$color.'>';
													echo '<form  class="margen_cero" name="agregar_secciones_'.$nick_user.'" action="index.php?opc=2" method="post" >';
														echo '<input type="hidden" name="metodo" value = "agregar_secciones_user" />';
														echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
														echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
														echo '<input type="submit" name="Submit" value="Agregar secciones" />';
													echo '</form>';
												echo '</td>';
												echo '<td '.$color.'>';
													echo '<form class="margen_cero" name="mod_secciones_'.$nick_user.'" action="index.php?opc=2" method="post" >';
														echo '<input type="hidden" name="metodo" value = "modificar_secciones_user" />';
														echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
														echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
														echo '<input type="submit" name="Submit" value="Modificar secciones" />';
													echo '</form>';
												echo '</td>';
											 echo '</tr>';
											 $contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<a href="index.php?opc=2" class="regresar">';
											echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
											echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
										echo '</td>';
									echo '</tr>';
								echo '</table>';
							}
					}
			}
		function agregar_secciones_user($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$nick_user = $_POST["nick_user"];
						$clave_seccion= $_POST["clave_seccion"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");		
						$ip = $_SERVER['REMOTE_ADDR'];		
						$insertar = "insert into nazep_usuarios_secciones_admon
						(fecha_creacion, hora_creacion, ip_creacion, nick_user, clave_seccion, situacion)
						values ('$fecha_hoy', '$hora_hoy', '$ip', '$nick_user', '$clave_seccion', 'activo')";	
						$conexion = $this->conectarse();
						if (!@mysql_query($insertar))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: Insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{ echo "termino-,*-$formulario_final"; }
						$this->desconectarse($conexion);
					}
				else
					{
						$ini = $_POST["ini"];
						$nick_user = $_POST["nick_user"];
						$con_secc = "select clave_seccion, nombre from nazep_secciones
						where  clave_seccion <> all (select clave_seccion from nazep_usuarios_secciones_admon
						where nick_user = '$nick_user') and (situacion = 'activo' or situacion = 'oculto')
						order by nombre";
						$conexion = $this->conectarse();
						$res_con = mysql_query($con_secc);
						echo '<script type="text/javascript">';
						echo ' $(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_agregar_secciones");
									});							
								function validar_form(formulario,nombre_formulario)
									{
										if(formulario.clave_seccion.value == "0") 
											{
												alert("Debe seleccionar una secci\u00F3n")
												formulario.clave_seccion.focus();
												return false
											}
										formulario.btn_guardar.style.visibility="hidden";
										formulario.btn_guardar2.style.visibility="hidden";
										formulario.formulario_final.value = nombre_formulario;
									} ';
						echo '</script>';
						HtmlAdmon::titulo_seccion("Agregar nuevas secciones al usuario: \"$nick_user\"");	
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
							echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
							echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
						echo '</form>';	
						echo '<form name="regresar_pantalla" id= "regresar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
							echo '<input type="hidden" name="metodo" value = "agregar_secciones_user" />';
							echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
							echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
						echo '</form>';							
						echo '<form name="frm_agregar_secciones" id="frm_agregar_secciones" method="post" action="index.php?opc=2" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td width="270">Secci&oacute;n que adminsitrar&aacute;</td>';
									echo '<td>';
										echo '<select name = "clave_seccion">';
											echo '<option value = "0">Seleccionar ... </option>';
											while($row= mysql_fetch_array($res_con))
												{
													$clave_seccion = $row["clave_seccion"];
													$nombre_seccion = $row["nombre"];
													echo '<option value = '.$clave_seccion.'>'.$nombre_seccion .'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';	
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
										echo '<input type="hidden" name="metodo" value = "agregar_secciones_user" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar secci&oacute;n" onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
										echo '<input type="submit" name="btn_guardar2" value="Guardar secci&oacute;n y regresar" onclick= "return validar_form(this.form, \'regresar_pantalla\')" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<form name="reg_noticias" method="post" action="index.php?opc=2">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
										echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
										echo '<a href="javascript:document.reg_noticias.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
										echo '<strong>Regresar al listado de Usuarios</strong></a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
			}
		function modificar_secciones_user($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$clave_secciones_usuario_admon = $_POST["clave_secciones_usuario_admon"];
						$situacion = $_POST["situacion"];
						$conexion = $this->conectarse();
						$update = "update nazep_usuarios_secciones_admon set situacion = '$situacion' where clave_secciones_usuario_admon = '$clave_secciones_usuario_admon'";
						if (!@mysql_query($update))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: Insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{ echo "termino-,*-$formulario_final"; }
						$this->desconectarse($conexion);
					}
				else
					{
						$ini = $_POST["ini"];
						$nick_user = $_POST["nick_user"];
						HtmlAdmon::titulo_seccion("Listado de secciones para el usuario: \"$nick_user \"");
						$con_secc = "select s.nombre, us.situacion, us.clave_secciones_usuario_admon
						from nazep_usuarios_secciones_admon us, nazep_secciones s
						where nick_user = '$nick_user' and us.clave_seccion = s.clave_seccion";
						$conexion = $this->conectarse();
						$res_sec = mysql_query($con_secc);
						$res_sec2 = mysql_query($con_secc);
						echo '<form name="regresar_pantalla" id= "regresar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
							echo '<input type="hidden" name="metodo" value = "modificar_secciones_user" />';
							echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
							echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
						echo '</form>';	
							echo '<script type="text/javascript">';
							while($ren2 = mysql_fetch_array($res_sec2))
								{
									$clave_secciones_usuario_admon = $ren2["clave_secciones_usuario_admon"];
									echo '$(document).ready(function()
											{									
												$.guardar_valores("modificar_secc_'.$clave_secciones_usuario_admon.'");
											});';									
								}
							echo '</script>';
						
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td><strong>Secci&oacute;n</strong></td>';
								echo '<td><strong>Situaci&oacute;n</strong></td>';
								echo '<td><strong>Modificar</strong></td>';
							echo '</tr>';
							$contador = 0;
							while($ren = mysql_fetch_array($res_sec))
								{
									if(($contador%2)==0)
										{ $color = 'bgcolor="#F9D07B"'; }
									else
										{ $color = ''; }									
									$nombre = $ren["nombre"];
									$situacion = $ren["situacion"];
									$clave_secciones_usuario_admon = $ren["clave_secciones_usuario_admon"];									
									echo '<tr>';
										echo '<td '.$color.'>'.$nombre.'</td>';
										echo '<td '.$color.'>'.$situacion.'</td>';
										echo '<td '.$color.'>';
											echo '<form name="modificar_secc_'.$clave_secciones_usuario_admon.'" id="modificar_secc_'.$clave_secciones_usuario_admon.'" action="index.php?opc=2" method="post" class="margen_cero">';
												echo '<input type="hidden" name="formulario_final" value = "regresar_pantalla" />';
												echo '<input type="hidden" name="metodo" value = "modificar_secciones_user" />';
												echo '<input type="hidden" name="nick_user" value = "'.$nick_user.'" />';
												echo '<input type="hidden" name="nombre" value = "'.$nombre.'" />';
												echo '<input type="hidden" name="guardar" value ="si" />';
												echo '<input type="hidden" name="clave_secciones_usuario_admon" value = "'.$clave_secciones_usuario_admon.'" />';
												if($situacion=="activo")
													{ echo '<input type="hidden" name="situacion" value = "cancelado" /><input type="submit" name="Submit" value="Cancelar" />';}
												elseif($situacion=="cancelado")
													{ echo '<input type="hidden" name="situacion" value = "activo" /><input type="submit" name="Submit" value="Activar" />';}
											echo '</form>';
										echo '</td>';
									echo '</tr>';
									$contador++;
								}
						echo '</table>';
						HtmlAdmon::div_res_oper(array());
						echo '<form name="reg_noticias" method="post" action="index.php?opc=2">';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
								echo '<tr>';
									echo '<td align="center">';
										echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
										echo '<input type="hidden" name="metodo" value = "modificar_usuario_admon" />';
										echo '<a href="javascript:document.reg_noticias.submit()" class="regresar">';
										echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
										echo '<strong>Regresar al listado de Usuarios</strong></a>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					}
			}
		function nuevo_usuario_vista($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{	
						$formulario_final = $_POST["formulario_final"];
						$situacion = $_POST["situacion"];
						$nick_usuario = $_POST["nick_usuario_portal"];
						$pasword1 = $_POST["pasword1"];
						$pasword1 = md5($pasword1);
						$nombre = $_POST["nombre"];
						$a_pat = $_POST["a_pat"];
						$a_mat = $_POST["a_mat"];
						$nombre_completo = $nombre." ".$a_pat." ".$a_mat;
						$correo = $_POST["correo"];
						$fecha_nacimiento = $_POST["ano"]."-".$_POST["mes"]."-".$_POST["dia"];
						$ubicacion = $_POST["ubicacion"];
						$web = $_POST["web"];
						$zona_horario = $_POST["zona_horario"];
						$ver_nombre = $_POST["ver_nombre"];
						$ver_mail = $_POST["ver_mail"];
						$ver_ubic = $_POST["ver_ubic"];
						$ver_web = $_POST["ver_web"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$tipo_guardar  = $_POST["tipo_guardar"];
						if($tipo_guardar == "guardar")
							{
								$pasword1 = $_POST["pasword1"];
								$pasword1 = md5($pasword1);
							}
						elseif($tipo_guardar == "enviar")
							{
								$str = "ABCDEFGHJLMNPQRSTUVWXYZabcdefghijmnpqrstuvwxyz23456789";
								$pass = "";
								for($i=0;$i<7;$i++) 
									{
										$pass .= substr($str,rand(0,53),1);
									}
								$pasword1 = md5($pass);
							}
						$insert = "insert into nazep_usuarios_final
						(nick_usuario, fecha_alta, hora_alta, pasword, nombre, a_pat , a_mat, situacion, correo,
						fecha_nacimiento, ubicacion, ip_alta, web, ver_nombre, ver_mail, ver_ubic, ver_web, 
						zona_horario, codigo_seguridad, fecha_ultima_visita)
						values ('$nick_usuario', '$fecha_hoy', '$hora_hoy', '$pasword1', '$nombre', '$a_pat', '$a_mat', '$situacion',
						 '$correo', '$fecha_nacimiento', '$ubicacion', '$ip', '$web', '$ver_nombre','$ver_mail', '$ver_ubic', 
						 '$ver_web', '$zona_horario', '', '$fecha_hoy')";
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($insert))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;
								if($tipo_guardar == "enviar")
									{
										require("../librerias/phpmailer/class.phpmailer.php");
										$mail = new PHPMailer ();
										$mail->SetLanguage("es","../librerias/phpmailer/language/");
										$con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp, 
										mensaje_nuevo_usuario_vista, url_sitio
										from nazep_configuracion ";
										$res_con = mysql_query($con_conf);
										$ren_con = mysql_fetch_array($res_con);
										$envio_correo = $ren_con["envio_correo"];
										$servidor_smtp = $ren_con["servidor_smtp"];
										$user_smtp = $ren_con["user_smtp"];
										$pass_smtp	= $ren_con["pass_smtp"];
										$mensaje_nuevo_usuario_vista = $ren_con["mensaje_nuevo_usuario_vista"];
										$url_sitio = $ren_con["url_sitio"];
										$con_datos_user = "select nombre, email from nazep_usuarios_admon where nick_user = 'admin'";
										$res_datos = mysql_query($con_datos_user);
										$ren_datos = mysql_fetch_array($res_datos);
										$nombre_ad = $ren_datos["nombre"];
										$email_ad = $ren_datos["email"];
										if($envio_correo =="php")
											{}
										elseif($envio_correo =="smtp")
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
										$mail->AddAddress($correo, $nombre_completo);
										$mail->IsHTML(true);
										$mail->Subject = "Nuevo usuario del portal";
										$mail->Body ="<strong>Hola $nombre_completo</strong>
										<br /><br />
										$mensaje_nuevo_usuario_vista
										<br /><br />
										Nick: $nick_usuario
										<br />
										Pasword: $pass
										<br /><br />
										Direcci�n de portal:
										<br /><br />
										$url_sitio/index/index.php
										<br /><br /><br />
										Atentamente
										<br /><br />
										$nombre_ad";
										if(!$mail->Send()) 
											{
												$men = $mail->ErrorInfo;
												$paso = false;
												mysql_query("ROLLBACK;");
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
							{ echo "Error: <strong>$error</strong> <br/> con el siguiente mensaje: $men"; }
						$this->desconectarse($conexion);
					}
				else
					{
						echo '<script type="text/javascript">';
						echo ' $(document).ready(function()
									{
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("nuevo_usuario_vista");
									});							
								function validar_form(formulario, tipo, nombre_formulario)
									{
										formulario.tipo_guardar.value = tipo;
										if(formulario.nick_usuario_portal.value == "") 
											{
												alert("El campo nick del usuario no puede quedar vac\u00EDo")
												formulario.nick_usuario.focus();
												return false;
											}
										if(tipo=="guardar")
											{
												if(formulario.pasword1.value == "") 
													{
														alert("El campo password no puede quedar vac\u00EDo")
														formulario.pasword1.focus();
														return false;
													}
												if(formulario.pasword2.value == "") 
													{
														alert("El campo repetir password no puede quedar vac\u00EDo")
														formulario.pasword2.focus();
														return false;
													}
												if(formulario.pasword1.value != formulario.pasword2.value) 
													{
														alert("Los campos de password son diferentes ingresar datos iguales")
														formulario.pasword1.focus();
														return false;
													}
											}
										if(formulario.nombre.value == "") 
											{
												alert("El campo nombre no puede quedar vac\u00EDo")
												formulario.nombre.focus();
												return false;
											}
										if(formulario.a_pat.value == "") 
											{
												alert("El campo Apellido paterno no puede quedar vac\u00EDo")
												formulario.a_pat.focus();
												return false;
											}
										if(formulario.a_mat.value == "") 
											{
												alert("El campo Apellido materno no puede quedar vac\u00EDo")
												formulario.a_mat.focus();
												return false;
											}
										if(formulario.correo.value == "") 
											{
												alert("El campo correo electr\u00F3nico no puede quedar vac\u00EDo")
												formulario.correo.focus();
												return false;
											}
										correo = formulario.correo.value;
										if(!isEmailAddress(correo))
											{
												alert("Ingresar una direcci\u00F3n de correo electr\u00F3nico v\u00E1lida");
												formulario.correo.focus();
												return false;
											}
										separador = "/";
										fecha = formulario.dia.value+"/"+formulario.mes.value+"/"+formulario.ano.value;
										if(!verificar_fecha(fecha, separador))
											{
												alert("Debe introduccir una fecha valida");
												formulario.dia.focus(); 
												return false;
											}
										if(formulario.ubicacion.value == "") 
											{
												alert("El campo ubicaci\u00F3n no puede quedar vac\u00EDo")
												formulario.ubicacion.focus();
												return false;
											}
										formulario.btn_guardar1.style.visibility="hidden";
										formulario.btn_guardar2.style.visibility="hidden";
										formulario.formulario_final.value = nombre_formulario;
									} ';
						echo '</script>';
						HtmlAdmon::titulo_seccion("Ingresar un usuario al portal");
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
						echo '<input type="hidden" name="metodo" value = "nuevo_usuario_vista" /></form>';
						echo '<form name="nuevo_usuario_vista" id="nuevo_usuario_vista" method="post" action="index.php?opc=2" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>Situaci&oacute;n</td>';
									echo '<td>';
										echo 'Activo <input type="radio" name="situacion" value="activo" checked="checked" /> ';
										echo 'Cancelado <input type="radio" name="situacion" value="cancelado"  /> ';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>Nick del usuario</td><td><input type = "text" name = "nick_usuario_portal" size = "20"  /></td></tr>';
								echo '<tr><td>Password del usuario</td><td><input type = "password" name = "pasword1" size = "40" /></td></tr>';
								echo '<tr><td>Repetir password del usuario</td><td><input type = "password" name = "pasword2" size = "40" /></td></tr>';
								echo '<tr><td>Nombre</td><td><input type = "text" name = "nombre" size = "60" /></td></tr>';
								echo '<tr><td>Apellido paterno</td><td><input type = "text" name = "a_pat" size = "60" /></td></tr>';
								echo '<tr><td>Apellido materno</td><td><input type = "text" name = "a_mat" size = "60"  /></td></tr>';
								echo '<tr><td>Correo electr&oacute;nico</td><td><input type = "text" name = "correo" size = "60"  /></td></tr>';
								echo '<tr>';
									echo '<td>Fecha de nacimiento</td>';
									echo '<td>';
										$dia=date('d');
										$mes=date('m');
										$ano=date('Y');
										$areglo_meses = FunGral::MesesNumero();
										echo dia.'&nbsp;<select name = "dia">';
											for ($a = 1; $a<=31; $a++)
												{ echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected'; } echo ' >'.$a.'</option>';}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes">';
											for ($b=1; $b<=12; $b++)
												{ echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected ';} echo ' >'. $areglo_meses[$b] .'</option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano">';
											for ($b=$ano-100; $b<=$ano; $b++)
												{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected ';} echo '>'.$b.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>Ubicaci&oacute;n</td><td><input type = "text" name = "ubicacion" size = "60"  /></td></tr>';
								echo '<tr><td>Web</td><td><input type = "text" name = "web" size = "60"  /></td></tr>';
								echo '<tr>';
									echo '<td>Zona horario GMT</td>';
									echo '<td>';
										echo '<select name = "zona_horario"  >';
											for ($b=-12; $b<=12; $b++)
												{ echo '<option value = "'.$b.'" '; if ($b == "0") {echo ' selected ';} echo '>'.$b.'</option>'; }
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Publicar nombre</td>';
									echo '<td>';
										echo '<input type="radio" name="ver_nombre" id ="ver_nombre_no" value="no" checked="checked"  /> '.no.'&nbsp;';
										echo '<input type="radio" name="ver_nombre" id ="ver_nombre_si"   value="si"  /> '.si.'&nbsp;';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Publicar correo</td>';
									echo '<td>';
										echo '<input type="radio" name="ver_mail" id ="ver_mail_no" value="no" checked="checked"  /> '.no.'&nbsp;';
										echo '<input type="radio" name="ver_mail" id ="ver_mail_si"   value="si"  /> '.si.'&nbsp;';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Publicar ubicaci&oacute;n</td>';
									echo '<td>';
										echo '<input type="radio" name="ver_ubic" id ="ver_ubic_no" value="no" checked="checked"  /> '.no.'&nbsp;';
										echo '<input type="radio" name="ver_ubic" id ="ver_ubic_si"   value="si"  /> '.si.'&nbsp;';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Publicar Web</td>';
									echo '<td>';
										echo '<input type="radio" name="ver_web" id ="ver_web_no" value="no" checked="checked"  /> '.no.'&nbsp;';
										echo '<input type="radio" name="ver_web" id ="ver_web_si"   value="si"  /> '.si.'&nbsp;';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';	
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="metodo" value = "nuevo_usuario_vista" />';
										echo '<input type="hidden" name="tipo_guardar" value = "guardar" />';
										echo '<input type="submit" name="btn_guardar1" value="Guardar nuevo usuario" onclick= "return validar_form(this.form, \'guardar\',\'recargar_pantalla\')" />';
									echo '</td>';
									echo '<td align ="center">';
										echo '<input type="submit" name="btn_guardar2" value="Generar password, nuevo usuario y enviar a su correo" onclick= "return validar_form(this.form, \'enviar\', \'recargar_pantalla\')" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php?opc=2" class="regresar">';
									echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
									echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
			}
		function modificar_usuario_vista($user,$correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$situacion = $_POST["situacion"];
						$nick_usuario = $_POST["nick_usuario"];
						$pasword1 = $_POST["pasword1"];
						$pasword2 = $_POST["pasword2"];
						$nombre = $_POST["nombre"];
						$a_pat = $_POST["a_pat"];
						$a_mat = $_POST["a_mat"];
						$nombre_completo = $nombre." ".$a_pat." ".$a_mat;
						$correo = $_POST["correo"];
						$fecha_nacimiento = $_POST["ano"]."-".$_POST["mes"]."-".$_POST["dia"];
						$ubicacion = $_POST["ubicacion"];
						$web = $_POST["web"];
						$zona_horario = $_POST["zona_horario"];
						$ver_nombre = $_POST["ver_nombre"];
						$ver_mail = $_POST["ver_mail"];
						$ver_ubic = $_POST["ver_ubic"];
						$ver_web = $_POST["ver_web"];
						$tipo_guardar =  $_POST["tipo_guardar"];
						if($tipo_guardar=="enviar")
							{
								$str = "ABCDEFGHJLMNPQRSTUVWXYZabcdefghijmnpqrstuvwxyz23456789";
								$pass = "";
								for($i=0;$i<7;$i++) 
									{
										$pasword1 .= substr($str,rand(0,53),1);
									}
								$pasword_fin = md5($pasword1);
								$set = " pasword = '$pasword_fin' ";
							}
						else
							{
								$set =" nombre = '$nombre', a_pat = '$a_pat', a_mat = '$a_mat', situacion = '$situacion', correo = '$correo',
								fecha_nacimiento = '$fecha_nacimiento', ubicacion = '$ubicacion', web = '$web', ver_nombre = '$ver_nombre',
								ver_mail = '$ver_mail',	ver_ubic = '$ver_ubic', ver_web = '$ver_web', zona_horario = '$zona_horario'";
								if($pasword1 != "" and $pasword2 != "")
									{
										$pasword1 = md5($pasword1);
										$set .= ", pasword = '$pasword1' ";
									}
							}
							
						$update = "update nazep_usuarios_final set ". $set."where nick_usuario = '$nick_usuario'";
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						if (!@mysql_query($update))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
							}
						else
							{
								$paso = true;
								if($tipo_guardar=="enviar")
									{
										require("../librerias/phpmailer/class.phpmailer.php");
										$mail = new PHPMailer ();
										$mail->SetLanguage("es","../librerias/phpmailer/language/");
										$con_conf ="select envio_correo, servidor_smtp, user_smtp, pass_smtp, 
										mensaje_nuevo_usuario_admon, url_sitio
										from nazep_configuracion ";
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
										
										if($envio_correo =="php")
											{ $con = '<br>php'; }
										elseif($envio_correo =="smtp")
											{
												$mail->IsSMTP();
												$mail->Host = $servidor_smtp;
												$mail->SMTPAuth = true;     
												$mail->Username = $user_smtp; 
												$mail->Password = $pass_smtp; 
												$mail->Mailer  = "smtp";	
												$con = "<br>smtp";
											}
										if($servidor_smtp=="ssl://smtp.gmail.com")
											{	
												$mail->Port = 465;
											}
										$mail->From = $email_ad;
										$mail->FromName = " ".$nombre_ad." ";
										$mail->AddAddress ($correo, $nombre_completo);
										$mail->IsHTML(true);
										$mail->Subject = "Cambio de contrase�a";
										$mail->Body =
										"<strong>Hola $nombre_completo</strong>
										<br /><br />
										Tu nueva contrase�a es:
										<br /><br />
										$pasword1
										<br /><br />
										Direcci�n del portal:
										<br /><br />
										$url_sitio/index/index.php
										<br /><br /><br />
										Atentamente
										<br /><br />
										$nombre_ad";
										if(!$mail->Send()) 
											{
												$men = $mail->ErrorInfo;
												$paso = false;
												mysql_query("ROLLBACK;");
											}
										else 
											{ $paso = true; }
									}
							}
						if($paso)
							{	
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";	
							}
						else
							{
								echo "Error: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						$this->desconectarse($conexion);
					}
				else
					{
						if(FunGral::_Post("nick_usuario")!="")
							{
								$ini = FunGral::_Post("ini");
								$nick_usuario = FunGral::_Post("nick_usuario");
								HtmlAdmon::titulo_seccion("Modificar datos del usuario: \"$nick_usuario\"");
								$con_user = "select * from nazep_usuarios_final where nick_usuario = '$nick_usuario'";
								$conexion = $this->conectarse();
								$res_con = mysql_query($con_user);
								$ren_con = mysql_fetch_array($res_con);
								$nick_usuario = $ren_con["nick_usuario"];
								$nombre = $ren_con["nombre"];
								$a_mat = $ren_con["a_mat"];
								$a_pat = $ren_con["a_pat"];
								$situacion = $ren_con["situacion"];
								$correo = $ren_con["correo"];
								$fecha_nacimiento = $ren_con["fecha_nacimiento"];
								list($ano, $mes, $dia) = explode("-",$fecha_nacimiento);
								$ubicacion = $ren_con["ubicacion"];
								$web = $ren_con["web"];
								$ver_nombre = $ren_con["ver_nombre"];
								$ver_mail = $ren_con["ver_mail"];
								$ver_ubic = $ren_con["ver_ubic"];
								$ver_web = $ren_con["ver_web"];
								$zona_horario = $ren_con["zona_horario"];
								echo '<script type="text/javascript">';
								echo ' $(document).ready(function()
											{									
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("frm_nuevo_usuario_vista");
											});									
										function validar_form(formulario, tipo, nombre_formulario)
											{
												formulario.tipo_guardar.value = tipo;
												if(tipo == "guardar")
													{
														if(formulario.pasword1.value != formulario.pasword2.value) 
															{
																alert("Los campos de password son diferentes ingresar datos iguales")
																formulario.pasword1.focus();
																return false
															}	
														if(formulario.nombre.value == "") 
															{
																alert("El campo nombre no puede quedar vac\u00EDo")
																formulario.nombre.focus();
																return false
															}
														if(formulario.a_pat.value == "") 
															{
																alert("El campo Apellido paterno no puede quedar vac\u00EDo")
																formulario.a_pat.focus();
																return false
															}
														if(formulario.a_mat.value == "") 
															{
																alert("El campo Apellido materno no puede quedar vac\u00EDo")
																formulario.a_mat.focus();
																return false
															}
														if(formulario.correo.value == "") 
															{
																alert("El campo correo electr\u00F3nico no puede quedar vac\u00EDo")
																formulario.correo.focus();
																return false
															}
														correo = formulario.correo.value;
														if(!isEmailAddress(correo))
															{
																alert("Ingresar una direcci\u00F3n de correo electr\u00F3nico v\u00E1lida");
																formulario.correo.focus();
																return false
															}
														separador = "/";
														fecha = formulario.dia.value+"/"+formulario.mes.value+"/"+formulario.ano.value;
														if(!verificar_fecha(fecha, separador))
															{
																alert("Debe introduccir una fecha valida");
																formulario.dia.focus(); 
																return false;
															}
														if(formulario.ubicacion.value == "") 
															{
																alert("El campo ubicaci\u00F3n no puede quedar vac\u00EDo")
																formulario.ubicacion.focus();
																return false;
															}
													}
												formulario.btn_guardar1.style.visibility=\'hidden\';
												formulario.btn_guardar2.style.visibility=\'hidden\';
												formulario.formulario_final.value = nombre_formulario;
											} ';
								echo '</script>';
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
								echo '<input type="hidden" name="metodo" value = "modificar_usuario_vista" /><input type="hidden" name="ini" value = "'.$ini.'" /><input type="hidden" name="nick_usuario" value = "'.$nick_usuario.'" /></form>';								
								echo '<form name="frm_nuevo_usuario_vista" id="frm_nuevo_usuario_vista" method="post" action="index.php?opc=2" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>Nick del usuario</td><td>'.$nick_usuario.'</td></tr>';
										echo '<tr>';
											echo '<td>Situaci&oacute;n</td>';
											echo '<td>';
												echo '<select name = "situacion">';
													echo '<option value = "activo"  '; if ($situacion == "activo") { echo 'selected'; } echo ' > Activo </option>';
													echo '<option value = "cancelado" '; if ($situacion == "cancelado") { echo 'selected'; } echo ' > Cancelado </option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>Nuevo password del usuario</td><td><input type = "password" name = "pasword1" size = "40" /></td></tr>';
										echo '<tr><td>Repetir nuevo password del usuario</td><td><input type = "password" name = "pasword2" size = "40" /></td></tr>';
										echo '<tr><td>Nombre</td><td><input type = "text" name = "nombre" size = "60" value ="'.$nombre.'" /></td></tr>';
										echo '<tr><td>Apellido Paterno</td><td><input type = "text" name = "a_pat" size = "60" value ="'.$a_pat.'" /></td></tr>';
										echo '<tr><td>Apellido Materno</td><td><input type = "text" name = "a_mat" size = "60" value ="'.$a_mat.'" /></td></tr>';
										echo '<tr><td>Correo electr&oacute;nico</td><td><input type = "text" name = "correo" size = "60" value ="'.$correo.'" /></td></tr>';
										echo '<tr>';
											echo '<td>Fecha de nacimiento</td>';
											echo '<td>';
												$areglo_meses = FunGral::MesesNumero();
												echo dia.'&nbsp;<select name = "dia">';
												for ($a = 1; $a<=31; $a++)
													{ echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected'; } echo ' >'.$a.'</option>'; }
												echo '</select>&nbsp;';
												echo mes.'&nbsp;<select name = "mes">';
													for ($b=1; $b<=12; $b++)
														{ echo '<option value ="'.$b.'"  '; if ($mes == $b) {echo ' selected ';} echo ' >'. $areglo_meses[$b] .'</option>'; }
												echo '</select>&nbsp;';
												echo ano.'&nbsp;<select name = "ano">';
													for ($b=$ano-100; $b<=$ano; $b++)
														{ echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected ';} echo '>'.$b.'</option>'; }
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr><td>Ubicaci&oacute;n</td><td><input type = "text" name = "ubicacion" size = "60" value ="'.$ubicacion.'" /></td></tr>';

										echo '<tr><td>Web</td><td><input type = "text" name = "web" size = "60" value ="'.$web.'" /></td></tr>';
										echo '<tr>';
											echo '<td>Zona horario GMT</td>';
											echo '<td>';
												echo '<select name = "zona_horario">';
													for ($b=-12; $b<=12; $b++)
														{echo '<option value = "'.$b.'" '; if ($b == $zona_horario) {echo ' selected ';} echo '>'.$b.'</option>';}
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Publicar nombre</td>';
											echo '<td>';
												echo '<input '; if ($ver_nombre == "no") { echo 'checked="checked"'; } echo 'type="radio" name="ver_nombre" id ="ver_nombre_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($ver_nombre == "si") { echo 'checked="checked"'; } echo 'type="radio" name="ver_nombre" id ="ver_nombre_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Publicar correo</td>';
											echo '<td>';
												echo '<input '; if ($ver_mail == "no") { echo 'checked="checked"'; } echo 'type="radio" name="ver_mail" id ="ver_mail_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($ver_mail == "si") { echo 'checked="checked"'; } echo 'type="radio" name="ver_mail" id ="ver_mail_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Publicar ubicaci&oacute;n</td>';
											echo '<td>';
												echo '<input '; if ($ver_ubic == "no") { echo 'checked="checked"'; } echo 'type="radio" name="ver_ubic" id ="ver_ubic_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($ver_ubic == "si") { echo 'checked="checked"'; } echo 'type="radio" name="ver_ubic" id ="ver_ubic_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Publicar Web</td>';
											echo '<td>';
												echo '<input '; if ($ver_web == "no") { echo 'checked="checked"'; } echo 'type="radio" name="ver_web" id ="ver_web_no" value="no"  /> '.no.'&nbsp;';
												echo '<input '; if ($ver_web == "si") { echo 'checked="checked"'; } echo 'type="radio" name="ver_web" id ="ver_web_si" value="si"  /> '.si.'&nbsp;';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
												echo '<input type="hidden" name="formulario_final" value = "" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="nick_usuario" value = "'.$nick_usuario.'" />';
												echo '<input type="hidden" name="metodo" value = "modificar_usuario_vista" />';
												echo '<input type="hidden" name="tipo_guardar" value = "guardar" />';
												echo '<input type="submit" name="btn_guardar1" value="Guardar cambios al usuario" onclick= "return validar_form(this.form, \'guardar\', \'recargar_pantalla\')" />';
											echo '</td>';
											echo '<td align="center"><input type="submit" name="btn_guardar2" value="Generar nuevo password y enviar por correo" onclick= "return validar_form(this.form, \'enviar\', \'recargar_pantalla\')" /></td>';
										 echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								echo '<form name="reg_noticias" method="post" action="index.php?opc=2">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="metodo" value = "modificar_usuario_vista" />';
												echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
												echo '<a href="javascript:document.reg_noticias.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<strong>Regresar al listado de Usuarios</strong></a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								HtmlAdmon::titulo_seccion("Listar usuarios del portal");
								$conexion = $this->conectarse();
								if(FunGral::_Post("ini")!="")
									{ $ini = FunGral::_Post("ini"); }
								else
									{ $ini = 'a'; }
								$abc = FunGral::AbecedarioMin();
								$cantidad = count($abc);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td>';
									foreach($abc as $pos => $val)
										{
											$tem = $val;
											echo '<form name="user_pag_'.$pos.'" action="index.php?opc=2" method="post" >';
												echo '<input type="hidden" name="metodo" value = "modificar_usuario_vista" />';
												echo '<input type="hidden" name="ini" value = "'.$tem.'" />';
											echo '</form>';
										}
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
									$cantidad_user=0;
									foreach($abc as $pos => $val)
										{
											echo '<td align = "center">';
												$tem = $val;
												$con_user = " select * from nazep_usuarios_final where nick_usuario like '$tem%' ";
												$res_user = mysql_query($con_user);
												$can_user = mysql_num_rows($res_user);
												if($tem==$ini)
													{
														$con_user_actual = $con_user;
														$cantidad_user = $can_user;
													}
												if($can_user!='')
													{ echo '<a href="javascript:document.user_pag_'.$pos.'.submit()">'.$tem.'</a>'; }
											echo '</td>';
										}
									 echo '</tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr><td align = "center" >&nbsp;</td></tr>';
									echo '<tr><td align = "center" >Usuarios que comienzan con la letra <strong>'.$ini.'</strong> ('.$cantidad_user.')</td></tr>';
									echo '<tr><td>&nbsp;</td></tr>';
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td><strong>Nick</strong></td>';
										echo '<td><strong>Nombre</strong></td>';
										echo '<td><strong>Situaci&oacute;n</strong></td>';
									echo '</tr>';
									$res_user_actual = mysql_query($con_user_actual);	
									$contador = 0;									
									while($ren = mysql_fetch_array($res_user_actual))
										{
											if(($contador%2)==0)
												{ $color = 'bgcolor="#F9D07B"'; }
											else
												{ $color = ''; }
											$nick_usuario = $ren["nick_usuario"];
											$nombre = $ren["nombre"]."&nbsp;".$ren["a_pat"]."&nbsp;".$ren["a_mat"];
											$situacion = $ren["situacion"];
											echo '<tr>';
												echo '<td  '.$color.'>'.$nick_usuario.'</td>';
												echo '<td  '.$color.'>'.$nombre.'</td>';
												echo '<td  '.$color.'>'.$situacion.'</td>';
												echo '<td  '.$color.'>';
													echo '<form name="mod_modulos_sec_'.$nick_usuario.'" action="index.php?opc=2" method="post" class="margen_cero">';
														echo '<input type="hidden" name="metodo" value = "modificar_usuario_vista" />';
														echo '<input type="hidden" name="nick_usuario" value = "'.$nick_usuario.'" />';
														echo '<input type="hidden" name="ini" value = "'.$ini.'" />';
														echo '<input type="submit" name="Submit" value="Modificar datos" />';
													echo '</form>';
												echo '</td>';
											 echo '</tr>';
											 $contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<a href="index.php?opc=2" class="regresar">';
											echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
											echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
										echo '</td>';
									echo '</tr>';
								echo '</table>';
							}
					}
			}
		function configurar_usuario_vista($user,$correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
					}
				else
					{
						HtmlAdmon::titulo_seccion("Configuraci&oacute;n Usuario Final");
						$con_gral = "select * from nazep_usuarios_final_config";						
					}
			}
			
		function nuevo_modulo($user,$correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$nombre = $_POST["nombre"];
						$descripcion = $_POST["descripcion"];
						$nombre_archivo = $_POST["nombre_archivo"];
						$cadena_sql = $_POST["cadena_sql"];
						$sql_valor = $_POST["sql_valor"];
						$arreglo = explode(";", $cadena_sql);
						$cantidad = count($arreglo);
						$tipo = $_POST["tipo"];
						$situacion = $_POST["situacion"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date("H:i:s");
						$ip = $_SERVER['REMOTE_ADDR'];
						$insert ="insert into nazep_modulos
						(nombre, descripcion, nombre_archivo, cadena_sql, fecha_creacion, hora_creacion, ip_creacion, tipo, situacion)
						values ('$nombre', '$descripcion','$nombre_archivo', '$cadena_sql','$fecha_hoy', '$hora_hoy', '$ip','$tipo', '$situacion')";
						$conexion = $this->conectarse();
						mysql_query("START TRANSACTION;");
						$paso = false;
						if($sql_valor == "si")
							{
								for($a=0; $a<$cantidad; $a++)
									{
										$con_temporal = $arreglo[$a];
										
										if (!@mysql_query($con_temporal))
											{
												$men = mysql_error();
												mysql_query("ROLLBACK;");
												$paso = false;
												$error = 1;
											}
										else
											{
												$paso = true;
											}
									}
							}
						if (!@mysql_query($insert))
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
						if($paso)
							{
								mysql_query("COMMIT;");
								echo "termino-,*-$formulario_final";
							}
						else
							{
								echo "Error: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
					}
				else
					{
						echo '<script type="text/javascript">';
						echo '
								$(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_nuevo_modulo");
									});							
								function validar_form(formulario, nombre_formulario)
									{	
										if(formulario.nombre.value == "") 
											{
												alert("El campo nombre no puede quedar vac\u00EDo")
												formulario.nombre.focus();
												return false;
											}
										if(formulario.nombre_archivo.value == "") 
											{
												alert("El campo nombre del archivo no puede quedar vac\u00EDo")
												formulario.nombre_archivo.focus();
												return false;
											}
										formulario.btn_guardar.style.visibility="hidden";
										formulario.formulario_final.value = nombre_formulario;
									}
								function OpenServerBrowser()
									{
										url = \'../librerias/fckeditor/editor/filemanager2/browser/default/browser.html?Connector=connectors/php/connector.php\'; 	
										width = screen.width * 0.7;
										height  = screen.height * 0.7;	
										iLeft = (screen.width  - width) / 2; 
										iTop  = (screen.height - height) / 2;
										sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes";
										sOptions += ",width=" + width;
										sOptions += ",height=" + height;
										sOptions += ",left=" + iLeft;
										sOptions += ",top=" + iTop;
										window.open(url, "BrowseWindow", sOptions);	
									}
								';
						echo '</script>';
						HtmlAdmon::titulo_seccion("Ingresar un nuevo m&oacute;dulo");
						$_SESSION["archivos_configuracion"] = directorio_librerias."modulos";
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
						echo'<input type="hidden" name="metodo" value = "nuevo_modulo" /></form>';						
						echo '<form name="frm_nuevo_modulo" id="frm_nuevo_modulo" method="post" action="index.php?opc=2" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td>Nombre</td><td><input type = "text" name = "nombre" size = "60" /></td></tr>';
								echo '<tr>';
									echo '<td>Descripci&oacute;n</td><td><textarea name="descripcion" cols="60" rows="5"></textarea></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Nombre del archivo</td><td><input type = "text" name = "nombre_archivo" size = "60" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>&iquest;Existe cadena de sql?</td>';
									echo '<td>';
										echo '<input type="radio" name="sql_valor" id ="sql_valor_no" value="no" /> '.no.'&nbsp;';
										echo '<input type="radio" name="sql_valor" id ="sql_valor_si" value="si" checked="checked" /> '.si.'&nbsp;';									
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>Cadena SQL</td><td><textarea name="cadena_sql" cols="60" rows="8"></textarea></td></tr>';
								echo '<tr>';
									echo '<td>Tipo del m&oacute;dulo</td>';
									echo '<td>';
										echo '<select name = "tipo">';
											echo '<option value = "central" > Central </option>';
											echo '<option value = "secundario" > Secundario</option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Situaci&oacute;n</td>';
									echo '<td>';
										echo '<select name = "situacion" >';
											echo '<option value = "activo" > Activo </option>';
											echo '<option value = "cancelado" > Cancelado </option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Archivos del m&oacute;dulo</td><td><button type="button" onclick="OpenServerBrowser();" > Ver carpetas de archivos </button></td>';
								echo '</tr>';
							echo '</table>';
							echo '<br />';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="metodo" value = "nuevo_modulo" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar nuevo m&oacute;dulo" onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php?opc=2" class="regresar">';
									echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
									echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
			}
		function modificar_modulo($user,$correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$nombre = $_POST["nombre"];
						$descripcion = $_POST["descripcion"];
						$nombre_archivo = $_POST["nombre_archivo"];
						$tipo = $_POST["tipo"];
						$situacion = $_POST["situacion"];
						$clave_modulo  = $_POST["clave_modulo"];
						$update = "update nazep_modulos set nombre = '$nombre', descripcion = '$descripcion', nombre_archivo = '$nombre_archivo', tipo = '$tipo', situacion = '$situacion' where clave_modulo = '$clave_modulo'";
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
						if(FunGral::_Post("clave_modulo")!="")
							{
								HtmlAdmon::titulo_seccion("Modificar M&oacute;dulo");
								$clave_modulo = FunGral::_Post("clave_modulo");
								$con_modulo = "select nombre, descripcion, nombre_archivo, cadena_sql, tipo, situacion from nazep_modulos where  clave_modulo = '$clave_modulo'";
								$conexion = $this->conectarse();
								$res_con = mysql_query($con_modulo);
								$ren_con = mysql_fetch_array($res_con);
								$nombre = $ren_con["nombre"];
								$descripcion = $ren_con["descripcion"];
								$nombre_archivo = $ren_con["nombre_archivo"];
								$cadena_sql = $ren_con["cadena_sql"];
								$tipo = $ren_con["tipo"];
								$situacion = $ren_con["situacion"];
								echo '<script type="text/javascript">';
								echo ' $(document).ready(function()
											{									
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("frm_modificar_modulo");
											});									
										function validar_form(formulario, nombre_formulario)
											{	
												if(formulario.nombre.value == "") 
													{
														alert("El campo nombre del m\u00F3dulo no puede quedar vac\u00EDo")
														formulario.nombre.focus();
														return false
													}
												if(formulario.nombre_archivo.value == "") 
													{
														alert("El campo nombre del archivo no puede quedar vac\u00EDo")
														formulario.nombre_archivo.focus();
														return false
													}
												formulario.btn_guardar.style.visibility=\'hidden\';
												formulario.formulario_final.value = nombre_formulario;
											}
										function OpenServerBrowser(obj)
											{
												url = \'../librerias/fckeditor/editor/filemanager2/browser/default/browser.html?Connector=connectors/php/connector.php\'; 	
												width = screen.width * 0.7;
												height  = screen.height * 0.7;	
												iLeft = (screen.width  - width) / 2; 
												iTop  = (screen.height - height) / 2;
												sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes";
												sOptions += ",width=" + width;
												sOptions += ",height=" + height;
												sOptions += ",left=" + iLeft;
												sOptions += ",top=" + iTop;
												window.open(url, "BrowseWindow", sOptions);	
											} ';
								echo '</script>';
								$_SESSION["archivos_configuracion"] = directorio_librerias."modulos/$nombre_archivo";
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">
								<input type="hidden" name="metodo" value = "modificar_modulo" /><input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" /></form>';
								echo '<form name="frm_modificar_modulo" id="frm_modificar_modulo" method="post" action="index.php?opc=2" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td>Nombre</td><td><input type = "text" name = "nombre" size = "60" value="'.$nombre.'" /></td></tr>';
										echo '<tr><td>Descripci&oacute;n</td><td><textarea name="descripcion" cols="60" rows="5">'.$descripcion.'</textarea></td></tr>';
										echo '<tr><td>Nombre del archivo</td><td><input type = "text" name = "nombre_archivo" size ="60"  value ="'.$nombre_archivo.'" /></td></tr>';
										echo '<tr><td>Cadena SQL</td><td>'.$cadena_sql.'</td></tr>';
										echo '<tr>';
											echo '<td>Tipo del m&oacute;dulo</td>';
											echo '<td>';
												echo '<select name = "tipo">';
													echo '<option value = "central"  '; if ($tipo == "central") {echo ' selected ';} echo ' > Central </option>';
													echo '<option value = "secundario" '; if ($tipo == "secundario") {echo 'selected ';} echo '  > Secundario</option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Situaci&oacute;n</td>';
											echo '<td>';
												echo '<select name="situacion">';
													echo '<option value = "activo"  '; if ($situacion == "activo") {echo 'selected ';} echo ' > Activo </option>';
													echo '<option value = "cancelado"  '; if ($situacion == "cancelado") {echo ' selected ';} echo '  > Cancelado </option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Archivos del m&oacute;dulo</td><td><button type="button" onclick="OpenServerBrowser();"> Ver carpetas de archivos </button></td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="formulario_final" value = "" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="metodo" value = "modificar_modulo" />';
												echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
												echo '<input type="submit" name="btn_guardar" value="Guardar cambios al m&oacute;dulo" onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
											echo '</td>';
										 echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								echo '<form name="reg_listado_modulos" method="post" action="index.php?opc=2">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="metodo" value = "modificar_modulo" />';
												echo '<a href="javascript:document.reg_listado_modulos.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<strong>Regresar al listado de M&oacute;dulos</strong></a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								HtmlAdmon::titulo_seccion("Listado de m&oacute;dulos del sistema");
								$con_modulos = "select clave_modulo, nombre, tipo, situacion from nazep_modulos ";
								$conexion = $this->conectarse();
								$res_con = mysql_query($con_modulos);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td><strong>Nombre</strong></td>';
										echo '<td><strong>Tipo</strong></td>';
										echo '<td><strong>Situaci&oacute;n</strong></td>';	
										echo '<td><strong>Modificar</strong></td>';
									echo '</tr>';
									$contador = 0;
									while($ren = mysql_fetch_array($res_con))
										{
											if(($contador%2)==0)
												{ $color = 'bgcolor="#F9D07B"'; }
											else
												{ $color = ''; }
											$nombre = $ren["nombre"];
											$tipo = $ren["tipo"];
											$situacion = $ren["situacion"];
											$clave_modulo = $ren["clave_modulo"];
											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td '.$color.'>'.$tipo.'</td>';
												echo '<td '.$color.'>'.$situacion.'</td>';
												echo '<td '.$color.'>';
													echo '<form class="margen_cero" name="modificar_modulo_'.$clave_modulo.'" action="index.php?opc=2" method="post" >';
														echo '<input type="hidden" name="metodo" value = "modificar_modulo" />';
														echo '<input type="hidden" name="clave_modulo" value = "'.$clave_modulo.'" />';
														echo '<input type="submit" name="Submit" value="Modificar m&oacute;dulo" />';
													echo '</form>';
												echo '</td>';
											 echo '</tr>';
											 $contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<a href="index.php?opc=2" class="regresar">';
											echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
											echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
										echo '</td>';
									echo '</tr>';
								echo '</table>';
							}
					}
			}	
		function nuevo_tema($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$nombre = $_POST["nombre"];
						$ubicacion = $_POST["ubicacion"];
						$descripcion = $_POST["descripcion"];
						$fecha_hoy = date("Y-m-d");
						$hora_hoy = date ("H:i:s");		
						$ip = $_SERVER['REMOTE_ADDR'];
						$insert_tema = "insert into nazep_temas (nombre, ubicacion, descripcion, fecha_creacion, hora_creacion, ip_creacion, situacion)
						values ('$nombre','$ubicacion','$descripcion', '$fecha_hoy', '$hora_hoy','$ip','activo')";
						$conexion = $this->conectarse();
						if (!@mysql_query($insert_tema))
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
						echo '<script type="text/javascript">';
						echo ' $(document).ready(function()
									{									
										$.frm_elem_color("#FACA70","");
										$.guardar_valores("frm_nuevo_tema");
									});							
								function validar_form(formulario,nombre_formulario)
									{
										if(formulario.nombre.value == "") 
											{
												alert("El campo Nombre del tema no puede quedar vac\u00EDo")
												formulario.nombre.focus();
												return false
											}
										if(formulario.ubicacion.value == "") 
											{
												alert("El campo Carpeta de ubicaci\u00F3n no puede quedar vac\u00EDo")
												formulario.ubicacion.focus();
												return false
											}
										if(formulario.descripcion.value == "") 
											{
												alert("El campo Descripci\u00F3n del tema no puede quedar vac\u00EDo")
												formulario.descripcion.focus();
												return false
											}
										formulario.btn_guardar.style.visibility=\'hidden\';
										formulario.formulario_final.value = nombre_formulario;
									}
								function OpenServerBrowser(obj)
									{
										url = \'../librerias/fckeditor/editor/filemanager2/browser/default/browser.html?Connector=connectors/php/connector.php\'; 	
										width = screen.width * 0.7;
										height  = screen.height * 0.7;	
										iLeft = (screen.width  - width) / 2; 
										iTop  = (screen.height - height) / 2;
										sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes";
										sOptions += ",width=" + width;
										sOptions += ",height=" + height;
										sOptions += ",left=" + iLeft;
										sOptions += ",top=" + iTop;
										window.open(url, "BrowseWindow", sOptions);	
									} ';
						echo '</script>';
						HtmlAdmon::titulo_seccion("Ingresar un nuevo tema");
						$_SESSION["archivos_configuracion"] = directorio_librerias."temas";
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
						echo'<input type="hidden" name="metodo" value = "nuevo_tema" /></form>';
						echo '<form name="frm_nuevo_tema" id="frm_nuevo_tema" method="post" action="index.php?opc=2" >';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td width="150">Nombre del tema</td><td><input type = "text" name = "nombre" size = "40" /></td></tr>';
								echo '<tr><td>Carpeta de ubicaci&oacute;n</td><td><input type ="text" name ="ubicacion" size="40" /></td></tr>';
								echo '<tr><td>Descripci&oacute;n</td><td><textarea name="descripcion" cols="60" rows="5"></textarea></td></tr>';
								echo '<tr><td>Archivos de los temas</td><td><button type="button" onclick="OpenServerBrowser();"> Ver carpetas de archivos </button></td></tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="metodo" value = "nuevo_tema" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar nuevo tema" onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php?opc=2" class="regresar">';
									echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
									echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
			}			
		function modificar_tema($user, $correo)
			{
				if(FunGral::_Post("guardar")=='si')
					{
						$formulario_final = $_POST["formulario_final"];
						$nombre = $_POST["nombre"];
						$ubicacion = $_POST["ubicacion"];
						$descripcion = $_POST["descripcion"];
						$clave_tema = $_POST["clave_tema"]; 
						$situacion = $_POST["situacion"]; 
						$update ="update nazep_temas set situacion = '$situacion', nombre = '$nombre', ubicacion = '$ubicacion', descripcion = '$descripcion' where clave_tema = '$clave_tema'";
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
						if(FunGral::_Post("clave_tema")!="")
							{
								$clave_tema = FunGral::_Post("clave_tema");
								$con_doc ="select * from nazep_temas where clave_tema = '$clave_tema'";
								$conexion = $this->conectarse();
								$res_doc = mysql_query($con_doc);
								$ren_doc = mysql_fetch_array($res_doc);	
								$nombre = $ren_doc["nombre"];
								$ubicacion = $ren_doc["ubicacion"];
								$descripcion = $ren_doc["descripcion"];
								$situacion = $ren_doc["situacion"];	
								echo '<script type="text/javascript">';
								echo ' $(document).ready(function()
											{									
												$.frm_elem_color("#FACA70","");
												$.guardar_valores("frm_modificar_tema");
											});								
										function validar_form(formulario, nombre_formulario)
											{
												if(formulario.nombre.value == "") 
													{
														alert("El campo Nombre del tema no puede quedar vac\u00EDo")
														formulario.nombre.focus();
														return false
													}
												if(formulario.ubicacion.value == "") 
													{
														alert("El campo Carpeta de ubicaci\u00F3n no puede quedar vac\u00EDo")
														formulario.ubicacion.focus();
														return false
													}
												if(formulario.descripcion.value == "") 
													{
														alert("El campo Descripci\u00F3n del tema no puede quedar vac\u00EDo")
														formulario.descripcion.focus();
														return false
													}
												formulario.btn_guardar.style.visibility=\'hidden\';
												formulario.formulario_final.value = nombre_formulario;
											}
										function OpenServerBrowser(obj)
											{
												url = \'../librerias/fckeditor/editor/filemanager2/browser/default/browser.html?Connector=connectors/php/connector.php\'; 	
												width = screen.width * 0.7;
												height  = screen.height * 0.7;	
												iLeft = (screen.width  - width) / 2; 
												iTop  = (screen.height - height) / 2;
												sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes";
												sOptions += ",width=" + width;
												sOptions += ",height=" + height;
												sOptions += ",left=" + iLeft;
												sOptions += ",top=" + iTop;
												window.open(url, "BrowseWindow", sOptions);	
											} ';
								echo '</script>';
								HtmlAdmon::titulo_seccion("Modificar el tema");
								$_SESSION["archivos_configuracion"] = directorio_librerias."temas/$ubicacion/";	
								echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
								echo'<input type="hidden" name="metodo" value = "modificar_tema" /><input type="hidden" name="clave_tema" value = "'.$clave_tema.'" /></form>';
								echo '<form name="frm_modificar_tema" id="frm_modificar_tema" method="post" action="index.php?opc=2" >';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr><td width="150">Nombre del tema</td><td><input type = "text" name = "nombre" size = "40" value = "'.$nombre.'" /></td></tr>';
										echo '<tr><td>Carpeta de ubicaci&oacute;n</td><td><input type = "text" name = "ubicacion" size = "40" value = "'.$ubicacion.'" /></td></tr>';
										echo '<tr><td>Descripci&oacute;n</td><td><textarea name="descripcion" cols="60" rows="5">'.$descripcion.'</textarea></td></tr>';
										echo '<tr>';
											echo '<td>Situaci&oacute;n</td>';
											echo '<td>';
												echo '<select name = "situacion">';
													echo '<option value = "activo"  '; if ($situacion == "activo") {echo ' selected ';} echo ' > Activo </option>';
													echo '<option value = "cancelado" '; if ($situacion == "cancelado") {echo ' selected ';} echo ' > Suspendido </option>';
												echo '</select>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td>Archivos del tema</td><td><button type="button" onclick="OpenServerBrowser();"> Ver carpetas de archivos </button></td>';
										echo '</tr>';
									echo '</table>';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="formulario_final" value = "" />';	
												echo '<input type="hidden" name="clave_tema" value = "'.$clave_tema.'" />';
												echo '<input type="hidden" name="guardar" value = "si" />';
												echo '<input type="hidden" name="metodo" value = "modificar_tema" />';
												echo '<input type="submit" name="btn_guardar" value="Guardar cambios al tema" onclick= "return validar_form(this.form, \'recargar_pantalla\')" />';
											echo '</td>';
										 echo '</tr>';
									echo '</table>';
								echo '</form>';
								HtmlAdmon::div_res_oper(array());
								echo '<form name="reg_lis_temas" method="post" action="index.php?opc=2">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align = "center">';
										echo '<tr>';
											echo '<td align="center">';
												echo '<input type="hidden" name="metodo" value = "modificar_tema" />';
												echo '<a href="javascript:document.reg_lis_temas.submit()" class="regresar">';
												echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
												echo '<strong>Regresar al listado de temas</strong></a>';
											echo '</td>';
										echo '</tr>';
									echo '</table>';
								echo '</form>';
							}
						else
							{
								HtmlAdmon::titulo_seccion("Listado de temas");
								$con_doc ="select * from nazep_temas";
								$conexion = $this->conectarse();
								$res_doc = mysql_query($con_doc);
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td><strong>Nombre</strong></td>';
										echo '<td><strong>Situaci&oacute;n</strong></td>';
										echo '<td><strong>Modificar</strong></td>';
									echo '</tr>';
									$contador = 0;
									while($ren = mysql_fetch_array($res_doc))
										{
											if(($contador%2)==0)
												{ $color = 'bgcolor="#F9D07B"'; }
											else
												{ $color = ''; }
											$nombre = $ren["nombre"];
											$situacion = $ren["situacion"];
											$clave_tema = $ren["clave_tema"];
											echo '<tr>';
												echo '<td '.$color.'>'.$nombre.'</td>';
												echo '<td '.$color.'>'.$situacion.'</td>';
												echo '<td '.$color.'>';
													echo '<form name="modificar_tema_'.$clave_tema.'" action="index.php?opc=2" method="post" class="margen_cero">';
														echo '<input type="hidden" name="metodo" value = "modificar_tema" />';
														echo '<input type="hidden" name="clave_tema" value = "'.$clave_tema.'" />';
														echo '<input type="submit" name="Submit" value="Modificar tema" />';
													echo '</form>';
												echo '</td>';
											echo '</tr>';
											$contador++;
										}
								echo '</table>';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align ="center">';
											echo '<a href="index.php?opc=2" class="regresar">';
											echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
											echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
										echo '</td>';
									echo '</tr>';
								echo '</table>';
							}
					}
			}
		function configuracion($user, $correo)
			{
				if(FunGral::_Post("guardar") == 'si')
					{
						$formulario_final = $_POST["formulario_final"];
						$nombre_sitio = $_POST["nombre_sitio"];
						$url_sitio = $_POST["url_sitio"];
						$lema = $_POST["lema"];
						$pie_sitio  = $_POST["pie_sitio"];
						$fecha_incio = $_POST["ano"]."-".$_POST["mes"]."-".$_POST["dia"];
						$clave_tema = $_POST["clave_tema"];
						$titu_sitio = $_POST["titu_sitio"];
						$envio_correo = $_POST["envio_correo"];
						$servidor_smtp = $_POST["servidor_smtp"];
						$user_smtp = $_POST["user_smtp"];
						$pass_smtp = $_POST["pass_smtp"];
						$lenguaje = $_POST["lenguaje"];
						$clave_buscador = $_POST["clave_buscador"];
						$clave_mapa_sitio = $_POST["clave_mapa_sitio"];
						$clave_recomendar = $_POST["clave_recomendar"];
						$clave_contacto = $_POST["clave_contacto"];
						$mensaje_nuevo_usuario_admon = $_POST["mensaje_nuevo_usuario_admon"];
						$mensaje_nuevo_usuario_vista = $_POST["mensaje_nuevo_usuario_vista"];
						$ver_noticias = $_POST["ver_noticias"];
						$cant_noticias_admon= $_POST["cant_noticias_admon"];
						$ver_pag_inicio = $_POST["ver_pag_inicio"];
						$pag_inicio = $_POST["pag_inicio"];
						$con_no_disponible = $_POST["con_no_disponible"];
						$palabras_clave = $_POST["palabras_clave"]; 
						$resolucion_ancho = $_POST["resolucion_ancho"];
						

						$llave_publica_captcha = $_POST["llave_publica_captcha"];
						$llave_privada_captcha = $_POST["llave_privada_captcha"];						

						
						$update = "update nazep_configuracion set
						nombre_sitio = '$nombre_sitio', url_sitio= '$url_sitio', lema = '$lema', pie_sitio = '$pie_sitio',
						fecha_incio = '$fecha_incio', clave_tema = '$clave_tema', titu_sitio = '$titu_sitio', 
						envio_correo = '$envio_correo', servidor_smtp = '$servidor_smtp', user_smtp = '$user_smtp',
						pass_smtp = '$pass_smtp', lenguaje = '$lenguaje', clave_buscador = '$clave_buscador', 
						clave_mapa_sitio= '$clave_mapa_sitio', clave_recomendar= '$clave_recomendar', clave_contacto= '$clave_contacto',
						palabras_clave = '$palabras_clave',
						mensaje_nuevo_usuario_admon = '$mensaje_nuevo_usuario_admon', mensaje_nuevo_usuario_vista = '$mensaje_nuevo_usuario_vista',
						ver_noticias = '$ver_noticias', resolucion_ancho = '$resolucion_ancho', ver_pag_inicio = '$ver_pag_inicio', pag_inicio= '$pag_inicio',
						cant_noticias_admon = '$cant_noticias_admon', con_no_disponible = '$con_no_disponible',
						 llave_publica_captcha = '$llave_publica_captcha', llave_privada_captcha= '$llave_privada_captcha' 
						  ";
						$conexion = $this->conectarse();
						if (!@mysql_query($update))
							{
								$men = mysql_error();
								$paso = false;
								$error = 1;
								echo "Error: insertar la base de datos la consulta: <strong>$error</strong> <br/> con el siguiente mensaje: $men";
							}
						else
							{
								$sesion_temporal_admon = md5(nombre_base."administracion");
								$_SESSION[$sesion_temporal_admon]->ancho_pixeles = $resolucion_ancho;
								echo "termino-,*-$formulario_final";
							}
						$this->desconectarse($conexion);
					}
				else
					{
						HtmlAdmon::titulo_seccion("Configuraci&oacute;n General");
						$con_gral = "select * from nazep_configuracion";
						$conexion = $this->conectarse();
						$res_gral = mysql_query($con_gral);
						$ren_gral = mysql_fetch_array($res_gral);
						$nombre_sitio = $ren_gral["nombre_sitio"];
						$url_sitio = $ren_gral["url_sitio"];
						$lema = $ren_gral["lema"];
						$fecha_incio = $ren_gral["fecha_incio"];
						list($ano, $mes, $dia) = explode("-",$fecha_incio);
						$clave_tema = $ren_gral["clave_tema"];
						$titu_sitio = $ren_gral["titu_sitio"];
						$envio_correo = $ren_gral["envio_correo"];
						$servidor_smtp = $ren_gral["servidor_smtp"];
						$user_smtp = $ren_gral["user_smtp"];
						$pass_smtp = $ren_gral["pass_smtp"];
						$lenguaje = $ren_gral["lenguaje"];
						$clave_buscador = $ren_gral["clave_buscador"];
						$clave_mapa_sitio = $ren_gral["clave_mapa_sitio"];
						$clave_recomendar = $ren_gral["clave_recomendar"];
						$clave_contacto = $ren_gral["clave_contacto"];
						$clave_rss = $ren_gral["clave_rss"];
						$version = $ren_gral["version"];
						$pie_sitio  = $ren_gral["pie_sitio"];
						$mensaje_nuevo_usuario_admon =  $ren_gral["mensaje_nuevo_usuario_admon"];
						$mensaje_nuevo_usuario_vista =  $ren_gral["mensaje_nuevo_usuario_vista"];
						$ver_noticias = $ren_gral["ver_noticias"];
						$cant_noticias_admon = $ren_gral["cant_noticias_admon"];
						$ver_pag_inicio = $ren_gral["ver_pag_inicio"];
						$pag_inicio = $ren_gral["pag_inicio"];
						$con_no_disponible = $ren_gral["con_no_disponible"];
						$palabras_clave = $ren_gral["palabras_clave"];
						$resolucion_ancho = $ren_gral["resolucion_ancho"];
						
						
						
						$llave_publica_captcha = $ren_gral["llave_publica_captcha"];
						$llave_privada_captcha = $ren_gral["llave_privada_captcha"];
						
						
						
						echo '<script type="text/javascript">
							$(document).ready(function()
								{									
									$.frm_elem_color("#FACA70","");
									$.guardar_valores("frm_configuracion_gral");
								});
							
							function mostrar_ocultar_div(div)
								{
									if ($("#"+div).is (":visible"))
										{
											$("#"+div).hide();
										}
									else
										{
											$("#"+div).show();
										}
								}	
							function validar_form(formulario)
								{	
									valor_pagina_inicio = FCKeditorAPI.__Instances[\'pag_inicio\'].GetHTML();
									formulario.pag_inicio.value = valor_pagina_inicio; 	
									
									valor_con_no_disponible = FCKeditorAPI.__Instances[\'con_no_disponible\'].GetHTML();
									formulario.con_no_disponible.value = valor_con_no_disponible; 											
									if(formulario.cant_noticias_admon.value == "") 
										{
											alert("El campo de cantidad de noticias no puede quedar vac\u00EDo");
											formulario.cant_noticias_admon.focus(); 	
											return false;
										}									
								}
						</script>';
						echo '<form name="recargar_pantalla" id= "recargar_pantalla" method="post" action="index.php?opc=2" class="margen_cero">';
						echo '<input type="hidden" name="metodo" value = "configuracion" /></form>';
						echo '<form name="frm_configuracion_gral" id="frm_configuracion_gral" method="post" action="index.php?opc=2" >';
							
							echo '<a name="n_datos_internos" id="a_datos_internos"></a> 
							
							<div style="text-align:center;" ><a href="#a_datos_internos" onClick="mostrar_ocultar_div(\'div_datos_internos\');" >
							<strong>Datos Internos HTML</strong></a> </div>';
							
							echo ' <div  id="div_datos_internos">';
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td>Nombre del sitio</td>';
										echo '<td><input type = "text" name = "nombre_sitio" size = "69" value = "'.$nombre_sitio.'" /></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>T&iacute;tulo del sitio</td>';
										echo '<td><input type = "text" name = "titu_sitio" size = "69" value = "'.$titu_sitio.'" /></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>Url del sitio</td>';
										echo '<td><input type = "text" name = "url_sitio" size = "69" value = "'.$url_sitio.'" /></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>Palabras claves</td>';
										echo '<td><textarea name="palabras_clave" cols="60" rows="5">'.$palabras_clave.'</textarea></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>Lema del sitio</td>';
										echo '<td><textarea name="lema" cols="60" rows="5">'.$lema.'</textarea></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>Pie del sitio</td>';
										echo '<td><textarea name="pie_sitio" cols="60" rows="5">'.$pie_sitio.'</textarea></td>';
									echo '</tr>';
								echo '</table>';
							echo '</div>';
							echo '<br/><hr/><br/>';

							
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>Llave Publica de Google Captcha</td>';
									echo '<td><input type = "text" name = "llave_publica_captcha" size = "60" value = "'.$llave_publica_captcha.'" /></td>';
								echo '</tr>';																

								echo '<tr>';
									echo '<td>Llave Privada de Google Captcha</td>';
									echo '<td><input type = "text" name = "llave_privada_captcha" size = "60" value = "'.$llave_privada_captcha.'" /></td>';
								echo '</tr>';
							echo '</table>';
							
							echo '<br/><hr/><br/>';
							
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';	
								
								echo '<tr>';
									echo '<td>Ancho del administrador</td>';
									echo '<td>';
										echo '<select name="resolucion_ancho">';
											echo '<option value ="777" '; if ($resolucion_ancho == "777") { echo 'selected="selected"'; } echo '>777</option>';
											echo '<option value ="1001" '; if ($resolucion_ancho == "1001") { echo 'selected="selected"'; } echo '>1001</option>';
											echo '<option value ="1129" '; if ($resolucion_ancho == "1129") { echo 'selected="selected"'; } echo '>1129</option>';
											echo '<option value ="1257" '; if ($resolucion_ancho == "1257") { echo 'selected="selected"'; } echo '>1257</option>';
											echo '<option value ="1337" '; if ($resolucion_ancho == "1337") { echo 'selected="selected"'; } echo '>1337</option>';
											echo '<option value ="1377" '; if ($resolucion_ancho == "1377") { echo 'selected="selected"'; } echo '>1377</option>';
											echo '<option value ="1417" '; if ($resolucion_ancho == "1417") { echo 'selected="selected"'; } echo '>1417</option>';
											echo '<option value ="1577" '; if ($resolucion_ancho == "1577") { echo 'selected="selected"'; } echo '>1577</option>';
											echo '<option value ="1657" '; if ($resolucion_ancho == "1657") { echo 'selected="selected"'; } echo '>1657</option>';
											echo '<option value ="1897" '; if ($resolucion_ancho == "1897") { echo 'selected="selected"'; } echo '>1897</option>';
										echo '</select>&nbsp;Pixeles';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Fecha de inicio del sitio</td>';
									echo '<td>';
										$areglo_meses = FunGral::MesesNumero();
										echo dia.'&nbsp;<select name = "dia">';
											for ($a = 1; $a<=31; $a++)
												{ echo '<option value = "'.$a.'" '; if ($dia == $a) { echo 'selected'; } echo ' > '.$a.' </option>';}
										echo '</select>&nbsp;';
										echo mes.'&nbsp;<select name = "mes">';
											for ($b=1; $b<=12; $b++)
												{echo '<option value = "'.$b.'"  '; if ($mes == $b) {echo ' selected ';} echo ' >'. $areglo_meses[$b] .'</option>';}
										echo '</select>&nbsp;';
										echo ano.'&nbsp;<select name = "ano">';
											for ($b=$ano-10; $b<=$ano+10; $b++)
												{echo '<option value = "'.$b.'" '; if ($ano == $b) {echo ' selected ';} echo '> '.$b.'</option>';}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Tema</td>';
									echo '<td>';
										$con_tema = "select clave_tema, nombre from nazep_temas ";
										$res_tema = mysql_query($con_tema);
										echo '<select name = "clave_tema">';
											while($ren = mysql_fetch_array($res_tema))
												{
													$clave_tema_b = $ren["clave_tema"];
													$nombre  = $ren["nombre"];
													echo '<option value = "'.$clave_tema_b.'"  '; if ($clave_tema_b == $clave_tema) {echo ' selected ';} echo ' >'.$nombre.' </option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';			
							echo '</table>';
							
							echo '<br/><hr/><br/>';
							
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td>Tipo de envi&oacute; de correo</td>';
									echo '<td>';
										echo '<select name = "envio_correo">';
											echo '<option value = "php"  '; if ($envio_correo == "php") {echo ' selected ';} echo ' > PHP </option>';
											echo '<option value = "smtp" '; if ($envio_correo == "smtp") {echo ' selected ';} echo ' > SMTP </option>';
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Servidor SMTP</td>';
									echo '<td><input type = "text" name ="servidor_smtp" size = "60" value = "'.$servidor_smtp.'" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Usuario SMTP</td>';
									echo '<td><input type = "text" name = "user_smtp" size = "60" value = "'.$user_smtp.'" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Password SMTP</td>';
									echo '<td><input type = "text" name = "pass_smtp" size = "60" value = "'.$pass_smtp.'" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Mensaje del nuevo usuario de administraci&oacute;n</td>';
									echo '<td><textarea name="mensaje_nuevo_usuario_admon" cols="60" rows="3">'.$mensaje_nuevo_usuario_admon.'</textarea></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Mensaje del nuevo usuario de Vista final</td>';
									echo '<td><textarea name="mensaje_nuevo_usuario_vista" cols="60" rows="3">'.$mensaje_nuevo_usuario_vista.'</textarea></td>';
								echo '</tr>';
							echo '</table>';
							
							echo '<br/><hr/><br/>';
													
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';		
								echo '<tr>';
									echo '<td>Lenguaje</td>';
									echo '<td><input type = "text" name ="lenguaje" size ="60" value ="'.$lenguaje.'" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Ver noticias internas</td>';
									echo '<td>';
										echo '<input '; if ($ver_noticias == "no") { echo 'checked="checked"'; } echo ' type="radio" name="ver_noticias" id ="ver_noticias_no" value="no"  /> '.no.'&nbsp;';
										echo '<input '; if ($ver_noticias == "si") { echo 'checked="checked"'; } echo ' type="radio" name="ver_noticias" id ="ver_noticias_si" value="si"  /> '.si.'&nbsp;';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Cantidad de noticias internas a mostrar</td>';
									echo '<td><input type = "text" name ="cant_noticias_admon" size ="10" value ="'.$cant_noticias_admon.'" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td>Ver la P&aacute;gina de inicio</td>';
									echo '<td>';
										echo '<input '; if ($ver_pag_inicio == "no") { echo 'checked="checked"'; } echo ' type="radio" name="ver_pag_inicio" id ="ver_pag_inicio_no" value="no"  /> '.no.'&nbsp;';
										echo '<input '; if ($ver_pag_inicio == "si") { echo 'checked="checked"'; } echo ' type="radio" name="ver_pag_inicio" id ="ver_pag_inicio_si" value="si"  /> '.si.'&nbsp;';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							$variable_archivos = directorio_archivos."0/";
							$_SESSION["direccion_archivos"] = $variable_archivos;
							$ubi_tema_admon = "temas/nazep/";
							
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr><td >&nbsp;</td></tr>';
								echo '<tr><td align="center"><strong>Contenido de la p&aacute;gina de inicio</strong></td></tr>';
								echo '<tr>';
									echo '<td>';
									
									
										$oFCKeditor1 = new FCKeditor("pag_inicio") ;
										$oFCKeditor1->BasePath = "../librerias/fckeditor/";
										$oFCKeditor1->ToolbarSet = "Default";
										$oFCKeditor1->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
										$oFCKeditor1->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';
										$oFCKeditor1->Width = "100%";
										$oFCKeditor1->Height = "500";
										$oFCKeditor1->Value = $pag_inicio;	
										$oFCKeditor1->Create();	
									echo '</td>';
								echo '</tr>';
								echo '<tr><td >&nbsp;</td></tr>';
								echo '<tr><td align="center"><strong>Mensaje a mostrar cuando el contenido no este disponible</strong></td></tr>';
								echo '<tr>';
									echo '<td>';
										$oFCKeditor2 = new FCKeditor("con_no_disponible") ;
										$oFCKeditor2->BasePath = "../librerias/fckeditor/";
										$oFCKeditor2->ToolbarSet = "Default";
										$oFCKeditor2->Config['EditorAreaCSS'] = $ubi_tema_admon.'fck_editorarea.css';
										$oFCKeditor2->Config['StylesXmlPath'] = $ubi_tema_admon.'fckstyles.xml';
										$oFCKeditor2->Width = "100%";
										$oFCKeditor2->Height = "500";
										$oFCKeditor2->Value = $con_no_disponible;	
										$oFCKeditor2->Create();	
									echo '</td>';
								echo '</tr>';
								echo '<tr><td >&nbsp;</td></tr>';								
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								$con_sec = "select clave_seccion, nombre from nazep_secciones where situacion = 'activo' or situacion='oculto' order by nombre";
								$res_sec_b = mysql_query($con_sec);
								echo '<tr>';
									echo '<td>Secci&oacute;n del buscador</td>';
									echo '<td>';
										echo '<select name = "clave_buscador">';
											while($ren = mysql_fetch_array($res_sec_b))
												{
													$clave_seccion_b = $ren["clave_seccion"];
													$nombre  = $ren["nombre"];
													echo '<option value = "'.$clave_seccion_b.'"'; if ($clave_seccion_b == $clave_buscador) {echo'selected';} echo ' >'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								$res_sec_m = mysql_query($con_sec);
								echo '<tr>';
									echo '<td>Secci&oacute;n del mapa del sitio</td>';
									echo '<td>';
										echo '<select name = "clave_mapa_sitio">';
											while($ren = mysql_fetch_array($res_sec_m))
												{
													$clave_seccion_m = $ren["clave_seccion"];
													$nombre  = $ren["nombre"];
													echo '<option value = "'.$clave_seccion_m.'"  '; if ($clave_seccion_m == $clave_mapa_sitio) {echo'selected';} echo ' >'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';								
								$res_sec_r = mysql_query($con_sec);
								echo '<tr>';
									echo '<td>Secci&oacute;n de recomendaci&oacute;n del sitio</td>';
									echo '<td>';
										echo '<select name = "clave_recomendar">';
											while($ren = mysql_fetch_array($res_sec_r))
												{
													$clave_seccion_r = $ren["clave_seccion"];
													$nombre = $ren["nombre"];
													echo '<option value = "'.$clave_seccion_r.'"  '; if ($clave_seccion_r == $clave_recomendar) {echo'selected';} echo ' >'. $nombre.'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								$res_sec_con = mysql_query($con_sec);
								echo '<tr>';
									echo '<td>Secci&oacute;n de contacto</td>';
									echo '<td>';
										echo '<select name = "clave_contacto">';
											while($ren = mysql_fetch_array($res_sec_con))
												{
													$clave_seccion_c = $ren["clave_seccion"];
													$nombre  = $ren["nombre"];
													echo '<option value = "'.$clave_seccion_c.'"  '; if ($clave_seccion_c == $clave_contacto) {echo 'selected ';} echo ' >'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								$res_sec_rss = mysql_query($con_sec);
								echo '<tr>';
									echo '<td>Secci&oacute;n Principal del RSS</td>';
									echo '<td>';
										echo '<select name = "clave_rss">';
											while($ren = mysql_fetch_array($res_sec_rss))
												{
													$clave_seccion_rss = $ren["clave_seccion"];
													$nombre  = $ren["nombre"];
													echo '<option value = "'.$clave_seccion_rss.'"  '; if ($clave_seccion_rss == $clave_rss) {echo ' selected ';} echo ' >'.$nombre.'</option>';
												}
										echo '</select>';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td>Versi&oacute;n</td><td>'.$version.'</td></tr>';
							echo '</table>';
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
								echo '<tr>';
									echo '<td align ="center">';
										echo '<input type="hidden" name="formulario_final" value = "recargar_pantalla" />';
										echo '<input type="hidden" name="guardar" value = "si" />';
										echo '<input type="hidden" name="metodo" value = "configuracion" />';
										echo '<input type="submit" name="btn_guardar" value="Guardar cambios de la configuraci&oacute;n"  onclick= "return validar_form(this.form)" />';
									echo '</td>';
								 echo '</tr>';
							echo '</table>';
						echo '</form>';
						HtmlAdmon::div_res_oper(array());
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
							echo '<tr>';
								echo '<td align ="center">';
									echo '<a href="index.php?opc=2" class="regresar">';
									echo '<img src="imagenes/atras.gif" align="middle" border="0"  alt ="atras" /><br />';
									echo '<strong>Regresar a la Configuraci&oacute;n del Administrador</strong></a>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
			}
	}
?>
