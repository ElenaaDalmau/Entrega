<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pago</title>
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="../css/pago.css">
        <!-- Link favicon -->
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
        <!-- Link para que funcionen los FA FA -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="Fondo_pago">
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

                if (!isset($_SESSION['DNI_Cliente'])) {
                    die("Error: DNI_Cliente no está definido.");
                }
                    $DNI_Cliente = $_SESSION['DNI_Cliente'];
                    $sql_cliente = "SELECT * FROM CLIENTES WHERE DNI_Cliente = '$DNI_Cliente'";
                    $resultado_cliente = mysqli_query($conn, $sql_cliente);

                if (!$resultado_cliente || mysqli_num_rows($resultado_cliente) == 0) {
                    die("Error: No se encontraron datos del cliente.");
                }
                $cliente = mysqli_fetch_assoc($resultado_cliente);
                $sql_especialista = "SELECT E.Nombre_Especialista, E.Apellido_Especialista, E.Cuota_Especialista
                                    FROM CITAS C
                                    JOIN ESPECIALISTAS E ON C.ID_Especialista_Cita = E.ID_Especialista
                                    WHERE C.ID_Cliente_Cita = (SELECT ID_Cliente FROM CLIENTES WHERE DNI_Cliente = '$DNI_Cliente')
                                    LIMIT 1;";

                    $resultado_especialista = mysqli_query($conn, $sql_especialista);
                if (!$resultado_especialista || mysqli_num_rows($resultado_especialista) == 0) {
                    die("Error: No se encontraron datos del especialista.");
                }
                    $especialista = mysqli_fetch_assoc($resultado_especialista);
                // Insertar datos de pago en la tabla `PAGOS`
                $cuota_especialista = $especialista['Cuota_Especialista']; // Cuota del especialista

                // Insertar datos de pago en la tabla `PAGOS`
                $fecha_pago = date('Y-m-d');
                
                // Obtener el ID del cliente
                $sql_id_cliente = "SELECT ID_Cliente FROM CLIENTES WHERE DNI_Cliente = '$DNI_Cliente'";
                $resultado_id_cliente = mysqli_query($conn, $sql_id_cliente);

                if ($resultado_id_cliente && mysqli_num_rows($resultado_id_cliente) > 0) {
                    $row_cliente = mysqli_fetch_assoc($resultado_id_cliente);
                    $id_cliente = $row_cliente['ID_Cliente'];

                    // Insertar datos en la tabla de pagos
                        $sql_insert_pago = "INSERT INTO PAGOS (Fecha_Pago, ID_Pago_Cliente, Cantidad_Pago)
                        VALUES ('$fecha_pago', '$id_cliente', '$cuota_especialista')";

                    if (mysqli_query($conn, $sql_insert_pago)) {
                        echo "";
                    } else {
                        die("Error al insertar el pago: " . mysqli_error($conn));
                    }
                } else {
                    die("Error: No se encontró el cliente en la base de datos.");
                }
            ?>

        <div class="container">
            <!-- Sección izquierda -->
            <div class="infoEspecialista">
                <h2>Especialista</h2>
                <p>Ha escogido a:</p>
                <input type="text" id="Nombre_Especialista" value="<?php echo $especialista['Nombre_Especialista']; ?>" readonly>
                <input type="text" id="Apellido_Especialista" value="<?php echo $especialista['Apellido_Especialista']; ?>" readonly>
                <p>Cuota del Especialista:</p>
                <input type="number" id="Cuota_Especialista" value="<?php echo $especialista['Cuota_Especialista']; ?>" readonly>
            </div>
            <!-- Sección derecha -->
            <div class="formularioPago">
                <h3>Elige tu método de pago</h3>
                <div class="metodo">
                    <button class="metodo"><i class="fa-brands fa-cc-mastercard"></i></button>
                    <button class="metodo"><i class="fa-brands fa-cc-visa"></i></button>
                    <button class="metodo"><i class="fa-brands fa-paypal"></i></button>
                    <button class="metodo"><i class="fa-brands fa-apple-pay"></i></button>
                    <button class="metodo"><i class="fa-brands fa-cc-amex"></i></button>
                    <button class="metodo"><i class="fa-solid fa-plus"></i></button>
                </div>
                <div class="DatosCliente">
                    <h3>Datos de pago</h3>
                    <label for="Nombre_Cliente">Nombre:</label>
                        <input type="text" id="Nombre_Cliente" value="<?php echo $cliente['Nombre_Cliente']; ?>" readonly>
                    <label for="Apellido_Cliente">Apellidos:</label>
                        <input type="text" id="Apellido_Cliente" value="<?php echo $cliente['Apellido_Cliente']; ?>" readonly>
                    <label for="DNI_Cliente">DNI:</label>
                        <input type="text" id="DNI_Cliente" value="<?php echo $cliente['DNI_Cliente']; ?>" readonly>
                    <label for="Fecha_Pago">Fecha de Hoy:</label>
                        <input type="text" id="Fecha_Pago" value="<?php echo date('Y-m-d'); ?>" readonly>

                        <div class="terminos_check">
                            <input type="checkbox" id="terminos" name="terminos" value="Acepto los términos de la página" required>
                                <label for="terminos" >Acepto los términos de la página</label>
                        </div>
                    </div>
                    <div class="button_contenedor">
                        <form action="ConfPago.php" method="POST">
                            <input type="hidden" name="Nombre_Cliente" value="<?php echo $cliente['Nombre_Cliente']; ?>">
                            <input type="hidden" name="Apellido_Cliente" value="<?php echo $cliente['Apellido_Cliente']; ?>">
                            <input type="submit" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            Todos los derechos reservados | Coaching SL Copyright © 2024
        </footer>
        <!-- Link a JavaScript -->
        <script src="../JS/pago.js"></script>
        <script src="../JS/AceptaC.js"></script>
    </body>
</html>
