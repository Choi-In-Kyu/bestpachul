<script>

    // Company, Employee Page Mapping
    <?php if (in_array($this->param->page_type, ['company', 'employee'])): ?>
    $('.board_list.scroll_list').css({'height': 'auto', 'margin-bottom': '100px'});
    $('.scroll_tbody tbody').css('height', 'auto');
    <?php endif;?>

    // Basic Functions
    $('.selectable').on('click', function () {
        $('.selectable').removeClass('selected');
        $(this).addClass('selected');
    });
    $('.ui-datepicker-calendar').on('click', function () {
        $(this).addClass('selected');
        $(this).css('background', 'red');
    });
    $('.moveAssignBtn').on('click', function () {
        $('#filterForm').attr("action","http://bestpachul.com/call/assign");
        $('input[name=callID]').val(this.id);
        $('#filterForm').submit();
    });

    // Modal Functions
    $('.callCancelBtn').on('click', function () {
        event.stopPropagation();
        $('#callCancelModal').show();
        $('input[name=callID]').val(this.id);
    });
    $('.assignCancelBtn').on('click', function () {
        event.stopPropagation();
        $('#assignCancelModal').show();
        $('input[name=callID]').val(this.id);
        $('input[name=employeeName]').val(this.innerText);
    });
    $('#closeAssignCancelModal').click(function () {
        $('#assignCancelModal').hide();
    });
    $('#closeCallCancelModal').click(function () {
        $('#callCancelModal').hide();
    });

    // Assign Page Functions
    <?php if ($this->param->action == 'assign'): ?>
    $(document).ready(function () {
      <?php if(isset($_POST['callID'])):?>
        $('.callRow<?php echo '#' . $_POST['callID']?>').addClass('selected');
      <?php endif;?>
    });
    $('.assignBtn').on('click', function () {
        let callID = $('.selected').attr('id');
        let employeeID = this.id;
        $('input[name=callID]').val(callID);
        $('input[name=employeeID]').val(employeeID);
    });
    $('.callRow').on('click', function () {
        $('input[name=callID]').val(this.id);
        $('#filterForm').submit();
    });
    <?php endif;?>

</script>