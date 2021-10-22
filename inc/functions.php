<?php 
/**
 * Author: @luichidev
 * Web: https://luisalbertoarana.com
 * Creation: 19/10/2021
 * Revision: 19/10/2021
 */

//PROTOTYPE: Array csvToArray(Resource $file)
//DESCRIPTION: Recibe un documento .CSV y devuelve un array asociativo
function csvToArray($file){
  $csv = array_map('str_getcsv', file($file));

  array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
  });

  array_shift($csv); # remove column header

  return $csv;
}

//PROTOTYPE: Array dump_var(Array $array)
//DESCRIPTION: Recibe un array y lo imprime formateado.
function dump_var($array){
  echo "<pre>";
  var_dump($array);
  echo "</pre>";
}

//PROTOTYPE: Array getData(Array $array)
//DESCRIPTION: Recibe un array de datos y otro array con 
//            los campos que se quiere extraer del primer array.
function getData($data, $columns){
  $res = [];

  if(empty($columns)) return $data;
  else {
    foreach ($data as $key => $value) {
      foreach ($columns as $val) {
        if(isset($value[$val]))
          $aux[$val] = $value[$val];
      }
      $res[] = $aux;
    }
  }

  return $res;
}

//PROTOTYPE: String listDir(Array $array)
//DESCRIPTION: lista los archivos de resources
function listDir(){
  $ruta = "resources";
  $res = "";
  if (is_dir($ruta)){
    $gestor = opendir($ruta);
    $res .= "<ul>";

    while (($archivo = readdir($gestor)) !== false){
      $ruta_completa = $ruta . "/" . $archivo;
      if ($archivo !== "." && $archivo !== "..") {
        if (is_file($ruta_completa)) 
          $res .= "<li>{$archivo}</li>";
      }
    }
    closedir($gestor);
    $res .= "</ul>";
  } 
  return $res;
}

//PROTOTYPE: String form(String $type, String $action)
//DESCRIPTION: Devuelve un formulario con type enviado y la acción requerida
//             1 usuarios, 2 páginas visitas, 3 Últimas url vistadas, 4 Url más visitadas.
function form($type, $action){
  $res = "";
  $sessionName = "{$type}FileName";
  $sessionMsq = "{$type}_msg";
  if(empty($_SESSION[$sessionName])){ 
    $res .= "<form action=\"{$_SERVER["PHP_SELF"]}\" method=\"POST\" enctype=\"multipart/form-data\">".PHP_EOL.
            "<div class=\"input-file-container\">
              <input class=\"input-file\" id=\"{$type}\" type=\"file\" name=\"{$type}_upload\">
              <label tabindex=\"0\" for=\"{$type}\" class=\"input-file-trigger\">Subir archivo <span>☁️</span></label>
            </div>".PHP_EOL.
            "<p class=\"file-return\" id=\"return_{$type}\"></p>".PHP_EOL.
          "<button class=\"btn success\" name=\"btn_{$type}\" aria-label=\"Archivo\">Subir</button>".PHP_EOL.
          (!empty($_SESSION[$sessionMsq])? $_SESSION[$sessionMsq] : "") .
        "</form>";
  } else { 
    $res .= !empty($_SESSION[$sessionMsq])? $_SESSION[$sessionMsq] : "" ;
    $res .= "<p>Registrar el archivo en la Base de datos <a class=\"btn success\" href=\"{$_SERVER['SCRIPT_NAME']}?rg={$action}\">Registrar</a>".PHP_EOL;
    $res .= "</p>";
    unset($_SESSION[$sessionMsq]);
  } 

  return $res;
}