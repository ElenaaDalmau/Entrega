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

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contacto</title>

        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="../css/contacto.css">

        <!-- Link favicon -->
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

        <!-- Link para que funcionen los FA FA -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <!--CABECERA-->
        <div id="header">
            <div class="logo">
                <img src="../img/logo.png" alt="COACHING SL">
            </div>
            <nav>
                <ul>
                    <?php
                    if ($_SESSION['Tipo'] == "cliente") { // Si es Admin, mostrar opciones adicionales
                        echo "<li><a href='../index.php'><i class='fa fa-home'></i> <span data-translate='inicio'>Inicio</span></a></li>";
                        echo "<li><a href='ComoTrabajamos.php'><i class='fa fa-briefcase'></i> <span data-translate='como_trabajar'>¿Quiénes somos?</span></a></li>";
                        echo "<li><a href='Contacto.php'><i class='fa fa-phone-square'></i> <span data-translate='contacto'>Puesta en contacto</span></a></li>";
                        echo "<li><a href='ListadoEspe.php'><i class='fa fa-address-book'></i> <span data-translate='especialistas'>Especialistas</span></a></li>";
                        echo "<li><a href='Calendario.php'><i class='fa fa-calendar'></i> <span data-translate='calendario'>Calendario</span></a></li>";
                        echo '<br>';
                    }

                    if ($_SESSION['Tipo'] == "admin") { // Si es Admin, mostrar opciones adicionales
                        echo "<li><a href='../index.php'><i class='fa fa-home'></i> <span data-translate='inicio'>Inicio</span></a></li>";
                        echo "<li><a href='ComoTrabajamos.php'><i class='fa fa-briefcase'></i> <span data-translate='como_trabajar'>¿Quiénes somos?</span></a></li>";
                        echo "<li><a href='FuncionesAdmin.php'><i class='fa fa-address-book'></i><span data-translate='ADMIN'>Admin</span></a></li>";
                        echo '<br>';
                    }
                    if ($_SESSION['Tipo'] == "espe") { // Si es Especialista, mostrar opciones adicionales
                        echo "<li><a href='../index.php'><i class='fa fa-home'></i> <span data-translate='inicio'>Inicio</span></a></li>";
                        echo "<li><a href='ComoTrabajamos.php'><i class='fa fa-briefcase'></i> <span data-translate='como_trabajar'>¿Quiénes somos?</span></a></li>";
                        echo "<li><a href='FuncionesEspe.php'><i class='fa fa-address-book'></i><span data-translate='espe'>espe</span></a></li>";
                        echo '<br>';
                    }
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
    </head>
    <body>
        <?php
            // Declarar los namespaces de PHPMailer al inicio del archivo
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            // Verificar si existe la sesión y el DNI del especialista
            if (!isset($_SESSION['DNI_Especialista'])) {
                die("Error: No se ha iniciado sesión o no se ha configurado el DNI del especialista.");
            }

            // Construir y ejecutar la consulta SQL
            $sql = "SELECT * FROM especialistas WHERE DNI_Especialista = '" . $_SESSION['DNI_Especialista'] . "'";
            $result = mysqli_query($conn, $sql);

            // Validar el resultado de la consulta
            if (!$result) {
                die("Error en la consulta SQL: " . mysqli_error($conn));
            }

            // Obtener los datos
            $row = mysqli_fetch_assoc($result);

            // Verificar si se encontraron resultados
            if (!$row) {
                die("Error: No se encontraron datos para el DNI proporcionado.");
            }


            // Lógica para enviar el correo
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botonESPcon'])) {
                // Incluir PHPMailer
                require './src/Exception.php';
                require './src/PHPMailer.php';
                require './src/SMTP.php';

                // Obtener datos del formulario
                $nombreUsuario = htmlspecialchars($_POST['Nombre']);
                $apellidoUsuario = htmlspecialchars($_POST['Apellido']);
                $correoUsuario = htmlspecialchars($_POST['Correo']);
                $asunto = htmlspecialchars($_POST['Asunto']);
                $mensaje = nl2br(htmlspecialchars($_POST['Mensaje']));

                $mail = new PHPMailer(true);

                try {
                    // Configuración SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'coachingslsants@gmail.com';
                    $mail->Password = 'xdffouvrdnhjnhlm'; // Clave de aplicación
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Configuración del remitente y destinatario
                    $mail->setFrom($correoUsuario, "$nombreUsuario $apellidoUsuario");
                    $mail->addAddress('coachingslsants@gmail.com', 'Coaching SL');
                    $mail->addReplyTo($correoUsuario, "$nombreUsuario $apellidoUsuario");

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = "Nuevo mensaje: $asunto";
                    $mail->Body = "
                    <html>
                        <body>
                            <h3>Nuevo mensaje de contacto</h3>
                            <p><strong>Nombre:</strong> $nombreUsuario</p>
                            <p><strong>Apellido:</strong> $apellidoUsuario</p>
                            <p><strong>Correo:</strong> $correoUsuario</p>
                            <p><strong>Asunto:</strong> $asunto</p>
                            <p><strong>Mensaje:</strong></p>
                            <p>$mensaje</p>
                        </body>
                    </html>";

                    // Enviar el correo
                    $mail->send();
                    echo "<script>alert('Correo enviado exitosamente.');</script>";
                } catch (Exception $e) {
                    echo "<script>alert('Error al enviar el correo: {$mail->ErrorInfo}');</script>";
                }
            }
        ?>

        <!-- FORMULARIO -->
        
        <section id="contactoES">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <!-- Caja para los mensajes -->
                        <div class="caja-mensajes">
                            <h2 class="Tituloes1">¿Necesitas Ayuda?</h2>
                            <h3 class="Tituloes2">Completa este formulario y nos pondremos en contacto contigo</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <form name="sentMessage" id="contactForm" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="formESPcon">
                                    <label for="Nombre"></label>
                                        <input type="text" class="Nombre"  id="Nombre" name="Nombre" required value="<?php echo htmlspecialchars($row['Nombre_Especialista']); ?>" readonly required>
                                        
                                    </div>
                                    <div class="formESPcon">
                                    <label for="Apellido"></label>
                                        <input type="text" class="Apellido" id="Apellido" name="Apellido" required value="<?php echo htmlspecialchars($row['Apellido_Especialista']); ?>" readonly required>
                                        
                                    </div>
                                    <div class="formESPcon">
                                    <label for="Correo"></label>
                                        <input type="email" class="Correo" id="Correo" name="Correo" required value="<?php echo htmlspecialchars($row['Correo_Especialista']); ?>" readonly required>
                                        
                                    </div>
                                    <div class="formESPcon">
                                    <label for="Asunto"></label>
                                        <input type="text" class="Asunto" name="Asunto" placeholder="Asunto *" id="Asunto" required="" >
                                    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="formESPcon">
                                    <label for="Mensaje"></label>
                                        <textarea class="Mensaje" placeholder="Mensaje *" name="Mensaje" id="Mensaje" required="" ></textarea>
                                        
                                    </div>
                                </div>
                                
                                <div class="botonCon">
                                    <div id="botonConESP"></div>
                                    <button type="submit" class="botonESPcon" name="botonESPcon">Enviar</button>
                                </div>
                            </div>

                        </form>
                    
                    </div>
                </div> 
            </div>
        </section>

        <!-- PIE DE PÁGINA -->
        <footer>
            Todos los derechos reservados | Coaching SL Copyright © 2024
        </footer>

        <!-- Link a JavaScript -->
        <script src="../JS/traducciones.js"></script>
    </body>
</html>
