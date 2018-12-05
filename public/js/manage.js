$('.blackDelBtn').on('click', function () {
    let btn = $(this);
    $.ajax({
        type: "POST",
        method: "POST",
        url: ajaxURL,
        data: {action: 'deleteBlack', blackID: btn.val()},
        dataType: "text",
        success: function (data) {
            alert(data);
            btn.closest('tr').slideUp();
        }
    });
});