<?php
//  if (in_array($this->param->page_type, ['company', 'employee', 'call'])) {
//    if (isset($_COOKIE['userID'])) {
//      if ($_COOKIE['userID'] == 1) {
//      } else {
//        alert('접근 권한이 없습니다.');
//        move(_URL . 'ceo');
//      }
//    } else {
//      alert('로그인이 필요한 서비스입니다.');
//      move(_URL . 'login');
//    }
//  } elseif(in_array($this->param->page_type, ['ceo'])) {
//    if (isset($_COOKIE['userID'])) {
//      if ($_COOKIE['userID'] == 1) {
//        alert('관리자페이지로 이동합니다.');
//        move(_URL . 'company');
//      }
//    } else {
//      alert('로그인이 필요한 서비스입니다.');
//      move(_URL . 'login');
//    }
//  }elseif ($this->param->page_type == 'login'){
//    alert("로그인페이지입니다.");
//  }
//  else{
//    alert("잘못된 페이지 접근입니다.");
//    move(_URL . 'login');
//  }