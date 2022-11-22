
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "rutina_gym";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlRutinas = mysqli_query($conexionBD,"SELECT * FROM rutina_gym WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlRutinas) > 0){
        $rutinas = mysqli_fetch_all($sqlRutinas,MYSQLI_ASSOC);
        echo json_encode($rutinas);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlRutinas = mysqli_query($conexionBD,"DELETE FROM rutina_gym WHERE id=".$_GET["borrar"]);
    if($sqlRutinas){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de nombre y correo
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $lunes=$data->lunes;
    $martes=$data->martes;
    $miercoles=$data->miercoles;
    $jueves=$data->jueves;
    $viernes=$data->viernes;
    $sabado=$data->sabado;
    $domingo=$data->domingo;
        if(($lunes!="")&&($martes!="")&&($miercoles!="")&&($jueves!="")&&($viernes!="")&&($sabado!="")&&($domingo!="")){
            
    $sqlRutinas = mysqli_query($conexionBD,"INSERT INTO rutina_gym(lunes,martes,miercoles,jueves,viernes,sabado,domingo) VALUES('$lunes','$martes','$miercoles','$jueves','$viernes','$sabado','$domingo') ");
    echo json_encode(["success"=>1]);
        }
    exit();
 }
// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $lunes=$data->lunes;
    $martes=$data->martes;
    $miercoles=$data->miercoles;
    $jueves=$data->jueves;
    $viernes=$data->viernes;
    $sabado=$data->sabado;
    $domingo=$data->domingo;
    
    $sqlRutinas = mysqli_query($conexionBD,"UPDATE rutina_gym SET lunes='$lunes',martes='$martes', miercoles='$miercoles', jueves='$jueves', viernes='$viernes', sabado='$sabado', domingo='$domingo' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla empleados
$sqlRutinas = mysqli_query($conexionBD,"SELECT * FROM rutina_gym ");
if(mysqli_num_rows($sqlRutinas) > 0){
    $rutinas = mysqli_fetch_all($sqlRutinas,MYSQLI_ASSOC);
    echo json_encode($rutinas);
}
else{ echo json_encode([["success"=>0]]); }


?>