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
	<link rel="icon" href="images/icono-logo.png">
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
		margin-bottom: 50px;
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
		background-image: url('images/banner-index.png');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: bottom right; 
		background-size:50vw;
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
		background-color: rgb(0,0,0,0.5);
		padding: 20px;
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
            transform: translateY(-200px); /* Ajusta la cantidad que quieres que suba */
			max-width: 470px;
        }
		
    }
	@media (min-width: 769px) and (max-width: 1024px) {
        .contenido-interno {
            transform: translateY(-100px); /* Ajusta la cantidad que quieres que suba */
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

	 <!-- Navbar -->
	 <nav class="navbar navbar-expand-lg navbar-black bg-black sticky-top" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="#inicio"><img src="images/logo-b.png" width="200" height="auto" title="Logo of a company" alt="Logo of a company" />
			</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    
                    <li class="nav-item ">
                        <a class="nav-link log-in" href="#login">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sección Inicio -->
    <section id="inicio" class="d-flex justify-content-start align-items-center py-5 bg-black text-white text-center banner">
        
			<div class=" text-start d-flex flex-column contenido-interno">
			<p class="lead text-start">CONOCE EL MEJOR</p>
				<h1>SISTEMA DE INVENTARIO Y GESTIÓN DE VENTAS</h1>
            	<p class="lead text-start">Descubre nuestros servicios y planes a tu medida.</p>
				<div class="d-grid gap-2 col-6 ">
					<a href="#login" class="btn boton">Inicar sesion</a>
				</div>
				
				
			</div>
		
    </section>

    <!-- Sección Servicios -->
    <section id="servicios" class=" servicios d-flex">
        <div class="container ">
            <h2 class="text-center">NUESTROS SERVICIOS</h2>
           <div class="row text-center">
			
				<div class="col-lg-4 servicio">
                    <div class="card borde  ">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">SEGURIDAD</h5>
                            <p class="card-text">Acceso completo o limitado dependiendo del rol de usuario.</p>
							<ul>
								<li>Acesso seguro al sistema bajo inicio de sesion</li>
								<li>Administradores tienen incluido los accesos de empleados y tambien pueden modificar, eliminar productos y generar reportes de inventario.</li>
								<li>Acceso al sistema bajo inicio de sesion.</li>
								
							</ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 servicio">
                    <div class="card borde">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">GESTIÓN DE INVENTARIO</h5>
							<p class="card-text">Maneja el inventario de todos tus productos de manera digital.</p>
                            <ul>
								<li>Muestra todo el inventario registrado.</li>
								<li>Motor de busqueda por ID o Nombre del producto.</li>
								<li>Registra, modifica y elimina productos.</li>
								<li>Genera y descarga un reporte personalizado de inventario en formato excel.</li>
							</ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 servicio">
                    <div class="card borde">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">REGISTRO DE VENTAS</h5>
                            <p class="card-text">Cuenta con una barra de busqueda de productos.</p>
							<ul>
								<li>Cuenta con una barra de busqueda de productos.</li>
								<li>Motor de busqueda por ID o Nombre del producto.</li>
								<li>Registra, modifica y elimina productos.</li>
								<li>Genera y descarga un reporte personalizado de inventario en formato excel.</li>
							</ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>



    <!-- Sección Iniciar Sesión -->
    <section id="login" class=" bg-black text-white sesion">
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
    </section>




	
</body>
</html>