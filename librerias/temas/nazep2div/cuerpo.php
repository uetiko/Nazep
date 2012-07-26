<?php
/*
Sistema: Nazep
Nombre archivo: cuerpo.php
Función archivo: archivo que genera el cuerpo del tema por defecto nazep2 para su visualización
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
?>
<div id="div_cuerpo_central" class="clas_cuerpo_central" >
	<div id="div_cuer_cen_izq" class="clas_cuer_cen_izq" >
		<div id="div_sup_menu" class="imagen_fondo_menu_lateral_sup" ></div>
		<?php
			$imagen_balazo = $ubicacion_tema.'image/bullet_prin.jpg';
			$this->lis_secc_prin_ver_ul("1", "99", "27px", "10px", "4px", "si", "Listado de secciones", "si", $ubicacion_tema, "5", $imagen_balazo, "Balazo", "Balazo");
			if($sec!="1")
				{	
					echo '<br />';
					$this->lis_subsecc_ver_ul($sec, "27px", "10px", "si", "Subsecciones", "si", $ubicacion_tema, "5", $imagen_balazo, "Balazo", "Balazo");
				}
			echo '<br/>';
			$this->listar_mod_secundarios_ver_div($sec, "izquierda", "10", "10px", "10px","000000");
			echo '<br/>';
			$this->listar_mod_secundarios_ver_div_per($sec, "izquierda", "10", "10px", "10px","000000");
			?>
		<div id="div_inf_menu" class="imagen_fondo_menu_lateral_inf" ></div>
	</div>
	<div id="div_cuer_cen_der" class="clas_cuer_cen_der" >
		<div id="enlaces_sup" class="clas_enlaces_sup">
        <?php
			$this->enlace_imprimir("Imprimir contenido","_blank"); 
			echo '&nbsp;&nbsp;&nbsp;';
			$this->enlace_recomendar($sec, "Recomendar a un amigo"); 
		?>
		</div>
        <?php
		if($sec!=1)
			{
				echo '<div id="historial_seccion" class="clas_historial_sec" >';
					$nombre_seccion = $this->historial_vista_div($sec,"->","_self");
				echo '</div>
				<div id="nombre_seccion" class="clas_nombre_sec" >';
					echo $nombre_seccion;
				echo '</div>';
			}
		?>
		<div id="sep_contenido" class="clas_sep_contenido" ></div>
		<div id="contenido_central" class="clas_contenido_central" >
        <?php
				$protegida = $this->seccion_protegida($sec); // variable para saber si la seccion usada esta protegida			
				if($protegida == "no")
					{$this->listar_mod_central_div($sec, $ubicacion_tema, $nick_usuario, "html"); }
				else
					{
						if($this->registro =="no")
							{ $this->validar_usuario($sec); }
						else
							{ $this->listar_mod_central_div($sec,$ubicacion_tema,$nick_usuario, "html"); }
					}
			?>
		</div>
	</div>
	<div style="clear: both;" ></div>
</div>