<?php
  
  class Model_login extends Model
  {
    function action()
    {
      $this->getUser($_POST);
      $userData = $this->getUser($_POST);
      if (isset($userData)) {//로그인 성공
        setcookie('userID',$userData['userID'],time()+(86400*365),'/');
        if (!isset($userData['companyID'])) {//관리자 로그인
          move("company");
        } else {//사장님 로그인
          move("ceo");
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