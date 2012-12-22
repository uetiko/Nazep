<?php
/*
Sistema: Nazep
Nombre archivo: cuerpo.php
Funci�n archivo: archivo que genera el cuerpo del tema por defecto nazep2 para su visualizaci�n
Fecha creaci�n: junio 2007
Fecha �ltima Modificaci�n: Marzo 2011
Versi�n: 0.2
Autor: Claudio Morales Godinez
Correo electr�nico: claudio@nazep.com.mx
*/
?>
<table width="777" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
<!--Inicio Columna Izquierda -->
		<td width="150" valign="top">
			<table width="150" border="0" cellspacing="0" cellpadding="0" align="center" class="imagen_fondo_menu_lateral" >
				<tr><td valign="top" class="imagen_fondo_menu_lateral_sup" height="25">&nbsp;</td></tr>
				<tr><td valign="top" align = "center">
                	<table style="width:130px;" border="0" cellspacing="5" cellpadding="0" ><tr><td >
<?php
                            $imagen_balazo = $ubicacion_tema.'image/bullet_prin.jpg';
                            $this->lis_secc_prin_ver_tablas("1", "999", "130", "no", "Listado de secciones", "si", $ubicacion_tema, "5", $imagen_balazo, "Balazo", "Balazo");
                            if($sec!="1")
                                    {	
                                            echo '<br />';
                                            $this->lis_subsecc_vert_tablas($sec, "130", "si", "Subsecciones", "si", $ubicacion_tema, "5", $imagen_balazo, "Balazo", "Balazo");
                                    }
                            echo '<br/>';
                            $this->listar_mod_secundarios_vert_tabla($sec, "izquierda", "130");
                            echo '<br/>';
                            $this->listar_mod_secundarios_vert_tabla_persistentes($sec, "izquierda", "130");
?>
                    </td></tr></table>
				</td></tr>
				<tr><td valign="top" class="imagen_fondo_menu_lateral_inf" height="25">&nbsp;</td></tr>
			</table>
		</td>
<!--Termino Columna Izquierda -->
<!--Inicio Columna Derecha -->
		<td width="627"  valign="top">
			<table width="627" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="right" width="70%">
									<?php $this->enlace_imprimir("Imprimir contenido","_blank"); //funci�n para mostrar el enlace de imprimir	?>
								</td>
								<td align="right">
									<?php $this->enlace_recomendar($sec, "Recomendar a un amigo"); //funci�n para mostrar el enlace de recomendar a un amigo?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
<?php 
                                if($sec!=1)
                                    { 
?>
                                        <tr>
                                            <td align="left">
                                                <table width="627" border="0" cellspacing="0" cellpadding="0" align="left">
                                                    <tr>
                                                        <td width="9" align="left"></td>
                                                        <td height="50" align="left">
                                                            <?php $nombre_seccion = $this->historial_vista($sec,"->","left","_self"); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <table width="627" border="0" cellspacing="0" cellpadding="0" align="center">
                                                    <tr>
                                                        <td align="center" class="titulo_seccion">
                                                            <?php echo $nombre_seccion; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
					<?php } ?>
				<tr>
					<td align="left">&nbsp;</td>
				</tr>
				<tr>
                                    <td align="left">
<?php
                                        $protegida = $this->seccion_protegida($sec);
                                        if($protegida == "no")
                                            { $this->listar_mod_central($sec, $ubicacion_tema, $nick_usuario, "html"); }
                                        else
                                            {
                                                if($this->registro =="no")
                                                        { $this->validar_usuario($sec); }
                                                else
                                                        { $this->listar_mod_central($sec,$ubicacion_tema,$nick_usuario, "html"); }
                                            }
?>
                                    </td>
				</tr>
			</table>
		</td>
<!--Termino Columna Derecha -->
	</tr>
</table>