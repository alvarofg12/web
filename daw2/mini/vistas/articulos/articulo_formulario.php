<?php
//---------------------------------------------------------------------------
//Vista de FICHA de articulo que va embebida dentro de las vistas de 
//CONSULTA o BORRADO.
//---------------------------------------------------------------------------
// Datos que recibe:
//    $modelo --> Instancia con un modelo "Articulo" a visualizar o "null" si
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<tbody onLoad="crearInputs()" class="formulario">
<?php if ($modelo !== null) { ?>
  <tr><th>Ref.</th><td>
    <input type="text" name="articulo[referencia]" id="articulo_referencia" maxlength="10" 
           value="<?php echo html::encode( $modelo->referencia);?>"/>
  </td></tr>
  <tr><th>Descripción</th><td>
    <input type="text" name="articulo[texto]" id="articulo_texto" maxlength="250" 
           value="<?php echo html::encode( $modelo->texto);?>"/>
  </td></tr>
  <tr><th>Precio</th><td>
    <input type="text" name="articulo[precio]" id="articulo_precio" maxlength="8" 
           value="<?php echo sprintf( '%0.2f', $modelo->precio);?>"/>
  </td></tr>
  <tr><th>%IVA</th><td>
    <input type="text" name="articulo[iva]" id="articulo_iva" maxlength="5" 
           value="<?php echo sprintf( '%0.2f', $modelo->iva);?>"/>
  </td></tr>
  <tr><th>Notas</th><td>
	<textarea name="articulo[notas]" id="articulo_notas" maxlength="1000" rows="5" cols="45"><?php echo html::encode( $modelo->notas);?></textarea>
  </td></tr>
  <tr><th>Tipo</th><td>
	<select  onClick="crearInputs()" name="articulo[tipo]" id="articulo_tipo" <?php if($modelo->tipo!="") echo "disabled"?>>
	    <option>Seleccione una opcion</option>
		<option value="libros"<?php if($modelo->tipo=="libros") echo "selected"?>>Libros</option>
		<option value="cuentos"<?php if($modelo->tipo=="cuentos") echo "selected"?>>Cuentos</option>
		<option value="peliculas"<?php if($modelo->tipo=="peliculas") echo "selected"?>>Peliculas</option>
		<option value="juegos"<?php if($modelo->tipo=="juegos") echo "selected"?>>Juegos</option>
		<option value="canciones"<?php if($modelo->tipo=="canciones") echo "selected"?>>Canciones</option>
		<option value="revistas"<?php if($modelo->tipo=="revistas") echo "selected"?>>Revistas</option>
	</select>
  </td></tr>
  <tr><th>Titulo</th><td>
    <input type="text" name="articulo[titulo]" id="articulo_titulo" maxlength="50" 
           value="<?php  echo html::encode( $modelo->titulo);?>"/>
  </td></tr>
  
  <tr><th>ISBN</th><td id="ISBN">
    
  </td></tr>
  
  
  <tr><th>Duracion</th><td id="duracion">
    
  </td></tr>
  
   <tr><th>Paginas</th><td id="paginas">
    
  </td></tr>
    <tr><th>Tamaño</th><td id="tamaño">
    
  </td></tr>
<?php } else { ?>
  <tr><th>Error</th><td><?php echo $error;?></td></tr>
<?php }//if ?>
</tbody>
<script>


