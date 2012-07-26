<?php
/*
Sistema: Nazep
Nombre archivo: conexion.php
Función archivo: Generar las funciones para las conexiones a base de datos y funciones generales a ocupar en todo el sistema
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
include("configuracion.php");
class conexion	
	{	
		var $host_mysql_con = host_mysql;
		var $nombre_user_con = nombre_user;
		var $pasword_user_con = pasword_user;
		var $nombre_base_con = nombre_base;
//************* Inicio de funciones de base de datos		
		function conectarse()
			{
				$conexion = mysql_connect($this->host_mysql_con, $this->nombre_user_con, $this->pasword_user_con) or die(mysql_error());	
				mysql_select_db($this->nombre_base_con) or die( mysql_error());
				return $conexion;
			} 
		function sentecia($cadena, $regreso) 
			{
				if (!@mysql_query($cadena))
					{
						echo "".error_query . mysql_errno() ."--" .mysql_error();
					}
				else
					{
						if($regreso!="")
							{
								echo "<br /><a href = $regreso>".correcto_query."</a>";
							}
					}
			}			
		function desconectarse($conexion)
			{
				mysql_close($conexion);
			}
		function crear_insert_simple($arreglo, $tabla)
			{
				$consulta_insertar = "insert into $tabla set ";
				foreach($arreglo as $indice=>$valor)
					{
						$consulta_insertar .= " $indice = '$valor', ";
					}
				$consulta_insertar = rtrim($consulta_insertar, ", ");
				$consulta_insertar .= ";";
				return $consulta_insertar;
			}
		function crear_update_simple($arreglo, $tabla, $condicion)
			{
				$consulta_update = "update $tabla set ";
				foreach($arreglo as $indice=>$valor)
					{
						$consulta_update .= " $indice = '$valor', ";
					}				
				$consulta_update = rtrim($consulta_update, ", ");
				$consulta_update .= "where $condicion";
				return $consulta_update;					
			}
		function escapar_caracteres($cadena_usar)
			{
				$cadena_final = '';
				if(function_exists("mysql_real_escape_string"))
					{
						$cadena_final = mysql_real_escape_string($cadena_usar);
					}
				else
					{
						$cadena_final = addslashes($cadena_usar);
					}
				return $cadena_final;
			}
//************* Fin de funciones de base de datos	
		//Se elimino Marzo 2012 function vigencia_modulo($arrelo_elementos){} ---> se paso a FunGral::vigenciaModulo()
		//Se elimino Marzo 2012 function car_normal(){} ---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function car_uft_8(){}		---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function car_htm(){} ---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function remplazar_htm($cadena){} ---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function convertir_normal_a_html($cadena){}	---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function convertir_normal_a_utf8($cadena){} ---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function remplazar_normal($cadena){} ---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function remplazar_uft8($cadena){} ---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function eliminar_etiquetas($cadena){} ---> no existe en ninguna otra parte
		//Se elimino Marzo 2012 function fecha_normal($fecha){} ---> se paso a FunGral::fechaNormal()
		//Se elimino Marzo 2012 function fecha_normal_d_m_a($fecha){} ---> se paso a FunGral::
		//Se elimino Marzo 2012 function fecha_normal_m_a($fecha){} ---> se paso a FunGral::
		//Se elimino Marzo 2012 function fecha_normal_corta($fecha){} ---> se paso a FunGral::
		//Se elimino Marzo 2012 function arreglo_clave_fechas(){}	---> se paso a FunGral::		
		//Se elimino Marzo 2012 function arreglo_nombre_fechas(){}  ---> se paso a FunGral::
		//Se elimino Marzo 2012 function abecedario_min(){}				
		//Se elimino Marzo 2012 function abecedario_may(){}
		//Se elimino Marzo 2012 function meses_numero(){}
		//Se elimino Marzo 2012 function meses_nombre(){}	
		//Se elimino Marzo 2012 function dia_nombre(){}
		//Se elimino Marzo 2012 function dia_numero(){}
		//Se elimino Marzo 2012 function niveles(){}
		//Se elimino Marzo 2012 function div_resultado_operacion(){}
		//Se elimino Marzo 2012 function btn_regresar_modificar(){}			
		//Se elimino Marzo 2012 function btn_regresar_cambios(){}			
		//Se elimino Marzo 2012 function acceso_denegado(){}
		//Se elimino Marzo 2012 function titulo_seccion($mensaje){}	
		//Se elimino Marzo 2012 function contenido_no_disponible($ubicacion_tema){}	
		//Se elimino Marzo 2012 function saber_idioma(){}			
		//Se elimino Marzo 2012 function historial($sec){}
		//Se elimino Marzo 2012 function cambiar_color_elemento_form(){}		
		//Se elimino Marzo 2012 function tiempo_error($segundos){}	
		//Se elimino Marzo 2012 function verificar_fecha_javascript(){}
		//Se elimino Marzo 2012 function comparar_fechas_javascript(){}
		//Se elimino Marzo 2012 function verificar_email_javascript(){}
		//Se elimino Marzo 2012 function solo_numero_javascript(){}
	}
?>