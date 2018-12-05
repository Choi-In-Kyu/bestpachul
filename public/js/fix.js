$('#companyName').on('input', function () {
    $('#formAction').val('getCompanyID');
    console.log($('#formAction').val());
    $.ajax({
        type: "POST",
        url: "http://bestpachul.com/application/ajax/ajax.php",
        method: "POST",
        data: $('#callForm').serialize(),
        dataType: "text",
        success: function (data) {
            $('#companyID').val(data);
            initiate(endHour.val()-startHour.val());
        }
    });
});
$('#employeeName').on('input', function () {
    $('#formAction').val('getEmployeeID');
    console.log($('#formAction').val());
    $.ajax({
        type: "POST",
        url: "http://bestpachul.com/application/ajax/ajax.php",
        method: "POST",
        data: $('#callForm').serialize(),
        dataType: "text",
        success: function (data) {
            $('#employeeID').val(data);
        }
    });
});
$('#manualCallBtn').on('click',function () {
    $('#fixBtn').attr("id","submitBtn");
    $('input[name=startDate]').attr('name', 'workDate');
    $('.fixedCall').slideUp();
});
$('#fixCallBtn').on('click',function () {
    $('#submitBtn').attr("id","fixBtn");
    $('input[name=workDate]').attr('name', 'startDate');
    $('.endDate').css('display','inline');
    $('.monthlyCall').slideUp();
    $('.fixedCall').slideDown();
});
$('#monthlyCallBtn').on('click',function () {
    $('#submitBtn').attr("id","fixBtn");
    $('input[name=workDate]').attr('name', 'startDate');
    $('.endDate').css('display','inline');
    $('.fixedCall').slideDown();
    $('.monthlyCall').slideDown();
});

$('#callForm input').on('input',function () {
    console.log('changed');
   initiate(endHour.val()-startHour.val());
});
$('#callForm select').on('input',function () {
    console.log('changed');
    initiate(endHour.val()-startHour.val());
});