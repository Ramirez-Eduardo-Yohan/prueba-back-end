<?php

    //si se invia datos del formulario quiere decir que esos datos estan
    //en la superVariable $POST y en ese caso ejecuta el SI
    if ($_POST) {
        require_once("../../bd.php");
        //en una variable verifico si tiene algo
        //isset:deja ver si tiene algo 
        //si tiene algo le asigna a la variables lo que esta despues de del signo ?
        $nombredelpuesto = (isset($_POST["nombredelpuesto"]) ? $_POST["nombredelpuesto"] :"ERROR");
        //insercion de los datos
        
        $sentencia = $conexion->prepare("INSERT INTO `tbl_puesto` (`id`,`nombredelpuesto`) 
        VALUES (null, :nombredelpuesto)");
        //asigmanamos lo valores que vienen por el metodo POST a la consulta
        $sentencia->bindValue(":nombredelpuesto", $nombredelpuesto);
        
        //ejecutar el pedido SQL
        $sentencia->execute();
        //CON ESTA SENTENCIA NOS ENVIA AL LUGAR DONDE CARGO EL NUEVO PUESTO
        header("Location:index.php");
    }
?>

<?php require("../../templates/header.php");?>
<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del Puesto</label>
                <input type="text"class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="">
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" href="#" role="button">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
    
</div>
<?php require("../../templates/footer.php");?>