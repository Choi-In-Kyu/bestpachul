<?php
  
  Class Company extends Controller
  {
    var $list;
    var $data;
    var $name;
    
    var $ceoList;
    var $businessTypeList;
    var $addressList;
    var $joinList;
  
    var $companyData;
    var $ceoData;
    
    var $action;
    var $submitButtonName;
    
    var $activatedCondition;
    var $expiredCondition;
    var $deadlineCondition;
    
    var $direction;
    var $condition;
    var $order;
    var $keyword;
    var $companyID;
    
    //bestpachul.com/company
    function basic()
    {
      //condition
      $this->condition = $_POST['condition'];
      $this->keyword = $_POST['keyword'];
      $this->activatedCondition = " WHERE activated = 1";
      $this->expiredCondition = " WHERE activated = 0";
      $this->deadlineCondition =
        " LEFT JOIN `join_company`
        ON `company`.companyID = `join_company`.companyID
        WHERE
        DATE_ADD(CURDATE(), interval -15 day) < CURDATE() < `endDate`
        ORDER BY endDate ASC
        limit 1";
      if (isset($this->keyword) && $this->keyword != "") $this->condition = " WHERE `companyName` LIKE '%{$this->keyword}%' OR `address` LIKE '%{$this->keyword}%' ";
      
      //order
      $this->direction = $_POST['direction'];
      if ($this->direction == "ASC") $this->direction = "DESC";
      else $this->direction = "ASC";
      $this->order = $_POST['order'];
      if (isset($this->order) && $this->order != "") $this->order = " {$_POST['order']} {$this->direction}";
      else $this->order = null;
      
      
      //get list
      $this->list = $this->db->getList($this->condition, $this->order);
    }
    
    //bestpachul.com/company/view
    function view()
    {
      $this->action = 'update';
      $this->submitButtonName = "수정";
      $this->companyID = $this->param->idx;
      
      $this->companyData      = $this->db->getTable("SELECT * FROM company WHERE companyID = '{$this->companyID}'");
      $this->ceoList          = $this->db->getTable("SELECT * FROM `ceo`");
      $this->businessTypeList = $this->db->getTable("SELECT * FROM `businessType`");
      $this->addressList      = $this->db->getTable("SELECT * FROM `address`");
      $this->ceoData          = $this->db->getTable("SELECT * FROM ceo WHERE ceoID = '{$this->companyData[0]['ceoID']}'");
      $this->joinList         = $this->db->getTable("SELECT * FROM join_company WHERE companyID = '{$this->companyID}' order by endDate DESC");
      
      $this->data = $this->db->getView();
      
      function get_joinType($data){
          if(isset($data['price']) && $data['price']!=0){return "구좌";}
          elseif (isset($data['deposit']) && $data['deposit']!=0){return "보증금+콜비";}
          elseif(isset($data['point']) && $data['point']!=0){return "포인트";}
      }
    }
    
    //bestpachul.com/company/write
    function write()
    {
      $this->action = 'insert';
      $this->submitButtonName = "추가";
      $this->businessTypeList = $this->db->getTable("SELECT * FROM `businessType`");
      $this->addressList = $this->db->getTable("SELECT * FROM `address`");
      $this->ceoList = $this->db->getTable("SELECT * FROM `ceo`");
    }
  
    //bestpachul.com/company/delete
    function delete()
    {
      $this->db->myDelete('company', $this->param->idx);
      alert("삭제되었습니다");
      move($this->param->get_page);
    }
    
    
  }