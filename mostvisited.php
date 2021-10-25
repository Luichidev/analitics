<?php 
include_once("model/Table.php");

function register_mostVisited(){
	$fileDir  = "resources/";
	$file = $fileDir . "Most visited content in 12 months-B1005898R31163J4336268-20210101-20211231.csv";
	Table::format($file);
	return Table::insertMostVisits($file, "mostvisited"); 
}

$res = register_mostVisited();
echo $res
			? "Se ha registrado correctamente!"
			: "No hay registros nuevos";