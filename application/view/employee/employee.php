<form id="formRefresh" action="" method="post">
    <input type="hidden" name="action"      value="refresh">
    <input type="hidden" name="filter"      value="<?php echo $_POST['filter']?>">
    <input type="hidden" name="keyword"     value="<?php echo $_POST['keyword']?>">
    <input type="hidden" name="order"       value="<?php echo $_POST['order']?>">
    <input type="hidden" name="direction"   value="<?php echo $_POST['direction']?>">
</form>
<div class="board_list auto-center">
  <?php require_once(_VIEW.'employee/employeeTable.php'); ?>
</div>
<?php require_once(_VIEW . 'common/modal.php'); ?>