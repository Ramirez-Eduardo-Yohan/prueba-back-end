<?php 
    //habro la coneccion a la base de datos
    require_once("../../bd.php");

    //TODO ESTO ES PARA SELECCIONA Y VER EL DATO QUE VAMOS A CAMBIAR
    if($_GET["identificador"]){
        //ISSET es para ver si tiene algo el elemento
        //si la variable que viene por el metodo GET tiene algo se lo adigna 
        //a la variable IDENTIFICADOR
        $identificador =(isset($_GET["identificador"])? $_GET["identificador"]:"");
        //SENTENCIA PARA TRAER EL PUESTO DE REQUERIDO
        $sentencia = $conexion->prepare("SELECT * FROM `tbl_usuario` WHERE id=:id");
        //LE ASIGNO EL VALOR A LA VARIABLE :id
        $sentencia->bindValue(":id",$identificador);
        //EJECUTO LO ANTES ESCRITO
        $sentencia->execute();
        //FETCH PARA TRAER UN PUESTO SOLAMENTE
        //FETCH_LAZY: TRAE UN UNICO ARREGLO
        $registroUsuario = $sentencia->fetch(PDO::FETCH_LAZY);
        //guardo en una variable el dato del NOMBRE de este
        //registro
        $nombreDelUsuario = $registroUsuario['nombredelusuario'];
        //guardo en una variable el dato de la CONTRACEÑA de este
        //registro
        $contrasenaUsario =$registroUsuario['password'];
        //guardo en una variable el dato del CORREO de este
        //registro
        $correoUsuario =$registroUsuario['correo'];
        echo "<pre>";
        //<pre> te formatea los datos y podes verlo de mejor manera
        print_r($registroUsuario);
        echo "</pre>";
    }
    //TODO ESTO PARA MODIFICAR EL DATO OBTENIDO ANTERIORMENTE
    if($_POST){
        $textoID =(isset($_POST["textoID"])?$_POST["textoID"]:"");
        //RECOLECTO EL DATO DEL METODO POST
        $nombre = (isset($_POST["nombreDelUsuario"])?$_POST["nombreDelUsuario"]:"");
        $contrasena = (isset($_POST["contrasenaUsuario"])?$_POST["contrasenaUsuario"]:"");
        $correo = (isset($_POST["correoUsuario"])?$_POST["correoUsuario"]:"");
        //CREAMOS LA SENTENCIA PARA MODIFICAR
        //$sentencia = $conexion->prepare("UPDATE `tbl_usuario` SET `nombredelpuesto`=:nombre , `password`:=contrasena , `correo`:=correo  WHERE id=:id");
        $sentencia = $conexion->prepare("UPDATE `tbl_usuario` SET `nombredelusuario` =:nombre, `password` =:contrasena , `correo`=:correo WHERE `tbl_usuario`.`id` =:id");
        //ASIGNAMOS VALORES AL NOMBRE DEL USUARIO CONTRAÑA , CORREO Y AL ID
        $sentencia->bindValue(":nombre",$nombre);
        $sentencia->bindValue(":contrasena",$contrasena);
        $sentencia->bindValue(":correo",$correo);
        $sentencia->bindValue(":id",$textoID);
        $sentencia->execute();
        //PARA REDIRECCIONAR AL INDEX DEL USUARIO
        header("location:index.php");
    
    }   

?>

<?php require("../../templates/header.php");?>

<!--creo una lista con boostrap para mostar el elmento a EDITAR-->

<div class="card">
    <div class="card-header">
        Edicion de Usuario
    </div>
    <div class="card-body">
        <!--creo un formulario para estucturar la informacion para la edicion-->
        <!--uso le metodo POST para luego hacer el invio de datos-->
        <form action="" method="post">
            <div class="mb-3">
                <!--ID-->
                <label for="textoID" class="form-label">ID:</label>
                <input type="text" class="form-control" name="textoID" id="textoID" aria-describedby="HelpId"
                value="<?php echo $identificador; ?>"  placeholder="" readonly>
                
                <!--NOMBRE DEL USUARIO-->
                <label for="" class="form-label">Nombre del Usuario</label>
                <input type="text"class="form-control" name="nombreDelUsuario" id="nombreDelUsuario" aria-describedby="helpId" 
                value="<?php echo $nombreDelUsuario; ?>" placeholder="">
                <!--CONTRASEÑA-->
                <label for="" class="form-label">Contraseña</label>
                <input type="password"class="form-control" name="contrasenaUsuario" id="contrasenaUsuario" aria-describedby="helpId" 
                value="<?php echo $contrasenaUsario; ?>" placeholder="">
                <!--CORREO-->
                <label for="" class="form-label">Correo del Usuario</label>
                <input type="text"class="form-control" name="correoUsuario" id="correoUsuario" aria-describedby="helpId" 
                value="<?php echo $correoUsuario; ?>" placeholder="">
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" href="#" role="button">Editar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>
<?php require("../../templates/footer.php");?>