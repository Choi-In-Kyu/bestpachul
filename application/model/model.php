<?php
  Class Model
  {
    public $db;
    public $param;
    public $sql;
    public function __construct($param)
    {
      $this->param = $param;
      //올바른 로그인인지 체크
      if(!isset ($_POST['ajax'])){$this->check_login();}
      //데이터베이스 설정
      $this->db = new PDO("mysql:host=" . _SERVERNAME . ";dbname=" . _DBNAME . "", _DBUSER, _DBPW);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->db->exec("set names utf8");
      if (isset($_POST['action'])) $this->action();//post 로 받은 action 값이 있으면 action() 함수 실행
    }
    public function check_login(){
      if (in_array($this->param->page_type, ['company', 'employee', 'call', 'manage'])) {
        if (isset($_COOKIE['userID'])) {
          if ($_COOKIE['userID'] == 1) {
          } else {
            alert('접근 권한이 없습니다.');
            move(_URL . 'ceo');
          }
        } else {
          alert('로그인이 필요한 서비스입니다.');
          move(_URL . 'login');
        }
      }
      elseif(in_array($this->param->page_type, ['ceo'])) {
        if (isset($_COOKIE['userID'])) {
          if ($_COOKIE['userID'] == 1) {
//            alert('관리자페이지로 이동합니다.');
//            move(_URL . 'company');
          }
        } else {
          alert('로그인이 필요한 서비스입니다.');
          move(_URL . 'login');
        }
      }
      elseif ($this->param->page_type == 'login'){}
      else{
        alert("잘못된 페이지 접근입니다.");
        move(_URL . 'login');
      }
    }
    public function query($sql)
    {
      $this->sql = $sql;
      $res = $this->db->prepare($this->sql);
      if ($res->execute()) {
        return $res;
      } else {
        echo "<pre>";
        echo $this->sql;
        echo "</pre>";
      }
    }
    public function fetch(){return $this->query($this->sql)->fetch();}
    public function executeSQL($string){$this->sql = $string;$this->fetch();}
    public function fetchAll(){return $this->query($this->sql)->fetchAll();}
    public function getTable($sql){$this->sql = $sql;return $this->fetchAll();}
    public function count(){return $this->query($this->sql)->rowCount();}
    public function getList($conditionArray = null, $order = null)
    {
      $this->sql = "SELECT * FROM {$this->param->page_type}";
      if (isset($conditionArray)) $getCondition = " WHERE " . implode(" AND ", $conditionArray);
      else $getCondition = " WHERE deleted = 0";
      $this->sql .= $getCondition;
      if (isset($order) && $order != "") $this->sql .= " ORDER BY {$order}";
      return $this->fetchAll();
    }
    public function getListNum($conditionArray = null){return sizeof($this->getList($conditionArray));}
    public function getColumnList($array, $column)
    {
      foreach ($array as $key => $value) {
        $result[] = $value[$column];
      }
      if (isset($result)) return $result;
      else return null;
    }
    public function removeDuplicate($post, $table, $column)
    {
      $result = $post["{$table}-{$column}"];
      $columnList = $this->getColumnList($this->getList(), $column);
      while (in_array($result, $columnList)) {
        $result .= "(중복됨)";
        continue;
      }
      return $result;
    }
    public function extractPost($post, $table)
    {
      $tblArray = array();
      foreach ($post as $key => $value) {
        if (isset($value)) {
          $arr = explode("-", $key);
          if ($table == $arr[0]) $tblArray[$table][] = "{$arr[1]} = '{$value}' ";
        }
      }
      return $tblArray;
    }
    public function getQuery($post, $table, $focus = null)
    {
      $tbl = $this->extractPost($post, $table);
      if (isset($table)) {
        switch ($post['action']) {
          case 'insert':
            $sql = "INSERT INTO ";
            break;
          case 'update':
            $sql = "UPDATE ";
            break;
          case 'new_insert':
            $sql = "INSERT INTO ";
            break;
          default :
            $sql = "INSERT INTO ";
            break;
        }
        $sql .= "{$table} SET ";
        $sql .= implode(",", $tbl[$table]);
        if ($post['action'] == 'update' or $post['action'] == 'delete') {
          if (!isset($focus)) $sql .= " WHERE {$table}.{$table}ID = '{$post[$table.'-'.$table.'ID']}' LIMIT 1";
          if (isset($focus)) $sql .= " WHERE {$table}.{$focus}ID = '{$post[$focus.'-'.$focus.'ID']}' LIMIT 1";
        }
        $this->sql = $sql;
        $this->fetch();
      }
    }
    public function select($table, $condition = null, $column = null, $order = null)
    {
      $sql = "SELECT * FROM `{$table}` ";
      if (isset($condition)) $sql .= "WHERE $condition ";
      if (isset($order)) $sql .= "ORDER BY '{$order}' ASC ";
      if (isset($column)) return $this->getTable($sql)[0][$column];
      else return $this->getTable($sql);
    }
    public function delete($post, $table)
    {
      $d = _TODAY;
      //업체, 인력 삭제
      if (!isset ($post['joinID'])) {
        //main table delete
        $string = "UPDATE {$table} SET deleted=1, activated=0, deletedDate= '{$d}', deleteDetail = '{$post['deleteDetail']}' WHERE {$table}ID = '{$post['deleteID']}'";
        $this->executeSQL($string);
        //join table delete
        $string2 = "UPDATE join_{$table} SET deleted=1, activated=0, deletedDate= '{$d}', deleteDetail = '업체삭제({$d})' WHERE {$table}ID = '{$post['deleteID']}' AND activated=1";
        $this->executeSQL($string2);
      }
      //가입 삭제
      else $this->executeSQL("UPDATE join_{$table} SET deleted=1, activated=0, deletedDate= '{$d}', deleteDetail = '{$post['deleteDetail']}' WHERE join_{$table}ID = '{$post['joinID']}'");
    }
    public function isHoliday($date)
    {
      if (in_array(date('w',strtotime($date)), [0,6])) {return true;}
      elseif(sizeof($this->getTable("SELECT * FROM `holiday` where holiday = '{$date}'"))>0) {return true;}
      else {return false;}
    }
    public function joinType($companyID)
    {
      $gujwaTable   = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$companyID} AND activated =1 AND price >0 AND  `point` IS NULL ");
      $pointTable   = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$companyID} AND activated =1 AND price >0 AND  `point` IS NOT NULL ");
      $depositTable = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$companyID} AND activated =1 AND deposit >0");
      if (sizeof($gujwaTable) > 0) return 'gujwa';
      elseif (sizeof($pointTable) > 0) return 'point';
      elseif (sizeof($depositTable) > 0) return 'deposit';
      else return 'deactivated';
    }
    public function insert($table, $post, $id=null)
    {
      if (isset($post['action'])) array_shift($post);
      foreach ($post as $item){$column[] = "`".$item."`";}
      foreach ($post as $value){$value[]= "'".$value."'";}
      $columnString =  implode(',', $column);
      $valueString = implode(',', $value);
      $sql = "INSERT INTO `{$table}` ({$columnString}) VALUES ($valueString)";
      alert($sql);
      $this->executeSQL($sql);
    }
    public function call($post){
      alert(json_encode($post));
    }
    public function call_gujwa($post)
    {
      if ($this->isHoliday($post['workDate'])) {$point = 10000;
      } else {$point = 8000;}
      $nowgujwa = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$this->companyID} AND activated =1 AND price >0 AND  `point` IS NULL AND endDate > '{$post['workDate']}'");
      if (sizeof($nowgujwa) > 0) {
        if ($this->thisweekPoint($post['workDate']) + $point <= 26000 * sizeof($this->gujwaTable)) {
          $this->call($post);
        }
        else {
          alert("이번주 콜 수가 초과되었습니다.");
          $_POST['action'] = 'paidCall';
        }
      }
      else{
        alert('가입만기일 이후의 콜입니다.');
        unset($post);
        move('ceo');
      }
    }
    public function call_point($post)
    {
      if($this->isHoliday($post['workDate'])){$point = 8;}
      else{$point = 6;}
      $myPoint = $this->getTable("SELECT point FROM join_company WHERE companyID = '{$this->companyID}'")[0]['point'];
      if($point>$myPoint){
        alert(($point-$myPoint).' 포인트가 부족합니다.');
        unset($post);
        move('ceo');
      }
      else{
        $post['point']=$point;
        $this->executeSQL("UPDATE join_company SET point = point-'{$point}' WHERE companyID = '{$this->companyID}' LIMIT 1");
        $this->call($post);
      }
    }
    public function call_deposit($post){
      if($this->isHoliday($post['workDate'])){$price = 8000;}
      else{$price = 6000;}
      $post['price'] = $price;
      $this->call($post);
    }
    public function callCancel($post){
      $this->executeSQL("UPDATE `call` SET employeeID = 0, `cancelled`=1, `cancelDetail`='{$post['detail']}' WHERE `callID` = {$post['callID']} LIMIT 1");
    }
    public function fixCancel($post){
      alert('test');
      $this->executeSQL("UPDATE `fix` SET employeeID = '0', `cancelled`='1', `cancelDetail`='{$post['detail']}' WHERE `fixID` = '{$post['fixID']}' LIMIT 1");
      $this->executeSQL("UPDATE `call` SET employeeID = '0', `cancelled`='1', `cancelDetail`='{$post['detail']}' WHERE `fixID`='{$post['fixID']}' AND `workDate` >= '{$post['date']}'");
    }
  }