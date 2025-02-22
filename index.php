<?php //Se hace el inicio de sesión del sistema 
	$alert = '';
	session_start(); 
	if (!empty($_SESSION['active'])) { //Se comprueba si existe una sesión activa
		header('location: sistema/');
	}
	else{ 
		if (!empty($_POST)){ //Se comprueba si los input del login estan vacios
			if (empty($_POST['username1']) || empty($_POST['password1'])) {
				$alert = 'Ingrese su usuario y contraseña';
			}
			else{
				require 'php/conexionbd.php'; //Conexión a la base de datos

				
				$user = $_POST['username1'];
				$psw = $_POST['password1'];
				//Consulta para buscar al usuario por nombre de usuario
				$query = mysqli_query($conn,"SELECT * FROM usuarios WHERE username = '$user' ");
				$result = mysqli_num_rows($query);
				


				if ($result > 0) {  
					//Obtener los datos del usuario
					$data = mysqli_fetch_array($query);

					//Verificar la contrasena ingresada con el hash almacenado
					if(password_verify($psw,$data['password'])){
						//Si la contrasena es correcta, iniciar sesion
						session_start();//Asegurate de que las sesiones esten habilitadas
						$_SESSION['active'] = true;
						$_SESSION['idus'] = $data['id'];
						$_SESSION['usernameus'] = $data['username'];
						$_SESSION['rolus'] = $data['rol_id'];
						header('location: sistema/');
					} else{
						$alert = 'Usuario y/o contraseña incorrecto';
						session_destroy();
					}
					
				}
				else{
					$alert = 'Usuario y/o contraseña incorrecto';
					session_destroy();
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head> <!--Atributos necesarios para el funcionamiento-->
	<meta charset="utf-8"> 
	<title>INNOVATEC</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/runa-icon.png">
	<!-- <link rel="stylesheet" href="styles/style.css"> -->
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<style>
		/* Aplica Montserrat a todo el cuerpo de la página */
	body {
		font-family: 'Montserrat', sans-serif;
	}

	/* Ejemplo de uso con variables */
	h1, h2, h3 {
		font-family: 'Montserrat', sans-serif;
		font-weight: 800; /* Usar peso de 700 (negrita) */
	}
	h2{
		margin-top: 50px;
	}

	p {
		font-family: 'Montserrat', sans-serif;
		font-weight: 400; /* Usar peso normal */
	}
	.card-text{
		font-weight: 600;
		line-height:1em;
	}
	li{
		text-align: start;
		line-height:1em; 
		padding-bottom: 10px;
	}
	/* Puedes jugar con las variables de la fuente (weight, width, etc.) */
	.custom-text {
		font-family: 'Montserrat', sans-serif;
		font-weight: 300; /* Peso más delgado */
		font-stretch: 100%; /* Controla el ancho de la fuente (normal) */
	}
    .nav-link:hover {
        color: #eefb03 ;
    }
	.log-in{
		color: #eefb03 ;
	}
	.log-in:hover{
		color: white ;
	}
	.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%23eefb03' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
	}
	.banner{
		height: 100vh;
		padding-left: 6vw;
		background-image: url('images/runneCrafter.webp');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: bottom right; 
		/* background-size:50vw; */
	}
	.servicios{
		padding-top: 100px;
		padding-bottom: 100px;
		
		padding-left: 20vw;
		background-image: url('images/capsula.png');
		background-repeat: no-repeat;
		background-position: 20px center ; 
		background-size:20vw;
	}
	.sesion{
		padding-top: 100px;
		padding-bottom: 100px;
		height: 500px;
		padding-left: 6vw;
		background-image: url('images/cubo.png');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: 90% 90%; 
		background-size:30vw;
	}
	.boton{
		
		background-color: #eefb03 ;
	}
	.boton:hover{
		color: #eefb03;
	}
	.contenido-interno {
        transition: transform 0.3s ease-in-out;
		max-width: 580px;
		background-color: rgb(0,0,0,0.7);
		
		padding: 20px;
		padding-top: 50px;
		transform: translateY(100px);
    }
	.borde{
		
		min-height: 360px;
		background-color: rgb(255,255,255,0.5);
		padding-top:20px;
	}
	.borde h5{

		text-decoration: underline;
		text-decoration-color: #eefb03 ;
		font-weight: 800; /* Usar peso de 700 (negrita) */

	}
	.formulario{
		
		margin: inherit;
		max-width:300px;
	}
	.alert{
		padding-left:0px;
		padding-right:0px;
	}

    @media (max-width: 768px) {
        .contenido-interno {
            
			max-width: 470px;
        }
		
    }
	@media (min-width: 769px) and (max-width: 1024px) {
        .contenido-interno {
            
			max-width: 540px;
        }
			
    }
	@media (max-width: 991px) {
       
		.borde{
		
			min-height: 250px;
			
		}
		.servicio{
			padding-top:20px;
		}
	}
	@media (max-width: 1200px) {
            
		.servicios{
			padding-left: 20px;
		}
    }
	
</style>
</head>
<body>


    <!-- Sección Inicio -->
    <section id="inicio" class="d-flex justify-content-start flex-column align-items-start py-5 bg-black text-white text-center banner">
        
			<div class=" text-start d-flex flex-column contenido-interno">
				<p class="lead text-start">El mejor sistema de inventario rúnico.</p>
				<h1>ELSANTUARIO DE LAS RELIQUIAS ARCANAS</h1>
            	<p class="lead text-start">¡Ven y equipa tu destino o vende al mejor precio!</p>
				
				
				<div class="container formulario">
					<h2 class="">INICIAR SESIÓN</h2>
					<form action= "" method="POST">
						<div class="mb-3 ">
							<label for="loginUser" class="form-label">Usuario</label>
							<input class="form-control" type="text" placeholder="Usuario" name="username1" autocomplete="off" required>
						</div>
						<div class="mb-3">
							<label for="loginPassword" class="form-label">Contraseña</label>
							<input class="form-control" id="loginPassword" type="password" placeholder="Contraseña" name="password1" autocomplete="off" required>
						</div>
						
						<button type="submit" class="btn boton">Iniciar Sesión</button>
						<div class="alert" ><?php echo isset($alert)? $alert : ''; ?></div>
					</form>
        		</div>
			</div>
			
		
    </section>


</body>
</html>