function crearInputs(){
	
	var viejo;
	var valor=document.getElementById("articulo_tipo").value;
	
	console.log(valor);
	
	if(valor=="juegos"){
		console.log("Unos jueguicos");
		document.getElementById("tamaño").innerHTML = "<input type='text' name='articulo[tamaño]' id='articulo_tamaño' maxlength='50' value='<?php  echo html::encode( $modelo->tamaño);?>'/>";
		//Los que no se usan
		document.getElementById("ISBN").innerHTML = "<!--<input type='text' name='articulo[ISBN]' id='articulo_isbn' maxlength='50' value='<?php  echo html::encode( $modelo->ISBN);?>'/>-->";
		document.getElementById("paginas").innerHTML = "<!--<input type='text' name='articulo[paginas]' id='articulo_paginas' maxlength='50' value='<?php  echo html::encode( $modelo->paginas);?>'/>-->";
		document.getElementById("duracion").innerHTML = "<!--<input type='text' name='articulo[duracion]' id='articulo_duracion' maxlength='50' value='<?php  echo html::encode( $modelo->duracion);?>'/>-->";
		
	}
	
	if(valor=="libros"){
		console.log("Unos libricos");
		document.getElementById("ISBN").innerHTML = "<input type='text' name='articulo[ISBN]' id='articulo_isbn' maxlength='50' value='<?php  echo html::encode( $modelo->ISBN);?>'/>";
		document.getElementById("paginas").innerHTML = "<input type='text' name='articulo[paginas]' id='articulo_paginas' maxlength='50' value='<?php  echo html::encode( $modelo->paginas);?>'/>";
		//Los que no se usan
		document.getElementById("duracion").innerHTML = "<!--<input type='text' name='articulo[duracion]' id='articulo_duracion' maxlength='50' value='<?php  echo html::encode( $modelo->duracion);?>'/>-->";
		document.getElementById("tamaño").innerHTML = "<!--<input type='text' name='articulo[tamaño]' id='articulo_tamaño' maxlength='50' value='<?php  echo html::encode( $modelo->tamaño);?>'/>-->";
		
	}
	
	
	
	if(valor=="cuentos"){
		console.log("Unos cuenticos");
		//document.getElementById("articulo_isbn").remove();
		//document.getElementById("duracion").remove();
		//document.getElementById("tamaño").remove();
		document.getElementById("paginas").innerHTML = "<input type='text' name='articulo[paginas]' id='articulo_paginas' maxlength='50' value='<?php  echo html::encode( $modelo->paginas);?>'/>";
		//Los que no se usan
		document.getElementById("ISBN").innerHTML = "<!--<input type='text' name='articulo[ISBN]' id='articulo_isbn' maxlength='50' value='<?php  echo html::encode( $modelo->ISBN);?>'/>-->";
		document.getElementById("duracion").innerHTML = "<!--<input type='text' name='articulo[duracion]' id='articulo_duracion' maxlength='50' value='<?php  echo html::encode( $modelo->duracion);?>'/>-->";
		document.getElementById("tamaño").innerHTML = "<!--<input type='text' name='articulo[tamaño]' id='articulo_tamaño' maxlength='50' value='<?php  echo html::encode( $modelo->tamaño);?>'/>-->";
	}
	
	
	if(valor=="peliculas"){
		console.log("Unas peliculicas");
		document.getElementById("duracion").innerHTML = "<input type='text' name='articulo[duracion]' id='articulo_duracion' maxlength='50' value='<?php  echo html::encode( $modelo->duracion);?>'/>";
		document.getElementById("tamaño").innerHTML = "<input type='text' name='articulo[tamaño]' id='articulo_tamaño' maxlength='50' value='<?php  echo html::encode( $modelo->tamaño);?>'/>";
		//Los que no se usan
		document.getElementById("ISBN").innerHTML = "<!--<input type='text' name='articulo[ISBN]' id='articulo_isbn' maxlength='50' value='<?php  echo html::encode( $modelo->ISBN);?>'/>-->";
		document.getElementById("paginas").innerHTML = "<!--<input type='text' name='articulo[paginas]' id='articulo_paginas' maxlength='50' value='<?php  echo html::encode( $modelo->paginas);?>'/>-->";
	}
	
	
	if(valor=="canciones"){
		console.log("Unas cancioncillas");
		document.getElementById("duracion").innerHTML = "<input type='text' name='articulo[duracion]' id='articulo_duracion' maxlength='50' value='<?php  echo html::encode( $modelo->duracion);?>'/>";
		document.getElementById("tamaño").innerHTML = "<input type='text' name='articulo[tamaño]' id='articulo_tamaño' maxlength='50' value='<?php  echo html::encode( $modelo->tamaño);?>'/>";
		//Los que no se usan
		document.getElementById("ISBN").innerHTML = "<!--<input type='text' name='articulo[ISBN]' id='articulo_isbn' maxlength='50' value='<?php  echo html::encode( $modelo->ISBN);?>'/>-->";
		document.getElementById("paginas").innerHTML = "<!--<input type='text' name='articulo[paginas]' id='articulo_paginas' maxlength='50' value='<?php  echo html::encode( $modelo->paginas);?>'/>-->";
		
	}
	
	if(valor=="revistas"){
		console.log("Unas revisticas");
		document.getElementById("paginas").innerHTML = "<input type='text' name='articulo[paginas]' id='articulo_paginas' maxlength='50' value='<?php  echo html::encode( $modelo->paginas);?>'/>";
		//Los que no se usan
		document.getElementById("ISBN").innerHTML = "<!--<input type='text' name='articulo[ISBN]' id='articulo_isbn' maxlength='50' value='<?php  echo html::encode( $modelo->ISBN);?>'/>-->";
		document.getElementById("duracion").innerHTML = "<!--<input type='text' name='articulo[duracion]' id='articulo_duracion' maxlength='50' value='<?php  echo html::encode( $modelo->duracion);?>'/>-->";
		document.getElementById("tamaño").innerHTML = "<!--<input type='text' name='articulo[tamaño]' id='articulo_tamaño' maxlength='50' value='<?php  echo html::encode( $modelo->tamaño);?>'/>-->";
	}
	
	
	
	
}

crearInputs();
</script>