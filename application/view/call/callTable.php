<form id="filterForm" method="post" style="display: none;">
    <input type="hidden" name="action" value="filter">
    <input type="hidden" name="callID" value="">
  <?php foreach ($_POST as $key => $value): ?>
      <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
  <?php endforeach; ?>
</form>

<?php $width = ($this->param->action == 'fix') ? 20 : 64 ?>
<div class="inline scroll_tbody call" style="width: <?php echo $width ?>%;">
    <table id="<?php echo $type . "_table" ?>" width="100%"
           style="height: <?php echo (sizeof($this->{$type . 'List'}) == 0) ? '50px;' : null ?>">
        <thead>
        <tr>
          <? foreach (['구분', '근무날짜', '업체명', '근무시간', '업종', '일당', '요청사항', '콜비', '인력', '취소'] as $key => $value): ?>
              <th class="call link"
                  onclick="sortTable('<?php echo $type . '_table' ?>',<?php echo $key ?>)"><?php echo $value ?></th>
          <?php endforeach; ?>
        </tr>
        </thead>
      <?php if (sizeof($this->{$type . 'List'}) > 0): ?>
          <tbody>
          <?php foreach ($this->{$type . 'List'} as $key => $data): ?>
            <?php
            $employeeName = $this->model->select('employee', "employeeID = '{$data['employeeID']}'", 'employeeName');
            $companyName = $this->model->select('company', "companyID = '{$data['companyID']}'", 'companyName');
            
            ?>
              <tr class="selectable callRow <?php if ($data['cancelled'] == 1) echo 'cancelled' ?>"
                  id="<?php echo $data['callID'] ?>">
                  <td class="al_c" style="width: 10%"><?php echo $data['callID'].$this->assignType($data).$this->get_fixType($data)?></td>
                <?php $dayofweek = ['일', '월', '화', '수', '목', '금', '토'] ?>
                  <td class="al_l" style="width: 5%"><?php echo $data['workDate'] . "(" . $dayofweek[date('w', strtotime($data['workDate']))] . ")" ?></td>
                  <td class="al_l" style="width: 35%;">
                      <a href="http://bestpachul.com/company/view/<?php echo $data['companyID'] ?>" class="link">
                        <?php echo $companyName ?>
                      </a>
                  </td>
                  <td class="al_l" style="width: 10%"><?php echo $this->timeType($data) ?></td>
                  <td class="al_l" style="width: 10%"> <?php echo $data['workField'] ?></td>
                  <td class="al_l" style="width: 10%"><?php echo number_format($data['salary']) ?></td>
                  <td class="al_l" style="width: 10%"><?php $this->get_callDetail($data) ?></td>
                  <td class="al_c" style="width: 10%"><?php echo $this->get_paidBtn($data, 'call', 'price'); ?></td>
                  <td class="al_c assignedEmployee" style="width: 10%">
                    <?php switch ($type): case 'call': ?>
                      <?php if ($data['employeeID'] > 0): ?>
                            <a class="assignCancelBtn link" id="<?php echo $data['callID'] ?>">
                              <?php echo $employeeName ?>
                            </a>
                      <?php endif; ?>
                      <?php break; ?>
                    <?php case 'punk': ?>
                        <a href="http://bestpachul.com/employee/view/<?php echo $data['employeeID'] ?>" class="link">
                          <?php echo $employeeName ?>
                        </a>
                      <?php break; ?>
                    <?php endswitch; ?>
                  </td>
                  <td class="al_c hide" style="width: 10%">
                    <?php if ($data['cancelled'] == 0): ?>
                        <button type="button" class="callCancelBtn btn btn-small btn-danger"
                                id="<?php echo $data['callID'] ?>">취소
                        </button>
                    <?php else: ?>
                        (취소됨)
                    <?php endif; ?>
                  </td>
              </tr>
          <?php endforeach ?>
          </tbody>
      <?php endif; ?>
    </table>
  <?php if (sizeof($this->{$type . 'List'}) == 0): ?>
      <h1>내역이 존재하지 않습니다.</h1>
  <?php endif; ?>
</div>