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
      

    if (!$conn) {
        die("Conexion fallida: " . mysqli_connect_error());
    }      

    // Construir la consulta SQL
    $sql = "SELECT * FROM especialistas WHERE DNI_Especialista = '" . $_SESSION['DNI_Especialista'] . "';";

    // Ejecutar la consulta
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
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Opciones de Gestión</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Link favicon -->
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

        <link rel="stylesheet" href="../css/FuncionesAdmin.css"> <!-- Archivo CSS externo -->

    </head>
    <body id="gestion-especialistas">
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

        <!-- FUNCIONES OPCIONES -->
        <div id="FuncionesOpciones">
            <h2><?php echo "¡Bienvenido " . htmlspecialchars($row['Nombre_Especialista']) . " " . htmlspecialchars($row['Apellido_Especialista']) . "!"; ?></h2>
            <div class="opciones">
                <!-- Opción 1 -->
                <div class="opcion-caja">
                    <i class="fa fa-calendar-alt"></i>
                    <h3>¿Deseas ver las citas que tienes asignadas?</h3>
                    <p>Si necesitas consultar las citas que tienes pendiente, puedes verlas aquí.</p>
                    <a href="MisCitasEspe.php">Haz clic aquí</a>
                </div>
                <!-- Opción 2 -->
                <div class="opcion-caja">
                    <i class="fa fa-user-shield"></i>
                    <h3>¿Necesitas consultar con un administrador?</h3>
                    <p>Cualquier duda que tengas sobre tu cuenta o funcionalidades, consúltalo aquí.</p>
                    <a href="ConsultaESPE.php">Haz clic aquí</a>
                </div>
            </div>
        </div>

        <!-- PIE DE PÁGINA -->
        <footer>
            Todos los derechos reservados | Coaching SL Copyright © 2024
        </footer>

        <!-- Link a JavaScript -->
        <script src="../JS/traducciones.js"></script>
    </body>
</html>
