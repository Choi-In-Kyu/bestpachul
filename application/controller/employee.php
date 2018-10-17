<?php
  
  Class Employee extends Controller
  {
    var $list;
    var $data;
    var $name;
    
    var $workFieldList;
    var $addressList;
    var $joinList;
    var $dayList;
    
    var $employeeData;
    
    var $action;
    var $submitButtonName;
    
    var $direction;
    var $condition;
    var $order;
    var $keyword;
    var $employeeID;
    
    public $activatedCondition = " WHERE activated = 1 AND deleted = 0 ";
    public $expiredCondition = " WHERE activated = 0 AND deleted = 0 ";
    public $deletedCondition = " WHERE activated = 0 AND deleted = 1 ";
    public $deadlineCondition =
      " LEFT JOIN `join_employee`
          ON `employee`.employeeID = `join_employee`.employeeID
          WHERE
          (DATE_ADD(`endDate`, interval -3 day) < CURDATE())
          AND
          (CURDATE()<`endDate`)
          ORDER BY endDate ASC LIMIT 1";
    
    
    function getActCondition($list)
    {
      $deadlineArray = $this->db->getColumnList($this->db->getList($this->deadlineCondition), 'employeeID');
      $expiredArray = $this->db->getColumnList($this->db->getList($this->expiredCondition), 'employeeID');
      $deletedArray = $this->db->getColumnList($this->db->getList($this->deletedCondition), 'employeeID');
      foreach ($list as $key => $value) {
        $employeeID = $list[$key]['employeeID'];
        if (in_array($employeeID, $expiredArray)) {
          $actCondition = "만기됨";
          $color = "pink";
        } elseif (in_array($employeeID, $deadlineArray)) {
          $actCondition = "만기임박";
          $color = "orange";
        } elseif (in_array($employeeID, $deletedArray)) {
          $actCondition = "삭제됨";
          $color = "gray";
        } else {
          $actCondition = "가입중";
          $color = "ivory";
        }
        $list[$key]['actCondition'] = $actCondition;
        $list[$key]['color'] = $color;
      }
      return $list;
    }
    
    function getDay($day, $type){
      if($this->dayList[0][$day] == $type) return "checked";
      return false;
    }
    
//    function getemployeeTable($list, $employeeID)
//    {
//      foreach ($list as $key => $value) {
//        if ($list[$key]['employeeID'] == $employeeID) {
//          return $list[$key];
//        } else {
//          return null;
//        }
//      }
//    }
    
    //bestpachul.com/employee
    function basic()
    {
      //condition
      if(isset($_POST['condition']))
        $this->condition = $_POST['condition'];
      $this->keyword = $_POST['keyword'];
      if (isset($this->keyword) && $this->keyword != "") $this->condition = " WHERE `employeeName` LIKE '%{$this->keyword}%' OR `address` LIKE '%{$this->keyword}%' ";
      //order
      $this->direction = $_POST['direction'];
      if ($this->direction == "ASC") $this->direction = "DESC";
      else $this->direction = "ASC";
      $this->order = $_POST['order'];
      if (isset($this->order) && $this->order != "") $this->order = " {$_POST['order']} {$this->direction}";
      else $this->order = null;
      //get list
      $this->list = $this->db->getList($this->condition, $this->order);
      $this->list = $this->getActCondition($this->list);
    }
    
    //bestpachul.com/employee/view
    function view()
    {
      $this->action = 'update';
      $this->submitButtonName = "수정";
      $this->employeeID = $this->param->idx;
      $this->employeeData = $this->db->getTable("SELECT * FROM employee WHERE employeeID = '{$this->employeeID}'");
      $this->employeeData = $this->getActCondition($this->employeeData)[0];
      
      $this->workFieldList = $this->db->getTable("SELECT * FROM `workField`");
      $this->addressList = $this->db->getTable("SELECT * FROM `address`");
      
      $this->joinList = $this->db->getTable("SELECT * FROM join_employee WHERE employeeID = '{$this->employeeID}' order by endDate DESC");
      $this->dayList = $this->db->getTable("SELECT * FROM employee_available_day WHERE employeeID = '{$this->employeeID}'");
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