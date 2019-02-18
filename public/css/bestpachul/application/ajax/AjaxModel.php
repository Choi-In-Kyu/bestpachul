<?php
  require_once '../config/lib.php';
  require_once '../config/db.php';
  require_once '../model/model.php';
  
  class AjaxModel
  {
    public $param;
    public $db;
    public $sql;
    public $companyID;
    
    public function __construct($param)
    {
      $this->param = $param;
      $this->db = new PDO("mysql:host=" . _SERVERNAME . ";dbname=" . _DBNAME . "", _DBUSER, _DBPW);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->db->exec("set names utf8");
    }
    
    public function query($sql)
    {
      $this->sql = $sql;
      $res = $this->db->prepare($this->sql);
      if ($res->execute()) {
        return $res;
      } else {
        echo $this->sql;
      }
    }
    
    public function fetch()
    {
      return $this->query($this->sql)->fetch();
    }
    
    public function executeSQL($string)
    {
      $this->sql = $string;
      $this->fetch();
    }
    
    public function fetchAll()
    {
      return $this->query($this->sql)->fetchAll();
    }
    
    public function getTable($sql)
    {
      $this->sql = $sql;
      return $this->fetchAll();
    }
    
    public function count()
    {
      return $this->query($this->sql)->rowCount();
    }
    
    public function getList($conditionArray = null, $order = null)
    {
      $this->sql = "SELECT * FROM {$this->param->page_type}";
      if (isset($conditionArray)) $getCondition = " WHERE " . implode(" AND ", $conditionArray);
      else $getCondition = " WHERE deleted = 0";
      $this->sql .= $getCondition;
      if (isset($order) && $order != "") $this->sql .= " ORDER BY {$order}";
      return $this->fetchAll();
    }
    
    public function getListNum($conditionArray = null)
    {
      return sizeof($this->getList($conditionArray));
    }
    
    public function getColumnList($array, $column)
    {
      foreach ($array as $key => $value) {
        $result[] = $value[$column];
      }
      if (isset($result)) return $result;
      else return null;
    }
    
    public function select($table, $condition = null, $column = null, $order = null)
    {
      $sql = "SELECT * FROM `{$table}` ";
      if (isset($condition)) $sql .= "WHERE $condition ";
      if (isset($order)) $sql .= "ORDER BY '{$order}' ASC ";
      if (isset($column)) return $this->getTable($sql)[0][$column];
      else return $this->getTable($sql);
    }
    
    public function getAllColumns($tableName)
    {
      $columnTable = $this->getTable("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'{$tableName}'");
      foreach ($columnTable as $value) {
        foreach ($value as $item) {
          $columnList[] = $item;
        }
      }
      return $columnList;
    }
    
    public function insert($table, $post)
    {
      $columns = array();
      $values = array();
      $columnList = $this->getAllColumns($table);
      foreach ($post as $key => $value) {
        if (!in_array($key, $columnList)) {
          unset($post[$key]);
        }
      }
      foreach (array_keys($post) as $item) {
        $columns[] = "`" . $item . "`";
      }
      foreach ($post as $value) {
        $values[] = "'" . $value . "'";
      }
      $columnString = implode(',', $columns);
      $valueString = implode(',', $values);
      $sql = "INSERT INTO `{$table}` ({$columnString}) VALUES ($valueString)";
      $this->executeSQL($sql);
    }
    
    public function joinType($companyID, $lang = null, $date = null)
    {
      $condition['id'] = " companyID = {$companyID} ";
      $condition['gujwa'] = " activated =1 AND price >0 AND  `point` IS NULL ";
      $condition['point'] = " activated =1 AND price >0 AND  `point` IS NOT NULL ";
      $condition['deposit'] = " activated =1 AND deposit >0 ";
      $kor_value = ["gujwa" => "구좌", "point" => "포인트", "deposit" => "보증금+콜비"];
      $result = array();
      foreach (['gujwa', 'point', 'deposit'] as $value) {
        if ($date) {
          $condition['date'] = ($value == 'gujwa') ? " `startDate`<= '{$date}' AND `endDate` >= '{$date}'" : " `startDate`<= '{$date}'";
        }
        $sql = "SELECT * FROM  `join_company` WHERE " . implode(' AND ', [$condition['id'], $condition[$value], $condition['date']]) . " ORDER BY `endDate` DESC ";
        ${$value . 'Table'} = $this->getTable($sql);
        if (sizeof(${$value . 'Table'}) > 0) {
          $result['joinType'] = ($lang == 'kor') ? $kor_value[$value] : $value;
          $result['endDate'] = ($value == 'gujwa') ? ${$value . 'Table'}[0]['endDate'] : null;
          $result['size'] = sizeof(${$value . 'Table'});
          break;
        }
      }
      //만기된 업체의 경우
      if ($result['joinType'] == null) {
        $result['error'] = '가입 내역이 없습니다.';
        $result['size'] = 0;
      } //check call type
      else {
        switch ($result['joinType']) {
          case 'gujwa':
          case '구좌':
            $score = ($this->isHoliday($date)) ? 10000 : 8000;
            $total = $score + $this->thisWeekScore($companyID, $date);
            $result['total'] = $total;
            if ($total <= 26000 * $result['size']) {
              $result['callType'] = 'gujwa_free';
              break;
            } else {
              $result['callType'] = 'gujwa_charged';
              $result['callPrice'] = 6000;
              break;
            }
            break;
          case 'point':
          case '포인트':
            $point = ($this->isHoliday($date)) ? 8000 : 6000;
            $totalPoint = 0;
            foreach ($this->getTable($sql) as $value) {
              $totalPoint += $value['point'];
            }
            $result['callType'] = ($totalPoint >= $point) ? 'point_free' : 'pointExceed';
            break;
          case 'deposit':
          case '보증금+콜비':
            $result['callType'] = 'charged';
            $result['callPrice'] = $this->isHoliday($date) ? 10000 : 8000;
            break;
          default:
            $result['callType'] = 'error';
            $result['callPrice'] = 'error';
            break;
        }
      }
      return $result;
    }
    
    public function isHoliday($date)
    {
      if (in_array(date('w', strtotime($date)), [0, 6])) {
        return true;
      } elseif (sizeof($this->getTable("SELECT * FROM `holiday` where holiday = '{$date}'")) > 0) {
        return true;
      } else {
        return false;
      }
    }
    
    public function call($post)
    {
      if ($post['monthlySalary'] > 0) {
        unset ($post['salary']);
      }
      $companyID = $post['companyID'];
      $point = $post['point'];
      $this->insert('call', $post);
//      if ($this->joinType($companyID)['joinType'] == 'point') {
//        $sql = "UPDATE join_company SET point = point-'{$point}' WHERE companyID = '{$companyID}' LIMIT 1";
//        $this->executeSQL($sql);
//      }
    }
    
    public function cancel($post)
    {
      $callID = $post['callID'];
      $companyID = $post['companyID'];
      $callData = $this->select('call', "callID = {$callID}")[0];
      $point = $callData['point'];
      if (isset($point)) {
        $this->executeSQL("UPDATE join_company SET point = point+'{$point}' WHERE companyID = '{$companyID}' LIMIT 1");
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$callID}' LIMIT 1");
      } else {
        $this->executeSQL("UPDATE `call` SET `cancelled` = 1 WHERE `callID` = '{$callID}' LIMIT 1");
      }
    }
    
    public function reset($post)
    {
      $id = $post['companyID'];
      $date = $post['workDate'];
      $all_call = $this->getTable("SELECT * FROM `call` WHERE `companyID`='{$id}' AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$date}' , 1 ) AND `cancelled`=0");
      $gujwaList = $this->getTable("SELECT * FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND endDate >= '{$date}' AND `activated` = 1 AND deleted = 0");
      $max = 26000 * sizeof($gujwaList);
      $sum = 0;
      #모든 콜을 무료 콜로 초기화
      $this->executeSQL("UPDATE `call` SET `price`=NULL WHERE `companyID` = '{$this->companyID}'  AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$post['workDate']}' , 1 ) AND `cancelled`=0");
      //모든 콜에 대해 평일/주말로 나눔
      foreach ($all_call as $value) {
        if ($this->isHoliday($value['workDate'])) {
          $holiday_call[] = $value['callID'];
        } else {
          $weekday_call[] = $value['callID'];
        }
      }
      //평일 콜 먼저 무료-유료 순으로 채우기
      foreach ($weekday_call as $value) {
        $sum += 8000;
        if ($sum <= $max) $this->executeSQL("UPDATE `call` SET `price`=0 WHERE `callID` = '{$value}' LIMIT 1");
        else $this->executeSQL("UPDATE `call` SET `price`= '6000' WHERE `callID` = '{$value}' LIMIT 1");
      }
      //주말 콜 무료-유료 순으로 채우기
      foreach ($holiday_call as $value) {
        $sum += 10000;
        if ($sum <= $max) $this->executeSQL("UPDATE `call` SET `price`=0 WHERE `callID` = '{$value}' LIMIT 1");
        else $this->executeSQL("UPDATE `call` SET `price`= '6000' WHERE `callID` = '{$value}' LIMIT 1");
      }
    }
    
    public function getWeekDates($date)
    {
      $i = date('w', strtotime($date));
      if ($i == 0) {
        $i += 7;
      }
      for ($cnt = $i - 1; $cnt > 0; --$cnt) {
        $arr[] = date('Y-m-d', strtotime($date . ' - ' . $cnt . ' day'));
      }
      $arr[] = $date;
      for ($cnt2 = 1; $cnt2 <= (7 - $i); ++$cnt2) {
        $arr[] = date('Y-m-d', strtotime($date . ' + ' . $cnt2 . ' day'));
      }
      return $arr;
    }
    
    public function thisWeekScore($id, $date)
    {
      $sum = 0;
      $sql = "SELECT `workDate` FROM  `call` WHERE `companyID` ='{$id}' AND YEARWEEK( workDate, 1 ) = YEARWEEK( '{$date}' , 1 ) AND `cancelled`=0 AND (price IS NULL OR price = 0)";
      $list = $this->getTable($sql);
      foreach ($list as $key => $value) {
        if ($this->isHoliday($value['workDate'])) {
          $sum += 10000;
        } else {
          $sum += 8000;
        }
      }
      return $sum;
    }

