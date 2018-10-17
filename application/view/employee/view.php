<?php include_once 'write.php' ?>
<div class="board_list auto-center">
    <!--가입 내역-->
    <h1>가입 내역</h1>
    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="15%">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>가입 시작일</th>
            <th>가입 만기일</th>
            <th>가입금액</th>
            <th>비고</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->joinList as $key => $data): ?>
            <tr>
                <td class="al_c"><?php echo $data['join_employeeID'] ?></td>
                <td class="al_l"><?php echo $data['startDate'] ?></td>
                <td class="al_l"><?php echo $data['endDate'] ?></td>
                <td class="al_l">
                  <? echo number_format($data['price']) . " 원"; ?>
                </td>
                <td class="al_l">
                  <?php
                    echo $data['detail'];
                    if ($data['deleted'] == 1) echo " (삭제사유: " . $data['deleteDetail'] . ")";
                  ?>
                </td>
                <td class="al_c">
                    <button id="myBtn" class="btnModal" value="<?php echo $data['join_employeeID']; ?>">X</button>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <br/>
    <!--가입 추가-->
    <div class="btn_group" id="join_button">
        <button type="button" class="btn btn-insert" onclick="show_join_form()">가입 추가
        </button>
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
                    <td><button type="button" class="btn btn-insert" onclick="auto_insert()">자동 입력</td>
                </tr>
                <tr>
                    <td>가입금액</td>
                    <td><input type="number" name="join_employee-price" required></td>
                    <td>가입비고</td>
                    <td><textarea name="join_employee-detail" required></textarea></td>
                    <td>
                        <input type="checkbox" name="join_employee-paid" value="1">회비 수금 여부
                    </td>
                </tr>
            </table>
        </div>
        <div class="btn_group">
            <button type="button" class="btn btn-default" onclick="cancel_join_form()">취소
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
            <input type="hidden" name="join_employee-deleted" value=1>
            <input id="modal-joinID" type="hidden" name="join_employee-join_employeeID">
            <textarea name="join_employee-deleteDetail" size="200"></textarea>
            <input class="btn btn-default" type="button" id="closeModal" value="취소">
            <input class="btn btn-danger" type="submit" value="삭제">
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
    }

    $('.btnModal').click(function () {
        $('#myModal').show();
        $('#modal-joinID').val(this.value);
    })
    $('#closeModal').click(function () {
        $('#myModal').hide();
    })
</script>