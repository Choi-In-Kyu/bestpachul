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
    var $callList;
    var $employeeList;

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
      $this->callList = $this->db->getTable("SELECT * FROM `call` WHERE `companyID` = '{$this->companyID}'");
      switch ($_POST['filter']) {
        case 'month':
          $condition = "WHERE YEAR(workDate) = YEAR(CURRENT_DATE()) AND MONTH(workDate) = MONTH(CURRENT_DATE())";
          break;
        case 'week':
          $condition = "WHERE  YEARWEEK(`workDate`, 1) = YEARWEEK(CURDATE(), 1)";
          break;
        case 'day':
          $condition = "WHERE workDate = '{$_POST['date']}'";
          break;
        default :
          $condition = "WHERE workDate = '".date('Y-m-d')."'";
          break;
      }
//      $condition .= "AND `cancelled` = 0";
      $condition .= "AND `companyID` = '{$this->companyID}'";
      $this->callList = $this->db->getTable("SELECT * FROM `call`" . $condition);
      $this->employeeList = $this->db->getTable("SELECT * FROM `employee` WHERE activated = 1");
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