<?php
/**
 * Clase ValidarCampos
 * 
 * Clase que contiene las funciones para validar los diferentes campos que se van a
 * modificar, intertar o eliminar de la base de datos
 * 
 * @author Cristina Núñez Sebastián
 * @version 1.0
 * @since 1.0
 */
class ValidarCampos{
	/**
	 * Funcion validarDni()
	 * 
	 * Funcion que pasado un dni como parametro valida si es un dni correcto
	 * 
	 * @param string cDni dni que queremos validar
	 * @return boolean bDniCorrecto devuelve true o false en funcion de si es correcto o incorrecto
	 */
	public static function validarDni($cDni)
	{
		// creamos e inicializamos a true la variable bDniCorrecto
		// el valor de esta variable será la respuesta que devuelva la función
		$bDniCorrecto = true;
		// almacenamos en la variable cLetra la letra del dni
		$cLetra = substr($cDni, -1);
		// almacenamos en la variable cNumeros los numeros del dni
		$cNumeros = substr($cDni, 0, -1);
		// si cLetra no es numerico, es decir, es una cadena que contiene una letra
		// y si cNumeros es numerico, es decir, es un numero
		if(!is_numeric($cLetra) && is_numeric($cNumeros))
		{
			// comprobamos que la letra y los numeros son correctos
			// si la letra de la posicion del array resultante del resto de dividir en numero almacenado en cNumeros entre 23 no es la letra almacenada en cLetra el dni no es correcto
			// si hay mas de una letra almacenada en cLetra el dni no es correcto
			// si no hay exactamente 8 numeros almacenados en cNumeros y el dni no esta vacio el dni no es correcto
			if((substr("TRWAGMYFPDXBNJZSQVHLCKE",$cNumeros%23,1)!=$cLetra ||  strlen($cLetra)!=1 || strlen($cNumeros)!=8) && !empty($cDni))
			{
				// cambiamos el valor de bDniCorrecto a false
				$bDniCorrecto=false;
			}
		}
		// si la letra es numerica o los numeros no son numericos
		else
		{
			// cambiamos el valor de bDniCorrecto a false
			$bDniCorrecto=false;
		}
		// la funcion devuelve el valor de bDniCorrecto
		// siendo true si el valor del dni es correcto o false si el dni no es correcto
		return $bDniCorrecto;
	}
	/**
	 * Funcion comprobarAlfabetico()
	 * 
	 * Funcion que dada una cadena valida que esta este formada unicamente por letras
	 * 
	 * @param string cCadena cadena que queremos validar
	 * @return boolean bCadenaCorrecta devuelve true o false en funcion de si se trata de una cadena formada unicamente por letras o no
	 */
	public static function validarAlfabetico($cCadena)
	{
		// almacenamos en cPatron texto un patron con el que comprobaremos si se trata o no de una cadena
		$cPatronTexto = "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\-_\sª]+$/";
		// creamos e inicializamos a true la variable bCadenaCorrecta
		// esta variable sera la respuesta de la funcion
		$bCadenaCorrecta=true;
		//comprobamos que la cadena introducida coincide con la sintaxis permitida del patron y no esta vacia
		// si no coincide con la sintaxis permitida por el patron o está vacia
		if(preg_match($cPatronTexto, $cCadena)==0 || $cCadena==null || $cCadena=="")
		{
			// cambiamos el valor de bCadenaCorrecta a false
			$bCadenaCorrecta=false;
		}
		// devolvemos el valor de bCadenaCorrecta
		// siendo true si es una cadena valida o false si no es valida
		return $bCadenaCorrecta;
	}
	public static function validarAlfanumerico($cCadena)
	{
		// almacenamos en cPatron texto un patron con el que comprobaremos si se trata o no de una cadena
		$cPatronTexto = "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\-_\sª0-9]+$/";
		// creamos e inicializamos a true la variable bCadenaCorrecta
		// esta variable sera la respuesta de la funcion
		$bCadenaCorrecta=true;
		//comprobamos que la cadena introducida coincide con la sintaxis permitida del patron y no esta vacia
		// si no coincide con la sintaxis permitida por el patron o está vacia
		if(preg_match($cPatronTexto, $cCadena)==0 || $cCadena==null || $cCadena=="")
		{
			// cambiamos el valor de bCadenaCorrecta a false
			$bCadenaCorrecta=false;
		}
		// devolvemos el valor de bCadenaCorrecta
		// siendo true si es una cadena valida o false si no es valida
		return $bCadenaCorrecta;
	}
	/**
	 * Funcion validarNumerico()
	 * 
	 * Funcion que valida que el parametro sea un numero o un string numerico
	 * 
	 * @param int nNumero numero que queremos validar
	 * @return boolean true si el valor pasado como parametro es un numero o un string numerico o false en caso contrario
	 */
	public static function validarNumerico($nNumero)
	{
		// si el numero pasado como parametro no es un numero o un string numerico
		if(!is_numeric($nNumero))
		{
			// la funcion devolvera false
			return false;
		}
		// si el numero es correcto y se trata de un numero o de un string numerico la funcion devolvera true
		return true;
	}
	/**
	 * Funcion validarFecha()
	 * 
	 * Funcion que valida que una fecha sea correcta
	 * 
	 * @param string cFecha fecha que queremos validar
	 * @return boolean true si la fecha es valida o false si la fecha no es valida
	 */
	public static function validarFecha($cFecha, $cFechaMaxima='01/01/2200')
	{
		$cFechaMinima = time();
		$cFechaMaxima = strtotime($cFechaMaxima); //PASAR A TIMESTAMP PARA PODER OPERAR
        $fechaFormateada = strtotime($cFecha);  //CREAR FECHA PARA TRABAJAR CON LAS FUNCIONES DE PHP

        if (is_bool($fechaFormateada) && !empty($fecha)) {
            return false;
        } else {
            if(!empty($fecha) && ($fechaFormateada < $cFechaMinima) || ($fechaFormateada > $cFechaMaxima)){
                return false;
            }
        }
        return true;
	}
	public static function validarCodigoPostal($nCodigoPostal)
	{
		$cPatron="/^[0-9]{5}$/";
		// si no valida el patron y está vacio
		if(!preg_match($cPatron, $nCodigoPostal))
		{
			return false;
		}
		// la funcion devolvera true
		return true;
	}
	/**
	 * Funcion validarSexo()
	 * 
	 * Funcion que valida que el valor del sexo sea correcto
	 * 
	 * @param string cSexo valor del sexo que queremos validar
	 * @return boolean true si el valor del sexo es correcto o false si el valor del sexo no es correcto
	 */
	public static function validarSexo($cSexo)
	{
		// si el valor del sexo que queremos validar es distinto a los posibles valores permitidos
		if($cSexo!='H' && $cSexo!='M' && $cSexo!='O')
		{
			// la funcion devolvera false
			return false;
		}
		// la funcion devolvera true
		return true;
	}
	/**
	 * Funcion validarEstadoCivil()
	 * 
	 * Funcion que valida el estado civil
	 * 
	 * @param string cEstadoCivil estado civil que queremos validar
	 * @return boolean true si el estado civil es valido o false si el estado divil no es valido
	 */
	public static function validarEstadoCivil($cEstadoCivil)
	{
		// si el valor del estado civil que queremos validar es distinto de los posibles valores permitidos
		if($cEstadoCivil!='C' && $cEstadoCivil!='D' && $cEstadoCivil!='S')
		{
			// la funcion devolvera false
			return false;
		}
		// la funcion devolvera true
		return true;
	}
	/**
	 * Funcion validarTelefono()
	 * 
	 * Funcion que valida que un telefono sea valido
	 * 
	 * @param string cTelefono telefono que queremos validar
	 * @return boolean true si el telefono es valido o false si el telefono no es valido
	 */
	public static function validarTelefono($cTelefono)
	{
		// creamos un patron para validar el telefono
		// beme comenzar por 6 | 7 | 9 y estar formado por 9 numeros
		$cPatron="/^[6|7|9][0-9]{8}$/";
		// si no valida el patron o está vacio
		if(!preg_match($cPatron, $cTelefono) || $cTelefono==null || $cTelefono=="")
		{
			// el telefono no sera valido y la funcion devolvera false
			return false;
		}
		// si el telefono es valido la funcion devolvera true
		return true; 
	}
	/**
	 * Funcion validarUsername()
	 * 
	 * Funcion que dado un nombre de usuario valida que sea alfanumerico, tenga una longitud entre 4 y 15
	 * 
	 * @param string $cNombreUsuario nombre de usuario que uqeremos validar
	 * @return boolean true si el nombre de usuario es valido o false si el nombre de usuario no es valido
	 */
	public static function validarUsername($cNombreUsuario)
	{
		// si el nombre de usuario no es alfanumerico o la longitud es menor que 4 o mayor que 15
		if(!self::validarAlfanumerico($cNombreUsuario) || strlen($cNombreUsuario)<4 || strlen($cNombreUsuario)>15)
		{
		// el nombre de usuario no sera valido y la funcion devolvera false
		return false;
		}
		// si el nombre de usuario es valido la funcion devolvera true
		return true; 
	}
	/**
	 * Funcion validarPassword()
	 * 
	 * Funcion que dado un password valida que sea alfanumerico, tenga una longitud entre 8 y 16 
	 * y tenga al menos una letra mayuscula y un numero
	 * 
	 * @param string $cPassword nombre de usuario que uqeremos validar
	 * @return boolean true si el nombre de usuario es valido o false si el nombre de usuario no es valido
	 */
	public static function validarPasswordUsuario($cPassword)
	{
		// si el nombre de usuario no es alfanumerico o la longitud es menor que 4 o mayor que 15
		if(strlen($cPassword)<8 || strlen($cPassword)>16)
		{
			// el nombre de usuario no sera valido y la funcion devolvera false
			return false;
		}
		// si el password no tiene una letra mayuscula o no tiene un numero
		if (!preg_match("/[A-Z]/", $cPassword) || !preg_match("/[0-9]/", $cPassword)) {
			// el nombre de usuario no sera valido y la funcion devolvera false
			return false;
		}
		// si el nombre de usuario es valido la funcion devolvera true
		return true;
	}
	/**
	 * Funcion validarNombre()
	 * 
	 * Funcion que dado un nombre del usuario valida que sea alfabetico, tenga una longitud entre 3 y 30
	 * 
	 * @param string $cNombre nombre del usuario que uqeremos validar
	 * @return boolean true si el nombre del usuario es valido o false si el nombre del usuario no es valido
	 */
	public static function validarNombreUsuario($cNombre)
	{
		// si el nombre del usuario no es alfabetico o la longitud es menor que 3 o mayor que 30
		if(!self::validarAlfabetico($cNombre) || strlen($cNombre)<3 || strlen($cNombre)>30)
		{
		// el nombre del usuario no sera valido y la funcion devolvera false
		return false;
		}
		// si el nombre del usuario es valido la funcion devolvera true
		return true; 
	}
	/**
	 * Funcion validarApellidos()
	 * 
	 * Funcion que dado uno apellidos del usuario valida que sea alfabetico, tenga una longitud entre 4 y 60
	 * 
	 * @param string $cApellidos apellidos del usuario que uqeremos validar
	 * @return boolean true si los apellidos del usuario es valido o false si los apellidos del usuario no es valido
	 */
	public static function validarApellidosUsuario($cApellidos)
	{
		// si los apellidos del usuario no es alfabetico o la longitud es menor que 4 o mayor que 60
		if(!self::validarAlfabetico($cApellidos) || strlen($cApellidos)<4 || strlen($cApellidos)>60)
		{
		// los apellidos del usuario no sera valido y la funcion devolvera false
		return false;
		}
		// si los apellidos del usuario es valido la funcion devolvera true
		return true; 
	}
	/**
	 * Funcion validarEmail()
	 * 
	 * Funcion que valida que un email sea valido
	 * 
	 * @param string $cEmail email que queremos validar
	 * @return boolean true si el email es valido o false si el email no es valido
	 */
	public static function validarEmail($cEmail)
	{
		// si no valida el email o esta vacio
		if(!filter_var($cEmail, FILTER_VALIDATE_EMAIL) || $cEmail==null || $cEmail=="")
		{
			// el email no sera valido y la funcion devolvera false
			return false;
		}
		// si el email es valido la funcion devolvera true
		return true; 
	}
	/**
	 * Funcion validarPerfil()
	 * 
	 * Funcion que valida que un perfil sea valido
	 * 
	 * @param string $cPerfil perfil que queremos validar
	 * @return boolean true si el perfil es valido o false si el perfil no es valido
	 */
	public static function validarPerfil($cPerfil)
	{
		// si el valor del perfil que queremos validar es distinto a los posibles valores permitidos
		if($cPerfil!="admin" && $cPerfil!="user")
		{
			// el perfil no sera valido y la funcion devolvera false
			return false;
		}
		// si el perfil es valido la funcion devolvera true
		return true; 
	}
}
