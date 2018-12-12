<div class="board_list scroll_list right auto-center" style="overflow: hidden">
  <?php if (in_array($this->param->page_type, ['company', 'employee'])): ?>
      <h1><?php echo ($this->param->page_type == 'company')? '콜':'배정' ?> 내역</h1>
  <?php endif; ?>
  <?php require_once _VIEW.'/common/datepicker.php' ?>
  <?php $type = 'call'; require 'callTable.php' ?>
  <?php require_once 'employeeTable.php' ?>
</div>
<?php require_once _VIEW.'common/modal.php' ?>