//    public function checkCallType($id, $date)
//    {
//      $joinType = $this->joinType($id,$date);
//      switch ($joinType) {
//        case 'gujwa':
//          $sql = "SELECT * FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND endDate >= '{$date}' AND `activated` = 1 AND deleted = 0";
//          $gujwaList = $this->getTable($sql);
//          if ($this->isHoliday($date)) {
//            $score = 10000;
//          } else {
//            $score = 8000;
//          }
//          $total = $score + $this->thisWeekScore($id, $date);
//          if ($total <= 26000 * sizeof($gujwaList)) return ['free', $total];
//          else return ['charged', $total];
//          break;
//        case 'point':
//          if ($this->isHoliday($date)) $point = 8000;
//          else $point = 6000;
//          $totalPoint = 0;
//          $sql = "SELECT point FROM `join_company` WHERE companyID = '{$id}' AND startDate <= '{$date}' AND `activated` = 1 AND deleted = 0 AND point>0";
//          foreach ($this->getTable($sql) as $value) {
//            $totalPoint += $value['point'];
//          };
//          if ($totalPoint >= $point) return ['free', null];//무료
//          else return ['pointExceed', null];//유료
//          break;
//        case 'deposit':
//          return ['charged', null];
//          break;
//        default:
//          break;
//      }
//    }
    
    public function fix($post)
    {
      $dow = $post['dow'];
      $post['dayofweek'] = implode(',', $post['dow']);
      $start = new DateTime($post['workDate']);
      $end = new DateTime($post['endDate']);
      for ($i = 0; $i < sizeof($dow); $i++) {//모든 date 추출
        $start->modify($dow[$i]);
        $interval = new DateInterval("P1W");
        $period = new DatePeriod($start, $interval, $end);
        foreach ($period as $date) {
          $dateArray[] = $date->format('Y-m-d');
        }
        $result['dateArray'] = $dateArray;
      }
      $this->insert('fix', $post);
      $fixID = intval($this->getTable("SELECT * FROM `fix` ORDER BY `fixID` DESC LIMIT 1")[0]['fixID']);
      if (isset($fixID)) {
        $result['fixID'] = $fixID;
      } else $result['fixID'] = 1;
      
      return json_encode($result);
    }
    
    public function getMoney($post)
    {
      $table = $post['table'];
      $id = $post['id'];
      $receiver = $post['receiver'];
      $sql = "UPDATE `{$table}` SET `paid` = '1', `receiver` = '{$receiver}' WHERE `{$table}ID` = '{$id}'";
      $this->executeSQL($sql);
    }
    
    public function toggleFilter($post)
    {
      $result['post'] = $post;
      
      $result['test'] = json_encode($post['duration']);
      
      $sql = "SELECT `callID` FROM `call`";
      if (isset($post['duration'])) {
        $condition[] = "(" . implode(' OR ', $post['duration']) . ")";
      }
      if (isset($post['date']) && $post['date'] != '') {
        $condition = null;
        $condition[] = " (`workDate` = '{$post['date']}') ";
      }
      if (isset($post['charged'])) {
        $condition[] = "(" . implode(' OR ', $post['charged']) . ")";
      }
      if (isset($post['fixed'])) {
        $condition[] = "(" . implode(' OR ', $post['fixed']) . ")";
      }
      if (isset($condition)) {
        $sql .= " WHERE ";
      }
      $sql .= implode(' AND ', $condition);
      
      $result['sql'] = (string)$sql;
      
      $result['arr'] = [];
      if ($this->getTable($sql)) {
        foreach ($this->getTable($sql) as $value) {
          foreach ($value as $item) {
            $result['arr'][] = intval($item);
          }
        }
      }
      return json_encode($result);
    }
    
    public function availableFilter($post)
    {
      $year_condition = " YEAR(`availableDate`) = YEAR(CURDATE()) OR YEAR(`notAvailableDate`) = YEAR(CURDATE())";
      $month_condition = " (YEAR(`availableDate`) = YEAR(CURDATE()) AND (MONTH(`availableDate`) = MONTH(CURDATE()))) OR (YEAR(`notAvailableDate`) = YEAR(CURDATE()) AND (MONTH(`notAvailableDate`) = MONTH(CURDATE())))";
      $week_condition = " YEARWEEK(`availableDate`) = YEARWEEK(CURDATE(),1) OR YEARWEEK(`notAvailableDate`) = YEARWEEK(CURDATE(),1)";
      $result['post'] = $post;
      $sql = "SELECT `availableDateID` FROM `employee_available_date`";
      if ($post['duration']) {
        $post['date'] = null;
        switch ($post['duration']) {
          case 'year':
            $condition = $year_condition;
            break;
          case 'month':
            $condition = $month_condition;
            break;
          case 'week':
            $condition = $week_condition;
            break;
        }
      } else {
        $condition = " `availableDate` = '" . _TODAY . "' OR `notAvailableDate` = '" . _TODAY . "' ";
      }
      if ($post['date']) {
        $condition = " (`availableDate` = '{$post['date']}') OR (`notAvailableDate` = '{$post['date']}')";
      }
      $sql .= " WHERE " . $condition;
      $result['sql'] = $sql;
      foreach ($this->getTable($sql) as $value) {
        foreach ($value as $item) {
          $result['arr'][] = intval($item);
        }
      }
      return $result;
    }
    
    
    public function workTimeType($data)
    {
      $start = $data['startTime'];
      $end = $data['endTime'];
      $workTime = $end - $start;
      if ($workTime >= 10) $result = '종일';
      else {
        if ($start < 12) $result = '오전'; else $result = '오후';
      }
      return $result;
    }
    
    public function getIDTable($list, $int = false)
    {
      foreach ($list as $value) {
        foreach ($value as $item) {
          if ($int == true) {
            $arr[] = intval($item);
          } else {
            $arr[] = $item;
          }
        }
      }
      return $arr;
    }
    
    public function timeType($data)
    {
      $start = $data['startTime'];
      $end = $data['endTime'];
      $workTime = $end - $start;
      if ($workTime >= 10) $result = '종일';
      else {
        if ($start < 12) $result = '오전'; else $result = '오후';
      }
      return $result . ' (' . date('H:i', strtotime($data['startTime'])) . "~" . date('H:i', strtotime($data['endTime'])) . ')';
    }
    
    public function assignFilter($post)
    {
      $callID = $post['id'];
      $callData = $this->getTable("SELECT * FROM `call` WHERE `callID` = {$callID}")[0];
      $companyID = $callData['companyID'];
      $workDate = $callData['workDate'];
      $workField = $callData['workField'];
      $day = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
      $workDay = $day[date('w', strtotime($workDate))];
      $startTime = $callData['startTime'];
      $endTime = $callData['endTime'];
      
      $condition['만기'] = "(`activated` = '1')";
      $condition['블랙'] = "(`employeeID` not in (select `employeeID` from `blackList` WHERE `companyID` = '{$companyID}'))";
      $condition['근무불가능일'] = "(`employeeID` not in (SELECT `employeeID` FROM `employee_available_date` WHERE (notAvailableDate = '{$workDate}')))";
      $condition['중복'] = "(`employeeID` not in (SELECT `employeeID` FROM `call` WHERE (employeeID is not null) AND (workDate ='{$workDate}') AND ('{$startTime}' < `endTime` AND '{$endTime}'>`startTime`) ))";
      if ($workField == '설거지') {
        $condition['업종'] =
          "(`workField1` = '{$workField}' OR `workField2` = '{$workField}' OR `workField3` = '{$workField}') OR `workField1` = '주방보조' OR `workField2` = '주방보조' OR `workField3` = '주방보조' ";
      } else {
        $condition['업종'] = "(`workField1` = '{$workField}' OR `workField2` = '{$workField}' OR `workField3` = '{$workField}')";
      }
      $type = $this->workTimeType($callData);
      switch ($type) {
        case '오전':
          $condition['요일'] = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '오전' || `{$workDay}` = '종일' || `{$workDay}` = '반반')))";
          break;
        case '오후':
          $condition['요일'] = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '오후' || `{$workDay}` = '종일' || `{$workDay}` = '반반')))";
          break;
        case '종일':
          $condition['요일'] = "(`employeeID` in (SELECT `employeeID` FROM `employee_available_day` WHERE (`{$workDay}` = '종일' )))";
          break;
      }
      $condition['최적'] = "(`employeeID` not in (SELECT `employeeID` FROM `employee_available_date` WHERE (availableDate = '{$workDate}')))";
      
      $employeeList = $this->getIDTable($this->getTable("SELECT `employeeID` FROM `employee`"));
      
      foreach ($condition as $value) {
        $conditionArray[] = $this->getIDTable($this->getTable("SELECT `employeeID` FROM `employee` WHERE `deleted`='0' AND {$value}"));
      }
      //employeeList의 value:employeeID, key:배열 인덱스
      //일부 DB 삭제로 인해 employeeID와 인덱스 간 차이가 있음
      foreach ($employeeList as $value) {
        for ($i = 0; $i < sizeof($conditionArray); $i++) {
          if (!in_array($value, $conditionArray[$i])) {
            $result[$value] = array_keys($condition)[$i];
            break 1;
          } else {
            $result[$value] = '적합';
            continue;
          }
        }
      }
      //result의 key: employeeID, value: 배정 불가 사유
      foreach ($result as $key => $value) {
        if ($value == '최적') {
          $group0[$key] = $value;
        }
        if ($value == '적합') {
          $group1[$key] = $value;
        }
        if (in_array($value, ['요일', '업종', '중복'])) {
          $group2[$key] = $value;
        }
        if ($value == '만기') {
          $deactivated[] = $value;
          $group3Array = $this->getIDTable($this->getTable("SELECT `employeeID` FROM `employee` WHERE `activated`='0' AND `bookmark`='1'"), true);
          if (in_array($key, $group3Array)) {
            $group3[$key] = sizeof($group3Array);
          }
        }
      }
      $return = "";
      $status = "배정가능 인력<br/> 1군(" . (sizeof($group1) + sizeof($group0)) . "명) 2군(" . sizeof($group2) . "명) 3군(" . sizeof($group3) . "명)";
      $return .= <<<HTML
