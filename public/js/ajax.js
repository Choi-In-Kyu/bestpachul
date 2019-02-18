let ajaxURL = "http://bestpchul.com/application/ajax/ajax.php";
let callForm = $('#callForm');
let arr = [];
let i = arr.length;
let count = 0;

//임금 계산 함수
function getSalary(start_time, end_time, date) {
    let salary = $('#salaryInfo');
    let price_table = {
        'holiday': {
            'night': {//주말야간
                5: 58000,
                6: 65000,
                7: 72000,
                8: 79000,
                9: 86000,
                10: 93000,
                11: 100000,
                12: 108500
            },
            'day': {//주말주간
                5: 48000,
                6: 55000,
                7: 62000,
                8: 69000,
                9: 76000,
                10: 83000,
                11: 90000,
                12: 98500
            }
        },
        'weekday': {
            'night': {//평일야간
                5: 53000,
                6: 60000,
                7: 67000,
                8: 74000,
                9: 81000,
                10: 88000,
                11: 95000,
                12: 103500
            },
            'day': {//평일주간
                5: 43000,
                6: 50000,
                7: 57000,
                8: 64000,
                9: 71000,
                10: 78000,
                11: 85000,
                12: 93500
            }
        }
    };
    let time = end_time - start_time;
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action:'check_holiday',date:date},
        dataType: "text",
        async: false,
        success: function (data) {
            let holiday = JSON.parse(data).holiday;
            let money = 0;
            if(holiday){
                if(end_time>=24){money = price_table.holiday.night[time];}//주말야간
                else{money = price_table.holiday.day[time];}//주말주간
                $('input.workDate').css('color','red');
            }
            else{
                if(end_time >=24){money  = price_table.weekday.night[time];}//평일야간
                else{money  = price_table.weekday.day[time];}//평일주간
                $('input.workDate').css('color','black');
            }
            salary.html("근무시간: " + time + " 시간 / 일당: " + number_format(parseInt(money)) + " 원");
            $('#salary').val(money);
        }
    });
}

//콜 취소 함수
function cancel() {
    event.stopPropagation();
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: $('#formCallCancel').serialize(),
        dataType: "text",
        success: function (data) {
            window.location.reload();
            $(this).closest('tr').css('background', 'red');
        }
    });
}

//고정 콜 함수
function fix(time) {
    $('#formAction').val('fix');
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        dataType: "text",
        data: callForm.serialize(),
        async: false,
    }).success(function (data) {
        let dateArray = JSON.parse(data).dateArray;
        let fixID = parseInt(JSON.parse(data).fixID);
        $('#fixID').val(fixID);
        for (let date in dateArray) {
            myFix(dateArray[date]);
            // initiate(time,true,dateArray[date]);
        }
    });
}

//무료콜, 유료콜, 포인트 부족의 상태 확인
function myFix(date) {
    $('#workDate').val(date);
    $('#formAction').val('initiate');
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: $('#callForm').serialize(),
        dataType: "text",
        async: false,
        success: function (data) {
            let callType = JSON.parse(data).callType;
            if (callType === 'free') {
                freeCall(data);
            }
            if (callType === 'charged') {
                chargedCall(data);
            }
            else if (callType === 'pointExceed') {
                alert('포인트가 부족합니다. 충전해주세요');
                window.location.reload();
            }
            recursive();
        }
    });
    count++;
}

//고정 콜 함수 내 반복 함수
function recursive() {
    if (count < i) {
        $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
        $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
        $('#formAction').val('initiate');
        $.ajax({
            type: "POST",
            method: "POST",
            url: ajaxURL,
            data: $('#callForm').serialize(),
            dataType: "text",
            success: function (data) {
                let callType = JSON.parse(data).callType;
                if (callType === 'free') {
                    freeCall(data);
                }
                if (callType === 'charged') {
                    chargedCall(data);
                }
                else if (callType === 'pointExceed') {
                    alert('포인트가 부족합니다. 충전해주세요');
                    window.location.reload();
                }
                recursive();
            }
        });
        count++;
    }
}

//HTML 리턴에 따른 테이블 출력
function getHTML(tableElement, action, id) {
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: action, id: id},
        dataType: "text",
        success: function (data) {
            tableElement.html(JSON.parse(data));
        }
    });
}