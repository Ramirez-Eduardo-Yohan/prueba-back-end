<?php 
    require_once("../../bd.php");
//PARA VER SI TRAE AL EL FORMULARIO POR EL 
//METODO POST
if($_POST){
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
    echo "</pre>";

    //RECOLECTAMOS LOS DATOS
    //ISSET ES PARA VER SI TIENE ALGO LA VARIABLE POST
    $primernombre =(isset($_POST["primerNombre"])?$_POST["primerNombre"]:"");
    $segundoNombre =(isset($_POST["segundoNombre"])?$_POST["segundoNombre"]:"");
    $primerApellido =(isset($_POST["primerApellido"])?$_POST["primerApellido"]:"");
    $segundoApellido =(isset($_POST["segundoApellido"])?$_POST["segundoApellido"]:"");
    // TAANTO LA FOTO COMO EL CV VIENEN EN EL LA VARIABLE FILE
    /**
     * NO OLVIDAR PONER VIEN LA DIRECCION DE $_FILES["foto"]["name"]
     * LA PRIMERA PARTE ES DEL INPUT LA PARTE NAME DEL FORMULARIO
     * EL SEGUNDO DE NOMBRE QUE TIENE FILES EN LA PARTE NAME 
     */
    $foto =(isset($_FILES["foto"]["name"])?$_FILES["foto"]["name"]:"");
    $cv =(isset($_FILES["cv"]["name"])?$_FILES["cv"]["name"]:"");
    
    $idpuesto =(isset($_POST["idPuesto"])?$_POST["idPuesto"]:"");
    $fechadeingreso =(isset($_POST["fechaIngreso"])?$_POST["fechaIngreso"]:"");

    //insercion de los datos    
    $sentencia = $conexion->prepare("INSERT INTO `tbl_empleados` (`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `cv`, `idpuesto`, `fechadeingreso`) 
    VALUES (NULL, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :foto, :cv, :idpuesto, :fechadeingreso)");
    //ASIGNAMOS LOS VALORES
    $sentencia->bindValue(":primernombre",$primernombre);
    $sentencia->bindValue(":segundonombre",$segundoNombre);
    $sentencia->bindValue(":primerapellido",$primerApellido);
    $sentencia->bindValue(":segundoapellido",$segundoApellido);
    //nombreArchivo_foto DESPUES DE TODO EL TRATAMIENTO EN LA PARTE DE ARRIVA
    //ESTA ES LA VARIABE A USAR FINAL
    
    
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
        //SENTENCIA PARA GUANDAR LA FOTO EN UN LUGAR DETERMINADO
        move_uploaded_file($tmp_foto, "./IMG/" . $nombreArchivo_foto);
    }
    $sentencia->bindValue(":foto",$nombreArchivo_foto);

    /* PARA EL CV ES LO MISMO QUE EN LA FOTO SOLO QUE SE REPLAZA LO QUE DIGA
    * FOTO POR CV
    *TAMBIEN SE TIENE QUE CREAR UNA CARPETA PARA GUARDAR LOS CV 
    */

    $nombreArchivo_cv =($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name']: "";
    
    //PARA PODER MOVER LA FOTO A UN ARCHIVO DE MI PROGRAMA
    $tmp_cv = $_FILES["cv"]['tmp_name'];
    if($tmp_cv != ''){
        //SENTENCIA PARA GUANDAR LA FOTO EN UN LUGAR DETERMINADO
        move_uploaded_file($tmp_cv, "./cv/" . $nombreArchivo_cv);
    }
    $sentencia->bindValue(":cv",$nombreArchivo_cv);
    $sentencia->bindValue(":idpuesto",$idpuesto);
    $sentencia->bindValue(":fechadeingreso",$fechadeingreso);

    //ejecuto la sentencia 
    $sentencia->execute();
    //REDIORECCIONA AL INDEX
    //header("location:index.php");
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

require("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        Datos del Empleado
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="primerNombre" class="form-label">Primer Nombre</label>
                <input type="text"class="form-control" name="primerNombre" id="primerNombre" aria-describedby="helpId" placeholder="">

                <label for="segundoNombre" class="form-label">Segundo Nombre</label>
                <input type="text"class="form-control" name="segundoNombre" id="segundoNombre" aria-describedby="helpId" placeholder="">

                <label for="primerApellido" class="form-label">Primer Apellido</label>
                <input type="text"class="form-control" name="primerApellido" id="primerApellido" aria-describedby="helpId" placeholder="">

                <label for="segundoApellido" class="form-label">Segundo Apellido</label>
                <input type="text"class="form-control" name="segundoApellido" id="segundoApellido" aria-describedby="helpId" placeholder="">

                <label for="foto" class="form-label">Foto</label>
                <input type="file"class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="">

                <label for="cv" class="form-label">CV</label>
                <input type="file"class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="">

                <div class="mb-3">
                    <label for="idPuesto" class="form-label">Puesto</label>
                    <select class="form-select form-select-lg" name="idPuesto" id="idPuesto">
                        <option selected>Seleccione uno</option>
                        <?php foreach ($lisya_tabla_puestos as $registro) {?>
                            <!--EN VALUE SE ENVIA EL VALOR DE ID DEL PUESTO AL SELECCIONAR UN PUESTO-->
                        <option value="<?php echo $registro['id']?>"><?php echo $registro['nombredelpuesto']?></option>
                        <?php }?>

                    </select>
                </div>
                
                <label for="fechaIngreso" class="form-label">Fecha de Ingreso</label>
                <input type="date"class="form-control" name="fechaIngreso" id="fechaIngreso" aria-describedby="helpId" placeholder="">

            </div>

            <button type="submit" name="" id="" class="btn btn-primary" href="#" role="button">Agregar registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
    
</div>
<?php require("../../templates/footer.php"); ?>