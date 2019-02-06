<?php
  $dayofweek = ['일', '월', '화', '수', '목', '금', '토'];
  $table_head_list = ['구분', '근무날짜', '상호명', '근무시간', '업종', '일당', '요청사항', '콜비', '인력', '취소']; ?>

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
        <colgroup>
            <col width="5%">
            <col width="7%">
            <col width="15%">
            <col width="10%">
            <col width="7%">
            <col width="8%">
            <col width="auto"><!--요청사항-->
            <col width="7%">
            <col width="9%">
            <col width="5%">
        </colgroup>
        <thead>
        <tr>
          <? foreach ($table_head_list as $key => $value): ?>
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
              <tr class="selectable callRow <?php if ($data['cancelled'] == 1) echo 'cancelled' ?>" id="<?php echo $data['callID'] ?>">
                  <!--구분-->
                  <td class="al_c">
                    <?php echo $data['callID'] ."<br>". $this->assignType($data) . $this->get_fixType($data) ?>
                  </td>
                  <!--근무날짜-->
                  <td class="al_c">
                    <?php echo date('m/d', strtotime($data['workDate'])) ."<br>". "(" . $dayofweek[date('w', strtotime($data['workDate']))] . ")" ?>
                  </td>
                  <!--상호명-->
                  <td class="al_l ellipsis">
                      <a href="http://bestpachul.com/company/view/<?php echo $data['companyID'] ?>" class="link" title="<?php echo $companyName?>">
                        <?php echo $companyName ?>
                      </a>
                  </td>
                  <!--근무시간-->
                  <td class="al_c" style="padding: 0;"><?php echo $this->timeType($data) ?></td>
                  <!--업종-->
                  <td class="al_c"> <?php echo $data['workField'] ?></td>
                  <!--일당-->
                  <td class="al_c"> <?php echo number_format($data['salary']) ?> 원</td>
                  <!--요청사항-->
                  <td class="al_c ellipsis"><?php $this->get_callDetail($data) ?></td>
                  <!--콜비-->
                  <td class="al_c" style="padding:0"><?php echo $this->getPayBtn($data, 'call', 'price'); ?></td>
                  <!--인력-->
                  <td class="al_c assignedEmployee ellipsis">
                    <?php switch ($type): case 'call': ?>
                      <?php if ($data['employeeID'] > 0): ?>
                            <a class="assignCancelBtn link" id="<?php echo $data['callID'] ?>" title="<?php echo $employeeName?>">
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
                  <td class="al_c hide" style="padding: 0;">
                    <?php if ($data['cancelled'] == 0): ?>
                        <button type="button" class="btn-call-cancel-modal btn btn-small btn-danger"
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
      <h1 style="text-align: center;">내역이 존재하지 않습니다.</h1>
  <?php endif; ?>
</div>