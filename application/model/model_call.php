<?php
  
  class Model_call extends Model
  {
    var $group1;
    var $group1_list;
    var $group2;
    var $group3;
    
    function action()
    {
      header("Content-type:text/html;charset=utf8");
      if (isset($_POST)) {
        switch ($_POST['action']) {
          case 'filter':
            $this->group1 = $this->filter($_POST['callID'], 1);
            $this->group2 = $this->filter($_POST['callID'], 2);
            $this->group3 = $this->filter($_POST['callID'], 3);
            $this->group1_list = $this->filter($_POST['callID'],0);
            break;
          case 'assign':
            $this->executeSQL("UPDATE `call` SET `employeeID` = '{$_POST['employeeID']}' WHERE `callID` = '{$_POST['callID']}' LIMIT 1");
            break;
          case 'punk':
            $employeeID = $this->select('employee', "`employeeName` = '{$_POST['employeeName']}'", 'employeeID');
            $this->executeSQL("INSERT INTO `punk` SET `callID` = '{$_POST['callID']}', `employeeID` = '{$employeeID}', `detail`='{$_POST['detail']}'");
            $this->executeSQL("UPDATE `call` SET `employeeID` = NULL WHERE `callID` = '{$_POST['callID']}' LIMIT 1");
            break;
          case 'callCancel':
            $this->executeSQL("UPDATE `call` SET employeeID = NULL, `cancelled`=1, `cancelDetail`='{$_POST['detail']}' WHERE `callID` = {$_POST['callID']} LIMIT 1");
            break;
          case 'assignCancel':
            $this->executeSQL("UPDATE `call` SET employeeID = NULL WHERE `callID` = {$_POST['callID']} LIMIT 1");
            break;
          case 'fix':
            $this->fix($_POST);
            break;
        }
      }
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
    
    function filter($callID, $number)
    {
      $callData = $this->getTable("SELECT * FROM `call` WHERE `callID` = {$callID}")[0];
      $companyID = $callData['companyID'];
      $workDate = $callData['workDate'];
      $workField = $callData['workField'];
      $day = ['sun','mon','tue','wed','thu','fri','sat'];
      $workDay = $day[date('w', strtotime($workDate))];
      $startTime = $callData['startTime'];
      $endTime = $callData['endTime'];
      $condition1 = "(`deleted` = 0)";
      $condition2 = "(`activated` = 1)";
      $condition3 = "(`employeeID` not in (select `employeeID` from `blackList` WHERE `companyID` = '{$companyID}'))";
      $condition4 = "(`employeeID` not in (SELECT `employeeID` FROM `employee_available_date` WHERE (notavailableDate is not null AND notavailableDate != '{$workDate}')))";
      
      $condition5 = "(`workField1` = '{$workField}' OR `workField2` = '{$workField}' OR `workField3` = '{$workField}')";
      if($workField == '설거지'){$condition5 .= "OR `workField1` = '주방보조' OR `workField2` = '주방보조' OR `workField3` = '주방보조' ";}
      
      $type = $this->workTimeType($callData);
      switch ($type){
        case '오전':$condition6 = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '오전' || `{$workDay}` = '종일' || `{$workDay}` = '반반')))";break;
        case '오후':$condition6 = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '오후' || `{$workDay}` = '종일' || `{$workDay}` = '반반')))";break;
        case '종일':$condition6 = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '종일' )))";break;
      }
      
      $condition7 = "(`employeeID` not in (SELECT `employeeID` FROM `call` WHERE (employeeID is not null) AND (workDate ='{$workDate}') AND ('{$startTime}' < `endTime` AND '{$endTime}'>`startTime`) ))";
      $condition8 = "(`bookmark` = 1)";
      switch ($number) {
        case 1:$sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition3, $condition4, $condition5, $condition6, $condition7]);break;
        case 2:$sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition3, $condition4]);break;
        case 3:$sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition8]);break;
        case 0:$sql = "SELECT employeeID FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition3, $condition4, $condition5, $condition6, $condition7]);break;
      }
      if(in_array($number,[1,2,3])){return $this->getTable($sql);}
      else{foreach ($this->getTable($sql) as $value){$array[] = intval($value['employeeID']);}return $array;}
    }
    
    function fix($post){
      $dow = $post['dow'];
      $dow_string = implode(',',$dow);
      $start = new DateTime($post['startDate']);
      $end = new DateTime($post['endDate']);
      $companyID = $this->select('company',"companyName = '{$post['companyName']}'",'companyID');
      $employeeID = $this->select('employee',"employeeName = '{$post['employeeName']}'",'employeeID');
      $columns = ['workDate','companyID', 'employeeID', 'startTime', 'endTime', 'workField', 'detail'];
      $values = [ null, $companyID, $employeeID, $post['startTime'], $post['endTime'], $post['workField'] , $post['detail'] ];
      foreach ($values as $value){$newValues[] = "'".$value."'";}
      //모든 date 추출
      for ($i=0; $i<sizeof($dow); $i++){
        $start->modify($dow[$i]);
        $interval = new DateInterval("P1W");
        $period   = new DatePeriod($start, $interval, $end);
        foreach ($period as $date) {
          $array[] = $date->format('Y-m-d');
        }
      }
      //DB에 입력하는 쿼리
      foreach ($array as $value){
        $newValues[0]= "'".$value."'";
        $column_string = implode(',',$columns);
        $value_string = implode(',',$newValues);
        $this->executeSQL("INSERT INTO `call` ({$column_string}) VALUES ({$value_string})");
      }
      $this->executeSQL("
INSERT INTO `fix` (companyID, employeeID, dayofweek, detail, startTime, endTime, startDate, endDate, salary)
VALUES ('{$companyID}','{$employeeID}','{$dow_string}','{$post['detail']}','{$post['startTime']}','{$post['endTime']}','{$post['startDate']}','{$post['endDate']}'), '{$post['salary']}'");
    }
    
  }