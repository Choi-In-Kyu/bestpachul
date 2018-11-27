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

  if(isset($_POST['action'])){
    switch ($_POST['action']){
      case 'call' :
        $obj->call($_POST);
        break;
      case 'isHoliday' : echo json_encode($obj->isHoliday($_POST['date'])); break;
      default : echo 'no matching action name';
    }
  }
  else echo 'no action';