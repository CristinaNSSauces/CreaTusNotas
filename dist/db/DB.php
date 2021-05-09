<?php
/**
 * Clase DB
 * 
 * Clase que contiene las funciones realizar una conexion a la base de datos o realizar consultas
 * 
 * @author Cristina Núñez Sebastián
 * @version 1.0
 * @since 1.0
 */
class DB
{
	/**
	 * Funcion conexionDB()
	 * 
	 * Funcion para realizar una conexion con la base de datos
	 * 
	 * @return mixed devuelve la conexion a la base de datos o un mensaje de error
	 */
	public static function conexionDB()
	{
		// habilitamos las excepciones de mysqli
		$controlador = new mysqli_driver(); // creo un objeto de la clase mysqli_driver
		$controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
		try
		{
			// Instanciamos un objeto mysqli
			$oMiDB = new mysqli(DNS, USER, PASSWORD, DB);
			// devolvemos la conexion con la base de datos
			return $oMiDB;
		}catch(mysqli_sql_exception $exception)
		{
			// en caso de error en la conexion devolvemos un mensaje con el error
			return false;
		}
	}
	/**
	 * Funcion ejecutarConsulta()
	 * 
	 * Funcion que ejecuta una consulta con la base de datos
	 * 
	 * @param mixed conexionDB conexión a la base de datos
	 * @param string cSentenciaSQL sentencia SQL que queremos realizar
	 * @return mixed devuelve la consulta si se ejecuta correctamente o un mensaje de error
	 */
	public static function ejecutarConsulta($conexionDB,$cSentenciaSQL)
	{
		// habilitamos las excepciones de mysqli
		$controlador = new mysqli_driver(); // creo un objeto de la clase mysqli_driver
		$controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
		try
		{
			// ejecutamos la consulta
			$consulta = $conexionDB->query($cSentenciaSQL);
			// devolvemos la consulta
			return $consulta;
		}catch(mysqli_sql_exception $exception)
		{
			// cerramos la conexion con la base de datos
			mysqli_close($conexionDB);
			// en caso de error al ejecutar la consulta devolvemos un mensaje con el error
			return false;
		}
	}
	public static function ejecutarConsultaComplejo($conexionDB,$aSentenciasSQL)
	{
		// habilitamos las excepciones de mysqli
		$controlador = new mysqli_driver(); // creo un objeto de la clase mysqli_driver
		$controlador->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
		try
		{
			$conexionDB->autocommit(FALSE);
			foreach($aSentenciasSQL as $cSentencia)
			{
				$consulta=$conexionDB->query($cSentencia);
			}
			$conexionDB->commit();
			// devolvemos la consulta
			return true;
		}catch(mysqli_sql_exception $exception)
		{
			$conexionDB->rollback();
			// cerramos la conexion con la base de datos
			mysqli_close($conexionDB);
			// en caso de error al ejecutar la consulta devolvemos un mensaje con el error
			return false;
		}
	}
}
