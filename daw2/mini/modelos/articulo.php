<?php
class articulo extends modeloDAO
{
  //Atributos del objeto en la base de datos
  public $referencia; //Referencia unica del articulo, creada por el usuario a su conveniencia
  public $texto;      //Texto descriptivo del articulo  
  public $precio;     //Precio del articulo con 2 decimales
  public $iva;        //Tipo de IVA del articulo en porcentaje
  public $notas;      //Notas internas para el Articulo
  public $tipo;		  //Determina el tipo de articulo que es
  public $titulo;     //Titulo o nombre del articulo
  public $ISBN;		  //ISBN en caso de ser un libro
  public $duracion;   //Determina la duracion en caso de ser una pelicula o cancion
  public $paginas;    //Determina las paginas en caso de ser libro o revista
  public $tamaño;     //Determina el tamaño en caso de ser juego, pelicula o cación en GB o MB
  
  //-------------------------------------------------------------------------
  //Atributos a iniciar por heredar de "modeloDAO".
  //-------------------------------------------------------------------------
  protected $nombreTabla= 'articulos';
  protected $campoClave= array( 'referencia'=>null);
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
  protected function datosTabla( $insertar)
  {
    $datos= array(
      'referencia'=>$this->referencia,
      'texto'     =>$this->texto,
      'precio'    =>str_replace( ',', '.', $this->precio),//asegurar numero en "sql-ingles"
      'iva'       =>str_replace( ',', '.', $this->iva),//asegurar numero en "sql-ingles"
      'notas'     =>$this->notas,
	  'tipo'      =>$this->tipo,
	  'titulo'    =>$this->titulo,
	  'ISBN'    =>$this->ISBN,
	  'duracion'    =>$this->duracion,
	  'paginas'    =>$this->paginas,
	  'tamaño'    =>$this->tamaño,
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
    if (empty($orden)) $orden= 'referencia ASC';
    //----------
    $sql= 'SELECT * FROM articulos ORDER BY '.$orden;
    return $sql;
  }//sqlListar
  
  
  public static function sqlRecursos($tipo)
  {
    //----------
    $sql= 'SELECT * FROM articulos where tipo="'.$tipo.'" order by referencia DESC';
    return $sql;
  }
  
  public static function sqlTipos()
  {
    //----------
    $sql= 'SELECT DISTINCT tipo FROM articulos where tipo!=""';
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