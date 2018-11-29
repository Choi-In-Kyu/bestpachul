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
//        echo "<pre>";
//        echo $this->sql;
//        echo "</pre>";
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
  
    public function select($table, $condition = null, $column = null, $order = null)
    {
      $sql = "SELECT * FROM `{$table}` ";
      if (isset($condition)) $sql .= "WHERE $condition ";
      if (isset($order)) $sql .= "ORDER BY '{$order}' ASC ";
      if (isset($column)) return $this->getTable($sql)[0][$column];
      else return $this->getTable($sql);
    }
    public function insert($table,$post)
    {
      $columns = array();
      $values = array();
      if (isset($post['action'])) array_shift($post);
      foreach (array_keys($post) as $item){$columns[] = "`".$item."`";}
      foreach ($post as $value){$values[]= "'".$value."'";}
      $columnString =  implode(',', $columns);
      $valueString = implode(',', $values);
      $sql = "INSERT INTO `{$table}` ({$columnString}) VALUES ($valueString)";
      $this->executeSQL($sql);
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
    public function isHoliday($date)
    {
      if (in_array(date('w',strtotime($date)), [0,6])) {return true;}
      elseif(sizeof($this->getTable("SELECT * FROM `holiday` where holiday = '{$date}'"))>0) {return true;}
      else {return false;}
    }
    public function call($post){
      $companyID = $post['companyID'];
      $point = $post['point'];
      $this->insert('call',$post);
      if($this->joinType($companyID)=='point'){
        $this->executeSQL("UPDATE join_company SET point = point-'{$point}' WHERE companyID = '{$companyID}' LIMIT 1");
      }
    }
    public function cancel($post){
      $callID = $post['callID'];
      $companyID = $post['companyID'];
      $callData = $this->select('call',"callID = {$callID}")[0];
      $point = $callData['point'];
      if(isset($point)){
        $this->executeSQL("UPDATE join_company SET point = point+'{$point}' WHERE companyID = '{$companyID}' LIMIT 1");
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$callID}' LIMIT 1");
      }
      else{
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$callID}' LIMIT 1");
      }
    }
    public function reset($post){
      
      $id = $post['companyID'];
      $date = $post['workDate'];
      $sql = "SELECT * FROM `call` WHERE `companyID`='{$id}' AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$date}' , 1 ) AND `cancelled`=0 ORDER BY `workDate` ASC";
      $all = $this->getTable($sql);

      $sql = "SELECT * FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND endDate >= '{$date}' AND `activated` = 1 AND deleted = 0";
      $gujwaList = $this->getTable($sql);

      $max = 26000*sizeof($gujwaList);
      $sum  = 0;
      $this->executeSQL("UPDATE `call` SET `price`=NULL WHERE `companyID` = '{$this->companyID}'  AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$post['workDate']}' , 1 ) AND `cancelled`=0");
      for ($i = 0; $i < sizeof($all); $i++) {
        if ($this->isHoliday($all[$i]['workDate'])) $sum += 10000;
        else $sum += 8000;
        if($sum<=$max) $this->executeSQL("UPDATE `call` SET `price`=0 WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
        else $this->executeSQL("UPDATE `call` SET `price`=6000 WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
      }
      return 'reset';
    }
    
    public function getCallPrice($id,$date){
      if($this->checkCallType($id, $date) == 'free'){
        return null;
      }
      else{
        switch ($this->joinType($id)){
          case 'gujwa': return 6000; break;
          case 'deposit' :
            if($this->isHoliday($date)) return 10000;
            else return 8000;
            break;
        }
      }
    }
    public function getWeekDates($date){
      $i = date('w',strtotime($date));
      if($i==0){$i+=7;}
      for($cnt=$i-1;$cnt>0;--$cnt){
        $arr[] = date('Y-m-d', strtotime($date .' - '.$cnt.' day'));
      }
      $arr[]=$date;
      for($cnt2=1;$cnt2<=(7-$i);++$cnt2){
        $arr[] = date('Y-m-d', strtotime($date .' + '. $cnt2 .' day'));
      }
      return $arr;
    }
    public function thisweekScore($id, $date)
    {
      $sum =0;
      $sql = "SELECT `workDate` FROM  `call` WHERE companyID ={$id} AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$date}' , 1 ) AND `cancelled`=0 AND (price IS NULL OR price = 0)";
      $list = $this->getTable($sql);
      foreach ($list as $key => $value){
        if($this->isHoliday($value['workDate'])){
          $sum += 10000;
        }
        else{
          $sum += 8000;
        }
      }
      return $sum;
    }
    public function checkCallType($id, $date)
    {
      $joinType = $this->joinType($id);
      
      switch ($joinType){
        case 'gujwa':
          $sql = "SELECT * FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND endDate >= '{$date}' AND `activated` = 1 AND deleted = 0";
          $gujwaList = $this->getTable($sql);

          if($this->isHoliday($date)){$score = 10000;}
          else{$score = 8000;}
          $total = $score +$this->thisweekScore($id, $date);
          if($total<=26000*sizeof($gujwaList)) return ['free',$total];
          else return ['charged',$total];
          break;

        case 'point':
          if($this->isHoliday($date))$point = 8000;
          else $point = 6000;
          $totalPoint = 0;
          $sql = "SELECT point FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND `activated` = 1 AND deleted = 0 AND point>0";
          foreach ($this->getTable($sql) as $value){
            $totalPoint += $value['point'];
          };
          if($totalPoint>=$point) return ['free',null];//무료
          else return ['pointExceed',null];//유료
          break;
        case 'deposit':
          return ['charged',null]; break;
        default:
          break;
        break;
      }
    }
    
//    public function call_gujwa($post)
//    {
//      if ($this->isHoliday($post['workDate'])) {$point = 10000;
//      } else {$point = 8000;}
//      $nowgujwa = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$this->companyID} AND activated =1 AND price >0 AND  `point` IS NULL AND endDate > '{$post['workDate']}'");
//      if (sizeof($nowgujwa) > 0) {
//        if ($this->thisweekPoint($post['workDate']) + $point <= 26000 * sizeof($this->gujwaTable)) {
//          $this->call($post);
//        }
//        else {
//          alert("이번주 콜 수가 초과되었습니다.");
//          $_POST['action'] = 'paidCall';
//        }
//      }
//      else{
//        alert('가입만기일 이후의 콜입니다.');
//        unset($post);
//        move('ceo');
//      }
//    }

//    public function call_point($post)
//    {
//      if($this->isHoliday($post['workDate'])){$point = 8;}
//      else{$point = 6;}
//      $myPoint = $this->getTable("SELECT point FROM join_company WHERE companyID = '{$this->companyID}'")[0]['point'];
//      if($point>$myPoint){
//        alert(($point-$myPoint).' 포인트가 부족합니다.');
//        unset($post);
//        move('ceo');
//      }
//      else{
//        $post['point']=$point;
//        $this->executeSQL("UPDATE join_company SET point = point-'{$point}' WHERE companyID = '{$this->companyID}' LIMIT 1");
//        $this->call($post);
//      }
//    }

//    public function call_deposit($post){
//      if($this->isHoliday($post['workDate'])){$price = 8000;}
//      else{$price = 6000;}
//      $post['price'] = $price;
//      $this->call($post);
//    }
  

  }