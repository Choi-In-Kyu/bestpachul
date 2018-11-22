<?php
  
  Class Employee extends Controller
  {
    var $list;
    var $data;
    var $name;
    var $filterColor;
    var $filterBgColor;
    var $joinList;
    var $dayList;
    var $employeeData;
    var $action;
    var $submitButtonName;
    var $employeeID;
    var $callList;
    var $employeeList;

//bestpachul.com/employee
    function basic()
    {
      $this->initJoin('employee');
      $this->getBasicFunction('employee');
    }
//bestpachul.com/employee/view
    function view()
    {
      $this->action = 'update';
      $this->submitButtonName = "수정";
      $this->employeeID = $this->param->idx;
      $this->employeeData = $this->db->getTable("SELECT * FROM employee WHERE employeeID = '{$this->employeeID}'");
      $this->employeeData = $this->getActCondition($this->employeeData, 'employee')[0];
      $this->dayList = $this->db->getTable("SELECT * FROM employee_available_day WHERE employeeID = '{$this->employeeID}'");
      $this->joinList = $this->db->getTable("SELECT * FROM join_employee WHERE employeeID = '{$this->employeeID}' order by endDate DESC");
      $this->data = $this->db->getView();
      $condition = "WHERE `employeeID` = '{$this->employeeID}'";
      switch ($_POST['filter']) {
        case 'all':   break;
        case 'month': $condition .= "AND YEAR(workDate) = YEAR(CURRENT_DATE()) AND MONTH(workDate) = MONTH(CURRENT_DATE())";break;
        case 'week':  $condition .= "AND  YEARWEEK(`workDate`, 1) = YEARWEEK(CURDATE(), 1)";break;
        case 'day':   $condition .= "AND workDate = '{$_POST['date']}' AND";break;
        default :     $condition .= "AND workDate = '".date('Y-m-d')."'";break;
      }
      $this->callList = $this->db->getTable("SELECT * FROM `call`" . $condition);
      $this->punkList = $this->db->getTable(
        "SELECT callID, punk.employeeID, companyID, workDate, startTime, endTime, workField, salary, call.detail as detail, punk.detail as punkDetail
         FROM  `punk` LEFT JOIN `call` USING (callID) WHERE punk.employeeID = '{$this->employeeID}'");
      $this->employeeList = $this->db->getTable("SELECT * FROM `employee` WHERE activated = 1");
    }
//bestpachul.com/employee/write
    function write()
    {
      $this->action = 'insert';
      $this->submitButtonName = "추가";
    }
//bestpachul.com/employee/delete
    function delete()
    {
      $this->db->myDelete('employee', $this->param->idx);
      alert("삭제되었습니다");
      move($this->param->get_page);
    }
    
//bestpachul.com/employee/delete
    function available_date(){
      $this->action = 'insert_date';
    }
    
    function getDay($day, $type)
    {
      if(isset($type)){
        if($type != '종일'){
          if (($this->dayList[0][$day] == $type) || ($this->dayList[0][$day] == '반반')) return "checked";
        }
        else{
          if($this->dayList[0][$day] == $type)
            return "checked";
        }
      }
      else return $this->dayList[0][$day];
    }
  }