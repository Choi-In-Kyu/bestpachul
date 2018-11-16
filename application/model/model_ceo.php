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
      if(isset($_COOKIE['userID'])){
        if($_COOKIE['userID']==1){
          alert('관리자페이지로 이동합니다.');
          move(_URL.'company');
        }
      }
      else{
        alert('로그인이 필요한 서비스입니다.');
        move (_URL.'login');
      }
    }
    
    function callFunctions()
    {
      if (isset($_COOKIE['userID'])) $this->userID = $_COOKIE['userID']; else move("login");
      $this->companyID = $this->getTable("SELECT * FROM user WHERE `userID`= '{$this->userID}' LIMIT 1")[0]['companyID'];
      $this->gujwaTable = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$this->companyID} AND activated =1 AND price >0 AND  `point` IS NULL ");
      $this->pointTable = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$this->companyID} AND activated =1 AND price >0 AND  `point` IS NOT NULL ");
      $this->depositTable = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$this->companyID} AND activated =1 AND deposit >0");
    }
    
    function action()
    {
      $this->callFunctions();
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
    
    function sqlImplode($post, $glue)
    {
      foreach ($post as $value) {
        $newPost[] = $glue . $value . $glue;
      }
      return $newPost;
    }
    
    function arrayToString($post)
    {
      array_shift($post);
      $string = implode(',', $post);
      return $string;
    }
    
    function call($post)
    {
      $post['companyID'] = $this->companyID;
      $columns = $this->arrayToString($this->sqlImplode(array_keys($post), "`"));
      $values = $this->arrayToString($this->sqlImplode($post, "'"));
      $this->executeSQL("INSERT INTO `call` ({$columns}) VALUES ($values)");
      alert("콜을 요청했습니다.");
      $this->reset($post);
      unset($post);
      move('ceo');
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
    
    function call_gujwa($post)
    {
      if ($this->isWeekend($post['workDate'])) {$point = 10000;
      } else {$point = 8000;}
      $nowgujwa = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$this->companyID} AND activated =1 AND price >0 AND  `point` IS NULL AND endDate > '{$post['workDate']}'");
      if (sizeof($nowgujwa) > 0) {
        if ($this->thisweekPoint($post['workDate']) + $point <= 26000 * sizeof($this->gujwaTable)) {
          $this->call($post);
        }
        else {
          alert("이번주 콜 수가 초과되었습니다.");
          $_POST['action'] = 'paidCall';
        }
      }
      else{
        alert('가입만기일 이후의 콜입니다.');
        unset($post);
        move('ceo');
      }
    }
    
    function call_point($post)
    {
      if($this->isWeekend($post['workDate'])){$point = 8;}
      else{$point = 6;}
      $myPoint = $this->getTable("SELECT point FROM join_company WHERE companyID = '{$this->companyID}'")[0]['point'];
      if($point>$myPoint){
        alert(($point-$myPoint).' 포인트가 부족합니다.');
        unset($post);
        move('ceo');
      }
      else{
        $post['point']=$point;
        $this->executeSQL("UPDATE join_company SET point = point-'{$point}' WHERE companyID = '{$this->companyID}' LIMIT 1");
        $this->call($post);
      }
    }
    
    function call_deposit($post){
      if($this->isWeekend($post['workDate'])){$price = 8000;}
      else{$price = 6000;}
      $post['price'] = $price;
      $this->call($post);
    }
    
    function isWeekend($date)
    {
      if ((date('w', strtotime($date)) == 0) || (date('w', strtotime($date)) == 6)) return true;
      elseif (sizeof($this->getTable("SELECT * FROM `holiday` where holiday = '{$date}'"))) {
        return true;
      } else return false;
    }
    
    function joinType()
    {
      if (sizeof($this->gujwaTable) > 0) return 'gujwa';
      elseif (sizeof($this->pointTable) > 0) return 'point';
      elseif (sizeof($this->depositTable) > 0) return 'deposit';
      else return 'deactivated';
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
        if ($this->isWeekend($all[$i]['workDate'])) $point += 10000;
        else $point += 8000;
        if($point<=$max) $this->executeSQL("UPDATE `call` SET `price`=NULL WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
        else $this->executeSQL("UPDATE `call` SET `price`=6000 WHERE `callID` = '{$all[$i]['callID']}' LIMIT 1");
      }
    }

  }