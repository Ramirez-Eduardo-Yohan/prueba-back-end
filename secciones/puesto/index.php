<?php 
//CONECCION A LA BASE DE DATOS
require_once("../../bd.php"); 

//PREGUTO SI LA SUPER VARIABLE GET TIENE ALGO YA QUE 
//AL PONER EN EL BOTON ELIMINAR EN LA HREF SE REFLEJA 
//EN LA URL Y SE GUARDA EN GET
//ISSET: ES PARA VER SI TIENE ALGO LA VARIABLE 
if(isset($_GET["txtID"])){
    //EN UNA VARIABLE DE PHP GUARDO EN VALOR QUE BIEN EN GET
    $txtID = (isset($_GET["txtID"])? $_GET["txtID"] :"");
    //CONSULTA DE ELIMINACION 
    $sentencia = $conexion->prepare("DELETE FROM `tbl_puesto` WHERE `id`=:id");
    //ASIGNAMOS LO VALORES QUE VIENEN DEL METODO GET
    $sentencia->bindValue(":id",$txtID);
    //EJECUTAMOS LA SENTENCIA ANTERIO
    $sentencia->execute();
    //REDIRECCIONAMOS AL INDEX DEL PUESTO
    header("location:index.php");
}





//me conecto a la base de datos 
//realizo todos los comando para poder todo los valores
//que tienen las tablas
// 
$sentencia = $conexion->prepare("SELECT * FROM `tbl_puesto`");
$sentencia->execute();
//FETCH_ASSOC:ES CUANDO NECECITO TRAER MUCHOS REGISTRO Y LO GUARDO
//EN UNA VARIABLE
$lisya_tabla_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

print_r($lisya_tabla_puestos);

?>

<?php 
require("../../templates/header.php"); 
?>
<h1>Puestos</h1>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="./crear.php" role="button">Agregar Registro</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nombre del Puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lisya_tabla_puestos as $registro) {?>
                        
                    
                    <tr class="">
                        <td scope="row"><?php echo $registro ['id'];?></td>
                        <td><?php echo $registro ['nombredelpuesto'];?></td>
                        <td>
                            <!--el signo ? despues del .php es para mandar una variable por la url usando el metodo GET 
                            que luego podemos usar para identificar a algun elemento en las tablas-->
                        <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $registro["id"];?>" role="button">Editar</a>
                        <!--el signo ? despues del .php es para mandar una variable por la url usando el metodo GET 
                            que luego podemos usar para identificar a algun elemento en las tablas-->
                        <a name="" id="" class="btn btn-danger" 
                        href="index.php?txtID=<?php echo $registro ['id'];?>" role="button">Eliminar</a>
                    </td>
                    </tr>
                    
                    <?php } ?>
                </tbody>
                    
            </table>
        </div>
    </div>
    
</div>



<?php require("../../templates/footer.php");?>