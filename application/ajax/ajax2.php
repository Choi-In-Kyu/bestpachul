<?php
  require_once 'AjaxModel.php';
  
  class Ajax2 extends AjaxModel {
    public $param;
    public $db;
    public $sql;
    public function __construct($param){
      parent::__construct($param);
      $this->param = $param;
    }
  }
  
  echo json_encode($_POST);
  
  $obj  = new Ajax2($_POST['param']);
  
  if(isset($_POST['action'])) {
    switch ($_POST['action']){
      case 'deleteBlack':
        $obj->executeSQL("DELETE FROM `blackList` WHERE `blackList`.`blackListID` = {$_POST['blackID']} LIMIT 1");
        break;
    }
  }
  else echo 'no action';