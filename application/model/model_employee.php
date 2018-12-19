<?php
  
  Class Model_employee extends Model
  {
    public function __construct($param)
    {
      parent::__construct($param);
    }
    function action()
    {
      header("Content-type:text/html;charset=utf8");
      switch ($_POST['action']) {
        case 'insert' :
          $_POST['employee-employeeName'] = $this->removeDuplicate($_POST, 'employee', 'employeeName');
          $this->getQuery($_POST, 'employee');
          //join_employee 입력
          $_POST['join_employee-employeeID'] = $this->db->lastInsertId();
          $_POST['employee_available_day-employeeID'] = $this->db->lastInsertId();
          $this->getQuery($_POST, 'join_employee');
          $this->getQuery($_POST, 'employee_available_day');
          $msg = "입력되었습니다";
          break;
        case 'update' :
          if ($_POST['employee-employeeID'] != $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$_POST['employee-employeeName']}' LIMIT 1")[0]['employeeID']) {
            $_POST['employee-employeeName'] = $this->removeDuplicate($_POST, 'employee', 'employeeName');
          }
          $this->getQuery($_POST, 'employee');
          $this->getQuery($_POST, 'employee_available_day', 'employee');
          break;
        case 'new_insert':
          $this->getQuery($_POST, 'join_employee', 'employee');
          $msg = "추가되었습니다";
          break;
        case 'date_insert':
          $post['employee_available_date-employeeID'] = $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$_POST['employee_available_date-employeeID']}'")[0]['employeeID'];
          $this->getQuery($post, 'employee_available_date');
          break;
        case 'delete' :
          $this->delete($_POST,'employee');
          $msg = "삭제되었습니다";
          break;
        case 'getMoney' :
          $this->executeSQL("UPDATE `join_employee` SET paid = '1' WHERE join_employeeID = {$_POST['id']} LIMIT 1");
          $msg = "수금완료";
          break;
        case 'insert_day':
          $employeeID = $this->getTable("SELECT employeeID from employee WHERE employeeName = '{$_POST['employeeName']}' ")[0]['employeeID'];
          $string ="INSERT INTO employee_available_date (employeeID,availableDate,notAvailableDate,detail)
                    VALUES ('{$employeeID}','{$_POST['availableDate']}','{$_POST['notAvailableDate']}','{$_POST['detail']}') ";
          $this->executeSQL($string);
          break;
        case 'restore' :
          $this->executeSQL("UPDATE employee SET activated = '1', deleted = '0', deleteDetail=null, deletedDate = null WHERE employeeID = '{$_POST['employeeID']}' LIMIT 1");
          $msg = "복구되었습니다.";
          break;
        case 'join_update':
          $joinID = $_POST['joinID'];
          $detail = $_POST['detail'];
          $price = $_POST['price'];
          $this->executeSQL("UPDATE join_employee SET price= '{$price}', detail = '{$detail}' WHERE join_employeeID = '{$joinID}' LIMIT 1");
          break;
      }
//      unset($_POST);
      if(isset($msg)) alert($msg);
    }
  }