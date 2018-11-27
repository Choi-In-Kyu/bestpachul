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
      switch ($_POST['action']) {
        case 'call':
          switch ($this->joinType()) {
            case 'gujwa':$this->call_gujwa($_POST);break;
            case 'point':$this->call_point($_POST);break;
            case 'deposit':$this->call_deposit($_POST);break;
            case 'deactivated':alert("만기됨");unset($_POST);move('ceo');break;
          }
          break;
        case 'cancel':$this->cancel($_POST);break;
        case 'paidCall': $this->call($_POST);break;
        case 'reset':unset($_POST);move('ceo');break;
      }
    }
    

    function cancel($post){
      $callData = $this->select('call',"callID = $post[callID]")[0];
      $point = $callData['point'];
      if(isset($point)){
        $this->executeSQL("UPDATE join_company SET point = point+'{$point}' WHERE companyID = '{$this->companyID}' LIMIT 1");
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$post['callID']}' LIMIT 1");
      }
      else{
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$post['callID']}' LIMIT 1");
        $this->reset($callData);
      }
      alert('콜을 취소했습니다.');
      unset($post);
      move('ceo');
    }
    function thisweekPoint($workDate)
    {
      $weekendList = $this->getTable("SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$workDate}' , 1 ) AND ( DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1) AND `cancelled`=0 AND price IS NULL");
      $weekdayList = $this->getTable("SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$workDate}' , 1 ) AND NOT( DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1) AND `cancelled`=0 AND price IS NULL");
      $point = (sizeof($weekdayList) * 8000) + (sizeof($weekendList) * 10000);
      return $point;
    }
    function reset($post){
      $sql = "SELECT * FROM `call` WHERE `companyID`='{$this->companyID}' AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$post['workDate']}' , 1 ) AND `cancelled`=0 ORDER BY `workDate` ASC";
      $all = $this->getTable($sql);
      $max = 26000*sizeof($this->gujwaTable);
      $point  = 0;
      $this->executeSQL("UPDATE `call` SET `price`=NULL WHERE `companyID` = '{$this->companyID}'  AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$post['workDate']}' , 1 ) AND `cancelled`=0");
      for ($i = 0; $i < sizeof($all); $i++) {
        if ($this->isHoliday($all[$i]['workDate'])) $point += 10000;
        else $point += 8000;
        if($point<=$max) $this->executeSQL("UPDATE `call` SET `price`=NULL WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
        else $this->executeSQL("UPDATE `call` SET `price`=6000 WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
      }
    }

  }