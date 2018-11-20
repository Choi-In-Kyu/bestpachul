<?php $width = (in_array($this->param->page_type, ['company', 'employee'])) ? 100 : 84 ?>
<div class="inline scroll_tbody call" style="width: <?php echo $width ?>%;">
    <table id="call_table" width="100%" style="height: <?php if (sizeof($this->punkList) == 0) echo '50px;' ?>">
        <thead>
        <tr>
            <th onclick="sortTable('call_table',0)">구분</th>
            <th onclick="sortTable('call_table',1)">근무날짜</th>
            <th onclick="sortTable('call_table',2)">업체명</th>
            <th onclick="sortTable('call_table',3)">근무시간</th>
            <th onclick="sortTable('call_table',4)">업종</th>
            <th onclick="sortTable('call_table',5)">일당</th>
            <th onclick="sortTable('call_table',6)">요청사항</th>
            <th onclick="sortTable('call_table',7)">인력</th>
            <th onclick="sortTable('call_table',8)">취소</th>
        </tr>
        </thead>
      <?php if (sizeof($this->punkList) > 0): ?>
          <tbody>
          <?php foreach ($this->punkList as $key => $data): ?>
              <tr class="selectable callRow" id="<?php echo $data['callID'] ?>">
                  <form id="filterForm<?php echo $data['callID'] ?>" action="" method="post">
                      <input type="hidden" name="action" value="filter">

                      <input type="hidden" name="callID" value="<?php echo $data['callID'] ?>">
                      <input type="hidden" name="filter" value="<?php echo $_POST['filter'] ?>">
                      <input type="hidden" name="date" value="<?php echo $_POST['date'] ?>">

                      <input type="hidden" name="callID" value="<?php echo $data['callID'] ?>">
                  </form>
                  <td class="al_c"><?php echo $data['callID'] . $this->assignType($data) ?></td>
                  <td class="al_l"><?php echo $data['workDate'] ?></td>
                  <td class="al_l">
                      <a href="http://bestpachul.com/company/view/<?php echo $data['companyID'] ?>" class="link">
                        <?php echo $this->db->select('company', "companyID = $data[companyID]", 'companyName') ?>
                      </a>
                  </td>
                  <td class="al_l"><?php echo $this->timeType($data) ?></td>
                  <td class="al_l"><?php echo $data['workField'] ?></td>
                  <td class="al_l"><?php echo $data['salary'] ?></td>
                  <td class="al_l">
                    <?php echo $data['callDetail'] ?><br>
                      (<?php echo $data['punkDetail'] ?>)
                  </td>
                  <td class="al_c">
                    <?php if (isset ($data['employeeID'])): ?>
                        <a href="http://bestpachul.com/employee/view/<?php echo $data['employeeID'] ?>" class=" link">
                          <?php echo $this->db->select('employee', "employeeID = $data[employeeID]", 'employeeName') ?>
                        </a>
                    <?php endif; ?>
                  </td>
                  <td class="al_c hide">
                    <?php if ($data['cancelled'] == 0): ?>
                        <form action="" method="post">
                            <input type="hidden" name="action" value="callCancel">
                            <input type="hidden" name="callID" value="<?php echo $data['callID'] ?>">
                            <input type="submit" class="btn btn-small btn-danger btn-cancel"
                                   id="<?php echo $data['callID'] ?>" value="취소">
                        </form>
                    <?php else: ?>
                        (취소됨)
                    <?php endif; ?>
                  </td>
              </tr>
          <?php endforeach ?>
          </tbody>
      <?php endif; ?>
    </table>
  <?php if (sizeof($this->punkList) == 0): ?>
      <h1>펑크 내역이 존재하지 않습니다.</h1>
  <?php endif; ?>

</div>