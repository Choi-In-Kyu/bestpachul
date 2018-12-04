<?php

  class Call extends Controller
  {
    var $callList;
    var $employeeList;
    var $punkList;
    
    function __construct($param)
    {
      parent::__construct($param);
      $this->basic();
      $this->content();
    }
    
    function basic()
    {
      $this->companyID = $this->model->select('user', "userID = $this->userID", 'companyID');
  
      if(isset($_POST['year'])&&isset($_POST['month'])){
        $newDate = $_POST['year'];
        if($_POST['month']<10) $newDate.= '0';
        $newDate.= $_POST['month'].'01';
      }
      switch ($_POST['filter']) {
        case 'week':$condition = "WHERE  YEARWEEK(`workDate`, 1) = YEARWEEK(CURDATE(), 1)";break;
        case 'day':$condition = "WHERE workDate = '{$_POST['date']}'";break;
        case 'month':$condition = "WHERE YEAR(workDate) = YEAR('{$newDate}') AND MONTH(workDate) = MONTH('{$newDate}')";break;
        case 'paid': $condition = "WHERE YEAR(workDate) = YEAR('{$newDate}') AND MONTH(workDate) = MONTH('{$newDate}') AND price > 0 AND point = 0";break;
        case 'all':$condition = "";break;
        default :$condition = "WHERE workDate = '".date('Y-m-d')."'";break;
      }
      
      
      $this->callList = $this->get_callList();
      
      $this->punkList = $this->model->getTable(
        "SELECT callID, punk.employeeID, companyID, workDate, startTime, endTime, workField, salary, call.detail as detail, punk.detail as punkDetail
         FROM  `punk` LEFT JOIN `call` USING (callID)" . $condition);
      $this->fixList = $this->model->getTable("SELECT * FROM `fix`");
      $this->employeeList = $this->model->getTable("SELECT * FROM `employee` WHERE activated = 1");
    }
    
  }