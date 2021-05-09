<?php
// incluimos el fichero configDBMySQLi.php
// este fichero contiene las constantes necesarias para realizar la conecion a la base de datos
require_once __DIR__.'/../db/configDBMySQLi.php';
// incluimos el fichero DB.php
// este fichero contiene funciones para conectarse a una base de datos y ejecutar consultas
require_once __DIR__.'/../db/DB.php';
// incluimos el fichero validarCampos.php
// este fichero contiene las funciones necesarias para validar los campos necesarios
require_once __DIR__.'/validarCampos.php';
/**
 * Clase FuncionesApi
 * 
 * Clase que contiene las funciones para utilizar en las diferentes api
 * Estas funciones se encargan de realizar las diferentes acciones sobre la base de datos
 * 
 * @author Cristina Núñez Sebastián
 * @version 1.0
 * @since 1.0
 */
class FuncionesApi{
	/**
	 * Funcion response()
	 * 
	 * Function que devuelve un array con una respuesta en funcion de los parametros introducidos
	 * 
	 * @param string cStatus estado de la respuesta
	 * @param int nErrorCode código del error
	 * @param string cDescription descripcion del error
	 * @param mixed data datos de respuesta en caso de no haber error
	 * @return array array con los parametros introducidos
	 */
	public static function response($cStatus,$nErrorCode=null,$cDescription=null,$data=null)
	{
		// la funcion devolvera un array con la informacion pasada como parametros
		return ['status'=>$cStatus,
				'errorCode'=>$nErrorCode,
				'description'=>$cDescription,
				'data'=>$data];
	}
	/**
	 * Funcion validarJson()
	 * 
	 * Funcion que valida que se pase un json como parametro
	 * 
	 * @return mixed array del json decodificado o false en caso de no haberle pasado un json como parametro
	 */
	public static function validarJson()
	{
		// decodificamos el json parado como parametro
		$aDatosJson=json_decode(file_get_contents("php://input"),true);
		// si es distinto de null significa que el json de ha decodificado correctamente
		if($aDatosJson!=null)
		{
			// devolvemos el json decodificado
			return $aDatosJson;
		}
		// si no se ha podido decodificar la informacion pasada como parametro a la api significa que no es un json
		// por lo tanto la funcion devolvera false
		return false;
	}
	
