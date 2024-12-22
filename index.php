<!-- CONEXION -->
<?php
    session_start();

    $servername = "localhost";
    $username = "sea";
    $database = "coaching";
    $password = "Pr0j3cts3@";
    
    // Creamos la conexion y seleccionamos la base de datos
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Conexion fallida: " . mysqli_connect_error());
    }   
      
?>
<!-- REGISTRO DE NUEVO USUARIO -->
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RegistrarUsuario'])) {
        // Obtener y validar datos del formulario
        $DNI_Cliente = $_POST['DNI_Cliente'];
        $Nombre_Cliente = $_POST['Nombre_Cliente'];
        $Apellido_Cliente = $_POST['Apellido_Cliente'];
        
        $FechaNacimiento_Cliente = $_POST['FechaNacimiento_Cliente'];
        
        $NumTelefono_Cliente = $_POST['NumTelefono_Cliente'];
        $Correo_Cliente = $_POST['Correo_Cliente'];
        
        $TipoVia_Cliente = $_POST['TipoVia_Cliente'];
        $NombreVia_Cliente = $_POST['NombreVia_Cliente'];
        $NumeroVia_Cliente = $_POST['NumeroVia_Cliente'];
        
        $Contrasena_Cliente = $_POST['Contrasena_Cliente'];
        $Tipo = "cliente"; // Siempre es cliente para el registro

        // Consulta para insertar usuario
        $sql = "INSERT INTO CLIENTES 
                    (DNI_Cliente, Nombre_Cliente, Apellido_Cliente, FechaNacimiento_Cliente, NumTelefono_Cliente, Correo_Cliente, TipoVia_Cliente, NombreVia_Cliente, NumeroVia_Cliente, Contrasena_Cliente, Tipo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssssss', $DNI_Cliente, $Nombre_Cliente, $Apellido_Cliente, $FechaNacimiento_Cliente, $NumTelefono_Cliente, $Correo_Cliente, $TipoVia_Cliente, $NombreVia_Cliente, $NumeroVia_Cliente, $Contrasena_Cliente, $Tipo);

        if (mysqli_stmt_execute($stmt)) {
            // Destruir cualquier sesión activa
    
            // Establecer nueva sesión para el cliente registrado
            $_SESSION['DNI_Cliente'] = $DNI_Cliente;
            $_SESSION['ID_Cliente'] = $row['ID_Cliente'];
            $_SESSION['Tipo'] = $Tipo; // Cliente
            header("Location: php/ConfAltaUsuario.php?Nombre_Cliente=$Nombre_Cliente");
            exit;
        } else {
            echo "<script>alert('Error al registrar usuario');</script>";
        }
    }
?>
<?php
            
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IniciarSesion'])) {
        $DNI_Cliente =  $_POST['DNI_Cliente'];
        $Contrasena_Cliente =  $_POST['Contrasena_Cliente'];
    
        $sql = "SELECT * FROM CLIENTES WHERE DNI_Cliente = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $DNI_Cliente);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($Contrasena_Cliente === $row['Contrasena_Cliente']) {
                
                // Establecer nueva sesión con los datos del usuario
                $_SESSION['DNI_Cliente'] = $row['DNI_Cliente'];
                $_SESSION['Tipo'] = $row['Tipo'];
                $_SESSION['ID_Cliente'] = $row['ID_Cliente'];
    
                // Redirigir según el tipo de usuario
                if ($_SESSION['Tipo'] === 'admin') {
                    header("Location: php/ComoTrabajamos.php");
                }
                if ($_SESSION['Tipo'] === 'cliente') {
                    // Obtener los datos del cliente
                    
                    header("Location: php/ComoTrabajamos.php");
                }
                } else {
                    header("Location: php/ComoTrabajamos.php");
                }
                exit;
            } else {
                echo "<script>alert('Dato incorrecta');</script>";
            }
        }
    ?>


