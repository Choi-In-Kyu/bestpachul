<div class="board_list auto-center">
  <?php require_once(_VIEW.'filter.php'); ?>
  <?php require_once(_VIEW.'company/companyTable.php'); ?>
</div>
<form id="bookmarkForm" action="" method="post">
    <input type="hidden" name="action" value="bookmark">
    <input type="hidden" name="ID" value="">
</form>
<?php require_once(_VIEW.'modal.php'); ?>