<?php
  require_once 'AjaxModel.php';
  
  class Ajax extends AjaxModel
  {
    public $param;
    public $db;
    public $sql;
    
    public function __construct($param)
    {
      parent::__construct($param);
      $this->param = $param;
    }
  }
  
  $obj = new Ajax($_POST['param']);
  $date = $_POST['workDate'];
  $id = $_POST['companyID'];
  
  if (isset($_POST['action'])) {
    switch ($_POST['action']) {
      case 'initiate':
        if (isset($_POST['companyID']) && ($_POST['companyID'] != '')) {
          if($obj->joinType($id)=='gujwa'){
            $obj->reset($_POST);
          }
          $result['joinType'] = $obj->joinType($id);
          $result['callType'] = $obj->checkCallType($id, $date)[0];
          $result['total'] = $obj->checkCallType($id, $date)[1];
          $result['holiday'] = $obj->isHoliday($date);
          $result['callPrice'] = $obj->getCallPrice($id, $date);
          $result['companyID'] = $_POST['companyID'];
          echo json_encode($result);
        } else {
          $result['joinType'] = null;
          $result['callType'] = null;
          $result['total'] = null;
          $result['holiday'] = null;
          $result['callPrice'] = null;
          $result['salary'] = $_POST['salary'];
          $result['companyID'] = $_POST['companyID'];
          
          echo json_encode($result);
        }
        break;
      case 'call' :
        $obj->call($_POST);
        if ($obj->joinType($id) == 'gujwa') {
//          $result = $obj->reset($_POST);
//          echo $result;
          $obj->reset($_POST);
        }
        break;
      case 'cancel':
        $obj->cancel($_POST);
        if ($obj->joinType($id) == 'gujwa') {
//          $result = $obj->reset($_POST);
//          echo $result;
          $obj->reset($_POST);
        }
        break;
      case 'fix':
        echo $obj->fix($_POST);
        break;
      case 'getCompanyID':
        echo $obj->select('company', "companyName = '{$_POST['companyName']}'", 'companyID');
        break;
      case 'getEmployeeID':
        echo $obj->select('employee', "employeeName = '{$_POST['employeeName']}'", 'employeeID');
        break;
      case 'deleteBlack':
        $obj->executeSQL("DELETE FROM `blackList` WHERE `blackList`.`blackListID` = {$_POST['blackID']} LIMIT 1");
        echo "삭제되었습니다.";
        break;
      case 'bookmark':
        $table = $_POST['tableName'];
        $id = $_POST['id'];
        $bookmark = ($obj->select($table, "{$table}ID = {$id}", 'bookmark') == 1) ? 0 : 1;
        $string = "UPDATE `{$table}` SET `bookmark` = {$bookmark} WHERE `{$table}ID` = '{$id}' LIMIT 1";
        $obj->executeSQL($string);
        $imminent = $obj->select($table, "{$table}ID = {$id}", 'imminent');
        $result['bookmark'] = $bookmark;
        $result['imminent'] = $imminent;
        echo json_encode($result);
        break;
      case 'getMoney':
        $obj->getMoney($_POST);
        echo json_encode($_POST);
        break;
      case 'toggleFilter':
        echo $obj->toggleFilter($_POST);
        break;
      case 'assignFilter':
        echo json_encode($obj->assignFilter($_POST));
        break;
      case 'callFilter':
        echo json_encode($obj->callFiter($_POST));
        break;
      case 'assign':
        echo json_encode($obj->assign($_POST));
        break;
      case 'assignCancel':
        $obj->executeSQL("UPDATE `call` SET employeeID = NULL WHERE `callID` = '{$_POST['callID']}' LIMIT 1");
        echo 'success';
        break;
      case 'getCallList':
        $result['body'] = $obj->getCallList($_POST)[0];
        $result['total'] = $obj->getCallList($_POST)[1];
        echo json_encode($result);
        break;
      case 'alertDetail':
        echo $obj->select('call',"`callID` = '{$_POST['id']}'",'detail');
        break;
      case 'callCancel':
        echo json_encode($obj->callCancel($_POST));
        break;
      case 'delete':
        
//        echo json_encode($_POST);
        
        $table = $_POST['table'];
        $detail = $_POST['deleteDetail'];
        $id = $_POST['id'];
        
        $sql = "UPDATE `{$table}` SET `deleted` = 1, `activated` = 0, `imminent` = 0, `deleteDetail` = '{$detail}' WHERE `{$table}ID` = {$id} LIMIT 1";
        $sql2 = "UPDATE `join_{$table}` SET `deleted` = 1, `activated` = 0, `imminent` = 0 WHERE `{$table}ID` = {$id} LIMIT 1";
        echo $sql2;
        $obj->executeSQL($sql);
        $obj->executeSQL($sql2);
        break;
      case 'restore':
        $sql = "UPDATE `{$_POST['table']}` SET `deleted` = 0 WHERE `{$_POST['table']}ID` = {$_POST['id']} LIMIT 1";
        $obj->executeSQL($sql);
        echo $sql;
        break;
      default :
        $result['msg'] = 'no matching action name';
        echo json_encode($result);
        break;
    }
  } else echo 'no action';