<?php 
include_once("model/Table.php");

function register_lastVisited(){
	$fileDir  = "resources/";
	$file = $fileDir . "Last visited content-B1005898R31161J4336251-20210101-20211231.csv";
	Table::format($file);
	return Table::insertLastVisits($file, "lastvisits"); 
}

$res = register_lastVisited();
echo $res
			? "Se ha registrado correctamente!"
			: "No hay registros nuevos";