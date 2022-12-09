<?php
return array(
  //array(rol, controlador, accion, permitir),
  //array('Invitado', 'inicio', 'inicio', true),
  
  //array('Invitado', 'inicio', 'logout', false),
  //array('Invitado', 'inicio', '*', true),
  
  //Permitir acceso al catalogo a todo el mundo.
  //array('*', 'catalogo', '*', true),
  
  //array('Cliente', 'catalogo', '*', true),
  //array('Cliente', 'pedidos', '*', true),
	
  
  //Si no se encuentra coincidencia, PERMITIR TODO al Administrador
  //array('Administrador', '*', '*', true),
  
  //Si no se encuentra coincidencia, PROHIBIR TODO al TODOS
  //array('*', '*', '*', false),
  //Si no se encuentra coincidencia, PERMITIR TODO al TODOS
  //array('*', '*', '*', true),
  
  array('Invitado', 'inicio', 'inicio', true),
  array('Invitado', 'inicio', 'logout', true),
  array('Usuario', 'inicio', 'logout', true),
  array('Usuario', 'inicio', 'inicio', true),
  array('Invitado', 'inicio', 'login', true),
  array('Invitado', 'catalogo', '*', true),
  array('Invitado', 'recursos', '*', true),
  array('Usuario', 'catalogo', '*', true),
  array('Usuario', 'recursos', '*', true),
  array('Editor', 'catalogo', '*', true),
  array('Editor', 'recursos', '*', true),
  array('Editor', 'inicio', 'inicio', true),
  array('Editor', 'inicio', 'logout', true),
  array('Editor', 'articulos', '*', true),
  array('Cliente', 'inicio', '*', true),
  array('Cliente', 'recursos', '*', true),
  array('Administrador', '*', '*', true),
 
  
);