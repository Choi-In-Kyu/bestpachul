let start_hour = $('#startHour');
let end_hour = $('#endHour');
let first_start_hour = 10;//근무 시작 시간 기본값
let first_end_hour = 15;//근무 종료 시간 기본값
let work_field = $('#workField');
let work_date = $('#workDate');

$(document).ready(function () {//다른 js 파일 모두 불러온 뒤 함수 내용이 실행됨
    ready();
    if(pageType !== 'ceo'){
        input_company();
        input_employee();
    }
    input_work_date();
    input_work_time();
    input_work_field();
    send_call();
});

function ready() {
    start_hour.val(first_start_hour);
    end_hour.val(first_end_hour);
    work_field.val('주방보조');
    if(pageType !== 'ceo'){
        $('.callBtn:not(#btnSendCall)').hide();
        $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', true);
    }
    $('input.workDate').prop('min', today);
    getSalary(first_start_hour, first_end_hour, tomorrow);
}

function input_company() {
    $('#companyName').on('input', function () {
        console.log('on input company name');
        let id_element = $('#companyID');
        let name_element = $(this);
        console.log(name_element);
        $('.workDate').val(tomorrow);
        $('.workDate').trigger('input');
        match_company_id(id_element, name_element);
        get_join_type(name_element, work_date.val());
    });
}

function match_company_id(id_element, name_element) {
    let company_name = name_element.val();
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'get_company_id', name: company_name},
        dataType: "text",
        async: true,
        success: function (data) {
            let error = JSON.parse(data).error;
            if (error) {
                console.log(error);
                $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', true);
                $('#errorMsg h2').html(error);
                $('#errorMsg').show();
                id_element.val(null);
            }
            else {
                $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', false);
                id_element.val(data);
            }
        },
    });
}

function get_join_type(name_element, date) {
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'get_join_type', name: name_element.val(), date: date},
        dataType: "text",
        async: true,
        success: function (data) {
            let join_type = JSON.parse(data).joinType;
            let size = JSON.parse(data).size;
            let end_date = JSON.parse(data).endDate;
            let call_type = JSON.parse(data).callType;
            let call_price = JSON.parse(data).callPrice;
            let error = JSON.parse(data).error;
            if (error) {
                console.log(error);
                $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', true);
                $('#errorMsg h2').html(error);
                $('#errorMsg').show();
            }
            else {
                $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', false);
                $('#errorMsg h2').html(join_type + " (" + size + "개 가입)");
                $('#errorMsg').show();
                if (join_type === '구좌') {
                    $('input.workDate').prop('max', end_date);
                }
                if (call_price) {
                    $('#btnSendCall').html("콜 신청하기 <br>" + "콜비 : " + call_price + "원");
                    $('#callPrice').val(call_price);
                }
                else {
                    $('#btnSendCall').html("콜 신청하기");
                }
            }
        }
    });
}

function input_work_date() {
    let workDate = $('.workDate');
    let btn1 = $('#tomorrow');
    let btn2 = $('#dayAfterTomorrow');
    workDate.on('input', function () {
        let date = $(this).val();
        if (date === tomorrow) {//내일 날짜 선택 시
            btn1.addClass('selected');
            btn2.removeClass('selected');
        }
        else if (date === dayaftertomorrow) {//모레 날짜 선택 시
            btn1.removeClass('selected');
            btn2.addClass('selected');
        }
        else {//내일, 모레 아닌 날짜 선택 시
            btn1.removeClass('selected');
            btn2.removeClass('selected');
        }
        getSalary(start_hour.val(), end_hour.val(), $(this).val());
        if(pageType !== 'ceo'){
            let name_element = $('#companyName');
            get_join_type(name_element, $(this).val());//match 된 companyID 사용
        }
    });
    btn1.on('click', function () {
        workDate.val(tomorrow);
        workDate.trigger('input');
    });
    btn2.on('click', function () {
        workDate.val(dayaftertomorrow);
        workDate.trigger('input');
    });
}

function limit_end_time(starth, endOption) {
    console.log(starth);
    for (let i = 0; i < 50; i++) {
        if ((i < starth + 4) || (i > starth + 11)) {
            endOption.eq(i).css('display', 'none');
        }
        else {
            endOption.eq(i).css('display', 'block');
        }
    }
}

function map_time_to_btn(starth, endh) {
    if (endh - starth >= 10) {//종일
        $('#allDayBtn').addClass('selected');
        $('#allDayBtn').closest('div').find('.btn-option:not(#allDayBtn)').removeClass('selected');
    }
    else {
        if (starth < 12) {//오전
            $('#morningBtn').addClass('selected');
            $('#morningBtn').closest('div').find('.btn-option:not(#morningBtn)').removeClass('selected');
        }
        else {//종일
            $('#afternoonBtn').addClass('selected');
            $('#afternoonBtn').closest('div').find('.btn-option:not(#afternoonBtn)').removeClass('selected');
        }
    }
}

