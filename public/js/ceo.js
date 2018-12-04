let startHour = $('#startHour');
let endHour = $('#endHour');
let minute = $('.minute');
// let submit = $('#submitBtn');
// let fixBtn = $('#fixBtn');
let endMin = $('#endMin');
let salary = $('#salaryInfo');
let date = $('#date');
let time = endHour.val() - startHour.val();

minute.on('change', function () {
    minute.val($(this).val());
});
date.on('change', function () {
    initiate(endHour.val() - startHour.val());
});
startHour.on('change', function () {
    let starth = parseInt(startHour.val());
    endHour.val(starth + 5);
    for (let i = 0; i < 50; i++) {
        if ((i < starth + 4) || (i > starth + 11)) {
            $('.endOption').eq(i).css('display', 'none');
        }
        else {
            $('.endOption').eq(i).css('display', 'block');
        }
    }
    initiate(endHour.val() - startHour.val());
});
endHour.on('change', function () {
    initiate(endHour.val() - startHour.val())
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
    startHour.trigger('change');
});
$('#afternoonBtn').click(function () {
    startHour.val('18');
    endHour.val('23');
    minute.val('00');
    startHour.trigger('change');
});
$('#allDayBtn').click(function () {
    startHour.val('10');
    endHour.val('22');
    minute.val('00');
    let starth = parseInt(startHour.val());
    for (let i = 0; i < 50; i++) {
        if ((i < starth + 5) || (i > starth + 11)) {
            $('.endOption').eq(i).css('display', 'none');
        }
        else {
            $('.endOption').eq(i).css('display', 'block');
        }
    }
    initiate(endHour.val() - startHour.val())
});
$('#dish').click(function () {
    $('#workField').val('설거지');
});
$('#kitchen').click(function () {
    $('#workField').val('주방보조');
});
$('#hall').click(function () {
    $('#workField').val('홀서빙');
});
$('#submitBtn').on('click',function () {
    call();
});
$('#callBtn').on('click',function () {
    call()
});
$('#fixBtn').on('click',function () {
    $('#startTime').val($('#startHour').val() + ":" + $('#startMin').val()); //HH:MM
    $('#endTime').val($('#endHour').val() + ":" + $('#endMin').val()); //HH:MM
    $('#fixed').val(1);
    fix();
});