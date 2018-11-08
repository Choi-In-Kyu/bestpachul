<?php
  
  Class Model
  {
    var $db;
    var $column;
    var $table;
    var $param;
    var $action;
    var $sql;
    var $tableArr;
    var $tableName;
    
    //생성자
    function __construct($param)
    {
      $this->column = NULL;
      $this->param = $param;
      $this->db = new PDO("mysql:host=" . _SERVERNAME . ";dbname=" . _DBNAME . "", _DBUSER, _DBPW);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->db->exec("set names utf8");
      //post로 받은 action에 따른 동작 실행
      if (isset($_POST['action'])) {
        $this->action = $_POST['action'];
        $this->action();
      }
    }
    
    //SQL 함수
    function query($sql)
    {
      $sql && $this->sql = $sql;
      $res = $this->db->prepare($this->sql);
      if ($res->execute($this->column)) {
        return $res;
      } else {
        echo "<pre>";
        echo $this->sql;
        echo "</pre>";
      }
    }
    
    function fetch(){return $this->query($this->sql)->fetch();}
    function executeSQL($string){$this->sql = $string;$this->fetch();}
    function fetchAll(){return $this->query($this->sql)->fetchAll();}
    function getTable($sql){$this->sql = $sql;return $this->fetchAll();}
    function count(){return $this->query($this->sql)->rowCount();}
    
    function getList($conditionArray = null, $order = null)
    {
      $this->sql = "SELECT * FROM {$this->tableName}";
      if (isset($conditionArray)) $getCondition = " WHERE " . implode(" AND ", $conditionArray);
      else $getCondition = " WHERE deleted = 0";
      $this->sql .= $getCondition;
      if (isset($order) && $order != "") $this->sql .= " ORDER BY {$order}";
      return $this->fetchAll();
    }
    
    function getListNum($conditionArray = null)
    {
      $this->sql = "SELECT * FROM {$this->tableName}";
      if (isset($conditionArray)) $this->sql .= " WHERE " . implode(" AND ", $conditionArray);
      return $this->count();
    }
    
    function getColumnList($array, $column)
    {
      foreach ($array as $key => $value) {
        $result[] = $value[$column];
      }
      if (isset($result)) return $result;
      else return null;
    }
    
    function getLastValue($table, $column)
    {
      $sql = "SELECT `{$column}` FROM `{$table}` ORDER BY `createdTime` DESC LIMIT 1";
      $table = $this->getTable($sql);
      return intval($table[0][$column]);
    }
    
    function extractPost($post, $tableName)
    {
      $table = array();
      foreach ($post as $key => $value) {
        if (isset($value)) {
          $arr = explode("-", $key);
          if ($tableName == $arr[0]) $table[$tableName][] = "{$arr[1]} = '{$value}' ";
        }
      }
      return $table;
    }
    
    function getQuery($post, $tableName, $focus = null)
    {
      $table = $this->extractPost($post, $tableName);
      if ((isset($table[$tableName])) && ($table[$tableName] != "")) {
        switch ($post['action']) {
          case 'insert':$sql = "INSERT INTO ";break;
          case 'update':$sql = "UPDATE ";break;
          case 'new_insert':$sql = "INSERT INTO ";break;
          case 'delete':$sql = "UPDATE ";break;
          default :$sql = "INSERT INTO ";break;
        }
        $sql .= "{$tableName} SET ";
        $sql .= implode(",", $table[$tableName]);
        if ($post['action'] == 'update' or $post['action'] == 'delete') {
          if (!isset($focus)) $sql .= " WHERE {$tableName}.{$tableName}ID = {$post[$tableName.'-'.$tableName.'ID']} LIMIT 1";
          if (isset($focus)) $sql .= " WHERE {$tableName}.{$focus}ID = {$post[$focus.'-'.$focus.'ID']} LIMIT 1";
        }
        $this->sql = $sql;
        $this->fetch();
      }
    }
    
    function removeDuplicate($post, $table, $column)
    {
      $result = $post["{$table}-{$column}"];
      $columnList = $this->getColumnList($this->getList(), $column);
      while (in_array($result, $columnList)) {$result .= "(중복됨)";continue;}
      return $result;
    }
    
    function select($table, $condition = null, $column = null, $order=null)
    {
      $sql = "SELECT * FROM `{$table}` ";
      if (isset($condition)) $sql .= "WHERE $condition ";
      if(isset($order)) $sql.="ORDER BY '{$order}' ASC ";
      if (isset($column)) return $this->getTable($sql)[0][$column];
      else return $this->getTable($sql);
    }
  }