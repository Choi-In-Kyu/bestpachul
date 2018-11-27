<?php
    switch ($type){
      case 'call': $width = ($this->param->action == 'assign') ? 79 : 84; break;
      case 'punk': $width = (in_array($this->param->page_type, ['company', 'employee'])) ? 100 : 84; break;
      case 'fix': $width = 79; break;
    }
?>

<form id="filterForm" method="post" style="display: none;">
    <input type="hidden" name="action" value="filter">
    <input type="hidden" name="callID" value="">
  <?php foreach ($_POST as $key => $value): ?>
      <input type="hidden" name="<?php echo $key?>" value="<?php echo $value?>">
  <?php endforeach; ?>
</form>

<div class="inline scroll_tbody call" style="width: <?php echo $width ?>%;">
    <table id="<?php echo $type."_table"?>" width="100%" style="height: <?php echo (sizeof($this->{$type.'List'}) == 0) ? '50px;' : null ?>">
        <thead>
        <tr>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',0)">구분</th>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',1)">근무날짜</th>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',2)">업체명</th>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',3)">근무시간</th>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',4)">업종</th>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',5)">일당</th>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',6)">요청사항</th>
            <th class="link" onclick="sortTable('<?php echo $type.'_table'?>',7)">인력</th>
            <th>취소</th>
        </tr>
        </thead>
      <?php if (sizeof($this->{$type.'List'}) > 0): ?>
          <tbody>
          <?php foreach ($this->{$type.'List'} as $key => $data): ?>
            <?php
            $employeeName = $this->model->select('employee', "employeeID = '{$data['employeeID']}'", 'employeeName');
            $companyName = $this->model->select('company', "companyID = '{$data['companyID']}'", 'companyName');
            ?>
              <tr class="selectable callRow <?php if ($data['cancelled'] == 1) echo 'cancelled' ?>" id="<?php echo $data['callID'] ?>">
                  <td class="al_c"><?php echo $data['callID'] . $this->assignType($data) ?></td>
                  <td class="al_l"><?php echo $data['workDate'] ?></td>
                  <td class="al_l">
                      <a href="http://bestpachul.com/company/view/<?php echo $data['companyID'] ?>" class="link">
                        <?php echo $companyName?>
                      </a>
                  </td>
                  <td class="al_l"><?php echo $this->timeType($data) ?></td>
                  <td class="al_l"><?php echo $data['workField'] ?></td>
                  <td class="al_l"><?php echo $data['salary'] ?></td>
                  <td class="al_l">
                    <?php                                                                       echo $data['detail'] ?>
                    <?php if ( ($data['cancelled'] == 1) && (isset($data['cancelDetail'])) )    echo "<br>({$data['cancelDetail']})"; ?>
                    <?php if ( ($type=='punk') && (isset($data['punkDetail'])) )                echo "<br>({$data['punkDetail']})"?>
                  </td>
                  <td class="al_c">
  
                    <?php switch ($type): case 'call': ?>
                      <?php if (isset ($data['employeeID'])): ?>
                            <a class="assignCancelBtn link" id="<?php echo $data['callID'] ?>">
                              <?php echo $employeeName?>
                            </a>
                      <?php elseif ($this->param->action != 'assign' && ($data['cancelled'] == 0)): ?>
                            <button type="button" class="btn btn-small btn-submit moveAssignBtn" id="<?php echo $data['callID'] ?>">배정</button>
                      <?php endif; ?>
                      <?php break; ?>
  
                    <?php case 'punk': ?>
                        <a href="http://bestpachul.com/employee/view/<?php echo $data['employeeID'] ?>" class="link">
                          <?php echo $employeeName ?>
                        </a>
                      <?php break; ?>
                    <?php endswitch; ?>
                    
                  </td>
                  <td class="al_c hide">
                    <?php if ($data['cancelled'] == 0): ?>
                        <button type="button" class="callCancelBtn btn btn-small btn-danger" id="<?php echo $data['callID'] ?>">취소</button>
                    <?php else: ?>
                        (취소됨)
                    <?php endif; ?>
                  </td>
              </tr>
          <?php endforeach ?>
          </tbody>
      <?php endif; ?>
    </table>
  <?php if (sizeof($this->{$type.'List'}) == 0): ?>
      <h1><?php echo ($type=='call') ? '콜':'펑크'; ?> 내역이 존재하지 않습니다.</h1>
  <?php endif; ?>
</div>