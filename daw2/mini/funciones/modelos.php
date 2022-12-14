<?php
//Un sistema basico de gestion de modelos de datos
//(c) DAW2 - EPSZ - Univ. Salamanca

//---------------------------------------------------------------------------
//La conexion a la base de datos se generaliza en esta clase, la cual utiliza
//el driver "MySQLi" que es más actual y mejor que el "MySQL" antiguo.
class basedatos
{
  //-------------------------------------------------------------------------
  //Atributo con la instancia de la conexion a la BD.
  private static $conexion= null;
  
  //-------------------------------------------------------------------------
  //Atributo con el mensaje de error producido en la última ejecución, o 
  //"false" si no hubo.
  public static $error= false;
  
  //-------------------------------------------------------------------------
  //Atributo con el indicador de depuracion de la ejecución de las consultas
  //sobre la base de datos y otros mensajes de información.
  public static $depurar= false;
  
  //-------------------------------------------------------------------------
  //Conecta a la base de datos configurada en la aplicacion.
  public static function conectar()
  {
    //Si no esta conectado, se conecta, sino, no.
    if (self::$conexion === null) {
      $svr= config::get( 'bd.servidor', 'localhost');
      $usr= config::get( 'bd.usuario', 'root');
      $pwd= config::get( 'bd.clave', '');
      $dbn= config::get( 'bd.nombre', '');
      self::$depurar= config::get( 'bd.depurar', false);
      self::$conexion= new mysqli( $svr, $usr, $pwd, $dbn);
      if (!mysqli_connect_error()) {
        $charset= config::get( 'bd.charset', '');
        if (!empty($charset)) self::$conexion->set_charset( $charset);
      }//if
      if (!mysqli_connect_error()) {
        if (self::$depurar) log::mensajeLin( __METHOD__.' Ok');
        self::$error= false;
      } else {
        self::$error= 'Error BD('.mysqli_connect_errno().'): '.mysqli_connect_error();
        self::$conexion= null;
        log::mensajeLin( __METHOD__.' '.self::$error);
      }//if
    }//if
    return (self::$conexion !== null);
  }//conectar
  
  //-------------------------------------------------------------------------
  //Obtener un objeto "MySQLi_Result" devuelvo por la consulta SQL enviada,
  //o "false" si hubo error.
  public static function ejecutarSQL( $sql)
  {
    $res= false;
    if (self::conectar()) {
      if (self::$depurar) log::mensajeLin( __METHOD__.' '.$sql);
      $res= self::$conexion->query( $sql);
      if ($res === false) {
        self::$error= 'BaseDatos Error'
            .' ('.self::$conexion->sqlstate.')'
            .': '.self::$conexion->errno
            .' - '.self::$conexion->error;
        log::mensajeLin( __METHOD__.' '.self::$error);
        log::mensajeLin( __METHOD__.' SQL= '.$sql);
      }//if
    }//if
    return $res;
  }//ejecutarSQL
  
  //-------------------------------------------------------------------------
  //Obtener un array asociativo del primer registro devuelvo por la 
  //consulta SQL enviada.
  //Si hay error se devuelve el valor falso ("false"), y si no hay registros 
  //resultantes, se devuelve el valor nulo ("null").
  public static function obtenerUno( $sql)
  {
    $res= false;
    $result= self::ejecutarSQL( $sql);
//log::mensajeLin( __METHOD__.' '.__LINE__.' '.var_export( $result, true));
    if ($result !== false) {
      $res= $result->fetch_assoc();
      $result->close();
    }//if  
//log::mensajeLin( __METHOD__.' '.__LINE__.' '.var_export( $res, true));
    return $res;
  }//obtenerUno
  
