<?php
class Users extends modeloDAO
{
  //Atributos del objeto en la base de datos
  public $id;
  public $nombre;
  public $login;
  public $password;
  public $perfil;
  public $ultima_fecha;
  
  //-------------------------------------------------------------------------
  //Atributos a iniciar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  protected $nombreTabla= 'usuarios';
  protected $campoClave= array( 'id'=>null);
  //--protected $campoAutonumerico= null;//
  
  //-------------------------------------------------------------------------
  //Metodos a implementar por heredar de "modelo".
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //Validar los datos antes de almacenarlos en la BD o cuando se quiera.
  //Debe devolver "verdadero" si se valida todo correctamente, sino "falso".
  /*-----Comentado mientras no se utilice
  public function validar()
  {
    return true;
  }//validar
  //-----*/
  
  //-------------------------------------------------------------------------
  //Metodos a implementar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  
  //-------------------------------------------------------------------------
  //Devolver los datos necesarios para generar una orden SQL para INSERTAR
  //o ACTUALIZAR un registro en la base de datos para este modelo.
  protected function datosTabla($insertar)
  {
    $datos= array(
      'id'=>$this->id,
	  'nombre'=>$this->nombre,
	  'login'=>$this->login,
	  'password'=>$this->password,
	  'perfil'=>$this->perfil,
	  'ultima_fecha'=>$this->ultima_fecha,
    );
	return basedatos::escaparArray( $datos);
  }//datosTabla
  
  //-------------------------------------------------------------------------
  //Obtener la orden SQL para listar los registros de "articulos" de la tabla, 
  //sin imponer limitaciones al número de filas resultantes, ya que la posible
  //paginación se añade posteriormente. 
  //Esta consulta está enfocada a la busqueda de registros para la sección de 
  //administración de articulos.
  // - $orden --> Se puede indicar el orden de los resultados tal cual se 
  // haría en la parte "ORDER BY" de la orden SQL, por defecto se ordena 
  // por "referencia".
  public static function sqlListar( $orden='')
  {
    if (empty($orden)) $orden= 'id ASC';
    //----------
    $sql= 'SELECT * FROM usuarios ORDER BY '.$orden;
    return $sql;
  }//sqlListar
  
  public static function sqlObtenerUsuario($login,$pass)
  {
   
    $sql= "SELECT * FROM usuarios where login='".$login."' and password='".$pass."'";
    return $sql;
  }//sqlListar
  
    public static function sqlActualizarAcceso($id)
  {
   
    $sql= "UPDATE usuarios SET ultima_fecha=CURRENT_TIMESTAMP WHERE id=".$id;
    return $sql;
  } 
 
  
  /*public static function sqlDetalle($referencia)
  {
    //----------
    $sql= 'SELECT * FROM articulos where referencia="'.$referencia.'"';
    return $sql;
  }*/
  
  
  
  
  //-------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  
}//articulo