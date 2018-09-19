<?php
Class Model_company extends Model
{
  var $tableName = "company";

  function getView(){
    $this->sql = "SELECT * FROM `company` join `ceo` ON company.ceoID = ceo.ceoID WHERE company.companyID='{$this->param->idx}'";
    return $this->fetch();}

  function action()
  {
    header("Content-type:text/html;charset=utf8");
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