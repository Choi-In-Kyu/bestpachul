<?php
  
  class Model_login extends Model
  {
    function action()
    {
      $userData = $this->getUser($_POST);
      $companyID = $userData['companyID'];
      $activated = $this->getTable("SELECT activated FROM company WHERE companyID = '{$companyID}'")[0]['activated'];
      
      
      if (isset($userData)) {//로그인 성공
        setcookie('userID',$userData['userID'],time()+(3600*24*365),'/');
        if ($userData['userID']==1) {//관리자 로그인
          move("company");
        }
        else {//사장님 로그인
          if($activated==1)move("ceo");
          else alert("로그인에 실패했습니다. 관리자에게 문의하세요.");
        }
      }
      else {//로그인 실패
        alert("로그인에 실패했습니다. 관리자에게 문의하세요.");
        move("login");
      }
    }
    
    function getUser($post)
    {
      $userName = $post['userName'];
      $userPW = $post['userPW'];
      $sql = "SELECT * FROM `user` WHERE userName = '{$userName}' ";
      if ($userPW != M_USERPW) {
        $sql .= " AND userPW = '{$userPW}'";
      }
      $userData = $this->getTable($sql)[0];
      return $userData;
    }
  }