// 기본 함수
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

// 모달 내에서 작동하는 함수
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

// 버튼, 행 클릭 함수
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