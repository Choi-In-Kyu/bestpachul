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
                <th onclick="sortTable(0)">근무일</th>
                <th onclick="sortTable(1)">시작</th>
                <th onclick="sortTable(2)">끝</th>
                <th onclick="sortTable(3)">직종</th>
                <th onclick="sortTable(4)">배정</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->callList as $key => $value): ?>
                <tr class="callList" id="<?php echo $value['callID']?>">
                    <td class="workDate"><?php echo $value['workDate'] ?></td>
                    <td><?php echo $value['startTime'] ?></td>
                    <td><?php echo $value['endTime'] ?></td>
                    <td><?php echo $value['workField'] ?></td>
                    <td>
                      <?php if (isset($value['employeeID'])): ?>
                        <?php echo $this->employeeName($value['employeeID']);?>
                      <?php else: ?>
                        <?php if ($value['cancelled'] == 1): ?>
                          (취소됨)
                        <?php else: ?>
                              <form action="" method="post">
                                  <input type="hidden" name="action" value="cancel">
                                  <input type="hidden" name="callID" value="<?php echo $value['callID'] ?>">
                                  <input class="btn" type="submit" value="취소">
                              </form>
                        <?php endif; ?>
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
    $('#month').on('change',function () {
        $('#month').val($(this).val());
        change();
    });
    $('.callList').click(function () {

        let callList = JSON.parse('<?php echo json_encode($this->callList)?>');
        let index = $(this).index();
        alert('요청사항 : '+callList[index]['detail']);
    });
    
    function change() {
        let day = new Date(parseInt($('#year').val()) + "/" + parseInt($('#month').val()) + "/01");
        let startTime = day;
        let endTime = new Date(new Date(parseInt($('#year').val()) + "/" + parseInt($('#month').val()) + "/01").setMonth(new Date(parseInt($('#year').val()) + "/" + parseInt($('#month').val()) + "/01").getMonth()+1));
        let rows = $('.workDate');
        let yearArray = JSON.parse('<?php echo json_encode($this->getDate($this->callList))?>');
        console.log(typeof(yearArray));
        for (let i = 0; i<$('.month').length; i++){
            if(yearArray[$('#year').val()].map(Number).includes(i+1)){
                $('.month').eq(i).css('display','block');
            }
            else{
                $('.month').eq(i).css('display','none');
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