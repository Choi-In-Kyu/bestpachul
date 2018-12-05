<div class="mobile_view">
    <form id="listForm" method="post" onchange="change()">
        <select class="filter" id="year" form="listForm" required>
          <?php foreach ($this->getDate($this->callList) as $key => $value): ?>
              <option class="year" value="<?php echo $key ?>"><?php echo $key ?></option>
          <?php endforeach; ?>
        </select>
        <select class="filter" id="month" form="listForm" onchange="change()">
          <?php for ($i = 1; $i <= 12; $i++): ?>
              <option class="month"
                      value="<?php echo $i ?>" <?php if ($i == date('n')) echo 'selected' ?>><?php echo $i . "월" ?></option>
          <?php endfor; ?>
        </select>
    </form>

    <div class="mobile_list">
        <table id="callList">
            <thead>
            <tr>
                <th class="al_c link" onclick="sortTable('callList',0)">근무일</th>
                <th class="al_c link" onclick="sortTable('callList',1)">시작</th>
                <th class="al_c link" onclick="sortTable('callList',2)">끝</th>
                <th class="al_c link" onclick="sortTable('callList',3)">직종</th>
              <?php if ($this->joinType == 'point'): ?>
                  <th class="al_c link" onclick="sortTable('callList',4)">포인트</th>
              <?php else: ?>
                  <th class="al_c link" onclick="sortTable('callList',4)">호출비</th>
              <?php endif; ?>
                <th class="al_c link" onclick="sortTable('callList',5)">배정</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->callList as $key => $value): ?>
                <tr class="callList" id="<?php echo $value['callID'] ?>">
                    <td class="workDate"><?php echo $value['workDate'] ?></td>
                    <td><?php echo $value['startTime'] ?></td>
                    <td><?php echo $value['endTime'] ?></td>
                    <td><?php echo $value['workField'] ?></td>
                  <?php if ($this->joinType == 'point'): ?>
                      <td><?php if (isset($value['point'])) echo $value['point']; else echo '없음'; ?></td>
                  <?php else: ?>
                      <td><?php if (isset($value['price'])) echo $value['price']; else echo '없음'; ?></td>
                  <?php endif; ?>

                    <td class="al_c">
                      <?php if ($value['cancelled'] == 1) echo "(취소됨)" ?>
                      <?php if (isset($value['employeeID'])) echo $this->employeeName($value['employeeID']); ?>
                      <?php if ($value['cancelled'] == 0 && !isset($value['employeeID'])): ?>
                          <button type="button" id="<?php echo $value['callID'] ?>" class="btn callCancelModalBtn">취소
                          </button>
                      <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



<script>
    $(document).ready(function () {
        change();
    });
    $('#year').on('change', function () {
        $('#year').val($(this).val());
        change();
    });
    $('#month').on('change', function () {
        $('#month').val($(this).val());
        change();
    });
    $('.callList').click(function () {
        let callList = JSON.parse('<?php echo json_encode($this->callList)?>');
        let index = $(this).index();
        alert('요청사항 : ' + callList[index]['detail']);
    });
    $('.callCancelModalBtn').on('click', function () {
        event.stopPropagation();
        $('#callCancelModal').show();
        $('#callCancelModal input[name=callID]').val(this.id);
    });
    $('#closeCallCancelModal').on('click', function () {
        $('#callCancelModal').hide();
    });
    $('.callCancelModalBtn').on('click', function () {
        console.log(this.id);
        $('#callCancelID').val(this.id);
    });
    $('#callCancelBtn').on('click', function () {
        cancel();
    });
    
    function change() {
        let month = $('.month');
        let day = new Date(parseInt($('#year').val()) + "/" + parseInt($('#month').val()) + "/01");
        let startTime = day;
        let endTime = new Date(new Date(parseInt($('#year').val()) + "/" + parseInt($('#month').val()) + "/01").setMonth(new Date(parseInt($('#year').val()) + "/" + parseInt($('#month').val()) + "/01").getMonth() + 1));
        let rows = $('.workDate');
        let yearArray = JSON.parse('<?php echo json_encode($this->getDate($this->callList))?>');
        for (let i = 0; i < 12; i++) {
            if (yearArray[$('#year').val()].map(Number).includes(i + 1)) {
                console.log(month.eq(i).val());
                month.eq(i).css('background','blue');
            }
            else {
                month.eq(i).css('display','none');
            }
        }
        rows.each(function () {
            let rowDate = new Date($(this).text()).getTime();
            if (rowDate > startTime.getTime() && rowDate <= endTime.getTime()) {
                $(this).parent().css('display', 'table-row');
            }
            else {
                $(this).parent().css('display', 'none');
            }
        });
    }
</script>
