// JavaScript Document
/*
Sistema: Nazep
Nombre archivo: jquery_nazep_admon.js
Función archivo: pluging de jquery para nazep
Fecha creación: mayo 2009
Fecha última Modificación: Diciembre 2009
Versión: 0.1.5
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
//----------- funciones extendidas de qjquery
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
jQuery.guardar_valores = function(formulario)
	{
		$("#"+formulario).submit(function() { 
			$.ajax({
				async:true,
				type:'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				beforeSend: function(data)
					{
						$("#div_resultado_operacion").html("<img src=\"imagenes/progreso.gif\" alt=\"Procesando Informaci&oacute;n \" />");
					},
				 success:function(data)
					{	
						data_final = data.split('-,*-');
						if(data_final[0]=="termino")
							{
								formulario_final = data_final[1];
								$("#"+formulario_final).submit();
							}
						else
							{
								$.escribir_mensaje_resultado(data, "error");
							}
					},
				error: function(data, error)
					{
						$.escribir_mensaje_resultado("Ocurrio un problema interno "+ error, "error");
					}					
				})
			return false;
		}); 
	}
jQuery.escribir_mensaje_resultado = function(mensaje,tipo)
	{
		if(tipo=="error")
			{
				$("#div_resultado_operacion").css( { color: "#AD0505" } );				
			}
		$("#div_resultado_operacion").html(mensaje);
	}
//------------ fin de funciones
//-------------- Inicio del script para verificar si la fecha es correcta							
	var DaysInMonth = new Array();
	DaysInMonth[0] = 31;  
	DaysInMonth[1] = 29;  
	DaysInMonth[2] = 31;  
	DaysInMonth[3] = 30;  
	DaysInMonth[4] = 31;  
	DaysInMonth[5] = 30;  
	DaysInMonth[6] = 31;  
	DaysInMonth[7] = 31;  
	DaysInMonth[8] = 30;  
	DaysInMonth[9] = 31;  
	DaysInMonth[10] = 30; 
	DaysInMonth[11] = 31; 					
	function IsDay(YourDay, YourMonth)
		{
			return (parseInt(YourDay) > 0 && parseInt(YourDay) <= DaysInMonth[YourMonth - 1]) ? 1 : 0;
		} 					
	function IsMonth(YourMonth)
		{	
			return (parseInt(YourMonth) > 0 && parseInt(YourMonth) <= 12) ? 1 : 0;
		}										
	function IsLeapYear(YourYear)
		{
			return ((YourYear % 4 == 0 && YourYear % 100 != 0) || (YourYear % 400 == 0)) ? 1 : 0;
		}					
	function verificar_fecha(YourDate, YourDateSeparator)
		{
			var IsAllOK = 1;
			var YourDateParts = new Array(); //Variable donde se almacenaran las partes de la fecha (dia, mes y año) tras haber eliminado el separador de la fecha
			YourDateParts = YourDate.split(YourDateSeparator); //Se crean las partes de la fecha (día, mes y año) eliminando el separador de la fecha
			var Day = YourDateParts[0]; //El día corresponde al primer elemento del array
			var Month = YourDateParts[1]; //El mes corresponde al segundo elemento del array
			var Year = YourDateParts[2]; //El año corresponde al tercer elemento del array
			
			if (!IsLeapYear(Year)) 
				{
					DaysInMonth[1] = 28; 
				}	
			else if (IsLeapYear(Year)) 
				{
					DaysInMonth[1] = 29; 
				}
			else IsAllOK = 0; 
			IsAllOK = (IsMonth(Month)) ? IsAllOK : 0 
			IsAllOK = (IsDay(Day, Month)) ? IsAllOK : 0 
			return IsAllOK 		
		}

//-------------- Fin del script para verificar si la fecha es correcta

//-------------- Inicio del script para comparar si una de dos fechas es mayor que la otra
	function Comparar_Fecha(Obj1,Obj2)
		{
			String1 = Obj1;
			String2 = Obj2;
			// Si los dias y los meses llegan con un valor menor que 10
			// Se concatena un 0 a cada valor dentro del string
			if (String1.substring(1,2)=="/") 
				{
					String1="0"+String1
				}
			if (String1.substring(4,5)=="/")
				{
					String1=String1.substring(0,3)+"0"+String1.substring(3,9)
				}							
			if (String2.substring(1,2)=="/") 
				{
					String2="0"+String2
				}
			if (String2.substring(4,5)=="/")
				{
					String2=String2.substring(0,3)+"0"+String2.substring(3,9)
				}							
			dia1=String1.substring(0,2);
			mes1=String1.substring(3,5);
			anyo1=String1.substring(6,10);
			dia2=String2.substring(0,2);
			mes2=String2.substring(3,5);
			anyo2=String2.substring(6,10);
			if (dia1 == "08") // parseInt("08") == 10 base octogonal
			dia1 = "8";
			if (dia1 == "09") // parseInt("09") == 11 base octogonal
			dia1 = "9";
			if (mes1 == "08") // parseInt("08") == 10 base octogonal
			mes1 = "8";
			if (mes1 == "09") // parseInt("09") == 11 base octogonal
			mes1 = "9";
			if (dia2 == "08") // parseInt("08") == 10 base octogonal
			dia2 = "8";
			if (dia2 == "09") // parseInt("09") == 11 base octogonal
			dia2 = "9";
			if (mes2 == "08") // parseInt("08") == 10 base octogonal
			mes2 = "8";
			if (mes2 == "09") // parseInt("09") == 11 base octogonal
			mes2 = "9";
			
			dia1=parseInt(dia1);
			dia2=parseInt(dia2);
			mes1=parseInt(mes1);
			mes2=parseInt(mes2);
			anyo1=parseInt(anyo1);
			anyo2=parseInt(anyo2);
			
			if (anyo1>anyo2)
				{
					return false;
				}							
			if ((anyo1==anyo2) && (mes1>mes2))
				{
					return false;
				}
			if ((anyo1==anyo2) && (mes1==mes2) && (dia1>dia2))
				{
					return false;
				}							
			return true;
		}			
//-------------- Fin del script para comparar si una de dos fechas es mayor que la otra
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
//-------------- Inicio del script para Solo dejar escribir numeros en un campo
	function solo_num(evt)
		{	
			tecla = (document.all) ? evt.keyCode : evt.which; 
			if (tecla==8) return true; 
			patron = /\d/;
			te = String.fromCharCode(tecla); 
			return patron.test(te);	
		}
//-------------- Fin del script para Solo dejar escribir numeros en un campo