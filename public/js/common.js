let mainUrl     = "http://bestpachul.com/";
let pageType    = window.location.href.replace(mainUrl, '').split('/')[0];
let pageAction  = window.location.href.replace(mainUrl, '').split('/')[1];
let pageID      = window.location.href.replace(mainUrl, '').split('/')[2];

//메인 페이지 정렬, 필터링
$('.filter').on('click', function () {
    let filter = $(this).attr('id').replace('filter-', '');
    $('#formRefresh input[name=filter]').val(filter);
    $('#formRefresh').submit();
});
$('.order').on('click', function () {
    let order = $(this).attr('id').replace('refresh-', '');
    console.log(order);
    $('#formRefresh input[name=order]').val(order);
    if ($('#formRefresh input[name=direction]').val() === 'ASC') {
        $('#formRefresh input[name=direction]').val('DESC');
    }
    else {
        $('#formRefresh input[name=direction]').val('ASC');
    }
    $('#formRefresh').submit();
});
$('#btnSearch').on('click', function () {
    let keyword = $('#inputKeyword').val();
    $('#formRefresh input[name=keyword]').val(keyword);
    $('#formRefresh').submit();
});

//북마크 별표 클릭
$('.fa-star.selectable').on('click', function () {
    let btn = $(this);
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'bookmark', id: btn.attr('id'), tableName: pageType},
        dataType: "text",
        success: function (data) {
            let bookmark = parseInt(JSON.parse(data).bookmark);
            let imminent = parseInt(JSON.parse(data).imminent);
            console.log(imminent);
            if (bookmark === 1) {
                btn.addClass('checked');
                btn.removeClass('unchecked');
                btn.closest('tr').addClass('imminent');
            } else {
                btn.addClass('unchecked');
                btn.removeClass('checked');
                if (imminent === 0) {
                    btn.closest('tr').removeClass('imminent');
                }
            }
        }
    });
});
//삭제 모달 여는 버튼
$('.btn-delete-modal').on('click', function () {
    console.log($(this).val());
    $('#modalDelete').show();
    $('#deleteTable').val($(this).val().split('-')[0]);
    $('#deleteID').val($(this).val().split('-')[1]);
});
//가입취소 모달 여는 버튼
$('.btn-join-cancel-modal').on('click',function () {
    $('#modalJoinCancel').show();
    $('#joinDeleteTable').val($(this).val().split('-')[0]);
    $('#joinDeleteID').val($(this).val().split('-')[1]);
});
//가입추가 버튼
$('#btnAddJoin').on('click', function () {
    let btn = $(this);
    $('#addJoinForm').slideToggle('fast', function () {
        if ($(this).is(':visible')) btn.text('취소');
        else btn.text('가입추가');
    });
});
//모달 닫기 버튼
$('.btn-close-modal').on('click', function () {
    $('.modal').hide();
});
//가입내역 수정 버튼
$('.update').click(function () {
    let id = $(this).parent().children('.join_id').html();
    let price = $(this).parent().children('.join_price').html();
    let detail = $(this).parent().children('.join_detail').html();
    let joinDetail = detail.split('<br>')[0];
    $('#modalJoinUpdate').show();
    $('#updateID').val(id);
    $('#updatePrice').val(parseInt(price.replace(',', '')));
    $('#updateDetail').text(joinDetail);
});
//콜 내역 수정
$('.update-call').on('click',function () {
    console.log('update call clicked');
    let id = $(this).parent().attr('id');
    let price = $(this).parent().find('.btn-money').text();
    let detail = $(this).find('.call-detail').text();
    $('#modalCallUpdate').show();
    $('#formUpdateCall input[name=callID]').val(id);
    $('#formUpdateCall input[name=price]').val(parseInt(price.replace(',', '')));
    $('#formUpdateCall textarea[name=detail]').text(detail);
});


$(document).on('click','.btn-money',function () {
    let table = $(this).val().split('-')[0];
    let price = $(this).val().split('-')[1];
    let id = $(this).attr('id');
    $('#modalGetMoney').show();
    $('#inputGetMoneyTable').val(table);
    $('#inputGetMoneyValue').val(price);
    $('#inputGetMoneyID').val(id);
});

