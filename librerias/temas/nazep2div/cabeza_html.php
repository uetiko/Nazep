<?php
/*
Sistema: Nazep
Nombre archivo: cabeza_html.php
Función archivo: archivo que genera la cabeza html del tema por defecto nazep2 para su visualización
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>
			<?php echo ':: '.$titu_sitio.'&nbsp;-&nbsp;'.$this->titulo_seccion($sec).' ::'; ?>
		</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
		echo '<meta name="keywords" content="'.$palabras_clave.$this->keywords_seccion($sec).'" />
		<meta name="description" content="'.$this->descripcion_seccion($sec).'" />
		<link rel="STYLESHEET" type="text/css" href="'.$estilo_css.'" />';
        ?>
        <script type="text/javascript" src="../librerias/jquery/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="../librerias/jquery/jquery_nazep_vista.js"></script>
	</head>
	<body>
	<div id="div_marco_principal" class="clas_marco_principal">
		<div id="div_marco_ancho" class="clas_marco_ancho">