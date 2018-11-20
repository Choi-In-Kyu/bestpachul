<div class="board_list scroll_list right auto-center" style="overflow: hidden">
  <?php if (in_array($this->param->page_type, ['company', 'employee'])): ?>
      <h1>펑크 내역</h1>
  <?php else: ?>
      <div class="inline" style="width: 15%; height: 100%;">
          <div id="datepicker"></div>
          <div>
              <form id="day_form" action="" method="post"><input type="hidden" name="filter" value="day"><input
                          id="date" type="hidden" name="date"></form>
              <form action="" method="post"><input type="hidden" name="filter" value="today"><input
                          class="full_width filterBtn" type="submit" value="오늘"></form>
              <form action="" method="post"><input type="hidden" name="filter" value="week"><input
                          class="full_width filterBtn" type="submit" value="이번주"></form>
              <form action="" method="post"><input type="hidden" name="filter" value="month"><input
                          class="full_width filterBtn" type="submit" value="이번달"></form>
              <form action="" method="post"><input type="hidden" name="filter" value="all"><input
                          class="full_width filterBtn" type="submit" value="전체기간"></form>
          </div>
      </div>
  <?php endif; ?>
  <?php require_once 'punkTable.php' ?>
</div>
<!-- Update Join Modal -->
<div id="assignCancelModal" class="modal">
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
        <input id="closeModal" class="btn btn-danger" type="button" value="닫기">
    </div>
</div>
<script>
    $('.btn-assign').on('click', function () {
        window.location.href = '<?php echo $this->param->get_page ?>/assign/';
    });
    $('.selectable').on('click', function () {
        $('.selectable').removeClass('selected');
        $(this).addClass('selected');
    });
    $('.ui-datepicker-calendar').on('click', function () {
        $(this).addClass('selected');
        $(this).css('background', 'red');
    });
    <?php if (in_array($this->param->page_type, ['company', 'employee'])): ?>
    $('.board_list.scroll_list').css('height', 'auto');
    $('.board_list.scroll_list').css('margin-bottom', '100px');
    $('.scroll_tbody tbody').css('height', 'auto');
    <?php endif;?>
    // $('.employeeCancel').on('click',function () {
    //     event.stopPropagation();
    //     $('#assignCancelModal').show();
    //     $('input[name=callID]').val(this.id);
    //     $('input[name=employeeName]').val(this.innerText);
    // });
    // $('#closeModal').click(function () {
    //     $('#assignCancelModal').hide();
    // });
</script>