  //-------------------------------------------------------------------------
  //Obtener un array de arrays asociativos con los registros devuelvos por la 
  //consulta SQL enviada. Se pueden limitar los resultados indicando el número
  //de página y de filas por página, en cuyo caso a la consulta SQL dada se
  //le agrega el límite solicitado (LIMIT offset,filas).
  //Si la página es negativa o las filas menor que 1, no se limita el resultado.
  //El número de página es relativo al 0, no al 1.
  public static function obtenerTodos( $sql, $pagina=-1, $filas=0)
  {
    $res= false;
    $limite= '';
    if ($pagina < 1) $pagina= 0;//se empieza en la primera pagina como mucho.
    if ($filas < 0) $filas= 0;//como minimo se obtiene 1 elemento por pagina.
    if (($pagina >= 0) && ($filas > 0)) {
      $limite= ' LIMIT '.($pagina * $filas).','.$filas;
    }//if
//log::mensajeLin( __METHOD__.' '.__LINE__.' '.print_r( $sql.$limite, true));
    $result= self::ejecutarSQL( $sql.$limite);
    if ($result !== false) {
//log::mensajeLin( __METHOD__.' '.__LINE__.' '.var_export( $result, true));
      //Control de existencia de la funcion "fetch_all" en versiones de PHP < 5.3
      if (method_exists('mysqli_result', 'fetch_all')) {
        $res= $result->fetch_all( MYSQLI_ASSOC);
      } else {
        for( $res = array(); $registro= $result->fetch_array( MYSQLI_ASSOC);) $res[]= $registro;
      }//if
      $result->close();
    }//if  
    return $res;
  }//obtenerTodos
  
  //-------------------------------------------------------------------------
  //Obtener el numero de registros que se obtendrán de la orden SQL dada, .
  //para lo cual se envuelve en una orden SQL de cuenta (COUNT).
  //Devuelve el número de registros que resultan de la SQL indicada, o si no
  //hay registros resultantes, se devuelve cero.
  public static function contar( $sql)
  {
    $res= false;
    $result= self::ejecutarSQL( 'SELECT COUNT(*) AS total FROM ('.$sql.') AS q');
    if ($result !== false) {
      $res= $result->fetch_assoc();
      $result->close();
      if ($res !== false) $res= $res['total']; else $res= 0;
    }//if  
    return $res;
  }//contar
  
  //-------------------------------------------------------------------------
  //Obtener el identificador (ID) generado por la última consulta ejecutada
  //en una tabla con una columna que tiene el atributo "AUTO_INCREMENT".
  //Si la última SQL ejecutada no es de tipo "INSERT" o "UPDATE", o la tabla
  //no contiene una columna autoincremental, o no hay conexion con la base de
  //datos, se devuelve un cero, el cual es un valor no válido en campos de
  //este tipo.
  public static function ultimo_id()
  {
    $res= 0;
    if (self::$conexion !== null) {
      $res= self::$conexion->insert_id;
      //--if (self::$depurar) log::mensajeLin( __METHOD__.' ID= '.$res);
    }//if
    return $res;
  }//ultimo_id
  
  //-------------------------------------------------------------------------
  //Obtener el numero de resultados de la última consulta ejecutada de tipo
  //INSERT, UPDATE, REPLACE o DELETE. Y para consultas de tipo SELECT, se
  //devuelve el número de registros resultantes si el resultado se almacena
  //en buffer intermedio, sino puede dar resultados incorrectos porque aún
  //no se hayan recuperado todos los registros resultantes.
  public static function filas_afectadas()
  {
    $res= 0;
    if (self::$conexion !== null) {
      $res= self::$conexion->affected_rows;
    }//if
    return $res;
  }//filas_afectadas
  
  //-------------------------------------------------------------------------
  //Obtener la cadena de caracteres escapada adecuadamene para mezclar dentro
  //de una cadena SQL.
  public static function escapar( $cadena)
  {
    $res= $cadena;
    if (self::conectar()) {
      $res= self::$conexion->escape_string( $cadena);
    }//if
    return $res;
  }//escapar
  
  //-------------------------------------------------------------------------
  //Procesar un array de datos y hacer las adaptaciones de sus valores para
  //protegerlos frente a cadenas SQL.
  //Las adaptaciones que se hacen son las siguientes:
  //  - Si el valor es el valor "null" de PHP, se adapta a la cadena "NULL"
  //  de SQL.
  //  - Si el valor es logico se adapta al valor 1 o 0 según éste sea 
  //    verdadero o falso respectivamente.
  //  - Si el valor es cualquier otra cosa (numero, cadena, fecha, hora, ...)
  //    se escapa adecuadamente según la conexion de la base de datos activa.
  public static function escaparArray( $datos)
  {
    foreach( $datos as $campo => $valor) {
      if ($valor === null) $datos[$campo]= 'NULL';
      else if (is_bool($valor)) $datos[$campo]= ($valor ? 1 : 0);
      else $datos[$campo]= '"'.basedatos::escapar( $valor).'"';
    }//foreach
    return $datos;
  }//escaparArray
  
