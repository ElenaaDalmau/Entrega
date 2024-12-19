<?php
    include ("1-conexion.php");

$sql_Cliente = "INSERT INTO CLIENTES 
                        (DNI_Cliente, Nombre_Cliente, Apellido_Cliente, FechaNacimiento_Cliente, NumTelefono_Cliente, Correo_Cliente, TipoVia_Cliente, NombreVia_Cliente, NumeroVia_Cliente, Contrasena_Cliente, Tipo)
                    VALUES ('11111111A', 'Admin', 'Admin', '1111-11-11', '111111111','admin@admin.com','Admin', 'Admin','1','Admin','Admin')";
    
    $Resultado= mysqli_multi_query($conn, $sql_Cliente);

    if ($Resultado)
    {
        echo "Admin añadido añadidos correctamente";
        
    } 
    else 
    {
        echo "Error: " . $sql_Cliente . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>








