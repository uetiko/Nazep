<?php
/*
Sistema: Nazep
Nombre archivo: vista_final.php
Funcion archivo: Contener todas las funciones necesarias para ver el portal
Fecha creacion: junio 2007
Fecha ultima Modificacion: Marzo 2011
Version: 0.2
Autor: Claudio Morales Godinez
Correo electronico: claudio@nazep.com.mx
*/
if( file_exists("librerias/error.php") && file_exists("librerias/conexion.php") )
    {
        include_once("librerias/error.php");
        include("librerias/conexion.php");		
    }
else if( file_exists("error.php") &&  file_exists("conexion.php") )
    {
        include_once("error.php");
        include_once("conexion.php");
    }
include_once("librerias/html.php");
include_once("librerias/html_vista.php");
include_once("librerias/FunGral.php");
class vista_final extends conexion
        {
	
		private $nick_user='Invitado';
		private $ip_user;
		private $registro = 'no';
		var $nom_usuario = '';
		var $direccion_recomendar_g = 'index.php';		
		var $clave_recomendar_g = 1;
		function ver_registro()
			{
                            return $this->registro;
			}	
		function arreglo($sec)
			{
                            $clave_seccion_usada = $sec;
                            $arreglo_seccion[0] = $sec;
                            for($a=1;$a>0;$a++)
                                    {	
                                            $con = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$clave_seccion_usada'";	
                                            $res = mysql_query($con);
                                            $ren = mysql_fetch_array($res);
                                            $clave_seccion_pertenece = $ren["clave_seccion_pertenece"]; 
                                            $arreglo_seccion[$a] = $clave_seccion_pertenece;
                                            if($clave_seccion_pertenece == 1)
                                                    { $a = -1; }
                                            else
                                                    { $clave_seccion_usada = $clave_seccion_pertenece; }
                                    }
                            return $arreglo_seccion;
			}
		function salir()
                    {	
                        $ip = $_SERVER['REMOTE_ADDR']; 
                        $conexion = $this->conectarse();
                        $temporal_ip = $this->ip_user;
                        $nick_tem = $this->nick_user;
                        $borrar = "delete from nazep_sesiones where nick_usuario = '$nick_tem' and ip = '$temporal_ip'";
                        $this->nick_user = 'Invitado';
                        $this->ip_user = $ip;
                        $this->registro = 'no';		
                        $this->sentecia($borrar, "");
                        $this->desconectarse($conexion);
                        return $this->obtenerSeccion();
                    }
                function generarUrlSalir()
                    { return "index.php?salir=si&sec=".$this->obtenerSeccion(); }
		function checar_sesion()
                    {
                        $ip = $_SERVER['REMOTE_ADDR']; 
                        if($this->registro =="no")
                            {
                                $this->nick_user ="Invitado";
                                $this->ip_user =$ip;
                            }
                        $temporal_user = $this->nick_user;
                        $temporal_ip = $this->ip_user;
                        $conexion = $this->conectarse();
                        $con_user_linea = "select nick_usuario from nazep_sesiones where nick_usuario = '$temporal_user' and ip = '$temporal_ip'";
                        $res_con_user = mysql_query($con_user_linea);
                        $cantidad = mysql_num_rows($res_con_user);
                        $tem_hora = time();
                        if($cantidad == 0)
                            {
                                $tem_nick = $this->nick_user;
                                $insertar_usuario = "insert into nazep_sesiones values('$tem_nick', '$tem_hora', '$ip')";
                                $this->sentecia($insertar_usuario, "");
                            }
                        else
                            {
                                $tem_nick = $this->nick_user;
                                $actualizar = "update nazep_sesiones set hora  = '$tem_hora' where nick_usuario = '$tem_nick' and ip = '$ip'";
                                $this->sentecia($actualizar, "");	
                            }
                        $inactividad = time()-(60*60*20);
                        $borrar_inactivos = "delete from nazep_sesiones where hora <= '$inactividad'";
                        $this->sentecia($borrar_inactivos, "");
                        $this->desconectarse($conexion);
                    }
                private function slqBack()
                    {
                        //Metodo que ejcuta metodos sin mostrar nada en la vista Final
                        if(isset($_POST["validar_vista"]) && $_POST["validar_vista"]=='si')
                            {
                                $this->validar_usuario_redireccionar();
                            }                                                                                        
                        else if(isset($_POST["buscarUsuario"]) && $_POST["buscarUsuario"]=='si')
                            {
                                //Se ejecuta Metodo sin interfaz
                                $this->buscarUsuarioExistencia();
                            }
                        else if(isset($_POST["registrarNuevoUsuario"]) && $_POST["registrarNuevoUsuario"]=='si')
                            {
                                $this->guardarNuevoUsuario();
                            }
                        else if (isset($_POST["nuevopassword"]) && $_POST["nuevopassword"]=='si')
                            {
                                $this->enviarNuevoPassword();
                            }
                        else if (isset($_POST["validarCapcha"]) && $_POST["validarCapcha"]=='si')
                            {
                                $this->validarCaptcha();
                            }
                    }
                private function obtenerSeccion()
                    {
                        if(!isset($_GET["sec"]) || $_GET["sec"]=='')
                            {$sec = 1;}
                        else
                            { $sec = $_GET["sec"]; } 
                        return (int)$sec;                        
                    }
                
		private function validar_usuario_redireccionar()
                    {
                        $sec = $this->obtenerSeccion();
                        $password_usuario_vista = $_POST["password_usuario_vista"];
                        $nick_usuario_vista = addslashes($_POST["nick_usuario_vista"]);
                        $password_usuario_vista = md5($password_usuario_vista);
                        $sql = "select nombre, a_mat, a_pat from nazep_usuarios_final
                        where nick_usuario = '$nick_usuario_vista' and pasword = '$password_usuario_vista' and situacion = 'activo'";
                        $conexion = $this->conectarse();
                        $res_con = mysql_query($sql);
                        $cantidad = mysql_num_rows($res_con);
                        if($cantidad === 0)
                            {
                                header("Location:  index.php?error_usuario=si&sec=$sec");
                            }
                        else
                            {
                                $ren_con = mysql_fetch_array($res_con);
                                $nombre = $ren_con["nombre"];
                                $a_mat = $ren_con["a_mat"];
                                $a_pat = $ren_con["a_pat"];	
                                $this->nick_user = $nick_usuario_vista;
                                $temporal_ip = $this->ip_user;
                                $this->registro = "si";
                                $this->nom_usuario = $nombre."&nbsp;".$a_pat."&nbsp;".$a_mat;
                                $delete = "delete from nazep_sesiones where nick_usuario = 'Invitado' and ip = '$temporal_ip'";
                                if (mysql_query($delete))
                                    {
                                        $this->registro = 'si';
                                        header("Location:  index.php?sec=$sec");
                                    }
                            }
                    }                    
                private function buscarUsuarioExistencia()
                    {
                        if(isset($_POST["NombreUsuario"]))
                            { $cadenaWere =  " where nick_usuario = '".$this->escapar_caracteres($_POST["NombreUsuario"])."'";}
                        else if(isset($_POST["correo"]))
                            { $cadenaWere =  " where correo = '".$this->escapar_caracteres($_POST["correo"])."'"; }
                        $conexion = $this->conectarse();
                        $sql = "select nick_usuario from nazep_usuarios_final $cadenaWere";
                        $res_sql = mysql_query($sql);
                        $can_reg = mysql_num_rows($res_sql);
                        if($can_reg==1)
                            {echo 'ocupado'; }
                        else if($can_reg==0)
                            { echo 'disponible'; }
                        $this->desconectarse($conexion);
                    }
                private function validarCaptcha()
                    {
                        require_once('librerias/recaptcha/recaptchalib.php');
                        $conexion = $this->conectarse();
                        $sql = "select llave_privada_captcha from nazep_configuracion ";
                        $resSql = mysql_query($sql);
                        $renSql = mysql_fetch_array($resSql);
                        $llavePrivada = $renSql["llave_privada_captcha"];                        
                        $resp = recaptcha_check_answer ($llavePrivada,
                        $_SERVER["REMOTE_ADDR"],
                        $_POST["recaptcha_challenge_field"],
                        $_POST["recaptcha_response_field"]);
                        
                        if($resp->is_valid)
                            {  echo 'valido';   }
                        else
                            { echo 'invalido';  }
                        $this->desconectarse($conexion);
                    }
                private function generarCodigoUsuario()
                    {
                        $str = "ABCDEFGHJLMNPQRSTUVWXYZabcdefghijmnpqrstuvwxyz23456789";                                
                        for($i=0;$i<11;$i++) 
                            {
                                $codigoActivacion .= substr($str,rand(0,53),1);
                            }
                        $sql = "select codigo_seguridad from nazep_usuarios_final where codigo_seguridad = '$codigoActivacion' ";
                        $res = mysql_query($sql);
                        $can = mysql_num_rows($res);
                        if($can<1)
                            {  return $codigoActivacion;  }
                        else
                            { return $this->generarCodigoUsuario(); }
                    }
                private function guardarNuevoUsuario()
                    {                        
                        $sec = $this->obtenerSeccion();
                        $txt_nick_usuario_registrar = $this->escapar_caracteres($_POST["txt_nick_usuario_registrar"]);
                        $txt_correo_usuario_registrar= $this->escapar_caracteres($_POST["txt_correo_usuario_registrar"]);
                        $txt_password_usuario_a= $_POST["txt_password_usuario_a"];
                        $txt_password_usuario_b= $_POST["txt_password_usuario_b"];
                        $txt_nombre_usuario= $this->escapar_caracteres($_POST["txt_nombre_usuario"]);
                        $txt_apellido_p_usuario= $this->escapar_caracteres($_POST["txt_apellido_p_usuario"]);
                        $txt_apellido_m_usuario= $this->escapar_caracteres($_POST["txt_apellido_m_usuario"]);
                        $fecha_nacimiento = $_POST["ano_n"].'-'.$_POST["mes_n"].'-'.$_POST["dia_n"];
                        $txt_ubicacion_usuario= $this->escapar_caracteres($_POST["txt_ubicacion_usuario"]);
                        $txt_web_usuario= $this->escapar_caracteres($_POST["txt_web_usuario"]);
                        $zona_horario_usuario= $this->escapar_caracteres($_POST["zona_horario_usuario"]);
                        $conexion = $this->conectarse();
                        $con_config = "select * from nazep_usuarios_final_config";
                        $res_config = mysql_query($con_config);
                        $config_user = array();
                        while($ren_config=mysql_fetch_array($res_config))
                            {
                                $config_user[$ren_config["nombre_campo"]] = $ren_config["valor_campo"];                                      
                            }
                        if($config_user["usar_captcha_google"]=='si')
                            {                               
                                if(file_exists("librerias/recaptcha/recaptchalib.php") && is_readable("librerias/recaptcha/recaptchalib.php"))
                                   {
                                        require_once('librerias/recaptcha/recaptchalib.php');
                                        $sql = "select llave_privada_captcha from nazep_configuracion ";
                                        $resSql = mysql_query($sql);
                                        $renSql = mysql_fetch_array($resSql);
                                        $llavePrivada = $renSql["llave_privada_captcha"];                        
                                        $resp = recaptcha_check_answer ($llavePrivada,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);                                        
                                        if(!$resp->is_valid)
                                            {  header("Location: index.php?sec=$sec&f=n&m=7");   }                                                                               
                                   }  
                            }    
                            
                        if($config_user["usar_correo_como_usuario"]=='no')
                            {
                                $sql = "select nick_usuario from nazep_usuarios_final where nick_usuario = '$txt_nick_usuario_registrar'";
                                $sqlb = "select nick_usuario from nazep_usuarios_final where correo = '$txt_correo_usuario_registrar' ";
                            }
                        if($config_user["usar_correo_como_usuario"]=='si')
                            {
                                $sql = "select nick_usuario from nazep_usuarios_final where nick_usuario = '$txt_correo_usuario_registrar'";
                                $txt_nick_usuario_registrar = $txt_correo_usuario_registrar;
                            }      
                        $res_sql = mysql_query($sql);
                        $can_reg = mysql_num_rows($res_sql);
                        if($can_reg==1)
                            {
                                //error existe el usuario
                                header("Location: index.php?sec=$sec&f=n&m=2");                           
                            }
                        if($sqlb!='')
                            {
                                $res_sqlb = mysql_query($sqlb);
                                $can_regb = mysql_num_rows($res_sqlb);
                                if($can_regb==1)
                                    {
                                        //error existe el correo
                                        header("Location: index.php?sec=$sec&f=n&m=3");
                                    }
                            }                            
                        if($txt_password_usuario_a!=$txt_password_usuario_b)
                            {
                                //error no son las mismas contraseñas
                                header("Location: index.php?sec=$sec&f=n&m=4");
                            }                            
                        $txt_password_usuario = md5($txt_password_usuario_a);
                        $fecha_hoy = date("Y-m-d");
                        $hora_hoy = date ("H:i:s");
                        $ip = $_SERVER['REMOTE_ADDR']; 
                        $codigoActivacion = '';
                        if($config_user["enviar_codigo_activacion"]=='si')
                            {
                                $situacion = 'activar';
                                $codigoActivacion = $this->generarCodigoUsuario();
                            }
                        else if($config_user["enviar_codigo_activacion"]=='no')
                            {
                                $situacion = 'activo';
                            }                            
                        $sql2 = "insert into nazep_usuarios_final 
                                (nick_usuario, fecha_alta, hora_alta, pasword, nombre, a_pat, a_mat, situacion,
                                correo, fecha_nacimiento,ubicacion,ip_alta,web,ver_nombre,ver_mail,ver_ubic, 
                                ver_web,zona_horario,codigo_seguridad) 
                                values
                                ('$txt_nick_usuario_registrar','$fecha_hoy', '$hora_hoy', '$txt_password_usuario',
                                 '$txt_nombre_usuario','$txt_apellido_p_usuario','$txt_apellido_m_usuario','$situacion',
                                 '$txt_correo_usuario_registrar', '$fecha_nacimiento', '$txt_ubicacion_usuario',
                                 '$ip', '$txt_web_usuario', 'no','no','no','no','$zona_horario_usuario',
                                  '$codigoActivacion')";                        
                        if (mysql_query($sql2))
                            {           
                                require("librerias/phpmailer/class.phpmailer.php");
                                $mail = new PHPMailer();
                                $mail->SetLanguage("es","librerias/phpmailer/language/");
                                $con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp, 
                                mensaje_nuevo_usuario_vista, url_sitio
                                from nazep_configuracion ";
                                $res_con = mysql_query($con_conf);
                                $ren_con = mysql_fetch_array($res_con);
                                $envio_correo = $ren_con["envio_correo"];
                                $servidor_smtp = $ren_con["servidor_smtp"];
                                $user_smtp = $ren_con["user_smtp"];
                                $pass_smtp	= $ren_con["pass_smtp"];
                                $mensaje_nuevo_usuario_vista = $ren_con["mensaje_nuevo_usuario_vista"];
                                $url_sitio = $ren_con["url_sitio"];
                                
                                $mensajeCodigo = "";
                                if($config_user["enviar_codigo_activacion"]=='si')
                                    {
                                        $mensajeCodigo = " <strong>
                                        Debes ingresar a la siguiente URL para activar tu usuario:<br>
                                        $url_sitio/index.php?codAct=$codigoActivacion
                                        </strong> <br /><br />";
                                    }                                    
                                $con_datos_user = "select nombre, email from nazep_usuarios_admon where nick_user = 'admin'";
                                $res_datos = mysql_query($con_datos_user);
                                $ren_datos = mysql_fetch_array($res_datos);
                                $nombre_ad = $ren_datos["nombre"];
                                $email_ad = $ren_datos["email"];                                
                                if($envio_correo =="smtp")
                                    {
                                        $mail->IsSMTP();
                                        $mail->Host = $servidor_smtp;

                                        $mail->SMTPAuth = true;
                                        $mail->Username = $user_smtp; 
                                        $mail->Password = $pass_smtp; 
                                        $mail->Mailer  = "smtp";
                                    }
                                if($servidor_smtp=="ssl://smtp.gmail.com")
                                    {
                                        $mail->Port = 465;
                                    }
                                $mail->From = $email_ad;
                                $mail->FromName = " ".$nombre_ad." ";
                                $mail->AddAddress($txt_correo_usuario_registrar, 'Nuevo Usuario');
                                $mail->IsHTML(true);
                                $mail->Subject = "Nuevo usuario de: $url_sitio ";
                                $mail->Body ="<strong>Hola $txt_nick_usuario_registrar</strong>
                                <br /><br />
                                $mensaje_nuevo_usuario_vista
                                <br /><br />
                                Nick: $txt_nick_usuario_registrar
                                <br />
                                Password: $txt_password_usuario_a
                                <br /><br />
                                URL de portal:
                                <br /><br />
                                $url_sitio/index.php
                                <br /><br />
                                $mensajeCodigo
                                Atentamente
                                <br /><br />
                                $nombre_ad
                                <br /><br >";
                                if(!$mail->Send())
                                    {
                                        //fallo
                                        header("Location: index.php?sec=$sec&f=n&m=6");
                                    }
                                else 
                                    {
                                        //Todo esta bien
                                        header("Location: index.php?sec=$sec&f=n&m=1");
                                    }
                                        
                            }
                        else
                            {
                                header("Location: index.php?sec=$sec&f=n&m=5");
                            }
                    }                             
		function validar_usuario($sec)
                    {
                        $con_config = "select * from nazep_usuarios_final_config";
                        $res_config = mysql_query($con_config);
                        $config_user = array();
                        while($ren_config=mysql_fetch_array($res_config))
                            {
                                $config_user[$ren_config["nombre_campo"]] = $ren_config["valor_campo"];                                      
                            }					
                        $formularios = (isset($_GET["f"]))?$_GET["f"]:'';


                        if($formularios=='' )
                            {
                                $this->formulario_ingresar_usuarios($config_user,$sec);
                            }
                        else if($formularios=='n' && $config_user["mostrar_registro_publico"]=='si')
                            {                                       
                                $this->formulario_registrar_usuario($config_user,$sec);                                            
                            }
                        else if($formularios=='r' && $config_user["mostrar_recuperar_password"]=='si')
                            {
                                $this->formulario_recuperar_acceso($config_user,$sec);    
                            }
                    }
                private function activarUsuario()
                    {
                        $codigo = $this->escapar_caracteres($_GET["codAct"]);
                        $sql = "select situacion from  nazep_usuarios_final where codigo_seguridad ='$codigo' and situacion='activar' ";
                        $res = mysql_query($sql);
                        $can = mysql_num_rows($res);
                        if($can==1)
                            {
                                $sql2 = "update nazep_usuarios_final set situacion='activo', codigo_seguridad='' 
                                    where codigo_seguridad ='$codigo' and situacion='activar' ";
                                if (mysql_query($sql2))
                                    { 
                                        echo '<div class="divusuarioactivado">Usuario Activado, ya puede ingresar a las secciones protegidas.</div>';
                                    }
                                else
                                    {
                                        echo '<div class="divusuarionoactivado">No se pudo activar el usuario.</div>';
                                    }
                            }
                        else 
                            {
                                echo '<div class="divusuarionoactivado">No existe el registro del codigo</div>';
                            }
                                
                    }                    
		private function enviarNuevoPassword()
                    {
                        $sec = $this->obtenerSeccion();
                        $conexion = $this->conectarse();
                        $con_config = "select * from nazep_usuarios_final_config";
                        $res_config = mysql_query($con_config);
                        $config_user = array();
                        while($ren_config=mysql_fetch_array($res_config))
                            {
                                $config_user[$ren_config["nombre_campo"]] = $ren_config["valor_campo"];                                      
                            }
                        $pasar=true;
                        if($config_user["usar_captcha_google"]=='si')
                            {                               
                                if(file_exists("librerias/recaptcha/recaptchalib.php") && is_readable("librerias/recaptcha/recaptchalib.php"))
                                   {
                                        require_once('librerias/recaptcha/recaptchalib.php');
                                        $sql = "select llave_privada_captcha from nazep_configuracion ";
                                        $resSql = mysql_query($sql);
                                        $renSql = mysql_fetch_array($resSql);
                                        $llavePrivada = $renSql["llave_privada_captcha"];                        
                                        $resp = recaptcha_check_answer ($llavePrivada,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
                                        
                                        if($resp->is_valid)
                                            {   $pasar=true;  }
                                        else
                                            {   $pasar=false; }
                                   }  
                            }                     
                        if($pasar)
                            {
                                $txt_correo_usuario_recuperar  = $this->escapar_caracteres($_POST["txt_correo_usuario_recuperar"]);
                                $sql = "select correo from nazep_usuarios_final where correo = '$txt_correo_usuario_recuperar' and situacion = 'activo' ";

                                $resSql = mysql_query($sql);
                                $canSql = mysql_num_rows($resSql);

                                if($canSql<1)
                                    {
                                        header("Location: index.php?sec=$sec&f=r&m=2");
                                    }
                                else
                                    {
                                        $newPassword ='';
                                        $str = "ABCDEFGHJLMNPQRSTUVWXYZabcdefghijmnpqrstuvwxyz23456789";                                
                                        for($i=0;$i<12;$i++) 
                                            {
                                                $newPassword .= substr($str,rand(0,53),1);
                                            }
                                        $newPasswordmd5 = md5($newPassword);
                                        $sql2 = "update nazep_usuarios_final set pasword ='$newPasswordmd5' where correo = '$txt_correo_usuario_recuperar' ";
                                        if (mysql_query($sql2))
                                            {
                                                require("librerias/phpmailer/class.phpmailer.php");
                                                $mail = new PHPMailer();
                                                $mail->SetLanguage("es","librerias/phpmailer/language/");
                                                $con_conf = "select envio_correo, servidor_smtp, user_smtp, pass_smtp, 
                                                mensaje_nuevo_usuario_vista, url_sitio
                                                from nazep_configuracion ";
                                                $res_con = mysql_query($con_conf);
                                                $ren_con = mysql_fetch_array($res_con);
                                                $envio_correo = $ren_con["envio_correo"];
                                                $servidor_smtp = $ren_con["servidor_smtp"];
                                                $user_smtp = $ren_con["user_smtp"];
                                                $pass_smtp	= $ren_con["pass_smtp"];

                                                $url_sitio = $ren_con["url_sitio"];

                                                $con_datos_user = "select nombre, email from nazep_usuarios_admon where nick_user = 'admin'";
                                                $res_datos = mysql_query($con_datos_user);
                                                $ren_datos = mysql_fetch_array($res_datos);
                                                $nombre_ad = $ren_datos["nombre"];
                                                $email_ad = $ren_datos["email"];                                
                                                if($envio_correo =="smtp")
                                                    {
                                                        $mail->IsSMTP();
                                                        $mail->Host = $servidor_smtp;

                                                        $mail->SMTPAuth = true;
                                                        $mail->Username = $user_smtp; 
                                                        $mail->Password = $pass_smtp; 
                                                        $mail->Mailer  = "smtp";
                                                    }
                                                if($servidor_smtp=="ssl://smtp.gmail.com")
                                                    {
                                                        $mail->Port = 465;
                                                    }
                                                $mail->From = $email_ad;
                                                $mail->FromName = " ".$nombre_ad." ";
                                                $mail->AddAddress($txt_correo_usuario_recuperar, 'Usuario');
                                                $mail->IsHTML(true);
                                                $mail->Subject = "Cambio de Password de: $url_sitio ";
                                                $mail->Body ="<strong>Hola</strong>
                                                <br /><br />
                                                Se realizo un cambio de Password en tu cuenta:
                                                <br /><br />
                                                Nuevo Password: $newPassword
                                                <br /><br />
                                                URL de portal:
                                                <br /><br />
                                                $url_sitio/index.php
                                                <br /><br />

                                                Atentamente
                                                <br /><br />
                                                $nombre_ad
                                                <br /><br >";
                                                if(!$mail->Send())
                                                    {                                                
                                                        header("Location: index.php?sec=$sec&f=r&m=4");
                                                    }
                                                else 
                                                    {
                                                        header("Location: index.php?sec=$sec&f=r&m=1");
                                                    }
                                            }
                                        else
                                            {
                                               header("Location: index.php?sec=$sec&f=r&m=3"); 
                                            }                                
                                    }
                            }
                        else
                            {
                                header("Location: index.php?sec=$sec&f=r&m=5");
                            }
                                
                    }                    
                function formulario_ingresar_usuarios($config_user,$sec)
                    {
                        $texto = '';                                                               
                        $texto .= '<form name="formulario_acceso_vista" id="formulario_acceso_vista" method="post" action="index.php?sec='.$sec.'">';
                            $texto .= '<div class="div_error_login" >';
                                $error_de_usuario = (isset($_GET["error_usuario"])) ?$_GET["error_usuario"]:'';
                                if($error_de_usuario  == 'si')
                                        { $texto .=  '<span class="error_usuario">'.txt_error_acceso_vista.'</span>'; }
                                else
                                        { $texto .=  '&nbsp;'; }
                            $texto .= '</div>';
                            $texto .= '<div class="div_titulo_login_vista">'.txt_titulo_login_vista.'</div>';
                            $texto .= '<div class="div_nick_user_login">';
                                $texto .= '<div class="div_nick_user_a"> '.txt_nick_user_vista.'</div>';
                                $texto .= '<div class="div_nick_user_b"> <input type= "text" name="nick_usuario_vista" id="nick_usuario_vista"  /></div>';
                                $texto .= '<div style="clear:both;"></div>';
                            $texto .= '</div>';	

                            $texto .= '<div class="div_password_user_login">';
                                $texto .= '<div class="div_password_user_login_a">'.txt_pasword_user_vista.'</div>';
                                $texto .= '<div class="div_password_user_login_b"><input type= "password" name="password_usuario_vista" id="password_usuario_vista" /></div>';
                                $texto .= '<div style="clear:both;"></div>';
                            $texto .= '</div>';	

                            $texto .= '<div class="div_boton_login_ingresar">';
                                $texto .= ' <input type="hidden" name="sqlBack" value = "si" />
                                            <input type="hidden" name="validar_vista" value = "si" />
                                            <input type="hidden" name="f" value = "validar" />
                                            <input type="submit" name="Submit" value="'.txt_enviar_user_vista.'" />';
                            $texto .= '</div>';                                        
                        $texto .= '</form>';
                        if($config_user["mostrar_registro_publico"]=='si')
                            {
                                $texto .= '<div id="d_enlace_registrar_usuario" class="div_enlace_registrar_usuario" >';
                                    $texto .= '<a href="index.php?sec='.$sec.'&f=n" class="enlace_registrar_usuario" >';
                                        $texto .= txt_enlace_registrar_usuario;
                                    $texto .= '</a>';	
                                $texto .= '</div>';
                            }
                        if($config_user["mostrar_recuperar_password"]=='si')
                            {
                                $texto .= '<div id="d_enlace_recuperar_password" class="div_enlace_recuperar_password"  >';
                                    $texto .= '<a href="index.php?sec='.$sec.'&f=r" class="enlace_recuperar_password" >';
                                        $texto .= txt_enlace_recuperar_password;
                                    $texto .= '</a>';	
                                $texto .= '</div>';
                            }	
                        echo $texto;
                        unset($texto);
                    }
		function formulario_registrar_usuario($config_user, $sec)
                    {
                        $texto = '';                                
                        $texto .= html::script(array('presentacion'=>'return', 'tipo'=>'ini'));
                            $texto .= '
                                        function validarUsuario(valor)
                                            {                                                               
                                                $.buscarUsuarioRegistrado(valor,"'.$sec.'");
                                            }
                                        function validarCorreo(valor)
                                            {
                                                $.buscarCorreoRegistrado(valor,"'.$sec.'");
                                            }
                                        function validarCaptcha(formulario)
                                            {
                                                if(formulario.recaptcha_response_field.value=="")
                                                    {
                                                        alert("No puedes quedar vac\u00EDo el campo de captcha")
                                                        formulario.recaptcha_response_field.focus();
                                                        return false;
                                                    }
                                                else
                                                    {
                                                        valoruno = formulario.recaptcha_challenge_field.value;
                                                        valordos = formulario.recaptcha_response_field.value;
                                                        $.validarCapcha(formulario, valoruno, valordos, "'.$sec.'")
                                                    }                                                
                                            }
                                        function validarRegistro(formulario)
                                            {
                                       ';
                            if($config_user["usar_correo_como_usuario"]=='no')
                                {
                                    $texto .='
                                                if(formulario.txt_nick_usuario_registrar.value == "") 
                                                    {
                                                        alert("El Nombre de Usuario no puede quedar vac\u00EDo")
                                                        formulario.txt_nick_usuario_registrar.focus();
                                                        return false;
                                                    }
                                                else
                                                    {

                                                        nombre_usario = formulario.txt_nick_usuario_registrar.value;
                                                        var RegExPattern = /([a-zA-Z0-9_-]{4,20})$/;
                                                        var errorMessage = "Nombre de Usuario no valido \nEl nombre tiene que contener de 4 a 12 caracteres \nNO se admiten caracteres raros";
                                                        if(!nombre_usario.match(RegExPattern))
                                                            {
                                                                alert(errorMessage);
                                                                formulario.txt_nick_usuario_registrar.focus();
                                                                return false;												
                                                            }

                                                    }
                                               ';
                                }
                            $texto .= '
                                                if(formulario.txt_correo_usuario_registrar.value == "") 
                                                    {
                                                        alert("El Correo del Usuario no puede quedar vac\u00EDo");
                                                        formulario.txt_correo_usuario_registrar.focus();
                                                        return false;
                                                    }

                                                if(!isEmailAddress(formulario.txt_correo_usuario_registrar.value))
                                                    {
                                                        alert("El Formato de Email es incorrecto");
                                                        formulario.txt_correo_usuario_registrar.focus();
                                                        return false;
                                                    }
                                                if(formulario.txt_usuario_valido.value == "NO")
                                                    {
                                                        alert("El nombre de usuario ya esta registrado, usa otro");
                                                        formulario.txt_usuario_valido.focus();
                                                        return false;
                                                    }
                                        ';
                            if($config_user["usar_correo_como_usuario"]=='no')
                                    {
                                        $texto .='
                                                if(formulario.txt_correo_valido.value == "NO")
                                                    {
                                                        alert("El Correo de usuario ya esta registrado, usa otro");
                                                        formulario.txt_correo_valido.focus();
                                                        return false;
                                                    }                                                
                                                ';
                                    }
                            $texto .= '
                                                if(formulario.txt_password_usuario_a.value == "") 
                                                    {
                                                        alert("La contraseña del Usuario no puede quedar vac\u00EDa")
                                                        formulario.txt_password_usuario_a.focus();
                                                        return false;
                                                    }
                                                if(formulario.txt_password_usuario_b.value == "") 
                                                    {
                                                        alert("La confirmacion de la contraseña del Usuario no puede quedar vac\u00EDa")
                                                        formulario.txt_password_usuario_b.focus();
                                                        return false;
                                                    }
                                                if(formulario.txt_password_usuario_b.value != formulario.txt_password_usuario_a.value ) 
                                                    {
                                                        alert("Los dos campos de contraseñas no coinciden")
                                                        formulario.txt_password_usuario_a.focus();
                                                        return false;
                                                    }
                                                formulario.submit();
                                            }                                                                    
                                      ';
                        $texto .= html::script(array('presentacion'=>'return', 'tipo'=>'fin'));
                        $texto .= '<form name="formulario_registrar_usuario" id="formulario_registrar_usuario" method="post" action="index.php?sec='.$sec.'">';
                                $texto .= '<div class="div_mensaje_registro_user" >';
                                        $mensa_respuesta = (isset($_GET["m"])) ?$_GET["m"]:'';
                                        if($mensa_respuesta  == 1)
                                            { $texto .=  '<span class="mensaje_registro">'.txt_reg_user_men_1.'</span>'; }
                                        elseif($mensa_respuesta  == 2)
                                            { $texto .=  '<span class="mensaje_registro">'.txt_reg_user_men_2.'</span>'; }
                                        elseif($mensa_respuesta  == 3)
                                            { $texto .=  '<span class="mensaje_registro">'.txt_reg_user_men_3.'</span>'; }
                                        elseif($mensa_respuesta  == 4)
                                            { $texto .=  '<span class="mensaje_registro">'.txt_reg_user_men_4.'</span>'; }
                                        elseif($mensa_respuesta  == 5)
                                            { $texto .=  '<span class="mensaje_registro">'.txt_reg_user_men_5.'</span>'; }
                                        elseif($mensa_respuesta  == 6)
                                            { $texto .=  '<span class="mensaje_registro">'.txt_reg_user_men_6.'</span>'; }
                                        elseif($mensa_respuesta  == 7)
                                            { $texto .=  '<span class="mensaje_registro">'.txt_reg_user_men_7.'</span>'; }    
                                        else
                                            { $texto .=  '&nbsp;'; }
                                $texto .= '</div>';	

                                $texto .= '<div class="div_titulo_registro_usuario">'.txt_titulo_registro_usuario.'</div>';

                                $texto .= '<div><input name="txt_usuario_valido" id="txt_usuario_valido" type="hidden" value="NO" />
                                            <input name="registrarNuevoUsuario" id="registrarNuevoUsuario" type="hidden" value="si" />
                                            <input name="sqlBack" id="sqlBack" type="hidden" value="si" />
                                            </div>';
                                if($config_user["usar_correo_como_usuario"]=='no')
                                    {
                                        $texto .= '<div class="div_nick_user_registro">';
                                            $texto .= '<div class="div_nick_user_r_a">'.txt_nick_user_registro.'&nbsp;</div>';
                                            $texto .= '<div class="div_nick_user_r_b"> 
                                                            <input onchange="validarUsuario(this.value)" type= "text" name="txt_nick_usuario_registrar" id="txt_nick_usuario_registrar"  />
                                                       </div>';
                                            $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';
                                        $texto .= ' <div id="div_mensajes_nombre_usuario"></div>';
                                    }
                               else
                                    {
                                        $texto .= '<div class = "div_mensaje_nombre_usuario"> El email se usara como Nombre de Usuario </div>';
                                    }
                                $texto .= '<div class="div_correo_registro">';
                                        $texto .= '<div class="div_correo_r_a"> '.txt_correo_registro.'&nbsp;</div>';

                                        $texto .= '<div class="div_correo_r_b">'; 


                                            if($config_user["usar_correo_como_usuario"]=='si')
                                                {
                                                    $texto .= '<input type= "text" onchange="validarUsuario(this.value)" name="txt_correo_usuario_registrar" id="txt_correo_usuario_registrar"  />';
                                                    $texto .= '</div>';
                                                    $texto .= '<div style="clear:both;"></div>';
                                                    $texto .= '<div id="div_mensajes_nombre_usuario"></div>';
                                                }
                                            elseif($config_user["usar_correo_como_usuario"]=='no')
                                                {
                                                    $texto .= '<input type= "text" onchange="validarCorreo(this.value)" name="txt_correo_usuario_registrar" id="txt_correo_usuario_registrar"  />';
                                                    $texto .= '</div>';
                                                    $texto .= '<div style="clear:both;"></div>';
                                                    $texto .= '<input name="txt_correo_valido" id="txt_correo_valido" type="hidden" value="NO" />';
                                                    $texto .= '<div id="div_mensajes_correo"></div>';
                                                }

                                $texto .= '</div>';

                                $texto .= '<div class="div_password_registro_a">';
                                        $texto .= '<div class="div_password_registro_a_a"> '.txt_password_a.'&nbsp;</div>';

                                        $texto .= '<div class="div_password_registro_a_b"> 
                                                        <input type= "password" name="txt_password_usuario_a" id="txt_password_usuario_a"  />
                                                    </div>';
                                        $texto .= '<div style="clear:both;"></div>';
                                $texto .= '</div>';						

                                $texto .= '<div class="div_password_registro_b">';
                                        $texto .= '<div class="div_password_registro_b_a"> '.txt_password_b.'&nbsp;</div>';
                                        $texto .= '<div class="div_password_registro_b_b"> 
                                                        <input type= "password" name="txt_password_usuario_b" id="txt_password_usuario_b"  />
                                                    </div>';
                                        $texto .= '<div style="clear:both;"></div>';
                                $texto .= '</div>';

                                if($config_user["pedir_nombre"]=='si')
                                    {
                                        $texto .= '<div class="div_nombre_usuario">';
                                                $texto .= '<div class="div_nombre_usuario_a"> '.txt_nombre_usuario.'&nbsp;</div>';

                                                $texto .= '<div class="div_nombre_usuario_b"> 
                                                                <input type= "text" name="txt_nombre_usuario" id="txt_nombre_usuario"  />
                                                           </div>';
                                                $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';
                                    }
                                if($config_user["pedir_ape_p"]=='si')
                                    {
                                        $texto .= '<div class="div_ape_p_usuario">';
                                                $texto .= '<div class="div_ape_p_usuario_a"> '.txt_apellido_p_usuario.'&nbsp;</div>';

                                                $texto .= '<div class="div_nombre_usuario_b"> 
                                                                <input type= "text" name="txt_apellido_p_usuario" id="txt_apellido_p_usuario"  />
                                                           </div>';
                                                $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';
                                    }                                            
                                if($config_user["pedir_ape_m"]=='si')
                                    {
                                        $texto .= '<div class="div_ape_m_usuario">';
                                                $texto .= '<div class="div_ape_m_usuario_a"> '.txt_apellido_m_usuario.'&nbsp;</div>';

                                                $texto .= '<div class="div_ape_m_usuario_b"> 
                                                                <input type= "text" name="txt_apellido_m_usuario" id="txt_apellido_m_usuario"  />
                                                           </div>';
                                                $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';
                                    }                                                
                                if($config_user["pedir_fecha_nacimiento"]=='si')
                                    {
                                        $texto .= '<div class="div_fecha_nacimiento_usuario">';

                                                $texto .= '<div class="div_fecha_nacimiento_usuario_a">'.txt_fecha_nacimiento_usuario.'&nbsp;</div>';

                                                $texto .= '<div class="div_fecha_nacimiento_usuario_b"> ';

                                                    $dia=date('d');
                                                    $mes=date('m');
                                                    $ano=date('Y');                                                        
                                                    $areglo_meses = FunGral::MesesNumero();
                                                    $texto .=  dia.'&nbsp;<select name = "dia_n">';
                                                    for ($a = 1; $a<=31; $a++)
                                                            {$texto .=  '<option value = "'.$a.'" '; if ($dia == $a) { $texto .=  'selected="selected"'; } $texto .=  ' > '.$a.' </option>';}
                                                    $texto .=  '</select>&nbsp;';
                                                    $texto .=  mes.'&nbsp;<select name = "mes_n">';
                                                    for ($b=1; $b<=12; $b++)
                                                            {$texto .=  '<option value = "'.$b.'"  '; if ($mes == $b) {$texto .=  ' selected="selected" ';} $texto .=  ' >'.$areglo_meses[$b].'</option>';}
                                                    $texto .=  '</select>&nbsp;';
                                                    $texto .=  ano.'&nbsp;<select name = "ano_n">';
                                                    for ($b=$ano-10; $b<=$ano+10; $b++)
                                                            {$texto .=  '<option value = "'.$b.'" '; if ($ano == $b) {$texto .=  ' selected="selected" ';} $texto .=  '>'.$b.'</option>';}
                                                    $texto .=  '</select>';
                                                $texto .= '</div>';                                                                  
                                                $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';

                                    }
                                if($config_user["pedir_ubicacion"]=='si')
                                    {
                                        $texto .= '<div class="div_ubicacion_usuario">';
                                                $texto .= '<div class="div_ubicacion_usuario_a"> '.txt_ubicacion_usuario.'&nbsp;</div>';

                                                $texto .= '<div class="div_ubicacion_usuario_b"> 
                                                                <input type= "text" name="txt_ubicacion_usuario" id="txt_ubicacion_usuario"  />
                                                           </div>';
                                                $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';
                                    }
                                if($config_user["pedir_web"]=='si')
                                    {
                                        $texto .= '<div class="div_web_usuario">';
                                                $texto .= '<div class="div_web_usuario_a"> '.txt_web_usuario.'&nbsp;</div>';

                                                $texto .= '<div class="div_web_usuario_b"> 
                                                                <input type= "text" name="txt_web_usuario" id="txt_web_usuario"  />
                                                           </div>';
                                                $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';
                                    } 
                                if($config_user["pedir_zona_horaria"]=='si')
                                    {
                                        $texto .= '<div class="div_zona_horaria">';
                                            $texto .= '<div class="div_zona_horaria_a"> '.txt_zona_horaria_usuario.'&nbsp;</div>';

                                            $texto .= '<div class="div_zona_horaria_b">'; 
                                                $texto .= '<select name = "zona_horario_usuario"  >';
                                                for ($b=-12; $b<=12; $b++)
                                                        { $texto .= '<option value = "'.$b.'"  '; if ($b == "0") {$texto .= 'selected= "selected" ';} $texto .= ' >'.$b.'</option>'; }
                                                $texto .= '</select>';
                                            $texto .= '</div>';
                                            $texto .= '<div style="clear:both;"></div>';
                                        $texto .= '</div>';
                                    }
                                if($config_user["usar_captcha_google"]=='si')
                                    {
                                        $texto .= '<div class="div_recapcha">';
                                        if(file_exists("librerias/recaptcha/recaptchalib.php") && ("librerias/recaptcha/recaptchalib.php"))
                                            {
                                                require_once('librerias/recaptcha/recaptchalib.php');
                                                $sql = "select llave_publica_captcha from nazep_configuracion ";
                                                $resSql = mysql_query($sql);
                                                $renSql = mysql_fetch_array($resSql);
                                                $llave_publica_captcha = $renSql["llave_publica_captcha"];                                                                                              
                                                $texto .= recaptcha_get_html($llave_publica_captcha);
                                                $texto .= '<div class="div_mensaje_captcha" id="div_mensaje_captcha"></div>';
                                            }
                                        else
                                            {
                                                $texto .= 'No se puede cargar el sistema Capcha';
                                            }                                                                                  
                                        $texto .= '</div>';
                                        $texto .= '<div class="div_boton_registrar_usuario" > 
                                            <input type="button" value="Registrar Usuario" onclick= "return validarCaptcha(this.form)" > 
                                            </div>';
                                    }
                                else 
                                    {
                                        $texto .= '<div class="div_boton_registrar_usuario" > 
                                            <input type="button" value="Registrar Usuario" onclick= "return validarRegistro(this.form)" > 
                                            </div>';
                                    }

                                
                        $texto .= '</form>';
                        $texto .= '<div class="div_enlace_regreso_acceso" ><a href="index.php?sec='.$sec.'">Regresar Formulario de Ingreso</a></div> ';
                        echo $texto;							
                    }
		function formulario_recuperar_acceso($config_user, $sec)
                    {
                        $sec = $this->obtenerSeccion();
                        $texto ='';
                        $texto .= html::script(array('presentacion'=>'return', 'tipo'=>'ini'));
                        $texto .= '
                            function validarCorreo(formulario)
                                {
                                    if(formulario.txt_correo_usuario_recuperar.value == "") 
                                        {
                                            alert("El Correo del Usuario no puede quedar vac\u00EDo");
                                            formulario.txt_correo_usuario_recuperar.focus();
                                            return false;
                                        }
                                    if(!isEmailAddress(formulario.txt_correo_usuario_recuperar.value))
                                        {
                                            alert("El Formato de Email es incorrecto");
                                            formulario.txt_correo_usuario_recuperar.focus();
                                            return false;
                                        }
                                    if(formulario.recaptcha_response_field.value=="")
                                        {
                                            alert("No puedes quedar vac\u00EDo el campo de captcha")
                                            formulario.recaptcha_response_field.focus();
                                            return false;
                                        }                                        
                                }';                        
                        $texto .= html::script(array('presentacion'=>'return', 'tipo'=>'fin'));                                    
                        $texto .= '<div class="div_mensaje_nuevo_pass" >';
                                $mensa_respuesta = (isset($_GET["m"])) ?$_GET["m"]:'';
                                if($mensa_respuesta  == 1)
                                    { $texto .=  '<span class="mensaje_registro">'.txt_nue_pass_men_1.'</span>'; }
                                elseif($mensa_respuesta  == 2)
                                    { $texto .=  '<span class="mensaje_registro">'.txt_nue_pass_men_2.'</span>'; }
                                elseif($mensa_respuesta  == 3)
                                    { $texto .=  '<span class="mensaje_registro">'.txt_nue_pass_men_3.'</span>'; }
                                elseif($mensa_respuesta  == 4)
                                    { $texto .=  '<span class="mensaje_registro">'.txt_nue_pass_men_4.'</span>'; }
                                elseif($mensa_respuesta  == 5)
                                    { $texto .=  '<span class="mensaje_registro">'.txt_nue_pass_men_5.'</span>'; }                                    
                                else
                                    { $texto .=  '&nbsp;'; }
                        $texto .= '</div>';                                    
                        $texto .= '<form name="formulario_generar_nuevo_password" id="formulario_generar_nuevo_password" method="post" action="index.php?sec='.$sec.'">';
                            $texto .= '<div>Formulario para recuperar Contraseña</div>';
                            $texto .= '<div>';
                                $texto .= 'Ingresar tu dirección de correo electronico de tu usuario';
                            $texto .= '</div>';
                            $texto .= '<div>';
                                $texto .= '<input type= "text"  name="txt_correo_usuario_recuperar" id="txt_correo_usuario_recuperar"  />';
                            $texto .= '</div>';
                            
                            if($config_user["usar_captcha_google"]=='si')
                                {
                                    $texto .= '<div class="div_recapcha">';
                                    if(file_exists("librerias/recaptcha/recaptchalib.php") && ("librerias/recaptcha/recaptchalib.php"))
                                        {
                                            require_once('librerias/recaptcha/recaptchalib.php');
                                            $sql = "select llave_publica_captcha from nazep_configuracion ";
                                            $resSql = mysql_query($sql);
                                            $renSql = mysql_fetch_array($resSql);
                                            $llave_publica_captcha = $renSql["llave_publica_captcha"];                                                                                              
                                            $texto .= recaptcha_get_html($llave_publica_captcha);
                                            $texto .= '<div class="div_mensaje_captcha" id="div_mensaje_captcha"></div>';
                                        }
                                    else
                                        {
                                            $texto .= 'No se puede cargar el sistema Capcha';
                                        }                                                                                  
                                    $texto .= '</div>';
                                }                            
                            
                            $texto .= '<div>';
                                $texto .= ' <input type="submit" onclick= "return validarCorreo(this.form)" value="Generar Nuevo Password"  >
                                            <input type="hidden" name="sqlBack" value = "si" />
                                            <input type="hidden" name="nuevopassword" value = "si" />';
                            $texto .= '</div>';
                            $texto .= '<div class="div_enlace_regreso_acceso" ><a href="index.php?sec='.$sec.'">Regresar Formulario de Ingreso</a></div> ';                            
                        $texto .= '</form>';
                        echo $texto;
                    }			
		function firma()
			{
				echo '
<!--
// ***************************************************************
// ********************** NAZEP **********************************
// *** Administrador de Contenidos Web ***
// *** Sitio Web : http://www.nazep.com.mx ***
// *** V 0.2 ***
// ***************************************************************
-->';
			}
		function cuerpo()
			{
                            if(isset($_GET["error"]))
                                    { $variable_error = $_GET["error"]; }
                            else
                                    { $variable_error = ''; }
                            if(!isset($_GET["sec"]) || $_GET["sec"]=='')
                                {$sec = 1;}
                            else
                                { $sec = $_GET["sec"]; }         

                            if(!isset($_GET["formato"]) || $_GET["formato"]=='')
                                    {$formato = "html";}
                            else
                                    {$formato = $_GET["formato"];}
                            $nick_usuario = $this->nick_user;
                            $conexion = $this->conectarse();
                            $con_tema = "select t.ubicacion, c.lenguaje, c.titu_sitio, c.palabras_clave, c.pie_sitio, c.url_sitio  from nazep_configuracion c, nazep_temas t where c.clave_tema = t.clave_tema";
                            $res_con = mysql_query($con_tema);
                            $ren_con = mysql_fetch_array($res_con);
                            $ubicacion = $ren_con["ubicacion"];	
                            $lenguaje  = $ren_con["lenguaje"];
                            $pie_sitio = $ren_con["pie_sitio"];
                            $url_sitio = $ren_con["url_sitio"];
                            $lenguaje_primario = "librerias/temas/$ubicacion"."/len_".$lenguaje.".php";
                            $titu_sitio  = $ren_con["titu_sitio"];	
                            $palabras_clave = $ren_con["palabras_clave"];
                            $this->desconectarse($conexion);
                            $dir_tem = 'librerias/temas/';
                            $ubicacion_tema = $dir_tem.$ubicacion.'/';
                            $cabeza_html = $dir_tem.$ubicacion.'/cabeza_html.php';
                            $estilo_css =  $dir_tem.$ubicacion.'/estilos.css';
                            $favicon = $dir_tem.$ubicacion.'/image/favicon.ico'; 
                            $cabeza = $dir_tem.$ubicacion.'/cabeza.php';
                            $cuerpo = $dir_tem.$ubicacion.'/cuerpo.php';
                            $cuerpo_redirecion = $dir_tem.$ubicacion.'/cuerpo_redireccion.php';
                            $cuerpo_print = $dir_tem.$ubicacion.'/cuerpo_print.php';
                            $cuerpo_xml = $dir_tem.$ubicacion.'/cuerpo_xml.php';
                            $pie = $dir_tem.$ubicacion.'/pie.php';
                            $pie_html = $dir_tem.$ubicacion.'/pie_html.php';
                            $xml_version = '<?xml version="1.0" encoding="utf-8"?>';
                            $existencia = false;
                            if (!is_numeric($sec))
                                {
                                    $existencia==false;
                                    $sec=1;
                                }
                            else
                                { $existencia = $this->existencia_seccion($sec); }			
                            if($variable_error!= "")
                                {
                                    $conexion = $this->conectarse();
                                    $cuerpo = $dir_tem.$ubicacion.'/cuerpo_error.php';
                                    include($lenguaje_primario);
                                    echo $xml_version;
                                    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
                                    include($cabeza_html);			
                                    include($cabeza);
                                    include($cuerpo);
                                    include($pie);	
                                    include($pie_html);	
                                    $this->firma();
                                    $this->desconectarse($conexion);
                                }
                            else
                                {
                                    if($existencia)
                                        {								
                                            if($formato=='html')
                                                    {
                                                        if(isset($_POST["sqlBack"]) && $_POST["sqlBack"]=='si')
                                                            {
                                                                $this->slqBack();
                                                            }
                                                        elseif(isset($_POST["redireccion"]) && $_POST["redireccion"]=='si')
                                                            {    
                                                                include($cuerpo_redirecion);                                                                                             
                                                            }                                                            
                                                        else
                                                            {
                                                                include($lenguaje_primario);
                                                                echo $xml_version;
                                                                echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';						
                                                                include($cabeza_html);			
                                                                include($cabeza);
                                                                if(isset($_GET["codAct"]) && $_GET["codAct"]!='')
                                                                    { $this->activarUsuario();  }
                                                                include($cuerpo);
                                                                include($pie);	
                                                                include($pie_html);	
                                                                $this->firma();
                                                            }
                                                    }
                                            elseif($formato=="print")
                                                    {
                                                        include($lenguaje_primario);
                                                        echo $xml_version;
                                                        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
                                                        include($cabeza_html);
                                                        include($cuerpo_print);
                                                        include($pie_html);
                                                        $this->firma();
                                                    }
                                            elseif($formato=="xml")
                                                    {
                                                        header('Content-Type: text/xml');
                                                        echo '<?xml version="1.0" encoding="utf-8"?>';
                                                        include($cuerpo_xml);
                                                    }									
                                        }
                                    else
                                        {
                                            $conexion = $this->conectarse();
                                            $variable_error = '404';
                                            $cuerpo = $dir_tem.$ubicacion.'/cuerpo_error.php';
                                            include($lenguaje_primario);
                                            echo $xml_version;
                                            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
                                            include($cabeza_html);			
                                            include($cabeza);
                                            include($cuerpo);
                                            include($pie);	
                                            include($pie_html);	
                                            $this->firma();
                                            $this->desconectarse($conexion);
                                        }
                                }
				
			}
//************************************************************************ INICIO FUNCIONES PARA MULTIPLES USOS **************************************************************
		function enlace_imprimir($texto, $ventana)
			{
				if(isset($_SERVER['REQUEST_URI']))
					{ $direccion = $_SERVER['REQUEST_URI']; }
				else
					{
						$direccion = '/index/index.php';
					}
				$direccion_temporal = explode("?", $direccion);
				if(!isset($direccion_temporal[1]) || $direccion_temporal[1] == '')
					{
						if($direccion_temporal[0]=="/index/")
							{ $cadena_print = "index.php?formato=print"; }
						else
							{ $cadena_print = "?formato=print"; }
					}
				else
					{
						$cadena_print = "&amp;formato=print";
					}
				$direccion_print = $direccion.$cadena_print;
				echo '<a class="enlace_imprimir" href="'.$direccion_print.'"  target="'.$ventana.'" >'.$texto.'</a>';
			}
		function enlace_imprimir_imagen($imagen, $texto, $ventana, $alt, $titulo)	
			{
				$direccion = $_SERVER['REQUEST_URI'];
				$direccion_temporal = explode("?", $direccion);
				if(!isset($direccion_temporal[1]) || $direccion_temporal[1] == '')
					{
						if($direccion_temporal[0]=="/index/")
							{ $cadena_print = "index.php?formato=print"; }
						else
							{ $cadena_print = "?formato=print"; }
					}
				else
					{
						$cadena_print = "&amp;formato=print";
					}
				$direccion_print = $direccion.$cadena_print;
				echo '<a class="enlace_imprimir" href="'.$direccion_print.'"  target="'.$ventana.'"  >';
					echo '<img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /> '.$texto;
				echo '</a>';
			}
		function clave_seccion_recomendar()
                    {
                        $conexion = $this->conectarse();
                        $con_sec = "select clave_recomendar from nazep_configuracion";
                        $res_sec = mysql_query($con_sec);
                        $ren_sec = mysql_fetch_array($res_sec);
                        $clave_recomendar = $ren_sec["clave_recomendar"];
                        $this->desconectarse($conexion);
                        return $clave_recomendar;                            
                    }		
		function enlace_recomendar($sec, $texto)
                    {
                        $conexion = $this->conectarse();
                        $con_sec = "select clave_recomendar from nazep_configuracion";
                        $res_sec = mysql_query($con_sec);
                        $ren_sec = mysql_fetch_array($res_sec);
                        $clave_recomendar = $ren_sec["clave_recomendar"];
                        echo '<a class="enlace_recomendar" href="index.php?sec='.$clave_recomendar.'&amp;recomendar=si">'.$texto.'</a>';
                        $this->desconectarse($conexion);
                    }
		function enlace_recomendar_imagen($sec, $imagen, $texto, $alt, $titulo)
                    {
                        $conexion = $this->conectarse();
                        $con_sec = "select clave_recomendar from nazep_configuracion";
                        $res_sec = mysql_query($con_sec);
                        $ren_sec = mysql_fetch_array($res_sec);
                        $clave_recomendar = $ren_sec["clave_recomendar"];
                        $direccion = $_SERVER['REQUEST_URI'];
                        echo '<a class="enlace_recomendar" href="index.php?sec='.$clave_recomendar.'&amp;direccion='.$direccion.'&amp;clave_seccion_recomendar='.$sec.'">';
                                echo '<img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /> '.$texto.'</a>';
                        $this->desconectarse($conexion);
                    }
		function clave_seccion_buscador()
                    {
                        $conexion = $this->conectarse();
                        $con_sec = "select clave_buscador from nazep_configuracion";
                        $res_sec = mysql_query($con_sec);
                        $ren_sec = mysql_fetch_array($res_sec);
                        $clave_buscador = $ren_sec["clave_buscador"];
                        return $clave_buscador;
                        $this->desconectarse($conexion);
                    }
		function enlace_buscador($texto)
                    {
                        $conexion = $this->conectarse();
                        $con_sec = "select clave_buscador from nazep_configuracion";
                        $res_sec = mysql_query($con_sec);
                        $ren_sec = mysql_fetch_array($res_sec);
                        $clave_buscador = $ren_sec["clave_buscador"];
                        echo '<a class="enlace_buscador" href="index.php?sec='.$clave_buscador.'" >'.$texto.'</a>';
                        $this->desconectarse($conexion);
                    }
		function enlace_buscador_imagen($imagen, $alt, $titulo)
                    {
                        $conexion = $this->conectarse();
                        $con_sec = "select clave_buscador from nazep_configuracion";
                        $res_sec = mysql_query($con_sec);
                        $ren_sec = mysql_fetch_array($res_sec);
                        $clave_buscador = $ren_sec["clave_buscador"];
                        echo '<a class="enlace_buscador" href="index.php?sec='.$clave_buscador.'" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
                        $this->desconectarse($conexion);
                    }
		function clave_seccion_mapa_sitio()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_mapa_sitio from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_mapa_sitio = $ren_sec["clave_mapa_sitio"];
                                $this->desconectarse($conexion);
				return $clave_mapa_sitio;                                
			}
		function enlace_mapa_sitio($texto)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_mapa_sitio from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_mapa_sitio = $ren_sec["clave_mapa_sitio"];
				echo '<a class="enlace_al_mapa_sitio" href="index.php?sec='.$clave_mapa_sitio.'" >'.$texto.'</a>';
                                $this->desconectarse($conexion);
			}
		function enlace_mapa_sitio_imagen($imagen, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_mapa_sitio from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_mapa_sitio = $ren_sec["clave_mapa_sitio"];
				echo '<a class="enlace_al_mapa_sitio" href="index.php?sec='.$clave_mapa_sitio.'" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
                                $this->desconectarse($conexion);
			}
		function clave_seccion_contacto()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_contacto from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_contacto = $ren_sec["clave_contacto"];
                                $this->desconectarse($conexion);
				return $clave_contacto;
			}
		function enlace_contacto($texto)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_contacto from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_contacto = $ren_sec["clave_contacto"];
				echo '<a class="enlace_contacto" href="index.php?sec='.$clave_contacto.'" >'.$texto.'</a>';
                                $this->desconectarse($conexion);
			}
		function enlace_contacto_imagen($imagen, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_contacto from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);
				$clave_contacto = $ren_sec["clave_contacto"];
				echo '<a class="enlace_contacto" href="index.php?sec='.$clave_contacto.'" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
                                $this->desconectarse($conexion);
			}	
		function clave_seccion_rss()
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_rss from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);		
				$clave_rss = $ren_sec["clave_rss"];
                                $this->desconectarse($conexion);
				return $clave_rss;
			}
		function enlace_rss_principal($imagen, $texto, $tipo, $alt, $titulo)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_rss from nazep_configuracion";
				$res_sec = mysql_query($con_sec);
				$ren_sec = mysql_fetch_array($res_sec);		
				$clave_rss = $ren_sec["clave_rss"];
				echo '<a class="enlace_rss" href="index.php?sec='.$clave_rss.'" >';
					if($tipo=="imagen")
						{ echo '<img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" />'; }
					elseif($tipo=="texto")
						{ echo $texto; }						
				echo '</a>';
                                $this->desconectarse($conexion);
			}			
		function enlace_inicio($texto)
			{
				echo '<a class="enlace_inicio" href="index.php" >'.$texto.'</a>';
			}
		function enlace_inicio_imagen($imagen, $alt, $titulo)
			{
				echo '<a class="enlace_inicio" href="index.php" ><img src= "'.$imagen.'" alt ="'.$alt.'" title="'.$titulo.'" border= "0" /></a>';
			}
		function listar_mod_central_horizontal($sec, $ubicacion_tema, $nick_usuario, $modo, $inico, $fin)
			{
				$conexion = $this->conectarse();
				$hoy = date('Y-m-d');
				$con_modulo = "select m.nombre_archivo, m.clave_modulo
				from nazep_secciones_modulos sm, nazep_modulos m 
				where m.tipo = 'central' and clave_seccion = '$sec'
				and (
				case sm.usar_vigencia_mod 
				when 'si'
				then
					sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
					1
				end)				
				and sm.situacion = 'activo'
				and sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy' 
				and sm.clave_modulo = m.clave_modulo order by sm.orden
				limit $inico, $fin";
				$res_mod = mysql_query($con_modulo);
				if($modo == 'html')
					{
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							echo '<tr>';
								while($ren_mod = mysql_fetch_array($res_mod))
									{
										echo '<td>';
											$nombre_archivo = $ren_mod["nombre_archivo"];
											$clave_modulo = $ren_mod["clave_modulo"];
											$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
											if(is_readable($archivo))
												{
													include_once($archivo);
													$clase = 'clase_'.$nombre_archivo;
													if(FunGral::validarClaseMetodoVista($clase,'vista'))
														{
															$obj_v = new $clase();
															$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
														}
												}
											else
												{
													HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
												}
										echo '</td>';
									}
							echo'</tr>';
						echo '</table>';
					}
				elseif($modo == 'print')
					{
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							echo '<tr>';
								while($ren_mod = mysql_fetch_array($res_mod))
									{
										echo '<td align="center" valign="top" >';
											$nombre_archivo = $ren_mod["nombre_archivo"];
											$clave_modulo = $ren_mod["clave_modulo"];
											$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
											if(is_readable($archivo))
												{
													include_once($archivo);
													$clase = 'clase_'.$nombre_archivo;
													if(FunGral::validarClaseMetodoVista($clase,'vista_print'))
														{
															$obj_v = new $clase();
															$obj_v->vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
														}
												}
											else
												{
													HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
												}
										echo '</td>';
									}
							echo'</tr>';
						echo '</table>';
					}			
				elseif($modo == 'redireccion')
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
								if(is_readable($archivo))
									{
										include_once($archivo);
										$clase = 'clase_'.$nombre_archivo;
										if(FunGral::validarClaseMetodoVista($clase,'vista_redireccion'))
											{
												$obj_v = new $clase();
												$obj_v->vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
											}
									}
								else
									{
										HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
									}
							}
					}
				elseif($modo == 'xml')
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
								if(is_readable($archivo))
									{
										include_once($archivo);
										$clase = 'clase_'.$nombre_archivo;
										if(FunGral::validarClaseMetodoVista($clase,'vista_xml'))
											{
												$obj_v = new $clase();
												$obj_v->vista_xml($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
											}
									}
								else
									{
										HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
									}
							}
					}
                            $this->desconectarse($conexion);
			}
		function listar_mod_central($sec, $ubicacion_tema, $nick_usuario, $modo)
			{
				$conexion = $this->conectarse();
				$hoy = date('Y-m-d');
				$con_modulo = "select m.nombre_archivo, m.clave_modulo
				from nazep_secciones_modulos sm, nazep_modulos m 
				where m.tipo = 'central' and clave_seccion = '$sec'
				and sm.situacion = 'activo'			
				and (
				case sm.usar_vigencia_mod 
				when 'si'
				then
					sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
					1
				end) 
				and sm.clave_modulo = m.clave_modulo 
				order by sm.orden";
				$res_mod = mysql_query($con_modulo);
				if($modo == "html")
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
								if(is_readable($archivo))
									{
										include_once($archivo);
										$clase = 'clase_'.$nombre_archivo;
										if(FunGral::validarClaseMetodoVista($clase,'vista'))
											{
												$obj_v = new $clase();
												$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
											}
									}
								else
									{
										HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
									}
							}
					}
				elseif($modo == 'print')
					{
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							while($ren_mod = mysql_fetch_array($res_mod))
								{		
									echo '<tr>';
										echo '<td align="center" valign="top" >';
											$nombre_archivo = $ren_mod["nombre_archivo"];
											$clave_modulo = $ren_mod["clave_modulo"];
											$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
											if(is_readable($archivo))
												{
													include_once($archivo);
													$clase = 'clase_'.$nombre_archivo;
													if(FunGral::validarClaseMetodoVista($clase,'vista_print'))
														{
															$obj_v = new $clase();
															$obj_v->vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
														}
												}
											else
												{
													HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
												}
										echo '</td>';
									echo'</tr>';
								}
						echo '</table>';
					}
				elseif($modo == 'redireccion')
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
								if(is_readable($archivo))
									{
										include_once($archivo);
										$clase = 'clase_'.$nombre_archivo;
										if(FunGral::validarClaseMetodoVista($clase,'vista_redireccion'))
											{
												$obj_v = new $clase();
												$obj_v->vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
											}
									}
								else
									{
										HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
									}
							}
					}
				elseif($modo == 'xml')
					{
						while($ren_mod = mysql_fetch_array($res_mod))
							{
								$nombre_archivo = $ren_mod["nombre_archivo"];
								$clave_modulo = $ren_mod["clave_modulo"];
								$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
								if(is_readable($archivo))
									{
										include_once($archivo);
										$clase = 'clase_'.$nombre_archivo;
										if(FunGral::validarClaseMetodoVista($clase,'vista_xml'))
											{
												$obj_v = new $clase();
												$obj_v->vista_xml($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
											}
									}
								else
									{
										HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
									}
							}
					}
                            $this->desconectarse($conexion);
			}
		function listar_mod_central_div($sec, $ubicacion_tema, $nick_usuario, $modo)
			{
                            $paso=false;
                            $protegida = $this->seccion_protegida($sec);
                            if($protegida == 'no')
                                {
                                    $paso = true;
                                }
                            else
                                {
                                    if($this->registro =="no")
                                        {                                            
                                            $this->validar_usuario($sec);
                                            $paso=false;
                                        }
                                    else
                                        {
                                            $paso=true;
                                        }
                                }                                                                                                       
                            if($paso)
                                {
                                    $conexion = $this->conectarse();
                                    $hoy = date('Y-m-d');
                                    $con_modulo = "select m.nombre_archivo, m.clave_modulo
                                    from nazep_secciones_modulos sm, nazep_modulos m 
                                    where m.tipo = 'central' and clave_seccion = '$sec'
                                    and sm.situacion = 'activo'			
                                    and (
                                    case sm.usar_vigencia_mod 
                                    when 'si'
                                    then
                                            sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
                                    else
                                            1
                                    end) 
                                    and sm.clave_modulo = m.clave_modulo 
                                    order by sm.orden";
                                    $res_mod = mysql_query($con_modulo);
                                    if($modo == 'html')
                                            {
                                                    while($ren_mod = mysql_fetch_array($res_mod))
                                                            {
                                                                    $nombre_archivo = $ren_mod["nombre_archivo"];
                                                                    $clave_modulo = $ren_mod["clave_modulo"];
                                                                    $archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
                                                                    if(is_readable($archivo))
                                                                            {
                                                                                    include_once($archivo);
                                                                                    $clase = 'clase_'.$nombre_archivo;
                                                                                    if(FunGral::validarClaseMetodoVista($clase,'vista'))
                                                                                            {
                                                                                                    $obj_v = new $clase();
                                                                                                    $obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
                                                                                            }
                                                                            }
                                                                    else
                                                                            {
                                                                                    HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
                                                                            }
                                                            }
                                            }
                                    elseif($modo == 'print')
                                            {
                                                    while($ren_mod = mysql_fetch_array($res_mod))
                                                            {		
                                                                    $nombre_archivo = $ren_mod["nombre_archivo"];
                                                                    $clave_modulo = $ren_mod["clave_modulo"];
                                                                    $archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
                                                                    if(is_readable($archivo))
                                                                            {
                                                                                    include_once($archivo);
                                                                                    $clase = 'clase_'.$nombre_archivo;
                                                                                    if(FunGral::validarClaseMetodoVista($clase,'vista_print'))
                                                                                            {
                                                                                                    $obj_v = new $clase();
                                                                                                    $obj_v->vista_print($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
                                                                                            }
                                                                            }
                                                                    else
                                                                            {
                                                                                    HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
                                                                            }
                                                            }
                                            }
                                    elseif($modo == 'redireccion')
                                            {
                                                    while($ren_mod = mysql_fetch_array($res_mod))
                                                            {
                                                                    $nombre_archivo = $ren_mod["nombre_archivo"];
                                                                    $clave_modulo = $ren_mod["clave_modulo"];
                                                                    $archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
                                                                    if(is_readable($archivo))
                                                                            {
                                                                                    include_once($archivo);
                                                                                    $clase = 'clase_'.$nombre_archivo;
                                                                                    if(FunGral::validarClaseMetodoVista($clase,'vista_redireccion'))
                                                                                            {
                                                                                                    $obj_v = new $clase();
                                                                                                    $obj_v->vista_redireccion($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
                                                                                            }
                                                                            }
                                                                    else
                                                                            {
                                                                                    HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
                                                                            }
                                                            }
                                            }
                                    elseif($modo == 'xml')
                                            {
                                                    while($ren_mod = mysql_fetch_array($res_mod))
                                                            {
                                                                    $nombre_archivo = $ren_mod["nombre_archivo"];
                                                                    $clave_modulo = $ren_mod["clave_modulo"];

                                                                    $archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
                                                                    if(is_readable($archivo))
                                                                            {
                                                                                    include_once($archivo);
                                                                                    $clase = 'clase_'.$nombre_archivo;
                                                                                    if(FunGral::validarClaseMetodoVista($clase,'vista_xml'))
                                                                                            {
                                                                                                    $obj_v = new $clase();
                                                                                                    $obj_v->vista_xml($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
                                                                                            }
                                                                            }
                                                                    else
                                                                            {
                                                                                    HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
                                                                            }
                                                            }
                                            }
                                }			
			}
		function listar_mod_secundarios_vert_tabla($sec, $lado, $ancho_tabla)
			{
				$hoy = date('Y-m-d');	
				$con_mod_alt = "select m.nombre_archivo, m.clave_modulo
				from nazep_modulos m, nazep_secciones_modulos sm
				where sm.clave_seccion = '$sec' and sm.situacion = 'activo'
				and (case sm.usar_vigencia_mod 
				when 'si'
				then
				sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
				1
				end) 
				and m.tipo = 'secundario' and sm.posicion = '$lado'
				and sm.clave_modulo = m.clave_modulo
				order by sm.orden";
				$res_mod_alt = mysql_query($con_mod_alt);
				$cantidad_modulos = mysql_num_rows($res_mod_alt);
				
				if($cantidad_modulos!="0")
					{
						echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
						$con = 1;
						while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
							{
								echo'<tr>';
									echo '<td align= "center" >';
										$nombre_archivo = $ren_mod_alt["nombre_archivo"];
										$clave_modulo = $ren_mod_alt["clave_modulo"];
										$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
										if(is_readable($archivo))
											{
												include_once($archivo);
												$clase = 'clase_'.$nombre_archivo;
												if(FunGral::validarClaseMetodoVista($clase,'vista'))
													{
														$obj_v = new $clase();
														$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
													}
											}
										else
											{
												HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
											}
									echo '</td>';
								echo'</tr>';
								
								if($con<$cantidad_modulos)
									{
										echo'<tr><td>&nbsp;</td></tr>';
									}
								$con++;
							}
						echo '</table>';
					}
			}
		function listar_mod_secundarios_vert_tabla_persistentes($sec, $lado, $ancho_tabla)
			{
				$con_seccion_pertenece = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion_perte = mysql_query($con_seccion_pertenece);
				$ren_seccion_perte = mysql_fetch_array($res_seccion_perte);
				$clave_seccion_pertenece = $ren_seccion_perte["clave_seccion_pertenece"];
				if($clave_seccion_pertenece!="")
					{
						$hoy = date('Y-m-d');
						$con_mod_alt = " select m.nombre_archivo, m.clave_modulo
						from nazep_modulos m, nazep_secciones_modulos sm
						where 
						sm.clave_seccion = '$clave_seccion_pertenece' and
						 sm.situacion = 'activo' 
						and (
						case sm.usar_vigencia_mod 
						when 'si'
						then
						sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
						else
						1
						end
						) 
						and m.tipo = 'secundario' and sm.posicion = '$lado'
						and sm.clave_modulo = m.clave_modulo
						and sm.persistencia = 'si'
						order by sm.orden";
						$res_mod_alt = mysql_query($con_mod_alt);
						$cantidad_modulos = mysql_num_rows($res_mod_alt);
						if($cantidad_modulos!="0")
							{
								$con = 1;
								echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
								while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
									{
										echo'<tr>';
											echo '<td align= "center" >';
												$nombre_archivo = $ren_mod_alt["nombre_archivo"];
												$clave_modulo = $ren_mod_alt["clave_modulo"];
												$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
												if(is_readable($archivo))
													{
														include_once($archivo);
														$clase = 'clase_'.$nombre_archivo;
														if(FunGral::validarClaseMetodoVista($clase,'vista'))
															{
																$obj_v = new $clase();
																$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
															}
													}
												else
													{
														HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
													}
											echo '</td>';
										echo'</tr>';	
										if($con<$cantidad_modulos)
											{
												echo'<tr><td>&nbsp;</td></tr>';
											}
										$con++;
									}
								echo '</table>';
							}
						if($clave_seccion_pertenece!="1")
							{
								$this->listar_mod_secundarios_vert_tabla_persistentes($clave_seccion_pertenece, $lado, $ancho_tabla);
							}
					}
			}
		function listar_mod_secundarios_ver_div($sec, $lado, $alto_separacion, $marg_izq, $marg_der, $color_separacion)
			{
                            $hoy = date('Y-m-d');	
                            $con_mod_alt = "select m.nombre_archivo, m.clave_modulo
                            from nazep_modulos m, nazep_secciones_modulos sm
                            where sm.clave_seccion = '$sec' and sm.situacion = 'activo'
                            and (case sm.usar_vigencia_mod 
                            when 'si'
                            then
                            sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
                            else
                            1
                            end) 
                            and m.tipo = 'secundario' and sm.posicion = '$lado'
                            and sm.clave_modulo = m.clave_modulo
                            order by sm.orden";
                            $res_mod_alt = mysql_query($con_mod_alt);
                            $cantidad_modulos = mysql_num_rows($res_mod_alt);
                            if($cantidad_modulos!="0")
                                {
                                    $con = 1;
                                    echo '<div style="padding-left:'.$marg_izq.'; padding-right:'.$marg_der.';">';
                                    while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
                                        {
                                            echo '<div id="div_mod_'.$con.'">';
                                                $nombre_archivo = $ren_mod_alt["nombre_archivo"];
                                                $clave_modulo = $ren_mod_alt["clave_modulo"];
                                                $archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
                                                if(is_readable($archivo))
                                                    {
                                                        include_once($archivo);
                                                        $clase = 'clase_'.$nombre_archivo;
                                                        if(FunGral::validarClaseMetodoVista($clase,'vista'))
                                                            {
                                                                $obj_v = new $clase();
                                                                $obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
                                                            }
                                                    }
                                                else
                                                    {
                                                        HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
                                                    }
                                            echo '</div>';
                                            if($con<$cantidad_modulos)
                                                {
                                                    echo'<div id="separacion_mod_'.$con.'"  style="width:100%; background-color:#'.$color_separacion.';  height:'.$alto_separacion.'px;"></div>';
                                                }
                                            $con++;
                                        }
                                    echo '</div>';
                                }
			}
		function listar_mod_secundarios_ver_div_per($sec, $lado, $alto_separacion, $marg_izq, $marg_der, $color_separacion)
			{
				$con_seccion_pertenece = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion_perte = mysql_query($con_seccion_pertenece);
				$ren_seccion_perte = mysql_fetch_array($res_seccion_perte);
				$clave_seccion_pertenece = $ren_seccion_perte["clave_seccion_pertenece"];
				if($clave_seccion_pertenece!="")
					{
						$hoy = date('Y-m-d');
						$con_mod_alt = " select m.nombre_archivo, m.clave_modulo
						from nazep_modulos m, nazep_secciones_modulos sm
						where 
						sm.clave_seccion = '$clave_seccion_pertenece' and
						 sm.situacion = 'activo' 
						and (
						case sm.usar_vigencia_mod 
						when 'si'
						then
						sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
						else
						1
						end
						) 
						and m.tipo = 'secundario' and sm.posicion = '$lado'
						and sm.clave_modulo = m.clave_modulo
						and sm.persistencia = 'si'
						order by sm.orden";
						$res_mod_alt = mysql_query($con_mod_alt);
						$cantidad_modulos = mysql_num_rows($res_mod_alt);
						if($cantidad_modulos!="0")
							{
								$con = 1;
								echo '<div style="padding-left:'.$marg_izq.'; padding-right:'.$marg_der.';">';
								while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
									{
										echo '<div id="div_mod_per_'.$con.'">';
											$nombre_archivo = $ren_mod_alt["nombre_archivo"];
											$clave_modulo = $ren_mod_alt["clave_modulo"];
											$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
											if(is_readable($archivo))
												{
													include_once($archivo);
													$clase = 'clase_'.$nombre_archivo;
													if(FunGral::validarClaseMetodoVista($clase,'vista'))
														{
															$obj_v = new $clase();
															$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
														}
												}
											else
												{
													HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
												}
										echo '</div>';
										if($con<$cantidad_modulos)
											{
												echo'<div id="separacion_mod_per_'.$con.'"  style="width:100%; background-color:#'.$color_separacion.';  height:'.$alto_separacion.'px;"></div>';
											}
										$con++;
									}
								echo '</div>';
							}
						if($clave_seccion_pertenece!="1")
							{
								$this->listar_mod_secundarios_ver_div_per($clave_seccion_pertenece, $lado, $alto_separacion, $marg_izq, $marg_der, $color_separacion);
							}
					}
			}
		function listar_mod_secundarios_hor_tabla($sec, $lado, $ancho_tabla)
			{
				$hoy = date('Y-m-d');	
				$con_mod_alt = "select m.nombre_archivo, m.clave_modulo
				from nazep_modulos m, nazep_secciones_modulos sm
				where sm.clave_seccion = '$sec' and sm.situacion = 'activo' 
				and (
				case sm.usar_vigencia_mod 
				when 'si'
				then
				sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
				else
				1
				end
				) 
				and m.tipo = 'secundario' and sm.posicion = '$lado'
				and sm.clave_modulo = m.clave_modulo
				order by sm.orden";
				$res_mod_alt = mysql_query($con_mod_alt);
				$cantidad_modulos = mysql_num_rows($res_mod_alt);
				if($cantidad_modulos!="0")
					{
						echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
							echo'<tr>';
								while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
									{
										echo '<td align= "center" >';	
											$nombre_archivo = $ren_mod_alt["nombre_archivo"];
											$clave_modulo = $ren_mod_alt["clave_modulo"];
											$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
											if(is_readable($archivo))
												{
													include_once($archivo);
													$clase = 'clase_'.$nombre_archivo;
													if(FunGral::validarClaseMetodoVista($clase,'vista'))
														{
															$obj_v = new $clase();
															$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
														}
												}
											else
												{
													HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
												}
										echo '</td>';
										echo '<td width="2%" >&nbsp;</td>';
									}
							echo'</tr>';
						echo '</table>';
					}
			}
		function listar_mod_secundarios_hor_tabla_persistentes($sec, $lado, $ancho_tabla)
			{
				$con_seccion_pertenece = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion_perte = mysql_query($con_seccion_pertenece);
				$ren_seccion_perte = mysql_fetch_array($res_seccion_perte);
				$clave_seccion_pertenece = $ren_seccion_perte["clave_seccion_pertenece"];
				if($clave_seccion_pertenece!="")
					{
						$hoy = date('Y-m-d');	
						$con_mod_alt = "select m.nombre_archivo, m.clave_modulo
						from nazep_modulos m, nazep_secciones_modulos sm
						where sm.clave_seccion = '$clave_seccion_pertenece' and sm.situacion = 'activo' 
						and (
						case sm.usar_vigencia_mod 
						when 'si'
						then
						sm.fecha_inicio <= '$hoy' and sm.fecha_fin >= '$hoy'
						else
						1
						end) 
						and m.tipo = 'secundario' and sm.posicion = '$lado'
						and sm.clave_modulo = m.clave_modulo
						and sm.persistencia = 'si'
						order by sm.orden";
						$res_mod_alt = mysql_query($con_mod_alt);
						$cantidad_modulos = mysql_num_rows($res_mod_alt);
						if($cantidad_modulos!="0")
							{
								echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
									echo'<tr>';
										while($ren_mod_alt = mysql_fetch_array($res_mod_alt))
											{
												echo '<td align= "center" >';
													$nombre_archivo = $ren_mod_alt["nombre_archivo"];
													$clave_modulo = $ren_mod_alt["clave_modulo"];
													$archivo = 'librerias/modulos/'.$nombre_archivo.'/'.$nombre_archivo.'_vista.php';
													if(is_readable($archivo))
														{
															include_once($archivo);
															$clase = 'clase_'.$nombre_archivo;
															if(FunGral::validarClaseMetodoVista($clase,'vista'))
																{
																	$obj_v = new $clase();
																	$obj_v->vista($sec, $ubicacion_tema, $nick_usuario, $clave_modulo);
																}
														}
													else
														{
															HtmlVista::verMensajeError(array('mensaje'=>NAZEP_NOHAVEFILEMODULE));
														}
												echo '</td>';
												echo '<td width="2%">&nbsp;</td>';
											}
									echo'</tr>';
								echo '</table>';
							}
					}
			}
		function lis_subsecc_horizontal_tablas($sec, $ancho, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				$hoy = date('Y-m-d');
				$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from nazep_secciones
				where clave_seccion_pertenece = '$sec' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
				    else 0 end)
				and situacion = 'activo'
				order by orden";
				$res_sub  = mysql_query($con_sub);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub=="0")
					{
						$con_sub2 = " select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
						$res_sub2 = mysql_query($con_sub2);
						$ren_sub2 = mysql_fetch_array($res_sub2);
						$clave_seccion_pertenece = $ren_sub2["clave_seccion_pertenece"];
						if($clave_seccion_pertenece!=1)
							{
								$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio 
								from nazep_secciones
								where clave_seccion_pertenece = '$clave_seccion_pertenece'  
								and (case usar_vigencia 
									when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
									when 'no' then 1
									else 0 end)
								and  situacion = 'activo'	
								order by orden";
								$res_sub  = mysql_query($con_sub);
							}
					}	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)	
					{
						echo '<table width="'.$ancho.'" border="0" cellspacing="0" cellpadding="0" align="center">';
							echo'<tr>';
								echo '<td align="left">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										echo'<tr>';
										while($ren = mysql_fetch_array($res_sub))
											{
												$titulo = $ren["titulo"];
												$clave_seccion = $ren["clave_seccion"];
												$tipo_contenido = $ren["tipo_contenido"];
												$tipo_titulo = $ren["tipo_titulo"];
												$flash_secion = $ren["flash_secion"];
												$imagen_secion = $ren["imagen_secion"];	
												$ancho_medio = $ren["ancho_medio"];	
												$alto_medio = $ren["alto_medio"];	
												$formato = '';
												if($tipo_contenido=='xml')
													{
														$formato = '&amp;formato=xml';
													}
												if($mostrar_balazo=='si')
													{
														echo '<td align="left"><img src="'.$imagen_balazo.'" alt="'.$alt_bal.'" title="'.$titulo_bal.'" /></td>';	
														echo '<td width="1%">&nbsp;</td>';
													}
												echo '<td align="left" width="100%">';
												if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
													{
														echo '<a class="lista_subsecc_vert_tabla" href="index.php?sec='.$clave_seccion.$formato.'" >';	
														if($tipo_titulo=="texto")
														{echo $titulo;}
														elseif($tipo_titulo=="imagen")
														{echo '<img width="'.$ancho_medio.'" height="'.$alto_medio.'" src="'.$imagen_secion.'" border="0" alt="" title="" >';}
														echo '</a>';
													}
												elseif($tipo_titulo=='flash')
													{
														echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
													}
												echo '</td>';
											}
										echo'</tr>';
									echo '</table>';
								echo '</td>';
							echo'</tr>';
						echo '</table>';
					}
			}
		function lis_subsecc_vert_tablas($sec, $ancho, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				$hoy = date('Y-m-d');
				$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from nazep_secciones
				where clave_seccion_pertenece = '$sec' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
				    else 0 end)
				and situacion = 'activo'
				order by orden";
				$res_sub  = mysql_query($con_sub);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub=="0")
					{
						$con_sub2 = " select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
						$res_sub2 = mysql_query($con_sub2);
						$ren_sub2 = mysql_fetch_array($res_sub2);
						$clave_seccion_pertenece = $ren_sub2["clave_seccion_pertenece"];
						if($clave_seccion_pertenece!=1)
							{
								$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio 
								from nazep_secciones
								where clave_seccion_pertenece = '$clave_seccion_pertenece'  
								and (case usar_vigencia 
									when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
									when 'no' then 1
									else 0 end)
								and  situacion = 'activo'	
								order by orden";
								$res_sub  = mysql_query($con_sub);
							}
					}	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)	
					{
						echo '<table width="'.$ancho.'" border="0" cellspacing="0" cellpadding="0" align="center">';
							if($mostrar_titulo=="si")
								{
									echo'<tr><td align= "center" class="titulo_subsecciones" >'.$titulo.'<br /><br /></td></tr>';
								}
							echo'<tr>';
								echo '<td align="left">';
									echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
										while($ren = mysql_fetch_array($res_sub))
											{
												$titulo = $ren["titulo"];
												$clave_seccion = $ren["clave_seccion"];
												$tipo_contenido = $ren["tipo_contenido"];
												$tipo_titulo = $ren["tipo_titulo"];
												$flash_secion = $ren["flash_secion"];
												$imagen_secion = $ren["imagen_secion"];	
												$ancho_medio = $ren["ancho_medio"];	
												$alto_medio = $ren["alto_medio"];	
												$formato = '';
												if($tipo_contenido=='xml')
													{
														$formato = '&amp;formato=xml';
													}
												echo'<tr>';
													if($mostrar_balazo=='si')
														{
															echo '<td align="left"><img src="'.$imagen_balazo.'" alt="'.$alt_bal.'" title="'.$titulo_bal.'" /></td>';	
															echo '<td width="1%">&nbsp;</td>';
														}
													echo '<td align="left" width="100%">';
													if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
														{
															echo '<a class="lista_subsecc_vert_tabla" href="index.php?sec='.$clave_seccion.$formato.'" >';	
															if($tipo_titulo=="texto")
															{echo $titulo;}
															elseif($tipo_titulo=="imagen")
															{echo '<img width="'.$ancho_medio.'" height="'.$alto_medio.'" src="'.$imagen_secion.'" border="0" alt="" title="" >';}
															echo '</a>';
														}
													elseif($tipo_titulo=='flash')
														{
															echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
														}
													echo '</td>';	
												echo'</tr>';	
												echo'<tr>';
													if($mostrar_balazo=='si')
														{
															echo '<td align="left" height="'.$espacio_secciones.'"></td><td width="1%" height="'.$espacio_secciones.'"></td>';
														}
													echo '<td align="left" width="100%" height="'.$espacio_secciones.'" ></td>';
												echo'</tr>';
											}
									echo '</table>';
								echo '</td>';
							echo'</tr>';
						echo '</table>';
					}
			}
		function lis_secc_prin_ver_tablas($inicio, $cantidad, $ancho, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				/*Metodo descotinuado, por usar tablas, remplazada por lis_secc_prin_ver_ul en la version 0.1.6*/
				$inicio--;
				$hoy = date('Y-m-d');
				$con_sec = " select clave_seccion, titulo, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio from  nazep_secciones  where clave_seccion_pertenece = '1' 
					        and (case usar_vigencia  when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy' when 'no' then 1 else 0 end) and situacion = 'activo' order by orden limit $inicio, $cantidad";
				$res_sub  = mysql_query($con_sec);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)
					{
						echo '<table width="'.$ancho.'" border="0" cellspacing="0" cellpadding="0" align="center" >';
							if($mostrar_titulo=="si")
								{ echo'<tr><td align="center" class="titulo_secc_principales" >'.$titulo.'<br /></td></tr>'; }	
							echo'<tr><td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">';
							while($ren = mysql_fetch_array($res_sub))
								{
									$titulo = $ren["titulo"];
									$clave_seccion = $ren["clave_seccion"];
									$tipo_contenido = $ren["tipo_contenido"];
									$tipo_titulo = $ren["tipo_titulo"];
									$flash_secion = $ren["flash_secion"];
									$imagen_secion = $ren["imagen_secion"];	
									$ancho_medio = $ren["ancho_medio"];
									$alto_medio = $ren["alto_medio"];
									$formato = '';
									if($tipo_contenido=='xml')
										{ $formato = '&amp;formato=xml'; }
									echo'<tr>';
										if($mostrar_balazo=="si")
											{ echo '<td align="left"><img src="'.$imagen_balazo.'" alt="'.$alt_bal.'" title="'.$titulo_bal.'" /></td><td width="1%">&nbsp;</td>';}
										echo '<td align="left" width="100%">';
										if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
											{
												echo '<a class="menu_prin_vertical" href="index.php?sec='.$clave_seccion.$formato.'" >';	
												if($tipo_titulo=="texto")
												{echo $titulo;}
												elseif($tipo_titulo=="imagen")
												{echo '<img src="'.$imagen_secion.'" width="'.$ancho_medio.'" height="'.$alto_medio.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
												echo '</a>';
											}
										elseif($tipo_titulo=="flash")
											{ echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';}
									echo '</td></tr>';
									echo'<tr>';
										if($mostrar_balazo=="si")
											{ echo '<td align="left" height="'.$espacio_secciones.'"></td><td width="1%" height="'.$espacio_secciones.'"></td>';}
									echo '<tdalign="left" width="100%" height="'.$espacio_secciones.'"></td></tr>';
								}
						echo '</table></td></tr></table>';
					}
			}
		function lis_secc_prin_hor_tablas($inicio, $cantidad, $simbolo, $ancho)
			{
				/*
				Metodo que te permite hacer un listado de las secciones principales del portal 
				en forma horizontal en una tabla con un ancho variable,
				separados por un simbolo personalizable y mostrando una cantidad establecida.
				*/
				$inicio--;
				$conexion = $this->conectarse();
				$hoy = date('Y-m-d');
				$con_secciones = "select clave_seccion, titulo, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from 
				nazep_secciones 
				where 
				clave_seccion_pertenece = '1' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
					else 0 end)
				and situacion = 'activo'
				order by orden limit $inicio, $cantidad";
				$res_sec = mysql_query($con_secciones);
				echo '<table width="'.$ancho.'" border="0" cellpadding="0" align="center" cellspacing="5">';
					echo'<tr>';
						echo '<td>';
							$con = 1;
							while($ren = mysql_fetch_array($res_sec))
								{
									$clave_seccion = $ren["clave_seccion"];
									$titulo = $ren["titulo"];
									$tipo_contenido = $ren["tipo_contenido"];
									$tipo_titulo = $ren["tipo_titulo"];
									$flash_secion = $ren["flash_secion"];
									$imagen_secion = $ren["imagen_secion"];
									$ancho_medio = $ren["ancho_medio"];	
									$alto_medio = $ren["alto_medio"];
									$formato = '';
									if($tipo_contenido=="xml")
										{ $formato = '&amp;formato=xml'; }
									if($con > 1)
										{
											echo '<span class="simb_sep_men_prin_hor">';
											echo '&nbsp;'.$simbolo.'&nbsp;';	
											echo '</span>';
										}
									if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
										{
											echo '<a class="menu_prin_horizontal" href="index.php?sec='.$clave_seccion.$formato.'" >';	
											if($tipo_titulo=="texto")
											{echo $titulo;}
											elseif($tipo_titulo=="imagen")
											{echo '<img width="'.$ancho_medio.'" height="'.$alto_medio.'" src="'.$imagen_secion.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
											echo '</a>';
										}
									elseif($tipo_titulo=="flash")
										{
											echo '<embed width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
										}
									$con++;			
								}
						echo '</td>';
					echo'</tr>';
				echo '</table>';
			}
		function lis_secc_prin_ver_ul($inicio, $cantidad, $anc_mar_izq, $anc_mar_der, $alto_sep, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
                            $inicio--;
                            $hoy = date('Y-m-d');
                            $con_sec = " select clave_seccion, titulo, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
                                    from  nazep_secciones 
                                    where clave_seccion_pertenece = '1' 
                                    and (case usar_vigencia 
                                            when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
                                            when 'no' then 1
                                            else 0 end)
                                    and situacion = 'activo' order by orden limit $inicio, $cantidad";
                            $conexion = $this->conectarse();
                            $res_sub  = mysql_query($con_sec);
                            $can_sub = mysql_num_rows($res_sub);
                            if($can_sub!=0)
                                {
                                    if($mostrar_titulo=="si")
                                        {echo'<div id="nzp_div_tit_menu" class="titulo_secc_principales" >'.$titulo.'</div>';}						
                                    if($mostrar_balazo=="si")
                                        {$balazo_ul = 'list-style-image:url('.$imagen_balazo.');';}
                                    else
                                        {$balazo_ul = 'list-style: none;';}
                                    echo '<ul style="'.$balazo_ul.' margin:0px; padding-left: '.$anc_mar_izq.';  padding-right: '.$anc_mar_der.';">';
                                    while($ren = mysql_fetch_array($res_sub))
                                        {
                                            $titulo = $ren["titulo"];
                                            $clave_seccion = $ren["clave_seccion"];
                                            $tipo_contenido = $ren["tipo_contenido"];
                                            $tipo_titulo = $ren["tipo_titulo"];
                                            $flash_secion = $ren["flash_secion"];
                                            $imagen_secion = $ren["imagen_secion"];	
                                            $ancho_medio = $ren["ancho_medio"];
                                            $alto_medio = $ren["alto_medio"];
                                            $formato = '';
                                            if($tipo_contenido=="xml")
                                                {
                                                    $formato = '&amp;formato=xml';
                                                }
                                            echo'<li style="padding-bottom:'.$alto_sep.';" >';
                                                if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
                                                    {
                                                        echo '<a class="menu_prin_vertical" title="'.$titulo.'" href="index.php?sec='.$clave_seccion.$formato.'" >';	
                                                        if($tipo_titulo=="texto")
                                                        {echo $titulo;}
                                                        elseif($tipo_titulo=="imagen")
                                                        {echo '<img src="'.$imagen_secion.'" width="'.$ancho_medio.'" height="'.$alto_medio.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
                                                        echo '</a>';
                                                    }
                                                elseif($tipo_titulo=="flash")
                                                    {
                                                        echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
                                                    }	
                                            echo '</li>';
                                        }
                                    echo '</ul>';
                                }
                            $this->desconectarse($conexion);
			}
		function lis_subsecc_ver_ul($sec, $anc_mar_izq, $anc_mar_der, $mostrar_titulo, $titulo, $mostrar_balazo, $ubicacion_tema, $espacio_secciones, $imagen_balazo, $alt_bal, $titulo_bal)
			{
				$hoy = date('Y-m-d');
				$con_sub = "select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio
				from nazep_secciones
				where clave_seccion_pertenece = '$sec' 
				and (case usar_vigencia 
					when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
					when 'no' then 1
				    else 0 end)
				and situacion = 'activo'
				order by orden";
				$res_sub  = mysql_query($con_sub);	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub=="0")
					{
						$con_sub2 = "select clave_seccion_pertenece from nazep_secciones where clave_seccion = '$sec' ";
						$res_sub2 = mysql_query($con_sub2);
						$ren_sub2 = mysql_fetch_array($res_sub2);
						$clave_seccion_pertenece = $ren_sub2["clave_seccion_pertenece"];
						if($clave_seccion_pertenece!=1)
							{
								$con_sub = " select  titulo, clave_seccion, tipo_contenido, tipo_titulo, flash_secion, imagen_secion, ancho_medio, alto_medio 
								from nazep_secciones
								where clave_seccion_pertenece = '$clave_seccion_pertenece'  
								and (case usar_vigencia 
									when 'si' then fecha_iniciar_vigencia <= '$hoy' and fecha_termina_vigencia >= '$hoy'
									when 'no' then 1
									else 0 end)
								and  situacion = 'activo'	
								order by orden";
								$res_sub  = mysql_query($con_sub);
							}
					}	
				$can_sub = mysql_num_rows($res_sub);
				if($can_sub!=0)	
					{
							if($mostrar_titulo=="si")
								{echo'<div id="nzp_div_tit_subsec" class="titulo_subsecciones" >'.$titulo.'</div>';}
							if($mostrar_balazo=="si")
								{$balazo_ul = 'list-style-image:url('.$imagen_balazo.');';}
							else
								{$balazo_ul = 'list-style: none;';}
							echo '<ul style="'.$balazo_ul.' margin:0px; padding-left: '.$anc_mar_izq.';  padding-right: '.$anc_mar_der.';">';
							while($ren = mysql_fetch_array($res_sub))
								{
									$titulo = $ren["titulo"];
									$clave_seccion = $ren["clave_seccion"];
									$tipo_contenido = $ren["tipo_contenido"];
									$tipo_titulo = $ren["tipo_titulo"];
									$flash_secion = $ren["flash_secion"];
									$imagen_secion = $ren["imagen_secion"];	
									$ancho_medio = $ren["ancho_medio"];	
									$alto_medio = $ren["alto_medio"];	
									$formato = '';
									if($tipo_contenido=="xml")
										{
											$formato = '&amp;formato=xml';
										}
									echo'<li style="padding-bottom:'.$alto_sep.';" >';
										if(($tipo_titulo=="texto") or ($tipo_titulo=="imagen"))
											{
												echo '<a class="lista_subsecc_vert_ul" title="'.$titulo.'" href="index.php?sec='.$clave_seccion.$formato.'" >';	
												if($tipo_titulo=="texto")
												{echo $titulo;}
												elseif($tipo_titulo=="imagen")
												{echo '<img src="'.$imagen_secion.'" width="'.$ancho_medio.'" height="'.$alto_medio.'" border="0" alt="'.$titulo.'" title="'.$titulo.'" >';}
												echo '</a>';
											}
										elseif($tipo_titulo=="flash")
											{
												echo '<embed  width="'.$ancho_medio.'" height="'.$alto_medio.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flash_secion.'" play="true" loop="true" menu="true"></embed>';
											}
									echo '</li>';
								}
							echo '</ul>';								
					}
			}
		function existencia_seccion($sec)
			{
				$conexion = $this->conectarse();
				$con_sec = "select clave_seccion from nazep_secciones where clave_seccion = '$sec'";
				$res_con = mysql_query($con_sec);
				$can_sec = mysql_num_rows($res_con);
				if($can_sec==1)
					{
						$situacion = $this->situacion_seccion($sec);
						if($situacion=="cancelado")
							{$existe = false; }
						else
							{ $existe = true; }
					}
				else
					{ $existe = false; }
				return $existe;
			}
		function situacion_seccion($sec)
			{
				$conexion = $this->conectarse();
				$con_sec = "select situacion from nazep_secciones where clave_seccion = '$sec'";
				$res_con = mysql_query($con_sec);
				$ren_con = mysql_fetch_array($res_con);
				$situacion = $ren_con["situacion"]; 
				return $situacion;			
			}
		function seccion_protegida($sec)
			{
				$conexion = $this->conectarse();
				$consulta_proteccion = " select protegida from nazep_secciones  where clave_seccion = '$sec'";
				$res = mysql_query($consulta_proteccion);
				$ren = mysql_fetch_array($res);
				$protegida = $ren["protegida"];	
				return 	$protegida;		
			}	
		function form_buscador($ancho_tabla, $ancho_input, $tex_btn)
			{
				$cons_buscador = "select clave_buscador from nazep_configuracion";
				$res_bus = mysql_query($cons_buscador);
				$ren_bus = mysql_fetch_array($res_bus);
				$clave_buscador = $ren_bus["clave_buscador"];
				echo '<form name="buscador_mini" action="index.php?sec='.$clave_buscador.'" method="post" >';
					echo '<table width="'.$ancho_tabla.'" border="0" cellspacing="0" cellpadding="0" align="center">';
						echo'<tr>';
							echo '<td align= "center" >';
								echo '<input type="hidden" name="buscador" value = "mini" />';
								echo '<input type = "text" name="frase" size="'.$ancho_input.'" /><br />';
								echo '<input type="submit" name="btn_buscar" value="'.$tex_btn.'" />';
							echo '</td>';
						echo '</tr>';
					echo '</table>';
				echo '</form>';
			}
		function titulo_seccion($sec)
			{
				$con_seccion = "select titulo from nazep_secciones where clave_seccion = '$sec' ";
				$res_seccion = mysql_query($con_seccion);
				$ren_seccion = mysql_fetch_array($res_seccion);
				$titulo = $ren_seccion["titulo"];
				return $titulo;				
			}
		function keywords_seccion($sec)
			{
				$con_seccion = "select usar_keywords, keywords from nazep_secciones where clave_seccion = '$sec'";
				$res_seccion = mysql_query($con_seccion);
				$ren_seccion = mysql_fetch_array($res_seccion);
				$keywords = $ren_seccion["keywords"];
				$usar_keywords = $ren_seccion["usar_keywords"];
				if($usar_keywords=="si")
				return $keywords;
				else
				return false;
			}
		function descripcion_seccion($sec)
			{
				$con_seccion = "select usar_descripcion, descripcion from nazep_secciones where clave_seccion = '$sec'";
				$res_seccion = mysql_query($con_seccion);
				$ren_seccion = mysql_fetch_array($res_seccion);
				$descripcion = $ren_seccion["descripcion"];
				$usar_descripcion = $ren_seccion["usar_descripcion"];
				if($usar_descripcion=="si")				
				return $descripcion;
				else
				return false;
			}
		function historial_vista($sec, $simbolo, $alineacion, $target)
			{
				/*
				Funci�n que te permite ver le historial de navegaci�n en las secciones del portal.
				se recibe la clave de la secci�n y el simbolo que se usara para dividir las secciones 
				*/
				$clave_seccion_usada = $sec;
				for($a=1;$a>0;$a++)
					{	
						if($clave_seccion_usada=="")
							{$clave_seccion_usada = '1';}
						$con = "select clave_seccion_pertenece, titulo from nazep_secciones where clave_seccion = '$clave_seccion_usada'";	
						$res = mysql_query($con);
						$ren = mysql_fetch_array($res);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"]; 
						$titulo = $ren["titulo"];
						$arreglo_seccion[$a] = $clave_seccion_usada;
						$nombre_seccion[$a] = $titulo;
						if($clave_seccion_usada == 1)
							{$a = -1;}
						else
							{$clave_seccion_usada = $clave_seccion_pertenece;}			
					}
				$cantidad = count($nombre_seccion);
				echo '<table width="100%" border="0">';
					echo '<tr>';
						echo '<td align="'.$alineacion.'">';
							for($a=$cantidad;$a>0;$a--)
								{
									$clave = $arreglo_seccion[$a];
									$nombre = $nombre_seccion[$a];	
									if($a!=1)
										{
											echo '<a class="enlace_historial" href= "index.php?sec='.$clave.'" target="'.$target.'">'.$nombre.'</a>';
											echo '<span class="flecha_historial">&nbsp;'.$simbolo.'&nbsp;</span>';
										}
									else
										{
											echo '<span class="final_historia">'.$nombre.'</span>';
										}
								}
						echo '</td>';
					echo '</tr>';
				echo '</table>';
				return $nombre;
			}
		function historial_vista_div($sec, $simbolo, $target)
			{
				$clave_seccion_usada = $sec;
				for($a=1;$a>0;$a++)
					{	
						if($clave_seccion_usada=="")
							{$clave_seccion_usada = '1';}
						$con = "select clave_seccion_pertenece, titulo from nazep_secciones where clave_seccion = '$clave_seccion_usada'";	
						$res = mysql_query($con);
						$ren = mysql_fetch_array($res);
						$clave_seccion_pertenece = $ren["clave_seccion_pertenece"]; 
						$titulo = $ren["titulo"];
						$arreglo_seccion[$a] = $clave_seccion_usada;
						$nombre_seccion[$a] = $titulo;
						if($clave_seccion_usada == 1)
							{$a = -1;}
						else
							{$clave_seccion_usada = $clave_seccion_pertenece;}
					}
				$cantidad = count($nombre_seccion);
				echo '<div id="cuerpo_historial_seccion" class="clas_cuerpo_historial_seccion" >';
					for($a=$cantidad;$a>0;$a--)
						{
							$clave = $arreglo_seccion[$a];
							$nombre = $nombre_seccion[$a];
							if($a!=1)
								{
									echo '<a class="enlace_historial" href= "index.php?sec='.$clave.'" target="'.$target.'">'.$nombre.'</a>';
									echo '<span class="flecha_historial">&nbsp;'.$simbolo.'&nbsp;</span>';
								}
							else
								{
									echo '<span class="final_historia">'.$nombre.'</span>';
								}
						}
				echo '</div>';
				return $nombre;
			}			
			
		function ver_visitas_sec($sec)
			{
				$conexion = $this->conectarse();
				$res_visitas = mysql_query("select visitas from nazep_secciones  where clave_seccion = '$sec' ");
				$ren_visitas = mysql_fetch_array($res_visitas);
				$visitas = $ren_visitas["visitas"];	
				echo '<span class="texto_visitas">'.gral_visitas.'</span>';
				echo '<span class="numero_visitas">'.$visitas.'</span>';	
			}
		function visitas_simple($sec)
			{
				$conexion = $this->conectarse();
				$fecha_hoy = date("Y-m-d");
				$con_visita = "select clave_visita, visita from nazep_v_visitas_simple where fecha = '$fecha_hoy' and clave_seccion = '$sec'";
				$res_visita = mysql_query($con_visita);
				$can_res =  mysql_num_rows($res_visita);
				if($can_res!="")
					{
						$ren = mysql_fetch_array($res_visita);
						$visita = $ren["visita"];
						$visita++;
						$consulta = "update nazep_v_visitas_simple set visita = '$visita' where fecha = '$fecha_hoy' and clave_seccion = '$sec'";
					}
				else
					{
						$consulta = "insert into nazep_v_visitas_simple (clave_seccion, fecha, visita) values ('$sec', '$fecha_hoy', '1')";
					}
				if (!@mysql_query($consulta))
					{
						echo 'visita no registrada';
					}
				else
					{
						$update_sec = "update nazep_secciones set visitas = visitas+1 where clave_seccion = '$sec'";
						if (!@mysql_query($update_sec))
							{
								echo 'visita no registrada';
							}
					}
			}
//************************************************************************ FIN FUNCIONES PARA MULTIPLES USOS *****************************************************************
	}
session_start();  
$sesion_temporal = md5(nombre_base.'final');
if (!isset($_SESSION[$sesion_temporal]))
	{
		$_SESSION[$sesion_temporal] = new vista_final();
	}
?>