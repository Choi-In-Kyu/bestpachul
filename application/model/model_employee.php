<?php
  
  Class Model_employee extends Model
  {
    var $tableName = "employee";
    function getView()
    {
      $this->sql = "SELECT * FROM `employee` WHERE employee.employeeID='{$this->param->idx}'";
      return $this->fetch();
    }
  
    function getAge($date){
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
          $post['employee-employeeName'] = $this->removeDuplicate($post,'employee','employeeName');
          $this->getQuery($post, 'employee');
          //join_employee 입력
          $post['join_employee-employeeID'] = $this->db->lastInsertId();
          $post['employee_available_day-employeeID'] = $this->db->lastInsertId();
          $this->getQuery($post, 'join_employee');
          $this->getQuery($post, 'employee_available_day');
          break;
        case 'update':
          //인력명 중복 배제
          $post['employee-employeeName'] = $this->removeDuplicate($post,'employee','employeeName');
          $this->getQuery($post, 'employee');
          $this->getQuery($post, 'employee_available_day', 'employee');
          break;
        case 'new_insert':
          $this->getQuery($post, 'join_employee', 'employee');
          break;
      }
    }
    
    function employeeDelete($post){
      if(!isset ($post['join_employee-join_employeeID'])){
        $post['employee-deleted'] = 1;
        $post['employee-activated'] = 0;
        $post['employee-deletedDate'] = date("Ymd");
        $this->getQuery($post,'employee');
      }
      else{
        $this->getQuery($post,'join_employee');
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
          $msg.="입력되었습니다";
          break;
        case 'update' :
          $url .= "/view/{$this->param->idx}";
          $this->employeeInsert($_POST);
          $msg.="수정되었습니다";
          break;
        case 'new_insert':
          $url .= "/view/{$this->param->idx}";
          $this ->employeeInsert($_POST);
          $msg.="추가되었습니다";
          break;
        case 'delete' :
          if(isset($this->param->idx)) $url .= "/view/{$this->param->idx}";
          $this->employeeDelete($_POST);
          $msg.="삭제되었습니다";
          break;
      }
      alert($msg);
      move($url);
    }
  }