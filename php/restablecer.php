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
<!-- Define que el documento esta bajo el estandar de HTML 5 -->
<!doctype html>
<!-- Representa la raíz de un documento HTML o XHTML. Todos los demás elementos deben ser descendientes de este elemento. -->
<html lang="es">
    <head>
        <meta charset="utf-8">
        
        <title> Login </title>    
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
        
        <!-- Link hacia el archivo de estilos css -->
            <link rel="stylesheet" href="../css/estilo2.css">

        <!-- Link favicon -->
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

        <!-- Link para que funcionen los FA FA -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    </head>

    <body class="confirmaciones_fondo">        

        <!-- Codigo inicio  -->
        <div class="confirmacion_cajagrande">
            <div class="central">
                <div class="conf_fafa">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="titulo">
                    <?php
                    if (isset($_REQUEST['DNI_Cliente'])) {
                        $DNI = mysqli_real_escape_string($conn, $_REQUEST['DNI_Cliente']);

                        // Consultar la base de datos
                        $sql = "SELECT Nombre_Cliente, Apellido_Cliente FROM CLIENTES WHERE DNI_Cliente='$DNI';";
                        $resultado = mysqli_query($conn, $sql);

                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            // Obtener los datos del cliente
                            $row = mysqli_fetch_assoc($resultado);
                            $Nombre_Cliente = $row['Nombre_Cliente'];
                            $Apellido_Cliente = $row['Apellido_Cliente'];
                            
                            //Mensaje de confirmación
                            echo "<h1 class='conf_titulo'>¡Se ha modificado correctamente la contraseña!</h1>";

                            echo "<p class='titulo'>$Nombre_Cliente $Apellido_Cliente se ha modificado correctamente tu contraseña.</p>";
                        }
                    }
                    ?>
                </div>
                    <div class="pie-form">
                        <a class="Confirmacion_boton" href="../index.php">Continuar</a>
                    </div>   
                </div>
            </div>        
        </div>        
        <!-- Link a JavaScript -->
        <script src="../JS/traducciones.js"></script>
    
    </body>
</html>
