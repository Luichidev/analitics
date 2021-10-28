<?php 
/**
 * Author: Luis Alberto Arana M.
 * twitter: @luichidev
 * Web: https://luisalbertoarana.com
 * Creation: 19/10/2021
 * Revision: 26/10/2021
 */

include_once("model/Table.php");

function register_visits(){
	$fileDir  = "resources/";
	$file = $fileDir . "Number of visits in 12 months-B1005898R31162J4336259-20210101-20211231.csv";
	Table::format($file);
	return Table::insertVisits($file, "visits");
}

$res = register_visits();
echo $res
			? "Se ha registrado correctamente!"
			: "No hay registros nuevos";