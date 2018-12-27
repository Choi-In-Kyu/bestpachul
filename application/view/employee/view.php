<?php include_once 'write.php' ?>
<?php if($this->param->action =='view')require_once 'employeeJoinTable.php'?>
<?php $type='call'; require_once(_VIEW . "call/call.php");?>
<?php $type='punk'; require_once(_VIEW . "call/punk.php");?>
<?php require_once(_VIEW . "common/modal.php");?>