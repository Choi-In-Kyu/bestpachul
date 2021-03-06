//Datepicker의 오늘 날짜를 클릭 -> 콜 테이블을 오늘 날짜 기준으로 불러옴
// $(document).ready(function () {
//     $('.ui-state-highlight').click();
// });
$('.ui-datepicker-calendar').on('click', function () {
    $(this).addClass('selected');
    $(this).css('background', 'red');
});
$('.workDate').on('change', function () {
    $('#callForm #workDate').val($(this).val());
});
$('.endDate').on('change', function () {
    $('#callForm #endDate').val($(this).val());
});
$(document).on('click', '.assignBtn', function () {
    let callID = $('.callRow.selected').attr('id');
    let employeeID = this.id;
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'assign', callID: callID, employeeID: employeeID},
        dataType: "text",
        success: function (data) {
            $('.callRow.selected .assignedEmployee').html(JSON.parse(data));
        }
    });
});
$('.callRow').on('click', function () {
    if(!$(this).hasClass('cancelled')){
        getHTML($('#employeeTable'), 'assignFilter', $(this).attr('id'));
    }
    else{
        event.stopPropagation();
        alert('취소된 콜입니다');
    }

});