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
// function show_join_form() {
//     document.getElementById('join_button').style.display = 'none';
//     document.getElementById('join_form_btn_group').style.display = 'block';
//     document.getElementById('new_join_form').style.display = 'block';
// }

$('#closeModal').click(function () {
    $('#myModal').hide();
});
