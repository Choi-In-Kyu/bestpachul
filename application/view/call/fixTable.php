<form id="filterForm" method="post" style="display: none;">
    <input type="hidden" name="action" value="filter">
    <input type="hidden" name="callID" value="">
  <?php foreach ($_POST as $key => $value): ?>
      <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
  <?php endforeach; ?>
</form>

<?php
  function get_dow_kor($str)
  {
    $eng = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $kor = ['월', '화', '수', '목', '금', '토', '일'];
    foreach ($eng as $key => $value) {
      $str = str_replace($value, $kor[$key], $str);
    }
    return $str;
  }

?>

<div class="inline scroll_tbody" style="width: 64%;">
    <table id="fixTable" width="100%">
        <colgroup>
          <?php foreach (['구분', '근무시작일', '근무종료일', '요일', '업체', '인력', '업종', '시작시간', '끝시간', '비고', '월급', '수수료'] as $value): ?>
              <col width="auto">
          <?php endforeach; ?>
        </colgroup>
        <thead>
        <tr>
          <?php foreach (['구분', '근무시작일', '근무종료일', '요일', '업체', '인력', '업종', '시작시간', '끝시간', '비고', '월급', '수수료'] as $value): ?>
              <th class="link"><?php echo $value ?></th>
          <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->fixList as $key => $data): ?>
          <?php
          $employeeName = $this->model->select('employee', "employeeID = '{$data['employeeID']}'", 'employeeName');
          $companyName = $this->model->select('company', "companyID = '{$data['companyID']}'", 'companyName');
          ?>
            <tr class="selectable fixRow" id="<?php echo $data['fixID'] ?>">
                <td class="al_c"><?php echo $data['fixID'].$this->get_fixType($data)?></td>
              <?php $dayofweek = ['일', '월', '화', '수', '목', '금', '토'] ?>
                <td class="al_l"><?php echo $data['workDate'] . "(" . $dayofweek[date('w', strtotime($data['workDate']))] . ")" ?></td>
                <td class="al_l"><?php echo $data['endDate'] . "(" . $dayofweek[date('w', strtotime($data['endDate']))] . ")" ?></td>
                <td class="al_l"><?php echo get_dow_kor($data['dayofweek']) ?></td>
                <td class="al_l">
                    <a href="http://bestpachul.com/company/view/<?php echo $data['companyID'] ?>" class="link">
                      <?php echo $companyName ?>
                    </a>
                </td>
                <td class="al_l">
                    <a href="http://bestpachul.com/employee/view/<?php echo $data['employeeID'] ?>" class="link">
                      <?php echo $employeeName ?>
                    </a>
                </td>
                <td class="al_l"><?php echo $data['workField'] ?></td>
                <td class="al_l"><?php echo $data['startTime'] ?></td>
                <td class="al_l"><?php echo $data['endTime'] ?></td>
                <td class="al_l"><?php echo $data['detail'] ?></td>
                <td class="al_l"><?php echo number_format($data['monthlySalary']) ?></td>
                <td class="al_c"><?php echo $this->get_paidBtn($data, 'fix', 'commission'); ?></td>
                <td class="al_c">
                  <?php if ($data['cancelled'] == 0): ?>
                      <button type="button" class="fixCancelBtn btn btn-small btn-danger"
                              id="<?php echo $data['fixID']; ?>">취소
                      </button>
                  <?php else: ?>
                      (취소됨)
                  <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>