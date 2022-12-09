<?php
aplicacion::$modoPublico= true;
modelo::usar( 'articulo');
modelo::usar( 'Cesta');

class controlador_catalogo extends controlador
{
  public $accion_defecto= 'ver';
  
  //-------------------------------------------------------------------------
  //Accion para VER catalogo de articulos
  public function accion_ver()
  {
    //----------
    //Extraer Datos para ejecucion con la pagina que se está viendo.
    $pagina= (isset($_GET['p']) ? (int)$_GET['p'] : 0);
    if ($pagina < 1) $pagina= 1;//se empieza en la primera pagina como mucho.
    $lineas= config::get('catalogo.lineas', 12);
    if ($lineas < 1) $lineas= 1;//como minimo se obtiene 1 elemento por pagina.
    //----------
    //Ejecutar accion
    $sql= articulo::sqlListar();
    $total= basedatos::contar( $sql);
    $registros= basedatos::obtenerTodos( $sql, $pagina-1, $lineas);
    //----------
    //Dar una respuesta
    //vista::$plantilla= 'publica.php';
    vista::generarPagina( 'catalogo', array( 
      'pagina'=>$pagina,
      'lineas'=>$lineas,
      'total'=>$total,
      'registros'=>$registros,
    ));
  }//accion_ver
  
  //-------------------------------------------------------------------------
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
    vista::redirigir( '', array('a'=>'catalogo.ver','p'=>$pagina));
  }//accion_add
  
}//class controlador_catalogo
