<?php
  $employeeList = $this->model->getTable("SELECT * FROM `employee` WHERE `activated` = 1 OR `bookmark` = 1 ORDER BY `employeeName` ASC");
  $companyList = $this->model->getTable("SELECT * FROM `company` WHERE `activated` = 1 OR `bookmark` =1 ORDER BY `companyName` ASC");
?>

<div class="board-write">
    <div class="title-table">
        <h1 class="title-main">콜 만들기</h1>
    </div>
    <div>
        <button class="btn btn-option selected" id="manualCallBtn">일반콜</button>
        <button class="btn btn-option" id="fixCallBtn">고정</button>
        <button class="btn btn-option" id="monthlyCallBtn">월급제</button>
    </div>
    <?php require_once 'callForm.php';?>
</div>
<script src="/public/js/create_call.js"></script>