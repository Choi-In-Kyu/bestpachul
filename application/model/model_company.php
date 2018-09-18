<?php

Class Model_company extends Model
{

  function getList($condition = null, $order = null)
  {
    $this->sql = "SELECT * FROM company LEFT JOIN ceo ON company.companyID = ceo.ceoID ";

    if (isset($condition)) {
      $this->sql .= $condition;
    }
    if (isset($order) && $order != "") {
      $this->sql .= " ORDER BY {$order}";
    }
    return $this->fetchAll();
  }

  function getListNum($table, $column, $value, $order)
  {
    $this->sql = "SELECT * FROM {$table}";
    if (isset($column) && isset($value)) {
      $this->sql .= " WHERE {$column} = {$value}";
    }
    if (isset($order)) {
      $this->sql .= " order by `{$order}` desc";
    }
    return $this->cnt();
  }

//getView
  function getView()
  {
    $this->sql = "SELECT * FROM `company` join `ceo` ON company.ceoID = ceo.ceoID WHERE company.companyID='{$this->param->idx}'";
    return $this->fetch();
  }


//action
  function action()
  {
    header("Content-type:text/html;charset=utf8");
    $cancel = "";
    $msg = "완료되었습니다.";
    $url = $this->param->get_page;
    switch ($_POST['action']) {
      case 'insert' :
        $this->myInsert($_POST);
        break;
      case 'update' :
        $url .= "/view/{$this->param->idx}";
    }
    access(!$this->query(), $msg, $url);
  }

}
?>