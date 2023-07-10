

<?php  
    //CONECTAMOS A LA BASE DE DATOS
    require_once("../../bd.php");
    //ELIMINAR LOS DATOS INGRESADOS
    //PREGUTO SI LA SUPER VARIABLE GET TIENE ALGO YA QUE 
    //AL PONER EN EL BOTON ELIMINAR EN LA HREF SE REFLEJA 
    //EN LA URL Y SE GUARDA EN GET
    //ISSET: ES PARA VER SI TIENE ALGO LA VARIABLE 
    if(isset($_GET["numeroID"])){
        //EN UNA VARIABLE DE PHP GUARDO EN VALOR QUE BIEN EN GET
        $numeroID = (isset($_GET["numeroID"])?$_GET["numeroID"]:"");
        //CONSULTA DE ELIMINACION
        //ELIMINAMOS PRIMERO LOS FOTO Y EL CV DE MANERA  Y PARA ELLO LOS LLAMO PRIMERO
        $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE `id`=:id");
        $sentencia->bindValue("id",$numeroID);
        $sentencia->execute();
        //GUANDAMOS EN UNA VARIABLE EL REGISTRO QUE TRAGIMOS GRACIAS A FETCH_LAZY
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        //PEGUNTAMOS SI EL REGISTRO TIENE ALGO Y ES DISTINTO DE VACIO
        if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] !=""){
        
            //SI LA FOTO EXISTE EN ESTE LUGAR  LO BORRO
            //FILE_EXISTS: ES PARA VER SI UNA DIRECCION EXISTE
            if(file_exists("./IMG/" .$registro_recuperado["foto"])){
                //../empleados/IMG
                //linea para eliminar
                unlink("./IMG/" .$registro_recuperado["foto"]);
            }
        }
        //LO MISMO PARA EL CV
        if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] !=""){
            //SI LA FOTO EXISTE EN ESTE LUGAR  LO BORRO
            //FILE_EXISTS: ES PARA VER SI UNA DIRECCION EXISTE
            if(file_exists("./cv/" .$registro_recuperado["cv"])){
                //linea para eliminar
                unlink("./cv/".$registro_recuperado["cv"]);
            }
        }

        $sentencia = $conexion->prepare("DELETE FROM `tbl_empleados` WHERE `id`=:id");
        //ASIGNAMOS LOS VALORES QUE VIENEN DEL METODO GET
        $sentencia->bindValue("id",$numeroID);
        //EJECUTAMOS LA SENTENCIA ANTERIOR
        $sentencia->execute();
        /*
        //REDIRECCIONAMOS AL INDEX DEL EMPLEADO
        header("location:index.php");
        */
    }


    //-----------------------------
    //CREO LA SENTENCIA PARA LLAMAR A LOS EMPLEADOS
    //CONESTA SENTENCIA TAMBIEN ME TRAIGO LA TABLA DE PUESTOSLO NOMBRE QUE SOLO
    //QUE COINCIDEN CON IDPUESTO DE LA TABLA DE EMPLEADOS Y EL ID DE LA TABLA
    //DE LOS PUESTOS
    //Y TODO SE GUARDA EN LA VARIABLE DESPUES DE AS PUESTOS
    $sentencia = $conexion->prepare("SELECT *,
    (SELECT nombredelpuesto
    FROM `tbl_puesto`
    WHERE tbl_puesto.id=tbl_empleados.idpuesto
    LIMIT 1) AS puestos
    FROM `tbl_empleados`");
    //EXECUTO LA SENTENCIA ANTERIOR
    $sentencia->execute();
    //GUARDO EN UNA VARIABLE LO ANTERIOR
    //FETCHALL LLAMO A TODOS LOS DATOS 
    //FETCH_ASSOC TODOS LOS CAMPOS 
    $listaEmpleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php  
require("../../templates/header.php");
?>

<h1>Empleados</h1>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="./crear.php" role="button">Agregar Empleados</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th><!--el nombre completo-->
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha de Ingreso</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <!--CON EL FOREACH RECORRO EL ARREGLO USANDO LA VARIABLE
                    REGISTRO Y SU INDICE 
                    SIEMPRE HAY DE USAR LA INICIALIZACION DE PHP Y SU CIERRE PARA CADA 
                    COSA QUE QUIERA HACER-->
                    <?php foreach($listaEmpleados as $dato){?>
                    <tr class="">
                        <td scope="row"><?php echo $dato['id'];?></td>
                        <td>
                            <?php echo $dato['primernombre'];?>
                            <?php echo $dato['segundonombre'];?>
                            <?php echo $dato['primerapellido'];?>
                            <?php echo $dato['segundoapellido'];?>
                        </td>
                        <td>
                            <!--PARA POCER VER LA IMAGENES EN SITIO WEB-->
                            <img width="50" src="./IMG/<?php echo $dato['foto'];?>"/>
                        </td>
                        <td>
                            <!--CON ESTO GENERO UN LINK PARA VER DEL CV-->
                            <a href="./cv/<?php echo $dato['cv'];?>">CV</a>
                            <?php ;?>
                        </td>
                        <td><?php echo $dato['puestos'];?></td>
                        <td><?php echo $dato['fechadeingreso'];?></td>
                        <td><a name="" id="" class="btn btn-primary" href="#" role="button">Carta</a>
                            <!--el signo ? despues del .php es para mandar una variable por la url usando el metodo GET 
                            que luego podemos usar para identificar a algun elemento en las tablas-->
                            <a name="" id="" class="btn btn-info" href="editar.php?numeroID=<?php echo $dato['id'];?>" role="button">Edital</a>   
                            <!--el signo ? despues del .php es para mandar una variable por la url usando el metodo GET 
                            que luego podemos usar para identificar a algun elemento en las tablas-->
                            <a name="" id="" class="btn btn-danger"
                            href="index.php?numeroID=<?php echo $dato['id'];?>" role="button">Eliminar</a> 
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

<?php
require("../../templates/footer.php");
?>

