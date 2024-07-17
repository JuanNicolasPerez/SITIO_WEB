<?php

    include("template/cabezera.php");

?>

<?php

    include("administrador/config/db.php");

    $sentenciaSQL = $conexion->prepare("SELECT * FROM productos");
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<?php foreach ($listaProductos as $producto) { ?>

    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="./img/<?php echo $producto['imagen']; ?>" alt="Title" />

            <div class="card-body">
                <h4 class="card-title"><?php echo $producto['nombre']; ?></h4>
                <a target="_blank" id="" class="btn btn-primary" href="https://goalkicker.com/" role="button"> 
                    Ver Mas!
                </a>
            </div>

        </div>
    </div>

<?php } ?>

<?php include("template/pie.php");  ?>