$('#btnGetMoney').on('click',function () {
    let table       = $('#inputGetMoneyTable').val();
    let value       = $('#inputGetMoneyValue').val();
    let id          = $('#inputGetMoneyID').val();
    let receiver    = $('textarea#inputGetMoneyReceiver').val();
    let btn         = $('tr#'+id).find('.btn-money')
    let td          = btn.closest('td');
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'getMoney',table:table, id: id, value:value, receiver:receiver},
        dataType: "text",
        success: function (data) {
            btn.hide();
            td.html('<b>'+btn.text()+'</b><br>수금('+receiver+')');
            $('.modal').hide();
        }
    });
});

// 모달 내에서 작동하는 함수
$(document).on('click','.btn-call-cancel-modal', function () {
    event.stopPropagation();
    $('#modalCallCancel').show();
    $('input[name=callID]').val(this.id);
});
$('#btnCallCancel').on('click', function () {
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: $('#formCallCancel').serialize(),
        dataType: "text",
        success: function (data) {
            let id = $('#callCancelID').val();
            let tr = $('.callRow[id=' + id + ']');
            let btn = $('.btn-call-cancel-modal[id=' + id + ']');

            console.log(data);
            console.log(tr);


            $('#modalCallCancel').hide();
            btn.hide();
            tr.closest('td').html('취소됨');
            tr.closest('tr').addClass('cancelled');
        }
    });
});
$('#btnDelete').on('click', function () {
    let table = $('#deleteTable').val();
    let id = $('#deleteID').val();
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: $('#formDelete').serialize(),
        dataType: "text",
        success: function (data) {
            let tr = $('.tr-'+table+'[id=' + id + ']');
            let btn = $('.btn-delete-modal[id=' + id + ']');
            $('.modal').hide();
            btn.hide();
            btn.closest('td').html('삭제됨');
            tr.closest('tr').addClass('deleted');
        }
    });
});
$('#btnJoinCancel').on('click', function () {
    let table = $('#joinDeleteTable').val();
    let id = $('#joinDeleteID').val();
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: $('#formJoinCancel').serialize(),
        dataType: "text",
        success: function (data) {
            console.log(data);

            console.log(table);

            let tr = $('.tr-'+table+'[id=' + id + ']');
            let btn = $('.btn-join-cancel-modal[id=' + id + ']');
            $('.modal').hide();
            btn.hide();
            btn.closest('td').html('삭제됨');
            tr.closest('tr').addClass('deleted');
        }
    });
});
$('.fixCancelBtn').on('click', function () {
    $('#modalFixCancel').show();
    $('input[name=fixID]').val(this.id);
});
$('.btn-restore').on('click', function () {
    let btn = $(this);
    let table = $(this).val().split('-')[0];
    let id = $(this).val().split('-')[1];
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'restore', table: table, id: id},
        dataType: "text",
        success: function (data) {
            console.log(data);
            btn.hide();
            btn.closest('td').html('복구');
            tr.closest('tr').removeClass('deleted');
        }
    });
});
$(document).on('click','.btn-money',function () {
    event.stopPropagation();
    let table = $(this).val().split('-')[0];
    let value = $(this).val().split('-')[1];
    $('#modalGetMoney').show();
    $('#inputGetMoneyTable').val(table);
    $('#inputGetMoneyValue').val(value);
});
$(document).on('click', '.assignCancelBtn', function () {
    let employeeID = $(this).closest('td').attr('id');
    event.stopPropagation();
    $('#modalAssignCancel').show();
    $('#modalAssignCancel input[name=callID]').val(this.id);
    $('#modalAssignCancel input[name=employeeID]').val(employeeID);
    // $('input[name=employeeName]').val(this.innerText);
});

//Iphone Style Toggle Checkbox
(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
ga('create', 'UA-46156385-1', 'cssscript.com');
ga('send', 'pageview');