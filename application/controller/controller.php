<?php
  
  Class Controller
  {
//변수
    var $param;
    var $db;
    var $title;
    var $setAjax;
    
    var $condition;
    var $keyword;
    var $order;
    var $orderBy;
    var $direction;
    var $join;
    var $group;
    var $today;
    var $tomorrow;
    var $afterTomorrow;
    var $addressList;
    var $workFieldList;
    var $day;
    
    public $defaultCondition    = array("filter" => " (deleted = 0) ");
    public $activatedCondition  = array("filter" => " (activated = 1 AND deleted = 0) ");
    public $expiredCondition    = array("filter" => " (activated = 0 AND deleted = 0) ");
    public $deletedCondition    = array("filter" => " (activated = 0 AND deleted = 1) ");

//생성자
    function __construct($param)
    {
      header("Content-type:text/html;charset=utf8");
      $this->param = $param;
      $modelName = "Model_{$this->param->page_type}";
      $this->db = new $modelName($this->param);
      $this->setAjax = false;
      //항상 index 함수를 실행
      if($this->param->page_type != 'login'){$this->index();}
    }
    
//모든 페이지에서 쓰이는 변수
    function getFunctions(){
      $this->workFieldList = $this->db->getTable("SELECT * FROM `workField`");
      $this->addressList = $this->db->getTable("SELECT * FROM `address`");
      $this->day = array('일','월','화','수','목','금','토');
    }

//index
    function index()
    {
      //따로 action 파라미터가 없으면 method == basic
      $method = isset($this->param->action) ? $this->param->action : 'basic';
      //basic 메소드를 포함한 메소드 실행
      if (method_exists($this, $method)) $this->$method();
      $this->title = '으뜸 파출';
      if ($this->param->page_type !='ceo') $this->setAjax || require_once(_VIEW . "header.php");
      $this->content();
      if ($this->param->page_type !='ceo') $this->setAjax || require_once(_VIEW . "footer.php");
    }

//content - ex)view/company/company.php 불러오기
    function content()
    {
      $this_arr = (array)$this;
      extract($this_arr);
      //page의 action이 없으면 page type의 이름을 가진 view 불러옴
      $dir = _VIEW . "{$this->param->page_type}/{$this->param->include_file}.php";
      if (file_exists($dir)) require_once($dir);
    }
    
    function initJoin($tableName)
    {
      $joinList = $this->db->getTable("SELECT * FROM join_{$tableName}");
      $today = date("Y-m-d");
      foreach ($joinList as $key => $value) {
        $endDate = $value['endDate'];
        $joinID = "join_" . $tableName . "ID";
        $joinID = $value[$joinID];
        if ($today > $endDate) {
          $this->db->executeSQL("UPDATE join_{$tableName} SET activated = 0 WHERE join_{$tableName}ID = {$joinID} LIMIT 1");
        }
      }
    }
    
    function initActCondition($list, $tableName)
    {
      $this->db->executeSQL("UPDATE join_{$tableName} SET activated = 0 WHERE endDate < CURDATE()");
      $today = date("Y-m-d");
      foreach ($list as $key => $value) {
        $tableID = $tableName . "ID";
        $tableID = $value[$tableID];
        $joinList = $this->db->getTable("SELECT * FROM `join_{$tableName}` WHERE {$tableName}ID = {$tableID}");
        if ($joinList == null) {
          $this->db->executeSQL("UPDATE {$tableName} SET activated = 0 WHERE {$tableName}ID = {$tableID} LIMIT 1");
        }
        foreach ($joinList as $key => $value) {
          $endDate = $value['endDate'];
          if ($today > $endDate) {
            $this->db->executeSQL("UPDATE {$tableName} SET activated = 0 WHERE {$tableName}ID = {$tableID} LIMIT 1");
            continue;
          } else {
//            if($value['deleted']!=1){
            $this->db->executeSQL("UPDATE {$tableName} SET activated = 1 WHERE {$tableName}ID = {$tableID} LIMIT 1");
            break;
//            }
          }
        }
      }
      return $list;
    }
    
    function getActCondition($list, $tableName)
    {
      $deadlineArray = $this->db->getColumnList($this->db->getList($this->deadlineCondition, null, $this->deadlineJoin, $this->deadlineGroup), $tableName . 'ID');
      $expiredArray = $this->db->getColumnList($this->db->getList($this->expiredCondition), $tableName . 'ID');
      $deletedArray = $this->db->getColumnList($this->db->getList($this->deletedCondition), $tableName . 'ID');
      foreach ($list as $key => $value) {
        $tableID = $tableName . 'ID';
        $tableID = $list[$key][$tableID];
        if (in_array($tableID, $deadlineArray)) {
          $actCondition = "만기임박";
          $color = "orange";
        } elseif (in_array($tableID, $expiredArray)) {
          $actCondition = "만기됨";
          $color = "pink";
        } elseif (in_array($tableID, $deletedArray)) {
          $actCondition = "삭제됨";
          $color = "gray";
        } else {
          $actCondition = "가입중";
          $color = null;
        }
        $list[$key]['actCondition'] = $actCondition;
        $list[$key]['color'] = $color;
      }
      return $list;
    }
    
    function getBasicFunction($tableName)
    {
      $this->join = $_POST['join'];
      $this->keyword = $_POST['keyword'];
      $this->order = $_POST['order'];
      $this->group = $_POST['group'];
      $this->direction = $_POST['direction'];
      //condition - 필터링, 검색, 정렬 기능
      if (isset($_POST['filterCondition'])) {
        $this->condition['filter'] = $_POST['filterCondition'];
      } else {
        $this->condition['filter'] = $this->defaultCondition['filter'];
      }
      if (isset($_POST['keyword']) && $_POST['keyword'] != "") {
        $this->condition['keyword'] = " (`{$tableName}Name` LIKE '%{$this->keyword}%' OR `address` LIKE '%{$this->keyword}%') ";
      }
      //order
      if (isset($this->direction) && isset($this->order)) {
        if ($this->direction == "ASC") $this->direction = "DESC";
        else $this->direction = "ASC";
        if (isset($this->order) && $this->order != "")
          $this->orderBy = " {$_POST['order']} {$_POST['direction']}";
      }
      //get list
      $this->list = $this->db->getList($this->condition, $this->orderBy, $this->join, $this->group);
      $this->list = $this->initActCondition($this->list, $tableName);
      $this->list = $this->getActCondition($this->list, $tableName);
      
      
      //filter color
      switch ($this->condition['filter']) {
        case $this->defaultCondition['filter']:
          $this->filterBgColor['default'] = "white";
          $this->filterColor['default'] = "black";
          break;
        case $this->activatedCondition['filter']:
          $this->filterBgColor['activated'] = "ivory";
          $this->filterColor['activated'] = "black";
          break;
        case $this->deadlineCondition['filter']:
          $this->filterBgColor['deadline'] = "orange";
          $this->filterColor['deadline'] = "black";
          break;
        case $this->expiredCondition['filter']:
          $this->filterBgColor['expired'] = "pink";
          $this->filterColor['expired'] = "black";
          break;
        case $this->deletedCondition['filter']:
          $this->filterBgColor['deleted'] = "gray";
          break;
      }
    }
    
    function get_joinType($data)
    {
      if (isset($data['deposit'])) return "보증금+콜비";
      elseif (isset($data['point'])) return "포인트";
      elseif (isset($data['price'])) return "구좌";
    }
    
    function get_joinPrice($data)
    {
      switch ($this->get_joinType($data)) {
        case '구좌':
          echo number_format($data['price']) . " 원";
          break;
        case '보증금+콜비':
          echo number_format($data['deposit']) . " 원 (보증금)";
          break;
        case '포인트':
          echo number_format($data['point']) . " 원 (포인트)";
          break;
      }
    }
    
    function get_endDate($data)
    {
      $condition1 = strtotime($data['endDate'] . " -15 days") < strtotime(date('Y-m-d'));
      $condition2 = strtotime(date('Y-m-d')) < strtotime($data['endDate']);
      $string = $data['endDate'];
      $leftDays = date('j', strtotime($data['endDate']) - strtotime(date('Y-m-d'))) - 1;
      if ($condition1 && $condition2) {
        $string .= " (D-{$leftDays})";
      }
      return $string;
    }
    
    function get_joinDetail($data)
    {
      echo $data['detail'];
      if ($data['deleted'] == 1) echo "<br/>(삭제사유: " . $data['deleteDetail'] . ")";
      elseif ($data['deleted'] == 0 && $data['activated'] == 0) {
        echo "<br/>(가입 만기됨)";
      }
    }
    
    function get_joinDeleteBtn($data, $tableName)
    {
      if ($data['activated'] == 1) {
        $id = "join_" . $tableName . "ID";
        return "<button id = \"myBtn\" class=\"btnModal\" value = \"{$data[$id]}\" > X</button>";
      } else {
        return $data['deletedDate'];
      }
    }
    
    function get_deleteBtn($data, $tableName)
    {
      $tableID = $tableName . "ID";
      if ($data['deleted'] == 0) {
        return <<<HTML
          <button id="myBtn" class="btnModal" value="{$data[$tableID]}">X</button>
HTML;
      } else {
        return <<<HTML
        <form action="" method="post">
              <input type="hidden" name="action" value="restore">
              <input type="hidden" name="{$tableID}" value="{$data[$tableID]}">
              <input class="btn" type="submit" value="복구">
        </form>
HTML;
      }
    }
    
    function get_paidBtn($data)
    {
      if ($data['paid'] == 0) {
        return <<<HTML
          <form action= "" method="post">
              <input type="hidden" name="action" value="getMoney">
              <input type="hidden" name="joinID" value="{$data['join_employeeID']}">
              <input class="btn" type="submit" value="수금">
          </form>
HTML;
      } else return "수금완료";
    }
    
    function makeDetail($array)
    {
      foreach ($array as $key => $value) {
        $value .= " : ";
        $newArray[] = $value;
      }
      $string = implode("\n", $newArray);
      return $string;
    }
    
    function get_detail($data, $tableName)
    {
      $companyDetail = array('좌탁여부', '테이블수', '그릇종류', '식기세척기', '상주직원수', '주방환경', '교통환경', '주요업무', '가입경로', '기타사항');
      $employeeDetail = array('경력', '특기', '체류비자', '월급제', '4대보험', '자차소유', '추천인', '외모', '이상여부', '지각', '빵꾸', '기타사항');
      if (isset($data['detail'])) {
        return $data['detail'];
      } else {
        switch ($tableName) {
          case 'company':
            return $this->makeDetail($companyDetail);
          case 'employee':
            return $this->makeDetail($employeeDetail);
        }
      }
      
    }
    
    function joinColor($data, $tableName)
    {
      $today = date('Y-m-d');
      $deadline = 15;
      if ($tableName == 'employee') $deadline = 5;
      if ($data['activated'] == 0) echo "gray";
      elseif (
        strtotime($data['endDate'] . " -{$deadline} days") < strtotime($today)
        && strtotime($today) < strtotime($data['endDate']))
        echo "orange";
    }
  }