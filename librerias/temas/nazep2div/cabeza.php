<?php
/*
Sistema: Nazep
Nombre archivo: cabeza.php
Función archivo: archivo que genera la cabeza del tema por defecto nazep2 para su visualización
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
?>
<div id="cabeza_prin">
	<div id="div_img_cabeza" class="imagen_cabeza" >
    	<?php
		if(!$this->registro=="no")
			{echo '<div id="div_usuario" class="clas_usuario"> Usuario: '.$this->nom_usuario.'<br/><a href="index.php?salir=si" title="Salir" >Salir</a></div>';}
            ?>
	</div>
	<div id="div_menu_sup" class="imagen_fondo_menu" >
		<div id="div_texto_menu" class="clas_texto_menu">
        		<?php
				echo '&nbsp;|&nbsp;';
					$this->enlace_inicio("Inicio");
				echo '&nbsp;|&nbsp;';
					$this->enlace_buscador("Buscador");
				echo '&nbsp;|&nbsp;';
					$this->enlace_mapa_sitio("Mapa del Sitio");
				echo '&nbsp;|&nbsp;';
					$this->enlace_contacto("Contacto");
				echo '&nbsp;|&nbsp;'
				?>
		</div>
	</div>
</div>