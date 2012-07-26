<?php
/*
Sistema: Nazep
Nombre archivo: html_admon.php
Función archivo: Generar toda las funciones para mostrar los elementos web de la aplicación
Fecha creación: Marzo 2011
Fecha última Modificación: Marzo 2011
Versión: 0.2
Autor: Claudio Morales Godinez
Correo electrónico: claudio@nazep.com.mx
*/
final class html 
	{
		public static function comment($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						$cadenaUsar = '<!--'.$text.'-->';
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function tagHTML($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';			
						$opc .= (isset($arr["xmlns"]) && $arr["xmlns"]!='' ) ? ' xmlns= "'.$arr["xmlns"].'" ' : '';
						$opc .= (isset($arr["lang"]) && $arr["lang"]!='' ) ? ' lang= "'.$arr["lang"].'" ' : '';	
						$opc .= (isset($arr["xml:lang"]) && $arr["xml:lang"]!='' ) ? ' xml:lang= "'.$arr["xml:lang"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<html '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<html '.$opc.'  >'.$text.'</html>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</html>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function head($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["profile"]) && $arr["profile"]!='' ) ? ' profile= "'.$arr["profile"].'" ' : '';
						$opc .= (isset($arr["dir"]) && $arr["dir"]!='' ) ? ' dir= "'.$arr["dir"].'" ' : '';
						$opc .= (isset($arr["lang"]) && $arr["lang"]!='' ) ? ' lang= "'.$arr["lang"].'" ' : '';
						$opc .= (isset($arr["xml:lang"]) && $arr["xml:lang"]!='' ) ? ' xml:lang= "'.$arr["xml:lang"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<head '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<head '.$opc.'  >'.$text.'</head>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</head>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function title($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';				
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["dir"]) && $arr["dir"]!='' ) ? ' dir= "'.$arr["dir"].'" ' : '';
						$opc .= (isset($arr["lang"]) && $arr["lang"]!='' ) ? ' lang= "'.$arr["lang"].'" ' : '';
						$opc .= (isset($arr["xml:lang"]) && $arr["xml:lang"]!='' ) ? ' xml:lang= "'.$arr["xml:lang"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<title '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<title '.$opc.'  >'.$text.'</title>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</title>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function style($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';				
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["media"]) && $arr["media"]!='' ) ? ' media= "'.$arr["media"].'" ' : '';
						$opc .= (isset($arr["dir"]) && $arr["dir"]!='' ) ? ' dir= "'.$arr["dir"].'" ' : '';
						$opc .= (isset($arr["lang"]) && $arr["lang"]!='' ) ? ' lang= "'.$arr["lang"].'" ' : '';
						$opc .= (isset($arr["title"]) && $arr["title"]!='' ) ? ' title= "'.$arr["title"].'" ' : '';
						$opc .= (isset($arr["xml:lang"]) && $arr["xml:lang"]!='' ) ? ' xml:lang= "'.$arr["xml:lang"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<style type="text/css" '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<style type="text/css"  '.$opc.'  >'.$text.'</style>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</style>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function meta($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';	
				if($presentacion=='echo' or $presentacion=='return')
					{
						$opc = '';
						$opc .= (isset($arr["content"]) && $arr["content"]!='' ) ? ' content= "'.$arr["content"].'" ' : ' content="" ';
						$opc .= (isset($arr["http-equiv"]) && $arr["http-equiv"]!='' ) ? ' http-equiv= "'.$arr["http-equiv"].'" ' : ' ';
						$opc .= (isset($arr["name"]) && $arr["name"]!='' ) ? ' name= "'.$arr["name"].'" ' : '';
						$opc .= (isset($arr["scheme"]) && $arr["scheme"]!='' ) ? ' scheme= "'.$arr["scheme"].'" ' : '';
						$cadenaUsar = '<meta  '.$opc.' />';
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function link($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';	
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["rel"]) && $arr["rel"]!='' ) ? ' rel= "'.$arr["rel"].'" ' : ' rel="stylesheet" ';
						$opc .= (isset($arr["type"]) && $arr["type"]!='' ) ? ' type= "'.$arr["type"].'" ' : ' type="text/css" ';
						$opc .= (isset($arr["href"]) && $arr["href"]!='' ) ? ' href= "'.$arr["href"].'" ' : '';
						
						$opc .= (isset($arr["charset"]) && $arr["charset"]!='' ) ? ' charset= "'.$arr["charset"].'" ' : '';
						$opc .= (isset($arr["hreflang"]) && $arr["hreflang"]!='' ) ? ' hreflang= "'.$arr["hreflang"].'" ' : '';
						$opc .= (isset($arr["media"]) && $arr["media"]!='' ) ? ' media= "'.$arr["media"].'" ' : '';
						$opc .= (isset($arr["rev"]) && $arr["rev"]!='' ) ? ' rev= "'.$arr["rev"].'" ' : '';
						$opc .= (isset($arr["target"]) && $arr["target"]!='' ) ? ' target= "'.$arr["target"].'" ' : '';	
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$cadenaUsar = '<link  '.$opc.' />';
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function script($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';				
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["type"]) && $arr["type"]!='' ) ? ' type= "'.$arr["type"].'" ' : ' type="text/javascript" ';
						$opc .= (isset($arr["charset"]) && $arr["charset"]!='' ) ? ' charset= "'.$arr["charset"].'" ' : '';
						$opc .= (isset($arr["defer"]) && $arr["defer"]!='' ) ? ' defer= "'.$arr["defer"].'" ' : '';
						$opc .= (isset($arr["src"]) && $arr["src"]!='' ) ? ' src= "'.$arr["src"].'" ' : '';
						$opc .= (isset($arr["xml:space"]) && $arr["xml:space"]!='' ) ? ' xml:space= "'.$arr["xml:space"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<script  '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<script   '.$opc.'  >'.$text.'</script>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</script>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}
		public static function body($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class= "'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["dir"]) && $arr["dir"]!='' ) ? ' dir= "'.$arr["dir"].'" ' : '';
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';
						$opc .= (isset($arr["lang"]) && $arr["lang"]!='' ) ? ' lang= "'.$arr["lang"].'" ' : '';
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style= "'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["title"]) && $arr["title"]!='' ) ? ' title= "'.$arr["title"].'" ' : '';
						$opc .= (isset($arr["xml:lang"]) && $arr["xml:lang"]!='' ) ? ' xml:lang= "'.$arr["xml:lang"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<body '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<body '.$opc.' >'.$text.'</body>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</body>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}					
			}			
		public static function a($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{						
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';	
						$opc = '';			
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';				
						$opc .= (isset($arr["name"]) && $arr["name"]!='' ) ? ' name ="'.$arr["name"].'" ' : ''; 
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style="'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["href"]) && $arr["href"]!='' ) ? ' href="'.$arr["href"].'" ' : ' href="#" ';
						$opc .= (isset($arr["title"]) && $arr["title"]!='' ) ? ' title="'.$arr["title"].'" ' : '';
						$opc .= (isset($arr["target"]) && $arr["target"]!='' ) ? ' target="'.$arr["target"].'" ' : ' target="_self" ';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : 'ir a';
						if($tipo=='ini')
							{ $cadenaUsar = '<a '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<a '.$opc.' >'.$text.'</a>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</a>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar; 
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}
			}
		public static function div($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';	
						$opc = '';			
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';
						$opc .= (isset($arr["name"]) && $arr["name"]!='' ) ? ' name ="'.$arr["name"].'" ' : ''; 
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style="'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<div '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<div '.$opc.' >'.$text.'</div>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</div>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar; 
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}				
			}			
		public static function form($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';	
						$opc = '';			
						$opc .= (isset($arr["action"]) && $arr["action"]!='' ) ? ' action= "'.$arr["action"].'" ' : ' action="#" ';
						$opc .= (isset($arr["accept"]) && $arr["accept"]!='' ) ? ' accept= "'.$arr["accept"].'" ' : '';
						$opc .= (isset($arr["accept-charset"]) && $arr["accept-charset"]!='' ) ? ' accept-charset= "'.$arr["accept-charset"].'" ' : '';
						$opc .= (isset($arr["enctype"]) && $arr["enctype"]!='' ) ? ' enctype= "'.$arr["enctype"].'" ' : '';
						$opc .= (isset($arr["method"]) && $arr["method"]!='' ) ? ' method= "'.$arr["method"].'" ' : ' method="POST" ';
						$opc .= (isset($arr["name"]) && $arr["name"]!='' ) ? ' name= "'.$arr["name"].'" ' : ' name= "formulario"';
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : 'id= "formulario"';
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style="'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<form '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<form '.$opc.' >'.$text.'</form>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</form>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}
			}
		public static function input($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';	
						$opc = '';			
						$opc .= (isset($arr["name"]) && $arr["name"]!='' ) ? ' name= "'.$arr["name"].'" ' : '';
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style="'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["accept"]) && $arr["accept"]!='' ) ? ' accept="'.$arr["accept"].'" ' : '';
						$opc .= (isset($arr["alt"]) && $arr["alt"]!='' ) ? ' alt="'.$arr["alt"].'" ' : '';
						$opc .= (isset($arr["checked"]) && $arr["checked"]!='' ) ? ' checked="'.$arr["checked"].'" ' : '';
						$opc .= (isset($arr["disabled"]) && $arr["disabled"]!='' ) ? ' disabled="'.$arr["disabled"].'" ' : '';
						$opc .= (isset($arr["maxlength"]) && $arr["maxlength"]!='' ) ? ' maxlength="'.$arr["maxlength"].'" ' : '';
						$opc .= (isset($arr["readonly"]) && $arr["readonly"]!='' ) ? ' readonly="'.$arr["readonly"].'" ' : '';
						$opc .= (isset($arr["size"]) && $arr["size"]!='' ) ? ' size="'.$arr["size"].'" ' : '';
						$opc .= (isset($arr["src"]) && $arr["src"]!='' ) ? ' src="'.$arr["src"].'" ' : '';
						$opc .= (isset($arr["type"]) && $arr["type"]!='' ) ? ' type="'.$arr["type"].'" ' : '';
						$opc .= (isset($arr["value"]) && $arr["value"]!='' ) ? ' value="'.$arr["value"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$cadenaUsar = '<input  '.$opc.' />';
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}
			}
		public static function select($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opciones = (isset($arr["opciones"]) && $arr["opciones"]!='' ) ? $arr["opciones"] : array();
						$opcionSelect = (isset($arr["opcionselect"]) && $arr["opcionselect"]!='' ) ? $arr["opcionselect"] : array();
						$opc = '';
						$opc .= (isset($arr["name"]) && $arr["name"]!='' ) ? ' name= "'.$arr["name"].'" ' : '';
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style="'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["disabled"]) && $arr["disabled"]!='' ) ? ' disabled="'.$arr["disabled"].'" ' : '';
						$opc .= (isset($arr["multiple"]) && $arr["multiple"]!='' ) ? ' multiple="'.$arr["multiple"].'" ' : '';						
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = '';
						foreach($opcionSelect as $clave => $valor)
							{
								$text .= '<option value="'.$clave.'" ';
								if($opcionSelect==$valor)
									{$text .= ' selected="selected" ';}
								$text .= '>'.$valor.'</option>'; 
							}						
						$cadenaUsar = '<select '.$opc.' > '.$text.' </select>';
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}
			}
		public static function label($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';
						$opc .= (isset($arr["for"]) && $arr["for"]!='' ) ? ' for="'.$arr["for"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["title"]) && $arr["title"]!='' ) ? ' title= "'.$arr["title"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$text = (isset($arr["contenido"]) && $arr["contenido"]!='' ) ? $arr["contenido"] : '';
						if($tipo=='ini')
							{ $cadenaUsar = '<label '.$opc.' >'; }
						else if($tipo =='inifin')
							{ $cadenaUsar = '<label '.$opc.' >'.$text.'</label>'; }
						else if($tipo =='fin')
							{ $cadenaUsar = '</label>'; }
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;	
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}	
			}			
		public static function hr($arreglo_elementos)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$tipo = (isset($arr["tipo"]) && $arr["tipo"]!='' ) ? $arr["tipo"] : 'inifin';
						$opc = '';
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style="'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["title"]) && $arr["title"]!='' ) ? ' title= "'.$arr["title"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$cadenaUsar = '<hr  '.$opc.' />';
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;						
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}
			}
		public static function img($arr)
			{
				$cadenaUsar = '';
				$presentacion = ( isset($arr["presentacion"]) && $arr["presentacion"]!=''  ) ? $arr["presentacion"] : 'echo';
				if($presentacion=='echo' or $presentacion=='return')
					{
						$opc = '';
						$opc .= (isset($arr["id"]) && $arr["id"]!='' ) ? ' id= "'.$arr["id"].'" ' : '';
						$opc .= (isset($arr["style"]) && $arr["style"]!='' ) ? ' style="'.$arr["style"].'" ' : '';
						$opc .= (isset($arr["class"]) && $arr["class"]!='' ) ? ' class="'.$arr["class"].'" ' : '';
						$opc .= (isset($arr["title"]) && $arr["title"]!='' ) ? ' title= "'.$arr["title"].'" ' : '';
						$opc .= (isset($arr["alt"]) && $arr["alt"]!='' ) ? ' alt= "'.$arr["alt"].'" ' : '';
						$opc .= (isset($arr["src"]) && $arr["src"]!='' ) ? ' src= "'.$arr["src"].'" ' : '';
						$opc .= (isset($arr["varios"]) && $arr["varios"]!='' ) ? $arr["varios"] : '';
						$cadenaUsar = '<img  '.$opc.' />';
						if($presentacion=='echo')
							echo $cadenaUsar;
						else if($presentacion=='return')
							return $cadenaUsar;	
					}
				else
					{html::div(array('contenido'=>'El valor de presentacion solo puede ser "echo" o "return"'));}	
			}
	}
?>