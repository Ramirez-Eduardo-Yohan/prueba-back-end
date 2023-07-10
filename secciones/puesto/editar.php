<?php 
    require("../../bd.php");

    //TODO ESTO ES PARA SELECCIONA Y VER EL DATO QUE VAMOS A CAMBIAR
    if($_GET["txtID"]){
        $txtID =(isset($_GET["txtID"])? $_GET["txtID"]:"");
        //SENTENCIA PARA TRAER EL PUESTO DE REQUERIDO
        $sentencia = $conexion->prepare("SELECT * FROM `tbl_puesto` WHERE id=:id ");
        //LE ASIGNO EL VALOR A LA VARIABLE :id
        $sentencia->bindValue(":id",$txtID);
        //EJECUTO LO ANTES ESCRITO
        $sentencia->execute();
        //FETCH PARA TRAER UN PUESTO SOLAMENTE
        //FETCH_LAZY: TRAE UN UNICO ARREGLO
        $registro = $sentencia->fetch(PDO::FETCH_LAZY);
        $nombreDelPuesto = $registro['nombredelpuesto'];
        print_r($registro);

    }
    //TODO ESTO PARA MODIFICAR EL DATO OBTENIDO ANTERIORMENTE
    if($_POST){
        $txtID =(isset($_POST["txtID"])? $_POST["txtID"]:"");
        //RECOLECTO EL DATO DEL METODO POST
        $nombreDelPuesto = (isset($_POST["nombredelpuesto"])? $_POST["nombredelpuesto"] :"");
        //CREAMOS LA SENTENCIA PARA MODIFICAR
        $sentencia = $conexion->prepare("UPDATE `tbl_puesto` SET `nombredelpuesto`=:nombre WHERE id=:id");
        //ASIGNAMOS VALORES AL NOMBRE DEL PUESTO Y AL ID
        $sentencia->bindValue(":nombre", $nombreDelPuesto);
        $sentencia->bindValue(":id",$txtID);
        $sentencia->execute();
        header("location:index.php");
    }
?>

<?php require("../../templates/header.php");?>
<div class="card">
    <div class="card-header">
        Editar Puestos
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text"class="form-control" name="txtID" id="txtID" aria-describedby="helpId" 
                value="<?php echo $txtID; ?>" placeholder="" readonly>

                <label for="nombredelpuesto" class="form-label">Nombre del Puesto</label>
                <input type="text"class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" 
                value="<?php echo $nombreDelPuesto; ?>" placeholder="">
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" href="#" role="button">Editar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
    
</div>
<?php require("../../templates/footer.php");?>
