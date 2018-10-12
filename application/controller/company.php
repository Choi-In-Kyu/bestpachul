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
    
    var $direction;
    var $condition;
    var $order;
    var $keyword;
    var $companyID;
    
    public $activatedCondition = " WHERE activated = 1 AND deleted = 0 ";
    public $expiredCondition = " WHERE activated = 0 AND deleted = 0 ";
    public $deletedCondition = " WHERE activated = 0 AND deleted = 1 ";
    public $deadlineCondition =
      " LEFT JOIN `join_company`
          ON `company`.companyID = `join_company`.companyID
          WHERE
          (DATE_ADD(`endDate`, interval -15 day) < CURDATE())
          AND
          (CURDATE()<`endDate`)
          ORDER BY endDate ASC LIMIT 1";
    
    
    function getActCondition($list)
    {
      $deadlineArray = $this->db->getColumnList($this->db->getList($this->deadlineCondition), 'companyID');
      $expiredArray = $this->db->getColumnList($this->db->getList($this->expiredCondition), 'companyID');
      $deletedArray = $this->db->getColumnList($this->db->getList($this->deletedCondition), 'companyID');
      foreach ($list as $key => $value) {
        $companyID = $list[$key]['companyID'];
        if (in_array($companyID, $expiredArray)) {
          $actCondition = "만기됨";
          $color = "pink";
        } elseif (in_array($companyID, $deadlineArray)) {
          $actCondition = "만기임박";
          $color = "orange";
        } elseif (in_array($companyID, $deletedArray)) {
          $actCondition = "삭제됨";
          $color = "gray";
        } else {
          $actCondition = "가입중";
          $color = "ivory";
        }
        $list[$key]['actCondition'] = $actCondition;
        $list[$key]['color'] = $color;
      }
      return $list;
    }
    
    function getCompanyTable($list, $companyID)
    {
      foreach ($list as $key => $value) {
        if ($list[$key]['companyID'] == $companyID) {
          return $list[$key];
        } else {
          return null;
        }
      }
    }
    
    //bestpachul.com/company
    function basic()
    {
      //condition
      $this->condition = $_POST['condition'];
      $this->keyword = $_POST['keyword'];
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
      $this->list = $this->getActCondition($this->list);
    }
    
    //bestpachul.com/company/view
    function view()
    {
      $this->action = 'update';
      $this->submitButtonName = "수정";
      $this->companyID = $this->param->idx;
      $this->companyData = $this->db->getTable("SELECT * FROM company WHERE companyID = '{$this->companyID}'");
      $this->companyData = $this->getActCondition($this->companyData)[0];
      
      $this->ceoList = $this->db->getTable("SELECT * FROM `ceo`");
      $this->businessTypeList = $this->db->getTable("SELECT * FROM `businessType`");
      $this->addressList = $this->db->getTable("SELECT * FROM `address`");
      
      $this->ceoData = $this->db->getTable("SELECT * FROM ceo WHERE ceoID = '{$this->companyData['ceoID']}'")[0];
      $this->joinList = $this->db->getTable("SELECT * FROM join_company WHERE companyID = '{$this->companyID}' order by endDate DESC");
      $this->data = $this->db->getView();
      function get_joinType($data)
      {
        if (isset($data['deposit']) && $data['deposit'] != 0) return "보증금+콜비";
        elseif (isset($data['point']) && $data['point'] != 0) return "포인트";
        elseif (isset($data['price']) && $data['price'] != 0) return "구좌";
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