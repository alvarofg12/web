<?php
//---------------------------------------------------------------------------
//Vista de Administracion de usuentes...
//---------------------------------------------------------------------------
// Datos que recibe:
//    $registros --> array con los registros de la tabla de usuentes.
//    $total --> número de registros totales de la tabla de usuentes.
//    $pagina --> numero de pagina que se esta obteniendo.
//    $lineas --> numero de lineas visibles por pagina.
//---------------------------------------------------------------------------
/*-----
depurar( array( 
  'id_controlador' => aplicacion::$id_controlador,
  'id_accion' => aplicacion::$id_accion,
  'pagina' => $pagina,
  'lineas' => $lineas,
  'total' => $total,
  'registros' => $registros,
));
//-----*/
?>
<h1>Usuarios</h1>
<div class="hoja">
<table>
<thead>
<tr>
  <th>Id</th>
  <th>Nombre</th>
  <th>Login</th>
  <th>Password</th>
  <th>Perfil</th>
  <th>Ultima fecha</th>
  <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php //Generar los registros obtenidos de usuentes.
$usu= new Users;
foreach($registros as $indice => $registro) {
  $usu->llenar( $registro);
  echo '<tr class="'.(($indice % 2 == 0) ? 'par' : 'impar').'">';
  echo '<td class="cen">'.html::encode( $usu->id).'</td>';
  echo '<td class="cen">'.html::encode( $usu->nombre).'</td>';
  echo '<td class="izq">'.html::encode( $usu->login).'</td>';
  echo '<td class="izq">'.html::encode( $usu->password).'</td>';
  echo '<td class="izq">'.html::encode( $usu->perfil).'</td>';
  echo '<td class="izq">'.html::encode( $usu->ultima_fecha).'</td>';
  echo '<td class="cen">';
  echo '<div class="acciones">';
  //-- echo 'Ver Modificar Eliminar';
  //if (tiene_permiso( 'usuentes.ver')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Ver', 'icono'=>'ver.png',
      'activo'=>false, 'url'=>array('a'=>'usuarios.ver', 'id'=>$usu->id, 'p'=>$pagina)));
  //if (tiene_permiso( 'usuentes.editar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Editar', 'icono'=>'editar.png',
      'activo'=>false, 'url'=>array('a'=>'usuarios.editar', 'id'=>$usu->id, 'p'=>$pagina)));
  //if (tiene_permiso( 'usuentes.borrar')) 
    vista::generarPieza( 'boton_accion', array( 'texto'=>'Borrar', 'icono'=>'borrar.png',
      'activo'=>false, 'url'=>array('a'=>'usuarios.borrar', 'id'=>$usu->id, 'p'=>$pagina)));
  echo '</div>';
  echo '</td>';
  echo '</tr>';
}//foreach
?>
</tbody>
<tfoot>
<tr>
  <td colspan="6">
<?php //Generar el pie de la tabla con la informacion y paginador
vista::generarPieza( 'paginador', array( 'url'=>array('a'=>'usuentes'), 'total'=>$total, 'pagina'=>$pagina, 'lineas'=>$lineas));
?>
  </td>
  <td class="cen">
<?php //Generar el boton para CREAR.
//if (tiene_permiso( 'usuentes.crear')) {
  echo '<div class="acciones">';
  vista::generarPieza( 'boton_accion', array( 'texto'=>'Nuevo', 'icono'=>'crear.png',
    'activo'=>true, 'url'=>array('a'=>'usuarios.crear', 'p'=>$pagina)));
  echo '</div>';
//}//if
?>
  </td>
</tr>
</tfoot>
</table>
</div>