	/**
	 * Funcion ejecutarSolicitud()
	 * 
	 * Funcion que ejecuta la solicitud recibida
	 * 
	 * @param array aDatos array con los datos del json
	 * @return self respuesta de las funciones que realizan las diferentes peticiones
	 */
	public static function ejecutarSolicitud($aDatos)
	{
		// si esta establecido el parametro method
		if(isset($aDatos['method']))
		{
			// en funcion del parametro method realizaremos diferentes acciones sobre la base de datos
			switch($aDatos['method'])
			{
				// si el valor es getNota
				case 'getNota':
					// la respuesta de la funcion sera la devuelta por la funcion obtenerDatosNota()
					return self::obtenerDatosNota($aDatos['data']['id']);
					break;
				// si el valor de method es updateNota
				case 'updateNota':
					// la respuesta de la funcion sera la devuelta por la funcion modificarNota()
					return self::modificarNota($aDatos['data']);
					break;
				// si el valor de method es deleteNota
				case 'deleteNota':
					// la respuesta de la funcion sera la devuelta por la funcion eliminarNota()
					return self::eliminarNota($aDatos['data']['id']);
					break;
				// si el valor de method es insertNota
				case 'insertNota':
					// la respuesta de la funcion sera la devuelta por la funcion crearNota()
					return self::crearNota($aDatos['data']);
					break;
				// si el valor de method es getNotas
				case "getNotas":
					// la respuesta de la funcion sera la devuelta por la funcion iniciarSesionUsuario()
					return self::obtenerNotas();
					break;
				default:
					// la funcion devolvera un status=ko con un codigo de error y una descripcion del error
					return self::response('ko',711,'El valor del metodo introducido es incorrecto');
					break;
			}
		}
	}
// 
// 
	/**
	 * Funcion validarData()
	 * 
	 * Funcion que valida los campos antes de ser introducidos en la base de datos
	 * 
	 * @param array aDatos array con los datos que queremos validar
	 * @return self array con información del resultado de la validación
	 */
	public static function validarData($aDatos)
	{
		// recorremos el array con los datos parado como parametro
		foreach($aDatos as $cClave => $cValor)
		{
			// si el valor de la clave es distinto de id
			if($cClave!='id')
			{
				// en funcion del valor de la clave
				switch ($cClave) {
					case 'titulo':
						// validamos que sea un titulo correcto
						// si no es un titulo correcto
						if(!ValidarCampos::validarAlfanumerico($cValor))
						{
							// la funcion devolvera un array con informacion del resultado de la validacion
							// en este caso indicaremos en la descripcion un mensaje del error indicando que el valor del titulo es incorrecto
							return self::response('ko',703,'El valor del titulo es incorrecto');
						}
						break;
					case 'descripcion':
						// validamos que sea una descripcion correcta
						// si no es una descripcion correcta
						if(!ValidarCampos::validarAlfanumerico($cValor))
						{
							// la funcion devolvera un array con informacion del resultado de la validacion
							// en este caso indicaremos en la descripcion un mensaje del error indicando que el valor del descripcion es incorrecto
							return self::response('ko',704,'El valor del descripcion es incorrecto');
						}
						break;
					case 'estado':
						// validamos que sea un estado correcto
						// si no es un estado correcto
						if($cValor!='sin comenzar' && $cValor!='en curso' && $cValor!='finalizada')
						{
							// la funcion devolvera un array con informacion del resultado de la validacion
							// en este caso indicaremos en la descripcion un mensaje del error indicando que el valor del estado es incorrecto
							return self::response('ko',705,'El valor de los apellidos es incorrecto');
						}
						break;
					case 'fecha_vencimiento':
						// validamos que la fecha sea correcta
						// si la fecha no es correcta
						if(!ValidarCampos::validarFecha($cValor))
						{
							// la funcion devolvera un array con informacion del resultado de la validacion
							// en este caso indicaremos en la descripcion un mensaje del error indicando que el valor de la fecha es incorrecto
							return self::response('ko',706,'El valor de la fecha de vencimiento es incorrecto');
						}
						break;
					default:
						// si el parametro no es valido
						// la funcion devolvera un array con la informacion del resultado de la validacion
						// en este caso indicaremos en la descripcion un mensaje del error indicando que los datos del json son incorrectos
						return self::response('ko',700,'Los datos el json son incorrectos');
						break;
				}
			}
		}
		// si los campos son correctos la funcion devuelve true
		return true;
	}
// 
// 
	/**
	 * Funcion concatenarDatos()
	 * 
	 * Funcion que concatena los datos para ejecutar una determinada consulta a la base de datos
	 * dichos datos se concatenan igualando el nombre del campo a su valor separados por comas
	 * 
	 * @param array aDatos array con los datos que queremos concatenar
	 * @return string cadena con los datos concatenados separados por comas
	 */
	public static function concatenarDatos($aDatos)
	{
		// creamos una variable cDatos en la que se ira añadiendo la información correspondiente
		// el valor de esta variable sera la respuesta de la funcion
		$cDatos="";
		// recorremos el array de datos pasado como parametro
		foreach ($aDatos as $cClave => $cValor) {
			// si el nombre de la clave es distinto de id
			if($cClave!='id' && $cClave!='api_key')
			{
				// si el valor del campo es igual a null
				if($cValor==null)
				{
					// concatenamos el valor de la clave igualado a null
					$cDatos.=$cClave."=null,";
				}
				// si el valor del campo es distinto de null
				else
				{
					// concatenamos el valor de la clave igualado al valor separados por comas
					$cDatos.=$cClave."='".$cValor."',";
				}
			}
		}
		// eliminamos la ultima coma de la cadena cDatos
		$cDatosRespuesta=substr($cDatos, 0,strlen($cDatos)-1);
		// devolvemos la cadena cDatosRespuesta
		// esta cadena esta formada por los campos del array igualado al valor correspondiente separados por comas para realizar la consulta correspondiente
		return $cDatosRespuesta;
	}
	/**
	 * Funcion concatenarDatosComplejo()
	 * 
	 * Funcion que concatena los datos para ejecutar una determinada consulta a la base de datos
	 * dichos datos se concatenan igualando el nombre del campo a su valor separados por comas
	 * 
	 * @param array aDatos array con los datos que queremos concatenar
	 * @return string cadena con los datos concatenados separados por comas
	 */
	public static function concatenarDatosComplejo($aDatos)
	{
		// creamos una variable cDatos en la que se ira añadiendo la información correspondiente
		// el valor de esta variable sera la respuesta de la funcion
		$cDatos="";
		// recorremos el array de datos pasado como parametro
		foreach ($aDatos as $aDato) {
			// recorremos el array/arrays almacenados en el array principal
			foreach ($aDato as $cClave => $cValor)
			{
				// si los nombres de las claves son distintos de los id
				if($cClave!='id' && $cClave!='Nota_id')
				{
					// concatenamos el valor de la clave igualado al valor separados por comas
					$cDatos.=$cClave."='".$cValor."',";
				}
			}
		}
		// eliminamos la ultima coma de la cadena cDatos
		$cDatosRespuesta=substr($cDatos, 0,strlen($cDatos)-1);
		// devolvemos la cadena cDatosRespuesta
		// esta cadena esta formada por los campos del array igualado al valor correspondiente separados por comas para realizar la consulta correspondiente
		return $cDatosRespuesta;
	}
	
