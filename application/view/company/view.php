<?php require_once 'write.php' ?>
<?php require_once 'companyJoinTable.php'?>
<?php require_once (_VIEW . "call/call.php");?>
<?php require_once(_VIEW . "common/modal.php") ?>
<script>
    $(document).ready(function () {
        detail_table.innerHTML = document.getElementById('companyAddJoinTable_gujwa').innerHTML;
    });
</script>