<tr><td colspan="6"><strong>{$status}</strong></td></tr>
HTML;
      for ($i = 0; $i <= 3; $i++) {
        if (${'group' . $i}) {
          $group_name = ($i == 0) ? '추천' : ($i . '군');
          $recommend = ($i == 0) ? 'recommend' : null;
          $return .= <<<HTML
<tr class="assign-employee {$recommend}">
<th>{$group_name}</th>
<th>인력명</th>
<th>간단주소</th>
<th>배정</th>
<th>비고</th>
<th>주간배정</th>
</tr>
HTML;
          foreach (${'group' . $i} as $key => $value) {
            $employeeData = $this->getTable("SELECT * FROM `employee` WHERE `employeeID` = '{$key}'")[0];
            $week_assign_count = sizeof($this->getTable("SELECT * FROM `call` WHERE `employeeID` = '{$key}' AND  YEARWEEK( workDate, 1 ) = YEARWEEK( '{$workDate}',1) "));
            $return .= <<<HTML
<tr class="assign-employee {$recommend}">
<td class="al_c">{$key}</td>
<td class="al_l ellipsis" title="{$employeeData['employeeName']}">{$employeeData['employeeName']}</td>
<td class="al_l">{$employeeData['address']}</td>
<td class="al_c"><button type="button" class="btn btn-small btn-submit assignBtn" id="{$employeeData['employeeID']}">배정</button></td>
<td class="al_c">{$value}</td>
<td class="al_c">{$week_assign_count}회</td>
</tr>
HTML;
          }
        }
      }
      return $return;
    }
    
    public function getClass($data)
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
    
    public function assign($post)
    {
      $callID = $post['callID'];
      $employeeID = $post['employeeID'];
      $sql = "UPDATE `call` SET `employeeID` = '{$employeeID}' WHERE `callID` = '{$callID}' ";
      $this->executeSQL($sql);
      
      return <<<HTML
<a class="assignCancelBtn link" id="{$employeeID}">{$this->select('employee', "`employeeID` = '{$employeeID}'", 'employeeName')}</a>
HTML;
    
    
    }
    
    public function callFilter($post)
    {
      $result = "";
      foreach ($this->getTable("SELECT * FROM `call` WHERE `fixID` = '{$post['id']}'") as $key => $data) {
        iF ($data['cancelled'] == 0) {
          $cancelled = '삭제됨';
        } else {
          $cancelled = '삭제';
        }
        $dayofweek = ['일', '월', '화', '수', '목', '금', '토'];
        $employeeName = $this->select('employee', "employeeID = '{$data['employeeID']}'", 'employeeName');
        
        if (($data['cancelled'] == 0)) {
          $cancelled = <<<HTML
<button type="button" class="btn-call-cancel-modal btn btn-small btn-danger" id="{$data['callID']}">취소</button>
HTML;
        } else {
          $cancelled = "(취소됨)";
        }
        $result .= <<<HTML
<tr class="selectable callRow ">
  <td class="al_c">{$data['callID']}</td>
  <td class="al_l">{$data['workDate']}({$dayofweek[date('w', strtotime($data['workDate']))]})</td>
  <td class="al_l">{$this->timeType($data)}</td>
  <td class="al_c assignedEmployee"></td>
  <td class="al_c assignedEmployee">
    <a class="assignCancelBtn link" id = "{$data['callID']}">{$employeeName}</a>
  </td>
  <td class="al_c">{$cancelled}</td>
</tr>
HTML;
      }
      return $result;
    }
    
    public function fetchCallTable($post)
    {
      $companyID = $post['companyID'];
      $year = (isset($post['year']) && $post['year'] != '') ? $post['year'] : date('Y');
      $month = (isset ($post['month']) && $post['month'] != '') ? $post['month'] : date('n');
      $sql = "SELECT * FROM `call` WHERE `companyID` = {$companyID} AND YEAR(workDate) = {$year} AND MONTH(workDate) = {$month}";
      if ($post['type'] == 'paid') {
        $sql .= " AND `price` > 0";
      }
      $priceTable = $this->getTable($sql . " AND `cancelled` = 0");
      $total = 0;
      foreach ($priceTable as $key => $value) {
        $total += $value['price'];
      }
      $sql .= " ORDER BY `workDate` ASC ";
      $table = $this->getTable($sql);
      $result = "";
      foreach ($table as $key => $value) {
        $dayofweek = ['일', '월', '화', '수', '목', '금', '토'];
        $date = date('m/d', strtotime($value['workDate'])) . "(" . $dayofweek[date('w', strtotime($value['workDate']))] . ")";
        $employeeName = $this->select('employee', "`employeeID`='{$value['employeeID']}'", 'employeeName');
        $start = date('H:i', strtotime($value['startTime']));
        $end = date('H:i', strtotime($value['endTime']));
        $cancel = ($value['cancelled'] == 1) ? '(취소됨)' : null;
        $class = ($value['cancelled'] == 1) ? 'cancelled' : null;
        $price = ($value['price'] > 0) ? number_format($value['price']) : '-';
        $employee = ($value['employeeID'] > 0) ? $employeeName : null;
        if ($value['cancelled'] == 1 || ($value['employeeID'] > 0)) {
          $btn = null;
        } else {
          $btn = "<button type=\"button\" id=\"{$value['callID']}\" class=\"btn btn-call-cancel-modal\">취소</button>";
        }
        $result .= <<<HTML
<tr class="tr-call {$class}" id="{$value['callID']}">
                <td class="workDate">{$date} </td>
                <td>{$start}~{$end}</td>
                <td>{$value['workField']}</td>
                <td class="price">{$price}</td>
                <td class="al_c">{$cancel}{$employee}{$btn}</td>
            </tr>
HTML;
      }
      return [$result, $total];
    }
    
    public function callCancel($post)
    {
      $callData = $this->select('call', "callID = '{$post['callID']}'")[0];
      $companyID = $callData['companyID'];
      if ($callData['point'] > 0) {
        $this->executeSQL("UPDATE join_company SET point = point+'{$callData['point']}' WHERE companyID = '{$companyID}' LIMIT 1");
        $this->executeSQL("UPDATE `call` SET `employeeID` = NULL, `cancelled` = 1, `cancelDetail` = '{$post['detail']}' WHERE `callID` = '{$post['callID']}' LIMIT 1");
      } else {
        $sql = "UPDATE `call` SET `employeeID` = NULL, `cancelled` = 1, `cancelDetail` = '{$post['detail']}', `price` = 0, `salary` = 0 WHERE `callID` = '{$post['callID']}' LIMIT 1";
        $this->executeSQL($sql);
        $this->reset($post);
      }
      unset($post);
    }
  }