<?php
  
  class Call extends Controller
  {
    function __construct($param)
    {
      parent::__construct($param);
      if(isset($_COOKIE['userID'])){
        if($_COOKIE['userID']==1){}
        else {
          alert('접근 권한이 없습니다.');
          move('ceo');
        }
      }
      else{
        alert('로그인이 필요한 서비스입니다.');
        move ('login');
      }
    }
    //bestpachul.com/call
    function basic()
    {
    
    }
    function callType($data){
      if(isset($data['point'])) return '포인트';
      if(isset($data['price'])) return '유료';
      else return '일반';
    }
   
    function timeType($data){
      $start = $data['startTime'];
      $end = $data['endTime'];
      $workTime = $end-$start;
      if($workTime >= 10) $result = '종일';
      else{
        if($start < 12) $result='오전'; else $result='오후';
      }
      return $result.' ('.date('H:i',strtotime($data['startTime']))."~".date('H:i',strtotime($data['endTime'])).')';
    }
  }