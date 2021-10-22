<?php 
include_once("library/mysqluis.php");

class Table {
  protected static $db;

  private static function connect(){
    include_once("config.php");
    self::$db = new mysqluis(DBHOST, DBUSER, DBPASS, DBNAME);
  }

  private static function close(){
    self::$db->close();
  }

  private static function csv_to_array($file){
    $csv = array_map('str_getcsv', file($file));
    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($csv[0], $a);
    });
    array_shift($csv); # remove column header
    return $csv;
  }
  
  private static function get_custom_data($data, $columns){
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

  private static function choose_columns($file, $columns){
    $data = self::csv_to_array($file);
    return self::get_custom_data($data, $columns);
  }

  private static function merge(&$data, $aux){
    foreach ($data as $key => $value) {
      foreach ($aux as $i => $val) {
        if($value['ID'] === "{$i}")
          foreach ($val as $j => $v) {
            $data[$key][$j]= $v;
          }
      }
    }
  }

  static function insertUsers($file, $table, $columns=[]){
    self::connect();
    $data = self::choose_columns($file, $columns);
    foreach ($data as $key => $value) {
      $row['use_userid'] = $value['ID '];
      $row['use_email'] = $value[' Email  '];
      $row['use_onekeycode'] = $value['OneKeyCode'];
      $res = self::$db->insert($table, $row);
    }

    self::close();
    return $res;
  }

  static function insertVisits($file, $table, $columns=[]){
    self::connect();
    //eliminamos los datos antiguos
    self::$db->delete($table);
    
    $data = self::choose_columns($file, $columns);
    foreach ($data as $key => $value) {
      $row['vis_userid'] = $value['User ID_CLAS'];
      $row['vis_nvisits'] = $value['Visits'];
      $res = self::$db->insert($table, $row);
    }

    self::close();
    return $res;
  }

  static function insertLastVisits($file, $table, $columns=[]){
    self::connect();
    //eliminamos los datos antiguos
    self::$db->delete($table);

    $data = self::choose_columns($file, $columns);
    foreach ($data as $key => $value) {
      $row['las_userid'] = $value['User ID_CLAS'];
      $row['las_url'] = $value['Web Analytics Page Path'];
      $row['las_day'] = date($value['Day']);
      $res = self::$db->insert($table, $row);
    }

    self::close();
    return $res;
  }

  static function insertMostVisits($file, $table, $columns=[]){
    self::connect();
    //eliminamos los datos antiguos
    self::$db->delete($table);

    $data = self::choose_columns($file, $columns);
    foreach ($data as $key => $value) {
      $row['mos_userid'] = $value['User ID_CLAS'];
      $row['mos_url'] = $value['Web Analytics Page Path'];
      $row['mos_pageviews'] = $value['Page Views'];
      $res = self::$db->insert($table, $row);
    }

    self::close();
    return $res;
  }

  static function array_to_csv(){
    self::connect();
    $sql = "SELECT use_userid AS ID, use_email AS Email, v.vis_nvisits AS 'Nro de visitas' FROM users JOIN visits AS v ON users.use_userid=v.vis_userid ORDER BY use_userid";
    $data = self::$db->raw($sql);
    $aux = [];

    foreach ($data as $key => $value) {
      $sql_temp = "SELECT las_day AS day, las_url AS 'Ultima url visitada' FROM lastvisits WHERE las_userid={$value['ID']} ORDER BY las_day DESC limit 1";
      $temp = self::$db->raw($sql_temp);
      foreach ($temp as $k => $val) {
        $aux[$value['ID']] = $val;
      }
    }
    self::merge($data, $aux);
    unset($aux);
    
    foreach ($data as $key => $value) {
      $sql_temp = "SELECT mos_url AS 'Url mas visitada', mos_pageviews AS 'Nro de visitas Url mas visitada' FROM mostvisited WHERE mos_userid={$value['ID']} ORDER BY mos_pageviews DESC limit 1;";
      $temp = self::$db->raw($sql_temp);
      foreach ($temp as $k => $val) {
        $aux[$value['ID']] = $val;
      }
    }
    self::merge($data, $aux);  
    $fp = fopen('public/analitics.csv', 'a');
  
    //creamos el encabezado
    foreach ($data[0] as $key => $value) {
      $head[] = $key;
    }
    fputcsv($fp, $head);
    
    //creamos el cuerpo
    foreach ($data as $value) {
      fputcsv($fp, $value);
    }
    
    fclose($fp);
    self::close();
  }

  static function format($file){
    $enlace =  fopen($file, 'r');
    $line = fgets($enlace);
    
    if(substr($line,0,13) === '"Report Name"'){
      $array =  file($file);
      $length = count($array);
      $fp = fopen($file, 'w');
      //eliminamos las 6 primeras filas
      for ($i=6; $i < $length; $i++) { 
        fwrite($fp, $array[$i]);
      }
      fclose($fp);
    }
    fclose($enlace);
  }
  
}