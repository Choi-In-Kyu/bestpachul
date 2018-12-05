<?php //getLog(json_encode($_POST))?>
<div class="board_list scroll_list right auto-center" style="overflow: hidden">
  <?php $type='call'; require_once 'callTable.php' ?>
  <?php require_once 'employeeTable.php' ?>
</div>
<?php require_once 'call_modal.php'?>