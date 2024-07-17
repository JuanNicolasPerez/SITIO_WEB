<?php include("template/cabezera.php");  ?>

                <div class="col-md-12">
                    <div class="p-5 mb-4 bg-light rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 fw-bold">Bienvenido <?php echo $nombreUsuario; ?></h1>
                            <p class="col-md-8 fs-4">
                                Vamos a administrar nuestros productos del sitio web.
                            </p>
                            
                            <a href="seccion/productos.php" class="btn btn-primary btn-lg" role="button">
                                Administrar
                            </a>
                            
                        </div>
                    </div>
                </div>

<?php include("template/pie.php");  ?>