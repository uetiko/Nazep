<?php
/*
Sistema: Nazep
Nombre archivo: html_admon.php
Funci�n archivo: Generar toda las funciones para mostrar los elementos web de la aplicaci�n
Fecha creaci�n: Marzo 2011
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
class HtmlAdmon
	{
		public static function int_contectarse()
			{
				$objconect = new conexion();
				$objconect->conectarse();				
			}
		public static function RadiosSiNO($arr)
			{
				//Inicia valores por defecto
				$cadena_mostrar='';
				$cadena_mostrar_f='';
				$val_che = array('si'=>'checked="checked"','no'=>'');
				//Termina valores por defecto
				
				//asignar valores personalizados				
				$ValorSeleccionado = ( isset($arr["ValorSeleccionado"]) && $arr["ValorSeleccionado"]!=''  ) ? $arr["ValorSeleccionado"]:'si';
				$NombreRadio = ( isset($arr["NombreRadio"]) && $arr["NombreRadio"]!=''  ) ?  $arr["NombreRadio"]:'';
				$Radio_clase_css =( isset($arr["class"]) && $arr["class"]!=''  ) ? $arr["class"]:'';
				$tipo_presentacion = ( isset($arr["tipo_presentacion"]) && $arr["tipo_presentacion"]!=''  ) ?$arr["tipo_presentacion"]:'echo';
				$orden=( isset($arr["orden"]) && $arr["orden"]!=''  ) ? $arr["orden"]:'si-no';
				
				if(!$orden=='si-no' || !$orden=='no-si')
					{echo 'Tu dato de orden "'.$orden.'" Se mando en formato incorecto el orden, se tiene que enviar en "si-no"  o "no-si" ';}
				else
					{
						$orden_array = explode('-',$orden);
						if($ValorSeleccionado=='si')
							{ $val_che = array('si'=>'checked="checked"','no'=>''); }							
						else if($ValorSeleccionado=='no')
							{ $val_che = array('si'=>'','no'=>'checked="checked"'); }
						else
							{ echo 'Se mando en formato incorecto en el valor seleccionado solo se reciben valores "si" o "no"'; }		
						
						$cadena_mostrar['si'] = html::label(array('presentacion'=>'return', 'tipo'=>'inifin', 'for'=>$NombreRadio.'_si', 'contenido'=>'SI'))
						.html::input(array('presentacion'=>'return', 'type'=>'radio', 
						'name'=>$NombreRadio, 'value' => 'si', 'id'=>$NombreRadio.'_si', 'varios'=>$val_che['si']));										
						
						$cadena_mostrar['no'] = html::label(array('presentacion'=>'return', 'tipo'=>'inifin', 'for'=>$NombreRadio.'_no', 'contenido'=>'NO'))
						.html::input(array('presentacion'=>'return','type'=>'radio', 
						'name'=>$NombreRadio,  'value' => 'no', 'id'=>$NombreRadio.'_no', 'varios'=>$val_che['no']));
																						
						$cadena_mostrar_f = $cadena_mostrar[$orden_array[0]].$cadena_mostrar[$orden_array[1]];
												
						if($tipo_presentacion=='echo')
							echo $cadena_mostrar_f;
						else if($tipo_presentacion=='return')
							return $cadena_mostrar_f;						
					}
			}
		public static function historial($sec)
			{		
				HtmlAdmon::int_contectarse();
				$clave_seccion_usada = $sec;
				for($a=1;$a>0;$a++)
					{	
						$con = " select clave_seccion_pertenece, nombre from nazep_secciones where clave_seccion = '$clave_seccion_usada' ";	
						$res = mysql_query($con);
						$ren = mysql_fetch_array($res);
						$clave_seccion_pertenece = $ren['clave_seccion_pertenece']; 
						$titulo = $ren['nombre'];
						$arreglo_seccion[$a] = $clave_seccion_usada;
						$nombre_seccion[$a] = $titulo;
						if($clave_seccion_usada == 1)
							{$a = -1;}
						else
							{$clave_seccion_usada = $clave_seccion_pertenece;}			
					}
				$cantidad = count($nombre_seccion);
				$nombre_final = '';
				echo '<table width="100%" border="0" bgcolor="#999798" ><tr><td align = "left">';
							for($a=$cantidad;$a>0;$a--)
								{								
									$clave = $arreglo_seccion[$a];
									$nombre = $nombre_seccion[$a];	
									if($a!=1)
										{ echo $nombre.'&nbsp;->&nbsp;';}
									else
										{ echo $nombre;	 }
								}
				echo '</td></tr></table>';
				return $nombre;
			}		
		public static function titulo_seccion($mensaje)
			{
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  align ="center" class="imagen_titulo_sec"><tr><td align="center" height="20">
				<strong>'.$mensaje.'</strong></td></tr></table>';
			}		
		public static function acceso_denegado()
			{
				echo '<table width="100%" cellspacing="0" cellpadding="0"  border="0"><tr><td height="50" align ="center">'.opcion_denegado.'</td></tr></table>';
			}				
		public static function boton_regreso($arr)
			{
				$tipo = ( isset($arr["tipo"]) && $arr["tipo"]!=''  ) ? $arr["tipo"] : 'sencillo';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				$clave_usar = ( isset($arr["clave_usar"]) && $arr["clave_usar"]!=''  ) ? $arr["clave_usar"] :1;							
				$par_seccion='';
				if($clave_usar=='')
					{$par_seccion='';}
				else
					{$par_seccion='&amp;clave_seccion='.$clave_usar;}
				$texto =  ( isset($arr["texto"]) && $arr["texto"]!=''  ) ? $arr["texto"]: 'Regresar';				
				$OpcOcultas = ( isset($arr["OpcOcultas"]) && $arr["OpcOcultas"]!=''  ) ? $arr["OpcOcultas"]: array();
								 
				$opc_regreso = (isset($arr["opc_regreso"])) ? $arr["opc_regreso"] :'' ;
				if($opc_regreso=='')
					$opc_regreso=11;
				else if($opc_regreso=='metodo')
					$opc_regreso=111;
				else if($opc_regreso=='modificar')
					$opc_regreso=11;
				else if($opc_regreso=='cambios')
					$opc_regreso=12;
				else if($opc_regreso=='nuevaseccion')
					$opc_regreso=13;
				else if($opc_regreso=='estadisticas')
					$opc_regreso=14;
				elseif($opc_regreso=='listado')
					$opc_regreso=1;
				$contenido_a = html::img(array('id'=>'imagen_regresar',
					'src'=>'imagenes/atras.gif',
					'alt'=>img_regresar,
					'title'=>$texto,
					'presentacion'=>'return')).'<br /><strong>'.$texto.'</strong>';
					
				$contenido_div = '';
				if($tipo =='sencillo')
					{
						$contenido_div = html::a(array('href'=>'index.php?opc='.$opc_regreso.$par_seccion, 'class'=>'regresar','presentacion'=>'return','tipo'=>'inifin', 'contenido' => $contenido_a));
					}
				elseif($tipo=='avanzado')
					{
						$todas_opciones = '';
						foreach($OpcOcultas as $nombre => $valor)
							{
								$todas_opciones .= html::input(array('presentacion'=>'return', 'type'=>'hidden','value'=>$valor,'id'=>$nombre,'name'=>$nombre ));
							}
						$enlace = html::a(array('href'=>'javascript:document.frm_regresar.submit()',
												'class'=>'regresar', 'presentacion'=>'return',
												'tipo'=>'inifin', 'contenido' => $contenido_a));
						$contenido_form = $todas_opciones.$enlace;						
						$contenido_div = html::form(array('presentacion'=>'return',
														'action'=>'index.php?opc=111'.$par_seccion,
														'class'=>'margen_cero',
														'name'=>'frm_regresar',
														'ir'=>'frm_regresar',
														'tipo'=>'inifin',
														'contenido'=>$contenido_form
														));
					}
				
				html::div(array( 'presentacion'=>'echo', 'id'=>'boton_regreso', 'class'=>'css_boton_regreso','tipo'=>'inifin', 'contenido'=>$contenido_div ));							
			}
		public static function div_res_oper($arr)
			{
				echo '<div class = "div_resultado_operacion" id="div_resultado_operacion"></div>';
			}
		public static function AccesoMetodo($arr)
			{
				//Inicia valores por defecto
				$cadenaUsar = '';
				$opcionNavega = (isset($arr["opcionNavega"]) && $arr["opcionNavega"]!='') ? $arr["opcionNavega"]: 111;
				$claveSeccion = (isset($arr["ClaveSeccion"]) && $arr["ClaveSeccion"]!='') ? '&amp;clave_seccion='.$arr["ClaveSeccion"]: '';
				
				$action = 'index.php?opc='.$opcionNavega.$claveSeccion;
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';							
				$class =(isset($arr["class"]) && $arr["class"]!='') ? $arr["class"]: 'margen_cero';
				$method = (isset($arr["method"]) && $arr["method"]!='') ? $arr["ClaveSeccion"]:'POST';				
				$name = (isset($arr["name"]) && $arr["name"]!='') ? $arr["name"] : 'FormularioAcceso';
				$id =(isset($arr["id"]) && $arr["id"]!='') ? $arr["id"] : 'FormularioAcceso';
				$OpcAntes = (isset($arr["OpcAntes"]) && $arr["OpcAntes"]!='') ? $arr["OpcAntes"]: '';
				$OpcDespues = (isset($arr["OpcDespues"]) && $arr["OpcDespues"]!='') ? $arr["OpcDespues"]: '';
				$BText = (isset($arr["BText"]) && $arr["BText"]!='') ? $arr["BText"] : 'Acceso Metodo';
				$BName = (isset($arr["BName"]) && $arr["BName"]!='') ? $arr["BName"]: 'Boton_Metodo';
				$BId = (isset($arr["BId"]) && $arr["BId"]!='') ? $arr["BId"] :'Boton_Metodo';				
				$BSrc = (isset($arr["BSrc"]) && $arr["BSrc"]!='') ?$arr["BSrc"] : '';				
				$OpcOcultas = (isset($arr["OpcOcultas"]) && $arr["OpcOcultas"]!='') ? $arr["OpcOcultas"]: array();
				//Inicio formularo
				$cadenaUsar =  html::form(array('presentacion'=>'return', 'action'=>$action , 'class'=>$class, 'name'=>$name, 'id'=>$id,  'tipo'=>'ini') );
				//Boton
				$cadenaUsar .= $OpcAntes;				
				$cadenaUsar .= html::input(array( 'presentacion'=>'return', 'type'=>'submit',  'value'=>$BText, 'id'=>$BId , 'name'=>$BName ,  'src'=>$BSrc ) );
				$cadenaUsar .= $OpcDespues;
				//Opciones Ocultas
				foreach($OpcOcultas as $nombre => $valor)
					{ 
						$cadenaUsar .= html::input( array('presentacion'=>'return','type'=>'hidden', 'value'=>$valor, 'id'=>$nombre , 'name'=>$nombre ) );  
					}					
				$cadenaUsar .=  html::form(array('presentacion'=>'return','tipo'=>'fin'));
				//Mandar Datos
				if($presentacion=='echo')
					echo $cadenaUsar;
				else if($presentacion=='return')
					return $cadenaUsar;
			}			
	}
?>