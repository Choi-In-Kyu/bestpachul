//bestpachul.com/company/view
function type_toggle(argument) {
    let detail_table = document.getElementById('detail_table');
    switch (argument) {
        case 'gujwa':
            detail_table.innerHTML = document.getElementById('table_join_gujwa').innerHTML;
            break;
        case 'deposit':
            detail_table.innerHTML = document.getElementById('table_join_deposit').innerHTML;
            break;
        case 'point':
            detail_table.innerHTML = document.getElementById('table_join_point').innerHTML;
            break;
    }
}
$('#closeModal').click(function () {
    $('#myModal').hide();
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
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch= true;
                    break;
                }
            } else if (dir == "desc") {
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
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}