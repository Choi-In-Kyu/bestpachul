<?php
  
  Class Model_company extends Model
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
  
    var $tableName = "company";
    function getView()
    {
      $this->sql = "SELECT * FROM `company` join `ceo` ON company.ceoID = ceo.ceoID WHERE company.companyID='{$this->param->idx}'";
      return $this->fetch();
    }
    
    function companyDelete($post)
    {
      $deletedDate = date("Ymd");
      if (!isset ($post['joinID'])) {
        $this->executeSQL("UPDATE company SET deleted=1, activated=0, deletedDate= '{$deletedDate}', deleteDetail = '{$post['deleteDetail']}' WHERE companyID = '{$post['companyID']}'");
        $this->executeSQL("UPDATE join_company SET deleted=1, activated=0, deletedDate= '{$deletedDate}', deleteDetail = '업체삭제({$deletedDate})' WHERE companyID = '{$post['companyID']}' AND activated=1");
      }
      else {
        $this->executeSQL("UPDATE join_company SET deleted=1, activated=0, deletedDate= '{$deletedDate}', deleteDetail = '{$post['deleteDetail']}' WHERE join_companyID = '{$post['joinID']}'");
      }
    }
  
    function action()
    {
      header("Content-type:text/html;charset=utf8");
      $msg ="[SYSTEM]";
      $url = $this->param->get_page;
      
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
          $msg.="입력되었습니다";
          break;
        case 'update' :
          $url .= "/view/{$this->param->idx}";
          if($_POST['company-companyID'] != $this->getTable("SELECT companyID from company WHERE companyName = '{$_POST['company-companyName']}' LIMIT 1")[0]['companyID']){
            $_POST['company-companyName'] = $this->removeDuplicate($_POST,'company','companyName');
          }
          $this->getQuery($_POST, 'ceo');
          $this->getQuery($_POST, 'company');
          $msg.="수정되었습니다";
          break;
        case 'new_insert':
          $url .= "/view/{$this->param->idx}";
          $this->getQuery($_POST, 'join_company', 'company');
          $msg.="추가되었습니다";
          break;
        case 'delete' :
          if(isset($this->param->idx)) $url .= "/view/{$this->param->idx}";
          $this->companyDelete($_POST);
          $msg.="삭제되었습니다";
          break;
        case 'restore' :
          $this->executeSQL("UPDATE company SET activated = '1', deleted = '0', deleteDetail=null, deletedDate = null WHERE companyID = '{$_POST['companyID']}' LIMIT 1");
          $msg.="복구완료!";
      }
      alert($msg);
      move($url);
    }
  }