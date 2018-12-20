<div class="board_write auto-center">
  <h1>가입 내역</h1>
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
      <tr class="tr-employee <?php echo $this->joinColor($data, 'employee');?>">
        <td class="al_c update join_id"><?php echo $data['join_employeeID'] ?></td>
        <td class="al_c"><?php echo $data['startDate'] ?></td>
        <td class="al_c"><?php echo $this->get_endDate($data,'employee') ?></td>
        <td class="al_c update link join_price"><?php echo $this->get_joinPrice($data); ?></td>
        <td class="al_l update link join_detail"><?php echo $this->get_joinDetail($data); ?></td>
        <td class="al_c td-money"><?php echo $this->get_paidBtn($data, 'join_employee','price'); ?></td>
        <td class="al_c"><?php echo $this->get_join_delete_btn($data,'employee'); ?></td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
  <br/>
  <!--가입 추가-->
  <div class="btn_group" id="join_button">
    <button id="btnAddJoin" type="button" class="btn btn-insert">가입 추가</button>
  </div>
  <form action="" id="addJoinForm" style="display:none;" method="post">
    <input type="hidden" name="action" value="new_insert">
    <input type="hidden" name="join_employee-employeeID" value="<?php echo $this->employeeData['employeeID'] ?>">
    <div id="new_join_table">
      <h1>가입 정보</h1>
      <table>
        <tr>
          <td>가입시작일</td>
          <td><input type="date" id="startDate" name="join_employee-startDate" required></td>
          <td>가입만기일</td>
          <td><input type="date" id="endDate" name="join_employee-endDate" required></td>
          <td>
            <button type="button" class="btn btn-insert" onclick="auto_insert_employee_join()">자동 입력
          </td>
        </tr>
        <tr>
          <td>가입금액</td>
          <td><input type="number" id="price" name="join_employee-price" value="50000"  required></td>
          <td>가입비고</td>
          <td><textarea name="join_employee-detail"></textarea></td>
          <td>
            <input type="checkbox" id="paid" name="join_employee-paid" value="1">회비 수금 여부
          </td>
        </tr>
      </table>
    </div>
    <div class="btn_group">
      <button class="btn btn-submit" type="submit">가입 추가</button>
    </div>
  </form>
</div>