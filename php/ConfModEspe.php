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
                    <i class="fa-solid fa-pen"></i>
                </div>
                <h1 class="conf_titulo">Modificación confirmada</h1>
                <div class="titulo">
                    <?php
                    echo "<p>Se ha modificado correctamente el especialista";
                    ?>
                </div>
                        
                <div class="pie-form">
                    <a class="Confirmacion_boton" href="GestionEspe.php">Continuar</a>
                </div>   
            </div>
        </div> 
    </body>
</html>