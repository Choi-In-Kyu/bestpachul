let startHour = $('#startHour');
let endHour = $('#endHour');
let minute = $('.minute');
let endMin = $('#endMin');
let salary = $('#salaryInfo');
let date = $('#date');
let time = endHour.val() - startHour.val();

minute.on('change', function () {
    minute.val($(this).val());
});

startHour.on('change', function () {
    limitTime(false);
});

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

$('.workFieldBtn').on('click',function () {
    $('#workField').val($(this).text());
});


$('#submitBtn').on('click', function () {
    call(endHour.val() - startHour.val());
});
$('.fixBtn').on('click', function () {
    $('#startTime').val($('#startHour').val() + ":" + $('#startMin').val()); //HH:MM
    $('#endTime').val($('#endHour').val() + ":" + $('#endMin').val()); //HH:MM
    fix(endHour.val() - startHour.val());
});

function map(element, value){
    element.val(value);
}