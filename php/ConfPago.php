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

    // Validar que el DNI del cliente esté definido en la sesión
    if (!isset($_SESSION['DNI_Cliente'])) {
        die("Error: No se ha iniciado sesión correctamente. DNI_Cliente no está definido.");
    }

    // Obtener el DNI del cliente desde la sesión
    $DNI_Cliente = $_SESSION['DNI_Cliente'];

    // Consulta SQL para obtener los datos del cliente
    $sql_cliente = "SELECT Nombre_Cliente, Apellido_Cliente FROM CLIENTES WHERE DNI_Cliente = '$DNI_Cliente'";
    $resultado_cliente = mysqli_query($conn, $sql_cliente);

    // Validar el resultado de la consulta
    if (!$resultado_cliente || mysqli_num_rows($resultado_cliente) == 0) {
        die("Error: No se encontraron datos del cliente.");
    }

    // Obtener los datos del cliente
    $cliente = mysqli_fetch_assoc($resultado_cliente);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contacto</title>
        
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="../css/estilo2.css">

        <!-- Link favicon -->
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

        <!-- Link para que funcionen los FA FA -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </head>

        
    <body class="confirmaciones_fondo">
    <!-- CODIGO CONFIRMACION -->
        <div class="confirmacion_cajagrande">
            <div class="central">
                <div class="conf_fafa">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h1 class="conf_titulo">Confirmación de Pago</h1>
                <div class="titulo">
                    <?php
                        echo "<p>Se ha realizado correctamente el pago del cliente " . htmlspecialchars($cliente['Nombre_Cliente']) . " " . htmlspecialchars($cliente['Apellido_Cliente']) . ". </p>";
                    ?>
                </div>
                    
                <div class="pie-form">
                    <a class="Confirmacion_boton" href="ComoTrabajamos.php">Continuar</a>
                </div>   
            </div>
        </div>

        <!-- Link a JavaScript -->
        <script src="../JS/traducciones.js"></script>
    </body>
</html>