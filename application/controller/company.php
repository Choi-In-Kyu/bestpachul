<?php

  Class Company extends Controller
  {
    var $list;
    var $data;
    var $name;
    var $filterColor;
    var $filterBgColor;
    var $joinList;
    var $companyData;
    var $ceoData;
    var $action;
    var $submitButtonName;
    var $companyID;

    //bestpachul.com/company
    function basic()
    {
      $this->initJoin('company');
      $this->getBasicFunction('company');
    }
    
    //bestpachul.com/company/view
    function view()
    {
      $this->action = 'update';
      $this->submitButtonName = "수정";
      $this->companyID = $this->param->idx;
      $this->companyData = $this->db->getTable("SELECT * FROM company WHERE companyID = '{$this->companyID}'");
      $this->companyData = $this->getActCondition($this->companyData, 'company')[0];
      $this->ceoData = $this->db->getTable("SELECT * FROM ceo WHERE ceoID = '{$this->companyData['ceoID']}'")[0];
      $this->joinList = $this->db->getTable("SELECT * FROM join_company WHERE companyID = '{$this->companyID}' order by endDate DESC");
      $this->data = $this->db->getView();
    }
    
    //bestpachul.com/company/write
    function write()
    {
      $this->action = 'insert';
      $this->submitButtonName = "추가";
    }
    
    //bestpachul.com/company/delete
    function delete()
    {
      $this->db->myDelete('company', $this->param->idx);
      alert("삭제되었습니다");
      move($this->param->get_page);
    }
  }