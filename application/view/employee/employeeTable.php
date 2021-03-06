<table id="employee_table" width="100%">
    <colgroup>
        <col width="5%">
        <col width="auto">
        <col width="10%">
        <col width="17%">
        <col width="17%">
        <col width="8%">
        <col width="15%">
        <col width="5%">
        <col width="5%">
        <col width="5%">
    </colgroup>
    <thead>
    <tr>
        <th class="order link"  id="refresh-employeeID"> #</th>
        <th class="order link"  id="refresh-employeeName"> 성명</th>
        <th class="order link"  id="refresh-birthDate"> 연령</th>
        <th class="order link"  id="refresh-address"> 간단주소</th>
        <th class="order link"  id="refresh-employeePhoneNumber"> 전화번호</th>
        <th>주간배정횟수</th>
        <th class="order link"  id="refresh-imminent"> 비고</th>
        <th class="order link"  id="refresh-grade"> 점수</th>
        <th class="order"       id="refresh-bookmark"><span class="link fa fa-star"></span></th>
        <th class="order"       id="refresh-deleted"> X</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->list as $key => $data): ?>
        <tr class="<?php echo $this->getClass($data) ?> tr-employee" id="<?php echo $data['employeeID']?>">
            <td class="al_c"><?php echo $data['employeeID'] ?><a href="<?php echo "{$this->param->get_page}/view/{$data['idx']}" ?>"></td>
            <td class="al_c link" onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data['employeeID']}" ?>"'><?php echo $data['employeeName'] ?></td>
            <td class="al_c"><?php echo getAge($data['birthDate'])."세" ?></td>
            <td class="al_c"><?php echo $data['address'] ?></td>
            <td class="al_c"><?php echo $data['employeePhoneNumber'] ?></td>
            <td class="al_c"><?php echo sizeof($this->model->getTable("SELECT * FROM `call` WHERE `employeeID` = '{$data['employeeID']}' AND  YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE(),1) " )); ?>회</td>
            <td class="al_c"><?php echo $this->imminent_check('employee',$data);?></td>
            <td class="al_c"><?php echo $data['grade'] ?>점</td>
            <td><span class="fa fa-star selectable <?php echo ($data['bookmark'] == 1) ? 'checked' : 'unchecked' ?>" id="<?php echo $data['employeeID'] ?>"></span></td>
            <td class="al_c"><?php echo $this->get_DeleteBtn($data, 'employee') ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>