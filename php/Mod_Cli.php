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
        <link rel="stylesheet" href="../css/estilo2.css">

        <!-- Link favicon -->
        <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

        <!-- Link para que funcionen los FA FA -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </head>
    
    <body>

        <!--CABECERA-->
        <div id="header">
            <div class="logo">
                <img src="img/logo.png" alt="COACHING SL">
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

        <!-- CODIGO -->

        <?php

            if (isset($_REQUEST['Modificar'])) {
                // Aseguramos que los valores del formulario estén en las variables
                
                $DNI_Cliente = mysqli_real_escape_string($conn, $_POST['DNI_Cliente']);
                $Nombre_Cliente = mysqli_real_escape_string($conn, $_POST['Nombre_Cliente']);
                $Apellido_Cliente = mysqli_real_escape_string($conn, $_POST['Apellido_Cliente']);
                $FechaNacimiento_Cliente = mysqli_real_escape_string($conn, $_POST['FechaNacimiento_Cliente']);
                $NumTelefono_Cliente = mysqli_real_escape_string($conn, $_POST['NumTelefono_Cliente']);
                $Correo_Cliente = mysqli_real_escape_string($conn, $_POST['Correo_Cliente']);
                $TipoVia_Cliente = mysqli_real_escape_string($conn, $_POST['TipoVia_Cliente']);
                $NombreVia_Cliente= mysqli_real_escape_string($conn, $_POST['NombreVia_Cliente']);
                $NumeroVia_Cliente = mysqli_real_escape_string($conn, $_POST['NumeroVia_Cliente']);
                $Contrasena_Cliente = mysqli_real_escape_string($conn, $_POST['Contrasena_Cliente']);

                // Preparamos la consulta SQL con valores vinculados
                $sql = "UPDATE CLIENTES 
                        SET DNI_Cliente=?, 
                            Nombre_Cliente=?, 
                            Apellido_Cliente=?, 
                            FechaNacimiento_Cliente=?, 
                            NumTelefono_Cliente=?, 
                            Correo_Cliente=?, 
                            TipoVia_Cliente=?, 
                            NombreVia_Cliente=?, 
                            NumeroVia_Cliente=?,
                            Contrasena_Cliente=?
                        WHERE DNI_Cliente=?";

                // Usamos mysqli_prepare y mysqli_stmt_bind_param para vincular las variables
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Vinculamos las variables a la consulta preparada
                    mysqli_stmt_bind_param($stmt, "sssssssssss", 
                        $DNI_Cliente, 
                        $Nombre_Cliente, 
                        $Apellido_Cliente, 
                        $FechaNacimiento_Cliente, 
                        $NumTelefono_Cliente, 
                        $Correo_Cliente, 
                        $TipoVia_Cliente, 
                        $NombreVia_Cliente, 
                        $NumeroVia_Cliente,
                        $Contrasena_Cliente, 
                        $DNI_Cliente); // El último $DNI_Cliente es para la condición WHERE

                    // Ejecutamos la consulta
                    if (mysqli_stmt_execute($stmt)) {
                        header("Location:ConfModCli.php");
                    } else {
                        // Muestra el error de ejecución
                        echo "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
                    }

                    // Cerramos la declaración preparada
                    mysqli_stmt_close($stmt);
                } else {
                    // Si no se puede preparar la consulta
                    echo "Error al preparar la consulta: " . mysqli_error($conn);
                }

            }
                if (isset($_REQUEST['DNI'])){
                    
                    $DNI_Cliente=$_REQUEST['DNI'];

                    $sql="SELECT * FROM Clientes WHERE DNI_Cliente= '$DNI_Cliente';";
            
                    $resultado=mysqli_query($conn,$sql);

                    //! Que estas 
                    if(mysqli_num_rows($resultado)>0)
                    {
                        $row = mysqli_fetch_assoc($resultado);            
                    ?>
        <div id="contenedor_ME">
            <div id="central_ME">
                <div id="modiel">
                    <div class="subtitulo_me">Modificar Cliente</div>
                    <form class="form_ME" action="" method="post">

                    <label class="label_ME" for="ID_Cliente">ID:</label>
                        <input type="text" id="ID_Cliente" readonly name="ID_Cliente" class="caja" value='<?php echo $row['ID_Cliente']?>'>

                    <label class="label_ME" for="DNI_Cliente">DNI:</label>
                        <input type="text" id="DNI_Cliente" name="DNI_Cliente" class="caja" required pattern="[0-9]{8}[A-Za-z]{1}" placeholder="DNI" value='<?php echo $row['DNI_Cliente']?>'>

                    <label class="label_ME" for="Nombre_Cliente">Nombre:</label>
                        <input type="text" id="Nombre_Cliente" name="Nombre_Cliente" class="caja" autofocus required pattern="[a-zA-Z\s]+" placeholder="Nombre" value='<?php echo $row['Nombre_Cliente']?>'>

                    <label class="label_ME" for="Apellido_Cliente">Apellidos:</label>
                        <input type="text" id="Apellido_Cliente" name="Apellido_Cliente" class="caja" required pattern="[a-zA-Z\s]+" placeholder="Apellidos" value='<?php echo $row['Apellido_Cliente']?>'>

                    <label class="label_ME" for="FechaNacimiento_Cliente">Fecha de Nacimiento:</label>
                        <input type="date" name="FechaNacimiento_Cliente" id="FechaNacimiento_Cliente" class="caja" placeholder="Fecha Nacimiento (Año - Mes - Dia)" title="Fecha Nacimiento" value='<?php echo $row['FechaNacimiento_Cliente']?>'>

                    <label class="label_ME" for="NumTelefono_Cliente">Teléfono: </label>
                        <input type="tel" name="NumTelefono_Cliente"  id="NumTelefono_Cliente" class="caja" required placeholder="Telefono" value='<?php echo $row['NumTelefono_Cliente']?>'>

                    <label class="label_ME" for="Correo_Cliente">e-Mail:</label>
                        <input type="email" name="Correo_Cliente" id="Correo_Cliente" class="caja" required placeholder="email" value='<?php echo $row['Correo_Cliente']?>'>

                    <label class="label_ME" for="TipoVia_Cliente">Tipo de la via:</label>
                        <input type="text" class="caja" name="TipoVia_Cliente" id="TipoVia_Cliente" placeholder="Escribe el nombre de la via" value='<?php echo $row['TipoVia_Cliente']?>'>
                    
                    <label class="label_ME" for="NombreVia_Cliente">Nombre de la via:</label>
                        <input type="text" class="caja" name="NombreVia_Cliente" id="NombreVia_Cliente" placeholder="Escribe el nombre de la via" value='<?php echo $row['NombreVia_Cliente']?>'>

                    <label class="label_ME" for="NumeroVia_Cliente">Numero de la via:</label>
                        <input type="text" class="caja" name="NumeroVia_Cliente" id="NumeroVia_Cliente" placeholder="Escribe el número de la via" value='<?php echo $row['NumeroVia_Cliente']?>'>
                    
                    <label class="label_ME" for="Contrasena_Cliente">Contraseña:</label>
                        <input type="password" name="Contrasena_Cliente" id="Contrasena_Cliente" class="caja"required placeholder="Contrasena" value='<?php echo $row['Contrasena_Cliente']?>'>
                    
                        <button type="submit" class="boton_ME" title="Modificar" name="Modificar">Guardar cambios</button>
                    </form>
                    <div class="botoooon_ME">
                        <a href="GestionCli.php">Volver</a>
                    </div>
                </div>
            </div>    
        </div>

        <?php
                    }else{
                        echo "Cliente no encontrado: " . $sql . "<br>" .mysqli_error($conn);
            }
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



