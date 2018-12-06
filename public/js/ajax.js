let ajaxURL = "http://bestpachul.com/application/ajax/ajax.php";
let callForm = $('#callForm');
let arr = [];
let i = arr.length;
let count = 0;

//근무시간, 임금 등 초기화
function initiate(time, callFunction = false, date=null) {
    console.log('initiate with time : '+time);
    $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
    $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
    $('#formAction').val('initiate');
    if(date!==null){
        $('#workDate').val(date);
        console.log("in initiate : "+$('#workDate').val());
    }
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: callForm.serialize(),
        dataType: "text",

        success: function (data) {

            console.log("success initiate : "+$('#workDate').val());

            let joinType    = JSON.parse(data).joinType;
            let callType    = JSON.parse(data).callType;
            let holiday     = JSON.parse(data).holiday;
            let callPrice   = JSON.parse(data).callPrice;

            getSalary(time, holiday);

            if (joinType !== 'deactivated') {
                if (callFunction === true) {
                    switch (callType) {
                        case 'free':
                            freeCall(data);
                            break;
                        case 'charged' :
                            chargedCall(data);
                            break;
                        case 'pointExceed':
                            alert('포인트가 부족합니다. 충전해주세요');
                            window.location.reload();
                            break;
                        default:
                            alert('Error 123');
                            break;
                    }
                }
                else {
                    switch (callType) {
                        case 'free':
                            $('#callPrice').val(0);
                            $('#submitBtn').html("콜 보내기");
                            if (joinType === 'point') {
                                if (holiday) {
                                    $('#callPoint').val(8000);
                                }
                                else $('#callPoint').val(6000);
                            }
                            break;
                        case 'charged':
                            $('#callPrice').val(callPrice);
                            $('#submitBtn').html("'유료' 콜 보내기 <br> 콜비 : " + callPrice + "원");
                            break;
                        case 'pointExceed':
                            $('#submitBtn').html("포인트 부족");
                            break;
                    }
                }
            }
            else {
                alert('만기된 회원입니다');
                window.location.reload();
            }
            return data;
        }
    });
}
//임금 계산 함수
function getSalary(time, holiday) {
    let money;
    if (holiday === true) {
        $('#date').css({'color': 'red', 'font-weight': 'bold'});
        if (parseInt(endHour.val()) * 100 + parseInt(endMin.val()) > 2400) {//야간
            switch (time) {
                case 5:
                    money = 57000;
                    break;
                case 6:
                    money = 64000;
                    break;
                case 7:
                    money = 71000;
                    break;
                case 8:
                    money = 78000;
                    break;
                case 9:
                    money = 85000;
                    break;
                case 10:
                    money = 92000;
                    break;
                case 11:
                    money = 96000;
                    break;
                case 12:
                    money = 100000;
                    break;
                default:
                    money = 0;
                    break;
            }
        }
        else {
            switch (time) {
                case 5:
                    money = 47000;
                    break;
                case 6:
                    money = 54000;
                    break;
                case 7:
                    money = 61000;
                    break;
                case 8:
                    money = 68000;
                    break;
                case 9:
                    money = 75000;
                    break;
                case 10:
                    money = 82000;
                    break;
                case 11:
                    money = 86000;
                    break;
                case 12:
                    money = 90000;
                    break;
                default:
                    money = 0;
                    break;
            }
        }
    }
    else {
        $('#date').css('color', 'black');
        if (parseInt(endHour.val()) * 100 + parseInt(endMin.val()) > 2400) {
            switch (time) {
                case 5:
                    money = 52000;
                    break;
                case 6:
                    money = 59000;
                    break;
                case 7:
                    money = 66000;
                    break;
                case 8:
                    money = 73000;
                    break;
                case 9:
                    money = 80000;
                    break;
                case 10:
                    money = 87000;
                    break;
                case 11:
                    money = 91000;
                    break;
                case 12:
                    money = 95000;
                    break;
                default:
                    money = 0;
                    break;
            }
        }
        else {
            switch (time) {
                case 5:
                    money = 42000;
                    break;
                case 6:
                    money = 49000;
                    break;
                case 7:
                    money = 56000;
                    break;
                case 8:
                    money = 63000;
                    break;
                case 9:
                    money = 70000;
                    break;
                case 10:
                    money = 77000;
                    break;
                case 11:
                    money = 81000;
                    break;
                case 12:
                    money = 85000;
                    break;
                default:
                    money = 0;
                    break;
            }
        }
    }
    salary.html("근무시간: " + time + " 시간 / 일당: " + money + " 원");
    $('#salary').val(money);
}
//콜 생성 함수
function call(time) {
    console.log('call with time : '+time);
    initiate(time, true);
}
//유료콜 보내기
function chargedCall(data) {
    if (confirm("유료콜입니다. 콜을 요청하시겠습니까?")) {
        $('#formAction').val('call');
        $.ajax({
            type: "POST",
            url: ajaxURL,
            method: "POST",
            data: $('#callForm').serialize(),
            dataType: "text",
            async: false,
            success: function (data) {
                alert('유료 콜을 보냈습니다.');
                if(pageType !=='call'){
                    window.location.reload();
                }
            }
        })
    }
    else {
        alert("콜을 취소했습니다.");
        if(pageType !=='call'){
            window.location.reload();
        }
    }
}
//무료콜 보내기
function freeCall(data) {

    console.log("in free call : "+$('#workDate').val());

    $('#submitBtn').html("콜 보내기");
    $('#formAction').val('call');
    $('#callPrice').val(0);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "http://bestpachul.com/application/ajax/ajax.php",
        data: $('#callForm').serialize(),
        dataType: "text",
        async: false,
        success: function (data) {

            console.log("success free call : "+$('#workDate').val());

            alert('무료 콜을 보냈습니다.');
            if(pageType !== 'call'){
                window.location.reload();
            }
        }
    })
}
//콜 취소 함수
function cancel() {
    $.ajax({
        type: "POST",
        url: "http://bestpachul.com/application/ajax/ajax.php",
        method: "POST",
        data: $('#callCancelForm').serialize(),
        dataType: "text",
        success: function (data) {
            window.location.reload();
        }
    });
}
//고정 콜 함수
function fix(time) {
    console.log('fix');
    $('#formAction').val('fix');
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        dataType: "text",
        data: callForm.serialize(),
        async: false,
    }).success(function (data) {
        console.log(data);
        let dateArray = JSON.parse(data);
        console.log(dateArray);
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
        url: "http://bestpachul.com/application/ajax/ajax.php",
        method: "POST",
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
    console.log(count);
    if (count < i) {
        $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
        $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
        $('#formAction').val('initiate');
        $.ajax({
            type: "POST",
            url: "http://bestpachul.com/application/ajax/ajax.php",
            method: "POST",
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