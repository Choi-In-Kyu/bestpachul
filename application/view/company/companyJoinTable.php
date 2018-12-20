<div class="board_write auto-center">
    <h1>가입 내역</h1>
    <table id="companyJoinTable" width="100%">
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
            <th class="link">#</th>
            <th class="link">가입구분</th>
            <th class="link">가입금액</th>
            <th class="link">가입 시작일</th>
            <th class="link">가입 만기일</th>
            <th class="link">비고</th>
            <th class="link">삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->joinList as $key => $data): ?>
            <tr class="tr-company <?php echo $this->joinColor($data, 'company'); ?>" id="<?php echo $data['join_companyID']?>">
                <td class="al_c link update join_id"><?php echo $data['join_companyID'] ?></td>
                <td class="al_l"><?php echo $this->get_joinType($data); ?></td>
                <td class="al_l link update join_price"><?php echo $this->get_joinPrice($data); ?></td>
                <td class="al_l"><?php echo $data['startDate'] ?></td>
                <td class="al_l"><?php echo $this->get_endDate($data, 'company'); ?></td>
                <td class="al_l link update join_detail"><?php echo $this->get_joinDetail($data); ?></td>
                <td class="al_c"><?php echo $this->get_join_delete_btn($data, 'company'); ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <br/>
    <div class="btn_group" id="join_button">
        <button id="btnAddJoin" type="button" class="btn btn-insert" onclick="">가입 추가</button>
    </div>
    <form action="" id="addJoinForm" style="display:none;" method="post">
        <div id="join_form_btn_group">
            <button type="button" id="btn_gujwa" onclick="type_toggle('gujwa')">구좌</button>
            <button type="button" id="btn_deposit" onclick="type_toggle('deposit')">보증금</button>
            <button type="button" id="btn_point" onclick="type_toggle('point')">포인트</button>
        </div>
        <input type="hidden" name="action" value="new_insert">
        <input type="hidden" name="join_company-companyID" value="<?php echo $this->companyData['companyID'] ?>">
        <div class="table" id="detail_table"></div>
        <div class="btn_group">
            <button class="btn btn-submit" type="submit">가입 추가</button>
        </div>
    </form>
</div>