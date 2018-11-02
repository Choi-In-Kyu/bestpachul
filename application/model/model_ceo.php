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
        //콜 보내기
        case 'call':
          switch ($this->joinType()) {
            case 'gujwa':
              $this->call_gujwa($_POST);
              break;
            case 'point':
              $this->call($_POST);
              break;
            case 'deposit':
              $this->call($_POST);
              break;
            case 'deactivated':
              break;
            default:
          }
        //콜 취소
        case 'cancel':
          break;
        case 'paidCall':
          alert('유료콜!!!!');

//          $this->call($_POST);
          //unset($_POST);
//          move('ceo');
          break;
        case 'reset':
          unset($_POST);
          move('ceo');
      }
      //콜 초기화 및 돌아가기
//      unset($_POST);
//      move('ceo');
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
      alert("콜을 보냈습니다!");
    }
    
    function call_gujwa($post)
    {
      if ($this->isWeekend($post['workDate'])) $point = 10000; else $point = 8000;
      $nowgujwa = $this->getTable("SELECT * FROM  `join_company` WHERE companyID = {$this->companyID} AND activated =1 AND price >0 AND  `point` IS NULL AND endDate > '{$post['workDate']}'");
      if (sizeof($nowgujwa) > 0) {
        if ($this->thisweekPoint($post) + $point <= 26000 * sizeof($this->gujwaTable)) {
          $this->call($post);
        } else {
          alert("콜 수 초과");
          $_POST['action'] = 'paidCall';
        }
      } else alert('가입기간이 만료됨');
    }
    
    
    function confirm()
    {
      $url = 'http://bestpachul.com/ceo';
      $fields = array(
        'action' => 'paidCall',
        'field2' => '222',
      );
      $vars = http_build_query($fields);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, count($fields));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
      curl_exec($ch);
    }
    
    function call_point($post)
    {
    
    }
    
    function isWeekend($date)
    {
      if ((date('w', $date) == 0) || (date('w', $date) == 6)) return true;
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
    
    function thisweekPoint($post)
    {
      $workDate = $post['workDate'];
      $weekendList = $this->getTable("SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$workDate}' , 1 ) AND ( DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1)");
      $weekdayList = $this->getTable("SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$workDate}' , 1 ) AND NOT( DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1)");
      $point = (sizeof($weekdayList) * 8000) + (sizeof($weekendList) * 10000);
      return $point;
    }
    
  }