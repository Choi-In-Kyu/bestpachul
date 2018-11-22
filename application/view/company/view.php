<?php include_once 'write.php' ?>
<div class="board_write auto-center">
    <h1>가입 내역</h1>
    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="15%">
            <col width="35%">
            <col width="10%">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>가입구분</th>
            <th>가입금액</th>
            <th>가입 시작일</th>
            <th>가입 만기일</th>
            <th>비고</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->joinList as $key => $data): ?>
            <tr style="background-color:<?php echo $this->joinColor($data, 'company');?>">
                <td class="al_c update join_id"><?php echo $data['join_companyID'] ?></td>
                <td class="al_l"><?php echo $this->get_joinType($data); ?></td>
                <td class="al_l update join_price"><?php echo $this->get_joinPrice($data); ?></td>
                <td class="al_l"><?php echo $data['startDate'] ?></td>
                <td class="al_l"><?php echo $this->get_endDate($data,'company'); ?></td>
                <td class="al_l update join_detail"><?php echo $this->get_joinDetail($data); ?></td>
                <td class="al_c"><?php echo $this->get_joinDeleteBtn($data,'company'); ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <br/>
    <!--가입 추가-->
  <?php include_once 'table_join.php'; ?>
    <div class="btn_group" id="join_button">
        <button type="button" class="btn btn-insert" onclick="show_join_form()">가입 추가</button>
    </div>
    <form action="" id="new_join_form" style="display:none;" method="post" enctype=''>
        <div id="join_form_btn_group" style="display:none;">
            <button type="button" id="btn_gujwa" onclick="type_toggle('gujwa')">구좌</button>
            <button type="button" id="btn_deposit" onclick="type_toggle('deposit')">보증금</button>
            <button type="button" id="btn_point" onclick="type_toggle('point')">포인트</button>
        </div>
        <input type="hidden" name="action" value="new_insert">
        <input type="hidden" name="join_company-companyID" value="<?php echo $this->companyData['companyID'] ?>">
        <div class="table" id="detail_table"></div>
        <div class="btn_group">
            <button type="button" class="btn btn-default" onclick="cancel_join_form()">취소</button>
            <button class="btn btn-submit" type="submit">가입 추가</button>
        </div>
    </form>
</div>

<?php require_once(_VIEW . "call/call.php");?>

<!-- Delete Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input id="modal-joinID" type="hidden" name="joinID">
            <textarea name="deleteDetail" size="200"></textarea>
            <input class="btn btn-default" type="button" id="closeModal" value="취소">
            <input class="btn btn-danger" type="submit" value="삭제">
        </form>
    </div>
</div>

<!-- Update Join Modal -->
<div id="joinModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="join_update">
            <input id="updateID" type="hidden" name="joinID">
            <input type="number" id="updatePrice" name="price">
            <textarea id="updateDetail" name="detail" size="200"></textarea>
            <input class="btn btn-default" type="button" id="closeJoinModal" value="취소">
            <input class="btn btn-insert" type="submit" value="수정">
        </form>
    </div>
</div>

<script>
    function type_toggle(argument) {
        let detail_table = document.getElementById('detail_table');
        switch (argument) {
            case 'gujwa':detail_table.innerHTML = document.getElementById('table_join_gujwa').innerHTML;break;
            case 'deposit':detail_table.innerHTML = document.getElementById('table_join_deposit').innerHTML;break;
            case 'point':detail_table.innerHTML = document.getElementById('table_join_point').innerHTML;break;
        }
    }
    function show_join_form() {
        detail_table.innerHTML = document.getElementById('table_join_gujwa').innerHTML;
        document.getElementById('join_button').style.display = 'none';
        document.getElementById('join_form_btn_group').style.display = 'block';
        document.getElementById('new_join_form').style.display = 'block';
    }
    function cancel_join_form() {
        document.getElementById('join_button').style.display = 'block';
        document.getElementById('join_form_btn_group').style.display = 'none';
        document.getElementById('new_join_form').style.display = 'none';
    }
    $('.btnModal').click(function () {
        $('#myModal').show();
        $('#modal-joinID').val(this.value);
    });
    $('#closeJoinModal').click(function () {
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