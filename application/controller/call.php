<?php
  
  class Call extends Controller
  {
    var $callList;
    var $employeeList;
    var $ajaxTest;
    
    function __construct($param)
    {
      parent::__construct($param);
      if (isset($_COOKIE['userID'])) {
        if ($_COOKIE['userID'] == 1) {
        } else {
          alert('접근 권한이 없습니다.');
          move('ceo');
        }
      } else {
        alert('로그인이 필요한 서비스입니다.');
        move('login');
      }
    }
    
    //bestpachul.com/call
    function basic()
    {
      switch ($_POST['filter']) {
        case 'month':
          $condition = "WHERE YEAR(workDate) = YEAR(CURRENT_DATE()) AND MONTH(workDate) = MONTH(CURRENT_DATE())";
          break;
        case 'week':
          $condition = "WHERE  YEARWEEK(`workDate`, 1) = YEARWEEK(CURDATE(), 1)";
          break;
        case 'day':
          $condition = "WHERE workDate = '{$_POST['date']}'";
          break;
        default :
          $condition = "WHERE workDate = '".date('Y-m-d')."'";
          break;
      }
//      $condition .= "AND `cancelled` = 0";
      $this->callList = $this->db->getTable("SELECT * FROM `call`" . $condition);
      $this->employeeList = $this->db->getTable("SELECT * FROM `employee` WHERE activated = 1");
    }
    
    function assign(){
      $this->basic();
    }
  }