  //-------------------------------------------------------------------------
  //Crear una cadena de condicion SQL con los datos de filtrado preparados y
  //unidos por el operador indicado.
  //El filtro puede ser una cadena ya preparada para unir a una SQL como
  //parte de la condicion "WHERE", o un array de elementos que generan una
  //o varias condiciones que se unirán por el operador indicado.
  //El operador de union puede ser "AND", u "OR", y si no se indica, se asume
  //"AND" de forma predeterminada.
  //El array de elementos de filtro si se indica, debe contener una serie de
  //elementos de tipo CAMPO => OPERADOR, es decir, que las claves del array
  //serán los nombres campo (o una expresión SQL válida) al que se aplicará
  //el OPERADOR, el cual puede ser un valor directo, o un array con los
  //detalles del operador a aplicar.
  //Si es un valor directo, se asumirá el operador "=" directamente.
  //Si es un array, el primer elemento (indice 0) debe ser la cadena con uno
  //de los operadores posibles, y los siguientes elementos el valor o valores
  //necesarios para completar el operador.
  //Los operadores posibles, el número de valores que requieren y un ejemplo
  //de cómo es la expresión son:
  // - "="          -> 1 -> campo_o_expresion =  valor1
  // - "<>"         -> 1 -> campo_o_expresion <> valor1
  // - "<"          -> 1 -> campo_o_expresion <  valor1
  // - "<="         -> 1 -> campo_o_expresion <= valor1
  // - ">"          -> 1 -> campo_o_expresion >  valor1
  // - ">="         -> 1 -> campo_o_expresion >= valor1
  // - "BETWEEN"    -> 2 -> campo_o_expresion BETWEEN valor1 AND valor2
  // - "NOT BETWEEN"-> 2 -> campo_o_expresion NOT BETWEEN valor1 AND valor2
  // - "NULL"    -> 0 -> campo_o_expresion IS NULL
  // - "NOT NULL"-> 0 -> campo_o_expresion IS NOT NULL
  // - "IN"         -> 1 cadena_condicion-> campo_o_expresion IN cadena_condicion
  // - "IN"         -> 1 array_valores -> campo_o_expresion IN (array_valores)
  // - "NOT IN"     -> 1 cadena_condicion-> campo_o_expresion NOT IN cadena_condicion
  // - "NOT IN"     -> 1 array_valores -> campo_o_expresion NOT IN (array_valores)
  // - "LIKE"       -> 1 -> campo_o_expresion LIKE valor1
  // - "NOT LIKE"   -> 1 -> campo_o_expresion NOT LIKE valor1
  //
  public static function crearCondicion( $filtros, $operador=null)
  {
    $condicion= '';
    //----------
    if (empty($operador)) $operador= ''; else $operador= trim( $operador);
    if (empty($operador)) $operador= 'AND'; else $operador= strtoupper( $operador);
    //----------
    if (!is_array($filtros)) {
      //Asumir una cadena ya preparada.
      $filtros= trim( $filtros);
      if (!empty($filtros)) $condicion= $filtros;
    } else {
      //Asumir un array de condiciones u operaciones de filtro.
      $condiciones= array();
      //----------
      foreach( $filtros as $campo => $valor) {
        if (!is_array($valor)) {
          //Si el valor no es un array, se asume el comparador "=",
          $condiciones[]= $campo.' = "'.self::escapar( $valor).'"';
        } else {
          //Si el valor es un array, se debe indicar el operador como primer
          //elemento, y el resto en función de lo que requiera el operador.
          $op= strtoupper( trim( $valor[0]));
          if (empty($op)) $op= '=';
          switch($op) {
          case '=':
          case '<>':
          case '<':
          case '<=':
          case '>':
          case '>=':
          case 'LIKE':
          case 'NOT LIKE':
            $valor1= $valor[1];
            $condiciones[]= $campo.' '.$op.' "'.self::escapar( $valor1).'"';
            break;
          case 'BETWEEN':
          case 'NOT BETWEEN':
            $valor1= $valor[1];
            $valor2= $valor[2];
            $condiciones[]= $campo.' '.$op.' "'.self::escapar( $valor1).'"'
                                      .' AND "'.self::escapar( $valor2).'"';
            break;
          case 'NULL':
          case 'NOT NULL':
            $condiciones[]= $campo.' IS '.$op;
            break;
          case 'IN':
          case 'NOT IN':
            $conjunto= $valor[1];
            if (!is_array($conjunto)) {
              //Se asume el conjunto como la cadena final con parentesis y todo.
            } else if (count($conjunto) == 0) {
              //Si no hay datos en el array, no se puede hacer nada, pero para
              //ser coherente y de error el SQL, se pone el conjunto "vacio".
              $conjunto= '()';
            } else {
              $metodo= get_class().'::escapar';
              $conjunto= array_map( $metodo, $conjunto);
              $conjunto= '("'.implode( '", "', $conjunto).'")';
            }//if
            $condiciones[]= $campo.' '.$op.' '.$conjunto;
            break;
          //case .....: //Otros casos que puedan surgir...
          }//switch
        }//if
      }//foreach
      //----------
      //Componer la condicion final.
      $total= count( $condiciones);
      if ($total > 1) {
        $condicion= '('.implode( ') '.$operador.' (', $condiciones).')';
        //Aunque se podría envolver siempre, se envuelve el resultado entre 
        //parentesis si no es el operador "AND" para que los "OR" sean 
        //coherentes en SQL.
        //--$condicion= '('.$condicion.')';
        if (strcasecmp( $operador, 'AND') !== 0) $condicion= '('.$condicion.')';
      } else if ($total == 1) {
        $condicion= $condiciones[0];
      } else {
        //Nada, sin condicion resultante.
      }//if
    }//if
    //----------
    return $condicion;
  }//crearCondicion
  
