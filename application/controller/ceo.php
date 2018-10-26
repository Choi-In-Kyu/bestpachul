<?php
  
  class Ceo extends Controller
  {
    var $userID;
    var $companyID;
    var $companyData;
    var $callList;
    var $joinData;
    var $leftDays;
    
    function basic()
    {
      $this->userID = $_COOKIE['userID'];
      $this->companyID = $this->db->getTable("SELECT companyID FROM user WHERE userID = '{$this->userID}'")[0]['companyID'];
      $this->companyData = $this->db->getTable("SELECT * from `company` WHERE company.companyID ='{$this->companyID}' LIMIT 1")[0];
      $this->joinData = $this->db->getTable("SELECT * FROM `join_company` WHERE companyID = '{$this->companyID}'");
      $this->callList = $this->db->getTable("SELECT * FROM `call` WHERE companyID = '{$this->companyID}'");
      $this->getFunctions();
    }
    
    function leftDays($date)
    {
      $today = strtotime($this->today);
      $date = strtotime($date);
      $leftDays = date('j', $today - $date);
      return $leftDays;
    }
    
    function getTime($i)
    {
      if ($i < 12) {
        $time = '오전 ' . $i . '시';
      } else {
        if ($i > 12) {
          $time = $i - 12;
        } else {
          $time = $i;
        }
        $time = '오후 ' . $time . '시';
      }
      return $time;
    }
  }