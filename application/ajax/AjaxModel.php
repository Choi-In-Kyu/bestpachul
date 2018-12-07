<?php
  require_once '../config/lib.php';
  require_once '../config/db.php';
  require_once '../model/model.php';
  
  class AjaxModel
  {
    public $param;
    public $db;
    public $sql;
    public $companyID;
    public function __construct($param)
    {
      $this->param = $param;
      $this->db = new PDO("mysql:host=" . _SERVERNAME . ";dbname=" . _DBNAME . "", _DBUSER, _DBPW);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->db->exec("set names utf8");
    }
    public function query($sql)
    {
      $this->sql = $sql;
      $res = $this->db->prepare($this->sql);
      if ($res->execute()) {
        return $res;
      } else {
        echo $this->sql;
      }
    }
    public function fetch()
    {
      return $this->query($this->sql)->fetch();
    }
    public function executeSQL($string)
    {
      $this->sql = $string;
      $this->fetch();
    }
    public function fetchAll()
    {
      return $this->query($this->sql)->fetchAll();
    }
    public function getTable($sql)
    {
      $this->sql = $sql;
      return $this->fetchAll();
    }
    public function count()
    {
      return $this->query($this->sql)->rowCount();
    }
    public function getList($conditionArray = null, $order = null)
    {
      $this->sql = "SELECT * FROM {$this->param->page_type}";
      if (isset($conditionArray)) $getCondition = " WHERE " . implode(" AND ", $conditionArray);
      else $getCondition = " WHERE deleted = 0";
      $this->sql .= $getCondition;
      if (isset($order) && $order != "") $this->sql .= " ORDER BY {$order}";
      return $this->fetchAll();
    }
    public function getListNum($conditionArray = null)
    {
      return sizeof($this->getList($conditionArray));
    }
    public function getColumnList($array, $column)
    {
      foreach ($array as $key => $value) {
        $result[] = $value[$column];
      }
      if (isset($result)) return $result;
      else return null;
    }
    public function select($table, $condition = null, $column = null, $order = null)
    {
      $sql = "SELECT * FROM `{$table}` ";
      if (isset($condition)) $sql .= "WHERE $condition ";
      if (isset($order)) $sql .= "ORDER BY '{$order}' ASC ";
      if (isset($column)) return $this->getTable($sql)[0][$column];
      else return $this->getTable($sql);
    }
    public function insert($table, $post)
    {
      $columns = array();
      $values = array();
      $columnTable =  $this->getTable("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'{$table}'");
      foreach($columnTable as $value){
        foreach ($value as $item){
          $columnList[] = $item;
        }
      }
      foreach ($post as $key=>$value){
        if(!in_array($key,$columnList)){
          unset($post[$key]);
        }
      }
      foreach (array_keys($post) as $item) {
        $columns[] = "`" . $item . "`";
      }
      foreach ($post as $value) {
        $values[] = "'" . $value . "'";
      }
      $columnString = implode(',', $columns);
      $valueString = implode(',', $values);
      $sql = "INSERT INTO `{$table}` ({$columnString}) VALUES ($valueString)";
      $this->executeSQL($sql);
    }
    public function joinType($companyID)
    {
      $gujwaTable = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$companyID} AND activated =1 AND price >0 AND  `point` IS NULL ");
      $pointTable = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$companyID} AND activated =1 AND price >0 AND  `point` IS NOT NULL ");
      $depositTable = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$companyID} AND activated =1 AND deposit >0");
      if (sizeof($gujwaTable) > 0) return 'gujwa';
      elseif (sizeof($pointTable) > 0) return 'point';
      elseif (sizeof($depositTable) > 0) return 'deposit';
      else return 'deactivated';
    }
    public function isHoliday($date)
    {
      if (in_array(date('w', strtotime($date)), [0, 6])) {
        return true;
      } elseif (sizeof($this->getTable("SELECT * FROM `holiday` where holiday = '{$date}'")) > 0) {
        return true;
      } else {
        return false;
      }
    }
    public function call($post)
    {
      if($post['monthlySalary']>0){
        unset ($post['salary']);
      }
      $companyID = $post['companyID'];
      $point = $post['point'];
      $this->insert('call', $post);
      if ($this->joinType($companyID) == 'point') {
        $sql = "UPDATE join_company SET point = point-'{$point}' WHERE companyID = '{$companyID}' LIMIT 1";
        $this->executeSQL($sql);
      }
    }
    public function cancel($post)
    {
      $callID = $post['callID'];
      $companyID = $post['companyID'];
      $callData = $this->select('call', "callID = {$callID}")[0];
      $point = $callData['point'];
      if (isset($point)) {
        $this->executeSQL("UPDATE join_company SET point = point+'{$point}' WHERE companyID = '{$companyID}' LIMIT 1");
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$callID}' LIMIT 1");
      } else {
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$callID}' LIMIT 1");
      }
    }
    public function reset($post)
    {
      $id = $post['companyID'];
      $date = $post['workDate'];
      $sql = "SELECT * FROM `call` WHERE `companyID`='{$id}' AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$date}' , 1 ) AND `cancelled`=0 ORDER BY `workDate` ASC";
      $all = $this->getTable($sql);
      
      $sql = "SELECT * FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND endDate >= '{$date}' AND `activated` = 1 AND deleted = 0";
      $gujwaList = $this->getTable($sql);
      
      $max = 26000 * sizeof($gujwaList);
      $sum = 0;
      $this->executeSQL("UPDATE `call` SET `price`=NULL WHERE `companyID` = '{$this->companyID}'  AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$post['workDate']}' , 1 ) AND `cancelled`=0");
      for ($i = 0; $i < sizeof($all); $i++) {
        if ($this->isHoliday($all[$i]['workDate'])) $sum += 10000;
        else $sum += 8000;
        if ($sum <= $max) $this->executeSQL("UPDATE `call` SET `price`=0 WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
        else $this->executeSQL("UPDATE `call` SET `price`=6000 WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
      }
    }
    public function getCallPrice($id, $date)
    {
      if ($this->checkCallType($id, $date) == 'free') {
        return null;
      } else {
        switch ($this->joinType($id)) {
          case 'gujwa':
            return 6000;
            break;
          case 'deposit' :
            if ($this->isHoliday($date)) return 10000;
            else return 8000;
            break;
        }
      }
    }
    public function getWeekDates($date)
    {
      $i = date('w', strtotime($date));
      if ($i == 0) {
        $i += 7;
      }
      for ($cnt = $i - 1; $cnt > 0; --$cnt) {
        $arr[] = date('Y-m-d', strtotime($date . ' - ' . $cnt . ' day'));
      }
      $arr[] = $date;
      for ($cnt2 = 1; $cnt2 <= (7 - $i); ++$cnt2) {
        $arr[] = date('Y-m-d', strtotime($date . ' + ' . $cnt2 . ' day'));
      }
      return $arr;
    }
    public function thisWeekScore($id, $date)
    {
      $sum = 0;
      $sql = "SELECT `workDate` FROM  `call` WHERE companyID ={$id} AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$date}' , 1 ) AND `cancelled`=0 AND (price IS NULL OR price = 0)";
      $list = $this->getTable($sql);
      foreach ($list as $key => $value) {
        if ($this->isHoliday($value['workDate'])) {
          $sum += 10000;
        } else {
          $sum += 8000;
        }
      }
      return $sum;
    }
    public function checkCallType($id, $date)
    {
      $joinType = $this->joinType($id);
      
      switch ($joinType) {
        case 'gujwa':
          $sql = "SELECT * FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND endDate >= '{$date}' AND `activated` = 1 AND deleted = 0";
          $gujwaList = $this->getTable($sql);
          if ($this->isHoliday($date)) {
            $score = 10000;
          } else {
            $score = 8000;
          }
          $total = $score + $this->thisWeekScore($id, $date);
          if ($total <= 26000 * sizeof($gujwaList)) return ['free', $total];
          else return ['charged', $total];
          break;
        
        case 'point':
          if ($this->isHoliday($date)) $point = 8000;
          else $point = 6000;
          $totalPoint = 0;
          $sql = "SELECT point FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND `activated` = 1 AND deleted = 0 AND point>0";
          foreach ($this->getTable($sql) as $value) {
            $totalPoint += $value['point'];
          };
          if ($totalPoint >= $point) return ['free', null];//무료
          else return ['pointExceed', null];//유료
          break;
        case 'deposit':
          return ['charged', null];
          break;
        default:
          break;
      }
    }
    public function fix($post)
    {
      $dow = $post['dow'];
      $start = new DateTime($post['workDate']);
      $end = new DateTime($post['endDate']);
      for ($i = 0; $i < sizeof($dow); $i++) {//모든 date 추출
        $start->modify($dow[$i]);
        $interval = new DateInterval("P1W");
        $period = new DatePeriod($start, $interval, $end);
        foreach ($period as $date) {
          $dateArray[] = $date->format('Y-m-d');
        }
        $result['dateArray'] = $dateArray;
      }
      $this->insert('fix',$post);
      $fixID = intval($this->getTable("SELECT * FROM `fix` ORDER BY `fixID` DESC LIMIT 1")[0]['fixID']);
      if(isset($fixID)){
        $result['fixID'] = $fixID;
      }
      else $result['fixID'] = 1;
      
      return json_encode($result);
    }
    public function getMoney($post){
      $tbl = $post['tableName'];
      $id = $post['id'];
      $sql = "UPDATE `{$tbl}` SET `paid` = '1' WHERE `{$tbl}ID` = '{$id}'";
      $this->executeSQL($sql);
    }
    public function toggleFilter($post){
      $sql = "SELECT `callID` FROM `call`";
      if(isset($post['duration'])){
        $post['date'] = null;
        $condition[]  = "(".implode(' OR ',$post['duration']).")";
      }
      if(isset($post['date'])&&$post['date']!=''){
        $condition = null;
        $condition[] = " (`workDate` = '{$post['date']}') ";
      }
      if(isset($post['charged'])){
        $condition[]  = "(".implode(' OR ',$post['charged']).")";
      }
      if(isset($post['fixed'])){
        $condition[]  = "(".implode(' OR ',$post['fixed']).")";
      }
      if(isset($condition)){
        $sql .= " WHERE ";
      }

      $sql .= implode(' AND ', $condition);

//      return $sql;
      foreach($this->getTable($sql) as $value){
        foreach($value as $item){
          $arr[] = intval($item);
        }
      }
      $arr[] = $sql;
      return json_encode($arr);
    }
  
    function workTimeType($data)
    {
      $start = $data['startTime'];
      $end = $data['endTime'];
      $workTime = $end - $start;
      if ($workTime >= 10) $result = '종일';
      else {if ($start < 12) $result = '오전'; else $result = '오후';}
      return $result;
    }
    
    
    public function assignFilter($post)
    {
      $callID = $post['callID'];
      $callData = $this->getTable("SELECT * FROM `call` WHERE `callID` = {$callID}")[0];
      $companyID = $callData['companyID'];
      $workDate = $callData['workDate'];
      $workField = $callData['workField'];
      $day = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
      $workDay = $day[date('w', strtotime($workDate))];
      $startTime = $callData['startTime'];
      $endTime = $callData['endTime'];
      $condition1 = "(`deleted` = 0)";
      $condition2 = "(`activated` = 1)";
      $condition3 = "(`employeeID` not in (select `employeeID` from `blackList` WHERE `companyID` = '{$companyID}'))";
      $condition4 = "(`employeeID` not in (SELECT `employeeID` FROM `employee_available_date` WHERE (notavailableDate is not null AND notavailableDate != '{$workDate}')))";
      $condition5 = "(`workField1` = '{$workField}' OR `workField2` = '{$workField}' OR `workField3` = '{$workField}')";
      if ($workField == '설거지') {$condition5 .= "OR `workField1` = '주방보조' OR `workField2` = '주방보조' OR `workField3` = '주방보조' ";}
      
      $type = $this->workTimeType($callData);
      switch ($type) {
        case '오전':
          $condition6 = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '오전' || `{$workDay}` = '종일' || `{$workDay}` = '반반')))";
          break;
        case '오후':
          $condition6 = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '오후' || `{$workDay}` = '종일' || `{$workDay}` = '반반')))";
          break;
        case '종일':
          $condition6 = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '종일' )))";
          break;
      }
      $condition7 = "(`employeeID` not in (SELECT `employeeID` FROM `call` WHERE (employeeID is not null) AND (workDate ='{$workDate}') AND ('{$startTime}' < `endTime` AND '{$endTime}'>`startTime`) ))";
      $condition8 = "(`bookmark` = 1)";
      
      
      for($i=1; $i<=3; $i++) {
        switch ($i) {
          case 1:
            $sql = "SELECT `employeeID` FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition3, $condition4, $condition5, $condition6, $condition7]);
            $arr[] = $this->getTable($sql);
            break;
          case 2:
            $sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition3, $condition4]);
            $arr[] = $this->getTable($sql);
            break;
          case 3:
            $sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition8]);
            $arr[] = $this->getTable($sql);
            break;
        }
      }
      return $arr[0] ;
  }