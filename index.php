<?php //Se hace el inicio de sesión del sistema 
	$alert = '';
	session_start(); 
	if (!empty($_SESSION['active'])) { //Se comprueba si existe una sesión activa
		header('location: sistema/');
	}
	else{ 
		if (!empty($_POST)){ //Se comprueba si los input del login estan vacios
			if (empty($_POST['username']) || empty($_POST['password'])) {
				$alert = 'Ingrese su usuario y contraseña';
			}
			else{
				require 'php/conexionbd.php'; //Conexión a la base de datos

				
				$user = $_POST['username'];
				$psw = $_POST['password'];
				//Consulta para buscar al usuario por nombre de usuario
				$query = mysqli_query($conn,"SELECT * FROM usuarios WHERE username = '$user' ");
				$result = mysqli_num_rows($query);
				


				if ($result > 0) {
					// Obtener los datos del usuario
					$data = mysqli_fetch_array($query);
					
					// Verificar la contraseña ingresada con el hash almacenado
					if(password_verify($psw,$data['password'])){
						// Verificar el rol del usuario
						if ($data['rol_id'] == 1 || $data['rol_id'] == 2) { // Suponiendo que 1 es administrador y 2 es vendedor, ajusta según tu lógica
							// Si el rol es permitido, iniciar sesión
							session_start();
							$_SESSION['active'] = true;
							$_SESSION['idus'] = $data['id'];
							$_SESSION['usernameus'] = $data['username'];
							$_SESSION['rolus'] = $data['rol_id'];
							header('location: sistema/');
						} else {
							$alert = 'No tienes acceso al sistema.';
							session_destroy();
						}
					} else {
						$alert = 'Usuario y/o contraseña incorrectos';
						session_destroy();
					}
				}
				
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head> <!--Atributos necesarios para el funcionamiento-->
	<meta charset="utf-8"> 
	<title>LA FORJA ARCANA</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/runa-icon.png">
	<!-- <link rel="stylesheet" href="styles/style.css"> -->
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
	<link rel="stylesheet" href="styles/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>


    <!-- Sección Inicio -->
    <section id="inicio" class="d-flex justify-content-center flex-column align-items-start  bg-black text-white text-center banner">
        
			<div class=" text-start d-flex flex-column contenido-interno">
				<p class="text-start">El mejor sistema de inventario rúnico.</p>
				<h1>LA FORJA ARCANA</h1>
            	<p class="text-start">¡Ven y equipa tu destino o vende al mejor precio!</p>
				
				
				<div class="container formulario">
					<h2 class="">INICIAR SESIÓN</h2>
					<form action= "" method="POST">
						<div class="mb-3 ">
							<label for="username" class="form-label">Usuario</label>
							<input class="form-control form-control-sm" type="text" id="username" placeholder="Usuario" name="username" autocomplete="off" required>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Contraseña</label>
							<input class="form-control form-control-sm" id="password" type="password" placeholder="Contraseña" name="password" autocomplete="off" required>
						</div>
						
						<button type="submit" class="btn boton">Iniciar Sesión</button>
						<div class="alert" ><?php echo isset($alert)? $alert : ''; ?></div>
					</form>
        		</div>
			</div>
			
		
    </section>


</body>
</html>