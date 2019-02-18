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
// $(function () {
//     $(".datepicker").datepicker({
//         changeMonth: true,
//         changeYear: true,
//         onSelect: function () {
//             if(pageAction === 'available_date'){
//                 $('#formAction').val('availableFilter');
//                 let date = $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val();
//                 $('#toggleDate').val(date);
//                 console.log(date);
//                 $.ajax({
//                     type: "POST",
//                     method: "POST",
//                     url: ajaxURL,
//                     data: $('#toggleForm').serialize(),
//                     dataType: "text",
//                     success: function (data) {
//                         let array = JSON.parse(data).list;
//                         let sql = JSON.parse(data).sql;
//
//                         let rows = $('.availableRow');
//                         rows.each(function () {
//                             if (array !== null) {
//                                 if (array.indexOf(parseInt(this.id)) >= 0) {
//                                     $(this).show();
//                                 }
//                                 else {
//                                     $(this).hide();
//                                 }
//                             }
//                         });
//                     }
//                 });
//             }
//             else{
//                 $('#formAction').val('toggleFilter');
//                 let date = $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val();
//                 $('#toggleDate').val(date);
//                 $.ajax({
//                     type: "POST",
//                     method: "POST",
//                     url: ajaxURL,
//                     data: $('#toggleForm').serialize(),
//                     dataType: "text",
//                     success: function (data) {
//                         let array = JSON.parse(data);
//                         $('.callRow').each(function () {
//                             if (array !== null) {
//                                 if (array.indexOf(parseInt(this.id)) >= 0) {
//                                     $(this).show();
//                                 }
//                                 else {
//                                     $(this).hide();
//                                 }
//                             }
//                         });
//                     }
//                 });
//             }
//         },
//         onChangeMonthYear: function (year, month, inst) {
//             $('.form-label.month').text(month + '월');
//             $('#form-input-month').val("( (YEAR(workDate) = '" + year + "') AND (MONTH(workDate) = '" + month + "') )");
//         }
//     });
// });