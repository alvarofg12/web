<?php
aplicacion::$modoPublico= true;
modelo::usar( 'articulo');
modelo::usar( 'Cesta');

class controlador_recursos extends controlador
{
  public $accion_defecto= 'inicio';
  
  //-------------------------------------------------------------------------
  //Accion para ADMINISTRAR/LISTAR articulos
  
  public function accion_inicio()
  {
    //----------
    //Extraer Datos para ejecucion con la pagina que se está viendo.
    $pagina= (isset($_GET['p']) ? (int)$_GET['p'] : 0);
    if ($pagina < 1) $pagina= 1;//se empieza en la primera pagina como mucho.
    $lineas= config::get('pagina.lineas', 10);
    if ($lineas < 1) $lineas= 1;//como minimo se obtiene 1 elemento por pagina.
    //----------
    //Ejecutar accion
    $sql= articulo::sqlTipos();
    $total= basedatos::contar( $sql);
    $registros= basedatos::obtenerTodos( $sql, $pagina-1, $lineas);
	//var_dump($registros);
	$tipos=[];

    foreach($registros as $registro){
		$nombreTipo=$registro['tipo'];
		$sql2= articulo::sqlRecursos($nombreTipo);
		$articulos= basedatos::obtenerTodos($sql2,$pagina-1,5);
		$tipos[$nombreTipo]=$articulos;
			
	}
	
	//var_dump($tipos);

        
	//----------
    //Dar una respuesta
    vista::generarPagina( 'vRecursos', array( 
      'pagina'=>$pagina,
      'lineas'=>$lineas,
      'total'=>$total,
      'tipos'=>$tipos,
    )); 
  }//accion_admin
  
  public function accion_add()
  {
    //----------
    //Extraer Datos para ejecucion con la pagina que se está viendo.
    $pagina= (isset($_GET['p']) ? (int)$_GET['p'] : 0);
    if ($pagina < 1) $pagina= 1;//se empieza en la primera pagina como mucho.
    
    $id= (isset($_GET['ref']) ? $_GET['ref'] : null);
    
    //Cargar la cesta, agregar el articulo en 1 unidad 
    //y vuelta a la sesion.
    /*
    $cesta= sesion::get( 'cesta', null);
    if (!($cesta instanceof Cesta)) {
      $cesta= new Cesta();
    }//if
    $cesta->poner( $id);
    sesion::set( 'cesta', $cesta);
    */
    $cesta= Cesta::instancia_de_sesion();
    //--$cesta= new Cesta(); $cesta->cargar_de_sesion();
    $cesta->poner( $id);
    $cesta->guardar_en_sesion();
    
    //Dar una respuesta
	//var_dump($cesta);
    vista::redirigir( '', array('a'=>'recursos.inicio','p'=>$pagina));
  }//accion_add
  
  
  public function accion_verTipo()
  {
	 $nombreTipo= (isset($_GET['tipo']) ? $_GET['tipo'] : "");
    //----------
    //Extraer Datos para ejecucion con la pagina que se está viendo.
    $pagina= (isset($_GET['p']) ? (int)$_GET['p'] : 0);
    if ($pagina < 1) $pagina= 1;//se empieza en la primera pagina como mucho.
    $lineas= config::get('pagina.lineas', 10);
    if ($lineas < 1) $lineas= 1;//como minimo se obtiene 1 elemento por pagina.
    //----------
    //Ejecutar accion
   
	$tipos=[];


		$sql2= articulo::sqlRecursos($nombreTipo);
		$articulos= basedatos::obtenerTodos($sql2,$pagina-1,50);
		$tipos[$nombreTipo]=$articulos;
		
		$total= basedatos::contar($sql2);
	
	

        
	//----------
    //Dar una respuesta
    vista::generarPagina( 'vRecursos', array( 
      'pagina'=>$pagina,
      'lineas'=>$lineas,
      'total'=>$total,
      'tipos'=>$tipos,
    )); 
  }//accion_admin
  
  
   public function accion_verDetalle()
  {
    $bien= false;
    $error= '';
    $modelo= null;
    //----------
    $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
    //----------
    //Coger el dato clave para cargar el modelo a editar...
    $id= (isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null));
    if ($id === null) {
      $error= 'No se ha indicado el articulo a consultar.';
    } else {
      $modelo= new articulo;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el articulo ('.$id.') para consultar.';
        $modelo= null;
      }//if
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    vista::generarPagina( 'verDetalle', array(
      'modelo'=>$modelo,
      'error'=>$error,
      'pagina'=>$pagina,
    ));
	
	
  }
  

  //Accion para CONSULTAR un articulo
  /*public function accion_ver()
  {
    $bien= false;
    $error= '';
    $modelo= null;
    //----------
    $pagina= (int)(isset($_GET['p']) ? $_GET['p'] : 0);//coger la pagina para poder volver
    //----------
    //Coger el dato clave para cargar el modelo a editar...
    $id= (isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null));
    if ($id === null) {
      $error= 'No se ha indicado el articulo a consultar.';
    } else {
      $modelo= new articulo;
      if (!$modelo->cargar( $id)) {
        $error= 'No se puede cargar el articulo ('.$id.') para consultar.';
        $modelo= null;
      }//if
    }//if
    //----------
    //Dar una respuesta segun el resultado del proceso.
    vista::generarPagina( 'ver', array(
      'modelo'=>$modelo,
      'error'=>$error,
      'pagina'=>$pagina,
    ));
  }//accion_ver*/

}//class controlador_articulos
