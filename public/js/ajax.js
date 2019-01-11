let ajaxURL = "http://bestpachul.com/application/ajax/ajax.php";
let callForm = $('#callForm');
let arr = [];
let i = arr.length;
let count = 0;

//근무시간, 임금 등 초기화
function initiate(time, callFunction = false, date = null) {
    $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
    $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
    $('#formAction').val('initiate');
    if (date !== null) {
        $('#workDate').val(date);
    }
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: callForm.serialize(),
        dataType: "text",

        success: function (data) {
            console.log(data);
            let joinType = JSON.parse(data).joinType;
            let callType = JSON.parse(data).callType;
            let holiday = JSON.parse(data).holiday;
            let callPrice = JSON.parse(data).callPrice;
            let bookmark = JSON.parse(data).bookmark;

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
                            $('#btnSendCall').html("콜 신청하기");
                            if (joinType === 'point') {
                                if (holiday) {
                                    $('#callPoint').val(8000);
                                }
                                else $('#callPoint').val(6000);
                            }
                            break;
                        case 'charged':
                            $('#callPrice').val(callPrice);
                            $('#btnSendCall').html("콜 신청하기 (콜비 : " + number_format(callPrice) + "원)");
                            break;
                        case 'pointExceed':
                            $('#btnSendCall').html("포인트 부족");
                            break;
                    }
                }
            }
            else {
                // if(bookmark){
                //     let confirmDeactivated = localStorage.getItem('confirmDeactivated');
                //     if(confirmDeactivated !== 'yes'){
                //         if(confirm("만기된 회원입니다 배정 하시겠습니까?")){
                //             localStorage.setItem('confirmDeactivated','yes');
                //         }
                //         else{
                //             window.location.reload();
                //         }
                //     }
                // }
                // else{
                    alert('만기된 회원입니다');
                    window.location.reload();
                // }
            }
            return data;
        }
    });
}

//임금 계산 함수
function getSalary(time, holiday) {
    let money;
    if (holiday === true) {//주말 공휴일
        $('#date').css({'color': 'red', 'font-weight': 'bold'});
        if (parseInt(endHour.val()) * 100 + parseInt(endMin.val()) > 2400) {//야간
            switch (time) {
                case 5:
                    money = 58000;
                    break;
                case 6:
                    money = 65000;
                    break;
                case 7:
                    money = 72000;
                    break;
                case 8:
                    money = 79000;
                    break;
                case 9:
                    money = 86000;
                    break;
                case 10:
                    money = 93000;
                    break;
                case 11:
                    money = 100000;
                    break;
                case 12:
                    money = 108500;
                    break;
                default:
                    money = 0;
                    break;
            }
        }
        else {
            switch (time) {
                case 5:
                    money = 48000;
                    break;
                case 6:
                    money = 55000;
                    break;
                case 7:
                    money = 62000;
                    break;
                case 8:
                    money = 69000;
                    break;
                case 9:
                    money = 76000;
                    break;
                case 10:
                    money = 83000;
                    break;
                case 11:
                    money = 90000;
                    break;
                case 12:
                    money = 98500;
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
                    money = 53000;
                    break;
                case 6:
                    money = 60000;
                    break;
                case 7:
                    money = 67000;
                    break;
                case 8:
                    money = 74000;
                    break;
                case 9:
                    money = 81000;
                    break;
                case 10:
                    money = 88000;
                    break;
                case 11:
                    money = 95000;
                    break;
                case 12:
                    money = 103500;
                    break;
                default:
                    money = 0;
                    break;
            }
        }
        else {
            switch (time) {
                case 5:
                    money = 43000;
                    break;
                case 6:
                    money = 50000;
                    break;
                case 7:
                    money = 57000;
                    break;
                case 8:
                    money = 64000;
                    break;
                case 9:
                    money = 71000;
                    break;
                case 10:
                    money = 78000;
                    break;
                case 11:
                    money = 85000;
                    break;
                case 12:
                    money = 93500;
                    break;
                default:
                    money = 0;
                    break;
            }
        }
    }
    salary.html("근무시간: " + time + " 시간 / 일당: " + number_format(parseInt(money)) + " 원");
    $('#salary').val(money);
}

//콜 생성 함수
function call(time) {initiate(time, true);}

//유료콜 보내기
function chargedCall(data) {
    if (confirm("콜비가 포함됩니다. 콜을 신청하시겠습니까?")) {
        $('#formAction').val('call');
        $.ajax({
            type: "POST",
            method: "POST",
            url: ajaxURL,
            data: $('#callForm').serialize(),
            dataType: "text",
            async: false,
            success: function (data) {
                alert('콜을 보냈습니다.');
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
}

//무료콜 보내기
function freeCall(data) {
    $('#btnSendCall').html("콜 신청하기");
    $('#formAction').val('call');
    $('#callPrice').val(0);
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: $('#callForm').serialize(),
        dataType: "text",
        async: false,
        success: function (data) {
            alert('콜을 신청했습니다.');
            if (pageType !== 'call') {
                window.location.reload();
            }
        }
    })
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
function getHTML(tableElement, action, id){
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