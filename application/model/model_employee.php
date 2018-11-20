<?php
  
  Class Model_employee extends Model
  {
    function __construct($param)
    {
      parent::__construct($param);
      if(isset($_COOKIE['userID'])){
        if($_COOKIE['userID']==1){}
        else {
          alert('접근 권한이 없습니다.');
          move(_URL.'ceo');
        }
      }
      else{
        alert('로그인이 필요한 서비스입니다.');
        move (_URL.'login');
      }
    }
    
    var $tableName = "employee";
    
    function getView()
    {
      $this->sql = "SELECT * FROM `employee` WHERE employee.employeeID='{$this->param->idx}'";
      return $this->fetch();
    }
    
    function employeeDelete($post)
    {
      $deletedDate = date("Ymd");
      //인력 삭제
      if (!isset ($post['joinID'])) {
        $this->executeSQL("UPDATE employee SET deleted=1, activated=0, deletedDate= '{$deletedDate}', deleteDetail = '{$post['deleteDetail']}' WHERE employeeID = '{$post['employeeID']}'");
        $this->executeSQL("UPDATE join_employee SET deleted=1, activated=0, deletedDate= '{$deletedDate}', deleteDetail = '인력삭제({$deletedDate})' WHERE employeeID = '{$post['employeeID']}'");
      }
      //가입 삭제
      else {
        $this->executeSQL("UPDATE join_employee SET deleted=1, activated=0, deletedDate= '{$deletedDate}', deleteDetail = '{$post['deleteDetail']}' WHERE join_employeeID = '{$post['joinID']}'");
      }
    }
    
    function action()
    {
      header("Content-type:text/html;charset=utf8");
      $msg = "[SYSTEM] ";
      $url = $this->param->get_page;
      switch ($_POST['action']) {
        case 'insert' :
          $_POST['employee-employeeName'] = $this->removeDuplicate($_POST, 'employee', 'employeeName');
          $this->getQuery($_POST, 'employee');
          //join_employee 입력
          $_POST['join_employee-employeeID'] = $this->db->lastInsertId();
          $_POST['employee_available_day-employeeID'] = $this->db->lastInsertId();
          $this->getQuery($_POST, 'join_employee');
          $this->getQuery($_POST, 'employee_available_day');
          $msg .= "입력되었습니다";
          break;
        case 'update' :
          if ($_POST['employee-employeeID'] != $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$_POST['employee-employeeName']}' LIMIT 1")[0]['employeeID']) {
            $_POST['employee-employeeName'] = $this->removeDuplicate($_POST, 'employee', 'employeeName');
          }
          $this->getQuery($_POST, 'employee');
          $this->getQuery($_POST, 'employee_available_day', 'employee');
          $url .= "/view/{$this->param->idx}";
          $msg .= "수정되었습니다";
          break;
        case 'new_insert':
          $this->getQuery($_POST, 'join_employee', 'employee');
          $url .= "/view/{$this->param->idx}";
          $msg .= "추가되었습니다";
          break;
        case 'date_insert':
          $post['employee_available_date-employeeID'] = $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$_POST['employee_available_date-employeeID']}'")[0]['employeeID'];
          $this->getQuery($post, 'employee_available_date');
          break;
        case 'delete' :
          if (isset($this->param->idx)) $url .= "/view/{$this->param->idx}";
          $this->employeeDelete($_POST);
          $msg .= "삭제되었습니다";
          break;
        case 'getMoney' :
          $url .= "/view/{$this->param->idx}";
          $this->executeSQL("UPDATE join_employee SET paid = '1' WHERE join_employeeID = {$_POST['joinID']} LIMIT 1");
          $msg .= "수금완료!";
          break;
        case 'insert_day':
          $url .= "/available_date";
          $employeeID = $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$_POST['employeeName']}' ")[0]['employeeID'];
          $string ="INSERT INTO employee_available_date (employeeID,availableDate,notAvailableDate,detail)
                    VALUES ('{$employeeID}','{$_POST['availableDate']}','{$_POST['notAvailableDate']}','{$_POST['detail']}') ";
          $this->executeSQL($string);
          break;
        case 'restore' :
          $this->executeSQL("UPDATE employee SET activated = '1', deleted = '0', deleteDetail=null, deletedDate = null WHERE employeeID = '{$_POST['employeeID']}' LIMIT 1");
          $msg.="복구완료!";
          break;
        case 'join_update':
          $url .= "/view/{$this->param->idx}";
          $joinID = $_POST['joinID'];
          $detail = $_POST['detail'];
          $price = $_POST['price'];
          $this->executeSQL("UPDATE join_employee SET price= '{$price}', detail = '{$detail}' WHERE join_employeeID = '{$joinID}' LIMIT 1");
          break;
        case 'bookmark':
          $value = ($this->select('employee',"employeeID = '{$_POST['employeeID']}'",'bookmark') == 1) ? 0 : 1 ;
          $this->executeSQL("UPDATE employee SET bookmark = {$value} WHERE employeeID = '{$_POST['employeeID']}' LIMIT 1");
          $msg = null;
          break;
      }
      unset($_POST);
      if(isset($msg)) alert($msg);
      move($url);
    }
  }