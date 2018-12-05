let mainUrl = "http://bestpachul.com/";
let pageType = window.location.href.replace(mainUrl,'').split('/')[0];

//북마크 별표 클릭
$('.fa-star.selectable').on('click', function () {
    let btn = $(this);
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'bookmark', id: btn.attr('id'), tableName: pageType },
        dataType: "text",
        success: function (data) {
            let type = parseInt(data);
            if(type === 1){
                btn.addClass('checked');
                btn.removeClass('unchecked');
                btn.closest('tr').css('background','yellow');
            }
            else{
                btn.addClass('unchecked');
                btn.removeClass('checked');
                btn.closest('tr').css('background','none');
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
$('.selectable').on('click',function () {
    $('.selected').removeClass('selected');
    $('.selected').addClass('selectable');
    $(this).addClass('selected');
    $(this).removeClass('selectable');
});
//수금 버튼
$('.getMoneyBtn').on('click',function () {
    let btn = $(this);
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'getMoney', id: btn.attr('id'), tableName: pageType },
        dataType: "text",
        success: function (data) {
            let type = parseInt(data);
            if(type === 1){
                btn.addClass('checked');
                btn.removeClass('unchecked');
                btn.closest('tr').css('background','yellow');
            }
            else{
                btn.addClass('unchecked');
                btn.removeClass('checked');
                btn.closest('tr').css('background','none');
            }
        }
    });
});