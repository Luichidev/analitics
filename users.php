<?php 
/**
 * Author: Luis Alberto Arana M.
 * twitter: @luichidev
 * Web: https://luisalbertoarana.com
 * Creation: 19/10/2021
 * Revision: 26/10/2021
 */

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