  //-------------------------------------------------------------------------
  public static function crearWhere( $filtros, $operador=null)
  {
    $condicion= self::crearCondicion( $filtros, $operador);
    return (!empty($condicion) ? 'WHERE '.$condicion : '');
  }//crearWhere
  
  //-------------------------------------------------------------------------
  //Crear una cadena de ordenacion SQL con los datos indicados.
  public static function crearOrdenacion( $ordenes)
  {
    $ordenacion= '';
    if (!is_array($ordenes)) {
      //Asumir que se tiene ya la cadena con lo que queramos.
      $ordenacion= (string)$ordenes;
    } else if (count($ordenes) == 0) {
      //No hay orden especificado.
    } else {
      $orden= array();
      foreach( $ordenes as $campo => $direccion) {
        if ((string)$campo == (string)((int)$campo)) {
          //Si la clave "campo" es numerica, se tiene en "direccion" el 
          //campo y la direccion se asume "ascendente".
          $campo= $direccion;
          $direccion= 'ASC';
        } else if (is_boolean($direccion)
                  || ((string)$direccion == (string)((int)$direccion))) {
          //Si la "direccion" es booleana o numerica, se asume que si al
          //evaluarlo como valor logico, lo verdadero es "ascendente" y lo
          //falso es "descendente".
          $direccion= ($direccion ? 'ASC' : 'DESC');
        } else {
          //Si llega aqui es que se indica el campo y direccion.
          //No se valida si la "direccion" es correcta, que de error de SQL.
          $direccion= strtoupper( $direccion);
        }//if
        //----------
        $orden[]= $campo.' '.$direccion;
      }//foreach
      //----------
      if (count($orden) == 1) {
        $ordenacion= $orden[0];
      } else {
        $ordenacion= implode( ', '.$orden);
      }//if
    }//if
    return $ordenacion;
  }//crearOrdenacion
  
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  public static function crearOrderBy( $ordenes)
  {
    $ordenacion= self::crearOrdenacion( $ordenes);
    return (!empty($ordenacion) ? 'ORDER BY '.$ordenacion : '');
  }//crearOrderBy
  
  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  
}//basedatos

//---------------------------------------------------------------------------
class modelos
{
  
}//class modelos


//---------------------------------------------------------------------------
//Clase de la que hereda un modelo de datos generico, no de base de datos.
abstract class modelo
{

  //-------------------------------------------------------------------------
  //Atributo con la ruta relativa a "index.php" donde se almacenan los modelos
  //de la aplicacion.
  public static $rutaModelos= 'modelos';
  
