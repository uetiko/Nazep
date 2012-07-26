<?php
/*
Sistema: Nazep
Nombre archivo: vista_final.php
Función archivo: Contener todas las funciones necesarias para ver el portal
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
if( file_exists("librerias/error.php") && file_exists("librerias/conexion.php") )
	{
		
		include_once("librerias/error.php");
		include("librerias/conexion.php");		
	}
else if( file_exists("error.php") &&  file_exists("conexion.php") )
	{
		include_once("error.php");
		include_once("conexion.php");
	}
include_once("librerias/html.php");
include_once("librerias/html_vista.php");
include_once("librerias/FunGral.php");
class vista_final extends conexion
	{
		private $nick_user="Invitado";
		private $ip_user;
		private $registro = "no";
		var $nom_usuario = "";
		var $direccion_recomendar_g = "index.php";		
		var $clave_recomendar_g = 1;
		function arreglo($sec)
			{
				$clave_seccion_usada = $sec;
				$arreglo_seccion[0] = $sec;
				for($a=1;$a>0;$a++)
					{	
						$con = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$clave_seccion_usada'";	
						$res = mysql_query($con);
						$ren = mysql_fetch_array($res);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"]; 
						$arreglo_seccion[$a] = $clave_seccion_pertenece;
						if($clave_seccion_pertenece == 1)
							{ $a = -1; }
						else
							{ $clave_seccion_usada = $clave_seccion_pertenece; }
					}
				return $arreglo_seccion;
			}
		function salir()
			{	
				$ip = $_SERVER['REMOTE_ADDR']; 
				$conexion = $this->conectarse();
				$temporal_ip = $this->ip_user;
				$nick_tem = $this->nick_user;
				$borrar = "delete from nazep_sesiones  where nick_usuario = '$nick_tem' and ip = '$temporal_ip'";
				$this->nick_user = "Invitado";
				$this->ip_user = $ip;
				$this->registro = "no";		
				$this->sentecia($borrar, "");
				$this->desconectarse($conexion);
			}
		function checar_sesion()
			{
				$ip = $_SERVER['REMOTE_ADDR']; 
				if($this->registro =="no")
					{
						$this->nick_user ="Invitado";
						$this->ip_user =$ip;
					}
				$temporal_user = $this->nick_user;
				$temporal_ip = $this->ip_user;
				$conexion = $this->conectarse();
				$con_user_linea = "select nick_usuario from nazep_sesiones where nick_usuario = '$temporal_user' and ip = '$temporal_ip'";
				$res_con_user = mysql_query($con_user_linea);
				$cantidad = mysql_num_rows($res_con_user);
				$tem_hora = time();
				if($cantidad == 0)
					{
						$tem_nick = $this->nick_user;
						$insertar_usuario = "insert into nazep_sesiones values('$tem_nick', '$tem_hora', '$ip')";
						$this->sentecia($insertar_usuario, "");
					}
				else
					{
						$tem_nick = $this->nick_user;
						$actualizar = "update nazep_sesiones set hora  = '$tem_hora' where nick_usuario = '$tem_nick' and ip = '$ip'";
						$this->sentecia($actualizar, "");	
					}
				$inactividad = time()-(60*60*20);
				$borrar_inactivos = "delete from nazep_sesiones where hora <= '$inactividad'";
				$this->sentecia($borrar_inactivos, "");
				$this->desconectarse($conexion);
			}
		function validar_usuario_redireccionar($sec)
			{
				$pasword_usuario_vista = $_POST["pasword_usuario_vista"];
				$nick_usuario_vista = $_POST["nick_usuario_vista"];
				$pasword_usuario_vista = md5($pasword_usuario_vista);
				$consulta_usu = "select nombre, a_mat, a_pat from nazep_usuarios_final
				where nick_usuario = '$nick_usuario_vista' and pasword = '$pasword_usuario_vista' and situacion = 'activo'";
				$conexion = $this->conectarse();
				$res_con = mysql_query($consulta_usu);
				$cantidad = mysql_num_rows($res_con);
				if($cantidad === 0)
					{
						header("Location:  index.php?error_usuario=si&sec=$sec");
					}
				else
					{
						$ren_con = mysql_fetch_array($res_con);
						$nombre = $ren_con["nombre"];
						$a_mat = $ren_con["a_mat"];
						$a_pat = $ren_con["a_pat"];	
						$this->nick_user = $nick_usuario_vista;
						$temporal_ip = $this->ip_user;
						$this->registro = "si";
						$this->nom_usuario = $nombre."&nbsp;".$a_pat."&nbsp;".$a_mat;
						$delete = "delete from nazep_sesiones where nick_usuario = 'Invitado' and ip = '$temporal_ip'";
						if (mysql_query($delete))
							{
								$this->registro = "si";
								header("Location:  index.php?sec=$sec");
							}
					}
			}
		function validar_usuario($sec)
			{
				echo '<form name="formulario_acceso_vista" id="formulario_acceso_vista" method="post" action="index.php?sec='.$sec.'">';
					echo '<table width="100%" border="0">';
						echo '<tr>';
							echo '<td align = "center">';
								$error_de_usuario = @$_GET["error_usuario"];
								if($error_de_usuario  == "si")
									{ echo '<span class="error_usuario">'. error_acceso_admon .'</span>'; }
								else
									{ echo '&nbsp;'; }
							echo '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>';
								echo '<table width = "100%">';
									echo '<tr><td>'.txt_nick_user.'</td>';
									echo '<td><input type= "text" name="nick_usuario_vista" /></td></tr>';
									echo '<tr><td>'.txt_pasword_user.'</td>';
									echo '<td><input type= "password" name="pasword_usuario_vista" /></td></tr>';
									echo '<tr><td></td>';
										echo '<td><input type="hidden" name="validar_vista" value = "si" /><input type="submit" name="Submit" value="'.txt_enviar_user.'" /></td>';
									echo '</tr>';
								echo '</table>';
							echo '</td>';
						echo '</tr>';
					echo '</table>';
				echo '</form>';
			}
		function firma()
			{
				echo '
<!--
// ***************************************************************
// ********************** NAZEP **********************************
// *** Administrador de Contenidos Web ***
// *** Sitio Web : http://www.nazep.com.mx ***
// *** V 0.2 ***
// ***************************************************************
-->';
			}
		function cuerpo()
			{
				if(isset($_GET["error"]))
					{ $variable_error = $_GET["error"]; }
				else
					{ $variable_error = ''; }
				if(!isset($_GET["sec"]) || $_GET["sec"]=='')
					{$sec = 1;}
				else
					{ $sec = $_GET["sec"]; }
				if(!isset($_GET["formato"]) || $_GET["formato"]=='')
					{$formato = "html";}
				else
					{$formato = $_GET["formato"];}
				$nick_usuario = $this->nick_user;
				$conexion = $this->conectarse();
				$con_tema = "select t.ubicacion, c.lenguaje, c.titu_sitio, c.palabras_clave, c.pie_sitio, c.url_sitio  from nazep_configuracion c, nazep_temas t where c.clave_tema = t.clave_tema";
				$res_con = mysql_query($con_tema);
				$ren_con = mysql_fetch_array($res_con);
				$ubicacion = $ren_con["ubicacion"];	
				$lenguaje  = $ren_con["lenguaje"];
				$pie_sitio = $ren_con["pie_sitio"];
				$url_sitio = $ren_con["url_sitio"];
				$lenguaje_primario = "librerias/temas/$ubicacion"."/len_".$lenguaje.".php";
				$titu_sitio  = $ren_con["titu_sitio"];	
				$palabras_clave = $ren_con["palabras_clave"];
				$this->desconectarse($conexion);
				$dir_tem = 'librerias/temas/';
				$ubicacion_tema = $dir_tem.$ubicacion.'/';
				$cabeza_html = $dir_tem.$ubicacion.'/cabeza_html.php';
				$estilo_css =  $dir_tem.$ubicacion.'/estilos.css';
				$favicon = $dir_tem.$ubicacion.'/image/favicon.ico'; 
				$cabeza = $dir_tem.$ubicacion.'/cabeza.php';
				$cuerpo = $dir_tem.$ubicacion.'/cuerpo.php';
				$cuerpo_redirecion = $dir_tem.$ubicacion.'/cuerpo_redireccion.php';
				$cuerpo_print = $dir_tem.$ubicacion.'/cuerpo_print.php';
				$cuerpo_xml = $dir_tem.$ubicacion.'/cuerpo_xml.php';
				$pie = $dir_tem.$ubicacion.'/pie.php';
				$pie_html = $dir_tem.$ubicacion.'/pie_html.php';
				$xml_version = '<?xml version="1.0" encoding="utf-8"?>';
				$existencia = false;
				if (!is_numeric($sec))
					{
						$existencia==false;
						$sec=1;
					}
				else
					{ $existencia = $this->existencia_seccion($sec); }			
				if($variable_error!= "")
					{
						$conexion = $this->conectarse();
						$cuerpo = $dir_tem.$ubicacion.'/cuerpo_error.php';
						include($lenguaje_primario);
						echo $xml_version;
						echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
						include($cabeza_html);			
						include($cabeza);
						include($cuerpo);
						include($pie);	
						include($pie_html);	
						$this->firma();
						$this->desconectarse($conexion);
					}
				else
					{
						if($existencia)
							{								
								if($formato=="html")
									{
										if(isset($_POST["validar_vista"]) && $_POST["validar_vista"]=="si")
											{
												$this->validar_usuario_redireccionar($sec);
											}	
										elseif(isset($_POST["redireccion"]) && $_POST["redireccion"]=="si")
											{ include($cuerpo_redirecion); }
										else
											{
												include($lenguaje_primario);
												echo $xml_version;
												echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';						
												include($cabeza_html);			
												include($cabeza);
												include($cuerpo);
												include($pie);	
												include($pie_html);	
												$this->firma();
											}
									}
								elseif($formato=="print")
									{
										include($lenguaje_primario);
										echo $xml_version;
										echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
										include($cabeza_html);
										include($cuerpo_print);
										include($pie_html);
										$this->firma();
									}
								elseif($formato=="xml")
									{
										header('Content-Type: text/xml');
										echo '<?xml version="1.0" encoding="utf-8"?>';
										include($cuerpo_xml);
									}									
							}
						else
							{
								$conexion = $this->conectarse();
								$variable_error = "404";
								$cuerpo = $dir_tem.$ubicacion.'/cuerpo_error.php';
								include($lenguaje_primario);
								echo $xml_version;
								echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
								include($cabeza_html);			
								include($cabeza);
								include($cuerpo);
								include($pie);	
								include($pie_html);	
								$this->firma();
								$this->desconectarse($conexion);
							}
					}
				
			}
//************************************************************************ INICIO FUNCIONES PARA MULTIPLES USOS **************************************************************
		function enlace_imprimir($texto, $ventana)
			{
				if(isset($_SERVER['REQUEST_URI']))
					{ $direccion = $_SERVER['REQUEST_URI']; }
				else
					{
						$direccion = '/index/index.php';
					}
				$direccion_temporal = explode("?", $direccion);
				if(!isset($direccion_temporal[1]) || $direccion_temporal[1] == '')
					{
						if($direccion_temporal[0]=="/index/")
							{
								$cadena_print = "index.php?formato=print";
							}
						else
							{
								$cadena_print = "?formato=print";
							}
					}
				else
					{
						$cadena_print = "&amp;formato=print";
					}
				$direccion_print = $direccion.$cadena_print;
				echo '<a class="enlace_imprimir" href="'.$direccion_print.'"  target="'.$ventana.'" >'.$texto.'</a>';
			}
		function enlace_imprimir_imagen($imagen, $texto, $ventana, $alt, $titulo)	
			{
				$direccion = $_SERVER['REQUEST_URI'];
				$direccion_temporal = explode("?", $direccion);
				if(!isset($direccion_temporal[1]) || $direccion_temporal[1] == '')
					{
						if($direccion_temporal[0]=="/index/")
							{
								$cadena_print = "index.php?formato=print";
							}
						else
							{
								$cadena_print = "?formato=print";
							}
					}
				else
					{
						$cadena_print = "&amp;formato=print";
					}
				$direccion_print = $direccion.$cadena_print;
				echo '<a class="enlace_imprimir" href="'.$direccion_print.'"  target="'.$ventana.'"  >';
					echo '<img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /> '.$texto;
				echo '</a>';
			}
		function clave_seccion_recomendar()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_recomendar from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_recomendar = $ren_sec["clave_recomendar"];
				return $clave_recomendar; 
			}		
		function enlace_recomendar($sec, $texto)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_recomendar from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_recomendar = $ren_sec["clave_recomendar"];
				$direccion = $_SERVER['REQUEST_URI'];
				echo '<a class="enlace_recomendar" href="index.php?sec='.$clave_recomendar.'&amp;recomendar=si">'.$texto.'</a>';
			}
		function enlace_recomendar_imagen($sec, $imagen, $texto, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_recomendar from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_recomendar = $ren_sec["clave_recomendar"];
				$direccion = $_SERVER['REQUEST_URI'];
				echo '<a class="enlace_recomendar" href="index.php?sec='.$clave_recomendar.'&amp;direccion='.$direccion.'&amp;clave_seccion_recomendar='.$sec.'">';
					echo '<img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /> '.$texto.'</a>';
			}
		function clave_seccion_buscador()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_buscador from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_buscador = $ren_sec["clave_buscador"];
				return $clave_buscador;
			}
		function enlace_buscador($texto)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_buscador from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_buscador = $ren_sec["clave_buscador"];
				echo '<a class="enlace_buscador" href="index.php?sec='.$clave_buscador.'" >'.$texto.'</a>';
			}
		function enlace_buscador_imagen($imagen, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_buscador from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_buscador = $ren_sec["clave_buscador"];
				echo '<a class="enlace_buscador" href="index.php?sec='.$clave_buscador.'" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
			}
		function clave_seccion_mapa_sitio()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_mapa_sitio from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_mapa_sitio = $ren_sec["clave_mapa_sitio"];
				return $clave_mapa_sitio;
			}
		function enlace_mapa_sitio($texto)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_mapa_sitio from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_mapa_sitio = $ren_sec["clave_mapa_sitio"];
				echo '<a class="enlace_al_mapa_sitio" href="index.php?sec='.$clave_mapa_sitio.'" >'.$texto.'</a>';
			}
		function enlace_mapa_sitio_imagen($imagen, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_mapa_sitio from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_mapa_sitio = $ren_sec["clave_mapa_sitio"];
				echo '<a class="enlace_al_mapa_sitio" href="index.php?sec='.$clave_mapa_sitio.'" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
			}
		function clave_seccion_contacto()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_contacto from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_contacto = $ren_sec["clave_contacto"];
				return $clave_contacto;
			}
		function enlace_contacto($texto)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_contacto from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_contacto = $ren_sec["clave_contacto"];
				echo '<a class="enlace_contacto" href="index.php?sec='.$clave_contacto.'" >'.$texto.'</a>';
			}
		function enlace_contacto_imagen($imagen, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_contacto from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_contacto = $ren_sec["clave_contacto"];
				echo '<a class="enlace_contacto" href="index.php?sec='.$clave_contacto.'" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
			}	
		function clave_seccion_rss()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_rss from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);		
				$clave_rss = $ren_sec["clave_rss"];
				return $clave_rss;
			}
		function enlace_rss_principal($imagen, $texto, $tipo, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_rss from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);		
				$clave_rss = $ren_sec["clave_rss"];
				echo '<a class="enlace_rss" href="index.php?sec='.$clave_rss.'" >';
					if($tipo=="imagen")
						{
							echo '<img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" />';
						}
					elseif($tipo=="texto")
						{
							echo $texto;
						}						
				echo '</a>';				
			}			
		function enlace_inicio($texto)
			{
				echo '<a class="enlace_inicio" href="index.php" >'.$texto.'</a>';
			}
		function enlace_inicio_imagen($imagen, $alt, $titulo)
			{
				echo '<a class="enlace_inicio" href="index.php" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
			}
		function listar_mod_central_horizontal($sec, $ubicacion_tema, $nick_usuario, $modo, $inico, $fin)
			{
				$conexion = $this->conectarse();
				$hoy = date('Y-m-d');
				$con_modulo = "select m.nombre_archivo, m.clave_modulo
				from nazep_secciones_modulos sm, nazep_modulos m 
				where m.tipo = 'central' and clave_seccion = '$sec'
				and (
				case sm.usar_vigencia_mod 
				when 'si'
				then
					sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
					1
				end)				
				and sm.situacion = 'activo'
				and sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy' 
				and sm.clave_modulo = m.clave_modulo order by sm.orden
				limit $inico, $fin";
				$res_mod = mysql_query($con_modulo);
				if($modo == "html")
					{
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							echo '<tr>';
								while($ren_mod = mysql_fetch_array($res_mod))
									{
										echo '<td>';
											$nombre_archivo = $ren_mod["nombre_archivo"];
											$clave_modulo = $ren_mod["clave_modulo"];
											$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
											include_once($archivo);
											$nombre = "clase_$nombre_archivo";
											$obj_v = new $nombre();
											$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
										echo '</td>';
									}
							echo'</tr>';
						echo '</table>';
					}
				elseif($modo == "print")
					{
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							echo '<tr>';
								while($ren_mod = mysql_fetch_array($res_mod))
									{
										echo '<td align="center" valign="top" >';
											$nombre_archivo = $ren_mod["nombre_archivo"];
											$clave_modulo = $ren_mod["clave_modulo"];
											$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
											include_once($archivo);
											$nombre = "clase_$nombre_archivo";
											$obj_v = new $nombre();
											$obj_v->vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
										echo '</td>';
									}
							echo'</tr>';
						echo '</table>';
					}			
				elseif($modo == "redireccion")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}
				elseif($modo == "xml")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista_xml($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}
			}
		function listar_mod_central($sec, $ubicacion_tema, $nick_usuario, $modo)
			{
				$conexion = $this->conectarse();
				$hoy = date('Y-m-d');
				$con_modulo = "select m.nombre_archivo, m.clave_modulo
				from nazep_secciones_modulos sm, nazep_modulos m 
				where m.tipo = 'central' and clave_seccion = '$sec'
				and sm.situacion = 'activo'			
				and (
				case sm.usar_vigencia_mod 
				when 'si'
				then
					sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
					1
				end) 
				and sm.clave_modulo = m.clave_modulo 
				order by sm.orden";
				$res_mod = mysql_query($con_modulo);
				if($modo == "html")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}
				elseif($modo == "print")
					{
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							while($ren_mod = mysql_fetch_array($res_mod))
								{		
									echo '<tr>';
										echo '<td align="center" valign="top" >';
											$nombre_archivo = $ren_mod["nombre_archivo"];
											$clave_modulo = $ren_mod["clave_modulo"];
											$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
											include_once($archivo);
											$nombre = "clase_$nombre_archivo";
											$obj_v = new $nombre();
											$obj_v->vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
										echo '</td>';
									echo'</tr>';
								}
						echo '</table>';
					}
				elseif($modo == "redireccion")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}
				elseif($modo == "xml")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista_xml($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}					
			}
		function listar_mod_central_div($sec, $ubicacion_tema, $nick_usuario, $modo)
			{
				$conexion = $this->conectarse();
				$hoy = date('Y-m-d');
				$con_modulo = "select m.nombre_archivo, m.clave_modulo
				from nazep_secciones_modulos sm, nazep_modulos m 
				where m.tipo = 'central' and clave_seccion = '$sec'
				and sm.situacion = 'activo'			
				and (
				case sm.usar_vigencia_mod 
				when 'si'
				then
					sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
					1
				end) 
				and sm.clave_modulo = m.clave_modulo 
				order by sm.orden";
				$res_mod = mysql_query($con_modulo);
				if($modo == "html")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}
				elseif($modo == "print")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{		
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}
				elseif($modo == "redireccion")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}
				elseif($modo == "xml")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								$obj_v->vista_xml($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
							}
					}					
			}
		function listar_mod_secundarios_vert_tabla($sec, $lado, $ancho_tabla)
			{
				$hoy = date('Y-m-d');	
				$con_mod_alt = "select m.nombre_archivo, m.clave_modulo
				from nazep_modulos m, nazep_secciones_modulos sm
				where sm.clave_seccion = '$sec' and sm.situacion = 'activo'
				and (case sm.usar_vigencia_mod 
				when 'si'
				then
				sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
				1
				end) 
				and m.tipo = 'secundario' and sm.posicion = '$lado'
				and sm.clave_modulo = m.clave_modulo
				order by sm.orden";
				$res_mod_alt = mysql_query($con_mod_alt);
				$cantidad_modulos = mysql_num_rows($res_mod_alt);
				
				if($cantidad_modulos!="0")
					{
						echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
						$con = 1;
						while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
							{
								$nombre_archivo = $ren_mod_alt["nombre_archivo"];
								$clave_modulo = $ren_mod_alt["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = "clase_$nombre_archivo";
								$obj_v = new $nombre();
								echo'<tr>';
									echo '<td align= "center" >';
										$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
									echo '</td>';
								echo'</tr>';
								if($con<$cantidad_modulos)
									{
										echo'<tr><td>&nbsp;</td></tr>';
									}
								$con++;
							}
						echo '</table>';
					}
			}
		function listar_mod_secundarios_vert_tabla_persistentes($sec, $lado, $ancho_tabla)
			{
				$con_seccion_pertenece = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion_perte = mysql_query($con_seccion_pertenece);
				$ren_seccion_perte = mysql_fetch_array($res_seccion_perte);
				$clave_seccion_pertenece = $ren_seccion_perte["clave_seccion_pertenece"];
				if($clave_seccion_pertenece!="")
					{
						$hoy = date('Y-m-d');
						$con_mod_alt = " select m.nombre_archivo, m.clave_modulo
						from nazep_modulos m, nazep_secciones_modulos sm
						where 
						sm.clave_seccion = '$clave_seccion_pertenece' and
						 sm.situacion = 'activo' 
						and (
						case sm.usar_vigencia_mod 
						when 'si'
						then
						sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
						else
						1
						end
						) 
						and m.tipo = 'secundario' and sm.posicion = '$lado'
						and sm.clave_modulo = m.clave_modulo
						and sm.persistencia = 'si'
						order by sm.orden";
						$res_mod_alt = mysql_query($con_mod_alt);
						$cantidad_modulos = mysql_num_rows($res_mod_alt);
						if($cantidad_modulos!="0")
							{
								$con = 1;
								echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
								while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
									{
										$nombre_archivo = $ren_mod_alt["nombre_archivo"];
										$clave_modulo = $ren_mod_alt["clave_modulo"];
										$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
										include_once($archivo);
										$nombre = "clase_$nombre_archivo";
										$obj_v = new $nombre();
										echo'<tr>';
											echo '<td align= "center" >';
												$obj_v->vista($clave_seccion_pertenece, $ubicacion_tema, $nick_usuario, $clave_modulo);
											echo '</td>';
										echo'</tr>';	
										if($con<$cantidad_modulos)
											{
												echo'<tr><td>&nbsp;</td></tr>';
											}
										$con++;
									}
								echo '</table>';
							}
						if($clave_seccion_pertenece!="1")
							{
								$this->listar_mod_secundarios_vert_tabla_persistentes($clave_seccion_pertenece, $lado, $ancho_tabla);
							}
					}
			}
		function listar_mod_secundarios_ver_div($sec, $lado, $alto_separacion, $marg_izq, $marg_der, $color_separacion)
			{
				$hoy = date('Y-m-d');	
				$con_mod_alt = "select m.nombre_archivo, m.clave_modulo
				from nazep_modulos m, nazep_secciones_modulos sm
				where sm.clave_seccion = '$sec' and sm.situacion = 'activo'
				and (case sm.usar_vigencia_mod 
				when 'si'
				then
				sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
				1
				end) 
				and m.tipo = 'secundario' and sm.posicion = '$lado'
				and sm.clave_modulo = m.clave_modulo
				order by sm.orden";
				$res_mod_alt = mysql_query($con_mod_alt);
				$cantidad_modulos = mysql_num_rows($res_mod_alt);
				if($cantidad_modulos!="0")
					{
						$con = 1;
						echo '<div style="padding-left:'.$marg_izq.'; padding-right:'.$marg_der.';">';
						while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
							{
								$nombre_archivo = $ren_mod_alt["nombre_archivo"];
								$clave_modulo = $ren_mod_alt["clave_modulo"];
								$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
								include_once($archivo);
								$nombre = 'clase_'.$nombre_archivo;
								$obj_v = new $nombre();
								echo '<div id="div_mod_'.$con.'">';
										$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
								echo '</div>';
								if($con<$cantidad_modulos)
									{
										echo'<div id="separacion_mod_'.$con.'"  style="width:100%; background-color:#'.$color_separacion.';  height:'.$alto_separacion.'px;"></div>';
									}
								$con++;
							}
						echo '</div>';
					}
			}
		function listar_mod_secundarios_ver_div_per($sec, $lado, $alto_separacion, $marg_izq, $marg_der, $color_separacion)
			{
				$con_seccion_pertenece = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion_perte = mysql_query($con_seccion_pertenece);
				$ren_seccion_perte = mysql_fetch_array($res_seccion_perte);
				$clave_seccion_pertenece = $ren_seccion_perte["clave_seccion_pertenece"];
				if($clave_seccion_pertenece!="")
					{
						$hoy = date('Y-m-d');
						$con_mod_alt = " select m.nombre_archivo, m.clave_modulo
						from nazep_modulos m, nazep_secciones_modulos sm
						where 
						sm.clave_seccion = '$clave_seccion_pertenece' and
						 sm.situacion = 'activo' 
						and (
						case sm.usar_vigencia_mod 
						when 'si'
						then
						sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
						else
						1
						end
						) 
						and m.tipo = 'secundario' and sm.posicion = '$lado'
						and sm.clave_modulo = m.clave_modulo
						and sm.persistencia = 'si'
						order by sm.orden";
						$res_mod_alt = mysql_query($con_mod_alt);
						$cantidad_modulos = mysql_num_rows($res_mod_alt);
						if($cantidad_modulos!="0")
							{
								$con = 1;
								echo '<div style="padding-left:'.$marg_izq.'; padding-right:'.$marg_der.';">';
								while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
									{
										$nombre_archivo = $ren_mod_alt["nombre_archivo"];
										$clave_modulo = $ren_mod_alt["clave_modulo"];
										$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
										include_once($archivo);
										$nombre = "clase_$nombre_archivo";
										$obj_v = new $nombre();
										echo '<div id="div_mod_per_'.$con.'">';
												$obj_v->vista($clave_seccion_pertenece, $ubicacion_tema, $nick_usuario, $clave_modulo);
										echo '</div>';
										if($con<$cantidad_modulos)
											{
												echo'<div id="separacion_mod_per_'.$con.'"  style="width:100%; background-color:#'.$color_separacion.';  height:'.$alto_separacion.'px;"></div>';
											}
										$con++;
									}
								echo '</div>';
							}
						if($clave_seccion_pertenece!="1")
							{
								$this->listar_mod_secundarios_ver_div_per($clave_seccion_pertenece, $lado, $alto_separacion, $marg_izq, $marg_der, $color_separacion);
							}
					}
			}
		function listar_mod_secundarios_hor_tabla($sec, $lado, $ancho_tabla)
			{
				$hoy = date('Y-m-d');	
				$con_mod_alt = "select m.nombre_archivo, m.clave_modulo
				from nazep_modulos m, nazep_secciones_modulos sm
				where sm.clave_seccion = '$sec' and sm.situacion = 'activo' 
				and (
				case sm.usar_vigencia_mod 
				when 'si'
				then
				sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
				1
				end
				) 
				and m.tipo = 'secundario' and sm.posicion = '$lado'
				and sm.clave_modulo = m.clave_modulo
				order by sm.orden";
				$res_mod_alt = mysql_query($con_mod_alt);
				$cantidad_modulos = mysql_num_rows($res_mod_alt);
				if($cantidad_modulos!="0")
					{
						echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
							echo'<tr>';
								while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
									{
										$nombre_archivo = $ren_mod_alt["nombre_archivo"];
										$clave_modulo = $ren_mod_alt["clave_modulo"];
										$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
										include_once($archivo);
										$nombre = "clase_$nombre_archivo";
										$obj_v = new $nombre();
										echo '<td align= "center" >';
											$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
										echo '</td>';
										echo '<td width="2%" >&nbsp;</td>';
									}
							echo'</tr>';
						echo '</table>';
					}
			}
		function listar_mod_secundarios_hor_tabla_persistentes($sec, $lado, $ancho_tabla)
			{
				$con_seccion_pertenece = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion_perte = mysql_query($con_seccion_pertenece);
				$ren_seccion_perte = mysql_fetch_array($res_seccion_perte);
				$clave_seccion_pertenece = $ren_seccion_perte["clave_seccion_pertenece"];
				if($clave_seccion_pertenece!="")
					{
						$hoy = date('Y-m-d');	
						$con_mod_alt = "select m.nombre_archivo, m.clave_modulo
						from nazep_modulos m, nazep_secciones_modulos sm
						where sm.clave_seccion = '$clave_seccion_pertenece' and sm.situacion = 'activo' 
						and (
						case sm.usar_vigencia_mod 
						when 'si'
						then
						sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
						else
						1
						end) 
						and m.tipo = 'secundario' and sm.posicion = '$lado'
						and sm.clave_modulo = m.clave_modulo
						and sm.persistencia = 'si'
						order by sm.orden";
						$res_mod_alt = mysql_query($con_mod_alt);
						$cantidad_modulos = mysql_num_rows($res_mod_alt);
						if($cantidad_modulos!="0")
							{
								echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
									echo'<tr>';
										while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
											{
												$nombre_archivo = $ren_mod_alt["nombre_archivo"];
												$clave_modulo = $ren_mod_alt["clave_modulo"];
												$archivo = "librerias/modulos/$nombre_archivo/$nombre_archivo"."_vista.php";
												include_once($archivo);
												$nombre = "clase_$nombre_archivo";
												$obj_v = new $nombre();
												echo '<td align= "center" >';
													$obj_v->vista($clave_seccion_pertenece, $ubicacion_tema, $nick_usuario, $clave_modulo);
												echo '</td>';
												echo '<td width="2%">&nbsp;</td>';
											}
									echo'</tr>';
								echo '</table>';
							}
					}
			}
		function lis_subsecc_horizontal_tablas($sec, $ancho, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				$hoy = date('Y-m-d');
				$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from nazep_secciones
				where clave_seccion_pertenece = '$sec' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
				    else 0 end)
				and situacion = 'activo'
				order by orden";
				$res_sub  = mysql_query($con_sub);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub=="0")
					{
						$con_sub2 = " select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
						$res_sub2 = mysql_query($con_sub2);
						$ren_sub2 = mysql_fetch_array($res_sub2);
						$clave_seccion_pertenece = $ren_sub2["clave_seccion_pertenece"];
						if($clave_seccion_pertenece!=1)
							{
								$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio 
								from nazep_secciones
								where clave_seccion_pertenece = '$clave_seccion_pertenece'  
								and (case usar_vigencia 
									when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
									when 'no' then 1
									else 0 end)
								and  situacion = 'activo'	
								order by orden";
								$res_sub  = mysql_query($con_sub);
							}
					}	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)	
					{
						echo '<table width="'.$ancho.'" border="0" cellspacing="0" cellpadding="0" align="center">';
							echo'<tr>';
								echo '<td align="left">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo'<tr>';
										while($ren = mysql_fetch_array($res_sub))
											{
												$titulo = $ren["titulo"];
												$clave_seccion = $ren["clave_seccion"];
												$tipo_contenido = $ren["tipo_contenido"];
												$tipo_titulo = $ren["tipo_titulo"];
												$flash_secion = $ren["flash_secion"];
												$imagen_secion = $ren["imagen_secion"];	
												$ancho_medio = $ren["ancho_medio"];	
												$alto_medio = $ren["alto_medio"];	
												$formato = '';
												if($tipo_contenido=="xml")
													{
														$formato = '&amp;formato=xml';
													}
												if($mostrar_balazo=="si")
													{
														echo '<td align="left"><img src="'.$imagen_balazo.'" alt="'.$alt_bal.'" title="'.$titulo_bal.'" /></td>';	
														echo '<td width="1%">&nbsp;</td>';
													}
												echo '<td align="left" width="100%">';
												if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
													{
														echo '<a class="lista_subsecc_vert_tabla" href="index.php?sec='.$clave_seccion.$formato.'" >';	
														if($tipo_titulo=="texto")
														{echo $titulo;}
														elseif($tipo_titulo=="imagen")
														{echo '<img width="'.$ancho_medio.'" height="'.$alto_medio.'" src="'.$imagen_secion.'" border="0" alt="" title="" >';}
														echo '</a>';
													}
												elseif($tipo_titulo=="flash")
													{
														echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
													}
												echo '</td>';												
											}
										echo'</tr>';											
									echo '</table>';
								echo '</td>';
							echo'</tr>';
						echo '</table>';
					}
			}
			
		function lis_subsecc_vert_tablas($sec, $ancho, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				$hoy = date('Y-m-d');
				$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from nazep_secciones
				where clave_seccion_pertenece = '$sec' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
				    else 0 end)
				and situacion = 'activo'
				order by orden";
				$res_sub  = mysql_query($con_sub);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub=="0")
					{
						$con_sub2 = " select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
						$res_sub2 = mysql_query($con_sub2);
						$ren_sub2 = mysql_fetch_array($res_sub2);
						$clave_seccion_pertenece = $ren_sub2["clave_seccion_pertenece"];
						if($clave_seccion_pertenece!=1)
							{
								$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio 
								from nazep_secciones
								where clave_seccion_pertenece = '$clave_seccion_pertenece'  
								and (case usar_vigencia 
									when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
									when 'no' then 1
									else 0 end)
								and  situacion = 'activo'	
								order by orden";
								$res_sub  = mysql_query($con_sub);
							}
					}	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)	
					{
						echo '<table width="'.$ancho.'" border="0" cellspacing="0" cellpadding="0" align="center">';
							if($mostrar_titulo=="si")
								{
									echo'<tr><td align= "center" class="titulo_subsecciones" >'.$titulo.'<br /><br /></td></tr>';
								}
							echo'<tr>';
								echo '<td align="left">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										while($ren = mysql_fetch_array($res_sub))
											{
												$titulo = $ren["titulo"];
												$clave_seccion = $ren["clave_seccion"];
												$tipo_contenido = $ren["tipo_contenido"];
												$tipo_titulo = $ren["tipo_titulo"];
												$flash_secion = $ren["flash_secion"];
												$imagen_secion = $ren["imagen_secion"];	
												$ancho_medio = $ren["ancho_medio"];	
												$alto_medio = $ren["alto_medio"];	
												$formato = '';
												if($tipo_contenido=="xml")
													{
														$formato = '&amp;formato=xml';
													}
												echo'<tr>';
													if($mostrar_balazo=="si")
														{
															echo '<td align="left"><img src="'.$imagen_balazo.'" alt="'.$alt_bal.'" title="'.$titulo_bal.'" /></td>';	
															echo '<td width="1%">&nbsp;</td>';
														}
													echo '<td align="left" width="100%">';
													if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
														{
															echo '<a class="lista_subsecc_vert_tabla" href="index.php?sec='.$clave_seccion.$formato.'" >';	
															if($tipo_titulo=="texto")
															{echo $titulo;}
															elseif($tipo_titulo=="imagen")
															{echo '<img width="'.$ancho_medio.'" height="'.$alto_medio.'" src="'.$imagen_secion.'" border="0" alt="" title="" >';}
															echo '</a>';
														}
													elseif($tipo_titulo=="flash")
														{
															echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
														}
													echo '</td>';	
												echo'</tr>';	
												echo'<tr>';
													if($mostrar_balazo=="si")
														{
															echo '<td align="left" height="'.$espacio_secciones.'"></td><td width="1%" height="'.$espacio_secciones.'"></td>';
														}
													echo '<td align="left" width="100%" height="'.$espacio_secciones.'" ></td>';
												echo'</tr>';
											}
									echo '</table>';
								echo '</td>';
							echo'</tr>';
						echo '</table>';
					}
			}
		function lis_secc_prin_ver_tablas($inicio, $cantidad, $ancho, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				/*Función descotinuada, por usar tablas, remplazada por lis_secc_prin_ver_ul en la version 0.1.6*/
				$inicio--;
				$hoy = date('Y-m-d');
				$con_sec = " select clave_seccion, titulo, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio from  nazep_secciones  where clave_seccion_pertenece = '1' 
					        and (case usar_vigencia  when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy' when 'no' then 1 else 0 end) and situacion = 'activo' order by orden limit $inicio, $cantidad";
				$res_sub  = mysql_query($con_sec);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)
					{
						echo '<table width="'.$ancho.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
							if($mostrar_titulo=="si")
								{ echo'<tr><td align="center" class="titulo_secc_principales" >'.$titulo.'<br /></td></tr>'; }	
							echo'<tr><td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">';
							while($ren = mysql_fetch_array($res_sub))
								{
									$titulo = $ren["titulo"];
									$clave_seccion = $ren["clave_seccion"];
									$tipo_contenido = $ren["tipo_contenido"];
									$tipo_titulo = $ren["tipo_titulo"];
									$flash_secion = $ren["flash_secion"];
									$imagen_secion = $ren["imagen_secion"];	
									$ancho_medio = $ren["ancho_medio"];
									$alto_medio = $ren["alto_medio"];
									$formato = '';
									if($tipo_contenido=="xml")
										{ $formato = '&amp;formato=xml'; }
									echo'<tr>';
										if($mostrar_balazo=="si")
											{ echo '<td align="left"><img src="'.$imagen_balazo.'" alt="'.$alt_bal.'" title="'.$titulo_bal.'" /></td><td width="1%">&nbsp;</td>';}
										echo '<td align="left" width="100%">';
										if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
											{
												echo '<a class="menu_prin_vertical" href="index.php?sec='.$clave_seccion.$formato.'" >';	
												if($tipo_titulo=="texto")
												{echo $titulo;}
												elseif($tipo_titulo=="imagen")
												{echo '<img src="'.$imagen_secion.'" width="'.$ancho_medio.'" height="'.$alto_medio.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
												echo '</a>';
											}
										elseif($tipo_titulo=="flash")
											{ echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';}
									echo '</td></tr>';
									echo'<tr>';
										if($mostrar_balazo=="si")
											{ echo '<td align="left" height="'.$espacio_secciones.'"></td><td width="1%" height="'.$espacio_secciones.'"></td>';}
									echo '<tdalign="left" width="100%" height="'.$espacio_secciones.'"></td></tr>';
								}
						echo '</table></td></tr></table>';
					}
			}
		function lis_secc_prin_hor_tablas($inicio, $cantidad, $simbolo, $ancho)
			{
				/*
				Función que te permite hacer un listado de las secciones principales del portal 
				en forma horizontal en una tabla con un ancho variable,
				separados por un simbolo personalizable y mostrando una cantidad establecida.
				*/
				$inicio--;
				$conexion = $this->conectarse();
				$hoy = date('Y-m-d');
				$con_secciones = "select clave_seccion, titulo, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from 
				nazep_secciones 
				where 
				clave_seccion_pertenece = '1' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
					else 0 end)
				and situacion = 'activo'
				order by orden limit $inicio, $cantidad";
				$res_sec = mysql_query($con_secciones);
				echo '<table width="'.$ancho.'" border="0" cellpadding="0" align="center" cellspacing="5">';
					echo'<tr>';
						echo '<td>';
							$con = 1;
							while($ren = mysql_fetch_array($res_sec))
								{
									$clave_seccion = $ren["clave_seccion"];
									$titulo = $ren["titulo"];
									$tipo_contenido = $ren["tipo_contenido"];
									$tipo_titulo = $ren["tipo_titulo"];
									$flash_secion = $ren["flash_secion"];
									$imagen_secion = $ren["imagen_secion"];
									$ancho_medio = $ren["ancho_medio"];	
									$alto_medio = $ren["alto_medio"];
									$formato = '';
									if($tipo_contenido=="xml")
										{
											$formato = '&amp;formato=xml';
										}
									if($con > 1)
										{
											echo '<span class="simb_sep_men_prin_hor">';
											echo '&nbsp;'.$simbolo.'&nbsp;';	
											echo '</span>';
										}
									if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
										{
											echo '<a class="menu_prin_horizontal" href="index.php?sec='.$clave_seccion.$formato.'" >';	
											if($tipo_titulo=="texto")
											{echo $titulo;}
											elseif($tipo_titulo=="imagen")
											{echo '<img width="'.$ancho_medio.'" height="'.$alto_medio.'" src="'.$imagen_secion.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
											echo '</a>';
										}
									elseif($tipo_titulo=="flash")
										{
											echo '<embed width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
										}
									$con++;			
								}
						echo '</td>';
					echo'</tr>';
				echo '</table>';
			}
		function lis_secc_prin_ver_ul($inicio, $cantidad, $anc_mar_izq, $anc_mar_der, $alto_sep, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				$inicio--;
				$hoy = date('Y-m-d');
				$con_sec = " select clave_seccion, titulo, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
					from  nazep_secciones 
					where clave_seccion_pertenece = '1' 
					and (case usar_vigencia 
						when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
						when 'no' then 1
						else 0 end)
					and situacion = 'activo' order by orden limit $inicio, $cantidad";
				$res_sub  = mysql_query($con_sec);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)
					{
						if($mostrar_titulo=="si")
							{echo'<div id="nzp_div_tit_menu" class="titulo_secc_principales" >'.$titulo.'</div>';}						
						if($mostrar_balazo=="si")
							{$balazo_ul = 'list-style-image:url('.$imagen_balazo.');';}
						else
							{$balazo_ul = 'list-style: none;';}
						echo '<ul style="'.$balazo_ul.' margin:0px; padding-left: '.$anc_mar_izq.';  padding-right: '.$anc_mar_der.';">';
						while($ren = mysql_fetch_array($res_sub))
							{
								$titulo = $ren["titulo"];
								$clave_seccion = $ren["clave_seccion"];
								$tipo_contenido = $ren["tipo_contenido"];
								$tipo_titulo = $ren["tipo_titulo"];
								$flash_secion = $ren["flash_secion"];
								$imagen_secion = $ren["imagen_secion"];	
								$ancho_medio = $ren["ancho_medio"];
								$alto_medio = $ren["alto_medio"];
								$formato = '';
								if($tipo_contenido=="xml")
									{
										$formato = '&amp;formato=xml';
									}
								echo'<li style="padding-bottom:'.$alto_sep.';" >';
										if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
											{
												echo '<a class="menu_prin_vertical" title="'.$titulo.'" href="index.php?sec='.$clave_seccion.$formato.'" >';	
												if($tipo_titulo=="texto")
												{echo $titulo;}
												elseif($tipo_titulo=="imagen")
												{echo '<img src="'.$imagen_secion.'" width="'.$ancho_medio.'" height="'.$alto_medio.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
												echo '</a>';
											}
										elseif($tipo_titulo=="flash")
											{
												echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
											}	
								echo '</li>';
							}
						echo '</ul>';
					}
			}
		function lis_subsecc_ver_ul($sec, $anc_mar_izq, $anc_mar_der, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				$hoy = date('Y-m-d');
				$con_sub = "select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from nazep_secciones
				where clave_seccion_pertenece = '$sec' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
				    else 0 end)
				and situacion = 'activo'
				order by orden";
				$res_sub  = mysql_query($con_sub);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub=="0")
					{
						$con_sub2 = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
						$res_sub2 = mysql_query($con_sub2);
						$ren_sub2 = mysql_fetch_array($res_sub2);
						$clave_seccion_pertenece = $ren_sub2["clave_seccion_pertenece"];
						if($clave_seccion_pertenece!=1)
							{
								$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio 
								from nazep_secciones
								where clave_seccion_pertenece = '$clave_seccion_pertenece'  
								and (case usar_vigencia 
									when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
									when 'no' then 1
									else 0 end)
								and  situacion = 'activo'	
								order by orden";
								$res_sub  = mysql_query($con_sub);
							}
					}	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)	
					{
							if($mostrar_titulo=="si")
								{echo'<div id="nzp_div_tit_subsec" class="titulo_subsecciones" >'.$titulo.'</div>';}
							if($mostrar_balazo=="si")
								{$balazo_ul = 'list-style-image:url('.$imagen_balazo.');';}
							else
								{$balazo_ul = 'list-style: none;';}
							echo '<ul style="'.$balazo_ul.' margin:0px; padding-left: '.$anc_mar_izq.';  padding-right: '.$anc_mar_der.';">';
							while($ren = mysql_fetch_array($res_sub))
								{
									$titulo = $ren["titulo"];
									$clave_seccion = $ren["clave_seccion"];
									$tipo_contenido = $ren["tipo_contenido"];
									$tipo_titulo = $ren["tipo_titulo"];
									$flash_secion = $ren["flash_secion"];
									$imagen_secion = $ren["imagen_secion"];	
									$ancho_medio = $ren["ancho_medio"];	
									$alto_medio = $ren["alto_medio"];	
									$formato = '';
									if($tipo_contenido=="xml")
										{
											$formato = '&amp;formato=xml';
										}
									echo'<li style="padding-bottom:'.$alto_sep.';" >';
										if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
											{
												echo '<a class="lista_subsecc_vert_ul" title="'.$titulo.'" href="index.php?sec='.$clave_seccion.$formato.'" >';	
												if($tipo_titulo=="texto")
												{echo $titulo;}
												elseif($tipo_titulo=="imagen")
												{echo '<img src="'.$imagen_secion.'" width="'.$ancho_medio.'" height="'.$alto_medio.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
												echo '</a>';
											}
										elseif($tipo_titulo=="flash")
											{
												echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
											}
									echo '</li>';
								}
							echo '</ul>';								
					}
			}
		function existencia_seccion($sec)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_seccion from nazep_secciones where clave_seccion = '$sec'";
				$res_con = mysql_query($con_sec);
				$can_sec = mysql_num_rows($res_con);
				if($can_sec==1)
					{
						$situacion = $this->situacion_seccion($sec);
						if($situacion=="cancelado")
							{$existe = false; }
						else
							{ $existe = true; }
					}
				else
					{ $existe = false; }
				return $existe;
			}
		function situacion_seccion($sec)
			{
				$conexion = $this->conectarse();
				$con_sec = "select situacion from nazep_secciones where clave_seccion = '$sec'";
				$res_con = mysql_query($con_sec);
				$ren_con = mysql_fetch_array($res_con);
				$situacion = $ren_con["situacion"]; 
				return $situacion;			
			}
		function seccion_protegida($sec)
			{
				$conexion = $this->conectarse();
				$consulta_proteccion = " select protegida from nazep_secciones  where clave_seccion = '$sec'";
				$res = mysql_query($consulta_proteccion);
				$ren = mysql_fetch_array($res);
				$protegida = $ren["protegida"];	
				return 	$protegida;		
			}	
		function form_buscador($ancho_tabla, $ancho_input, $tex_btn)
			{
				$cons_buscador = "select clave_buscador from nazep_configuracion";
				$res_bus = mysql_query($cons_buscador);
				$ren_bus = mysql_fetch_array($res_bus);
				$clave_buscador = $ren_bus["clave_buscador"];
				echo '<form name="buscador_mini" action="index.php?sec='.$clave_buscador.'" method="post" >';
					echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center">';
						echo'<tr>';
							echo '<td align= "center" >';
								echo '<input type="hidden" name="buscador" value = "mini" />';
								echo '<input type = "text" name="frase" size="'.$ancho_input.'" /><br />';
								echo '<input type="submit" name="btn_buscar" value="'.$tex_btn.'" />';
							echo '</td>';
						echo '</tr>';
					echo '</table>';
				echo '</form>';
			}
		function titulo_seccion($sec)
			{
				$con_seccion = "select titulo from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion = mysql_query($con_seccion);
				$ren_seccion = mysql_fetch_array($res_seccion);
				$titulo = $ren_seccion["titulo"];
				return $titulo;				
			}
		function keywords_seccion($sec)
			{
				$con_seccion = "select usar_keywords, keywords from nazep_secciones where clave_seccion = '$sec'";
				$res_seccion = mysql_query($con_seccion);
				$ren_seccion = mysql_fetch_array($res_seccion);
				$keywords = $ren_seccion["keywords"];
				$usar_keywords = $ren_seccion["usar_keywords"];
				if($usar_keywords=="si")
				return $keywords;
				else
				return false;
			}
		function descripcion_seccion($sec)
			{
				$con_seccion = "select usar_descripcion, descripcion from nazep_secciones where clave_seccion = '$sec'";
				$res_seccion = mysql_query($con_seccion);
				$ren_seccion = mysql_fetch_array($res_seccion);
				$descripcion = $ren_seccion["descripcion"];
				$usar_descripcion = $ren_seccion["usar_descripcion"];
				if($usar_descripcion=="si")				
				return $descripcion;
				else
				return false;
			}
		function historial_vista($sec, $simbolo, $alineacion, $target)
			{
				/*
				Función que te permite ver le historial de navegación en las secciones del portal.
				se recibe la clave de la sección y el simbolo que se usara para dividir las secciones 
				*/
				$clave_seccion_usada = $sec;
				for($a=1;$a>0;$a++)
					{	
						if($clave_seccion_usada=="")
							{$clave_seccion_usada = '1';}
						$con = "select clave_seccion_pertenece, titulo from nazep_secciones where clave_seccion = '$clave_seccion_usada'";	
						$res = mysql_query($con);
						$ren = mysql_fetch_array($res);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"]; 
						$titulo = $ren["titulo"];
						$arreglo_seccion[$a] = $clave_seccion_usada;
						$nombre_seccion[$a] = $titulo;
						if($clave_seccion_usada == 1)
							{$a = -1;}
						else
							{$clave_seccion_usada = $clave_seccion_pertenece;}			
					}
				$cantidad = count($nombre_seccion);
				echo '<table width="100%" border="0">';
					echo '<tr>';
						echo '<td align="'.$alineacion.'">';
							for($a=$cantidad;$a>0;$a--)
								{
									$clave = $arreglo_seccion[$a];
									$nombre = $nombre_seccion[$a];	
									if($a!=1)
										{
											echo '<a class="enlace_historial" href= "index.php?sec='.$clave.'" target="'.$target.'">'.$nombre.'</a>';
											echo '<span class="flecha_historial">&nbsp;'.$simbolo.'&nbsp;</span>';
										}
									else
										{
											echo '<span class="final_historia">'.$nombre.'</span>';
										}
								}
						echo '</td>';
					echo '</tr>';
				echo '</table>';
				return $nombre;
			}
		function historial_vista_div($sec, $simbolo, $target)
			{
				$clave_seccion_usada = $sec;
				for($a=1;$a>0;$a++)
					{	
						if($clave_seccion_usada=="")
							{$clave_seccion_usada = '1';}
						$con = "select clave_seccion_pertenece, titulo from nazep_secciones where clave_seccion = '$clave_seccion_usada'";	
						$res = mysql_query($con);
						$ren = mysql_fetch_array($res);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"]; 
						$titulo = $ren["titulo"];
						$arreglo_seccion[$a] = $clave_seccion_usada;
						$nombre_seccion[$a] = $titulo;
						if($clave_seccion_usada == 1)
							{$a = -1;}
						else
							{$clave_seccion_usada = $clave_seccion_pertenece;}
					}
				$cantidad = count($nombre_seccion);
				echo '<div id="cuerpo_historial_seccion" class="clas_cuerpo_historial_seccion" >';
					for($a=$cantidad;$a>0;$a--)
						{
							$clave = $arreglo_seccion[$a];
							$nombre = $nombre_seccion[$a];
							if($a!=1)
								{
									echo '<a class="enlace_historial" href= "index.php?sec='.$clave.'" target="'.$target.'">'.$nombre.'</a>';
									echo '<span class="flecha_historial">&nbsp;'.$simbolo.'&nbsp;</span>';
								}
							else
								{
									echo '<span class="final_historia">'.$nombre.'</span>';
								}
						}
				echo '</div>';
				return $nombre;
			}			
			
		function ver_visitas_sec($sec)
			{
				$conexion = $this->conectarse();
				$res_visitas = mysql_query("select visitas from nazep_secciones  where clave_seccion = '$sec' ");
				$ren_visitas = mysql_fetch_array($res_visitas);
				$visitas = $ren_visitas["visitas"];	
				echo '<span class="texto_visitas">'.gral_visitas.'</span>';
				echo '<span class="numero_visitas">'.$visitas.'</span>';	
			}
		function visitas_simple($sec)
			{
				$conexion = $this->conectarse();
				$fecha_hoy = date("Y-m-d");
				$con_visita = "select clave_visita, visita from nazep_v_visitas_simple where fecha = '$fecha_hoy' and clave_seccion = '$sec'";
				$res_visita = mysql_query($con_visita);
				$can_res =  mysql_num_rows($res_visita);
				if($can_res!="")
					{
						$ren = mysql_fetch_array($res_visita);
						$visita = $ren["visita"];
						$visita++;
						$consulta = "update nazep_v_visitas_simple set visita = '$visita' where fecha = '$fecha_hoy' and clave_seccion = '$sec'";
					}
				else
					{
						$consulta = "insert into nazep_v_visitas_simple (clave_seccion, fecha, visita) values ('$sec', '$fecha_hoy', '1')";
					}
				if (!@mysql_query($consulta))
					{
						echo 'visita no registrada';
					}
				else
					{
						$update_sec = "update nazep_secciones set visitas = visitas+1 where clave_seccion = '$sec'";
						if (!@mysql_query($update_sec))
							{
								echo 'visita no registrada';
							}
					}
			}
//************************************************************************ FIN FUNCIONES PARA MULTIPLES USOS *****************************************************************
	}
session_start();  
$sesion_temporal = md5(nombre_base);
if (!isset($_SESSION[$sesion_temporal]))
	{
		$_SESSION[$sesion_temporal] = new vista_final();
	}
?>