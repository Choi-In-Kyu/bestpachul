<table id="company_table" width="100%">
    <colgroup>
        <col width="5%">
        <col width="15%">
        <col width="35%">
        <col width="25%">
        <col width="15%">
        <col width="2%">
        <col width="3%">
    </colgroup>
    <thead>
    <tr>
        <th class="link" onclick="sortTable('company_table', 0)">#</th>
        <th class="link" onclick="sortTable('company_table', 1)">상호명</th>
        <th class="link" onclick="sortTable('company_table', 2)">간단주소</th>
        <th class="link" onclick="sortTable('company_table', 3)">업종</th>
        <th class="link" onclick="sortTable('company_table', 4)">점수</th>
        <th onclick="sortTable('company_table', 5)"><span class="link fa fa-star"></span></th>
        <th class="link" onclick="sortTable('company_table', 6)">X</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->list as $key => $data): ?>
        <tr style="background-color: <?php echo $data['color'] ?>">
            <td class="al_c"><?php echo $data['companyID'] ?><a href="<?php echo "{$this->param->get_page}/view/{$data['idx']}" ?>"></td>
            <td class="al_l link" onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data['companyID']}" ?>"'><?php echo $data['companyName'] ?></td>
            <td class="al_l"><?php echo $data['address'] ?></td>
            <td class="al_l"><?php echo $data['businessType'] ?></td>
            <td class="al_l"><?php echo $data['grade'] ?></td>
            <td><span class="fa fa-star selectable <?php echo ($data['bookmark'] == 1) ? 'checked' : 'unchecked' ?>" id="<?php echo $data['companyID'] ?>"></span></td>
            <td class="al_c"><?php echo $this->get_DeleteBtn($data, 'company') ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>