  //-------------------------------------------------------------------------
  //Una forma sencilla de incluir uno o varios archivos de la carpeta de 
  //modelos para que sus definiciones estén disponibles en el sistema de
  //ejecución de PHP.
  public static function usar( $modelos)
  {
    if (!is_array($modelos)) $modelos= array( (string)$modelos);
    foreach( $modelos as $modelo) {
      $archivo= self::$rutaModelos.'/'.$modelo.'.php';
      if (is_readable($archivo)) {
        //Los archivos de modelos se deben cargar una sola vez porque definen
        //una clase de objeto y no puede redefinirse una segunda vez.
        require_once( $archivo);
      } else {
        error_grave( 'modelo no disponible ('.$archivo.').');
      }//if
    }//foreach
  }//usar
  
  //-------------------------------------------------------------------------
  //Metodo para llenar el modelo desde una array de datos como puede ser una
  //variable que haya venido desde un formulario, o de una tabla de una base 
  //de datos.
  public function llenar( $datos)
  {
    if (is_array( $datos)) {
      //Una forma rapida de copiar valores por clave del array a atributos 
      //del objeto, pero que sin controlar el tipo de acceso del atributo
      //(publico, protegido, privado).
      foreach( $datos as $k => $v) {
        if (property_exists( $this, $k)) $this->$k= $v;
        //Aqui se puede hacer algo si la propiedad no existe, pero no importa.
      }//foreach
    }//if
  }//llenar
  
  //-------------------------------------------------------------------------
  //Metodo para obtener un modelo desde algún sistema de persistencia, bien
  //sea en Base de Datos, en fichero particular, aunque depende de la 
  //implementación en herencia del mismo.
  //El parametro "$filtroIDs" contiene el/los datos que identifican de forma
  //única al objeto dentro del sistema de persistencia utilizado.
  abstract public function cargar( $filtroIDs);
  
  //-------------------------------------------------------------------------
  //Metodo para almacenar el modelo en algún sistema de persistencia, bien
  //sea en Base de Datos, en fichero particular, aunque depende de la 
  //implementación en herencia del mismo.
  abstract public function guardar();
  
  //-------------------------------------------------------------------------
  //Metodo para eliminar el modelo de algún sistema de persistencia, bien
  //sea en Base de Datos, en fichero particular, aunque depende de la 
  //implementación en herencia del mismo.
  abstract public function eliminar();
  
  //-------------------------------------------------------------------------
  //Metodo para sobreescribir en herencia que se utiliza para validar la
  //información que esta en los atributos del modelos y devolver "verdadero"
  //o "falso" según aparezca algún atributo no válido.
  //Por defecto devuelve "verdadero".
  public function validar()
  {
    return true;
  }//validar
  
}//class modelo


//---------------------------------------------------------------------------
//Clase de la que hereda un modelo de datos que refleja una tabla en una base 
//de datos.
abstract class modeloDAO extends modelo
{
  //-------------------------------------------------------------------------
  //Atributo a establecer en herencia para indicar el nombre de la tabla en
  //la base de datos a la hora de generar las consultas SQL necesarias que
  //son básicas o esenciales.
  protected $nombreTabla= null;
 
  //-------------------------------------------------------------------------
  //Atributo a establecer en herencia para indicar el campo que es un campo
  //establecido como autonumerico en la tabla en la base de datos. Si no hay
  //campo autonumerico no se debe establecer su valor.
  protected $campoAutonumerico= null;
  
  //-------------------------------------------------------------------------
  //Atributo a establecer en herencia para indicar el campo o campos que son 
  //clave primaria de la tabla en la base de datos. Si no hay clave primaria
  //no se debe establecer su valor.
  //Se debe iniciar como un array de (clave=>valor) donde la clave es el 
  //campo que forma parte de la clave primaria, y el valor inicialmente se
  //deja a nulo, pero se usará en las cargas y grabaciones para actualizarlo
  //con el último valor clave, y así poderlo utilizar en las condiciones de
  //actualización y búsquedas similares.
  protected $campoClave= array();
  
  //-------------------------------------------------------------------------
  //Atributo que indica si la instancia del objeto es nueva ("true") o se ha
  //cargado desde la base de datos ("false"), para diferenciar a la hora de
  //poder guardarlo o tratar al objeto de forma diferente.
  protected $nuevo= true;
  
