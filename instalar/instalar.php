<?php
/*
Sistema: Nazep
Nombre archivo: instalar.php
Funcin archivo: Contener las funciones necesarias para instalar Nazep en el sitio
Fecha creación: junio 2007
Fecha última Modificacin: Julio 2009
Versin: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
Colaborador: Jorge Antonio Reyes Benitez
Correo electrónico: jorg_reyes@hotmail.com 
*/
include("../librerias/configuracion.php");
echo '<?xml version="1.0" encoding="utf-8"?>';
$paso = isset($_POST["paso"]) ? ($_POST["paso"]!="" ? $_POST["paso"] : "0") : "0";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<!--
// ***************************************************************
// ********************** NAZEP **********************************
// *** Administrador de Contenidos Web ***
// *** Desarrollador Claudio Morales Godinez ***
// *** Correo: claudio@nazep.com.mx ***
// *** Sitio Web : http://www.nazep.com.mx ***
// *** Versión 0.2***
// ***************************************************************
-->
	<head><title> .::. Sistema de instalaci&oacute;n de NAZEP .::. Paso: <?php echo $paso; ?> .::.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link rel="SHORTCUT ICON" href="../admon/imagenes/favicon.ico" /><link rel="STYLESHEET" type="text/css" href="../admon/estilos.css" />
	</head><body>
		<table width="500" cellspacing="0" cellpadding="0"  border="0" align = "center">
			<tr>
				<td align="center" valign="top">
					<table width="500" border="0" cellspacing="0" cellpadding="0" style = " background-image:url(cabeza_instalar.jpg); background-repeat:no-repeat; height: 100px;">
						<tr><td align="right" valign="middle" height="100">Paso # <?php echo $paso; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
					</table>
					<br />
