<?php 
include_once("model/Table.php");

function register_users(){
	$fileDir  = "resources/";
	$file = $fileDir . "Wordpress_Registro usuarios.csv";
	Table::format($file);
	return Table::insertUsers($file, "users", [' Dia de login OWA ', 'ID ', ' Email  ', 'OneKeyCode']); 
}

$res = register_users();
echo $res
			? "Se ha registrado los usuarios en la base de datos"
			: "No hay usuarios nuevos";