  //-------------------------------------------------------------------------
  //Metodo para conocer si el objeto es nuevo o no, o lo que es lo mismo, se 
  //ha cargado de la BD.
  public function esNuevo() 
  {
    return $this->nuevo;
  }//esNuevo
  
  //-------------------------------------------------------------------------
  //Inicia la copia de la clave primaria con los datos actuales del modelo
  //segun la configuracion del atributo "$campoClave" que debe ser un array,
  //y el contenido de los propios atributos del modelo.
  protected function llenarClave()
  {
//log::mensajeLin( __METHOD__.' '.__LINE__.' antes= '.print_r( $this->campoClave, true));
    if (is_array( $this->campoClave)) {
      foreach( $this->campoClave as $campo => $valor) {
        //El $valor se ignora porque se coge del atributo de la clase. Si hay
        //algun error de nombres de campo/atributo, se genera un fallo de PHP.
        $this->campoClave[$campo]= $this->$campo;
      }//foreach
    }//if
//log::mensajeLin( __METHOD__.' '.__LINE__.' despues= '.print_r( $this->campoClave, true));
  }//llenarClave
  
  //-------------------------------------------------------------------------
  //Obtiene la clave primaria para este modelo como un array de elementos
  //con (campo => valor) que la componen. Los datos se obtienen del atributo
  //"$campoClave" que debe estar configurado en el modelo.
  public function clavePrimaria()
  {
    //Si el modelo es nuevo, el campoClave no estará iniciado, con lo que 
    //se debe "llenar" con los atributos clave que contenga actualmente el 
    //modelo según su configuración de campos clave.
    if ($this->nuevo) $this->llenarClave();
    return $this->campoClave;
  }//clavePrimaria
  
  //-------------------------------------------------------------------------
  //Obtiene la parte de condicion WHERE que sirve de busqueda de un registro
  //segun la configuracion del atributo "$campoClave" y los valores que tiene.
  protected function condicionClave()
  {
//log::mensajeLin( __METHOD__.' '.__LINE__.' campoClave= '.print_r( $this->campoClave, true));
    $res= '(1==0)';//condicion falsa por si va mal.
    if (is_array( $this->campoClave)) {
      $datos= array();
      foreach( $this->campoClave as $campo => $valor) {
        $datos[]= $campo.' = "'.basedatos::escapar( $valor).'"';
      }//foreach
//log::mensajeLin( __METHOD__.' '.__LINE__.' datos= '.print_r( $datos, true));
      if (count($datos) > 0) $res= '('.implode( ') AND (', $datos).')';
    }//if
//log::mensajeLin( __METHOD__.' '.__LINE__.' res= '.print_r( $res, true));
    return $res;
  }//condicionClave
  
  //-------------------------------------------------------------------------
  //Metodo para llenar el modelo desde una array de datos que representa un
  //registro obtenido de la base de datos, se distingue del metodo heredado
  //"llenar()" porque es genérico y no hace más que copiar los datos que 
  //existan como atributos del modelo. Para ampliar la copia a los registros
  //de una BD y establecer el control de "nuevo", la copia de atributos que
  //se han configurado como clave primaria y otros detalles, se debe usar
  //este método.
  public function cargarRegistro( $registro)
  {
    $this->llenar( $registro);//Llenar los atributos con los datos recibidos.
    $this->llenarClave();//Actualizar los datos de la clave primaria.
    $this->nuevo= false;
  }//cargarRegistro
  
