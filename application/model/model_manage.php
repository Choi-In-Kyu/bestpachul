<?php

  class Model_manage extends Model
  {
    function action(){
      if(isset($_POST)){
        $employeeName = $_POST['employeeName'];
        $companyName = $_POST['companyName'];
        $detail = $_POST['detail'];
        $type = $_POST['type'];
        $employeeID = $this->getTable("SELECT * FROM employee WHERE employeeName = '{$employeeName}'")[0]['employeeID'];
        $companyID = $this->getTable("SELECT * FROM company WHERE companyName = '{$companyName}'")[0]['companyID'];
        $this->executeSQL("INSERT INTO blackList SET employeeID = '{$employeeID}', companyID = '{$companyID}', detail = '{$detail}', ceoReg = '{$type}'");
        unset($_POST);
      }
    }
  }