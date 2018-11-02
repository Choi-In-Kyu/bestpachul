<?php include_once 'write.php' ?>
<div class="board_list auto-center">
    <!--가입 내역-->
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
                <td class="al_c"><?php echo $data['join_companyID'] ?></td>
                <td class="al_l"><?php echo $this->get_joinType($data); ?></td>
                <td class="al_l"><?php echo $this->get_joinPrice($data); ?></td>
                <td class="al_l"><?php echo $data['startDate'] ?></td>
                <td class="al_l"><?php echo $this->get_endDate($data,'company'); ?></td>
                <td class="al_l"><?php echo $this->get_joinDetail($data); ?></td>
                <td class="al_c"><?php echo $this->get_joinDeleteBtn($data,'company'); ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <br/>
    <!--가입 추가-->
  <?php include_once 'table_join.php'; ?>
    <div class="btn_group" id="join_button">
        <button type="button" class="btn btn-insert" onclick="show_join_form()" style="text-align: center">가입 추가
        </button>
    </div>
    <div id="join_form_btn_group" style="display:none;">
        <button type="button" id="btn_gujwa" onclick="type_toggle('gujwa')">구좌</button>
        <button type="button" id="btn_deposit" onclick="type_toggle('deposit')">보증금</button>
        <button type="button" id="btn_point" onclick="type_toggle('point')">포인트</button>
    </div>
    <form action="" id="new_join_form" style="display:none;" method="post" enctype=''>
        <input type="hidden" name="action" value="new_insert">
        <input type="hidden" name="join_company-companyID" value="<?php echo $this->companyData['companyID'] ?>">
        <div class="table" id="detail_table"></div>
        <div class="btn_group">
            <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
            <button class="btn btn-submit" type="submit">가입 추가</button>
        </div>
    </form>
</div>

<!-- The Modal -->
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

<script>
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
    function show_join_form() {
        document.getElementById('join_button').style.display = 'none';
        document.getElementById('join_form_btn_group').style.display = 'block';
        document.getElementById('new_join_form').style.display = 'block';
    }

    $('.btnModal').click(function () {
        $('#myModal').show();
        $('#modal-joinID').val(this.value);
    })
</script>
<script src="/public/js/common.js"></script>