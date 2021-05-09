<?php
// incluimos el fichero funcionesApi.php
// este fichero contiene funciones que realizan direferentes acciones contra la base de datos
require_once __DIR__.'/api/funciones.php';
// permitimos el acceso desde cualquier url
header('Access-Control-Allow-Origin: *');
// indicamos que encabezados HTTP pueden ser utilizados durante la solicitus
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// permitimos el acceso por GET, POST, PUT y DELETE
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//El contenido devuelto va a tener formato JSON
header('content-type: application/json; charset=utf-8');
//Comprobamos que el usuario está realizando una petición POST
// si no esta realizando una peticion POST
if($_SERVER['REQUEST_METHOD']!='POST')
{
    // la respuesta sera un array con el estado=ko, un codigo de error y una descripción del error
    echo json_encode(FuncionesApi::response('ko',801,'Método incorrecto'));
}
// si el metodo es correcto
else{
    // almacenamos el array con la informacion del json devuelto por la funcion validarJson() en aDatosJson
    $aDatosJson=FuncionesApi::validarJson();
    // devolvemos un array con la respuesta que se obtiene al ejecutar la solicitud
    echo json_encode(FuncionesApi::ejecutarSolicitud($aDatosJson));
}
