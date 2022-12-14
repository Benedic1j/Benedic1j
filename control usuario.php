<?php

class ControladorUsuarios{

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	public function ctrRegistroUsuario(){

		if(isset($_POST["regUsuario"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["regUsuario"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["regPassword"])){

			   	$encriptar = crypt($_POST["regPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$
			   		$2a$07$asxx54ahjppf45sd87a5auxq/SS293XhTEeizKWMnfhnpfay0AALe');
					//    crypt(string $str, string $salt = ?): string

			   	$encriptarEmail = md5($_POST["regEmail"]);

				$datos = array("nombre"=>$_POST["regUsuario"],
							   "password"=> $encriptar,
							   "email"=> $_POST["regEmail"],
							   "foto"=>"",
							   "modo"=> "directo",
							   "verificacion"=> 0,
							   "emailEncriptado"=>$encriptarEmail,
							   "completo"=> 1,);

				$tabla = "usuarios";

				$respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

				if($respuesta == "ok"){

					/*=============================================
					ACTUALIZAR NOTIFICACIONES NUEVOS USUARIOS
					=============================================*/

					$traerNotificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();

					$nuevoUsuario = $traerNotificaciones["nuevosUsuarios"] + 1;

					ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", "nuevosUsuarios", $nuevoUsuario);

					/*=============================================
					VERIFICACIÓN CORREO ELECTRÓNICO
					=============================================*/

					// date_default_timezone_set("America/Santiago");

					// $url = Ruta::ctrRuta();	
					// $email= $_POST["regEmail"];
			  
					// $para = $email . ', ';
					// $para .= 'leonardom969@gmail.com';
			  
					// $título = 'Por favor verifique su dirección de correo electrónico';

					// $mensaje ='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
						
					// 	<center>
							
					// 		<img style="padding:20px; width:10%" src="https://testback.merust.mx/vistas/img/plantilla/logo.png">

					// 	</center>

					// 	<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
						
					// 		<center>
							
					// 		<img style="padding:20px; width:15%" src="https://testfront.merust.mx/vistas/img/plantilla/icon-email.png">

					// 		<h3 style="font-weight:100; color:#999">VERIFIQUE SU DIRECCIÓN DE CORREO ELECTRÓNICO</h3>

					// 		<hr style="border:1px solid #ccc; width:80%">

					// 		<h4 style="font-weight:100; color:#999; padding:0 20px">Para comenzar a usar su cuenta de Alpha Line, debe confirmar su dirección de correo electrónico</h4>

					// 		<a href="'.$url.'verificar/'.$encriptarEmail.'" target="_blank" style="text-decoration:none">

					// 		<div style="line-height:60px; background:#0F71B8; width:60%; color:white">Verifique su dirección de correo electrónico</div>

					// 		</a>

					// 		<br>

					// 		<hr style="border:1px solid #ccc; width:80%">

					// 		<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

					// 		</center>

					// 	</div>

					// </div>';

					// $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
					// $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					// $cabeceras .= 'From: <leonardo.moran@merust.mx>' . "\r\n";

					// $envio = mail($para, $título, $mensaje, $cabeceras);

					// if(!$envio){

					// 	echo '<script> 

					// 		swal({
					// 			  title: "¡ERROR!",
					// 			  text: "¡Ha ocurrido un problema enviando verificación de correo electrónico a '.$_POST["regEmail"].'!",
					// 			  type:"error",
					// 			  confirmButtonText: "Cerrar",
					// 			  closeOnConfirm: false
					// 			},

					// 			function(isConfirm){

					// 				if(isConfirm){
					// 					history.back();
					// 				}
					// 		});

					// 	</script>';

					// }else{

						// text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST["regEmail"].' para verificar la cuenta!",

						echo '<script> 

							swal({
								  title: "¡OK!",
								  text: "¡Su registro a sido exitoso...!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';

					// }

				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al registrar el usuario, no se permiten caracteres especiales!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/

	static public function ctrMostrarUsuario($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function ctrActualizarUsuario($id, $item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/

	public function ctrIngresoUsuario(){

		if(isset($_POST["ingEmail"])){

			if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["ingEmail"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

				$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "usuarios";
				$item = "email";
				$valor = $_POST["ingEmail"];
				$completo=1;

				$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);
				var_dump($respuesta);

				if($respuesta["email"] == $_POST["ingEmail"] && $respuesta["password"] == $encriptar){

					if($respuesta["verificacion"] == 1){

						echo'<script>

							swal({
								  title: "¡NO HA VERIFICADO SU CORREO ELECTRÓNICO!",
								  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo para verififcar la dirección de correo electrónico '.$respuesta["email"].'!",
								  type: "error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	   
									    history.back();
									  } 
							});

							</script>';
					
					}else{

						$_SESSION["validarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["foto"] = $respuesta["foto"];
						$_SESSION["email"] = $respuesta["email"];
						$_SESSION["password"] = $respuesta["password"];
						$_SESSION["modo"] = $respuesta["modo"];
						$_SESSION["completo"] = $respuesta["completo"];
						$_SESSION["genero"] = $respuesta["genero"];
						$_SESSION["fenac"] = $respuesta["fenac"];
						$_SESSION["nacionalidad"] = $respuesta["nacionalidad"];
						$_SESSION["rut"] = $respuesta["rut"];
						$_SESSION["edocivil"] = $respuesta["edocivil"];
						$_SESSION["ocupacion"] = $respuesta["ocupacion"];
						$_SESSION["profesion"] = $respuesta["profesion"];
						$_SESSION["celular"] = $respuesta["celular"];
						$_SESSION["paisres"] = $respuesta["paisres"];
						$_SESSION["ciudad"] = $respuesta["ciudad"];
						$_SESSION["direccion"] = $respuesta["direccion"];
						$_SESSION["cp"] = $respuesta["cp"];


						echo '<script>
							
							window.location = localStorage.getItem("rutaActual");

						</script>';

									
					
				}

				}else{

					echo'<script>

							swal({
								  title: "¡ERROR AL INGRESAR!",
								  text: "¡Por favor revise que el email exista o la contraseña coincida con la registrada!",
								  type: "error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	   
									    window.location = localStorage.getItem("rutaActual");
									  } 
							});

							</script>';

				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al ingresar al sistema, no se permiten caracteres especiales!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}
			
			// if($respuesta["completo"] == 1){

			// $_SESSION["validarSesion"] = "ok";
			// $_SESSION["id"] = $respuesta["id"];
			// $_SESSION["nombre"] = $respuesta["nombre"];
			// $_SESSION["foto"] = $respuesta["foto"];
			// $_SESSION["email"] = $respuesta["email"];
			// $_SESSION["password"] = $respuesta["password"];
			// $_SESSION["modo"] = $respuesta["modo"];
			// $_SESSION["completo"] = $respuesta["completo"];
			// $_SESSION["genero"] = $respuesta["genero"];
			// $_SESSION["fenac"] = $respuesta["fenac"];
			// $_SESSION["nacionalidad"] = $respuesta["nacionalidad"];
			// $_SESSION["rut"] = $respuesta["rut"];
			// $_SESSION["edocivil"] = $respuesta["edocivil"];
			// $_SESSION["ocupacion"] = $respuesta["ocupacion"];
			// $_SESSION["profesion"] = $respuesta["profesion"];
			// $_SESSION["celular"] = $respuesta["celular"];
			// $_SESSION["paisres"] = $respuesta["paisres"];
			// $_SESSION["ciudad"] = $respuesta["ciudad"];
			// $_SESSION["direccion"] = $respuesta["direccion"];
			// $_SESSION["cp"] = $respuesta["cp"];

			// echo'<script>

			// 	swal({
			// 		title: "¡Atención!",
			// 		text: "¡Debe Completar el registro para operar en Alpha Line",
			// 		type: "error",
			// 		confirmButtonText: "Completar Registro",
			// 		closeOnConfirm: false
			// 	},

			// 	function(isConfirm){
			// 			if (isConfirm) {	   
			// 				window.location = "completaregistro";
			// 			} 
			// 	});

			// 	</script>';

			// }else{


			// }

		
			
		}

	}

	/*=============================================
	OLVIDO DE CONTRASEÑA
	=============================================*/

	public function ctrOlvidoPassword(){

		if(isset($_POST["passEmail"])){

			if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["passEmail"])){

				/*=============================================
				GENERAR CONTRASEÑA ALEATORIA
				=============================================*/

				function generarPassword($longitud){

					$key = "";
					$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";

					$max = strlen($pattern)-1;

					for($i = 0; $i < $longitud; $i++){

						$key .= $pattern[mt_rand(0,$max)];

					}

					return $key;

				}

				$nuevaPassword = generarPassword(11);
				var_dump($nuevaPassword);

				$encriptar = crypt($nuevaPassword, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "usuarios";

				$item1 = "email";
				$valor1 = $_POST["passEmail"];

				$respuesta1 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item1, $valor1);

				if($respuesta1){

					$id = $respuesta1["id"];
					$item2 = "password";
					$valor2 = $encriptar;

					$respuesta2 = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item2, $valor2);

					if($respuesta2  == "ok"){

						/*=============================================
						CAMBIO DE CONTRASEÑA
						=============================================*/

						date_default_timezone_set("America/Bogota");

						$url = Ruta::ctrRuta();	

						$email= $_POST["passEmail"];
				  
						$para = $email . ', ';
				// 		$para .= 'soporte@alphalifechile.cl';
				  
						$título = 'Solicitud de nueva contraseña';
	
						$mensaje ='<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
	
								<center>
									
									<img style="padding:20px; width:10%" src="https://testback.merust.mx/vistas/img/plantilla/logo.png">

								</center>

								<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
								
									<center>
									
									<img style="padding:20px; width:15%" src="https://testfront.merust.mx/vistas/img/plantilla/icon-pass.png">

									<h3 style="font-weight:100; color:#999">SOLICITUD DE NUEVA CONTRASEÑA</h3>

									<hr style="border:1px solid #ccc; width:80%">

									<h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Su nueva contraseña: </strong>'.$nuevaPassword.'</h4>

									<a href="'.$url.'" target="_blank" style="text-decoration:none">

									<div style="line-height:60px; background:#0F71B8; width:60%; color:white">Ingrese nuevamente al sitio</div>

									</a>

									<br>

									<hr style="border:1px solid #ccc; width:80%">

									<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

									</center>

								</div>

							</div>';

						$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
						$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
						$cabeceras .= 'From: <noreply@alphalifechile.cl>' . "\r\n";
		
						$envio = mail($para, $título, $mensaje, $cabeceras);
	
						if(!$envio){

							echo '<script> 

								swal({
									  title: "¡ERROR!",
									  text: "¡Ha ocurrido un problema enviando cambio de contraseña a '.$_POST["passEmail"].'!",
									  type:"error",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									},

									function(isConfirm){

										if(isConfirm){
											history.back();
										}
								});

							</script>';

						}else{

							echo '<script> 

								swal({
									  title: "¡OK!",
									  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST["passEmail"].' para su cambio de contraseña!",
									  type:"success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									},

									function(isConfirm){

										if(isConfirm){
											history.back();
										}
								});

							</script>';

						}

					}

				}else{

					echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡El correo electrónico no existe en el sistema!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

					</script>';


				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al enviar el correo electrónico, está mal escrito!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}

		}

	}

	/*=============================================
	REGISTRO CON REDES SOCIALES
	=============================================*/

	static public function ctrRegistroRedesSociales($datos){

		$tabla = "usuarios";
		$item = "email";
		$valor = $datos["email"];
		$emailRepetido = false;

		$respuesta0 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

		if($respuesta0){

			if($respuesta0["modo"] != $datos["modo"]){

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡El correo electrónico '.$datos["email"].', ya está registrado en el sistema con un método diferente a Google!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

				$emailRepetido = false;

				return;

			}

			$emailRepetido = true;

		}else{

			$respuesta1 = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

			/*=============================================
			ACTUALIZAR NOTIFICACIONES NUEVOS USUARIOS
			=============================================*/

			$traerNotificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();

			$nuevoUsuario = $traerNotificaciones["nuevosUsuarios"] + 1;

			ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", "nuevosUsuarios", $nuevoUsuario);

		}

		if($emailRepetido || $respuesta1 == "ok"){

			$respuesta2 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

			if($respuesta2["modo"] == "facebook"){

				session_start();

				$_SESSION["validarSesion"] = "ok";
				$_SESSION["id"] = $respuesta2["id"];
				$_SESSION["nombre"] = $respuesta2["nombre"];
				$_SESSION["foto"] = $respuesta2["foto"];
				$_SESSION["email"] = $respuesta2["email"];
				$_SESSION["password"] = $respuesta2["password"];
				$_SESSION["modo"] = $respuesta2["modo"];

				echo "ok";

			}else if($respuesta2["modo"] == "google"){

				$_SESSION["validarSesion"] = "ok";
				$_SESSION["id"] = $respuesta2["id"];
				$_SESSION["nombre"] = $respuesta2["nombre"];
				$_SESSION["foto"] = $respuesta2["foto"];
				$_SESSION["email"] = $respuesta2["email"];
				$_SESSION["password"] = $respuesta2["password"];
				$_SESSION["modo"] = $respuesta2["modo"];

				echo "<span style='color:white'>ok</span>";

			}

			else{

				echo "";
			}

		}
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	// static public function ctrEditarUsuario($datos){

	// 	if(isset($datos["idUsuario"])){

	// 		if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["regUsuario"])){
		
	// 				$datosUsuario = array("genero" => $datos["regGenero"],
	// 									"fenac" => $datos["fecha_nacimiento"],
	// 									"nacionalidad" => $datos["regNacio"],
	// 									"rut" => $datos["regRut"],
	// 									"edocivil" => $datos["regEdoCivil"],
	// 									"ocupacion" => $datos["regOcupacion"],
	// 									"profesion" => $datos["regProfesion"],
	// 									"celular" => $datos["regCelular"],
	// 									"paisres" => $datos["regPaisRes"],
	// 									"ciudad" => $datos["regCiudad"],
	// 									"direccion" => $datos["regDireccion"],
	// 									"cp" => $datos["regCodPostal"],
	// 									"id" => $datos["idUsuario"]
	// 							   );


	// 			$respuesta = ModeloUsuarios::mdlActualizarPerfil("usuario", $datosUsuario);

	// 			return $respuesta;


	// 		}else{

	// 			echo'<script>

	// 				swal({
	// 					  type: "error",
	// 					  title: "¡El nombre del Cliente no puede ir vacío o llevar caracteres especiales!",
	// 					  showConfirmButton: true,
	// 					  confirmButtonText: "Cerrar"
	// 					  }).then(function(result){
	// 						if (result.value) {

	// 						window.location = "perfil";

	// 						}
	// 					})

	// 		  	</script>';

	// 		}

	// 	}
		
	// }

	/*=============================================
	ACTUALIZAR PERFIL
	=============================================*/

	public function ctrActualizarPerfil(){

		if(isset($_POST["editarNombre"])){

			/*=============================================
			VALIDAR IMAGEN
			=============================================*/

			$ruta = "";

			if(isset($_FILES["datosImagen"]["tmp_name"]) && !empty($_FILES["datosImagen"]["tmp_name"])){

				/*=============================================
				PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
				=============================================*/

				$directorio = "vistas/img/usuarios/".$_POST["idUsuario"];

				if(!empty($_POST["fotoUsuario"])){

					unlink($_POST["fotoUsuario"]);
				
				}else{

					mkdir($directorio, 0755);

				}

				/*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/

				list($ancho, $alto) = getimagesize($_FILES["datosImagen"]["tmp_name"]);

				$nuevoAncho = 500;
				$nuevoAlto = 500;	

				$aleatorio = mt_rand(100, 999);

				if($_FILES["datosImagen"]["type"] == "image/jpeg"){

					$ruta = "vistas/img/usuarios/".$_POST["idUsuario"]."/".$aleatorio.".jpg";

					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/

					$origen = imagecreatefromjpeg($_FILES["datosImagen"]["tmp_name"]);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);

				}

				if($_FILES["datosImagen"]["type"] == "image/png"){

					$ruta = "vistas/img/usuarios/".$_POST["idUsuario"]."/".$aleatorio.".png";

					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/

					$origen = imagecreatefrompng($_FILES["datosImagen"]["tmp_name"]);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagealphablending($destino, FALSE);
    			
					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);

				}

			}

			if($_POST["editarPassword"] == ""){

				$password = $_POST["passUsuario"];

			}else{

				$password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			}

			$datos = array("nombre" => $_POST["editarNombre"],
						   "email" => $_POST["editarEmail"],
						   "password" => $password,
						   "genero" => $_POST["regGenero"],
						   "fenac" => $_POST["regFenac"],
						   "nacionalidad" => $_POST["regNacionalidad"],
						   "rut" => $_POST["regRut"],
						   "edocivil" => $_POST["regEdoCivil"],
						   "ocupacion" => $_POST["regOcupacion"],
						   "profesion" => $_POST["regProfesion"],
						   "celular" => $_POST["regCelular"],
						   "paisres" => $_POST["regPaisRes"],
						   "ciudad" => $_POST["regCiudad"],
						   "direccion" => $_POST["regDireccion"],
						   "cp" => $_POST["regCodPostal"],
						   "foto" => $ruta,
						   "id" => $_POST["idUsuario"]);

			$tabla = "usuarios";

			$respuesta = ModeloUsuarios::mdlActualizarPerfil($tabla, $datos);
			var_dump($respuesta);

			if($respuesta == "ok"){

				$_SESSION["validarSesion"] = "ok";
				$_SESSION["id"] = $datos["id"];
				$_SESSION["nombre"] = $datos["nombre"];
				$_SESSION["foto"] = $datos["foto"];
				$_SESSION["email"] = $datos["email"];
				$_SESSION["password"] = $datos["password"];
				$_SESSION["modo"] = $_POST["modoUsuario"];
				$_SESSION["genero"] = $datos["genero"];
				$_SESSION["fenac"] = $datos["fenac"];
				$_SESSION["nacionalidad"] = $datos["nacionalidad"];
				$_SESSION["rut"] = $datos["rut"];
				$_SESSION["edocivil"] > $datos["edocivil"];
				$_SESSION["ocupacion"] = $datos["ocupacion"];
				$_SESSION["profesion"] = $datos["profesion"];
				$_SESSION["celular"] = $datos["celular"];
				$_SESSION["paisres"] = $datos["paisres"];
				$_SESSION["ciudad"] = $datos["ciudad"];
				$_SESSION["direccion"] = $datos["direccion"];
				$_SESSION["cp"] = $datos["cp"];


				echo '<script> 

						swal({
							  title: "¡OK!",
							  text: "¡Su cuenta ha sido actualizada correctamente!",
							  type:"success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';


			}

		}

	}

	/*=============================================
	SUBIR MULTIMEDIA
	=============================================*/

	static public function ctrSubirMultimedia($datos, $ruta){

		if(isset($datos["tmp_name"]) && !empty($datos["tmp_name"])){

			/*=============================================
			DEFINIMOS LAS MEDIDAS
			=============================================*/

			list($ancho, $alto) = getimagesize($datos["tmp_name"]);	

			$nuevoAncho = 1000;
			$nuevoAlto = 1000;

			/*=============================================
			CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DE LA MULTIMEDIA
			=============================================*/

			$directorio = "../vistas/img/multimedia/".$ruta;

			/*=============================================
			PRIMERO PREGUNTAMOS SI EXISTE UN DIRECTORIO DE MULTIMEDIA CON ESTA RUTA
			=============================================*/

			if (!file_exists($directorio)){

				mkdir($directorio, 0755);
			
			}

			/*=============================================
			DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
			=============================================*/

			if($datos["type"] == "image/jpeg"){

				/*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/

				$rutaMultimedia = $directorio."/".$datos["name"];

				$origen = imagecreatefromjpeg($datos["tmp_name"]);						

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $rutaMultimedia);

			}

			if($datos["type"] == "image/png"){

				/*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/

				$rutaMultimedia = $directorio."/".$datos["name"];

				$origen = imagecreatefrompng($datos["tmp_name"]);						

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagealphablending($destino, FALSE);
		
				imagesavealpha($destino, TRUE);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $rutaMultimedia);

			}

			return $rutaMultimedia;	

		}

	}


	/*=============================================
	MOSTRAR COMPRAS
	=============================================*/

	static public function ctrMostrarCompras($item, $valor){

		$tabla = "compras";

		$respuesta = ModeloUsuarios::mdlMostrarCompras($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR COMENTARIOS EN PERFIL
	=============================================*/

	static public function ctrMostrarComentariosPerfil($datos){

		$tabla = "comentarios";

		$respuesta = ModeloUsuarios::mdlMostrarComentariosPerfil($tabla, $datos);

		return $respuesta;

	}


	/*=============================================
	ACTUALIZAR COMENTARIOS
	=============================================*/

	public function ctrActualizarComentario(){

		if(isset($_POST["idComentario"])){

			if(preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["comentario"])){

				if($_POST["comentario"] != ""){

					$tabla = "comentarios";

					$datos = array("id"=>$_POST["idComentario"],
								   "calificacion"=>$_POST["puntaje"],
								   "comentario"=>$_POST["comentario"]);

					$respuesta = ModeloUsuarios::mdlActualizarComentario($tabla, $datos);

					if($respuesta == "ok"){

						echo'<script>

								swal({
									  title: "¡GRACIAS POR COMPARTIR SU OPINIÓN!",
									  text: "¡Su calificación y comentario ha sido guardado!",
									  type: "success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
								},

								function(isConfirm){
										 if (isConfirm) {	   
										   history.back();
										  } 
								});

							  </script>';

					}

				}else{

					echo'<script>

						swal({
							  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
							  text: "¡El comentario no puede estar vacío!",
							  type: "error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   history.back();
								  } 
						});

					  </script>';

				}	

			}else{

				echo'<script>

					swal({
						  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
						  text: "¡El comentario no puede llevar caracteres especiales!",
						  type: "error",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							   history.back();
							  } 
					});

				  </script>';

			}

		}

	}

	/*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/

	static public function ctrAgregarDeseo($datos){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlAgregarDeseo($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LISTA DE DESEOS
	=============================================*/

	static public function ctrMostrarDeseos($item){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlMostrarDeseos($tabla, $item);

		return $respuesta;

	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/
	static public function ctrQuitarDeseo($datos){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlQuitarDeseo($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	ELIMINAR USUARIO
	=============================================*/

	public function ctrEliminarUsuario(){

		if(isset($_GET["id"])){

			$tabla1 = "usuarios";		
			$tabla2 = "comentarios";
			$tabla3 = "compras";
			$tabla4 = "deseos";

			$id = $_GET["id"];

			if($_GET["foto"] != ""){

				unlink($_GET["foto"]);
				rmdir('vistas/img/usuarios/'.$_GET["id"]);

			}

			$respuesta = ModeloUsuarios::mdlEliminarUsuario($tabla1, $id);
			
			ModeloUsuarios::mdlEliminarComentarios($tabla2, $id);

			ModeloUsuarios::mdlEliminarCompras($tabla3, $id);

			ModeloUsuarios::mdlEliminarListaDeseos($tabla4, $id);

			if($respuesta == "ok"){

		    	$url = Ruta::ctrRuta();

		    	echo'<script>

						swal({
							  title: "¡SU CUENTA HA SIDO BORRADA!",
							  text: "¡Debe registrarse nuevamente si desea ingresar!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   window.location = "'.$url.'salir";
								  } 
						});

					  </script>';

		    }

		}

	}

	/*=============================================
	FORMULARIO CONTACTENOS
	=============================================*/

	public function ctrFormularioContactenos(){

		if(isset($_POST['mensajeContactenos'])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreContactenos"]) &&
			preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["mensajeContactenos"]) &&
			preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["emailContactenos"])){

				/*=============================================
				ENVÍO CORREO ELECTRÓNICO
				=============================================*/

					date_default_timezone_set("America/Bogota");

					$url = Ruta::ctrRuta();	

					// $email= $_POST["emailContactenos"];
				  
					// $para = $email . ', ';
					$para .= 'soporte@alphalifechile.cl';
			  
					$título = 'Ha recibido una consulta';

					$mensaje ='

						<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

						<center><img style="padding:20px; width:10%" src="http://www.tutorialesatualcance.com/tienda/logo.png"></center>

						<div style="position:relative; margin:auto; width:600px; background:white; padding-bottom:20px">

							<center>

							<img style="padding-top:20px; width:15%" src="http://www.tutorialesatualcance.com/tienda/icon-email.png">


							<h3 style="font-weight:100; color:#999;">HA RECIBIDO UNA CONSULTA</h3>

							<hr style="width:80%; border:1px solid #ccc">

							<h4 style="font-weight:100; color:#999; padding:0px 20px; text-transform:uppercase">'.$_POST["nombreContactenos"].'</h4>

							<h4 style="font-weight:100; color:#999; padding:0px 20px;">De: '.$_POST["emailContactenos"].'</h4>

							<h4 style="font-weight:100; color:#999; padding:0px 20px">'.$_POST["mensajeContactenos"].'</h4>

							<hr style="width:80%; border:1px solid #ccc">

							</center>

						</div>

					</div>';

					$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
					$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					$cabeceras .= 'From: <soporte@alphalifechile.cl>' . "\r\n";
	
					$envio = mail($para, $título, $mensaje, $cabeceras);

					if(!$envio){

						echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Ha ocurrido un problema enviando el mensaje!",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';

					}else{

						echo '<script> 

							swal({
							  title: "¡OK!",
							  text: "¡Su mensaje ha sido enviado, muy pronto le responderemos!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	  
											history.back();
										}
							});

						</script>';

					}

			}else{

				echo'<script>

					swal({
						  title: "¡ERROR!",
						  text: "¡Problemas al enviar el mensaje, revise que no tenga caracteres especiales!",
						  type: "error",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							   	window.location =  history.back();
							  } 
					});

					</script>';


			}

		}
		/*==================================================
		OTROS CAMPOS DE CONTACTOS
		===============================================*/
		$("#tipocontactenos").change(function(){
			if($(this).val() == "SOPORTE"){	
				$('#soporte').show();
				$('#soportecontactenos').attr('required','');
				$('#soportecontactenos').attr('data-error', 'this field is required.');
				$('#girocontactenos').attr('required','');
				$('#girocontactenos').attr('data-error', 'this field is required.');
				$('#documentocontactenos').attr('required','');
				$('#documentocontactenos').attr('data-error', 'this field is required.');
				$('#beneficiarioContactenos').attr('required','');
				$('#beneficiarioContactenos').attr('data-error', 'this field is required.');
				
					}else{
						$('#soporte').hide();
						$('#soportecontactenos').removeAttr('required');
						$('#soportecontactenos').removeAttr('data-error');
				                $('#girocontactenos').removeAttr('required');
						$('#girocontactenos').removeAttr('data-error');
						$('#documentocontactenos').removeAttr('required');
						$('#documentocontactenos').removeAttr('data-error');
						$('#beneficiariocontactenos').removeAttr('required');
						$('#beneficiariocontactenos').removeAttr('data-error');
					}
					});
				$("#otroscampos".trigger("change");
				  $("#seesnotherfieldgroup").change(function(){
					  if($(this).val() == "CAMBIAR"){
						  $('#otherfieldgroupdiv').show();
						  $('otherfieldCa').attr('required', '');
						  $('#otherfieldCa').attr('data-error', 'this field is required.');
						  $('#otherfieldCa1').attr('requiered', '');
						  $('#otherfieldCa1').attr('data-error', ' this field is required.');
					  }else{
						  $('#otherfieldgroupdiv').hide();
						  $('#otherfieldCa').removeAttr('required);
						  $('#otherfieldCa').removeAttr('data-error);
						  $('#otherfieldCa1').removeAttr('required');
						  $('#otherfieldCa1').removeAttr('data-error');
										}
										});
						  $("#seeanotherfieldgroup").trigger("change");
						  
					  }
				  }
								    }

	}

}
