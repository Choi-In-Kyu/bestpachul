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
    $('.callBtn').hide();
    $('#submitBtn').show();
    // $('input[name=startDate]').prop('name', 'workDate');
    $('.monthly').slideUp();
    $('.fixable').slideUp();
});
$('#fixCallBtn').on('click',function () {
    $('.callBtn').hide();
    $('#submitFixedCallBtn').show();
    // $('input[name=workDate]').prop('name', 'startDate');
    $('.endDate').css('display','inline');
    $('.monthly').slideUp();
    $('.fixable').slideDown();
});
$('#monthlyCallBtn').on('click',function () {
    $('.callBtn').hide();
    $('#submitMonthlyCallBtn').show();
    // $('input[name=workDate]').prop('name', 'startDate');
    $('.endDate').css('display','inline');
    $('.fixable').slideDown();
    $('.monthly').slideDown();
});

$('#callForm input').on('input',function () {
    console.log('changed');
   initiate(endHour.val()-startHour.val());
});
$('#callForm select').on('input',function () {
    console.log('changed');
    initiate(endHour.val()-startHour.val());
});