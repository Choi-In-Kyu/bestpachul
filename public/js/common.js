$('.fa-star.selectable').on('click', function () {
    $('#bookmarkForm input[name=ID]').val(this.id);
    $('#bookmarkForm').submit();
});
$('.deleteModalBtn').on('click', function () {
    $('#deleteModal').show();
    $('#modal-deleteID').val($(this).val());
});
$('.joinCancelModalBtn').click(function () {
    $('#joinCancelModal').show();
    $('#modal-joinID').val(this.value);
});
$('#addJoinBtn').on('click', function () {
    let btn = $(this);
    $('#addJoinForm').slideToggle('fast', function () {
        if ($(this).is(':visible')) btn.text('취소');
        else btn.text('가입추가');
    });
});

$('.update').click(function () {
    let id = $(this).parent().children('.join_id').html();
    let price = $(this).parent().children('.join_price').html();
    let detail = $(this).parent().children('.join_detail').html();
    $('#joinUpdateModal').show();
    $('#updateID').val(id);
    $('#updatePrice').val(parseInt(price.replace(',', '')));
    $('#updateDetail').text(detail.replace('<br>', '\n'));
});

function type_toggle(argument) {
    $('#detail_table').html($('#companyAddJoinTable_' + argument + '').html());
}

function auto_insert() {
    $('#startDate').val('<?php echo date("Y-m-d")?>');
    $('#endDate').val('<?php echo date("Y-m-d", strtotime("+1 month -1 day"));?>');
    $('#price').val(50000);
    document.getElementById('paid').checked = true;
}

$('.closeModal').on('click', function () {
    $('.modal').hide();
});

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