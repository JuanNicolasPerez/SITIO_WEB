<?php
    session_start();

    if ($_POST) {
        if (($_POST['usuario'] == "admin") && ($_POST['contrasenia'] == 123)) {

            $_SESSION['usuario'] = "ok";
            $_SESSION['nombreUsuario'] = "admin";

            header("location:inicio.php");
        } else {
            $mensaje = "El Usuario o Contraseña, son incorrectos";
        }
    }
?>

<!doctype html>
<html lang="es">

<head>
    <title>Administrador del sitio web</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <div class="container">
        <div class="row">

            <div class="col-md-4"></div>

            <div class="col-md-4">
                <br /><br /><br /><br /><br />
                <div class="card">

                    <div class="card-header">
                        Login
                    </div>

                    <div class="card-body">

                        <?php 

                            if(isset($mensaje)){ 

                        ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $mensaje;?>
                                </div>

                        <?php 

                            } 

                        ?>
                        <form method="POST">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Usuarios</label>
                                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                            </div>
                            <br />
                            <div class="form-group">
                                <label for="exampleInputPassword1">Contraseña: </label>
                                <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
                            </div>
                            <br />
                            <button type="submit" class="btn btn-primary">Entrar al administrador</button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>