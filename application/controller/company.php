<?php

Class Company extends Controller
{
  var $list;
  var $data;
  var $listNum;
  var $listNumAct;
  var $listNumNotAct;
  var $name;
  var $businessTypeList;
  var $addressList;

//basic : list
  function basic()
  {
//    $this->list = $this->db->getList("company",null,"date",null);
    $this->listNum = $this->db->getListNum("company",null,null,null);
    $this->listNumAct = $this->db->getListNum("company","activated",1,null);
    $this->listNumNotAct = $this->db->getListNum("company","activated",0,null);
  }

  function getList($condition=null, $order=null){
    $this->list = $this->db->getList($condition, $order);
  }

//view
  function view()
  {
    $this->data = $this->db->getView();
  }

//write
  function write()
  {
    if (isset($this->param->idx)) {
      $this->data = $this->db->getView();
    }
    $this->action = isset($this->param->idx) ? 'update' : 'insert';
    $this->businessTypeList = $this->db->getTable("SELECT * FROM `businessType`");
    $this->addressList = $this->db->getTable("SELECT * FROM `address`");
  }

}
?>