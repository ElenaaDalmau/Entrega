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
        <meta charset="utf-8">
        
        <title> Login </title>    
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
        
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="../css/InicioEspe.css">

        <!-- Link favicon -->
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">


        <!-- Link para que funcionen los FA FA -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
       
    </head>
    
    <body >

        <!--CABECERA-->
        <div id="header">
            <div class="logo">
                <img src="../img/logo.png" alt="COACHING SL">
            </div>
            <nav>
                <ul>
                    <?php
                        echo "<li><a href='../index.php'><i class='fa fa-home'></i> <span data-translate='inicio'>Inicio</span></a></li>";
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

        <!-- INICIO DE SESIÓN -->
        <div class="form-container login-container">
            <?php

                // Verificar conexión
            if (!$conn) {
                die("Error en la conexión a la base de datos: " . mysqli_connect_error());
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IniciarSesion'])) {
                $DNI_Especialista = mysqli_real_escape_string($conn, $_POST['DNI_Especialista']);
                $Contrasena_Especialista = mysqli_real_escape_string($conn, $_POST['Contrasena_Especialista']);

                $sql = "SELECT * FROM ESPECIALISTAS WHERE DNI_Especialista = ?";
                $stmt = mysqli_prepare($conn, $sql);

                // Verificar si la preparación fue exitosa
                if (!$stmt) {
                    die("Error en la preparación de la consulta: " . mysqli_error($conn));
                }

                mysqli_stmt_bind_param($stmt, 's', $DNI_Especialista);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                // Verificar si el resultado es válido
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    // Validar contraseña
                    if ($Contrasena_Especialista === $row['Contrasena_Especialista']) {
                        $_SESSION['Tipo'] = "espe";
                        $_SESSION['DNI_Especialista'] = $row['DNI_Especialista'];
                        header("Location: ComoTrabajamos.php");
                        exit;
                    } else {
                        echo "<script>alert('Contraseña incorrecta');</script>";
                    }
                } else {
                    echo "<script>alert('Usuario no encontrado');</script>";
                }
            }
            else{
            ?>

            <div class="centrar_info">
                <div id="recuperar_global">
                    <div id="recuperar_central">
                        <div id="login">
                            <div class="recuperar_titulo">Iniciar sesión</div>
                            <form action="" method="post">
                                <input type="text" name="DNI_Especialista" required placeholder="Correo">
                                <input type="password" name="Contrasena_Especialista" required placeholder="Contraseña">
                                <button type="submit" name="IniciarSesion">Iniciar Sesión</button>
                            </form>
                        </div>
                    </div>
                </div><!-- recuperar_global -->
            </div> <!-- centrar_info -->
        </div> 

        <?php
            }
        ?>

        <!-- PIE DE PAGINA -->
        <footer>
            Todos los derechos reservados | Coaching SL Copyright © 2024
        </footer>

        <!-- Link a JavaScript -->
        <script src="../JS/traducciones.js"></script>
    </body>
</html>