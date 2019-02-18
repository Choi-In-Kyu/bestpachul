<div class="board-write auto-center">
    <div class="title-table">
        <h1>가입 내역</h1>
    </div>
    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="15%">
            <col width="15%">
            <col width="15%">
            <col width="auto">
            <col width="10%">
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
            <tr class="tr-employee <?php echo $this->joinColor($data, 'employee'); ?>">
                <td class="al_c update join_id"><?php echo $data['join_employeeID'] ?></td>
                <td class="al_c"><?php echo $data['startDate'] ?></td>
                <td class="al_c"><?php echo $this->get_endDate($data, 'employee') ?></td>
                <td class="al_c update link join_price"><?php echo $this->get_joinPrice($data); ?></td>
                <td class="al_l update link join_detail"><?php echo $this->get_joinDetail($data); ?></td>
                <td class="al_c td-money"><?php echo $this->getPayBtn($data, 'join_employee', 'price'); ?></td>
                <td class="al_c"><?php echo $this->get_join_delete_btn($data, 'employee'); ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <!--가입 추가-->
    <div class="btn-group al_r" id="join_button">
        <button id="btnAddJoin" type="button" class="btn btn-insert">가입 추가</button>
    </div>
    <form action="" id="addJoinForm" style="display:none;" method="post">
        <input type="hidden" name="action" value="new_insert">
        <input type="hidden" name="employeeID" value="<?php echo $this->employeeData['employeeID'] ?>">
        <div id="new_join_table">
            <div class="title-table">
                <h1>가입 정보</h1>
            </div>
<!--            <table>-->
<!--                <tr>-->
<!--                    <td>가입시작일</td>-->
<!--                    <td><input type="date" id="startDate" name="startDate" required></td>-->
<!--                    <td>가입만기일</td>-->
<!--                    <td><input type="date" id="endDate" name="endDate" required></td>-->
<!--                    <td>-->
<!--                        <button type="button" class="btn btn-insert" onclick="auto_insert_employee_join('today')">오늘부터</button>-->
<!--                        <button type="button" class="btn btn-insert" onclick="auto_insert_employee_join('extend')">가입연장</button>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>가입금액</td>-->
<!--                    <td><input type="number" id="price" name="price" value="50000" min="0" required></td>-->
<!--                    <td>가입비고</td>-->
<!--                    <td><textarea name="joinDetail"></textarea></td>-->
<!--                    <td>-->
<!--                        <label for="">수금</label>-->
<!--                        <input type="checkbox" id="paid" name="paid" value="1">-->
<!--                        <label for="">수금자</label>-->
<!--                        <input type="text" id="paid" name="receiver" value="지명희">-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
            <div class="table table-add-join" id="employeeAddJoinTable">
                <div class="tr">
                    <div class="td">
                        <label for="startDate">가입시작일</label>
                        <input type="date" id="startDate" name="startDate" required>
                    </div>
                    <div class="td">
                        <label for="endDate">가입만기일</label>
                        <input type="date" id="endDate" name="endDate" required>
                    </div>
                    <div class="td">
                        <button type="button" class="btn btn-option" onclick="auto_insert_employee_join('today')"
                                style="width: 100px;">오늘부터
                        </button>
                        <button type="button" class="btn btn-option" onclick="auto_insert_employee_join('extend')"
                                style="width: 100px;">가입연장
                        </button>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label for="price">가입금액</label>
                        <input type="number" id="price" name="price" required>
                    </div>
                    <div class="td">
                        <label for="joinDetail">가입비고</label>
                        <textarea name="joinDetail"></textarea>
                    </div>
                    <div class="td">
                        <label for="">수금</label>
                        <input type="checkbox" id="paid" name="paid" value="1" style="width: 30px; height: 30px;">
                        <input type="text" id="paid" name="receiver" value="지명희" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group al_r">
            <button class="btn btn-insert" type="submit">가입 추가</button>
        </div>
    </form>
</div>