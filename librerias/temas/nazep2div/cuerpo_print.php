<?php
/*
Sistema: Nazep
Nombre archivo: cuerpo_print.php
Función archivo: archivo que genera el cuerpo del tema por defecto nazep2 para su visualización en la impresión
Fecha creación: junio 2007
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
?>
<div id="div_cuerpo_central_print" class="clas_cuerpo_central_print" >
<?php
	$protegida = $this->seccion_protegida($sec); // variable para saber si la seccion usada esta protegida
	if($protegida == "no")
			{ $this->listar_mod_central_div($sec, $ubicacion_tema, $nick_usuario, "print"); }
		else
			{
				if($this->registro =="no")
					{$this->validar_usuario($sec); }
				else
					{ $this->listar_mod_central_div($sec, $ubicacion_tema, $nick_usuario, "print"); }
			}
?>
</div>