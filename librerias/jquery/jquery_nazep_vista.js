/*
Sistema: Nazep
Nombre archivo: jquery_nazep_vista.js
Función archivo: pluging de jquery para nazep
Fecha creación: mayo 2009
Fecha última Modificación: Diciembre 2009
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
jQuery.buscarUsuarioRegistrado = function(nombreUsuario, seccion)
        {
            if(nombreUsuario.length>3)
                {                
                    $.ajax({
                            async:true,
                            type:"POST",
                            url: "index.php",
                            data: "NombreUsuario="+nombreUsuario+"&sqlBack=si&buscarUsuario=si",
                            beforeSend: function(data)
                                    {
                                        $("#div_mensajes_nombre_usuario").html("Verificando Nombre de usuario");
                                    },
                             success:function(data)
                                    {
                                        data_final = data;
                                        if(data_final=="disponible")
                                            {
                                                 $("#div_mensajes_nombre_usuario").html("Usuario Disponible");
                                                 $("#txt_usuario_valido").val("SI");
                                            }
                                        else if(data_final=="ocupado")
                                            {
                                                $("#div_mensajes_nombre_usuario").html("Usuario NO Disponible");
                                            }

                                    },
                            error: function(data, error)
                                    {
                                        $("#div_mensajes_nombre_usuario").html("Ocurrio el siguiente problema: "+data);
                                    }					
                            })
                }
            else
                {
                    $("#div_mensajes_nombre_usuario").html("El usuario debe tener mas de 3 caracteres");
                }
            return false;            
        }               
jQuery.buscarCorreoRegistrado = function(correo, seccion)
        {
            $.ajax({
                    async:true,
                    type:"POST",
                    url: "index.php",
                    data: "correo="+correo+"&sqlBack=si&buscarUsuario=si",
                    beforeSend: function(data)
                            {
                                $("#div_mensajes_correo").html("Verificando Correo de usuario");
                            },
                     success:function(data)
                            {
                                data_final = data;  
                                if(data_final=="disponible")
                                    {
                                         $("#div_mensajes_correo").html("Correo Disponible");
                                         $("#txt_correo_valido").val("SI");
                                    }
                                else if(data_final=="ocupado")
                                    {
                                        $("#div_mensajes_correo").html("Correo NO Disponible");
                                    }

                            },
                    error: function(data, error)
                            {
                                $("#div_mensajes_correo").html("Ocurrio el siguiente problema: "+data);
                            }					
                    })
            return false;            
        }                 
jQuery.frm_elem_color = function(color_focus, color_blur)
	{
		$("input,textarea").each(function()
			{		
				var type = this.type.toLowerCase();
				if(type!='button' && type!= 'submit' && type!= 'hidden'&& type!= 'reset')
					{	
						$(this).focus(function(){
							$(this).css({"background-color":color_focus});
						});
						$(this).blur(function(){
							$(this).css({"background-color":color_blur});
						});
					}
		
			});		
	}
jQuery.limpiar_form = function(ele)
	{
   		$(ele).find(':input').each(function() 
			{
        		switch(this.type) 
					{
            			case 'password':
	        	   		case 'select-multiple':
	            		case 'select-one':
	            		case 'text':
           				case 'textarea':
                			$(this).val('');
	                	break;
	            		case 'checkbox':
            			case 'radio':
	                		this.checked = false;
	        		}
	    	});
	}
jQuery.guardar_datos_limpiar = function(formulario,ubicacion_tema,mensaje_exito)
	{
			$("#"+formulario).submit(
			function() 
				{ 
						$.ajax({
							async:true,
							type:"POST",
							url: $(this).attr("action"),
							data: $(this).serialize(),
							beforeSend: function(data)
								{
									$("#div_resultado_operacion").html("<img src=\""+ubicacion_tema+"/progreso.gif\" alt=\"Procesando Informaci&oacute;n \" />");
								},
							 success:function(data)
								{
									data_final = data.split('-');
									if(data_final[0]=="termino")
										{
											$("#div_resultado_operacion").html(mensaje_exito);
											$.limpiar_form("#"+formulario);
										}
									else if(data_final[0]=="fallo")
										{
											mensaje = data_final[1];
											$("#div_resultado_operacion").html("Ocurrio el siguiente problema: "+mensaje);
										}
								},
							error: function(data, error)
								{
									$("#div_resultado_operacion").html("Ocurrio el siguiente problema: "+data);
								}					
							})
						return false;
					})		
			
	}
	
//-------------- Inicio del script para Verificar si un texto es un correo valido
	function isEmailAddress(theElement)
		{
			var s = theElement;
			var filter=/^[A-Za-z][A-Za-z0-9_.]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
			if (s.length == 0 ) return true;
			if (filter.test(s))
			return true;
			else
			return false;
		}
//-------------- Fin del script para Verificar si un texto es un correo valido		