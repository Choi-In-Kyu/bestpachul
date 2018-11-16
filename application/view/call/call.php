<div class="board_list scroll_list right auto-center" style="overflow: hidden">
    <?php if(in_array($this->param->page_type,['company','employee']) ):?>
        <h1>콜 내역</h1>
    <?php endif;?>
    <div class="inline" style="width: 15%; height: 100%;">
        <div id="datepicker"></div>
        <div>
            <form id="day_form" action="" method="post"><input type="hidden" name="filter" value="day"><input id="date" type="hidden" name="date"></form>
            <form action="" method="post"><input type="hidden" name="filter" value="week"><input class="full_width" type="submit" value="이번주"></form>
            <form action="" method="post"><input type="hidden" name="filter" value="month"><input class="full_width" type="submit" value="이번달"></form>
        </div>
    </div>
    <?php require_once 'callTable.php'?>
</div>
<script>
    $('.btn-assign').on('click',function() {
        window.location.href ='<?php echo $this->param->get_page ?>/assign/';
    });
    $('.selectable').on('click',function () {
        $('.selectable').removeClass('selected');
        $(this).addClass('selected');
    });
    $('.ui-datepicker-calendar').on('click',function () {
        $(this).addClass('selected');
        $(this).css('background','red');
    });
</script>
