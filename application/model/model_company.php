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
          alert("POST : ".json_encode($_POST));
          $_POST['userName'] = $_POST['companyName'];
          $_POST['userPW'] = $_POST['ceoPhoneNumber'];
          if(!$_POST['ceoID']){//새로운 사장 입력 시
            $this->insert('insert','ceo',$_POST);
            $_POST['ceoID'] = $this->getLastID('ceo');
            alert('new ceoID : '.json_encode($_POST['ceoID']));
          }
          else{
            alert(json_encode($_POST['ceoID']));
          }
          $this->insert('insert','company', $_POST);
          $_POST['companyID'] = $this->getLastID('company');
          $this->insert('insert','join_company',$_POST);
          $this->insert('insert','user',$_POST);
          foreach ($this->select('address') as $value){//존재하는 간단주소의 목록
            foreach ($value as $item){
              $addressTable[] = $item;
            }
          }
          if(!in_array($_POST['address'],$addressTable)){//새로운 간단주소 입력
            $this->insert('insert','address',$_POST);
          }
          foreach ($this->select('businessType') as $value){//존재하는 간단주소의 목록
            foreach ($value as $item){
              $businessTypeTable[] = $item;
            }
          }
          if(!in_array($_POST['businessType'],$businessTypeTable)){//새로운 간단주소 입력
            $this->insert('insert','businessType',$_POST);
          }
          $msg = "insert!";
//          unset($_POST);
          break;
        case 'update' :
          alert("POST : <br>".json_encode($_POST));
          $this->insert('update', 'company', $_POST);
          $this->insert('update', 'ceo', $_POST);
          unset($_POST);
          break;
        case 'new_insert':
          $_POST['companyID'] = $this->param->idx;
          $this->insert('addJoin', 'join_company', $_POST);
          unset($_POST);
          $msg = "추가되었습니다";
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