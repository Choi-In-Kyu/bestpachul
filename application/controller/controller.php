<?php
  require_once(__DIR__ . '/../config/functions.php');
  
  Class Controller extends Functions
  {
    var $param;
    var $userID;
    var $model;
    var $list;
    var $title;
    var $setAjax;
    var $condition;
    var $keyword;
    var $join;
    var $day;
    var $tables;
    public $defaultCondition = array("filter" => " (deleted = 0) ");
    public $activatedCondition = array("filter" => " (activated = 1 AND deleted = 0) ");
    public $expiredCondition = array("filter" => " (activated = 0 AND deleted = 0) ");
    public $deletedCondition = array("filter" => " (activated = 0 AND deleted = 1) ");
    public $deadlineCondition = array("filter" => " (activated = 1 AND (bookmark = 1 OR imminent = 1)) ");

//생성자
    function __construct($param)
    {
      header("Content-type:text/html;charset=utf8");
      $this->param = $param;
      if (isset($_COOKIE['userID'])) $this->userID = $_COOKIE['userID'];
      $modelName = "Model_{$this->param->page_type}";//Model 객체 생성
      $this->model = new $modelName($this->param);
      $this->getFunctions();
      $method = isset($this->param->action) ? $this->param->action : null;
      if (method_exists($this, $method)) $this->$method();
      require_once(_VIEW . "header.php");
    }
    
    function getFunctions()
    {
      $this->tables = array('company', 'ceo', 'employee', 'call', 'address', 'businessType', 'workField', 'call', 'employee_available_date', 'blackList');
      foreach ($this->tables as $value) {
        $this->{$value . '_List'} = $this->model->select($value);
      }
    }
    
    function getBasicFunction($tableName)
    {
      $this->keyword = $_POST['keyword'];
      $this->order = $_POST['order'];
      $this->direction = $_POST['direction'];
      if (isset($_POST['filterCondition'])) {
        $this->condition['filter'] = $_POST['filterCondition'];
      } else {
        $this->condition['filter'] = $this->activatedCondition['filter'];
      }
      if (isset($_POST['keyword']) && $_POST['keyword'] != "") {
        $this->condition['keyword'] = " (`{$tableName}Name` LIKE '%{$this->keyword}%' OR `address` LIKE '%{$this->keyword}%') ";
      }
      $this->list = $this->model->getList($this->condition);
      $this->list = $this->initActCondition($this->list, $tableName);
      $this->list = $this->getActCondition($this->list, $tableName);
    }
    
    function get_callList(){
      $table = $this->param->page_type;
      if(in_array($table,['company','employee'])) $condition = " WHERE `{$table}ID` = '{$this->param->idx}' ";
      else $condition = "";
      if(isset($_POST['year'])&&isset($_POST['month'])){
        $newDate = $_POST['year'];
        if($_POST['month']<10) $newDate.= '0';
        $newDate.= $_POST['month'].'01';
      }
      
      switch ($_POST['filter']) {
        case 'all'  :$condition = "";break;
        case 'day'  :$condition = "WHERE workDate = '{$_POST['date']}'";break;
        case 'week' :$condition = "WHERE  YEARWEEK(`workDate`, 1) = YEARWEEK(CURDATE(), 1)";break;
        case 'month':$condition = "WHERE YEAR(workDate) = YEAR('{$newDate}') AND MONTH(workDate) = MONTH('{$newDate}')";break;
        case 'paid' :$condition = "WHERE YEAR(workDate) = YEAR('{$newDate}') AND MONTH(workDate) = MONTH('{$newDate}') AND price IS NOT NULL AND point IS NULL";break;
        default     :$condition = "WHERE workDate = '"._TODAY."'";break; //기본값은 오늘
      }
      return $this->model->getTable("SELECT * FROM `call`" . $condition);
    }
  }