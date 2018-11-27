<?php
  
  class Ceo extends Controller
  {
    var $userID;
    var $companyID;
    var $companyData;
    var $callList;
    var $joinData;
    var $leftDays;
    var $weekendCount;
    var $weekdayCount;
    var $callPriceList;
    var $callPrice;
    
    function __construct($param)
    {
      parent::__construct($param);
      $this->basic();
      $this->content();
    }
    
    function basic()
    {
      $this->companyID = $this->model->select('user', "userID = $this->userID", 'companyID');
      $this->companyData = $this->model->getTable("SELECT * from `company` WHERE companyID ='{$this->companyID}' LIMIT 1")[0];
      $this->joinData = $this->model->getTable("SELECT * FROM `join_company` WHERE companyID = '{$this->companyID}' AND activated = 1");
      $this->callList = $this->model->getTable("SELECT * FROM `call` WHERE companyID = '{$this->companyID}'");
      $this->payList = $this->model->getTable("SELECT * FROM `call` WHERE companyID = '{$this->companyID}' AND `price` IS NOT NULL AND `cancelled`=0");
      $this->weekendCount = $this->model->getTable(
        "SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 )
AND ( DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1) AND price IS NULL AND cancelled=0");
      $this->weekdayCount = $this->model->getTable(
        "SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 )
AND NOT (DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1) AND price IS NULL AND cancelled=0");
      $this->weekendPaidCount = $this->model->getTable(
        "SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 )
AND ( DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1) AND price>0 AND cancelled=0");
      $this->weekdayPaidCount = $this->model->getTable(
        "SELECT * FROM  `call` WHERE companyID ={$this->companyID} AND YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 )
AND NOT (DAYOFWEEK( workDate ) =7 OR DAYOFWEEK( workDate ) =1) AND price>0 AND cancelled=0");
      $this->callPriceList = $this->model->getTable("SELECT * FROM `call`  WHERE companyID =  '{$this->companyID}' AND price >=0 AND cancelled=0");
      $this->callPrice = $this->addAll($this->callPriceList);
    }
    
    function lastJoinDate()
    {
      if ($this->joinType($this->joinData) == '구좌') {
        return $this->model->getTable("SELECT * FROM join_company WHERE companyID = '{$this->companyID}' ORDER BY endDate DESC")[0]['endDate'];
      } else return null;
    }
    
    function dateFormat($array)
    {
      foreach ($array as $item) {
        $array2[] = "\"" . $item . "\"";
      }
      $date = implode(',', $array2);
      return $date;
    }
    
    function addAll($array)
    {
      $sum = 0;
      foreach ($array as $value) $sum += $value['price'];
      return $sum;
    }
    
    function getDate($list)
    {
      foreach ($list as $key => $value) {
        $year = date('Y', strtotime($value['workDate']));
        $array[$year][] = date('m', strtotime($value['workDate']));
      }
      return $array;
    }
    
    function employeeName($id)
    {
      return $this->model->getTable("SELECT * FROM employee WHERE employeeID = '{$id}'")[0]['employeeName'];
    }
  }