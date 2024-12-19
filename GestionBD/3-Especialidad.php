<?php
    include ("1-conexion.php");
    
    $sql_ESPECIALIDAD = "INSERT INTO ESPECIALIDAD (Especialidad_Especialista)
        VALUES ('Coaching Empresarial')";
    $sql_ESPECIALIDAD .= ", ('Coaching Personal')";
    $sql_ESPECIALIDAD .= ", ('Coaching con Inteligencia Emocional')";
    $sql_ESPECIALIDAD .= ", ('Coaching Deportivo')";
    $sql_ESPECIALIDAD .= ", ('Coaching Ontológico')";
    $sql_ESPECIALIDAD .= ", ('Coaching Cognitivo')";
    $sql_ESPECIALIDAD .= ", ('Coaching PNL (Programación Neurolingüística)')";
    $sql_ESPECIALIDAD .= ", ('Coaching Coercitivo')";
    $sql_ESPECIALIDAD .=";";

    $Resultado= mysqli_multi_query($conn, $sql_ESPECIALIDAD);

    if ($Resultado)
    {
        echo "8 ESPECIALIDADES añadidas correctamente";
        
    } 
    else 
    {
        echo "Error: " . $sql_ESPECIALIDAD . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
