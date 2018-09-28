<?php
Class Model
{
//변수
  var $db;
  var $column;
  var $table;
  var $param;
  var $action;
  var $sql;
  //커스텀 변수
  var $tableArr;
  var $tableName;

//생성자
  function __construct($param)
  {
    $servername = "localhost";
    $dbname = "informationsys";
    $username = "informationsys";
    $password = "ingee440";

    $this->column = NULL;
    $this->param = $param;
    $this->db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $this->db->exec("set names utf8");

    if (isset($_POST['action'])) {
      $this->action = $_POST['action'];
      $this->action();
    }
  }

//PDO
  function query($sql)
  {
    $sql && $this->sql = $sql;
    $res = $this->db->prepare($this->sql);
    if ($res->execute($this->column)) {
      return $res;
    } else {
      echo "<pre>";
      echo $this->sql;
      print_r($this->column);
      print_r($this->db->errorInfo());
      echo "</pre>";
    }
  }
  function fetch(){return $this->query($this->sql)->fetch();}
  function fetchAll(){return $this->query($this->sql)->fetchAll();}
  function cnt(){return $this->query($this->sql)->rowCount();}

  //커스텀 함수
  function getList($condition = null, $order = null){
    $this->sql = "SELECT * FROM {$this->tableName}";
    if (isset($condition)) {
      $this->sql .= $condition;
    }
    if (isset($order) && $order != "") {$this->sql .= " ORDER BY {$order}";}
    return $this->fetchAll();}

  function getListNum($condition=null){
    $this->sql = "SELECT * FROM {$this->tableName} ";
    if (isset($condition)) {$this->sql .= $condition;}
    return $this->cnt();}

  function getTable($sql){$this->sql = $sql;return $this->fetchAll();}
  function getColumnList($array,$column){
    foreach ($array as $key=>$value){
      $result[] = $value[$column];
    }
    if(isset($result)){
      return $result;
    }
    else return null;
  }

  function myInsert($post)
  {
    $table = array();
    foreach ($post as $key => $value) {
      if (!in_array($key, ['action', 'table', 'idx'])) {
        $arr = explode("-", $key);
        $table[$arr[0]][] = "{$arr[1]} = '{$value}' ";
      }
    }
    $sql = array();
    foreach ($table as $k => $v) {
      $sql[$k] = "INSERT INTO {$k} SET ".implode(',',$v);
    }
    foreach ($sql as $k2=>$v2){
      $this->sql = $v2;
      $this->fetch();
    }
  }
  
  function myDelete($tableName, $id){
    $this->sql = "UPDATE `{$tableName}` SET deleted = 1, activated = 0  WHERE `{$tableName}`.{$tableName}ID = {$id} LIMIT 1";
    $this->fetch();
  }
}

?>