  //-------------------------------------------------------------------------
  //Metodo para iniciar la instancia del objeto con el registro obtenido
  //de la busqueda en la BD de una clave primaria concreta dada por el 
  //parametro "$filtroIDs" que debera contener el valor de la clave primaria
  //del registro a obtener, o un array de tipo (clave => valor) con las claves
  //primarias o atributos de filtrado con los datos que identifican de forma
  //única al objeto dentro de la tabla de la base de datos.
  //Devuelve "verdadero" si la carga ha sido correcta, "falso" en cualquier
  //otro caso.
  public function cargar( $filtroIDs)
  {
    $res= false;
    //Si no es un array, se inicia como un array con el campo clave definido
    //en la clase, si lo está y es sólo un campo.
    if (!is_array( $filtroIDs) && is_array( $this->campoClave) && (count( $this->campoClave) == 1)) {
      reset( $this->campoClave);
      $filtroIDs= array( key( $this->campoClave) => $filtroIDs);
    }//if
//log::mensajeLin( __METHOD__.' '.__LINE__.' filtroIDs= '.print_r( $filtroIDs, true));
    
    if (is_array( $filtroIDs)) {
      $sql= $this->sqlConsultar( $filtroIDs);
//log::mensajeLin( __METHOD__.' '.__LINE__.' SQL= '.print_r( $sql, true));
      if ($sql !== false) {
        $registro= basedatos::obtenerUno( $sql);
//log::mensajeLin( __METHOD__.' '.__LINE__.' registro= '.print_r( $registro, true));
        if (($registro !== null) && ($registro !== false)) {
          $this->cargarRegistro( $registro);
          $res= true;
        }//if
      }//if
    }//if
    return $res;
  }//cargar
  
  //-------------------------------------------------------------------------
  //Metodo para guardar la instancia del objeto con los datos que contiene
  //actualmente en la BD. 
  //Por defecto se llama al metodo "validar" de la clase si no se indica lo
  //contrario.
  //Se inserta o actualiza según el estado del atributo "$nuevo" de la clase.
  //Si es nuevo, y tiene definida clave primaria autonumerica, se intenta
  //obtener de la BD automáticamente y se quita el estado de "nuevo".
  //Devuelve "verdadero" si la grabacion ha sido correcta, "falso" en cualquier
  //otro caso.
  public function guardar( $validar=true)
  {
    $res= true;
    //Validar si se debe hacer...
    if ($validar) $res= $this->validar();
    //si ha validado bien, o no se ha ejecutado, almacenar...
    if ($res) {
      $sql= ($this->nuevo ? $this->sqlInsertar() : $this->sqlActualizar());
//log::mensajeLin( __METHOD__.' '.__LINE__.' SQL= '.print_r( $sql, true));
      if ($sql !== false) {
        $res= basedatos::ejecutarSQL( $sql);
        //Si se ha ejecutado la SQL obtenida...
//log::mensajeLin( __METHOD__.' '.__LINE__.' res= '.print_r( $res, true));
        if ($res === true) {//comparar con "true" porque puede ser "false" u "objeto"...
          //Si el registro es nuevo, se intenta coger el ID autonumerico (si existe)
          if ($this->nuevo) {
            if (!empty($this->campoAutonumerico) && (basedatos::ultimo_id() != 0)) {
              $campo= $this->campoAutonumerico;
              $this->$campo= basedatos::ultimo_id();
            }//if
            $this->nuevo= false;
            $this->llenarClave();//Actualizar los datos de la clave primaria.
          }//if
        } else {
          //Si resulta "false" u "objeto", no ha ido bien, pues una SQL de 
          //insercion o actualizacion deben devolver "true".
          $res= false;
        }//if
      }//if
    }//if
    return $res;
  }//guardar
  
  //-------------------------------------------------------------------------
  //Metodo para eliminar el registro correspondiente a la instancia del 
  //objeto indicado, el cual debe haber sido previamente cargado desde la 
  //base de datos o que haya sido guardado si era nuevo.
  //Los atributos del objeto se siguen manteniendo en memoria tras el borrado
  //en la base de datos.
  //Devuelve "verdadero" si la eliminacion ha sido correcta, "falso" en
  //cualquier otro caso.
  public function eliminar()
  {
    $res= false;
    if (!$this->nuevo) {
      $sql= $this->sqlEliminar();
      if ($sql !== false) {
        $res= basedatos::ejecutarSQL( $sql);
//log::mensajeLin( __METHOD__.' '.__LINE__.' SQL= '.print_r( $sql, true));
        //Si se ha ejecutado la SQL obtenida...
        if ($res === true) {//comparar con "true" porque puede ser "false" u "objeto"...
          //Tras el borrado, marcar la instancia como si fuera nueva, pues no
          //existe en la base de datos ya.
          $this->nuevo= true;
        } else {
          //Si resulta "false" u "objeto", no ha ido bien, pues una SQL de 
          //insercion o actualizacion deben devolver "true".
          $res= false;
        }//if
      }//if
    }//if
    return $res;
  }//eliminar
  
