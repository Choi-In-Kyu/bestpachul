<div class="mobile_view">
    
    <form action="" id="callForm" method="post">
        <input type="hidden" name="action" id="formAction">
        <input type="hidden" name="companyID" value="<?php echo $this->companyID?>">
        <input type="hidden" name="startTime" id="startTime">
        <input type="hidden" name="endTime" id="endTime">
        <input type="hidden" name="salary" id="salary">
        <input type="hidden" name="price" id="callPrice">
        <input type="hidden" name="point" id="callPoint">
        <!--날짜-->
        <div class="container">
            <div class="tr tr-title">
                <div class="lbl">날짜</div>
            </div>
            <div class="tr tr-body">
                <div class="td td-50">
                    <input class="date" id="date" type="date" name="workDate"
                           min="<?php echo date("Y-m-d", strtotime('+1 day')) ?>"
                           max="<?php echo $this->lastJoinDate ?>" required
                           value="<?php echo _TOMORROW ?>">
                </div>
                <div class="td td-50">
                    <button class="btn-day" type="button" id="1day">
                        내일(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime(_TOMORROW))] ?>)
                    </button>
                    <button class="btn-day" type="button" id="2day">
                        모레(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime("+2 day"))] ?>)
                    </button>
                </div>
            </div>
        </div>
        <!--시간-->
        <div class="container">
            <div class="tr tr-title">
                <div class="lbl">시간</div>
            </div>
            <div class="tr tr-body">
                <div class="td td-70" id="">
                    <select class="time hour" id="startHour" form="callForm" required>
                        <option value="" selected disabled hidden>근무 시작 시간</option>
                      <?php for ($i = 1; $i < 25; $i++): ?>
                          <option class="startOption" value="<?php echo $i ?>">
                            <?php echo $this->getTime($i); ?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="time minute" id="startMin" form="callForm" required>
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                    <select class="time hour" id="endHour" form="callForm" required>
                        <option value="" selected disabled hidden>근무 종료 시간</option>
                      <?php for ($i = 1; $i < 37; $i++): ?>
                          <option class="endOption" value="<?php echo $i ?>">
                            <?php echo $this->getTime($i); ?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="time minute" id="endMin" form="callForm" required>
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                </div>
                <div class="td td-30">
                    <button type="button" class="timeSelect" id="morningBtn">오전</button>
                    <button type="button" class="timeSelect" id="afternoonBtn">오후</button>
                    <button type="button" class="timeSelect" id="allDayBtn">종일</button>
                </div>
            </div>
            <div class="tr-title">
                <div class="td">
                    <h1 id="salaryInfo">근무기간을 선택해주세요</h1>
                </div>
            </div>
        </div>
        <!--업종-->
        <div class="container">
            <div class="tr tr-title">
                <div class="lbl">업종</div>
            </div>
            <div class="tr">
                <div class="td">
                    <button type="button" class="btn workFieldBtn">설거지</button>
                    <button type="button" class="btn workFieldBtn">주방보조</button>
                    <button type="button" class="btn workFieldBtn">홀서빙</button>
                    <select name="workField" id="workField" form="callForm" required>
                      <?php foreach ($this->workField_List as $key => $data): ?>
                          <option value="<?php echo $data['workField']; ?>">
                            <?php echo $data['workField'] ?>
                          </option>
                      <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>
        <!--기타-->
        <div class="container">
            <div class="tr tr-title">
                <div class="lbl">기타요청사항</div>
            </div>
            <div class="tr tr-body">
                <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
            </div>
        </div>
        <!--버튼-->
        <div class="tr al_r full_width">
            <h1 class="callPrice"></h1>
            <button id="submitBtn" class="btn btn-insert" type="button">콜 보내기</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('#formAction').val('initiate');
        $('#workField').val('주방보조');
        startHour.val('10');
        endHour.val('15');
        initiate(endHour.val() - startHour.val());
    });
</script>