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
<table width="480" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr><td width="480" valign="top"></td></tr>
<?php
$protegida = $this->seccion_protegida($sec); // variable para saber si la seccion usada esta protegida
	if($protegida == "no")
			{?>
				<tr><td width="480" valign="top">
					<?php $this->listar_mod_central($sec, $ubicacion_tema, $nick_usuario, "print"); ?>
				</td></tr>
			<?php }
		else
			{
				if($this->registro =="no")
					{?>
						<tr><td width="480" valign="top">
							<?php $this->validar_usuario($sec); ?>
						</td></tr>
					<?php  }
				else
					{ ?>
						<tr><td width="480" valign="top">
							<?php $this->listar_mod_central($sec, $ubicacion_tema, $nick_usuario, "print"); ?>
						</td></tr>
					<?php } 
			}?>
</table>