	/**
	 * Funcion obtenerDatosTabla()
	 * 
	 * Funcion para obtener los datos de una determinada tabla
	 * 
	 * @param string cNombreTabla nombre de la tabla de la que queremos obtener los datos
	 * @param string cNombreCampo nombre del campo por el que queremos buscar
	 * @param string cValorCampo valor del campo por el que queremos buscar
	 * @return array array con los datos obtenidos en la consulta o un array con el error y los datos del error correspondientes
	 */
	public static function obtenerDatosTabla($cNombreTabla,$cNombreCampo=null,$cValorCampo=null)
	{
		// establecemos la conexion con la base de datos
		$oMiDB=DB::conexionDB();
		// si no se establece la conexion con la base de datos
		if($oMiDB===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',600,'No se ha podido establecer la conexión con la base de datos');
		}
		// si tanto el nombre del campo por el que queremos buscat, tanto el valor del mismo se pasan como parametro
		if($cNombreCampo!=null && $cValorCampo!=null)
		{
			// escribimos la sentencia para obtener los datos solicitados
			$cSentenciaSql="Select * from ".$cNombreTabla." where ".$cNombreCampo."=".$cValorCampo;
		}
		// si no se paran como parametro ni el nombre del campo ni el valor
		else
		{
			// escribimos la sentencia para obtener los datos solicitados unicamente con el nombre de la tabla
			$cSentenciaSql="Select * from ".$cNombreTabla;
		}
		$consulta=DB::ejecutarConsulta($oMiDB,$cSentenciaSql);
		// si la consulta no se ejecuta correctamente
		if($consulta===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',601,'La consulta no se ejecutado correctamente');
		}
		// si se ejecuta la consulta pero no se obtiene ningun registro
		if($consulta && mysqli_num_rows($consulta)==0)
		{
			// la funcion devolvera un array con un status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',602,'No se ha encontrado ninguna coincidencia');
		}
		$registro=$consulta->fetch_assoc();
		while($registro)
		{
			$aDatosRespuesta[]=$registro;
			$registro=$consulta->fetch_assoc();
		}
		// si no se ha producido ningun array el status devuelto por la funcion sera ok y devolvera los datos correspondientes
		return $aDatosRespuesta;
	}

// 
// 
	/**
	 * Funcion obtenerDatosNota()
	 * 
	 * Funcion que devuelve los datos de una nota específica
	 * pasando como parametro el id de la nota que queremos obtener los datos
	 * 
	 * @param string cIdNota id de la nota de que queremos obtener la informacion
	 * @return self array con los datos de respuesta de la api
	 */
	public static function obtenerDatosNota($cIdNota)
	{
		$aDatosNota=self::obtenerDatosTabla('nota','id',$cIdNota);
		if(isset($aDatosNota['status']))
		{
			return $aDatosNota;
		}
		// si no se ha producido ningun array el status devuelto por la funcion sera ok y devolvera los datos correspondientes
		return self::response('ok',null,null,$aDatosNota);
	}
// 
// 

