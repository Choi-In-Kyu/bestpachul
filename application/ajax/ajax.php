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
        $obj->reset($_POST);
        $result['joinType']   = $obj->joinType($id);
        $result['callType']   = $obj->checkCallType($id,$date)[0];
        $result['total']      = $obj->checkCallType($id,$date)[1];
        $result['holiday']    = $obj->isHoliday($date);
        $result['callPrice']  = $obj->getCallPrice($id, $date);
        echo json_encode($result);
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
      default :
        $result['msg'] = 'no matching action name';
        echo json_encode($result);
    }
  }
  else echo 'no action';