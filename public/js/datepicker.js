//jQuery Datepicker
$.datepicker.setDefaults({
    dateFormat: 'yy-mm-dd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear: true,
    yearSuffix: '년'
});
$(function () {
    $(".datepicker").datepicker({
        changeMonth:true,
        changeYear:true,
        onSelect: function () {
            $('#formAction').val('toggleFilter');
            let date = $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val();
            $('#toggleDate').val(date);

            $.ajax({
                type: "POST",
                method: "POST",
                url: ajaxURL,
                data: $('#toggleForm').serialize(),
                dataType: "text",
                success: function (data) {
                    let array = JSON.parse(data);
                    $('.callRow').each(function () {
                        if (array !== null) {
                            if (array.indexOf(parseInt(this.id)) > 0) {
                                $(this).show();
                            }
                            else {
                                $(this).hide();
                            }
                        }
                    });
                }
            });



        },
        onChangeMonthYear: function (year, month, inst) {
            $('.filterYear').val(year);
            $('.filterMonth').val(month);
            $('#filterMonthBtn').val(month+'월 (모든콜)');
            $('#filterMonthPaidBtn').val(month+'월 (유료콜)');
        }
    });
});