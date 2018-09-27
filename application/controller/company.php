<?php

Class Company extends Controller
{
  var $list;
  var $data;
  var $name;
  var $businessTypeList;
  var $addressList;

  function basic()
  {
    $this->list = $this->db->getList();
  }

  function view(){$this->data = $this->db->getView();}

  function write()
  {
    if (isset($this->param->idx)) {
      $this->data = $this->db->getView();
    }
    $this->action = isset($this->param->idx) ? 'update' : 'insert';
    $this->businessTypeList = $this->db->getTable("SELECT * FROM `businessType`");
    $this->addressList = $this->db->getTable("SELECT * FROM `address`");
  }
  function delete(){
    $this->db->myDelete('company',$this->param->idx);
    alert("삭제되었습니다");
    move($this->param->get_page);
  }
}