  //-------------------------------------------------------------------------
  //Metodo que se puede ampliar o sobreescribir en herencia para obtener la 
  //orden SQL que permite localizar un registro concreto en la tabla que se
  //corresponde con el modelo de datos.
  protected function sqlConsultar( $filtro)
  {
    $tabla= basedatos::escapar( $this->nombreTabla);
    $sql= 'SELECT * FROM '.$tabla;
    if (!empty($filtro)) {
      $condicion= basedatos::crearCondicion( $filtro);
      if (!empty($condicion)) $sql.= ' WHERE '.$condicion;
    }//if
    return $sql;
  }//sqlConsultar
  
  //-------------------------------------------------------------------------
  //Metodo a implementar en herencia para obtener la orden SQL que permite
  //buscar y extraer un registro o una lista de registros de la tabla en la 
  //base de datos.
  //El parametro "$filtro" es un array de datos de tipo (clave => valor) con
  //los campos y valores a utilizar en la busqueda. En caso de querer obtener
  //un solo registro, el filtro deberían identificar de forma única al mismo.
  //--abstract public function sqlFiltrar( $filtro);
  //abstract protected function sqlListar( $filtro);
  
  
  //-------------------------------------------------------------------------
  //Metodo que se debe implementar en herencia para devolver el array de 
  //datos que mapean los atributos de la instancia actual del modelo, en los
  //campos del registro en la tabla en la base de datos.
  //El array devuelto debe tener como claves los nombres de los campos de la
  //tabla en la base de datos, y como valores los datos como cadenas 
  //protegidas o "escapadas" para la base de datos, o valores nulos "NULL" si
  //deben almacenarse así. Para ello se puede hacer uso del metodo
  //"basedatos::escaparArray( $datos)" que facilita el trabajo.
  //El argumento "$insertar" se puede utilizar para adaptar o no los datos
  //resultantes en función de si es verdadero o falso. Si es verdadero, se
  //deben devolver para SQL "INSERT" y si es falso para SQL "UPDATE".
  abstract protected function datosTabla( $insertar);
  
  //-------------------------------------------------------------------------
  //Metodo que se puede ampliar o sobreescribir en herencia para obtener la 
  //orden SQL que permite insertar un registro nuevo en la tabla 
  //correspondiente al modelo de datos.
  protected function sqlInsertar()
  {
    //Preparar los datos del modelo.
  $tabla= basedatos::escapar( $this->nombreTabla);
    $datos= $this->datosTabla( true);//Datos ya escapados para SQL.
    $campos= implode( ', ', array_keys( $datos));
    $valores= implode( ', ', array_values( $datos)); 
    //----------
    $sql= 'INSERT INTO '.$tabla.' ('.$campos.') VALUES ('.$valores.')';
    //----------
    return $sql;
  }//sqlInsertar
  
  //-------------------------------------------------------------------------
  //Metodo a implementar en herencia para obtener la orden SQL que permite
  //actualizar o modificar un registro existente en la tabla correspondiente
  //al modelo de datos.
  protected function sqlActualizar()
  {
    //Preparar los datos.
  $tabla= basedatos::escapar( $this->nombreTabla);
    $datos= $this->datosTabla( false);//Datos ya escapados para SQL.
    foreach( $datos as $campo => $valor) {
      $datos[$campo]= $campo.'='.$valor;
    }//foreach
    $datos= implode( ', ', $datos);
    $condicion= $this->condicionClave();
    //----------
    $sql= 'UPDATE '.$tabla.' SET '.$datos.' WHERE '.$condicion;
    //----------
    return $sql;
  }//sqlActualizar
  
  //-------------------------------------------------------------------------
  //Metodo a implementar en herencia para obtener la orden SQL que permite
  //eliminar un registro existente en la tabla correspondiente al modelo de 
  //datos.
  protected function sqlEliminar()
  {
    //Preparar los datos.
    $tabla= basedatos::escapar( $this->nombreTabla);
    $condicion= $this->condicionClave();
    //----------
    $sql= 'DELETE FROM '.$tabla.' WHERE '.$condicion;
    //----------
    return $sql;
  }//sqlEliminar
  
  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  
}//class modeloDAO
