<?php
  
  Class Model_company extends Model
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
          //업체명 중복 배제
          $_POST['company-companyName'] = $this->removeDuplicate($_POST,'company','companyName');
          $_POST['user-userName'] = $_POST['company-companyName'];
          $_POST['user-userPW'] = $_POST['ceo-ceoPhoneNumber'];
          //ceo 이름 처리
          $ceoName = $_POST['ceo-ceoName'];
          $ceoNameList = $this->getColumnList($this->getTable("SELECT * FROM ceo"), 'ceoName');
          //기존 ceo 이름 입력 시
          if (in_array($ceoName, $ceoNameList)) {
            $_POST['company-ceoID'] = $this->getTable("SELECT `ceoID` FROM ceo WHERE `ceoName`= '{$ceoName}' LIMIT 1")[0]['ceoID'];
            $_POST['ceo-ceoName'] = null;
            $_POST['ceo-ceoPhoneNumber'] = null;
            //ceo 입력
            $this->getQuery($_POST, 'ceo');
            $this->getQuery($_POST, 'company');
          }
          //새로운 ceo 이름 입력 시
          else{
            //ceo 입력
            $this->getQuery($_POST, 'ceo');
            //company 입력
            $_POST['company-ceoID'] = $this->db->lastInsertId();
            $this->getQuery($_POST, 'company');
          }
          //join_company, user 입력
          $_POST['join_company-companyID'] = $this->db->lastInsertId();
          $_POST['user-companyID'] = $this->db->lastInsertId();
          $this->getQuery($_POST, 'join_company');
          $this->getQuery($_POST, 'user');
          $msg="입력되었습니다";
          break;
        case 'update' :
          if($_POST['company-companyID'] != $this->getTable("SELECT companyID from company WHERE companyName = '{$_POST['company-companyName']}' LIMIT 1")[0]['companyID']){
            $_POST['company-companyName'] = $this->removeDuplicate($_POST,'company','companyName');
          }
          $this->getQuery($_POST, 'ceo');
          $this->getQuery($_POST, 'company');
          break;
        case 'new_insert':
          $this->getQuery($_POST, 'join_company', 'company');
          unset($_POST);
          $msg="추가되었습니다";
          break;
        case 'delete' :
          $this->delete($_POST,'company');
          $msg="삭제되었습니다";
          break;
        case 'restore' :
          $this->executeSQL("UPDATE company SET activated = '1', deleted = '0', deleteDetail=null, deletedDate = null WHERE companyID = '{$_POST['companyID']}' LIMIT 1");
          $msg="복구되었습니다";
          break;
        case 'join_update':
          $joinID = $_POST['joinID'];
          $detail = $_POST['detail'];
          $price = $_POST['price'];
          $this->executeSQL("UPDATE join_company SET price= '{$price}', detail = '{$detail}' WHERE join_companyID = '{$joinID}' LIMIT 1");
          break;
        case 'callCancel':
          $this->callCancel($_POST);
          break;
      }
//      unset($_POST);
      if(isset($msg)) alert($msg);
    }
  }