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
    $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $this->db->exec("set names utf8");

    if (isset($_POST['action'])) {
      $this->action = $_POST['action'];
      $this->action();
    }
  }

//query
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

//fetch
  function fetch($sql)
  {
//    $sql && $this->sql = $sql;
    return $this->query($this->sql)->fetch();
  }

//fetchAll
  function fetchAll($sql)
  {
//    $sql && $this->sql = $sql;
    return $this->query($this->sql)->fetchAll();
  }

//cnt
  function cnt($sql)
  {
//    $sql && $this->sql = $sql;
    return $this->query($this->sql)->rowCount();
  }

//column
  function getColumn($arr, $cancel)
  {
    $column = '';
    $cancel = explode("/", $cancel);
    foreach ($arr as $key => $value) {
      if (!in_array($key, $cancel)) {
        //$column .= ", {$key} = :{$key}\n";
        $column .= ", {$key} = '{$value}'\n";
        $this->column[$key] = $value;
      }
    }
    return $column = substr($column, 2);
  }

  function getTable($str)
  {
    $this->sql = $str;
    return $this->fetchAll();
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
      $sql[$k] = "INSERT INTO {$k} SET ";
      $lastValue = end(array_keys($v));
      foreach ($v as $k1 => $v1) {
        if ($k1 == $lastValue) {
          $sql[$k] .= $v1 . ";";
        } else {
          $sql[$k] .= $v1 . ", ";
        }
      }
      substr($sql[$k], 0, -3);
    }
    foreach ($sql as $k2=>$v2){
      $this->sql = $v2;
      $this->fetch($this->sql);
    }
  }

}

?>