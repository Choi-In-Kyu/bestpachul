<?php
  
  Class Employee extends Controller
  {
    var $list;
    var $data;
    var $name;
    var $filterColor;
    var $filterBgColor;
    var $workFieldList;
    var $addressList;
    var $joinList;
    var $dayList;
    var $employeeData;
    var $action;
    var $submitButtonName;
    var $employeeID;
    
    public $deadlineJoin = " LEFT JOIN `join_employee` ON `employee`.employeeID = `join_employee`.employeeID ";
    public $deadlineCondition = array("filter" => " (DATE_ADD(`endDate`, interval -15 day) < CURDATE()) AND (CURDATE()<`endDate`)");
    public $deadlineGroup = "employeeName";
    
    function getDay($day, $type)
    {
      if ($this->dayList[0][$day] == $type) return "checked";
      return false;
    }
//bestpachul.com/employee
    function basic()
    {
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
      $this->workFieldList = $this->db->getTable("SELECT * FROM `workField`");
      $this->addressList = $this->db->getTable("SELECT * FROM `address`");
      $this->dayList = $this->db->getTable("SELECT * FROM employee_available_day WHERE employeeID = '{$this->employeeID}'");
      $this->joinList = $this->db->getTable("SELECT * FROM join_employee WHERE employeeID = '{$this->employeeID}' order by endDate DESC");
      $this->data = $this->db->getView();
    }
//bestpachul.com/employee/write
    function write()
    {
      $this->action = 'insert';
      $this->submitButtonName = "추가";
      $this->workFieldList = $this->db->getTable("SELECT * FROM `workField`");
      $this->addressList = $this->db->getTable("SELECT * FROM `address`");
    }
//bestpachul.com/employee/delete
    function delete()
    {
      $this->db->myDelete('employee', $this->param->idx);
      alert("삭제되었습니다");
      move($this->param->get_page);
    }
  }