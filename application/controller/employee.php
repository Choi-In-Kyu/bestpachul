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
  
    var $direction;
    var $condition;
    var $join;
    var $order;
    var $keyword;
    var $employeeID;
  
    public $defaultCondition    = array("filter" => " (deleted = 0) ");
    public $activatedCondition  = array("filter" => " (activated = 1 AND deleted = 0) ");
    public $expiredCondition    = array("filter" => " (activated = 0 AND deleted = 0) ");
    public $deletedCondition    = array("filter" => " (activated = 0 AND deleted = 1) ");
    public $deadlineJoin        = " LEFT JOIN `join_employee` ON `employee`.employeeID = `join_employee`.employeeID ";
    public $deadlineCondition   = array("filter" => "(DATE_ADD(`endDate`, interval -3 day) < CURDATE()) AND (CURDATE()<`endDate`) ORDER BY endDate ASC LIMIT 1");
  
    function getActCondition($list)
    {
      $deadlineArray  = $this->db->getColumnList($this->db->getList($this->deadlineCondition, null, $this->deadlineJoin), 'employeeID');
      $expiredArray   = $this->db->getColumnList($this->db->getList($this->expiredCondition), 'employeeID');
      $deletedArray   = $this->db->getColumnList($this->db->getList($this->deletedCondition), 'employeeID');
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
  
    function getemployeeTable($list, $employeeID)
    {
      foreach ($list as $key => $value) {
        if ($list[$key]['employeeID'] == $employeeID) {
          return $list[$key];
        } else {
          return null;
        }
      }
    }
  
    function initActCondition($list){
      $today = date("Y-m-d");
      foreach ($list as $key => $value){
        $employeeID = $value['employeeID'];
        $endDateArray = $this->db->getTable("SELECT * from `join_employee` WHERE employeeID = {$employeeID}");
        foreach ($endDateArray as $key => $value) {
          $endDate = $value['endDate'];
          if($today>$endDate){
            $this->db->executeSQL("UPDATE employee SET activated = 0, deleted = 0 WHERE employeeID = {$employeeID} LIMIT 1");
          }
          else{
            $this->db->executeSQL("UPDATE employee SET activated = 1, deleted = 0 WHERE employeeID = {$employeeID} LIMIT 1");
            break;
          }
        }
      }
      return $list;
    }
  
    function getDay($day, $type){
      if($this->dayList[0][$day] == $type) return "checked";
      return false;
    }

//bestpachul.com/employee
    function basic()
    {
      $this->join       = $_POST['join'];
      $this->keyword    = $_POST['keyword'];
      $this->order      = $_POST['order'];
      $this->direction  = $_POST['direction'];
      //condition - 필터링, 검색, 정렬 기능
      if(isset($_POST['filterCondition'])){
        $this->condition['filter'] = $_POST['filterCondition'];
      }
      if (isset($_POST['keyword']) && $_POST['keyword'] != ""){
        $this->condition['keyword'] = " (`employeeName` LIKE '%{$this->keyword}%' OR `address` LIKE '%{$this->keyword}%') ";
      }
      //order
      if(isset($this->direction) && isset($this->order)){
        if ($this->direction == "ASC") $this->direction = "DESC";
        else $this->direction = "ASC";
        if (isset($this->order) && $this->order != "") $this->order = " {$_POST['order']} {$this->direction}";
        else $this->order = null;
      }
      //get list
      $this->list = $this->db->getList($this->condition, $this->order, $this->join);
      $this->list = $this->initActCondition($this->list);
      $this->list = $this->getActCondition($this->list);
      
      switch ($this->condition['filter']){
        case $this->defaultCondition['filter']:   $this->filterBgColor['default'] = "white"; $this->filterColor['default'] = "black"; break;
        case $this->activatedCondition['filter']: $this->filterBgColor['activated'] = "ivory"; $this->filterColor['activated'] = "black"; break;
        case $this->deadlineCondition['filter']:  $this->filterBgColor['deadline'] = "orange"; $this->filterColor['deadline'] = "black"; break;
        case $this->expiredCondition['filter']:   $this->filterBgColor['expired'] = "pink"; $this->filterColor['expired'] = "black"; break;
        case $this->deletedCondition['filter']:   $this->filterBgColor['deleted'] = "gray"; break;
      }
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
      $this->dayList = $this->db->getTable("SELECT * FROM employee_available_day WHERE employeeID = '{$this->employeeID}'");
      $this->joinList = $this->db->getTable("SELECT * FROM join_employee WHERE employeeID = '{$this->employeeID}' order by endDate DESC");
      $this->data = $this->db->getView();
      function get_joinType($data)
      {
        if (isset($data['deposit']) && $data['deposit'] != 0) return "보증금+콜비";
        elseif (isset($data['point']) && $data['point'] != 0) return "포인트";
        elseif (isset($data['price']) && $data['price'] != 0) return "구좌";
      }
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

