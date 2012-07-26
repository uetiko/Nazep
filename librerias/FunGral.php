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
class FunGral 
	{
		static private $mesesPosIngValLocal = array('January'=>mes_01,'February'=>mes_02, 'March'=>mes_03,'April'=>mes_04, 'May'=>mes_05,'June'=>mes_06, 'July'=>mes_07,'August'=>mes_08,'September'=>mes_09,'October'=>mes_10, 'November'=>mes_11,'December'=>mes_12);
		static private $diasPosIngValLocal = array('Monday'=>dia_01,'Tuesday'=>dia_02,'Wednesday'=>dia_03,'Thursday'=>dia_04,'Friday'=>dia_05,'Saturday'=>dia_06,'Sunday'=>dia_07);
		static private $abecedario = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'); 
		static private $abecedarioMa = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'); 
		static private $ClavesTextoFechas = array('FechaNormal','FechaNormalDMA','FechaNormalMA','FechaNormalCorta');
		static private $TextosFechas = array('lunes 1 de enero de 2000','1 de enero de 2000','enero de 2000','01/01/2000');
		static private $MesesNumero = array(1=>mes_01, 2=>mes_02,3=>mes_03,4=>mes_04,5=>mes_05,6=>mes_06,7=>mes_07,8=>mes_08,9=>mes_09,10=>mes_10,11=>mes_11,12=>mes_12);
		static private $MesesNombre = array('January'=>mes_01,'February'=>mes_02,'March'=>mes_03,'April'=>mes_04,'May'=>mes_05,'June'=>mes_06, 'July'=>mes_07,'August'=>mes_08,'September'=>mes_09,'October'=>mes_10,'November'=>mes_11,'December'=>mes_12);
		static private $DiasNumero = array(dia_01,dia_02,dia_03,dia_04,dia_05,dia_06,dia_07);
		static private $DiasNombres = array('Monday'=>dia_01,'Tuesday'=>dia_02,'Wednesday'=>dia_03,'Thursday'=>dia_04,'Friday'=>dia_05,'Saturday'=>dia_06,'Sunday'=>dia_07);
		static private $ArregloNiveles = array(nivel_01,nivel_02,nivel_03);		
		public static function int_contectarse()
			{
				$objconect = new conexion();
				$objconect->conectarse();				
			}
		public static function _Get($nombre, $otroValor='')
			{
				$val = (isset($_GET[$nombre])) ? $_GET[$nombre] :$otroValor;
				return $val;	
			}
		public static function _GetLimpio($nombre, $otroValor='')
			{
				$val = (isset($_GET[$nombre])) ? strip_tags(addslashes($_GET[$nombre])):$otroValor;  
				return $val;	
			}
		public static function _GetLimpioInt($nombre, $otroValor='')
			{
				$val = (isset($_GET[$nombre])) ? intval($_GET[$nombre]):$otroValor;  
				return $val;	
			}						
		public static function _Post($nombre, $otroValor='')
			{
				$val = (isset($_POST[$nombre])) ? $_POST[$nombre] :$otroValor;
				return $val;	
			}
		public static function _PostLimpio($nombre, $otroValor='')
			{
				$val = (isset($_POST[$nombre])) ? intval($_POST[$nombre]) :$otroValor;
				return $val;	
			}
		public static function _PostLimpioInt($nombre, $otroValor='')
			{
				$val = (isset($_POST[$nombre])) ? strip_tags(addslashes($_POST[$nombre])) :$otroValor;
				return $val;	
			}
		public static function _ValorArray($areglo,$posicion)
			{
				$val = (isset($areglo[$posicion])) ?$areglo[$posicion] :'';
				return $val;
			}						
		public static function VigenciaModulo($arrelo_elementos)
			{
				$clave_seccion_enviada =$arrelo_elementos["clave_seccion"];
				$clave_modulo =$arrelo_elementos["clave_modulo"];
				$fecha_hoy = date("Y-m-d");
				$con_mod_sec = "select situacion from nazep_secciones_modulos where clave_seccion = '$clave_seccion_enviada' and clave_modulo = '$clave_modulo' and ( case usar_vigencia_mod  when 'si' then fecha_inicio <= '$fecha_hoy' and fecha_fin >= '$fecha_hoy' else 1 end)";
				FunGral::int_contectarse();
				$res_con_mod = mysql_query($con_mod_sec);
				$ren_con_mod = mysql_fetch_array($res_con_mod);
				$situacion = $ren_con_mod["situacion"];
				if($situacion=='')
					{$situacion='cancelado';}
				return $situacion;				
			}
		public static function SaberIdioma()
			{
				FunGral::int_contectarse();
				$con_idioma = "select lenguaje from nazep_configuracion";
				$res_idioma = mysql_query($con_idioma);
				$ren_idioma = mysql_fetch_array($res_idioma);
				$lenguaje = $ren_idioma["lenguaje"];
				if($lenguaje=='')
					{$lenguaje='es';}
				return $lenguaje;
			}			
		public static function FechaNormal($fecha)
			{
				//ingresa una fecha en formato (YY-MM-DD)
				//regresa una fecha en formato Dia Semana Dia de Nombre mes de A�o
				$meses = FunGral::$mesesPosIngValLocal;				
				$dias = FunGral::$diasPosIngValLocal;				 
				list($tem_ano, $tem_mes, $tem_dia) = explode("-",$fecha);
				$fecha_unix = mktime(1,1,1,$tem_mes,$tem_dia,$tem_ano);
				$dia = getdate($fecha_unix);
				$dia_semana = $dia["weekday"];
				$mes_fecha =  $dia["month"];
				$dia_semana = $dias[$dia_semana];
				$mes_fecha = $meses[$mes_fecha];
				$lafecha = $dia_semana."&nbsp;".$tem_dia."&nbsp;de&nbsp;".$mes_fecha."&nbsp;de&nbsp;".$tem_ano;
				return $lafecha; 				
			}
		public static function FechaNormalDMA($fecha)
			{
				$meses = funGral::$mesesPosIngValLocal;
				$dias = funGral::$diasPosIngValLocal; 
				list($tem_ano, $tem_mes, $tem_dia) = explode("-",$fecha);
				$fecha_unix = mktime(1,1,1,$tem_mes,$tem_dia,$tem_ano);
				$dia = getdate($fecha_unix);
				$dia_semana = $dia["weekday"];
				$mes_fecha =  $dia["month"];
				$dia_semana = $dias[$dia_semana];
				$mes_fecha = $meses[$mes_fecha];
				$lafecha = $tem_dia."&nbsp;de&nbsp;".$mes_fecha."&nbsp;de&nbsp;".$tem_ano;	
				return $lafecha; 
			}
		public static function FechaNormalMA($fecha)
			{
				$meses = funGral::$mesesPosIngValLocal;
				$dias = funGral::$diasPosIngValLocal; 
				list($tem_ano, $tem_mes, $tem_dia) = explode("-",$fecha);
				$fecha_unix = mktime(1,1,1,$tem_mes,$tem_dia,$tem_ano);
				$dia = getdate($fecha_unix);
				$dia_semana = $dia["weekday"];
				$mes_fecha =  $dia["month"];
				$dia_semana = $dias[$dia_semana];
				$mes_fecha = $meses[$mes_fecha];
				$lafecha = $mes_fecha."&nbsp;de&nbsp;".$tem_ano;
				return $lafecha;
			}
		public static function FechaNormalCorta($fecha)
			{
				list($tem_ano, $tem_mes, $tem_dia) = explode("-",$fecha);
				$lafecha = $tem_dia."/".$tem_mes."/".$tem_ano;
				return $lafecha;
			}			
		public static function ArregloClaveFechas()
			{return FunGral::$ClavesTextoFechas;}
		public static function ArregloNombreFechas()
			{return FunGral::$TextosFechas;}
		public static function AbecedarioMin()
			{return FunGral::$abecedario;}				
		public static function AbecedarioMay()
			{return FunGral::$abecedarioMa;}
		public static function MesesNumero()
			{return FunGral::$MesesNumero;}
		public static function MesesNombre()
			{return FunGral::$MesesNombre;}
		public static function DiaNombre()
			{ return FunGral::$DiasNombres;}
		public static function DiaNumero()
			{return FunGral::$DiasNumero;}
		public static function Niveles()
			{return FunGral::$ArregloNiveles;}			
	}
?>