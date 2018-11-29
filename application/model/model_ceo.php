<?php
  class Model_ceo extends Model
  {
    var $userID;
    var $companyID;
    var $gujwaTable;
    var $pointTable;
    var $depositTable;
    var $error;
  
    function __construct($param)
    {
      parent::__construct($param);
      if (isset($_COOKIE['userID'])) $this->userID = $_COOKIE['userID']; else move("login");
      $this->companyID = $this->getTable("SELECT * FROM user WHERE `userID`= '{$this->userID}' LIMIT 1")[0]['companyID'];
    }
  
    function action()
    {
//      switch ($_POST['action']) {
//        case 'call':
//          switch ($this->joinType()) {
//            case 'gujwa':$this->call_gujwa($_POST);break;
//            case 'point':$this->call_point($_POST);break;
//            case 'deposit':$this->call_deposit($_POST);break;
//            case 'deactivated':alert("만기됨");unset($_POST);move('ceo');break;
//          }
//          break;
//        case 'cancel':$this->cancel($_POST);break;
//        case 'paidCall': $this->call($_POST);break;
//        case 'reset':unset($_POST);move('ceo');break;
//      }
    }
  
  

  }