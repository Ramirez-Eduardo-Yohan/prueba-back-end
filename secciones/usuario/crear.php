<?php
//despues a apretar el boton de enviar los datos vienen por el metodos POST
//y tengo agregar un nuevo registro al la base de dato del usuario
//conecto la base de datos

//veo que biene por el metodo post del formulario
if($_POST){
    require_once("../../bd.php");
    //en una variable verifico si tiene algo
    //isset:deja ver si tiene algo 
    //si tiene algo le asigna a la variables lo que esta despues de del signo ?
    //guardo el dato que vino en la super variable en el NOMBRE
    $nombreDelUsuario =(isset($_POST["nombreDelUsuario"]) ? $_POST["nombreDelUsuario"]:"");
    //guardo el dato que vino en la super variable en el CONTRACEÑA
    $contracenaDelUsuario =(isset($_POST["contracenaa"]) ? $_POST["contracenaa"]:"");
    //guardo el dato que vino en la super variable en el correo
    $correoDelUsuario =(isset($_POST["correoo"])?$_POST["correoo"]:"");
    //insercion de datos

    $sentencia = $conexion->prepare("INSERT INTO `tbl_usuario` (`id`, `nombredelusuario`, `password`, `correo`) 
    VALUES (NULL, :nombre , :contra , :correo)");
    //asigmanamos lo valores que vienen por el metodo POST a la consulta
    $sentencia->bindValue(":nombre",$nombreDelUsuario);
    $sentencia->bindValue(":contra",$contracenaDelUsuario);
    $sentencia->bindValue(":correo",$correoDelUsuario);
    //ejecutar el pedido SQL
    $sentencia->execute();
    //CON ESTA SENTENCIA NOS ENVIA AL LUGAR DONDE CARGO EL NUEVO USUARIO
    header("location:index.php");

}
?>


<?php require("../../templates/header.php");?>
<div class="card">
    <div class="card-header">
        Usuarios
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="nombreUsuario" class="form-label">Nombre del usuario</label>
                <input type="text"class="form-control" name="nombreDelUsuario" id="nombreUsuario" aria-describedby="helpId" placeholder="">
                
                <div class="mb-3">
                    <label for="contracena" class="form-label">Password</label>
                    <input type="password" class="form-control" name="contracenaa" id="contracena" placeholder="">
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Email</label>
                    <input type="email" class="form-control" name="correoo" id="correo" aria-describedby="emailHelpId" placeholder="abc@mail.com">
                </div>
                <!--<label for="contraceña" class="form-label">Contraceña</label>
                <input type="password"class="form-control" name="contraceña" id="contraceña" aria-describedby="helpId" placeholder="">
                
                <label for="correo" class="form-label">Correo</label>
                <input type="email"class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="">-->
            
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" href="#" role="button">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">cancelar</a>
        </form>
    </div>
    
</div>
<?php require("../../templates/footer.php");?>