function input_work_time() {
    //front input values
    let start = $('#startHour');
    let end = $('#endHour');
    let minute = $('.minute');
    let workDate = $('.workDate');
    let endOption = $('.endOption');

    //real input values
    let start_time = $('#startTime');
    let end_time = $('#endTime');

    start.on('input', function () {
        let starth = parseInt($(this).val());
        let endh = starth + 5;
        end.val(endh);
        start_time.val(starth + ':' + $('#startMin').val());
        end_time.val(endh + ':' + $('#startMin').val());
        limit_end_time(starth, endOption);
        map_time_to_btn(starth, endh);
        getSalary(start.val(), end.val(), workDate.val());
    });
    end.on('input', function () {
        let starth = parseInt(start.val());
        let endh = parseInt($(this).val());
        start_time.val(starth + ':' + $('#endMin').val());
        end_time.val(endh + ':' + $('#endMin').val());
        limit_end_time(starth, endOption);
        map_time_to_btn(starth, endh);
        getSalary(start.val(), end.val(), workDate.val());
    });
    minute.on('input', function () {
        minute.val($(this).val());
        start_time.val(start.val() + ':' + minute.val());
        end_time.val(end.val() + ':' + minute.val());
    });

    $('#morningBtn').on('click', function () {
        start_hour.val('10');
        end_hour.val('15');
        minute.val('00');
        start.trigger('input');
        minute.trigger('input');
    });
    $('#afternoonBtn').on('click', function () {
        start_hour.val('18');
        end_hour.val('23');
        minute.val('00');
        start.trigger('input');
        minute.trigger('input');
    });
    $('#allDayBtn').on('click', function () {
        start_hour.val('10');
        end_hour.val('21');
        minute.val('00');
        end.trigger('input');
        minute.trigger('input');
    });
}

function input_work_field() {
    work_field.on('input', function () {
        let value = $(this).val();
        if (value === '설거지') {
            let btn = $('.btn-option.wash');
            btn.closest('div').find('.btn-option').removeClass('selected');
            btn.addClass('selected');
        }
        else if (value === '주방보조') {
            let btn = $('.btn-option.kitchen');
            btn.closest('div').find('.btn-option').removeClass('selected');
            btn.addClass('selected');
        }
        else if (value === '홀서빙') {
            let btn = $('.btn-option.hall');
            btn.closest('div').find('.btn-option').removeClass('selected');
            btn.addClass('selected');
        }
        else {
            let btn = $('.btn-option.wash');
            btn.closest('div').find('.btn-option').removeClass('selected');
        }
    });
    $('.btn-work-field').on('click', function () {
        work_field.val($(this).text());
    });
}

function input_employee() {
    $('#employeeName').on('input', function () {
        $('#formAction').val('getEmployeeID');
        $.ajax({
            type: "POST",
            url: ajaxURL,
            method: "POST",
            data: $('#callForm').serialize(),
            dataType: "text",
            success: function (data) {
                $('#employeeID').val(data);
            }
        });
        set_validity($(this), 'employee');
    });
}

function send_call() {
    $('#btnSendCall').on('click', function () {
        if (confirm("콜을 신청하시겠습니까?")) {
            $('#formAction').val('call');
            $.ajax({
                type: "POST",
                method: "POST",
                url: ajaxURL,
                data: $('#callForm').serialize(),
                dataType: "text",
                async: false,
                success: function (data) {
                    console.log(data);
                    alert('콜을 보냈습니다!');
                    if (pageType !== 'call') {
                        window.location.reload();
                    }
                }
            })
        }
        else {
            alert("콜을 취소했습니다.");
            if (pageType !== 'call') {
                window.location.reload();
            }
        }
    });
}

$('#percentage').on('input', function () {
    $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
    $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
});
$('#monthlySalary').on('input', function () {
    $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
    $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
});
$('#manualCallBtn').on('click', function () {
    $('.callBtn').hide();
    $('#btnSendCall').show();
    $('.basic').slideDown();
    $('.monthly').slideUp();
    $('.fixable').slideUp();
});
$('#fixCallBtn').on('click', function () {
    $('.callBtn').hide();
    $('#submitFixedCallBtn').show();
    $('.endDate').css('display', 'inline');
    $('.basic').slideUp();
    $('.monthly').slideUp();
    $('.fixable').slideDown();
});
$('#monthlyCallBtn').on('click', function () {
    $('.callBtn').hide();
    $('#submitMonthlyCallBtn').show();
    $('.endDate').css('display', 'inline');
    $('.endDate').val();
    $('.basic').slideUp();
    $('.fixable').slideDown();
    $('.monthly').slideDown();
});
$('.btn-option').on('click', function () {
    $(this).closest('div').find('.btn-option').removeClass("selected");
    $(this).addClass('selected');
});