<?php					
					if($paso == '1')
						{					
                                                    $conecto = comprobar_conexion();
                                                    if($conecto)	
                                                        {
                                                            echo '<table width="500" border="0" cellspacing="0" cellpadding="0" >';
                                                                    echo '<tr><td align = "center">La conexi&oacute;n con la base de datos ha sido exitosa.</td></tr>';
                                                            echo '</table>';
                                                            echo '<br />';
                                                            $con_tablas  ='select * from nazep_configuracion';
                                                            $conexion = conectarse();
                                                            $res_con = mysql_query($con_tablas);
                                                            $error = mysql_errno();
                                                            if($error=="1146")
                                                                    {
                                                                        //Si no existen las tablas se mostraran las opciones para crearlas
                                                                        $res_tipo_tablas = mysql_query("SHOW VARIABLES LIKE '%have_innodb%';");
                                                                        $ren_tipo = mysql_fetch_array($res_tipo_tablas);
                                                                        $variable_name = $ren_tipo["Variable_name"];
                                                                        $value = $ren_tipo["Value"];
                                                                        if($variable_name=="have_innodb")
                                                                            {	
                                                                                if($value=="YES")
                                                                                    { $tabla = true; }
                                                                            }
                                                                        echo '<form id="crear_tablas_simples"  name="crear_tablas_simples" method="post" action="instalar.php" >';	
                                                                            echo '<table width="500" border="0" cellspacing="0" cellpadding="0" >';
                                                                                echo '<tr>';
                                                                                    echo '<td align = "center">';
                                                                                        echo 'Tipos de tablas&nbsp;&nbsp;';
                                                                                        echo '<select name = "tipo_tablas">';
                                                                                            echo '<option value = "MyISAM" >MyISAM</option>';
                                                                                            if($tabla)
                                                                                                { echo '<option value = "InnoDB" >InnoDB</option>'; }
                                                                                        echo '</select>';
                                                                                    echo '</td>';
                                                                                echo '</tr>';
                                                                                echo '<tr><td align = "center">&nbsp;</td></tr>';
                                                                                echo '<tr>';
                                                                                    echo '<td align = "center">';
                                                                                        echo '<input type="hidden" name="paso" value = "2" />';
                                                                                        echo '<input type="submit" name="btn_guardar" value="Crear las tablas en la Base de Datos" />';	
                                                                                    echo '</td>';
                                                                                 echo '</tr>';	
                                                                            echo '</table>';
                                                                        echo '</form>';
                                                                    }
                                                            else
                                                                    {
                                                                        $consutar_fin = "select instalado from nazep_configuracion";
                                                                        $res_con_fin = mysql_query($consutar_fin);
                                                                        $ren_con_fin = mysql_fetch_array($res_con_fin);
                                                                        $instalado = $ren_con_fin["instalado"];
                                                                        if($instalado == 'no')
                                                                            {
                                                                                echo '<form name="pasar_paso1" method="post" action="instalar.php" >';	
                                                                                    echo '<table width="500" border="0" cellspacing="0" cellpadding="0" >';
                                                                                            echo '<tr><td align = "center"><input type="hidden" name="paso" value = "3" /><input type="submit" name="btn_guardar" value="Configuraci&oacute;n de Nazep" /></td></tr>';
                                                                                    echo '</table>';
                                                                                echo '</form>';

                                                                            }
                                                                        else
                                                                            {
                                                                                echo '<table width="500" border="0" cellspacing="0" cellpadding="0">';
                                                                                    echo '<tr><td align="center"> 
                                                                                            La instalaci&oacute;n de Nazep ha finalizado con &eacute;xito
                                                                                                    <br /><br />Le solicitamos que elimine la carpeta llamada <strong>/instalar/</strong> con su contenido
                                                                                                    para iniciar la visualizaci&oacute;n y administraci&oacute;n su portal<br /><br /><br />
                                                                                                    Le agradecemos por seleccionar Nazep para administrar su portal 
                                                                                          </td></tr>';
                                                                                echo '</table>';
                                                                            }
                                                                    }
                                                        }
						}		
					elseif($paso=="2")
						{
							$tipo_tablas = $_POST["tipo_tablas"];
							$fecha_hoy = date("Y-m-d");
							$anomas = date("Y")+1;
							$fecha_fin = $anomas."-".date("m-d");
							$hora_hoy = date ("H:i:s");
							$ip = $_SERVER['REMOTE_ADDR'];
							$error = borrar_tablas();
							$cadena_cascada='';													
							if($tipo_tablas == "InnoDB")
								{
									$cadena_cascada = 'ON UPDATE CASCADE ON DELETE RESTRICT';
								}
							$sql_instalar ="
create table nazep_paises ( 
clave_pais int auto_increment, 
nombre varchar(250)not null,
situacion varchar(20) not null, 
constraint clave_pais_pk primary key(clave_pais))ENGINE = $tipo_tablas  ;;

insert into nazep_paises values('1',' Pa&iacute;s no registrado','activo');;
insert into nazep_paises values('2',' Acrotiri y Dhekelia','activo');;
insert into nazep_paises values('3',' Afganist&aacute;n','activo');;
insert into nazep_paises values('4',' &Aacute;land','activo');;
insert into nazep_paises values('5',' Albania','activo');;
insert into nazep_paises values('6',' Alemania ','activo');;
insert into nazep_paises values('7',' Andorra ','activo');;
insert into nazep_paises values('8',' Angola','activo');;
insert into nazep_paises values('9',' Anguila','activo');;
insert into nazep_paises values('10',' Ant&aacute;rtida','activo');;
insert into nazep_paises values('11',' Antigua y Barbuda','activo');;
insert into nazep_paises values('12',' Antillas Neerlandesas','activo');;
insert into nazep_paises values('13',' Arabia Saudita','activo');;
insert into nazep_paises values('14',' Argelia','activo');;
insert into nazep_paises values('15',' Argentina','activo');;
insert into nazep_paises values('16',' Armenia','activo');;
insert into nazep_paises values('17',' Arrecife Kingman ','activo');;
insert into nazep_paises values('18',' Aruba','activo');;
insert into nazep_paises values('19',' Atol&oacute;n Johnston ','activo');;
insert into nazep_paises values('20',' Atol&oacute;n Midway ','activo');;
insert into nazep_paises values('21',' Atol&oacute;n Palmira','activo');;
insert into nazep_paises values('22',' Azerbaiy&aacute;n','activo');;
insert into nazep_paises values('23',' Bahamas','activo');;
insert into nazep_paises values('24',' Bahr&eacute;in','activo');;
insert into nazep_paises values('25',' Bandera de Australia Australia ','activo');;
insert into nazep_paises values('26',' Bandera de Austria Austria','activo');;
insert into nazep_paises values('27',' Bandera de Brasil Brasil','activo');;
insert into nazep_paises values('28',' Bandera de Canad Canad ','activo');;
insert into nazep_paises values('29',' Bandera de Chile Chile ','activo');;
insert into nazep_paises values('30',' Bandera de Egipto Egipto ','activo');;
insert into nazep_paises values('31',' Bandera de la Repblica Popular China China ','activo');;
insert into nazep_paises values('32',' Bangladesh','activo');;
insert into nazep_paises values('33',' Barbados','activo');;
insert into nazep_paises values('34',' B&eacute;lgica','activo');;
insert into nazep_paises values('35',' Belice','activo');;
insert into nazep_paises values('36',' Ben&iacute;n ','activo');;
insert into nazep_paises values('37',' Bermudas ','activo');;
insert into nazep_paises values('38',' Bielorrusia','activo');;
insert into nazep_paises values('39',' Bolivia','activo');;
insert into nazep_paises values('40',' Bosnia y Herzegovina','activo');;
insert into nazep_paises values('41',' Botsuana','activo');;
insert into nazep_paises values('42',' Brun&eacute;i','activo');;
insert into nazep_paises values('43',' Bulgaria','activo');;
insert into nazep_paises values('44',' Burkina Faso','activo');;
insert into nazep_paises values('45',' Burundi ','activo');;
insert into nazep_paises values('46',' But&aacute;n ','activo');;
insert into nazep_paises values('47',' Cabo Verde ','activo');;
insert into nazep_paises values('48',' Camboya ','activo');;
insert into nazep_paises values('49',' Camer&uacute;n','activo');;
insert into nazep_paises values('50',' Chad - Rep&uacute;blica de Chad','activo');;
insert into nazep_paises values('51',' Chipre ','activo');;
insert into nazep_paises values('52',' Chipre Septentrional','activo');;
insert into nazep_paises values('53',' Ciudad del Vaticano ','activo');;
insert into nazep_paises values('54',' Colombia ','activo');;
insert into nazep_paises values('55',' Comoras ','activo');;
insert into nazep_paises values('56',' Corea del Norte','activo');;
insert into nazep_paises values('57',' Corea del Sur','activo');;
insert into nazep_paises values('58',' Costa de Marfil ','activo');;
insert into nazep_paises values('59',' Costa Rica','activo');;
insert into nazep_paises values('60',' Croacia','activo');;
insert into nazep_paises values('61',' Cuba','activo');;
insert into nazep_paises values('62',' Dinamarca ','activo');;
insert into nazep_paises values('63',' Dominica ','activo');;
insert into nazep_paises values('64',' Ecuador','activo');;
insert into nazep_paises values('65',' El Salvador ','activo');;
insert into nazep_paises values('66',' Emiratos &Aacute;rabes Unidos','activo');;
insert into nazep_paises values('67',' Eritrea -','activo');;
insert into nazep_paises values('68',' Escocia ','activo');;
insert into nazep_paises values('69',' Eslovaquia ','activo');;
insert into nazep_paises values('70',' Eslovenia ','activo');;
insert into nazep_paises values('71',' Espa&ntilde;a ','activo');;
insert into nazep_paises values('72',' Estados Unidos de America','activo');;
insert into nazep_paises values('73',' Estonia ','activo');;
insert into nazep_paises values('74',' Etiop&iacute;a','activo');;
insert into nazep_paises values('75',' Filipinas','activo');;
insert into nazep_paises values('76',' Finlandia ','activo');;
insert into nazep_paises values('77',' Fiyi','activo');;
insert into nazep_paises values('78',' Francia','activo');;
insert into nazep_paises values('79',' Gab&oacute;n ','activo');;
insert into nazep_paises values('80',' Gambia ','activo');;
insert into nazep_paises values('81',' Georgia','activo');;
insert into nazep_paises values('82',' Ghana ','activo');;
insert into nazep_paises values('83',' Gibraltar','activo');;
insert into nazep_paises values('84',' Granada','activo');;
insert into nazep_paises values('85',' Grecia ','activo');;
insert into nazep_paises values('86',' Groenlandia','activo');;
insert into nazep_paises values('87',' Guadalupe','activo');;
insert into nazep_paises values('88',' Guam','activo');;
insert into nazep_paises values('89',' Guatemala','activo');;
insert into nazep_paises values('90',' Guayana Francesa','activo');;
insert into nazep_paises values('91',' Guernsey ','activo');;
insert into nazep_paises values('92',' Guinea ','activo');;
insert into nazep_paises values('93',' Guinea Ecuatorial ','activo');;
insert into nazep_paises values('94',' Guinea-Bissau','activo');;
insert into nazep_paises values('95',' Guyana ','activo');;
insert into nazep_paises values('96',' Hait&iacute; ','activo');;
insert into nazep_paises values('97',' Honduras','activo');;
insert into nazep_paises values('98',' Hong Kong ','activo');;
insert into nazep_paises values('99',' Hungr&iacute;a','activo');;
insert into nazep_paises values('100',' India ','activo');;
insert into nazep_paises values('101',' Indonesia ','activo');;
insert into nazep_paises values('102',' Inglaterra ','activo');;
insert into nazep_paises values('103',' Ir&aacute;n','activo');;
insert into nazep_paises values('104',' Iraq','activo');;
insert into nazep_paises values('105',' Irlanda ','activo');;
insert into nazep_paises values('106',' Irlanda del Norte ','activo');;
insert into nazep_paises values('107',' Isla Ascensi&oacute;n','activo');;
insert into nazep_paises values('108',' Isla Baker ','activo');;
insert into nazep_paises values('109',' Isla Bouvet ','activo');;
insert into nazep_paises values('110',' Isla Clipperton ','activo');;
insert into nazep_paises values('111',' Isla de Man ','activo');;
insert into nazep_paises values('112',' Isla de Navidad ','activo');;
insert into nazep_paises values('113',' Isla Howland','activo');;
insert into nazep_paises values('114',' Isla Jarvis ','activo');;
insert into nazep_paises values('115',' Isla Navaza ','activo');;
insert into nazep_paises values('116',' Isla Wake ','activo');;
insert into nazep_paises values('117',' Islandia ','activo');;
insert into nazep_paises values('118',' Islas Ashmore y Cartier ','activo');;
insert into nazep_paises values('119',' Islas Caim&aacute;n','activo');;
insert into nazep_paises values('120',' Islas Cocos','activo');;
insert into nazep_paises values('121',' Islas Cook','activo');;
insert into nazep_paises values('122',' Islas del Mar del Coral ','activo');;
insert into nazep_paises values('123',' Islas Feroe','activo');;
insert into nazep_paises values('124',' Islas Georgias del Sur y Sandwich del Sur','activo');;
insert into nazep_paises values('125',' Islas Heard y McDonald','activo');;
insert into nazep_paises values('126',' Islas Malvinas','activo');;
insert into nazep_paises values('127',' Islas Marianas del Norte ','activo');;
insert into nazep_paises values('128',' Islas Marshall ','activo');;
insert into nazep_paises values('129',' Islas Pitcairn ','activo');;
insert into nazep_paises values('130',' Islas Salom&oacute;n','activo');;
insert into nazep_paises values('131',' Islas Turcas y Caicos','activo');;
insert into nazep_paises values('132',' Islas V&iacute;rgenes Brit&aacute;nicas ','activo');;
insert into nazep_paises values('133',' Islas V&iacute;rgenes Estadounidenses ','activo');;
insert into nazep_paises values('134',' Israel','activo');;
insert into nazep_paises values('135',' Italia ','activo');;
insert into nazep_paises values('136',' Jamaica','activo');;
insert into nazep_paises values('137',' Jap&oacute;n','activo');;
insert into nazep_paises values('138',' Jersey ','activo');;
insert into nazep_paises values('139',' Jordania','activo');;
insert into nazep_paises values('140',' Kazajist&aacute;n','activo');;
insert into nazep_paises values('141',' Kenia ','activo');;
insert into nazep_paises values('142',' Kirguist&aacute;n','activo');;
insert into nazep_paises values('143',' Kiribati ','activo');;
insert into nazep_paises values('144',' Kosovo','activo');;
insert into nazep_paises values('145',' Kuwait','activo');;
insert into nazep_paises values('146',' Laos','activo');;
insert into nazep_paises values('147',' Lesoto','activo');;
insert into nazep_paises values('148',' Letonia ','activo');;
insert into nazep_paises values('149',' L&iacute;bano','activo');;
insert into nazep_paises values('150',' Liberia','activo');;
insert into nazep_paises values('151',' Libia','activo');;
insert into nazep_paises values('152',' Liechtenstein ','activo');;
insert into nazep_paises values('153',' Lituania','activo');;
insert into nazep_paises values('154',' Luxemburgo','activo');;
insert into nazep_paises values('155',' Macao ','activo');;
insert into nazep_paises values('156',' Macedonia','activo');;
insert into nazep_paises values('157',' Madagascar','activo');;
insert into nazep_paises values('158',' Malasia','activo');;
insert into nazep_paises values('159',' Malawi ','activo');;
insert into nazep_paises values('160',' Maldivas ','activo');;
insert into nazep_paises values('161',' Mal&iacute; ','activo');;
insert into nazep_paises values('162',' Malta','activo');;
insert into nazep_paises values('163',' Marruecos','activo');;
insert into nazep_paises values('164',' Martinica ','activo');;
insert into nazep_paises values('165',' Mauricio ','activo');;
insert into nazep_paises values('166',' Mauritania','activo');;
insert into nazep_paises values('167',' Mayotte','activo');;
insert into nazep_paises values('168',' M&eacute;xico','activo');;
insert into nazep_paises values('169',' Micronesia','activo');;
insert into nazep_paises values('170',' Moldavia ','activo');;
insert into nazep_paises values('171',' M&oacute;naco ','activo');;
insert into nazep_paises values('172',' Mongolia','activo');;
insert into nazep_paises values('173',' Monte Athos','activo');;
insert into nazep_paises values('174',' Montenegro','activo');;
insert into nazep_paises values('175',' Montserrat','activo');;
insert into nazep_paises values('176',' Mozambique ','activo');;
insert into nazep_paises values('177',' Myanmar','activo');;
insert into nazep_paises values('178',' Nagorno-Karabaj ','activo');;
insert into nazep_paises values('179',' Namibia ','activo');;
insert into nazep_paises values('180',' Nauru ','activo');;
insert into nazep_paises values('181',' Nepal ','activo');;
insert into nazep_paises values('182',' Nicaragua ','activo');;
insert into nazep_paises values('183',' Niger  N&iacute;ger','activo');;
insert into nazep_paises values('184',' Nigeria ','activo');;
insert into nazep_paises values('185',' Niue','activo');;
insert into nazep_paises values('186',' Norfolk','activo');;
insert into nazep_paises values('187',' Noruega','activo');;
insert into nazep_paises values('188',' Nueva Caledonia','activo');;
insert into nazep_paises values('189',' Nueva Zelanda','activo');;
insert into nazep_paises values('190',' Om&aacute;n','activo');;
insert into nazep_paises values('191',' Osetia del Sur','activo');;
insert into nazep_paises values('192',' Pa&iacute;s de Gales ','activo');;
insert into nazep_paises values('193',' Pa&iacute;ses Bajos ','activo');;
insert into nazep_paises values('194',' Pakist&aacute;n','activo');;
insert into nazep_paises values('195',' Palaos ','activo');;
insert into nazep_paises values('196',' Palestina','activo');;
insert into nazep_paises values('197',' Panam&aacute;','activo');;
insert into nazep_paises values('198',' Pap&uacute;a Nueva Guinea ','activo');;
insert into nazep_paises values('199',' Paraguay','activo');;
insert into nazep_paises values('200',' Per&uacute; ','activo');;
insert into nazep_paises values('201',' Polinesia Francesa ','activo');;
insert into nazep_paises values('202',' Polonia','activo');;
insert into nazep_paises values('203',' Portugal ','activo');;
insert into nazep_paises values('204',' Puerto Rico','activo');;
insert into nazep_paises values('205',' Puntland','activo');;
insert into nazep_paises values('206',' Qatar ','activo');;
insert into nazep_paises values('207',' Reino Unido','activo');;
insert into nazep_paises values('208',' Rep&uacute;blica Centroafricana','activo');;
insert into nazep_paises values('209',' Rep&uacute;blica Checa','activo');;
insert into nazep_paises values('210',' Rep&uacute;blica del Congo','activo');;
insert into nazep_paises values('211',' Rep&uacute;blica Democrtica del Congo','activo');;
insert into nazep_paises values('212',' Rep&uacute;blica Dominicana','activo');;
insert into nazep_paises values('213',' Reuni&oacute;n ','activo');;
insert into nazep_paises values('214',' Ruanda ','activo');;
insert into nazep_paises values('215',' Rumania','activo');;
insert into nazep_paises values('216',' Rusia ','activo');;
insert into nazep_paises values('217',' Sahara Occidental','activo');;
insert into nazep_paises values('218',' Samoa ','activo');;
insert into nazep_paises values('219',' Samoa Americana ','activo');;
insert into nazep_paises values('220',' San Bartolom&eacute; ','activo');;
insert into nazep_paises values('221',' San Crist&oacute;bal y Nieves','activo');;
insert into nazep_paises values('222',' San Marino','activo');;
insert into nazep_paises values('223',' San Mart&iacute;n ','activo');;
insert into nazep_paises values('224',' San Pedro y Miquel&oacute;n ','activo');;
insert into nazep_paises values('225',' San Vicente y las Granadinas','activo');;
insert into nazep_paises values('226',' Santa Helena ','activo');;
insert into nazep_paises values('227',' Santa Luc&iacute;a','activo');;
insert into nazep_paises values('228',' Santo Tom&eacute; y Pr&iacute;ncipe','activo');;
insert into nazep_paises values('229',' Senegal','activo');;
insert into nazep_paises values('230',' Serbia','activo');;
insert into nazep_paises values('231',' Seychelles','activo');;
insert into nazep_paises values('232',' Sierra Leona','activo');;
insert into nazep_paises values('233',' Singapur','activo');;
insert into nazep_paises values('234',' Siria','activo');;
insert into nazep_paises values('235',' Somalia','activo');;
insert into nazep_paises values('236',' Somalilandia ','activo');;
insert into nazep_paises values('237',' Sri Lanka ','activo');;
insert into nazep_paises values('238',' Suazilandia ','activo');;
insert into nazep_paises values('239',' Sud&aacute;frica ','activo');;
insert into nazep_paises values('240',' Sud&aacute;n','activo');;
insert into nazep_paises values('241',' Suecia ','activo');;
insert into nazep_paises values('242',' Suiza','activo');;
insert into nazep_paises values('243',' Surinam ','activo');;
insert into nazep_paises values('244',' Svalbard ','activo');;
insert into nazep_paises values('245',' Tailandia ','activo');;
insert into nazep_paises values('246',' Taiw&aacute;n','activo');;
insert into nazep_paises values('247',' Tamil Eelam ','activo');;
insert into nazep_paises values('248',' Tanzania','activo');;
insert into nazep_paises values('249',' Tayikist&aacute;n','activo');;
insert into nazep_paises values('250',' Territorio Brit&aacute;nico del Oc&eacute;ano &Iacute;ndico','activo');;
insert into nazep_paises values('251',' Territorios Australes Franceses ','activo');;
insert into nazep_paises values('252',' Timor Oriental','activo');;
insert into nazep_paises values('253',' Togo ','activo');;
insert into nazep_paises values('254',' Tokelau ','activo');;
insert into nazep_paises values('255',' Tonga ','activo');;
insert into nazep_paises values('256',' Transnistria ','activo');;
insert into nazep_paises values('257',' Trinidad y Tobago ','activo');;
insert into nazep_paises values('258',' Trist&aacute;n da Cunha ','activo');;
insert into nazep_paises values('259',' T&uacute;nez ','activo');;
insert into nazep_paises values('260',' Turkmenist&aacute;n','activo');;
insert into nazep_paises values('261',' Turqu&iacute;a ','activo');;
insert into nazep_paises values('262',' Tuvalu','activo');;
insert into nazep_paises values('263',' Ucrania','activo');;
insert into nazep_paises values('264',' Uganda ','activo');;
insert into nazep_paises values('265',' Uruguay ','activo');;
insert into nazep_paises values('266',' Uzbekist&aacute;n','activo');;
insert into nazep_paises values('267',' Vanuatu','activo');;
insert into nazep_paises values('268',' Venezuela ','activo');;
insert into nazep_paises values('269',' Vietnam ','activo');;
insert into nazep_paises values('270',' Wallis y Futuna','activo');;
insert into nazep_paises values('271',' Yemen','activo');;
insert into nazep_paises values('272',' Yibuti','activo');;
insert into nazep_paises values('273',' Zambia','activo');;
insert into nazep_paises values('274',' Zimbabue','activo');;

create table nazep_modulos (
clave_modulo int auto_increment, 
nombre varchar(250) not null,
descripcion text not null,
nombre_archivo varchar(250) not null,
cadena_sql mediumtext not null,
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(20) not null,
tipo varchar(20) not null,
situacion varchar(20) not null,
constraint clave_modulo_pk
primary key(clave_modulo))ENGINE = $tipo_tablas ;;

insert into nazep_modulos values('1', 'Contenido html paginado', 'Desplegar contenido html con paginaci&oacute;n', 'contenido','sql generado en la instalacin del sistema','$fecha_hoy','$hora_hoy','$ip','central', 'activo');;
insert into nazep_modulos values('2', 'Buscador interno','Realizar busquedas en el sitio','buscador','sql generado en la instalacin del sistema' , '$fecha_hoy' , '$hora_hoy','$ip','central', 'activo');; 
insert into nazep_modulos values('3', 'Mapa del sitio','Genera un mapa del sitio automaticamente','mapa_sitio','no necesita tablas de sql','$fecha_hoy','$hora_hoy','$ip','central', 'activo');;
insert into nazep_modulos values('4', 'Baners laterales','Genera un listado de baners','baner_lateral','sql generado en la instalacin del sistema','$fecha_hoy','$hora_hoy','$ip','secundario', 'activo');;
insert into nazep_modulos values('5', 'Recomendar sitio','Recomendar el sitio a un amigo', 'recomendar', 'sql generado en la instalacin del sistema', '$fecha_hoy','$hora_hoy','$ip','central', 'activo');;
insert into nazep_modulos values('6', 'Art&iacute;culos paginados','Genera documentos de un tipo en una secci&oacute;n', 'articulos', 'sql generado en la instalacin del sistema', '$fecha_hoy','$hora_hoy','$ip','central','activo');;
insert into nazep_modulos values('7', 'Contacto','Genera un formulario para contacto con los administradores', 'contacto', 'sql generado en la instalacin del sistema', '$fecha_hoy','$hora_hoy','$ip','central','activo');;
insert into nazep_modulos values('8', 'Listar baners completos','Enlista los baners completos del m&oacute;dulo lateral', 'listado_baner_lateral', 'sql generado en la instalacin del sistema', '$fecha_hoy','$hora_hoy','$ip','central','activo');;
insert into nazep_modulos values('9', 'Listar art&iacute;culos','Lista los Ar&iacute;culos de cualquier secci&oacute;n', 'articulos_lista', 'sql generado en la instalacin del sistema', '$fecha_hoy','$hora_hoy','$ip','central','activo');;
insert into nazep_modulos values('10', 'RSS de art&iacute;culos','Lista los Ar&iacute;culos de cualquier secci&oacute;n en formato rss', 'articulos_rss', 'sql generado en la instalacin del sistema', '$fecha_hoy','$hora_hoy','$ip','central','activo');;

create table nazep_secciones (
clave_seccion int auto_increment,
clave_seccion_pertenece int null,
index(clave_seccion_pertenece),
user_creacion varchar(200) not null,
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(50) not null,
user_actualiza varchar(200) not null,
fecha_actualizacion date not null,
hora_actualizacion time not null,
ip_actualizacion varchar(50) not null,
orden int,
usar_descripcion varchar(4) not null,
descripcion text not null,
usar_keywords varchar(4) not null,
keywords text not null,
usar_vigencia varchar(4) not null, 
fecha_iniciar_vigencia date not null,
fecha_termina_vigencia date not null,
situacion varchar(20) not null,
protegida varchar(20) not null,
nombre varchar(250) not null,
titulo varchar(250) not null,
imagen_secion varchar(250) not null,
flash_secion varchar(250) not null,
ancho_medio int(3) not null,
alto_medio int(3) not null,
tipo_titulo varchar(30) not null,
tipo_contenido varchar(20) not null,
visitas int not null,
constraint clave_seccion_pk
primary key(clave_seccion),
constraint clave_seccion_pertenece_fk
foreign key(clave_seccion_pertenece)references
nazep_secciones(clave_seccion) $cadena_cascada  )ENGINE = $tipo_tablas ;;

insert into nazep_secciones values 
('1', null, 'admin', '$fecha_hoy', '$hora_hoy', '$ip','admin',  '$fecha_hoy', '$hora_hoy', '$ip', 1, 'no', 
'Secci&oacute;n ra&iacute;z del portal', 'no', 'palabra, palabra2', 'no', '$fecha_hoy', '$fecha_fin', 'activo','no', 'Inicio','Inicio','/','/',
'0','0','texto','html','0');; 

create table nazep_secciones_cambio (
clave_secciones_cambio int auto_increment,
user_propone varchar(200) not null,
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(50) not null,
motivo_cambio text not null,
clave_seccion int,
index(clave_seccion),
nuevo_clave_seccion_pertenece int,
nuevo_orden int,
nuevo_usar_descripcion varchar(4) not null,
nuevo_descripcion text,
nuevo_usar_keywords varchar(4) not null,
nuevo_keywords text not null,
nuevo_usar_vigencia varchar(4) not null,
nuevo_fecha_iniciar_vigencia date not null,
nuevo_fecha_termina_vigencia date not null,
nuevo_situacion varchar(20) not null,
nuevo_protegida varchar(20) not null,
nuevo_nombre varchar(250) not null,
nuevo_titulo varchar(250) not null,
nuevo_imagen_secion varchar(250) not null,
nuevo_flash_secion varchar(250) not null,
nuevo_ancho_medio int(3) not null,
nuevo_alto_medio int(3) not null,
nuevo_tipo_titulo varchar(30) not null,
nuevo_tipo_contenido varchar(20) not null,
anterior_clave_seccion_pertenece int,
anterior_orden int,
anterior_usar_descripcion varchar(4) not null,
anterior_descripcion text,
anterior_usar_keyword varchar(4) not null,
anterior_keywords text not null,
anterior_usar_vigencia varchar(4) not null,
anterior_fecha_iniciar_vigencia date not null,
anterior_fecha_termina_vigencia date not null,
anterior_situacion varchar(20) not null,
anterior_protegida varchar(20) not null,
anterior_nombre varchar(250) not null,
anterior_titulo varchar(250) not null,
anterior_imagen_secion varchar(250) not null,
anterior_flash_secion varchar(250) not null,
anterior_ancho_medio int(3) not null,
anterior_alto_medio int(3) not null,
anterior_tipo_titulo varchar(30) not null,
anterior_tipo_contenido varchar(20) not null,
constraint clave_secciones_cambio_pk
primary key(clave_secciones_cambio),
constraint clave_seccion_sec_cambio_fk
foreign key(clave_seccion)references
nazep_secciones(clave_seccion) $cadena_cascada )ENGINE = $tipo_tablas ;;

create table nazep_secciones_modulos (
clave_secciones_modulos int auto_increment,
clave_seccion int,
index(clave_seccion),
clave_modulo int,
index(clave_modulo),
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(50) not null,
fecha_actualizacion date not null,
hora_actualizacion time not null,
ip_actualizacion varchar(50) not null,
posicion varchar(20) not null,
orden int not null,
situacion varchar(20) not null,
usar_vigencia_mod varchar(4) not null,
fecha_inicio date not null,
fecha_fin date not null,
persistencia varchar(10) null,
constraint clave_secciones_modulos_pk
primary key(clave_secciones_modulos),
constraint clave_seccion_sec_modulo_fk
foreign key(clave_seccion)references
nazep_secciones(clave_seccion) $cadena_cascada,
constraint clave_modulo_sec_modulo_fk
foreign key(clave_modulo)references
nazep_modulos(clave_modulo) $cadena_cascada )ENGINE = $tipo_tablas ;;

insert into nazep_secciones_modulos values ('1', '1', '1','$fecha_hoy', '$hora_hoy','$ip', '$fecha_hoy', '$hora_hoy','$ip', 'centro','1','activo', 'si', '$fecha_hoy', '$fecha_fin', 'no');;

create table nazep_secciones_modulos_cambio (
clave_secciones_modulos_cambio int auto_increment,
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(50) not null,
motivo_cambio text not null,
clave_secciones_modulos int,
index(clave_secciones_modulos),
nuevo_posicion varchar(20),
nuevo_orden int,
nuevo_situacion varchar(20),
nuevo_usar_vigencia varchar(4),
nuevo_fecha_inicio date not null,
nuevo_fecha_fin date not null,
nuevo_persistencia varchar(10) null,
anterior_posicion varchar(20),
anterior_orden int,
anterior_situacion varchar(20),
anterior_usar_vigencia varchar(4),
anterior_fecha_inicio date not null,
anterior_fecha_fin date not null,
anterior_persistencia varchar(10) not null,
constraint clave_secciones_modulos_cambio_pk
primary key(clave_secciones_modulos_cambio),
constraint clave_secciones_modulos_s_m_c_fk
foreign key(clave_secciones_modulos)references
nazep_secciones_modulos(clave_secciones_modulos) $cadena_cascada )ENGINE = $tipo_tablas ;;

create table nazep_usuarios_final (
nick_usuario varchar(250) not null,
fecha_alta date not null,
hora_alta time not null,
pasword text not null,
nombre varchar(250) not null,
a_pat varchar(250) not null,
a_mat varchar(250) not null,
situacion varchar(20) not null,
correo varchar(250) not null,
fecha_nacimiento date not null,
ubicacion varchar(250) not null,
ip_alta varchar(250) not null,
web varchar(250) not null,
ver_nombre varchar(10) not null,
ver_mail varchar(10) not null,
ver_ubic varchar(10) not null,
ver_web varchar(10) not null,
zona_horario varchar(10) not null,
codigo_seguridad varchar(250) not null,
fecha_ultima_visita date not null,
constraint nick_usaurio_pk
primary key(nick_usuario))ENGINE = $tipo_tablas ;;

create table nazep_usuarios_final_config (
clave_user_final_config int auto_increment not null,
nombre_campo varchar(250),
valor_campo text not null,
constraint clave_user_final_config_pk
primary key(clave_user_final_config))ENGINE = $tipo_tablas ;;

insert into nazep_usuarios_final_config 
(clave_user_final_config,nombre_campo,valor_campo)
values
(1,'mostrar_registro_publico','si'),
(2,'mostrar_recuperar_password','si'),
(3,'enviar_codigo_activacion','no'),
(4,'usar_captcha_google','si'),
(5,'usar_correo_como_usuario','no'),
(6,'pedir_nombre','no'),
(7,'pedir_ape_p','no'),
(8,'pedir_ape_m','no'),
(9,'pedir_fecha_nacimiento','no'),
(10,'pedir_ubicacion','no'),
(11,'pedir_web','no'),
(12,'pedir_zona_horaria','no');;


create table nazep_sesiones (
nick_usuario varchar(250) not null,
hora varchar(250) not null,
ip varchar(50) not null)ENGINE = $tipo_tablas ;;

create table nazep_usuarios_admon (
nick_user varchar(200) not null,
pasword text not null,
nombre varchar(250) not null,
email varchar(250) not null,
direccion text not null,
nivel int not null,
situacion varchar(20) not null,
fecha_creacion date  not null,
hora_creacion time not null,
ip_creacion varchar(50) not null,
fecha_actualizacion date not null,
hora_actualizacion time not null,
ip_actualizacion varchar(50) not null,
constraint nick_user_pk
primary key(nick_user))ENGINE = $tipo_tablas ;;

insert into nazep_usuarios_admon values ('admin','','Administrador de Nazep', 'correo@sitio.com', 'Conocida', '1', 'cancelado','$fecha_hoy', '$hora_hoy','$ip','$fecha_hoy', '$hora_hoy','$ip');;

create table nazep_registro_acceso (
clave_acceso int auto_increment,
nick_user varchar(200) not null,
ip_acceso varchar(50) not null,
fecha_intento date not null,
hora_unix bigint not null,
hora_intento time not null,
estado_intento varchar(10) not null,
tipo_intento varchar(20) not null,
constraint clave_acceso_pk 
primary key(clave_acceso))ENGINE = $tipo_tablas ;;

create table nazep_usuarios_secciones_admon (
clave_secciones_usuario_admon int auto_increment,
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(50) not null,
nick_user varchar(200),
index(nick_user),
clave_seccion int,
index(clave_seccion),
situacion varchar(20) not null,
constraint clave_secciones_usuario_admon_pk
primary key(clave_secciones_usuario_admon),
constraint clave_seccion_secciones_fk
foreign key(clave_seccion) references
nazep_secciones(clave_seccion) $cadena_cascada,
constraint nick_user_use_secc_fk
foreign key(nick_user)references
nazep_usuarios_admon(nick_user) $cadena_cascada)ENGINE = $tipo_tablas ;;

insert into nazep_usuarios_secciones_admon values ('1','$fecha_hoy', '$hora_hoy','$ip', 'admin','1','activo');;

create table nazep_v_visitas_simple (
clave_visita bigint auto_increment,
clave_seccion int,
index(clave_seccion),
fecha date not null,
visita bigint not null,
constraint clave_visita_pk
primary key(clave_visita),
constraint clave_seccion_visita_fk
foreign key(clave_seccion)references
nazep_secciones (clave_seccion) $cadena_cascada)ENGINE = $tipo_tablas ;;

create table nazep_temas (
clave_tema int auto_increment,
nombre varchar(250) not null,
ubicacion varchar(250) not null,
descripcion text not null,
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(20) not null,
situacion varchar(20) not null,
constraint clave_tema_pk
primary key(clave_tema))ENGINE = $tipo_tablas ;;

insert into nazep_temas values ('1', 'Nazep', 'nazep', 'Tema de Nazep','$fecha_hoy', '$hora_hoy','$ip','activo');;
insert into nazep_temas values ('2', 'Nazep 2', 'nazep2', 'Tema de Nazep alterno','$fecha_hoy', '$hora_hoy','$ip','activo');;
insert into nazep_temas values ('3', 'Nazep 2 Div', 'nazep2div', 'Tema de Nazep alterno que usa divs','$fecha_hoy', '$hora_hoy','$ip','activo');;

create table nazep_configuracion (
nombre_sitio text not null,
url_sitio varchar(250) not null,
lema  text not null,
pie_sitio text not null,
fecha_incio date not null,
clave_tema int,
index(clave_tema),
titu_sitio text not null,
envio_correo varchar(20) not null,
servidor_smtp varchar(250) not null,
user_smtp varchar(250) not null,
pass_smtp varchar(250) not null,
lenguaje varchar(10) not null,
clave_buscador int null,
clave_mapa_sitio int null,
clave_recomendar int null,
clave_contacto int null,
clave_rss int null,
version varchar(10) null,
instalado varchar(4) null,
palabras_clave text not null,
mensaje_nuevo_usuario_admon text,
mensaje_nuevo_usuario_vista text,
ver_noticias varchar(20) not null,
cant_noticias_admon int not null,
tipo_tablas varchar(30) not null,
resolucion_ancho varchar(10) not null,
ver_pag_inicio varchar(5) not null,
pag_inicio text not null,
usar_captcha_google varchar(10),
llave_publica_captcha varchar(255),
llave_privada_captcha varchar(255),
con_no_disponible text not null
)ENGINE = $tipo_tablas ;;

insert into nazep_configuracion values ('Sitio creado por nazep', 
'http://www.misitio.com', 'Lema del sitio','Pie del sitio',
'$fecha_hoy','1','Sitio nuevo','php','mail.smtp','user','pasword',
'es','1','1','1','1','1','0.2','no','palabra1, palabra2',
'Este es el usuario de administraci&oacute;n para el sistema nazep',
'Este es el usuario de vista para el sitio', 
'si','5','$tipo_tablas','777','no','','no','','','Contenido no disponible');;

create table nazep_zmod_recomendar (
clave_recomendar int auto_increment,
clave_seccion int,
index(clave_seccion),
fecha date not null,
hora time not null,
ip varchar(20),
enlace varchar(250) not null,
nombre_envia varchar(250) not null,
correo_envia varchar(250) not null,
nombre_recibe varchar(250) not null,
correo_recibe varchar(250) not null,
comentario text,
constraint clave_recomendar_pk
primary key(clave_recomendar))ENGINE = $tipo_tablas ;;

create table nazep_zmod_recomendar_conf (
user_actualiza varchar(200) not null,
ip_actualiza varchar(20) not null,
fecha_actualiza date not null,
hora_acutaliza time not null,
asunto varchar(250) not null,
introduccion varchar(250) not null,
mensaje text not null,
despedida text not null,
ancho_nom1 int not null,
ancho_cor1 int not null,
ancho_nom2 int not null,
ancho_cor2 int not null,
ancho_mens int not null,
alto_mens int not null)ENGINE = $tipo_tablas ;;	

insert into nazep_zmod_recomendar_conf values('admin','000.000.000.000','0000-00-00', '00:00:00','
Recomendando un sitio','Hola que tal.','Se recomienda visitar el siguiente enlace', 'Sin mas quedo a tus ordenes',
'20','20','20','20','40','5');;

create table nazep_zmod_contenido (
clave_contenido  int auto_increment,
clave_seccion int not null,
index(clave_seccion),
clave_modulo int not null,
index (clave_modulo),
situacion varchar(20) not null,
ver_actualizacion varchar(20) not null,
usar_caducidad varchar(20)not null,
fecha_incio date not null,
fecha_fin date not null,
user_creacion varchar(200) not null,
index(user_creacion),
fecha_creacion date not null,
hora_creacion time not null,
ip_creacion varchar(50) not null,
user_actualizacion varchar(200) not null,
index(user_actualizacion),
fecha_actualizacion date not null,
hora_actualizacion time not null,
ip_actualizacion varchar(50) not null,
nombre_actualizacion varchar(250) not null,
correo_actualizacion varchar(250) not null,
constraint clave_contenido_pk
primary key(clave_contenido),
constraint clave_seccion_m_contenido_fk
foreign key(clave_seccion)references
nazep_secciones(clave_seccion) $cadena_cascada,
constraint user_creacion_m_contenido_fk
foreign key(user_creacion)references
nazep_usuarios_admon(nick_user) $cadena_cascada,
constraint user_actualizacion_m_contenido_fk
foreign key(user_actualizacion)references
nazep_usuarios_admon(nick_user) $cadena_cascada)ENGINE = $tipo_tablas ;;

create table nazep_zmod_contenido_cambios (
clave_contenido_cambios int auto_increment,
clave_contenido int, 
index(clave_contenido),
situacion varchar(20) not null,
nick_user_propone varchar(200) not null,
fecha_propone date not null,
hora_propone time not null,
ip_propone varchar(50) not null,
motivo_propone text not null,
nombre_propone varchar(250) not null,
correo_propone varchar(250) not null,
nick_user_decide varchar(200)null,
fecha_decide date not null,
hora_decide time not null,
ip_decide varchar(50) not null,
motivo_decide text not null,
nombre_decide varchar(250) not null,
correo_decide varchar(250) not null,
nuevo_situacion varchar(20) not null,
nuevo_ver_actualizacion varchar(20) not null,
nuevo_usar_caducidad varchar(20) not null,
nuevo_fecha_incio date not null,
nuevo_fecha_fin date not null,
anterior_situacion varchar(20) not null,
anterior_ver_actualizacion varchar(20) not null,
anterior_usar_caducidad varchar(20) not null,
anterior_fecha_incio date not null,
anterior_fecha_fin date not null,
constraint clave_contenido_cambios_pk
primary key(clave_contenido_cambios),
constraint clave_contenido_m_con_cam_fk
foreign key(clave_contenido)references
nazep_zmod_contenido(clave_contenido) $cadena_cascada )ENGINE = $tipo_tablas ;;

create table nazep_zmod_contenido_detalle (
clave_contenido_detalle int auto_increment,
clave_contenido int, 
index(clave_contenido),
pagina int not null,
texto mediumtext not null,
situacion varchar(20) not null,
constraint clave_contenido_detalle_pk
primary key(clave_contenido_detalle),
constraint clave_contenido_detalle_fk
foreign key(clave_contenido)references
nazep_zmod_contenido(clave_contenido) $cadena_cascada)ENGINE = $tipo_tablas ;;

create table nazep_zmod_contenido_detalle_cambios (
clave_contenido_detalle_cambios int auto_increment,
clave_contenido_cambios int,
index(clave_contenido_cambios),
clave_contenido_detalle int,
index(clave_contenido_detalle),
nuevo_pagina int,
nuevo_texto mediumtext not null,
nuevo_situacion varchar(20) not null,
anterior_pagina int,
anterior_texto mediumtext not null,
anterior_situacion varchar(20) not null,
constraint clave_contenido_detalle_cambios_pk
primary key(clave_contenido_detalle_cambios),
constraint clave_contenido_cambios_mcdc_fk
foreign key(clave_contenido_cambios)references
nazep_zmod_contenido_cambios (clave_contenido_cambios) $cadena_cascada,
constraint clave_contenido_detalle_mcdc_fk
foreign key(clave_contenido_detalle)references
nazep_zmod_contenido_detalle(clave_contenido_detalle) $cadena_cascada )ENGINE = $tipo_tablas ;;

create table nazep_zmod_baner_configuracion (
clave_baner_configuracion int auto_increment,
clave_modulo int,								
clave_seccion int,
index(clave_seccion),
nombre_baners varchar(250) not null,
cantidad_mostrar int not null,
texto_titulo varchar(250) not null,
ver_texto_titulo varchar(20) not null,
imagen_titulo text not null,
ver_imagen_titulo varchar(20) not null,
texto_ver_mas varchar(250) not null,
ver_texto_ver_mas varchar(20) not null,
imagen_ver_mas varchar(250) not null,
ver_imagen_ver_mas varchar(20) not null,
seccion_ver_mas int,
ubicacion_imagen_balazo text not null,
ver_imagen_balazo varchar(20) not null,
texto_balazo varchar(10) not null,
ver_texto_balazo varchar(20) not null,
alin_balazo varchar(50) not null,
color_fondo_lateral varchar(20) not null,
constraint clave_baner_configuracion_pk
primary key(clave_baner_configuracion))ENGINE = $tipo_tablas ;;

create table nazep_zmod_baner (
clave_baner int auto_increment,
clave_baner_configuracion int,
index(clave_baner_configuracion),
situacion varchar(20) not null,
fecha_inicio date not null,
fecha_fin date not null,
user_creacion varchar(200),
index(user_creacion),
ip_creacion varchar(50),
fecha_creacion date,
hora_creacion time,
user_actualizacion varchar(200),
index(user_actualizacion),
ip_actualizacion varchar(50),
fecha_actualizacion date,
hora_actualizacion time,
nombre text not null,
orden int not null,
descripcion text not null,
enlace text not null,
constraint clave_baner_pk
primary key(clave_baner),
constraint clave_baner_configuracion_fk
foreign key(clave_baner_configuracion)references
nazep_zmod_baner_configuracion(clave_baner_configuracion) $cadena_cascada,
constraint user_creacion_enlaces_fk
foreign key(user_creacion)references
nazep_usuarios_admon(nick_user) $cadena_cascada,
constraint user_actualizacion_enlaces_fk
foreign key(user_actualizacion)references
nazep_usuarios_admon(nick_user) $cadena_cascada )ENGINE = $tipo_tablas ;;

create table nazep_zmod_baner_cambios (
clave_baners_cambios int auto_increment,
clave_baner int,
index(clave_baner),
situacion varchar(20) not null,
nick_user_propone varchar(200),
index(nick_user_propone),
ip_propone varchar(100),
fecha_propone date,
hora_propone time,
motivo_propone text not null,
nombre_propone varchar(250) not null,
correo_propone varchar(250) not null,
nick_user_decide varchar(200),
index(nick_user_decide),
ip_decide varchar(100),
fecha_decide date,
hora_decide time,
motivo_decide text not null,
nombre_decide varchar(250) not null,
correo_decide varchar(250) not null,
nuevo_nombre text not null,
nuevo_orden int not null,
nuevo_situacion varchar(20) not null,
nuevo_descripcion text not null,
nuevo_enlace text not null,
nuevo_fecha_inicio date not null,
nuevo_fecha_fin date not null,
anterior_nombre text not null,
anterior_orden int not null,
anterior_situacion varchar(20) not null,
anterior_descripcion text not null,
anterior_enlace text not null,
anterior_fecha_inicio date not null,
anterior_fecha_fin date not null,
constraint clave_baners_cambios_pk
primary key(clave_baners_cambios),
constraint clave_baner_enlaces_cambios_fk 
foreign key(clave_baner)references
nazep_zmod_baner(clave_baner) $cadena_cascada )ENGINE = $tipo_tablas ;;

create table nazep_zmod_buscador (
clave_buscador int auto_increment,
situacion varchar(20) not null,
fecha_inicio date not null,
fecha_fin date not null,
user_creacion varchar(200),
index(user_creacion),
ip_creacion varchar(50),
fecha_creacion date,
hora_creacion time,
user_actualizacion varchar(200),
index(user_actualizacion),
ip_actualizacion varchar(50),
fecha_actualizacion date,
hora_actualizacion time,
clave_modulo int not null,
index(clave_modulo),
constraint clave_buscador_pk
primary key(clave_buscador),
constraint clave_modulo_buscador_fk
foreign key(clave_modulo)references
nazep_modulos(clave_modulo) $cadena_cascada,
constraint user_creacion_buscador_fk
foreign key(user_creacion)references
nazep_usuarios_admon(nick_user) $cadena_cascada,
constraint user_actualizacion_buscador_fk
foreign key(user_actualizacion)references
nazep_usuarios_admon(nick_user) $cadena_cascada )ENGINE = $tipo_tablas ;;

insert into nazep_zmod_buscador values
('1','activo', '$fecha_hoy', '$fecha_fin','admin', '$ip', '$fecha_hoy', '$hora_hoy', 'admin', '$ip', '$fecha_hoy','$hora_hoy','1');;

create table nazep_zmod_buscador_cambios (
clave_buscador_cambios int auto_increment,
clave_buscador int,
index(clave_buscador),
situacion varchar(20) not null,
nick_user_propone varchar(200),
index(nick_user_propone),
ip_propone varchar(100),
fecha_propone date,
hora_propone time,
motivo_propone text not null,
nombre_propone varchar(250) not null,
correo_propone varchar(250) not null,
nick_user_decide varchar(200),
index(nick_user_decide),
ip_decide varchar(100),
fecha_decide date,
hora_decide time,
motivo_decide text not null,
nombre_decide varchar(250) not null,
correo_decide varchar(250) not null,
nuevo_situacion varchar(20) not null,
nuevo_fecha_inicio date not null,
nuevo_fecha_fin date not null,
anterior_situacion varchar(20) not null,
anterior_fecha_inicio date not null,
anterior_fecha_fin date not null,
constraint clave_buscador_cambios_pk
primary key(clave_buscador_cambios),
constraint clave_buscador_fk
foreign key(clave_buscador)references
nazep_zmod_buscador(clave_buscador) $cadena_cascada )ENGINE = $tipo_tablas ;;	

create table nazep_noticias_admo (
clave_noticia_admon int auto_increment,
nick_user_crea varchar(200) not null,
fecha_noticia date not null,
hora_noticia time not null,
ip_creacion varchar(20) not null,
situacion varchar(100) not null,
titulo text not null,
resumen text not null,
cuerpo mediumtext not null,
visitas int not null,
constraint clave_noticia_admon_pk
primary key(clave_noticia_admon))ENGINE = $tipo_tablas ;;

insert into nazep_noticias_admo values ('1','admin',
'$fecha_hoy','$hora_hoy','$ip','activo','Primera noticia',
'Es la primera noticia generada por el Administrador de Contenidos Web Nazep',
'El grupo creador del Nazep le agradece la preferencia',
'0');;
								
create table nazep_zmod_articulos_lista (
clave_articulo_lista int auto_increment,
clave_modulo int,
index(clave_modulo),
clave_seccion int,
index(clave_seccion),
clave_seccion_enlazar int,
index(clave_seccion_enlazar),
nombre_articulos varchar(250) not null,
ver_nombre varchar(20) not null,
orden_nombre int not null,
lado_nombre varchar(50) not null,
enlace_nombre varchar(20) not null,
nom_por_col1 int not null,
nom_por_col2 int not null,
ver_enlace_ver varchar(20) not null,
lado_enalce_ver varchar(50) not null,
cantidad_listar int not null,
enl_por_col1 int not null,
enl_por_col2 int not null,
ver_titulo varchar(20) not null,
orden_titulo int not null,
lado_titulo varchar(50) not null,
tit_por_col1 int not null,
tit_por_col2 int not null,
ver_numero varchar(20) not null,
orden_numero int not null,
lado_numero varchar(50) not null,
num_por_col1 int not null,
num_por_col2 int not null,
ver_lugar varchar(20) not null,
ver_fecha varchar(20) not null,
orden_lugar_fecha int not null,
lado_lugar_fecha varchar(50) not null,
lug_por_col1 int not null,
lug_por_col2 int not null,
ver_resumen_chico varchar(20) null,
orden_resumen_chico int not null,
resc_por_col1 int not null,
resc_por_col2 int not null,
ver_resumen_grande varchar(20) not null,
orden_resumen_graden int not null,
resg_por_col1 int not null,
resg_por_col2 int not null,
constraint clave_articulo_lista_pk
primary key(clave_articulo_lista))ENGINE = $tipo_tablas ;;

create table nazep_zmod_articulos_temas (
clave_tema int auto_increment,
clave_tipo int not null,
situacion varchar(10) not null,
nombre varchar(250) not null,
descripcion text not null,
constraint clave_tema_pk
primary key(clave_tema))ENGINE = $tipo_tablas ;;

create table nazep_zmod_articulos_tipos (
clave_tipo int auto_increment,
clave_seccion int,
index(clave_seccion),
situacion varchar(20) not null,
nombre varchar(250) not null,
descripcion text not null,
permitir_ver_visitas varchar(10) not null,
permitir_calificar varchar(10) not null,
permitir_comentarios varchar(10) not null,
permitir_ver_cuerpo varchar(10),
permitir_caducar varchar(10),
permitir_ver_numero varchar(10),
per_ver_fec_actualiza varchar(10),
cantidad_art_mostrar int(3) not null,
tipo_resumen_ver varchar(30) not null,
formato_fecha_lista varchar(100) not null,
formato_fecha_cuerpo varchar(100) not null,
user_creacion varchar(200) not null,
ip_creacion varchar(50) not null,
fecha_creacion date not null,
hora_creacion time not null,
user_actualiza varchar(200)null,
ip_actualizacion varchar(20) not null,
fecha_actualizacion date not null,
hora_actualizacion time not null,
ver_buscador varchar(10) not null,
usar_tema varchar(10) not null,
posicion_titulo_lista int(2) not null,
posicion_titulo_cuerpo int(2) not null,
posicion_tema_lista int(2) not null,
posicion_tema_cuerpo int(2) not null,
posicion_numero_lista int(2) not null,
posicion_numero_cuerpo int(2) not null,
posicion_fecha_lugar_lista int(2) not null,
posicion_fecha_lugar_cuerpo int(2) not null,
posicion_resumen_lista int(2) not null,
posicion_resumen_cuerpo int(2) not null,
posicion_cuerpo int(2) not null,
posicion_visitas_lista int(2) not null,
posicion_visitas_cuerpo int(2) not null,
posicion_fe_act_lista int(2) not null,
posicion_fe_act_cuerpo int(2) not null,
permitir_ver_resumen_cuerpo varchar(10) not null,
per_ver_fec_actualiza_lista varchar(10) not null,
ver_lugar_lista varchar(10) not null,
ver_lugar_cuerpo varchar(10) not null,
tipo_separacion_lista varchar(10) not null,
permitir_comentarios_lista varchar(10) not null,
permitir_ver_visitas_lista varchar(10) not null,
moderar_comentarios varchar(10) not null,
permitir_ver_numero_lista varchar(10) not null,
partes_enlace_cuerpo varchar(250) not null,
permitir_ver_temas_lista varchar(10) not null,
permitir_ver_temas_cuerpo varchar(10) not null,
ver_fecha_lista varchar(10) not null,
ver_hora_lista varchar(10) not null,
ver_fecha_cuerpo varchar(10) not null, 
ver_hora_cuerpo varchar(10) not null,
posicion_buscador varchar(10) not null,
constraint clave_tipo_art_pk
primary key(clave_tipo))ENGINE = $tipo_tablas ;;

create table nazep_zmod_articulos (
clave_articulo int auto_increment,
clave_tipo int,
index(clave_tipo),
situacion varchar(20) not null,
user_creacion varchar(200) not null,
nombre_creacion varchar(250) not null,
correo_creacion varchar(250) not null,
ip_creacion varchar(50) not null,
fecha_creacion date not null,
hora_creacion time not null,
user_actualiza varchar(200)null,
nombre_actualiza varchar(250) not null,
correo_actualiza varchar(250) not null,
ip_actualizacion varchar(20) not null,
fecha_actualizacion date not null,
hora_actualizacion time not null,
fecha_inicio date not null,
fecha_fin date not null,
fecha_articulo date not null,
lugar_articulo varchar(250) not null,
titulo text not null,
numero_articulo int not null,
resumen_chico text not null,
resumen_grande text not null,
visitas int not null,
cantidad_votos int not null,
votos int not null,
clave_tema int null,
constraint clave_articulo_pk
primary key(clave_articulo))ENGINE = $tipo_tablas ;;

create table nazep_zmod_articulos_cambios (
clave_articulo_cambios int auto_increment,
clave_articulo int,
index(clave_articulo),
situacion varchar(20) not null,
user_propone varchar(200) not null,
nombre_propone varchar(250) not null,
correo_propone varchar(250) not null,
motivo_propone text not null,
fecha_propone date not null,
hora_propone time not null,
ip_poropone varchar(20),
user_decide varchar(200)null,
nombre_decide varchar(250) not null,
correo_decide varchar(250) not null,
motivo_decide text not null,
fecha_decide date not null,
hora_decide time not null,
ip_decide varchar(20),
nuevo_situacion varchar(20) not null,
nuevo_fecha_inicio date not null,
nuevo_fecha_fin date not null,
nuevo_fecha_articulo date not null,
nuevo_lugar_articulo varchar(250) not null,
nuevo_titulo text not null,
nuevo_numero_articulo int not null,
nuevo_resumen_chico text not null,
nuevo_resumen_grande text not null,
nuevo_clave_tema int null,
anterior_situacion varchar(20) not null,
anterior_fecha_inicio date not null,
anterior_fecha_fin date not null,
anterior_fecha_articulo date not null,
anterior_lugar_articulo varchar(250) not null,
anterior_titulo text not null,
anterior_numero_articulo int not null,
anterior_resumen_chico text not null,
anterior_resumen_grande text not null,
anterior_clave_tema int null,
constraint clave_articulo_cambios_pk
primary key(clave_articulo_cambios))ENGINE = $tipo_tablas ;;

create table nazep_zmod_articulos_paginas (
clave_articulo_pagina int auto_increment,
clave_articulo int,
index(clave_articulo),
situacion varchar(20) not null,
pagina int not null,
texto mediumtext,
constraint clave_articulo_pagina_pk
primary key(clave_articulo_pagina))ENGINE = $tipo_tablas ;;

create table nazep_zmod_articulos_paginas_cambios (
clave_articulos_paginas_cambios int auto_increment,
clave_articulo_cambios int,
index(clave_articulo_cambios),
clave_articulo_pagina int,
index(clave_articulo_pagina),
nuevo_situacion varchar(20) not null,
nuevo_pagina int not null,
nuevo_texto mediumtext,
anterior_situacion varchar(20) not null,
anterior_pagina int not null,
anterior_texto mediumtext,
constraint clave_articulos_paginas_cambios_pk
primary key(clave_articulos_paginas_cambios))ENGINE = $tipo_tablas ;;

create table nazep_zmod_articulos_comentarios (
clave_comentario_art int auto_increment,
clave_articulo int,
index(clave_articulo),
situacion varchar(100) not null,
fecha date not null,
hora time not null,
ip varchar(20) not null,
nick_usuario varchar(250) not null,
nombre varchar(250) not null,
correo varchar(250) not null,
web    varchar(250) not null,
comentario text not null,
leido varchar(5) not null,
constraint clave_comentario_art_pk
primary key(clave_comentario_art))ENGINE = $tipo_tablas ;;	

create table nazep_zmod_articulos_votos(
clave_voto_art int auto_increment,
clave_articulo int,
index(clave_articulo),
voto int not null,
ip varchar(20) not null,
fecha date not null,
hora time not null,
constraint clave_voto_art_pk
primary key(clave_voto_art))ENGINE = $tipo_tablas ;;	

create table nazep_zmod_contacto_configuracion (
enviar_correo varchar(20) not null,
correo_recibe varchar(250) not null,
nombre_recibe varchar(250) not null,
texto_contestacion text not null,
pedir_tema varchar(5) not null,
pedir_nombre_compuesto varchar(5) not null,
pedir_nombre_largo varchar(5) not null,
pedir_correo varchar(5) not null,
pedir_sitio_web varchar(5) not null,
pedir_telefono varchar(5) not null,
pedir_fax varchar(5) not null,
pedir_direccion varchar(5) not null,
pedir_pais varchar(5) not null,
pedir_mensaje varchar(5) not null,
obligar_nombre_compuesto varchar(5) not null,
obligar_nombre_largo varchar(5) not null,
obligar_correo varchar(5) not null,
obligar_sitio_web varchar(5) not null,
obligar_telefono varchar(5) not null,
obligar_fax varchar(5) not null,
obligar_direccion varchar(5) not null,
obligar_mensaje varchar(5) not null,
pais_defecto int not null)ENGINE = $tipo_tablas ;;
 
insert into nazep_zmod_contacto_configuracion values('no','correo@sitio.com.mx','Nombre Recibe','Gracias por enviarnos su comentario',
'si','si','si','si','si','si','si','si','si','si','si','si','si','si','si','si','si','si','1');;
								
create table nazep_zmod_contacto_temas (
clave_contacto_tema int auto_increment,
nombre varchar(250) not null,
descripcion text not null,
situacion varchar(20) not null,
user_creacion varchar(200) not null,
ip_creacion varchar(50) not null,
fecha_creacion date not null,
hora_creacion time not null,
user_actualiza varchar(200)null,
ip_actualizacion varchar(20) not null,
fecha_actualizacion date not null,
hora_actualizacion time not null,
constraint clave_contacto_tema_pk
primary key(clave_contacto_tema))ENGINE = $tipo_tablas ;;

insert into nazep_zmod_contacto_temas values('1','Informes','Para solicitar informaci&oacute;n acerca del portal','activo',
'admin','$ip','$fecha_hoy', '$hora_hoy','admin','$ip','$fecha_hoy', '$hora_hoy');;

create table nazep_zmod_contacto (
clave_contacto int auto_increment,
fecha date not null,
hora time not null,
ip varchar(50) not null,
clave_contacto_tema int default '1',
index(clave_contacto_tema),
nombre varchar(250) null,
ap_pat varchar(250) null,
ap_mat varchar(250) null,
nombre_completo text null,
correo_electronico varchar(250)null,
sitio_web varchar(250)null,
telefono varchar(250)null,
fax varchar(250)null,
direccion text null,
clave_pais int not null default '1', 
index(clave_pais),
mensaje text null,
fecha_acciones date not null,
hora_acciones time not null,
ip_acciones varchar(20) not null,
user_acciones varchar(200) not null,
ver_acciones varchar(10) not null,
acciones_tomadas text not null,
contestado varchar(10) not null,
texto_contestacion text not null,
fecha_contestacion date not null,
hora_contestacion time not null,
ip_contestacion varchar(20) not null,
user_contestacion varchar(200) not null,
constraint clave_contacto_pk
primary key(clave_contacto)) ENGINE = $tipo_tablas;;

create table nazep_zmod_articulos_rss (
clave_articulo_rss int auto_increment,
clave_modulo int not null,
clave_seccion int not null,
index(clave_seccion),
clave_seccion_enlazar int not null,
nombre_rss varchar(250) not null,
enlace_rss varchar(250) not null,
lenguaje varchar(50) not null,
descripcion varchar(250) not null,
cantidad_mostrar int not null,
permitir_ver_comentarios varchar(10) not null,
ver_autor varchar(10) not null,
tipo_autor_ver varchar(30) not null,
usar_tema varchar(10) not null,
tipo_resumen_ver varchar(30) not null,
permitir_caducar varchar(10) not null,
user_creacion varchar(200) not null,
ip_creacion varchar(50) not null,
fecha_creacion date not null,
hora_creacion time not null,
user_actualizacion varchar(200) not null,
ip_actualizacion varchar(50) not null,
fecha_actualizacion date not null,
hora_actualizacion time not null,
constraint clave_articulo_rss_pk
primary key(clave_articulo_rss)) ENGINE = $tipo_tablas";


							$arreglo_query = explode(";;", $sql_instalar);
							$cantidad = count($arreglo_query);
							$paso = false;
							$conexion = conectarse();
							for($a=0; $a<$cantidad; $a++)
								{
									$con_temporal = $arreglo_query[$a];
									if (!@mysql_query($con_temporal))
										{
											$men = mysql_error();
											$division = $a;
											$consulta = $con_temporal;	
											$paso = false;
											$a=$cantidad+2;
										}
									else
										{ $paso = true; }
								}
							if($paso == true)
								{
									echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td align ="center">La creaci&oacute;n de las tablas ha sido exitosa.</td></tr></table><br /><br />';
									echo '<form name="pasar_paso2" method="post" action="instalar.php" >';	
										echo '<table width="500" border="0" cellspacing="0" cellpadding="0" >';
											echo '<tr>';
												echo '<td align = "center"><input type="hidden" name="paso" value = "3" /><input type="submit" name="btn_guardar" value="Configuraci&oacute;n de Nazep" /></td>';
											 echo '</tr>';	
										echo '</table>';
									echo '</form>';
								}
							else
								{
									$error = borrar_tablas();
									echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td align = "center">Ocurrio un problema al de crear las tablas</td></tr><tr><td align = "center">'."$men-<br /><br />$division-<br /><br />-$consulta - ".'</td></tr></table>';
								}
						}
					elseif($paso=="3")
						{
							$conexion = conectarse();
							$consulta1 = " select nombre_sitio, url_sitio, lema, pie_sitio, titu_sitio, palabras_clave, mensaje_nuevo_usuario_admon, mensaje_nuevo_usuario_vista, resolucion_ancho from nazep_configuracion";
							$res_con1 = mysql_query($consulta1);
							$ren_con1 = mysql_fetch_array($res_con1);
							$nombre_sitio = $ren_con1["nombre_sitio"];
							$url_sitio = $ren_con1["url_sitio"];
							$lema = $ren_con1["lema"];
							$pie_sitio = $ren_con1["pie_sitio"];
							$titu_sitio = $ren_con1["titu_sitio"];
							$palabras_clave =  $ren_con1["palabras_clave"];
							$mensaje_nuevo_usuario_admon = $ren_con1["mensaje_nuevo_usuario_admon"];
							$mensaje_nuevo_usuario_vista = $ren_con1["mensaje_nuevo_usuario_vista"];
							$resolucion_ancho = $ren_con1["resolucion_ancho"];
							$consulta2 = " select nombre, email, direccion from nazep_usuarios_admon where nick_user = 'admin'";
							$res_con2 = mysql_query($consulta2);
							$ren_con2 = mysql_fetch_array($res_con2);							
							$nombre_usuario = $ren_con2["nombre"];
							$correo_electronico = $ren_con2["email"];;
							$direccion = $ren_con2["direccion"];
							echo '<script type="text/javascript">';
							echo '
									function validar_form(formulario)
										{
											if(formulario.pasword1.value == "") 
												{
													alert("El campo Password no puede quedar vac\u00ED o");
													formulario.pasword1.focus();
													return false;
												}
											if(formulario.pasword2.value == "") 
												{
													alert("El campo Repetir Password no puede quedar vac\u00ED o");
													formulario.pasword2.focus();
													return false;
												}
											if(formulario.pasword1.value != formulario.pasword2.value) 
												{
													alert("Los campos de Contrase\u00D1a son diferentes, ingresar datos iguales")
													formulario.pasword1.focus();
													return false
												}
											formulario.submit();
										}
								';
							echo '</script>';
							echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td align = "center">Configuraci&oacute;n general</td></tr></table><br />';	
							echo '<form name="pasar_paso2" method="post" action="instalar.php">';
								echo '<table width="500" border="0" cellspacing="0" cellpadding="0">';
									echo '<tr><td width="180" align = "left">Nombre del sitio</td><td><input type = "text" name = "nombre_sitio" size = "45" value = "'.$nombre_sitio.'" /></td></tr>';
									echo '<tr><td align = "left">Url del sitio</td><td><input type = "text" name = "url_sitio" size = "45" value = "'.$url_sitio.'" /></td></tr>';
									echo '<tr><td align = "left">T&iacute;tulo del sitio</td><td><input type = "text" name = "titu_sitio" size = "45" value = "'.$titu_sitio.'" /></td></tr>';
									echo '<tr><td align = "left">Palabras clave del sitio <br /><b><i>Separar las palabras con comas</i></b></td><td><textarea name="palabras_clave" cols="34" rows="4">'.$palabras_clave.'</textarea></td></tr>';
									echo '<tr><td align = "left">Lema del sitio</td><td><textarea name="lema" cols="34" rows="3">'.$lema.'</textarea></td></tr>';
									echo '<tr><td align = "left">Pie del sitio</td><td><textarea name="pie_sitio" cols="34" rows="3">'.$pie_sitio.'</textarea></td></tr>';
									echo '<tr><td align = "left">Mensaje del nuevo usuario de Administraci&oacute;n</td><td><textarea name="mensaje_nuevo_usuario_admon" cols="34" rows="3">'.$mensaje_nuevo_usuario_admon.'</textarea></td></tr>';
									echo '<tr><td align = "left">Mensaje del nuevo usuario de Vista final</td><td><textarea name="mensaje_nuevo_usuario_vista" cols="34" rows="3">'.$mensaje_nuevo_usuario_vista.'</textarea></td></tr>';
									echo '<tr>';
										echo '<td align = "left">Ancho del administrador</td>';
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
								echo '</table><br />';
								echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td align = "center">Podr&aacute; modificar los datos anteriores m&aacute;s tarde en la secci&oacute;n de configuraci&oacute;n</td></tr></table><br />';
								echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td align = "center">Datos del Administrador general llamado  <strong>"admin"</strong></td></tr></table><br />';
								echo '<table width="500" border="0" cellspacing="0" cellpadding="0">';
									echo '<tr><td width="180" align = "left">Contrase&ntilde;a</td><td><input type = "password" name = "pasword1" size = "45" /></td></tr>';
									echo '<tr><td align = "left">Repetir Contrase&ntilde;a</td><td><input type = "password" name = "pasword2" size = "45" /></td></tr>';
									echo '<tr><td align = "left">Nombre del usuario</td><td><input type = "text" name = "nombre" size = "45" value ="'.$nombre_usuario.'" /></td></tr>';
									echo '<tr><td align = "left">Correo electr&oacute;nico</td><td><input type ="text" name ="correo_electronico" size ="45" value ="'.$correo_electronico.'" /></td></tr>';
									echo '<tr><td align = "left">Direcci&oacute;n</td><td><textarea name="direccion" cols="34" rows="3">'.$direccion.'</textarea></td></tr>';
								echo '</table>';
								echo '<table width="500" border="0" cellspacing="0" cellpadding="0" >';
									echo '<tr>';
										echo '<td align = "center">';
											echo '<input type="hidden" name="paso" value = "4" />';
											echo '<input type="hidden" name="guardar" value = "si" />';
											echo '<input type="submit" name="btn_guardar" value="Guardar configuraci&oacute;n y terminar la instalaci&oacute;n"  onclick= "return validar_form(this.form)" />';	
										echo '</td>';
									 echo '</tr>';
								echo '</table>';
							echo '</form>';
						}
					elseif($paso=="4")
						{
							if($_POST["guardar"]=="si")
								{
									$nombre_sitio = $_POST["nombre_sitio"];
									$url_sitio = $_POST["url_sitio"];
									$titu_sitio = $_POST["titu_sitio"];
									$lema = $_POST["lema"];
									$pie_sitio = $_POST["pie_sitio"];
									$palabras_clave = $_POST["palabras_clave"];
									$password_limpia = $_POST["pasword1"];
									$password  = md5($password_limpia);
									$nombre = $_POST["nombre"];
									$correo_electronico = $_POST["correo_electronico"];
									$direccion = $_POST["direccion"];
									$mensaje_nuevo_usuario_admon = $_POST["mensaje_nuevo_usuario_admon"];
									$mensaje_nuevo_usuario_vista = $_POST["mensaje_nuevo_usuario_vista"];
									$resolucion_ancho= $_POST["resolucion_ancho"];
									
									$update_confi = " update nazep_configuracion
									set nombre_sitio = '$nombre_sitio', url_sitio = '$url_sitio', lema = '$lema', 
									pie_sitio= '$pie_sitio', titu_sitio= '$titu_sitio', instalado = 'si', palabras_clave = '$palabras_clave', 
									mensaje_nuevo_usuario_admon = '$mensaje_nuevo_usuario_admon', mensaje_nuevo_usuario_vista = '$mensaje_nuevo_usuario_vista',
									resolucion_ancho = '$resolucion_ancho'";
									$update_user = " update  nazep_usuarios_admon
									set pasword = '$password', nombre= '$nombre', email = '$correo_electronico', 
									direccion = '$direccion', situacion = 'activo'
									where nick_user = 'admin'";
									$conexion = conectarse();
									mysql_query("START TRANSACTION;");
									
									if (!@mysql_query($update_confi))
										{
											$men = mysql_error();
											mysql_query("ROLLBACK;");
											$paso = false;
										}
									else
										{
											if (!@mysql_query($update_user))
												{
													$men = mysql_error();
													mysql_query("ROLLBACK;");
													$paso = false;
												}
											else
												{ $paso = true; }
										}
									if($paso)
										{
											mysql_query("COMMIT;");	
											echo '<table width="500" border="0" cellspacing="0" cellpadding="0">';
												echo '<tr>';
													echo '<td align = "center">';
														echo '
														La instalaci&oacute;n de Nazep ha sido exitosa.
														<br /><br />
														Deber&aacute; eliminar la carpeta llamada "<strong>instalar</strong>" y su contenido para visualizar y administrar su portal.
														<br /><br />
														As&iacute; mismo debe otorgar permisos de lectura, ejecuci&oacute;n y escritura (777) a la carpeta "<strong>archivos</strong>", 
														ubicada en la ra&iacute;z de la instalaci&oacute;n, esto con el fin de un correcto funcionamiento del administrador de archivos.
														<br /><br />
														La direcci&oacute;n para ingresar al administrador de contenidos de su portal es la siguiente:
														<br /><br />
														<a href="'.$url_sitio.'/admon/">'.$url_sitio.'/admon/</a>
														<br /><br />
														La direcci&oacute;n para ingresar a su nuevo portal es la siguiente
														<br /><br />
														<a href="'.$url_sitio.'/index/">'.$url_sitio.'/index/</a>
														<br /><br /> ';
														echo 'El nombre de usuario es: <strong>admin</strong><br />';
														echo "La contrase&ntilde;a para el usuario es: <strong>$password_limpia</strong><br /><br />";
														echo 'Le agradecemos por seleccionar <strong>Nazep</strong> para administrar su portal';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
										}
									else
										{
											echo '<table width="500" border="0" cellspacing="0" cellpadding="0">';
												echo '<tr>';
													echo '<td align = "center">';
														echo 'Se genero el siguiente error en el momento de actualizar los datos<br /><br />'.$men.'<br /><br />';
														echo 'Esperamos pueda solucionarlo, si requiere ayuda puede acudir al sitio de nazep por mas asesoria<br />';
														echo '<a href="http://wwww.nazep.com.mx">http://wwww.nazep.com.mx</a>';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
										}
								}
						}
					else
						{
							echo '<table width="500" border="0" cellspacing="0" cellpadding="0">';
								echo '<tr>';
									echo '<td align = "left" valign="top">';
										echo ' Para iniciar la instalaci&oacute;n de <strong>Nazep</strong>, debe de configurar correctamente 
												unos datos en el archivo "<strong>configuracion.php</strong>" 
												que se encuentra ubicado en la carpeta "<strong>librerias</strong>".
												<br />
										';
									echo '</td>';
								echo '</tr>';
								echo '<tr><td align = "left"><br /></td></tr>';;
								echo '<tr>';
									echo '<td align = "left">';
										echo ' Antes o despu&eacute;s de instalar <strong>Nazep</strong>, deber&aacute; otorgar permisos de lectura, 
												ejecuci&oacute;n y escritura (777) a la carpeta "<strong>archivos</strong>", ubicada en la ra&iacute;z 
												de la instalaci&oacute;n, esto con el fin de un correcto funcionamiento del administrador de archivos.
												<br /><br />';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td align = "left">';
										echo ' Concluida la instalacin de <strong>Nazep</strong>, 
												debe eliminar del servidor la carpeta "<strong>instalar</strong>" y todo su contenido para iniciar a trabajar en su sitio.
												<br /><br /> ';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
							$version_php = phpversion();
							$version_phpa = explode(".", $version_php);
							if($version_phpa[0]<4)
								{
									echo '<table width="500" border="0" cellspacing="0" cellpadding="0" >';
										echo '<tr>';
											echo '<td align = "center">';
												echo 'La versi&oacute;n de php del servidor actual es: '.$version_php;	
												echo '<br />Nazep tiene como requerimiento b&aacute;sico en lenguaje de programacin de php la versi&oacute;n 4.2';
												echo '<br />Por lo que sugerimos actualizar php a una versi&oacute;n mas actual para mejorar sus sistemas';
												echo '<br />Lamentamos informarle que no podra instalar Nazep con esta versi&oacute;n de php';
											echo '</td>';
										 echo '</tr>';	
									echo '</table>';
								}
							else
								{
									echo '<form name="pasar_paso1" method="post" action="instalar.php" >';	
										echo '<table width="500" border="0" cellspacing="0" cellpadding="0" >';
											echo '<tr>';
												echo '<td align = "center">';
													echo '<input type="hidden" name="paso" value="1" />';
													echo '<input type="submit" name="btn_guardar" value="Comprobar conexi&oacute;n a la base de datos" />';	
												echo '</td>';
											 echo '</tr>';
										echo '</table>';
									echo '</form>';
								}
						}
					?>
				</td>
			</tr>
		</table>
		<br /><br />
		<table width="500" border="0" cellspacing="0" cellpadding="0" align ="center">
			<tr><td height="20" width="40%" align = "right" valign="bottom">
					<a href="http://validator.w3.org/check?uri=referer"><img  border = "0" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
				</td><td height="20" width="60%" align = "left" valign="bottom">
					<a href="http://www.nazep.com.mx" class="derechos" target="_blank" >Nazep</a><br /><span class="derechos">&copy; Todos los Derechos Reservados 2007 <br />Claudio Morales Godinez</span>
			</td></tr>
		</table>
	</body>
