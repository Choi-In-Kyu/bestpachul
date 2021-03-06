<?php
//  $order = $_POST['order'];
//  $direction = $_POST['direction'];
//  $sql = "SELECT * FROM  `company` ";
//  $sql .= ($_POST['order'] && $_POST['direction']) ? "ORDER BY  `{$_POST['order']}` {$_POST['direction']} " : null;
//  $company_table = $this->model->getTable($sql);
////  echo json_encode($sql);
////  echo sizeof($company_table);
?>
<table id="company_table" width="100%">
    <colgroup>
        <col width="7%"><!--아이디-->
        <col width="auto"><!--상호명-->
        <col width="12%"><!--간단주소-->
        <col width="12%"><!--업종-->

        <col width="10%"><!--가입유형-->

        <col width="15%"><!--비고-->
        <col width="10%"><!--점수-->
        <col width="7%"><!--별표-->
        <col width="7%"><!--삭제-->
    </colgroup>
    <thead>
    <tr>
        <th class="order link" id="refresh-companyID"> #</th>
        <th class="order link" id="refresh-companyName"> 상호명</th>
        <th class="order link" id="refresh-address"> 간단주소</th>
        <th class="order link" id="refresh-businessType"> 업종</th>
        <th class="order link">가입 유형</th>
<!--        <th class="order link" id="refresh-endDate">비고</th>-->
        <th class="link" id="refresh-endDate">비고</th>
        <th class="order link" id="refresh-grade"> 점수</th>
        <th class="order" id="refresh-bookmark"><span class="link fa fa-star"></span></th>
        <th class="order" id="refresh-deleted"
        "> X</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->list as $key => $data): ?>
        <tr class="<?php echo $data['class'] ?> tr-company" id="<?php echo $data['companyID'] ?>">
            <td class="al_c"><?php echo $data['companyID'] ?><a
                        href="<?php echo "{$this->param->get_page}/view/{$data['idx']}" ?>"></td>
            <td class="al_l link"
                onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data['companyID']}" ?>"'><?php echo $data['companyName'] ?></td>
            <td class="al_c"><?php echo $data['address'] ?></td>
            <td class="al_c"><?php echo $data['businessType'] ?></td>

            <td class="al_c"><?php echo $this->get_join_type($data['companyID'], 'kor'); ?></td>

            <td class="al_c"><?php echo $this->imminent_check('company', $data) ?></td>
            <td class="al_c"><?php echo $data['grade'] ?>점</td>
            <td class="al_c"><span
                        class="fa fa-star selectable <?php echo ($data['bookmark'] == 1) ? 'checked' : 'unchecked' ?>"
                        id="<?php echo $data['companyID'] ?>"></span></td>
            <td class="al_c"><?php echo $this->get_DeleteBtn($data, 'company') ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script>

</script>