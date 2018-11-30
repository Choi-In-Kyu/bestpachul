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
          echo json_encode($result);
        }
        else{
          $result['joinType']   = null;
          $result['callType']   = null;
          $result['total']      = null;
          $result['holiday']    = null;
          $result['callPrice']  = null;
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
      default :
        $result['msg'] = 'no matching action name';
        echo json_encode($result);
        break;
    }
  }
  else echo 'no action';