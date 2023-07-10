<?php 
    require_once("../../bd.php");

    //DAMOS FUNCIONALIDAD AL BOTON ELIMINAR
    //VEO SI POR EL METODO GET BIENE ALGUN VALOR
    if (isset($_GET["textoID"])) {
        //SI HAY ALGUN VALOR LE ASIGNO EL VALOR A UNA VARIABLE
        $textoID = (isset($_GET["textoID"])?$_GET["textoID"]:"");
        //GENERO LA CONSULTADE EKIMINACION
        $eliminarSentencia = $conexion->prepare("DELETE FROM `tbl_usuario` WHERE `id`=:ID");
        //ASIGNO LOS VALORES QUE VIENEN POR EL METODO GET
        $eliminarSentencia->bindValue(":ID",$textoID);
        //EJECUTO LA SENTENCIAS ANTERIORES
        $eliminarSentencia->execute();
        //REDIRECCIONA AL INDEX DEL USUARIO
        header("location:index.php");


    }




    //CREO LA SENTENCIA PARA LLAMAR A LOS USUARIOS
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_usuario`");
    //EXECUTO LA SENTENCIA ANTERIOR
    $sentencia->execute();
    //GUARDO EN UNA VARIABLE LO ANTERIOR
    //FETCHALL LLAMO A TODOS LOS DATOS 
    //FETCH_ASSOC TODOS LOS CAMPOS 
    $lista_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    //VEO QUE HAY EN LA VARIABLE ENTERIOR
    //CON PRE TE APARECE BIEN SEPARADO LOS DATOS 
    //SE MEJOR
    echo "<pre>";
    //print_r($lista_usuarios);
    echo "</pre>";


?>

<?php require("../../templates/header.php");?>
<h1>Usuario</h1>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="./crear.php" role="button">Agregar Usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nombre del usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!--CON EL FOREACH RECORRO EL ARREGLO USANDO LA VARIABLE
                    REGISTRO Y SU INDICE 
                    SIEMPRE HAY DE USAR LA INICIALIZACION DE PHP Y SU CIERRE PARA CADA 
                    COSA QUE QUIERA HACER-->
                    <?php foreach ($lista_usuarios as $registro ) {?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id'];?></td>
                        <td><?php echo $registro['nombredelusuario'];?></td>
                        <td><?php echo $registro['password'];?></td>
                        <td><?php echo $registro['correo'];?></td>
                        <td>
                            <!--el signo ? despues del .php es para mandar una variable por la url usando el metodo GET 
                            que luego podemos usar para identificar a algun elemento en las tablas-->
                            <a name="" id="" class="btn btn-info" href="editar.php?identificador=<?php echo $registro['id'] ?>" role="button">Editar</a>
                            <!--el signo ? despues del .php es para mandar una variable por la url usando el metodo GET 
                            que luego podemos usar para identificar a algun elemento en las tablas-->
                            <a name="" id="" class="btn btn-danger" href="index.php?textoID=<?php echo $registro['id'] ?>" role="button">Eliminar</a>

                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>
    
</div>
<?php require("../../templates/footer.php");?>