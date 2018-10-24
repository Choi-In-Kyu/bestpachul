<?php
  
  Class Model_company extends Model
  {
    var $tableName = "company";
    function getView()
    {
      $this->sql = "SELECT * FROM `company` join `ceo` ON company.ceoID = ceo.ceoID WHERE company.companyID='{$this->param->idx}'";
      return $this->fetch();
    }
    
    function companyInsert($post)
    {
      //insert <-> update
      switch ($post['action']) {
        case 'insert':
          //신규 등록 시 user 추가
          $post['user-userName'] = $post['company-companyName'];
          $post['user-userPW'] = $post['ceo-ceoPhoneNumber'];
          //업체명 중복 배제
          $post['company-companyName'] = $this->removeDuplicate($post,'company','companyName');
          //ceo 이름 처리
          $ceoName = $post['ceo-ceoName'];
          $ceoNameList = $this->getColumnList($this->getTable("SELECT * FROM ceo"), 'ceoName');
          //기존 ceo 이름 입력 시
          if (in_array($ceoName, $ceoNameList)) {
            $post['company-ceoID'] = $this->getTable("SELECT `ceoID` FROM ceo WHERE `ceoName`= '{$ceoName}' LIMIT 1")[0]['ceoID'];
            $post['ceo-ceoName'] = null;
            $post['ceo-ceoPhoneNumber'] = null;
            //ceo 입력
            $this->getQuery($post, 'ceo');
            $this->getQuery($post, 'company');
          }
          //새로운 ceo 이름 입력 시
          else{
            //ceo 입력
            $this->getQuery($post, 'ceo');
            //company 입력
            $post['company-ceoID'] = $this->db->lastInsertId();
            $this->getQuery($post, 'company');
          }
          //join_company, user 입력
          $post['join_company-companyID'] = $this->db->lastInsertId();
          $post['user-companyID'] = $this->db->lastInsertId();
          //$post['user-userName'] = $post['company-companyName'];
          //$post['user-userPW'] = $post['ceo-ceoPhoneNumber'];
          $this->getQuery($post, 'join_company');
          $this->getQuery($post, 'user');
          break;
        case 'update':
          //업체명 중복 배제
          if($post['company-companyID'] != $this->getTable("SELECT companyID from company WHERE companyName = '{$post['company-companyName']}' LIMIT 1")[0]['companyID']){
            $post['company-companyName'] = $this->removeDuplicate($post,'company','companyName');
          }
          $this->getQuery($post, 'ceo');
          $this->getQuery($post, 'company');
          break;
        case 'new_insert':
          $this->getQuery($post, 'join_company', 'company');
          break;
      }
    }
    
    function companyDelete($post){
      if(!isset ($post['join_company-join_companyID'])){
        $this->getQuery($post,'company');
      }
      else{
        $this->getQuery($post,'join_company');
      }
    }
    
    function action()
    {
      header("Content-type:text/html;charset=utf8");
      $msg = "완료되었습니다.";
      $url = $this->param->get_page;
      
      switch ($_POST['action']) {
        case 'insert' :
          $this->companyInsert($_POST);
          $msg.="입력되었습니다";
          break;
        case 'update' :
          $url .= "/view/{$this->param->idx}";
          $this->companyInsert($_POST);
          $msg.="수정되었습니다";
          break;
        case 'new_insert':
          $url .= "/view/{$this->param->idx}";
          $this ->companyInsert($_POST);
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