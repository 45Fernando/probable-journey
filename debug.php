<?php 
    session_start();

    //Se agrego esta funcion
    function agregarTrabajo($nombre, $descripcion, $estado, $file){           
        
        $ubicacion = subirArchivo($file);

        echo "Trabajo agregado exitosamente";
        echo "<br>";
        echo $nombre;
        echo "<br>";
        echo $descripcion;
        echo "<br>";
        echo $estado;
        echo "<br>";
        echo $ubicacion;
        echo "<br>";

        
    }

    function subirArchivo($file){
        $ubicacion ="";
        if(isset($file) && $file["error"] == 0){
            $allowed = array("pdf" => "application/pdf");
            $filename = $file["name"]; // devuelve el nombre con la extesion
            $filetype = $file["type"];
            $filesize = $file["size"];

                   
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Error: No es un formato de archivo válido");
        
            // Verificar tamaño máximo
            $maxsize = 25 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: El archivo tiene un tamaño muy grande");
        
            if(in_array($filetype, $allowed)){
                //$nombreArchivo= rand().".pdf";
                $nuevoNombre = rand().".pdf";
                move_uploaded_file($file["tmp_name"],  $nuevoNombre);
                //echo "Archivo enviado exitosamente";
                $ubicacion = $nuevoNombre;
            } else{
                echo "Error: Hubo un problema al subir el archivo, intentar nuevamente"; 
            }
        } else{
            echo "Error: " . $file["error"];
        }
        return $ubicacion;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //agregarTrabajo($_POST["nombre"],$_POST["descripcion"],$_POST["estado"],subirArchivo($_POST["archivo"]));
        agregarTrabajo($_POST["nombre"],$_POST["descripcion"],$_POST["estado"],$_FILES["archivo"]);
    }

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Formulario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
</head>


<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Subir un nuevo archivo</h1>
        </div>
    </div>
    <div class="centrar card">
        <!--
            <div class="alert alert-danger" role="alert">
            </div>
        -->
        <!-- form class="card-body" action="" method="post" enctype="multipart/form-data"> -->
        <form class="card-body" action="" method="post" enctype="multipart/form-data">
            <!--nombre del trabajo -->
            <div class="form-group">
                <label>Nombre del artículo</label>
                <!-- <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" required> -->
                <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" required>
            </div>
            <!--descripcion--> 
            <div class="form-group">
                <label>Breve descripción del artículo</label>
                <!--<input id="ddescripcion" name="descripcion" type="text" class="form-control" placeholder="Descripción" maxlength="200" required  aria-describedby="ddescripcion"> -->
                <input id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Descripción" maxlength="200" required  aria-describedby="descripcionLong">
                <small id="descripcionLong" class="text-muted">  long. máxima: 200 caracteres </small>
            </div>
          
           <input type="hidden" name="estado" value="Pendiente">

            <div class="form-group">
                <label>Archivo</label>
                <!-- <input name="archivo" id="fileSelect" type="file" class="form-control" placeholder="Archivo" required> -->
                <input name="archivo" id="archivo" type="file" class="form-control" placeholder="Archivo" required>
                <span class="help-block"> Solo se aceptarán pdf, tamaño máximo 25MB</span>
           </div>
            
            <input type="submit" class="btn btn-primary" name="submit" value="Enviar">      
            <a href="portal.php" class="btn btn-primary">Cancelar</a>   
        </form>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </div>
</body>
</html>