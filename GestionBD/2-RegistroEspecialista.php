<?php
    include ("1-conexion.php");

    $sql_ESPECIALISTAS = "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('35710210X', 'Jose', 'Gil', '1997-11-20', '634973323', 'jgil@gmail.com', 'C/','Tarragona', '110', 'ES1212341234120123456789', '90.85', 'blancamartinez');";

    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('84276108A', 'Alex', 'Lopez', '1995-04-12', '649561795', 'alopez@gmail.com', 'Av.', 'del Carrilet', '114', 'ES2476831095714658203076', '75.15', 'alexlopez');";

    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('55288172J', 'Blanca', 'Martinez', '1986-10-31', '605403214','bmartinez@gmail.com', 'C/', 'de Cantàbria', '12', 'ES8188358801246553965472', '87.35', 'blancamartinez');";
            
    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('58507369S', 'Antonio', 'Suárez', '1993-10-17', '678952037','asuarez@gmail.com', 'C/', 'del Comte Borrell', '307', 'ES8501517856703099748789', '99.99', 'antoniosuarez');";

    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('61156217E', 'Cecilia', 'Fernandez', '1985-05-26', '696187474', 'cfernandez@gmail.com', 'C/', 'de Leonardo da Vinci', '24', 'ES0420902044318259662746', '120.05', 'ceciliafernandez');";

    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('17801516E','Víctor', 'Herrera', '1991-12-03', '668954318', 'vherrera@gmail.com', 'Pl', 'de les Roses', '', 'ES6520565729624448284452', '97.00', 'victorherrera');";

    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('25899345B', 'Natalia', 'Gutierrez', '1987-03-20', '668436584', 'ngutierrez@gmail.com', 'C/', 'del Doctor Figarola', '16', 'ES3401043936410285983437', '88.88', 'nataliagutierrez');";

    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('36987937G', 'Alicia', 'Torres', '1995-04-27', '665412001', 'atorres@gmail.com', 'C/', 'dels Pensaments', '1', 'ES3301313873110191038048', '92.15', 'aliciatorres');";

    $sql_ESPECIALISTAS .= "INSERT INTO ESPECIALISTAS (DNI_Especialista, Nombre_Especialista, Apellido_Especialista, FechaNacimiento_Especialista, NumTelefono_Especialista, Correo_Especialista,
            TipoVia_Especialista, NombreVia_Especialista, NumeroVia_Especialista, CuentaBancaria_Especialista, Cuota_Especialista, Contrasena_Especialista)
        VALUES
            ('40441106E', 'Sergio', 'Diaz', '1983-11-08', '651300210', 'sdiaz@gmail.com', 'C/', 'de les Delicies', '31', 'ES7301087926891955150150', '110.28', 'sergiodiaz');";

    $Resultado= mysqli_multi_query($conn, $sql_ESPECIALISTAS);

    if ($Resultado)
    {
        echo "9 ESPECIALISTAS añadidos correctamente";
        
    } 
    else 
    {
        echo "Error: " . $sql_ESPECIALISTAS . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
