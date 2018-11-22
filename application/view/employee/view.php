<?php include_once 'write.php' ?>
<div class="board_write auto-center">
    <!--가입 내역-->
    <h1>가입 내역</h1>
    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="5%">
            <col width="10%">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>가입 시작일</th>
            <th>가입 만기일</th>
            <th>가입금액</th>
            <th>비고</th>
            <th>수금</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->joinList as $key => $data): ?>
            <tr style="background-color:<?php echo $this->joinColor($data, 'employee');?>">
                <td class="al_c update join_id"><?php echo $data['join_employeeID'] ?></td>
                <td class="al_l"><?php echo $data['startDate'] ?></td>
                <td class="al_l"><?php echo $this->get_endDate($data,'employee') ?></td>
                <td class="al_l update link join_price"><?php echo $this->get_joinPrice($data); ?></td>
                <td class="al_l update link join_detail"><?php echo $this->get_joinDetail($data); ?></td>
                <td class="al_c"><?php echo $this->get_paidBtn($data); ?></td>
                <td class="al_c"><?php echo $this->get_joinDeleteBtn($data,'employee'); ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <br/>
    <!--가입 추가-->
    <div class="btn_group" id="join_button">
        <button type="button" class="btn btn-insert" onclick="show_join_form()">가입 추가</button>
    </div>
    <form action="" id="new_join_form" style="display:none;" method="post" enctype=''>
        <input type="hidden" name="action" value="new_insert">
        <input type="hidden" name="join_employee-employeeID" value="<?php echo $this->employeeData['employeeID'] ?>">
        <div id="new_join_table" style="display: none;">
            <h1>가입 정보</h1>
            <table>
                <tr>
                    <td>가입시작일</td>
                    <td><input type="date" id="startDate" name="join_employee-startDate" required></td>
                    <td>가입만기일</td>
                    <td><input type="date" id="endDate" name="join_employee-endDate" required></td>
                    <td>
                        <button type="button" class="btn btn-insert" onclick="auto_insert()">자동 입력
                    </td>
                </tr>
                <tr>
                    <td>가입금액</td>
                    <td><input type="number" id="price" name="join_employee-price" value="50000"  required></td>
                    <td>가입비고</td>
                    <td><textarea name="join_employee-detail"></textarea></td>
                    <td>
                        <input type="checkbox" name="join_employee-paid" value="1">회비 수금 여부
                    </td>
                </tr>
            </table>
        </div>
        <div class="btn_group">
            <button type="button" class="btn btn-default" onclick="cancel_join_form()">취소</button>
            <button class="btn btn-submit" type="submit">가입 추가</button>
        </div>
    </form>
</div>

<?php $type='call'; require_once(_VIEW . "call/call.php");?>
<?php $type='punk'; require_once(_VIEW . "call/punk.php");?>

<!-- Update Join Modal -->
<div id="joinModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="join_update">
            <input id="updateID" type="hidden" name="joinID">
            <input type="number" id="updatePrice" name="price">
            <textarea id="updateDetail" name="detail" size="200"></textarea>
            <input class="btn btn-insert" type="submit" value="수정">
            <input class="btn btn-default" type="button" id="closeJoinModal" value="취소">
        </form>
    </div>
</div>

<script>
    function show_join_form() {
        document.getElementById('join_button').style.display = 'none';
        document.getElementById('new_join_form').style.display = 'block';
        document.getElementById('new_join_table').style.display = 'block';
    }
    function cancel_join_form() {
        document.getElementById('join_button').style.display = 'block';
        document.getElementById('new_join_form').style.display = 'none';
        document.getElementById('new_join_table').style.display = 'none';
    }
    function auto_insert() {
        $('#startDate').val('<?php echo date("Y-m-d")?>');
        $('#endDate').val('<?php echo date("Y-m-d", strtotime("+1 month -1 day"));?>')
        $('#price').val(50000);
    }
    $('.btnModal').click(function () {
        $('#myModal').show();
        $('#modal-joinID').val(this.value);
    });
    $('#closeJoinModal').on('click',function () {
        $('#joinModal').hide();
    });
    $('.update').click(function () {
        let id = $(this).parent().children('.join_id').html();
        let price = $(this).parent().children('.join_price').html();
        let detail = $(this).parent().children('.join_detail').html();
        $('#joinModal').show();
        $('#updateID').val(id);
        $('#updatePrice').val(parseInt(price.replace(',','')));
        $('#updateDetail').text(detail.replace('<br>','\n'));
    });
</script>
<script src="/public/js/common.js"></script>