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
    var $keyword;
    var $join;
    var $day;
    var $tables;
    var $tableName;
    //필터 버튼 조건
    public $defaultCondition = " (deleted = 0) ";
    public $activatedCondition = " (activated = 1 AND deleted = 0) ";
    public $imminentCondition = " (bookmark = 1 OR imminent = 1) ";
    public $deactivatedCondition = " (activated = 0 AND deleted = 0) ";
    public $deletedCondition = " (activated = 0 AND deleted = 1) ";
    //토글 버튼 조건
    

    
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
      require_once(_VIEW . "common/header.php");
    }
    
    //선택한 테이블들의 모든 데이터를 불러와서 table_List 배열 생성
    function getFunctions()
    {
      $this->tables = array('company', 'ceo', 'employee', 'call', 'address', 'businessType', 'workField', 'call', 'employee_available_date', 'fix');
      foreach ($this->tables as $value) {
        $this->{$value . '_List'} = $this->model->select($value);
      }
      $this->tableName = $this->param->page_type;
      if ($this->param->action == 'available_date') {
        $this->thisWeekCondition = "(YEARWEEK( availableDate, 1 ) = YEARWEEK( CURDATE( ) , 1 )) OR (YEARWEEK( notAvailableDate, 1 ) = YEARWEEK( CURDATE( ) , 1 ))";
        $this->thisMonthCondition = "(YEAR(availableDate) = YEAR(CURDATE()) AND MONTH(availableDate) = MONTH(CURDATE())) OR (YEAR(notAvailableDate) = YEAR(CURDATE()) AND MONTH(notAvailableDate) = MONTH(CURDATE()))";
      }
    }
    
    function getBasicFunction($tableName)
    {
      $this->keyword = $_POST['keyword'];
      $this->order = $_POST['order'];
      $this->direction = $_POST['direction'];
      
      if (isset($_POST['filter'])) {
        switch ($_POST['filter']) {
          case 'all':
            $condition[] = $this->defaultCondition;
            break;
          case 'activated':
            $condition[] = $this->activatedCondition;
            break;
          case 'imminent':
            $condition[] = $this->imminentCondition;
            break;
          case 'deactivated':
            $condition[] = $this->deactivatedCondition;
            break;
          case 'deleted':
            $condition[] = $this->deletedCondition;
            break;
        }
      } else {
        $_POST['filter'] = 'activated';
        $condition[] = $this->activatedCondition;
      }
      if (isset($_POST['keyword']) && $_POST['keyword'] != "") {
        $condition[] = " (`{$tableName}Name` LIKE '%{$this->keyword}%' OR `address` LIKE '%{$this->keyword}%' OR `detail` LIKE '%{$this->keyword}%') ";
      }
      $order = ($_POST['order']) ? $_POST['order'] : $this->param->page_type . "ID";
      $direction = ($_POST['direction']) ? $_POST['direction'] : "DESC";
      $this->list = $this->model->getList($condition, $order, $direction);
      //초기화 테스트
      $this->initJoin($tableName);
      $this->list = $this->initActCondition($this->list, $tableName);
      $this->list = $this->getActCondition($this->list, $tableName);
    }
    
    function getCallTable()
    {
      $sql = "SELECT * FROM `call`";
      $table = $this->param->page_type;
      if (in_array($table, ['company', 'employee'])) $sql .= " WHERE `{$table}ID` = '{$this->param->idx}' ";
      $sql.= " ORDER BY `workDate` ASC";
      return $this->model->getTable($sql);
    }
    
    function getBlackList()
    {
      $tbl = $this->tableName;
      return $this->model->getTable("SELECT * FROM `blackList` WHERE `{$tbl}ID` = '{$this->param->idx}' ");
    }
    
    function get_fixType($data)
    {
      if ($data['fixID'] > 0) {
        if ($this->model->select('fix', "`fixID`='{$data['fixID']}'", 'monthlySalary') > 0) {
          return '(월급)';
        } else {
          return '(고정)';
        }
      }
    }
    
    function getClass($data)
    {
      if ($data['deleted'] == 0) {
        if ($data['activated'] == 1) {
          if ($data['imminent'] == 1 OR $data['bookmark'] == 1) {
            return 'imminent';
          } else {
            return null;
          }
        } else {
          if ($data['bookmark'] == 1) {
            return 'imminent';
          } else {
            return 'deactivated';
          }
        }
      } else return 'deleted';
    }
    
  }