</html>
<?php
function comprobar_conexion()
	{
		$host_mysql_con = host_mysql;
		$nombre_user_con = nombre_user;
		$pasword_user_con = pasword_user;
		$nombre_base_con = nombre_base;
		$conexion = @mysql_connect($host_mysql_con, $nombre_user_con, $pasword_user_con);
		$pasar = false;
		if(!$conexion)
			{ echo '<br />No se logr&oacute; establecer la conexi&oacute;n con la base de datos por el motivo:<br /><br />'.mysql_error(); }
		else
			{				
				$version_base = mysql_query("SELECT VERSION()");
				$ren_version = mysql_fetch_array($version_base);
				$version = $ren_version["VERSION()"];
				$version_my = explode(".", $version);
				if($version_my[0]<4)
					{ echo '<br />La versi&oacute;n m&iacute;nimia para usar nazep es la 4.1 y la que desea usar es '.$version_my.', Por lo que no es posible instalar nazep'; }
				else
					{
						$seleccion_db = @mysql_select_db($nombre_base_con);
						if(!$seleccion_db)
							{ echo '<br />No se logr&oacute; seleccionar la base de datos por el siguiente motivo:<br /><br />'.mysql_error();}
						else
							{ $pasar = true; }
					}
			}
		return $pasar;
	}
