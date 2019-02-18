<?php
  $dayofweek = ['일', '월', '화', '수', '목', '금', '토'];
  $table_head_list = ['구분', '근무날짜', '상호명', '근무시간', '업종', '일당', '요청사항', '콜비', '구직자', '취소'];
?>

<form id="filterForm" method="post" style="display: none;">
    <input type="hidden" name="action" value="filter">
    <input type="hidden" name="callID" value="">
  <?php foreach ($_POST as $key => $value): ?>
      <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
  <?php endforeach; ?>
</form>

<?php $width = ($this->param->action == 'fix') ? 20 : 64 ?>
<div class="inline scroll_tbody call" style="width: <?php echo $width ?>%;">
    <table id="call_table" style="width=100%; height: <?php echo (sizeof($this->callList) == 0) ? '50px;' : null ?>;">
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
                  onclick="sortTable('<?php echo 'call_table' ?>',<?php echo $key ?>)"><?php echo $value ?></th>
          <?php endforeach; ?>
        </tr>
        </thead>
      <?php if (sizeof($this->callList) > 0): ?>
          <tbody>
          <?php foreach ($this->callList as $key => $data): ?>
            <?php
            $employeeName = $this->model->select('employee', "employeeID = '{$data['employeeID']}'", 'employeeName');
            $companyName = $this->model->select('company', "companyID = '{$data['companyID']}'", 'companyName');
            ?>
              <tr class="selectable callRow <?php echo ($data['cancelled'] == 1) ? 'cancelled' : null; echo " "; echo $this->assignType($data,true); echo " "; echo $this->get_fixType($data,true);?> "
                  id="<?php echo $data['callID'] ?>">
                  <!--구분-->
                  <td class="al_c">
                    <?php echo $data['callID'] . "<br>" . $this->assignType($data) . $this->get_fixType($data) ?>
                  </td>
                  <!--근무날짜-->
                  <td class="al_c">
                    <?php echo date('m/d', strtotime($data['workDate'])) . "<br>" . "(" . $dayofweek[date('w', strtotime($data['workDate']))] . ")" ?>
                  </td>
                  <!--상호명-->
                  <td class="al_l ellipsis">
                      <a href="http://bestpchul.com/company/view/<?php echo $data['companyID'] ?>" class="link"
                         title="<?php echo $companyName ?>">
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
                  <td class="al_l update-call link ellipsis">
                    <?php if ($this->get_punk_list($data['callID'])): ?>
                      <?php foreach ($this->get_punk_list($data['callID']) as $value): ; ?>
                            <b class="punk-employee">
                              <?php echo $this->model->select('employee', " `employeeID` = '{$value['employeeID']}'", 'employeeName'); ?>:
                              <?php echo $value['detail']; ?>
                            </b><br>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php $this->get_callDetail($data) ?>
                  </td>
                  <!--콜비-->
                  <td class="al_c call-price" style="padding:0"><?php echo $this->getPayBtn($data, 'call', 'price'); ?></td>
                  <!--구직자-->
                  <td class="al_c assignedEmployee ellipsis" id="<?php echo $data['employeeID']?>">
                    <?php if ($data['cancelled']): ?>
                        취소됨
                    <?php else: ?>
                      <?php if ($this->get_punk_list($data['callID'])): ?>
                        <?php foreach ($this->get_punk_list($data['callID']) as $value): ; ?>
                                <b class="punk-employee">펑크(<?php echo $this->model->select('employee', " `employeeID` = '{$value['employeeID']}'", 'employeeName'); ?>
                                    )</b><br>
                        <?php endforeach; ?>
                      <?php endif; ?>
                      <?php if ($data['employeeID']): ?>
                            <a class="assignCancelBtn link" id="<?php echo $data['callID'] ?>"
                               title="<?php echo $employeeName ?>" value="<?php echo $data['employeeID']?>">
                              <?php echo $employeeName; ?>
                            </a>
                      <?php endif; ?>
                    <?php endif; ?>
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
  <?php if (sizeof($this->callList) == 0): ?>
      <h1 style="text-align: center;">내역이 존재하지 않습니다.</h1>
  <?php endif; ?>
</div>