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
    var $employeeList;
    var $availableDateList;
    var $employeeData;
    var $action;
    var $submitButtonName;
    var $employeeID;
    
    public $deadlineJoin = " LEFT JOIN `join_employee` ON `employee`.employeeID = `join_employee`.employeeID ";
    public $deadlineCondition = array("filter" => " (DATE_ADD(`endDate`, interval -5 day) < CURDATE()) AND (CURDATE()<`endDate`)");
    public $deadlineGroup = "employeeName";
    
//bestpachul.com/employee
    function basic()
    {
      $this->getBasicFunction('employee');
      $this->employeeList = $this->db->getTable("SELECT * FROM employee WHERE deleted = 0");
      $this->availableDateList = $this->db->getTable("SELECT * FROM employee_available_date");
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
      if ($this->dayList[0][$day] == $type) return "checked";
      return false;
    }
  }