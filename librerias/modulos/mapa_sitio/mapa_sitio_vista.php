<?php
/*
Sistema: Nazep
Nombre archivo: mapa_sitio_vista.php
Función archivo: archivo para controlar la vista final del módulo de mapa del sitio
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
class clase_mapa_sitio extends conexion
	{
		var $tree;
		function vista_buscador_avanzado($sec, $ubicacion_tema, $nick_usuario)
			{}	
		function vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				echo '<div id="centro_contenido"  class="centro_contenido_gral">';
					include("librerias/modulos/mapa_sitio/dhtmlgoodies_tree.class.php");
					$this->tree = new dhtmlgoodies_tree();
					$this->mapa("si", "1");
					$this->tree->writeJavascript();
					$this->tree->drawTree();
				echo '</div>';
			}
		function vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo)
			{
				echo '<div class="div_contenido_principal_print" >';
					include("librerias/modulos/mapa_sitio/dhtmlgoodies_tree.class.php");
					$this->tree = new dhtmlgoodies_tree();
					$this->mapa("no", "1");
					$this->tree->writeJavascript();
					$this->tree->drawTree();
				echo '</div>';
			}
		function mapa($ver_otro, $seccion)
			{
				$hoy = date('Y-m-d');
				$con_mapa ="select clave_seccion, titulo, clave_seccion_pertenece  from nazep_secciones
				where clave_seccion_pertenece = '$seccion'
				and (case usar_vigencia  when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy' when 'no' then 1 else 0 end)
				and situacion = 'activo' order by orden asc";
				$res = mysql_query($con_mapa);
				while($ren = mysql_fetch_array($res))
					{
						$clave_seccion = $ren["clave_seccion"];
						$titulo = $ren["titulo"];
						$clave_seccion_pertenece  = $ren["clave_seccion_pertenece"];
						if($clave_seccion_pertenece ==1)
							{ $clave_seccion_pertenece=0; }
						if($ver_otro == 'si')
							{ $this->tree->addToArray($clave_seccion,$titulo,$clave_seccion_pertenece,"index.php?sec=$clave_seccion"); }
						else
							{ $this->tree->addToArray($clave_seccion,$titulo,$clave_seccion_pertenece,""); }	
						$con_sub = "select clave_seccion, nombre from nazep_secciones
						where clave_seccion_pertenece = '$clave_seccion'
						and (case usar_vigencia  when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
						when 'no' then 1 else 0 end) and situacion = 'activo'  order by orden asc";
						$res_sub = mysql_query($con_sub);
						$can_sub = mysql_num_rows($res_sub);
						if($can_sub!="")
							{ $this->mapa($ver_otro, $clave_seccion); }
					}
			}
	}
?>