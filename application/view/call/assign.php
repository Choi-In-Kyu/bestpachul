<div class="board_list scroll_list right auto-center" style="overflow: hidden">
  <?php require_once 'callTable.php'?>
    <div class="inline scroll_tbody employee">
        <table id="employeeTable">
            <?php require_once 'employeeRow.php'?>
        </table>
    </div>
</div>
<!-- Update Join Modal -->
<div id="assignCancelModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="assignCancel">
            <input type="hidden" name="callID">
            <input class="btn btn-insert" type="submit" value="배정취소">
        </form>
        <form action="" method="post">
            <input type="hidden" name="action" value="punk">
            <input type="hidden" name="callID">
            <input type="hidden" name="employeeName">
            <textarea id="punkDetail" name="detail" size="200">펑크사유: 무단잠수</textarea>
            <input class="btn btn-insert" type="submit" value="펑크">
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        <?php if(isset($_POST['callID'])):?>
            $('.callRow<?php echo '#'.$_POST['callID']?>').addClass('selected');
        <?php endif;?>
    });
    $('.selectable').on('click', function () {
        if ($(this).hasClass("callRow")) {$('.callRow').removeClass('selected');}
        else {$('.employeeRow').removeClass('selected');}
        $(this).addClass('selected');
    });
    $('.employeeCancel').on('click',function () {
        event.stopPropagation();
        $('#assignCancelModal').show();
        $('input[name=callID]').val(this.id);
        $('input[name=employeeName]').val(this.innerText);
    });
    $('.btn-submit').on('click',function () {
         let callID = $('.selected').attr('id');
         let employeeID = this.id;
        $('input[name=callID]').val(callID);
        $('input[name=employeeID]').val(employeeID);
    });
    $('.callRow').on('click',function () {
        $('#filterForm'+this.id).submit();
    });
</script>