<?php
    //CONEXION A LA BASE DE DATO
    require_once("../../bd.php");
    //TODO ESTO ES PARA SELECCIONA Y VER EL DATO QUE VAMOS A CAMBIAR
    if($_GET["numeroID"]){
        //CON ISSET VEO QUE TIENE ESA VARIABLE
        $numeroID =(isset($_GET["numeroID"])?$_GET["numeroID"]:"");
        //SENTENCIA PARA TRAER EL PUESTO DE REQUERIDO
        $sentencia = $conexion->prepare("SELECT * FROM `tbl_empleados` WHERE id=:id");
        //LE ASIGNO EL VALOR A LA VARIABLE :id
        $sentencia->bindValue(":id",$numeroID);
        //EJECUTO LO ANTES ESCRITO
        $sentencia->execute();
        //FETCH PARA TRAER UN PUESTO SOLAMENTE
        //FETCH_LAZY: TRAE UN UNICO ARREGLO
        $registro = $sentencia->fetch(PDO::FETCH_LAZY);
        //PARA VER LOS DATOS QUE LLAMAMOS EN UN ARREGLO
        //LO GUARDAMOS EN CADA VARIABLE 
        $primerNombre = $registro['primernombre'];
        $segundonombre = $registro['segundonombre'];
        $primerapellido = $registro['primerapellido'];
        $segundoapellido = $registro['segundoapellido'];
        $foto = $registro['foto'];
        $cv = $registro['cv'];
        $idpuesto = $registro['idpuesto'];
        $fechadeingreso = $registro['fechadeingreso'];

        /*echo "<pre>";
        print_r($registro);
        echo "</pre>";*/
    }

    //TODO ESTO PARA MODIVICAR EL DATO OBTENIDO ANTERIORMENTE
    if($_POST){
        echo "<pre>";
        print_r($_POST);
        print_r($_FILES);
        echo "</pre>";
        //MIRA SI POR EL METODO POST SI EL ID TIENE ALGO
        $numeroID =(isset($_POST["numeroID"])?$_POST["numeroID"]:"");
        $primerNombre =(isset($_POST["primerNombre"])?$_POST["primerNombre"]:"");
        $segundoNombre =(isset($_POST["segundoNombre"])?$_POST["segundoNombre"]:"");
        $primerApellido =(isset($_POST["primerApellido"])?$_POST["primerApellido"]:"");
        $segundoApellido =(isset($_POST["segundoApellido"])?$_POST["segundoApellido"]:"");
        // TAANTO LA FOTO COMO EL CV VIENEN EN EL LA VARIABLE FILE
        /**
        * NO OLVIDAR PONER VIEN LA DIRECCION DE $_FILES["foto"]["name"]
        * LA PRIMERA PARTE ES DEL INPUT LA PARTE NAME DEL FORMULARIO
        * EL SEGUNDO DE NOMBRE QUE TIENE FILES EN LA PARTE NAME 
        */
        $foto =(isset($_FILES["Foto"]["name"])?$_FILES["Foto"]["name"]:"");
        $cv =(isset($_FILES["cv"]["name"])?$_FILES["cv"]["name"]:"");
        //PASOS A SEGIR PARA ELIMINAR FOTO Y CV
        if($foto !="" || $cv !=""){
            //LLAMO A LOS VALORES QUE NECESITOS
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
    
        }

        $idpuestos =(isset($_POST["idpuestos"])?$_POST["idpuestos"]:"");
        $fechaDeIngreso =(isset($_POST["fechaDeIngreso"])?$_POST["fechaDeIngreso"]:"");
        //CREAMOS LA SENTENCIA PARA MODIFICAR

        $sentencia = $conexion->prepare("UPDATE `tbl_empleados` 
        SET 
        primernombre=:primerNombre,
        segundonombre=:segundoNombre,
        primerapellido=:primerApellido,
        segundoapellido=:segundoApellido,
        foto=:foto,
        cv=:CV,
        idpuesto=:idPuesto,
        fechadeingreso=:fechaDeIngreso
        WHERE id=:id");
        //ASIGNAMOS LOS VALORES QUE VIENEN POR EL EL METODO POST
        $sentencia->bindValue(":primerNombre",$primerNombre);
        $sentencia->bindValue("segundoNombre",$segundoNombre);
        $sentencia->bindValue("primerApellido",$primerApellido);
        $sentencia->bindValue("segundoApellido",$segundoApellido);
        //PARA QUE FOTO SEA UNICA
        //NOS DEVUELVE FECHA HORA MINUTOS Y SEGUNDO ACTUAL 
        $fecha_ = new DateTime();
        //VARIABLE PARA EL NOMBRE DE LA FOTO QUE QUIERO GUARDAR
        //getTimestamp GENERA UNA ESPANTA DE TIEMPO
        //DESPUES DEL GION BAJO PONEMOS EL NOMBRE CON QUE BIEN LA FOTO
        //CONCATENAMOS LA FECHA DE LA FOTO AL NOMBRE QUE TIENE LA FOTO
        $nombreArchivo_foto =($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name']: "";
            
         //PARA PODER MOVER LA FOTO A UN ARCHIVO DE MI PROGRAMA
        $tmp_foto = $_FILES["foto"]['tmp_name'];
        print_r($tmp_foto);
        if($tmp_foto != ''){
            //$lugar="../empleados/IMG/";
            //SENTENCIA PARA GUANDAR LA FOTO EN UN LUGAR DETERMINADO
            move_uploaded_file($tmp_foto, "./IMG/". $nombreArchivo_foto);
        }
        $sentencia->bindValue(":foto",$nombreArchivo_foto);

            /* PARA EL CV ES LO MISMO QUE EN LA FOTO SOLO QUE SE REPLAZA LO QUE DIGA
            * FOTO POR CV
            *TAMBIEN SE TIENE QUE CREAR UNA CARPETA PARA GUARDAR LOS CV 
            */

            $nombreArchivo_cv =($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["CV"]['name']: "";
            
            //PARA PODER MOVER LA FOTO A UN ARCHIVO DE MI PROGRAMA
            $tmp_cv = $_FILES["CV"]['tmp_name'];
            if($tmp_cv != ''){
                //SENTENCIA PARA GUANDAR LA FOTO EN UN LUGAR DETERMINADO
                move_uploaded_file($tmp_cv, "./cv/" . $nombreArchivo_cv);
            }
        $sentencia->bindValue(":CV",$nombreArchivo_cv);
        $sentencia->bindValue("idPuesto",$idpuestos);
        $sentencia->bindValue("fechaDeIngreso",$fechaDeIngreso);
        $sentencia->bindValue("id",$numeroID);

        $sentencia->execute();
    
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

require("../../templates/header.php");?>

<div class="card">
    <div class="card-header">
        Edicion de Empleados
    </div>
    <div class="card-body">
        <!--FORMULARIO PARA MODIFICAR A LOS EMPLEADOS-->
        <!--PARA QUE FUNCIONE EL ENVIO DE DATOS DE TIPO FILE
        TIENE QUE PONER enctype="multipart/form-data"  NO TE OLVIDES-->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="numeroID" class="form-label">ID:</label>
                <input type="text"class="form-control" name="numeroID" id="numeroID" aria-describedby="helpId" 
                value="<?php echo $numeroID; ?>" placeholder="" readonly>

                <label for="primerNombre" class="form-label">Primer Nombre</label>
                <input type="text"class="form-control" name="primerNombre" id="primerNombre" aria-describedby="helpId" 
                value="<?php echo $primerNombre; ?>" >

                <label for="segundoNombre" class="form-label">Segundo Nombre</label>
                <input type="text"class="form-control" name="segundoNombre" id="segundoNombre" aria-describedby="helpId" 
                value="<?php echo $segundonombre; ?>" >

                <label for="primerApellido" class="form-label">Primer Apellido</label>
                <input type="text"class="form-control" name="primerApellido" id="primerApellido" aria-describedby="helpId" 
                value="<?php echo $primerapellido; ?>" >

                <label for="segundoApellido" class="form-label">Segundo Apellido</label>
                <input type="text"class="form-control" name="segundoApellido" id="segundoApellido" aria-describedby="helpId" 
                value="<?php echo $segundoapellido; ?>" >

                <label for="foto" class="form-label">foto

                </label>
                <img width="80" src="./IMG/<?php echo $foto;?>"/>

                <input type="file"class="form-control" name="foto" id="foto" aria-describedby="helpId"
                value="<?php echo $foto; ?>" >

                <label for="cv" class="form-label">cv</label>
                <a href="./cv/<?php echo $dato['cv'];?>">cv</a>
                <input type="file"class="form-control" name="cv" id="cv" aria-describedby="helpId" 
                value="<?php echo $cv; ?>">

                <div class="mb-3">
                    <label for="idpuestos" class="form-label">Puesto</label>
                    <select class="form-select form-select-lg" name="idpuestos" id="idpuestos">
                        <option selected>
                            
                        </option>
                        <?php foreach ($lisya_tabla_puestos as $registro) {
                        //SIE EL ID DEL REGISTRO ES IGUAL AL IDPUESTO ENTONCES
                        //QUE MUESTRE COMO PRIMERA OBCION EL PUESTO QUE TIENE
                            if($registro['id']==$idpuesto){?>
                            <!--EN VALUE SE ENVIA EL VALOR DE ID DEL PUESTO AL SELECCIONAR UN PUESTO-->
                                <option selected value="<?php echo $registro['id']?>">
                                    <?php echo $registro['nombredelpuesto']?>
                                </option>
                            <?php }else {?>
                                <option  value="<?php echo $registro['id']?>">
                                    <?php echo $registro['nombredelpuesto']?>
                                </option>
                            <?php }
                        }?>
                    </select>
                </div>
                

                <label for="fechaDeIngreso" class="form-label">Fecha de Ingreso</label>
                <input type="date"class="form-control" name="fechaDeIngreso" id="fechaDeIngreso" aria-describedby="helpId" 
                value="<?php echo $fechadeingreso; ?>">
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" href="#" role="button">Editar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>

        </form>
    </div>
    
</div>
<?php require("../../templates/footer.php");?>