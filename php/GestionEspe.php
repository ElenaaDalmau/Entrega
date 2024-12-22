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
        <title>Listado Especialista</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="../css/estilo.css">

        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

    </head> 

    <body id="gestioncliente">
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

        <!-- Listado de Especialistas -->
        <div class="titulos">Listado de Especialistas</div>
        <div id="fondo_listado">
            <?php
            $sql = "SELECT E.DNI_Especialista, E.Nombre_Especialista, E.Apellido_Especialista, 
                        ES.Especialidad_Especialista, E.Cuota_Especialista
                    FROM ESPECIALISTAS E
                    JOIN ESPECIALISTA_ESPECIALIDAD EE ON E.ID_Especialista = EE.ID_Especialista_EspeEspe
                    JOIN ESPECIALIDAD ES ON EE.ID_Especialidad_EspeEspe = ES.ID_Especialidad";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="especialista-contenedor">';
                    echo '<h5>Especialista: ' . $row['Nombre_Especialista'] . ' ' . $row['Apellido_Especialista'] . '</h5>';
                    echo '<p>Cuota: ' . $row['Cuota_Especialista'] . '€</p>';
                    echo '<ul>';
                    echo '<li>Especialidad: ' . $row['Especialidad_Especialista'] . '</li>';
                    echo '</ul>';
                    echo '<a class="PRIMERO" href="Mod_Espe.php?DNI=' . $row['DNI_Especialista'] . '">Modificar</a>';
                    echo '<a class="SEGUNDO" href="Elim_Espe.php?DNI=' . $row['DNI_Especialista'] . '">Eliminar</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No se encontraron especialistas.</p>';
            }
            ?>
        </div>

        <!-- PIE DE PÁGINA -->
        <footer>
            Todos los derechos reservados | Coaching SL Copyright © 2024
        </footer>

        <!-- Link a JavaScript -->
        <script src="../JS/traducciones.js"></script>
    </body>
</html>