	public static function obtenerNotas()
	{
		$aDatosNota=self::obtenerDatosTabla('nota');
		if(isset($aDatosNota['status']))
		{
			return $aDatosNota;
		}
		// si no se ha producido ningun array el status devuelto por la funcion sera ok y devolvera los datos correspondientes
		return self::response('ok',null,null,$aDatosNota);
	}

// 
// 
	/**
	 * Funcion modificarNota()
	 * 
	 * Funcion que modifica los datos de un Nota especifico
	 * pasando como parametro el dni de dicho Nota y los campos que queremos modificar
	 * 
	 * @param array aDatos array con los datos necesarios para realizar la consulta
	 * @return self array con los datos de respuesta que proporcionará la api
	 */
	public static function modificarNota($aDatos)
	{
		// si los datos del json no son validos
		if(self::validarData($aDatos)!=true)
		{
			// la funcion devolvera la repsuesta devuelta por la funcion validarData()
			// esta funcion devolvera un status=ko con un codigo de error y descripcion del error correspondientes
			return self::validarData($aDatos);
		}
		// establecemos la conexion con la base de datos
		$oMiDB=DB::conexionDB();
		// si no se establece la conexion con la base de datos
		if($oMiDB===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',600,'No se ha podido establecer la conexión con la base de datos');
		}
		$cSentencia="Update nota set ".self::concatenarDatos($aDatos)." WHERE id=".$aDatos['id'];
		$consulta=DB::ejecutarConsulta($oMiDB,$cSentencia);
		if($consulta===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',601,'La consulta no se ejecutado correctamente');
		}
		// si se actualizan los datos del Nota correctamente
		return self::response('ok');
	}
// 
// 

	/**
	 * Funcion eliminarNota()
	 * 
	 * Funcion que elimina un Nota especifico pasando como parametro el dni de dicho Nota
	 * 
	 * @param string cIdNota id del Nota que queremos eliminar
	 * @return self array con los datos de respuesta que proporcionará la api
	 */
	public static function eliminarNota($cId)
	{
		// establecemos la conexion con la base de datos
		$oMiDB=DB::conexionDB();
		// si no se establece la conexion con la base de datos
		if($oMiDB===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',600,'No se ha podido establecer la conexión con la base de datos');
		}
		// escribimos la sentencia para introducir un Nota en la base de datos
		$cSentenciaSql="Delete from nota where id=".$cId;
		// realizamos la consulta para eliminar un Nota
		$consulta=DB::ejecutarConsulta($oMiDB,$cSentenciaSql);
		// si la consulta no se ejecuta correctamente
		if($consulta===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',601,'La consulta no se ejecutado correctamente');
		}
		// si el Nota se elimina correctamente
		return self::response('ok');
	}
	public static function generarSentenciaInsertNota($aDatosJson)
	{
		$aDatosNota=$aDatosJson;
		$cClavesNota="";
		$cValoresNota="";
		foreach($aDatosNota as $cClave => $cValor)
		{
			if($cValor!=null)
			{
				$cClavesNota.=$cClave.",";
				$cValoresNota.="'".$cValor."',";
			}
		}
		$cClavesNotaFormateado=substr($cClavesNota,0,strlen($cClavesNota)-1);
		$cValoresNotaFormateado=substr($cValoresNota,0,strlen($cValoresNota)-1);
		$sentencia='Insert into nota ('.$cClavesNotaFormateado.') values ('.$cValoresNotaFormateado.')';
		return $sentencia;
	}
	
	/**
	 * Funcion crearNota()
	 * 
	 * Funcion que crea un Nota pasando como parametro los diferentes campos necesarios para su creación
	 * 
	 * @param array $aDatosJson array con los datos necesarios para crear un Nota
	 * @return self array con los datos de respuesta que proporcionará la api
	 */
	public static function crearNota($aDatosJson)
	{
		// validamos los campos
		// si los campos del json no son validos
		if(self::validarData($aDatosJson)!==true)
		{
			return self::validarData($aDatosJson);
		}
		// establecemos la conexion con la base de datos
		$oMiDB=DB::conexionDB();
		// si no se establece la conexion con la base de datos
		if($oMiDB===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',600,'No se ha podido establecer la conexión con la base de datos');
		}
		$cSentencia=self::generarSentenciaInsertNota($aDatosJson);
		$consulta=DB::ejecutarConsulta($oMiDB,$cSentencia);
		// si la consulta no se ejecuta correctamente
		if($consulta===false)
		{
			// la funcion devolvera un array con status=ko, un codigo de error y una descripcion del error correspondiente
			return self::response('ko',601,'La consulta no se ejecutado correctamente');
		}
		// si el Nota se elimina correctamente
		return self::response('ok');
			
	}
}
