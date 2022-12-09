<?php
//---------------------------------------------------------------------------
//Vista de FICHA de articulo que va embebida dentro de las vistas de 
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "articulo" a visualizar o "null" si
//                hubo error de carga.
//    $error  --> Mensaje de error o cadena vacia si no hubo.
//---------------------------------------------------------------------------
/*-----
depurar( array( 
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'modelo' => $modelo,
  'error' => $error,
));
//-----*/
?>
<tbody class="ficha">
<?php if ($modelo !== null) { ?>
  <tr><th>Ref.</th><td><?php echo html::encode( $modelo->referencia);?></td></tr>
  <tr><th>Descripción</th><td><?php echo html::encode( $modelo->texto);?></td></tr>
  <tr><th>Precio</th><td><?php echo sprintf( '%0.2f', $modelo->precio);?></td></tr>
  <tr><th>%IVA</th><td><?php echo sprintf( '%0.2f', $modelo->iva);?></td></tr>
  <tr><th>Notas</th><td><?php echo html::encode( $modelo->notas);?></td></tr>
  <tr><th>Tipo</th><td><?php echo html::encode( $modelo->tipo);?></td></tr>
  <tr><th>Titulo</th><td><?php echo html::encode( $modelo->titulo);?></td></tr>
  <?php if($modelo->ISBN!=""){ echo "<tr><th>ISBN</th><td> ".html::encode( $modelo->ISBN)."</td></tr>";} ?>
   <?php if($modelo->duracion!=""){ echo "<tr><th>Duración</th><td> ".html::encode( $modelo->duracion)."</td></tr>";} ?>
    <?php if($modelo->paginas!=""){ echo "<tr><th>Paginas</th><td> ".html::encode( $modelo->paginas)."</td></tr>";} ?>
	 <?php if($modelo->tamaño!=""){ echo "<tr><th>Tamaño</th><td> ".html::encode( $modelo->tamaño)."</td></tr>";} ?>
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>