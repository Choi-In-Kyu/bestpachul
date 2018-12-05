<?php
  require_once 'AjaxModel.php';

  class Ajax extends AjaxModel {
    public $param;
    public $db;
    public $sql;
    public function __construct($param){
      parent::__construct($param);
      $this->param = $param;
    }
  }
  
  $obj  = new Ajax($_POST['param']);
  $date = $_POST['workDate'];
  $id = $_POST['companyID'];
  
  if(isset($_POST['action'])){
    switch ($_POST['action']){
      case 'initiate':
        if(isset($_POST['companyID']) && ($_POST['companyID']!='')){
          $obj->reset($_POST);
          $result['joinType']   = $obj->joinType($id);
          $result['callType']   = $obj->checkCallType($id,$date)[0];
          $result['total']      = $obj->checkCallType($id,$date)[1];
          $result['holiday']    = $obj->isHoliday($date);
          $result['callPrice']  = $obj->getCallPrice($id, $date);
          $result['companyID']          = $_POST['companyID'];
          echo json_encode($result);
        }
        else{
          $result['joinType']   = null;
          $result['callType']   = null;
          $result['total']      = null;
          $result['holiday']    = null;
          $result['callPrice']  = null;
          $result['salary']          = $_POST['salary'];
          $result['companyID']          = $_POST['companyID'];
  
          echo json_encode($result);
        }
        break;
      case 'call' :
        $obj->call($_POST);
        if($obj->joinType($id)=='gujwa'){
          $result = $obj->reset($_POST);
          echo $result;
        }
        break;
      case 'cancel':
        $obj->cancel($_POST);
        if($obj->joinType($id)=='gujwa'){
          $result = $obj->reset($_POST);
          echo $result;
        }
        break;
      case 'fix':
        echo $obj->fix($_POST);
        break;
      case 'getCompanyID':
        echo $obj->select('company',"companyName = '{$_POST['companyName']}'",'companyID');
        break;
      case 'getEmployeeID':
        echo $obj->select('employee',"employeeName = '{$_POST['employeeName']}'",'employeeID');
        break;
      case 'deleteBlack':
        $obj->executeSQL("DELETE FROM `blackList` WHERE `blackList`.`blackListID` = {$_POST['blackID']} LIMIT 1");
        echo "삭제되었습니다.";
        break;
      case 'bookmark':
        $table = $_POST['tableName'];
        $id = $_POST['id'];
        $value = ($obj->select($table,"{$table}ID = {$id}",'bookmark') == 1) ? 0 : 1 ;
        $string = "UPDATE `{$table}` SET `bookmark` = {$value} WHERE `{$table}ID` = '{$id}' LIMIT 1";
        $obj->executeSQL($string);
        echo $value;
        break;
      case 'getMoney':
        echo json_encode($_POST);
        break;
      default :
        $result['msg'] = 'no matching action name';
        echo json_encode($result);
        break;
    }
  }
  else echo 'no action';