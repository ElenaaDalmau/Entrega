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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reservar cita</title>
        <link rel="stylesheet" href="../css/reservar.css">
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
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
                            echo "<li><a href='Pago.html'><i class='fa fa-calendar'></i> <span data-translate='calendario'>Calendario</span></a></li>";
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
        <?php

        if (isset($_POST['DNI_Especialista'])) 
        {
            $DNI_Especialista = $_POST['DNI_Especialista'];

            // Obtener información del especialista
            $sqlEspecialista = "SELECT * FROM especialistas WHERE DNI_Especialista='$DNI_Especialista';";
            $resultadoEspecialista = mysqli_query($conn, $sqlEspecialista);

            if ($resultadoEspecialista && mysqli_num_rows($resultadoEspecialista) > 0) 
            {

                
                $especialista = mysqli_fetch_assoc($resultadoEspecialista);
                $ID_Especialista = $especialista['ID_Especialista'];
                $Coste= $especialista['Cuota_Especialista'];


                echo '<div class="infoEspecialista">';
                echo '<h2>Especialista</h2>';
                echo '<p>Ha escogido a:</p>';
                echo '<input type="text" value="' . htmlspecialchars($especialista['Nombre_Especialista']) . '" readonly>';
                echo '<input type="text" value="' . htmlspecialchars($especialista['Apellido_Especialista']) . '" readonly>';
                echo '</div>';

                // Consulta para obtener la disponibilidad del especialista
                $sqlDisponibilidad = "SELECT * FROM DISPONIBILIDAD_ESPECIALISTA 
                WHERE ID_Especialista_DispoEspe = 
                (SELECT ID_Especialista FROM especialistas WHERE DNI_Especialista='$DNI_Especialista');";

                // Consulta para obtener la disponibilidad del especialista
                $sqlDisponibilidad = "SELECT * FROM DISPONIBILIDAD_ESPECIALISTA WHERE ID_Especialista_DispoEspe = (SELECT ID_Especialista FROM especialistas WHERE DNI_Especialista='$DNI_Especialista');";
                $resultadoDisponibilidad = mysqli_query($conn, $sqlDisponibilidad);

                if ($resultadoDisponibilidad && mysqli_num_rows($resultadoDisponibilidad) > 0) {
                    $diasDisponibles = ["Lunes" => [], "Martes" => [], "Miercoles" => [], "Jueves" => [], "Viernes" => []];
                    
                    while ($row = mysqli_fetch_assoc($resultadoDisponibilidad)) {
                        if ($row['Lunes']) $diasDisponibles["Lunes"][] = $row['Hora_Dispo'];
                        if ($row['Martes']) $diasDisponibles["Martes"][] = $row['Hora_Dispo'];
                        if ($row['Miercoles']) $diasDisponibles["Miercoles"][] = $row['Hora_Dispo'];
                        if ($row['Jueves']) $diasDisponibles["Jueves"][] = $row['Hora_Dispo'];
                        if ($row['Viernes']) $diasDisponibles["Viernes"][] = $row['Hora_Dispo'];
                    }

                    // Recopilamos los días válidos
                    foreach ($diasDisponibles as $dia => $horarios) {
                        if (count($horarios) > 0) {
                            switch ($dia) {
                                case "Lunes":
                                    $DiaValido[] = 1;
                                    break;
                                case "Martes":
                                    $DiaValido[] = 2;
                                    break;
                                case "Miercoles":
                                    $DiaValido[] = 3;
                                    break;
                                case "Jueves":
                                    $DiaValido[] = 4;
                                    break;
                                case "Viernes":
                                    $DiaValido[] = 5;
                                    break;
                                }

                                $data = json_decode(file_get_contents("php://input"), true);
                                
                            // if ($data ['RES']='TRUE') {
                            $id_cliente = $_SESSION['ID_Cliente'];
                            
                            if (isset($_REQUEST['Reservar'])){
                                $dia = $_REQUEST['fecha'];
                                $hora = $_REQUEST['horarios'];
                                $SQL= "INSERT INTO CITAS (Fecha_Cita, Hora_Cita, Coste_Cita, ID_Especialista_Cita, ID_Cliente_Cita) VALUES ('$dia', '$hora', $Coste, $ID_Especialista, $id_cliente);";
                                $result = mysqli_query($conn, $SQL);
                                if ($result){
                                    // Redirigir a la página de pago
                                header("Location: Pago.php");
                                exit;  // Asegura que el script se detenga después de redirigir
                            } else {
                                echo "<script>alert('Error al reservar la cita.');</script>";
                            }
                            }
                        }
                    }

                    // Imprimir el formulario de selección de horario
                    echo '<form method="POST" action="">';
                    echo '<label>Horarios:</label>';
                    echo '<select name="horarios">';
                    echo '<option> Seleccione un horario</option>';

                    foreach ($diasDisponibles as $dia => $horarios) {
                        foreach ($horarios as $horario) {
                            echo '<option value="' . htmlspecialchars($horario) . '">' . htmlspecialchars($horario) . '</option>';
                        }
                    }

                    echo '</select><br>';
                    echo '<label for="Calendario">Selecciona una fecha:</label>';
                    echo '<input type="date" id="Calendario" name="fecha" />';

                    // Pasar los días válidos a JavaScript
                    echo '<input type="hidden" id="DiaValido" value="' . json_encode($DiaValido) . '" />';
                    echo '<input type="hidden" name="DNI_Especialista" value="' . htmlspecialchars($DNI_Especialista) . '">';
                    echo '<button type="submit" name="Reservar">Reservar Cita</button>';
                    echo '</form>';
                } else {
                    echo "No se encontró disponibilidad.";
                }
            } else {
                echo "Especialista no encontrado.";
            }
        }
        ?>

        <footer>
            Todos los derechos reservados | Coaching SL Copyright © 2024
        </footer>
        <script type="text/javascript">
            document.addEventListener('change', function() {
                var condicion = JSON.parse(document.getElementById('DiaValido').value);
            
            
                ComprobarFecha(condicion);
            });

            function ComprobarFecha(condicion) {
                const InputFecha = document.getElementById("Calendario");
                const selectedDate = new Date(InputFecha.value);
                
                const day = selectedDate.getDay();  
                console.log("Días válidos:", condicion);  // Controla días válidos
                console.log("Día seleccionado:", day);  // Muestra el día 

            
                if (!condicion.includes(day)) {
                    alert("Por favor, selecciona un día disponible.");
                
                    InputFecha.value = "";  // Limpiar el valor si no es un día que nos sirva
                }else{
                    fetch("procesar.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"  // Enviar los datos
                    },
                    body: JSON.stringify('RES:TRUE')  // Convertir el objeto a JSON
                    })
                    .then(response => response.json())  //respuesta en  JSON
                    .then(data => {
                        console.log("Respuesta del servidor:", data); 
                        document.getElementById("respuesta").innerHTML = data.message;  
                    })
                    .catch(error => {
                        console.error("Error:", error);  // En caso de error
                });
                
                }
            }
        </script>
    </body>
</html>  

