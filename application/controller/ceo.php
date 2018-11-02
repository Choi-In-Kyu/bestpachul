<?php
  
  class Ceo extends Controller
  {
    var $userID;
    var $companyID;
    var $companyData;
    var $callList;
    var $joinData;
    var $leftDays;
    var $holidayList;
    var $weekendCount;
    var $weekdayCount;
    var $callPriceList;
    var $callPrice;
  
    public function __construct($param)
    {
      parent::__construct($param);
    }
    
    function basic()
    {
      if(isset($_COOKIE['userID']))$this->userID = $_COOKIE['userID']; else {alert('로그인이 필요합니다');move('login');};
      $this->companyID    = $this->db->getTable("SELECT companyID FROM user WHERE userID = '{$this->userID}'")[0]['companyID'];
      $this->companyData  = $this->db->getTable("SELECT * from `company` WHERE company.companyID ='{$this->companyID}' LIMIT 1")[0];
      $this->joinData     = $this->db->getTable("SELECT * FROM `join_company` WHERE companyID = '{$this->companyID}' AND activated = 1");
      $this->callList     = $this->db->getTable("SELECT * FROM `call` WHERE companyID = '{$this->companyID}'");
      $this->holidayList  = $this->db->getColumnList($this->db->getTable("SELECT * FROM `holiday`"), 'holiday');
      $this->weekendCount = $this->db->getTable(
        "SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 ) AND ( DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1)");
      $this->weekdayCount = $this->db->getTable(
        "SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 ) AND NOT (DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1)");
      $this->callPriceList = $this->db->getTable("SELECT * FROM `call`  WHERE companyID =  '{$this->companyID}' AND paid = 0 AND price >0");
      $this->callPrice = $this->addAll($this->callPriceList);
    }
    
    function leftDays($date)
    {
      $today = strtotime($this->today);
      $date = strtotime($date);
      $leftDays = date('j', $today - $date);
      return $leftDays;
    }
    
    function getTime($i)
    {
      if ($i < 12) {$time = '오전 ' . $i . '시';}
      elseif($i == 12){$time = '정오';}
      elseif(12<$i && $i<24) {$time = $i - 12; $time = '오후 ' . $time . '시';}
      elseif($i==24) {$time = '자정';}
      elseif($i>24){$time = $i - 24;$time = '익일오전 ' . $time . '시';}
      return $time;
    }
    
    function dateFormat($array){
      foreach ($array as $item){
        $array2[] = "\"".$item."\"";
      }
      $date = implode(',',$array2);
      return $date;
    }
    
    function get_joinTypes($list){
      $result = array();
      foreach ($list as $key => $value){
        if(isset($value['point'])){
          if(!in_array('포인트',$result)){
            $result[] = '포인트';
          }
        }
        elseif(isset($value['deposit'])){
          if(!in_array('보증금',$result)){
            $result[] = '보증금';
          }
        }
        elseif(isset($value['price'])){
          if(!in_array('구좌',$result)){
            $result[] ='구좌';
          }
        }
      }
      return implode(',',$result);
    }
    
    function addAll($array){
      $sum=0;
      foreach($array as $value){
        $sum += $value['price'];
      }
      return $sum;
    }
    
    function getDate($list){
      foreach($list as $key=>$value){
        $year = date('Y',strtotime($value['workDate']));
        $array[$year][] = date('m',strtotime($value['workDate']));
      }
      return $array;
    }
  }