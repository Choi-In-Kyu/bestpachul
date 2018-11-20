<?php
  
  class Call extends Controller
  {
    var $callList;
    var $employeeList;
    var $punkList;
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
        case 'today':$condition = "WHERE workDate = '".date('Y-m-d')."'";break;
        case 'all':$condition = "";break;
        case 'month':$condition = "WHERE YEAR(workDate) = YEAR(CURRENT_DATE()) AND MONTH(workDate) = MONTH(CURRENT_DATE())";break;
        case 'week':$condition = "WHERE  YEARWEEK(`workDate`, 1) = YEARWEEK(CURDATE(), 1)";break;
        case 'day':$condition = "WHERE workDate = '{$_POST['date']}'";break;
        default :$condition = "WHERE workDate = '".date('Y-m-d')."'";break;
      }
//      $condition .= "AND `cancelled` = 0";
      $this->callList = $this->db->getTable("SELECT * FROM `call`" . $condition);
      $this->punkList = $this->db->getTable(
        "SELECT callID, punk.employeeID, companyID, workDate, startTime, endTime, workField, salary, call.detail as callDetail, punk.detail as punkDetail
         FROM  `punk` LEFT JOIN `call` USING (callID)" . $condition);
      $this->employeeList = $this->db->getTable("SELECT * FROM `employee` WHERE activated = 1");
    }
    
    function assign(){
      $this->basic();
    }
    function punk(){
      $this->basic();
    }
  }