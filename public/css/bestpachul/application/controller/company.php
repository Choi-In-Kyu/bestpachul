<?php
  
  Class Company extends Controller
  {
    var $list;
    var $data;
    var $name;
    var $joinList;
    var $companyData;
    var $ceoData;
    var $companyID;
    var $callList;
    var $employeeList;
    
    function __construct($param)
    {
      parent::__construct($param);
      $this->initJoin('company');
      $this->getBasicFunction('company');
      $this->content();
    }
    
    function view()
    {
      $this->companyID = $this->param->idx;
      $this->companyData = $this->model->getTable("SELECT * FROM company WHERE companyID = '{$this->companyID}'");
      $this->companyData = $this->getActCondition($this->companyData, 'company')[0];
      $this->ceoData = $this->model->getTable("SELECT * FROM ceo WHERE ceoID = '{$this->companyData['ceoID']}'")[0];
      $this->joinList = $this->model->getTable("SELECT * FROM join_company WHERE companyID = '{$this->companyID}' order by endDate DESC");
      $this->employeeList = $this->model->getTable("SELECT * FROM `employee` WHERE activated = 1");
      $this->callList = $this->getCallTable();
      $this->blackList = $this->getBlackList();
    }
  }