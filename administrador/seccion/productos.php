<?php 
    include("../template/cabezera.php");  
?>

<?php
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
    $txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

    include("../config/db.php");

    switch ($accion) {
        case 'Agregar':
            $sentenciaSQL = $conexion->prepare("INSERT INTO productos (nombre, imagen) VALUES (:nombre, :imagen);");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

            if($tmpImagen != ""){
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();

            header("location:productos.php");
        break;

        case 'Modificar':
            $sentenciaSQL = $conexion->prepare("UPDATE  productos SET nombre = :nombre WHERE id = :id");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            if($txtImagen != ""){

                $fecha = new DateTime();
                $nombreArchivo = ($txtImagen != "")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
                if(isset($producto["imagen"]) && ($producto["imagen"] != "imagen.jpg")){
    
                    if(file_exists("../../img".$producto["imagen"])){
    
                        unlink("../../img".$producto["imagen"]);
    
                    }
                }

                $sentenciaSQL = $conexion->prepare("UPDATE  productos SET imagen = :imagen WHERE id = :id");
                $sentenciaSQL->bindParam(':imagen',$txtNombre);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
            }

            header("location:productos.php");
        break;

        case 'Cancelar':
            header("location:productos.php");
        break;

        case 'Seleccionar':
            $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre = $producto['nombre'];
            $txtImagen = $producto['imagen'];
        break;

        case 'Borrar':
            $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if(isset($producto["imagen"]) && ($producto["imagen"] != "imagen.jpg")){

                if(file_exists("../../img/".$producto["imagen"])){

                    unlink("../../img/".$producto["imagen"]);

                }
            }

            $sentenciaSQL = $conexion->prepare("DELETE FROM productos WHERE id = :id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            header("location:productos.php");
        break;
    }

    $sentenciaSQL = $conexion->prepare("SELECT * FROM productos");
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos del Producto
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID: </label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" id="txtID" name="txtID" placeholder="ID">
                </div>

                <br />
                <div class="form-group">
                    <label for="txtNombre">Nombre: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" id="txtNombre" name="txtNombre" placeholder="Nombre">
                </div>

                <br />
                <div class="form-group">
                    <label for="txtImagen">Imagen: </label>

                    <?php 
                    
                        if($txtImagen!= " "){

                    ?>

                            <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen;?>" width="50" alt="" srcset="">

                    <?php
                    
                        }

                    ?>

                    <br/><br/>
                    <input type="file" class="form-control" id="txtImagen" name="txtImagen" placeholder="Nombre">
                </div>

                <br />
                <div class="btn-group" role="group" aria-label="Button group name">
                    <button type="submit" class="btn btn-success" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar">
                        Agregar
                    </button>
                    <button type="submit" class="btn btn-warning" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar">
                        Modificar
                    </button>
                    <button type="submit" class="btn btn-info" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar">
                        Cancelar
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<div class="col-md-7">
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    foreach($listaProductos as $producto){
                ?>
                    <tr class="">
                        <td scope="row"><?php echo $producto['id'];?></td>
                        <td><?php echo $producto['nombre'];?></td>
                        <td>
                            <img class="img-thumbnail rounded" src="../../img/<?php echo $producto['imagen'];?>" width="50" alt="" srcset="">
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['id'];?>">
                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>

<?php include("../template/pie.php");  ?>