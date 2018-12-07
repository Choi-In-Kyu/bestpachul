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
$('.workDate').on('change',function () {
    $('#callForm #workDate').val($(this).val());
});
$('.endDate').on('change',function () {
    $('#callForm #endDate').val($(this).val());
});


// 버튼, 행 클릭 함수
$('.assignBtn').on('click', function () {
    let callID = $('.selected').attr('id');
    let employeeID = this.id;
    $('input[name=callID]').val(callID);
    $('input[name=employeeID]').val(employeeID);
});
$('.callRow').on('click', function () {
    if(pageAction === 'assign'){
        console.log('공사 시작');
        let callID = $(this).attr('id');
        $.ajax({
            type: "POST",
            method: "POST",
            url: ajaxURL,
            data: {action:'assignFilter', callID:callID},
            dataType: "text",
            success: function (data) {
                console.log(data);
            }
        });
    }
});