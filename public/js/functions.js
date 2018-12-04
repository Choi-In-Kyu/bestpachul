//날짜 데이터 수정
let now = new Date();
if (now.getMonth() === 11) {nextmon = new Date(now.getFullYear() + 1, 0, 1);}
let today = dateFormat(now);
let nextMonth = dateFormat(new Date(now.getFullYear(), now.getMonth() + 1, 1));
let tomorrow = dateFormat(new Date(now.getTime() + 24 * 60 * 60 * 1000));
let dayaftertomorrow = dateFormat(new Date(now.getTime() + 2 * 24 * 60 * 60 * 1000));

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
function auto_insert() {
    $('#startDate').val(today);
    $('#endDate').val(nextMonth);
    $('#price').val(50000);
    document.getElementById('paid').checked = true;
}
//테이블 정렬 함수
function sortTable(tableName, n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(tableName);
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir === "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir === "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}