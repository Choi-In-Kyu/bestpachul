let mainUrl = "http://bestpachul.com/";
let pageType = window.location.href.replace(mainUrl, '').split('/')[0];
let pageAction = window.location.href.replace(mainUrl, '').split('/')[1];

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
            let type = parseInt(data);
            if (type === 1) {
                btn.addClass('checked');
                btn.removeClass('unchecked');
                btn.closest('tr').css('background', 'yellow');
            }
            else {
                btn.addClass('unchecked');
                btn.removeClass('checked');
                btn.closest('tr').css('background', 'none');
            }
        }
    });
});
//삭제 모달 여는 버튼
$('.deleteModalBtn').on('click', function () {
    $('#deleteModal').show();
    $('#modal-deleteID').val($(this).val());
});
//가입취소 모달 여는 버튼
$('.joinCancelModalBtn').click(function () {
    $('#joinCancelModal').show();
    $('#modal-joinID').val(this.value);
});
//가입추가 버튼
$('#addJoinBtn').on('click', function () {
    let btn = $(this);
    $('#addJoinForm').slideToggle('fast', function () {
        if ($(this).is(':visible')) btn.text('취소');
        else btn.text('가입추가');
    });
});
//모달 닫기 버튼
$('.closeModal').on('click', function () {
    $('.modal').hide();
});
//가입내역 수정 버튼
$('.update').click(function () {
    let id = $(this).parent().children('.join_id').html();
    let price = $(this).parent().children('.join_price').html();
    let detail = $(this).parent().children('.join_detail').html();
    $('#joinUpdateModal').show();
    $('#updateID').val(id);
    $('#updatePrice').val(parseInt(price.replace(',', '')));
    $('#updateDetail').text(detail.replace('<br>', '\n'));
});
//버튼 클릭 이벤트
$('.selectable').on('click', function () {
    $('.selected').removeClass('selected');
    $('.selected').addClass('selectable');
    $(this).addClass('selected');
    $(this).removeClass('selectable');
});
//수금 버튼
$('.getMoneyBtn_call').on('click', function () {
    event.stopPropagation();
    let thisBtn = $(this);
    getMoney('call', thisBtn);
});
$('.getMoneyBtn_join_employee').on('click', function () {
    event.stopPropagation();
    let thisBtn = $(this);
    getMoney('join_employee', thisBtn);
});
$('.getMoneyBtn_fix').on('click', function () {
    event.stopPropagation();
    let thisBtn = $(this);
    getMoney('fix', thisBtn);
});

function getMoney(tableName, thisBtn) {
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'getMoney', id: thisBtn.attr('id'), tableName: tableName},
        dataType: "text",
        success: function (data) {
            thisBtn.closest('td').html('수금완료');
        }
    });
}

// 모달 내에서 작동하는 함수
$(document).on('click', '.callCancelBtn', function () {
    event.stopPropagation();
    $('#callCancelModal').show();
    $('input[name=callID]').val(this.id);
});
$('.fixCancelBtn').on('click', function () {
    $('#fixCancelModal').show();
    $('input[name=fixID]').val(this.id);
});
$(document).on('click', '.assignCancelBtn', function () {
    event.stopPropagation();
    $('#assignCancelModal').show();
    $('input[name=callID]').val(this.id);
    $('input[name=employeeName]').val(this.innerText);
});
$('#closeAssignCancelModal').click(function () {
    $('#assignCancelModal').hide();
});
$('#closeCallCancelModal').click(function () {
    $('#callCancelModal').hide();
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