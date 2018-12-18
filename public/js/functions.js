//날짜 데이터 수정
let now = new Date();
let y = now.getFullYear();
let m = now.getMonth();
let d = now.getDate();

let today = dateFormat(now);
let nextMonth;
if (now.getMonth() === 11) {
    nextMon = new Date(y + 1, 0, d);
}//내년 1월
else {
    nextMon = new Date(y, m + 1, d);
}//올해 다음달
nextMonth = dateFormat(nextMon);
let tomorrow = dateFormat(new Date(now.getTime() + 24 * 60 * 60 * 1000));
let dayaftertomorrow = dateFormat(new Date(now.getTime() + 2 * 24 * 60 * 60 * 1000));
let thisMonFirstDay = dateFormat(new Date(y, m, 1));
let thisMonLastDay = dateFormat(new Date(y, m + 1, 0));

//js 날짜 -> YYYY-mm-dd 수정 함수
function dateFormat(date) {
    let day = ("0" + date.getDate()).slice(-2);
    let month = ("0" + (date.getMonth() + 1)).slice(-2);
    return date.getFullYear() + "-" + (month) + "-" + (day);
}

//업체 유형별 가입추가 토글 기능
function type_toggle(argument) {
    $('#detail_table').html($('#companyAddJoinTable_' + argument + '').html());
}

//인력 가입 자동입력 함수
function auto_insert_employee_join() {
    $('#startDate').val(today);
    $('#endDate').val(nextMonth);
    $('#price').val(50000);
    document.getElementById('paid').checked = true;
}

//월급제 자동입력
function auto_insert_call_monthly() {
    $('.workDate').val(thisMonFirstDay);
    $('.endDate').val(thisMonLastDay);
}

//1000 단위로 콤마
function number_format(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// //테이블 정렬 함수
// function sortTable(tableName, n) {
//     var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
//     table = document.getElementById(tableName);
//     switching = true;
//     dir = "asc";
//     while (switching) {
//         switching = false;
//         rows = table.rows;
//         for (i = 1; i < (rows.length - 1); i++) {
//             shouldSwitch = false;
//             x = rows[i].getElementsByTagName("TD")[n];
//             y = rows[i + 1].getElementsByTagName("TD")[n];
//             if (dir === "asc") {
//                 if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
//                     //if so, mark as a switch and break the loop:
//                     shouldSwitch = true;
//                     break;
//                 }
//             } else if (dir === "desc") {
//                 if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
//                     //if so, mark as a switch and break the loop:
//                     shouldSwitch = true;
//                     break;
//                 }
//             }
//         }
//         if (shouldSwitch) {
//             rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
//             switching = true;
//             switchcount++;
//         } else {
//             if (switchcount === 0 && dir === "asc") {
//                 dir = "desc";
//                 switching = true;
//             }
//         }
//     }
// }