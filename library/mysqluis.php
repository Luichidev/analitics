<?php 
class mysqluis {
  private $dblink;

  function __construct($dbHost, $dbUser, $dbPass, $dbName){
    $this->dblink = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
    mysqli_set_charset($this->dblink, 'utf8mb4');
  }
  /**
   * Funciones privadas
   */
  
  //Si no se conecta devuelve un array vacio.
  private function get_data($sql) {
    $data = [];

    if($this->dblink){
      $resultado = mysqli_query($this->dblink, $sql);
      if(mysqli_num_rows($resultado)){
        while($fila = mysqli_fetch_assoc($resultado)){
          $data[] = $fila;
        }
        mysqli_free_result($resultado);
      }
    } 
    return $data;
  }

  //Si no puede conectarse devuelve false.
  private function send_data($sql) {
    $res = false;

    if($this->dblink){
      $res = mysqli_query($this->dblink, $sql);
    }  
    return $res;
  }

  /**
   * Funciones Públicas
   */
  function close() {
    return mysqli_close($this->dblink);
  }
  
  function get($table, $columns=[]){
    $sql = "SELECT ";
    if(empty($columns)){
      $sql .= " * FROM {$table}";
    } else {
      foreach ($columns as $value) {
        $sql .= " {$value},";
      }
      $sql = substr($sql, 0, -1); // quitamos la última coma
      $sql .= " FROM {$table}";

    }
    return $this->get_data($sql);
  }

  function getOne($col, $id, $table, $columns=[]){
    $sql = "SELECT ";
    $id = is_numeric($id) ? $id : "'{$id}'";
    
    if(empty($columns)){
      $sql .= "* FROM {$table} WHERE {$col}={$id}";
    }else {
      foreach ($columns as $value) {
        $sql .= " {$value},";
      }
      $sql = substr($sql, 0, -1); // quitamos la última coma
      $sql .= " FROM {$table} WHERE {$col}=$id";
    }
    return $this->get_data($sql);
  }

  function deleteOne($col, $id, $tabla){
    $sql = "DELETE from {$tabla} WHERE {$col}={$id}";
    return $this->send_data($sql);
  }

  function delete($tabla){
    $sql = "DELETE from {$tabla}";
    return $this->send_data($sql);
  }

  function insert($tabla, $arrayElements){
    $res = false;
    if(is_array($arrayElements)){
      $sql = "INSERT INTO {$tabla} ";
      $col = " (";
      $val = " (";
      foreach ($arrayElements as $key => $value) {
        $col .= "{$key},";
        $val .= "'{$value}',";
      }
      $col = substr($col, 0, -1); // quitamos la última coma
      $val = substr($val, 0, -1); // quitamos la última coma
      $col .= " ) VALUES ";
      $val .= " )";
      $sql .= $col . $val;
      $res = $this->send_data($sql);
      // $res = $sql;
    } 
    return $res;
  }

  function update($tabla, $arrayElements, $colUpdate){
    $res = false;
    $id = 0;
    if(is_array($arrayElements)){
      $sql = "UPDATE {$tabla} SET ";
      foreach ($arrayElements as $key => $value) {
        if($key === $colUpdate)
          $id = $value;

        $sql .= "{$key}='{$value}',";
      }
      $sql = substr($sql, 0, -1); // quitamos la última coma
      if(is_numeric($id)) $sql .= " WHERE {$colUpdate}={$id}";
      else $sql .= " WHERE {$colUpdate}='{$id}'";
      if($id){
        $res = $this->send_data($sql);
      }
    } 
    return $res;
  }

  function raw($sql){
    $res = [];
    
    if(!empty($sql))
      $res = $this->get_data($sql);
    
    return $res;
  }
}

?>