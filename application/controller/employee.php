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