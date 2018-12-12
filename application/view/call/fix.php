<div class="board_list scroll_list right auto-center" style="overflow: hidden">
  <?php if (in_array($this->param->page_type, ['company', 'employee'])): ?>
      <h1><?php echo ($this->param->page_type == 'company')? '콜':'배정' ?> 내역</h1>
  <?php endif; ?>
  <?php require_once 'datepicker.php' ?>
  <?php $type = 'call'; require 'fixTable.php' ?>
  <?php require_once 'callTable_min.php' ?>
</div>
<?php require_once _VIEW.'common/modal.php' ?>