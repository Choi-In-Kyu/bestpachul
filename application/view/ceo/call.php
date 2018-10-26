<div class="mobile_view">
    <h1>콜 보내기</h1>
    <form action="" id="callForm" method="post">
        <input type="hidden" name="action" value="call">
        <div class="table">
            <div class="tr tr-merged">
                <div class="lbl lbl-2row" rowspan="2">날짜</div>
                <div class="td">
                    <button type="button" id="1day">내일(<? echo $this->day[date("w", strtotime("+1 day"))] ?>)</button>
                    <button type="button" id="2day">모레(<? echo $this->day[date("w", strtotime("+2 day"))] ?>)</button>
                </div>
                <div class="td">
                    <input id="date" type="date" name="workDate" min="<?php echo date("Y-m-d") ?>" value="<?php echo date('Y-m-d') ?>" required>
                </div>
            </div>
            <div class="tr tr-merged">
                <div class="lbl lbl-2row" rowspan="4">시간</div>
                <div class="td">
                    <button type="button" id="morningBtn">오전</button>
                    <button type="button" id="afternoonBtn">오후</button>
                    <button type="button" id="allDayBtn">종일</button>
                </div>
                <div class="td">
                    <input type="hidden" name="startTime" id="startTime" value="">
                    <select class="hour" id="startHour" form="callForm" required>
                      <?php for ($i = 0; $i < 25; $i++): ?>
                          <option value="<?php echo $i ?>">
                            <?php echo $this->getTime($i);?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="minute" id="startMin" form="callForm" required>
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                    <h2>부터</h2>
                </div>
                <div class="td">
                    <input type="hidden" name="endTime" id="endTime" value="">
                    <select class="hour" id="endHour" form="callForm" required>
                      <?php for ($i = 0; $i < 25; $i++): ?>
                          <option value="<?php echo $i ?>">
                            <?php echo $this->getTime($i);?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="minute" id="endMin" form="callForm" required>
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                    <h2>까지</h2>
                </div>
                <div class="td">
                    <h1 id="salary">근무시간을 선택해주세요</h1>
                </div>
            </div>
            <div class="tr">
                <div class="lbl">업종</div>
                <div class="td">
                    <select name="workField" id="workField" form="callForm" required>
                      <?php foreach ($this->workFieldList as $key => $data): ?>
                          <option value="<?php echo $data['workField']; ?>">
                            <?php echo $data['workField'] ?>
                          </option>
                      <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="tr">
                <div class="lbl">기타요청사항</div>
                <div class="td">
                    <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="tr al_r">
                    <input id="submitBtn" class="btn btn-insert" type="submit">
            </div>
        </div>
    </form>

</div>
</div>

<script>
    let startHour = $('#startHour');
    let endHour = $('#endHour');
    let hour = $('.hour');
    let minute = $('.minute');
    let salary = $('#salary');
    let form = $('#callForm');
    let submit = $('#submitBtn');
    
    function check(){
        let time = endHour.val()-startHour.val();
        if(5>time || time>12){
            alert("5~12시간 콜만 가능합니다");
            startHour.val('0');
            endHour.val('0');
            minute.val(null);
            return 0;
        }
        else return time;
    }
    
    function calculate(time){
        let money;
        switch (time) {
            case 5: money = 42000; break;
            case 6: money = 49000; break;
            case 7: money = 56000; break;
            case 8: money = 63000; break;
            case 9: money = 70000; break;
            case 10: money = 77000; break;
            case 11: money = 81000; break;
            case 12: money = 85000; break;
            default: money = 0; break;
        }
        salary.html("근무시간: "+time+"/ 일당: "+money);
    }
    
    $(document).ready(function () {
        calculate(endHour.val()-startHour.val());
    });
    
    $('#1day').click(function () {
        $('#date').val('<?php echo date("Y-m-d", strtotime("+1 day"))?>');
    });
    $('#2day').click(function () {
        $('#date').val('<?php echo date("Y-m-d", strtotime("+2 day"))?>');
    });
    $('#morningBtn').click(function () {
        startHour.val('10');
        endHour.val('15');
        minute.val('00');
        hour.trigger('change');
    });
    $('#afternoonBtn').click(function () {
        startHour.val('18');
        endHour.val('23');
        minute.val('00');
        hour.trigger('change');
    });
    $('#allDayBtn').click(function () {
        startHour.val('10');
        endHour.val('22');
        minute.val('00');
        hour.trigger('change');
    });
    hour.on('change', function () {
        check;
        calculate(check());
    });
    minute.on('change', function () {
        minute.val($(this).val());
    });
    
    submit.on('click',function () {
        alert("click")
        $('#startTime').val(startHour.val()+":"+$('#startMin').val());
        $('#endTime').val(endHour.val()+":"+$('#endMin').val());
    });
</script>