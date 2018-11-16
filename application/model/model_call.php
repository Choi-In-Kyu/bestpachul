<?php
  
  class Model_call extends Model
  {
    var $group1;
    var $group2;
    var $group3;
    
    function action()
    {
      header("Content-type:text/html;charset=utf8");
      $msg = "[SYSTEM] ";
      $url = $this->param->get_page;
      switch ($_POST['action']) {
        case 'test':
      }
      if (isset($_POST)) {
        switch ($_POST['action']) {
          case 'assignCancel':
            $this->executeSQL("UPDATE `call` SET employeeID = NULL WHERE `callID` = {$_POST['callID']} LIMIT 1");
            break;
          case 'callCancel':
            $this->executeSQL("UPDATE `call` SET employeeID = NULL, `cancelled`=1 WHERE `callID` = {$_POST['callID']} LIMIT 1");
            alert("콜을 취소했습니다.");
            break;
          case 'punk':
            $employeeID = $this->select('employee', "`employeeName` = '{$_POST['employeeName']}'", 'employeeID');
            $this->executeSQL("INSERT INTO `punk` SET `callID` = '{$_POST['callID']}', `employeeID` = '{$employeeID}', `detail`='{$_POST['detail']}'");
            $this->executeSQL("UPDATE `call` SET `employeeID` = NULL WHERE `callID` = '{$_POST['callID']}' LIMIT 1");
            break;
          case 'assign':
            $this->executeSQL("UPDATE `call` SET `employeeID` = '{$_POST['employeeID']}' WHERE `callID` = '{$_POST['callID']}' LIMIT 1");
            break;
          case 'filter':
            $this->group1 = $this->filter($_POST['callID'],1);
            $this->group2 = $this->filter($_POST['callID'],2);
            $this->group3 = $this->filter($_POST['callID'],3);
            break;
        }
      }
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
      $condition6 = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '종일' || `{$workDay}` = '오전')))";
      $condition7 = "(`employeeID` not in (SELECT `employeeID` FROM `call` WHERE (employeeID is not null) AND (workDate ='{$workDate}') AND ('{$startTime}' < `endTime` AND '{$endTime}'>`startTime`) ))";
      switch ($number) {
        case 1:
          $sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition3, $condition4, $condition5, $condition6, $condition7]);
          break;
        case 2:
          $sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2, $condition3, $condition4]);
          break;
        case 3:
          $sql = "SELECT * FROM `employee` WHERE " . implode(' AND ', [$condition1, $condition2]);
          break;
      }
      return $this->getTable($sql);
    }
    
    
  }