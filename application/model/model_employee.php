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
          move('ceo');
        }
      }
      else{
        alert('로그인이 필요한 서비스입니다.');
        move ('login');
      }
    }
    
    var $tableName = "employee";
    
    function getView()
    {
      $this->sql = "SELECT * FROM `employee` WHERE employee.employeeID='{$this->param->idx}'";
      return $this->fetch();
    }
    
    function getAge($date)
    {
      $birthDate = new DateTime($date);
      $now = new DateTime();
      $difference = $now->diff($birthDate);
      $age = $difference->y;
      return $age;
    }
    
    function employeeInsert($post)
    {
      //insert <-> update
      switch ($post['action']) {
        case 'insert':
          //인력명 중복 배제
          $post['employee-employeeName'] = $this->removeDuplicate($post, 'employee', 'employeeName');
          $this->getQuery($post, 'employee');
          //join_employee 입력
          $post['join_employee-employeeID'] = $this->db->lastInsertId();
          $post['employee_available_day-employeeID'] = $this->db->lastInsertId();
          $this->getQuery($post, 'join_employee');
          $this->getQuery($post, 'employee_available_day');
          break;
        case 'update':
          //인력명 중복 배제
          if ($post['employee-employeeID'] != $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$post['employee-employeeName']}' LIMIT 1")[0]['employeeID']) {
            $post['employee-employeeName'] = $this->removeDuplicate($post, 'employee', 'employeeName');
          }
          $this->getQuery($post, 'employee');
          $this->getQuery($post, 'employee_available_day', 'employee');
          break;
        case 'new_insert':
          $this->getQuery($post, 'join_employee', 'employee');
          break;
        case 'date_insert':
          $post['employee_available_date-employeeID'] = $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$post['employee_available_date-employeeID']}'")[0]['employeeID'];
          $this->getQuery($post, 'employee_available_date');
      }
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
      $msg = "완료되었습니다.";
      $url = $this->param->get_page;
      
      switch ($_POST['action']) {
        case 'insert' :
          $this->employeeInsert($_POST);
          $msg .= "입력되었습니다";
          break;
        case 'update' :
          $url .= "/view/{$this->param->idx}";
          $this->employeeInsert($_POST);
          $msg .= "수정되었습니다";
          break;
        case 'new_insert':
          $url .= "/view/{$this->param->idx}";
          $this->employeeInsert($_POST);
          $msg .= "추가되었습니다";
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
      }
      alert($msg);
      move($url);
    }
  }