<?php
  
  Class Model_company extends Model
  {
    var $tableName = "company";
    
    function getView()
    {
      $this->sql =
        "SELECT * FROM `company` join `ceo` ON company.ceoID = ceo.ceoID WHERE company.companyID='{$this->param->idx}'";
      return $this->fetch();
    }
    
    function action()
    {
      header("Content-type:text/html;charset=utf8");
      $msg = "완료되었습니다.";
      $url = $this->param->get_page;
      $companyName = $_POST['company-companyName'];
      
      switch ($_POST['action']) {
        case 'insert' :
          $companyNameList = $this->getColumnList($this->getList(), 'companyName');
          while (in_array($companyName, $companyNameList)) {
            $companyName .= "(중복됨)";
            continue;
          }
          $_POST['company-companyName'] = $companyName;
          $this->companyInsert($_POST);
          break;
        case 'update' :
          $url .= "/view/{$this->param->idx}";
          $this->companyInsert($_POST);
          break;
      }
      alert($msg);
      move($url);
    }
  }