<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/inicio.css">
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>

        <div id="header">
            <div class="logo">
                <img src="img/logo.png" alt="COACHING SL">
            </div>
            <nav>
                <ul>
                    <?php
                        echo "<li><a href=''><i class='fa fa-home'></i> <span data-translate='inicio'>Inicio</span></a></li>";
                    //Para controlar el acceso de los usuarios no registrados dentro de nuestra página, hemos decidido que 
                    //solo muestre este enlace como posible ruta
                    ?>
                    
                    <li>               
                        <div class="lenguage-selector">
                            <label for="lenguage"></label>
                            <select name="lenguage" id="lenguage">
                                <option value="es" data-translate="espanol">Español</option>
                                <option value="ca" data-translate="catalan">Catalan</option>
                                <option value="en" data-translate="ingles">Inglés</option>
                                <option value="fr" data-translate="frances">Francés</option>
                                <option value="it" data-translate="italiano">Italiano</option>
                                <option value="eu" data-translate="euskera">Euskera</option>
                                <option value="gl" data-translate="gallego">Gallego</option>
                                <option value="su" data-translate="sueco">Sueco</option>
                            </select>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>

            <div class="form-container sign-up-container">
                <div class="Inicio_fondoo">
                    <div class="Contenedor_Inicio">
                    <h1>COACHING SL</h1>
                    <p class="frase_inicio">¡Bienvenido a la página que te va a cambiar la forma de ver tu vida!</p>
                </div>
            </div>

            <hr class="highlight"/> <!-- SEPARADOR-->

            <div class="gestioncliente" id="container">
                <form class="cliente-contenedor" action="" method="post">
                    <h1 class="titulos">Regístrate</h1>
                    <input type="text" name="DNI_Cliente" required pattern="[0-9]{8}[A-Za-z]{1}" placeholder="DNI">
                    <input type="tel" name="NumTelefono_Cliente" required placeholder="Teléfono">
                    <input type="email" name="Correo_Cliente" required placeholder="Correo">
                    <input type="text" name="Nombre_Cliente" required pattern="[a-zA-Z\s]+" placeholder="Nombre">
                    <input type="text" name="Apellido_Cliente" required pattern="[a-zA-Z\s]+" placeholder="Apellidos">
                    <input type="password" name="Contrasena_Cliente" required placeholder="Contraseña">
                    <input type="date" name="FechaNacimiento_Cliente" placeholder="Fecha de Nacimiento">
                    <input type="text" name="NombreVia_Cliente" placeholder="Nombre de la vía">
                    <input type="text" name="NumeroVia_Cliente" placeholder="Número de la vía">
                    <input type="text" name="TipoVia_Cliente" placeholder="Tipo de vía">
                <!-- <input type="text" name="Tipo" placeholder="Tipo"> -->
                    <button class="acciones" type="submit" name="RegistrarUsuario">Registrarse</button>
                </form>
            </div>

            <!-- INICIO DE SESIÓN -->
            <div class="form-container login-container">
                <form class="cliente-contenedor" action="" method="post">
                    <h1>Iniciar Sesión</h1>
                    <input type="text" name="DNI_Cliente" required placeholder="DNI">
                    <input type="password" name="Contrasena_Cliente" required placeholder="Contraseña">
                    <button class="acciones" type="submit" name="IniciarSesion">Iniciar Sesión</button>
                    <a class="acciones" href="php/recuperar.php">He olvidado la contraseña</a>
                </form>
            </div>
            <a class="enlaceess" href="php/inicioESPE.php">Iniciar Sesión Especialista</a>
        </div>

        <hr class="highlight"/> <!-- SEPARADOR-->

        <section id="about">
            <div class="container">
                <div class="explicacionQueVasAEncontrar">
                    <h2>¿Qué vas a encontrar aquí dentro?</h2>
                    <p>¿Porqué esta página web y no otra página? ¿Porqué nuestros servicios y no otros? A continuación, te explicaremos el porqué deberías de escogernos a nosotros, y no a cualquier otra empresa:</p>
                </div>
            
                <br>
                <hr class="highlight"/> <!-- SEPARADOR-->
                <br>

                <ul class="GlobalApartadosInfo">
                <li>
                    <i class="fa-solid fa-user-tie lock-icon"></i>
                    <h4 class="TitulosApartados">1. Ayuda profesional elegida por ti</h4>
                    <div class="TextExplApartados">
                        <p>Aquí dentro, podrás escoger entre diversos profesionales aquel que creas que es el indicado para ti.</p>
                    </div>
                </li>      
                <li>
                    <i class="fa-solid fa-book-open lock-icon"></i>
                    <h4 class="TitulosApartados">2. La especialidad que más prefieras</h4>
                    <div class="TextExplApartados">
                        <p>Podrás investigar que servicios ofrecemos y, de entre todas las opciones, escoger aquella que creas que se adapta mejor a tus necesidades.</p>
                    </div>
                </li>
                    <li>
                    <i class="fa-regular fa-lightbulb lock-icon"></i>
                    <h4 class="TitulosApartados">3. ¿No sabes que hacer?</h4>
                    <div class="TextExplApartados">
                        <p>Ofrecemos la posibilidad de contactar con nosotros para pedir consejos. ¡Nosotros siempre estaremos dispuestos a ayudarte!</p>
                    </div>
                    </li>
            
                    <li>
                    <i class="fa-solid fa-calendar-days lock-icon"></i>
                    <h4 class="TitulosApartados">4. Modificar fechas</h4>
                    <div class="TextExplApartados">
                        <p>Si has reservado una cita y, cuando se acerca la fecha, te das cuenta que finalmente no podrás asistir, ¡no te preocupes! Ofrecemos la opción de anular citas programadas sin consecuencias.</p>
                    </div>
                    </li>
            
                    <li>
                    <i class="fa-solid fa-lock lock-icon"></i>
                    <h4 class="TitulosApartados">5. Privacidad</h4>
                    <div class="TextExplApartados">
                        <p>Ofrecemos privacidad con todo aquello que cuentes: nadie se va a enterar de las cosas que comentas o explicas con nuestros especialistas.</p>
                    </div>
                    </li>
            
                    <li>
                    <i class="fa-regular fa-credit-card lock-icon"></i>
                    <h4 class="TitulosApartados"> 6. Método de pago</h4>
                    <div class="TextExplApartados">
                        <p>Podrás escoger que método de pago deseas utilizar, pudiendo pagar en efectivo o desde la web. Ofrecemos la opción de poder pagar una cantidad antes de realizar la sesión.</p>
                    </div>
                    </li>
                </ul>
            </div>
        </section>

            <br>
                <hr class="highlight"/> <!-- SEPARADOR-->
            <br>


        <!-- PIE DE PAGINA -->
        <footer>
            Todos los derechos reservados | Coaching SL Copyright © 2024
        </footer>

        <!-- Link a JavaScript -->
        <script src="JS/traducciones.js"></script>

    </body>
</html>
