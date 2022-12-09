<?php
//---------------------------------------------------------------------------
//Vista de FICHA de cliente que va embebida dentro de las vistas de 
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "Cliente" a visualizar o "null" si
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
<tbody class="formulario">
<?php if ($modelo !== null) { ?>
  <tr><th>Id</th><td>
    <input type="text" name="usuario[id]" id="usuario_id" maxlength="10" 
           value="<?php echo html::encode( $modelo->id);?>" disabled/>
  </td></tr>
  <tr><th>Nombre</th><td>
    <input type="text" name="usuario[nombre]" id="usuario_nombre" maxlength="10" 
           value="<?php echo html::encode( $modelo->nombre);?>"/>
  </td></tr>
  <tr><th>Login</th><td>
    <input type="text" name="usuario[login]" id="usuario_login" maxlength="250" 
           value="<?php echo html::encode( $modelo->login);?>"/>
  </td></tr>
  <tr><th>Password</th><td>
    <input type="text" name="usuario[password]" id="usuario_password" maxlength="250" 
           value="<?php echo html::encode( $modelo->password);?>"/>
  </td></tr>
  <tr><th>Perfil</th><td>
		<select name="usuario[perfil]" id="usuario_perfil">
				<option value="Usuario"<?php if($modelo->perfil=="Usuario") echo "selected"?>>Usuario</option>
				<option value="Editor" <?php if($modelo->perfil=="Editor") echo "selected"?>>Editor</option>
				<option value="Administrador"<?php if($modelo->perfil=="Administrador") echo "selected"?>>Administrador</option>
		</select>
  </td></tr>
  <tr><th>Ultima fecha</th><td>
    <input type="text" name="usuario[ultima_fecha]" id="ultima_fecha" maxlength="250" 
           value="<?php echo html::encode( $modelo->ultima_fecha);?>"/>
  </td></tr>
  
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>