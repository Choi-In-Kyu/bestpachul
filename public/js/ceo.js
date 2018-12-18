let startHour = $('#startHour');
let endHour = $('#endHour');
let minute = $('.minute');
let endMin = $('#endMin');
let salary = $('#salaryInfo');
let date = $('#date');
let time = endHour.val() - startHour.val();

date.on('change', function () {
    initiate(endHour.val() - startHour.val());
});
minute.on('change', function () {
    minute.val($(this).val());
});
startHour.on('change', function () {
    limitTime(false);
});
$('#1day').click(function () {
    date.val(tomorrow);
    date.trigger('change');
});
$('#2day').click(function () {
    date.val(dayaftertomorrow);
    date.trigger('change');
});
$('#morningBtn').click(function () {
    startHour.val('10');
    endHour.val('15');
    minute.val('00');
    limitTime(false);
});
$('#afternoonBtn').click(function () {
    startHour.val('18');
    endHour.val('23');
    minute.val('00');
    limitTime(false);
});
$('#allDayBtn').click(function () {
    startHour.val('10');
    endHour.val('22');
    minute.val('00');
    let starth = parseInt(startHour.val());
    limitTime(true);
});
$('.btn-work-field').on('click', function () {
    $('#workField').val($(this).text());
});
$('.all-filter').on('change', function () {
    change('all');
});
$('.paid-filter').on('change', function () {
    change('paid');
});
$('.callList').click(function () {
    let callList = JSON.parse('<?php echo json_encode($this->callList)?>');
    let index = $(this).index();
    alert('요청사항 : ' + callList[index]['detail']);
});
$('#submitBtn').on('click', function () {
    call(endHour.val() - startHour.val());
});
$('.fixBtn').on('click', function () {
    $('#startTime').val($('#startHour').val() + ":" + $('#startMin').val()); //HH:MM
    $('#endTime').val($('#endHour').val() + ":" + $('#endMin').val()); //HH:MM
    fix(endHour.val() - startHour.val());
});
$(document).on('click', '.callCancelModalBtn', function () {
    event.stopPropagation();
    $('#callCancelID').val(this.id);
    $('#callCancelModal').show();
    $('#callCancelModal input[name=callID]').val(this.id);
});
$('#closeCallCancelModal').on('click', function () {
    $('#callCancelModal').hide();
});
$('#callCancelBtn').on('click', function () {
    cancel();
});
$('.total-price').on('click',function () {
    $('#payChargedCallModal').show();
});
$('#copyBtn').on('click',function () {
   copy();
});

function change(type) {
    let companyID = $('.user-profile').attr('id');
    let year;
    let month;
    let sum=0;
    if(type === 'all'){
        year = $('#all-year').val();
        month = $('#all-month').val();
    }
    else{
        year = $('#paid-year').val();
        month = $('#paid-month').val();
    }
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'getCallList', companyID: companyID, year: year, month: month, type: type},
        dataType: "text",
        success: function (data) {
            let body = JSON.parse(data).body;
            let total = JSON.parse(data).total;
            console.log(total);
            $('#'+type+'-call-list-body').html(body);
            if(type === 'paid'){
                $('.total-price').html('콜비 총 합: '+number_format(total)+'원');
                $('#pay-info').val($('#pay-info').val()+" "+total+'원');
            }
        }
    });
}
function limitTime(allday) {
    let starth = parseInt(startHour.val());
    if (allday !== true) {
        endHour.val(starth + 5);
    }
    for (let i = 0; i < 50; i++) {
        if ((i < starth + 4) || (i > starth + 11)) {
            $('.endOption').eq(i).css('display', 'none');
        }
        else {
            $('.endOption').eq(i).css('display', 'block');
        }
    }
    initiate(endHour.val() - startHour.val());
}

function copy() {
    let copyText = document.getElementById("pay-info");
    copyText.select();
    document.execCommand('copy');
}