function borrar_tablas()
	{
		$tablas_1 = "drop table if exists
			nazep_configuracion,
			nazep_noticias_admo,
			nazep_secciones_cambio,
			nazep_secciones_modulos_cambio,
			nazep_sesiones,
			nazep_temas,
			nazep_usuarios_secciones_admon,	
			nazep_v_visitas_simple, 
			nazep_zmod_articulos_votos, 
			nazep_zmod_articulos_paginas_cambios,
			nazep_zmod_articulos_lista,
			nazep_zmod_articulos_comentarios,
			nazep_zmod_articulos_cambios,
			nazep_zmod_baner_cambios,
			nazep_zmod_buscador_cambios,
			nazep_zmod_contacto_configuracion,
			nazep_zmod_contacto_temas,			
			nazep_zmod_contenido_detalle_cambios,
			nazep_zmod_contenido_cambios,
			nazep_zmod_recomendar_conf,
			nazep_registro_acceso,
			nazep_zmod_recomendar;";
			//-22
		if (!@mysql_query($tablas_1))
			{ $error_mensaje[1] = mysql_error(); }
		else
			{
				$tablas_2 = "drop table if exists
					nazep_usuarios_final,
					nazep_zmod_contenido_detalle,
					nazep_zmod_contenido,
					nazep_zmod_contacto,
					nazep_zmod_buscador,
					nazep_zmod_baner,
					nazep_zmod_articulos_temas,
					nazep_zmod_articulos_paginas,
					nazep_secciones_modulos;";
					//30
				if (!@mysql_query($tablas_2))
					{ $error_mensaje[2] = mysql_error(); }
				else
					{
						$tablas_3 ="drop table if exists
						nazep_zmod_baner_configuracion,
						nazep_zmod_articulos,
						nazep_modulos;";
						//34
						if (!@mysql_query($tablas_3))
							{ $error_mensaje[3] = mysql_error(); }
						else
							{
								$tablas_4 ="drop table if exists
								nazep_zmod_articulos_tipos,
								nazep_paises,
								nazep_secciones,
								nazep_zmod_articulos_rss;";
								//38
								if (!@mysql_query($tablas_4))
									{ $error_mensaje[4] = mysql_error(); }
								else
									{
										$tablas_5 ="drop table if exists nazep_usuarios_admon;";
										//39
										if (!@mysql_query($tablas_5))
											{ $error_mensaje[5] = mysql_error(); }
										else
											{ $error_mensaje[0] = true; }
									}
								
							}
					}
			}
		return $error_mensaje;
	} 
function conectarse()
	{
		$host_mysql_con = host_mysql;
		$nombre_user_con = nombre_user;
		$pasword_user_con = pasword_user;
		$nombre_base_con = nombre_base;
		$conexion = mysql_connect($host_mysql_con, $nombre_user_con, $pasword_user_con) or die(mysql_error());
		mysql_select_db($nombre_base_con) or die (mysql_error());
		return $conexion;
	}
?>