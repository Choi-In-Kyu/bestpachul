<div class="mobile_view">

    <form action="" id="callForm" method="post">
        <input type="hidden" name="action" id="formAction">
        <input type="hidden" name="companyID" value="<?php echo $this->companyID ?>">
        <input type="hidden" name="startTime" id="startTime">
        <input type="hidden" name="endTime" id="endTime">
        <input type="hidden" name="salary" id="salary">
        <input type="hidden" name="price" id="callPrice">
        <input type="hidden" name="point" id="callPoint">

        <div class="box">
            <div class="title">근무 날짜</div>
            <div class="content" style="height: 40px;">
                <input id="date" type="date" name="workDate"
                       min="<?php echo _TOMORROW ?>"
                       max="<?php echo $this->lastJoinDate ?>" required
                       value="<?php echo _TOMORROW ?>">
                <button class="btn btn-day" type="button" id="1day">
                    내일(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime(_TOMORROW))] ?>)
                </button>
                <button class="btn btn-day" type="button" id="2day">
                    모레(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime("+2 day"))] ?>)
                </button>
            </div>
        </div>

        <div class="box">
            <div class="title">근무 시간</div>
            <div class="content content-time">
                <div>
                    <select class="time hour" id="startHour" form="callForm" required>
                        <option value="" selected disabled hidden>시작 시간</option>
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
                    <div class="tag">부터</div>
                </div>
                <div>
                    <select class="time hour" id="endHour" form="callForm" required>
                        <option value="" selected disabled hidden>종료 시간</option>
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
                    <div class="tag">까지</div>
                </div>
                <div class="al_r">
                    <button type="button" class="btn btn-time" id="morningBtn">오전</button>
                    <button type="button" class="btn btn-time" id="afternoonBtn">오후</button>
                    <button type="button" class="btn btn-time" id="allDayBtn">종일</button>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="title">업종</div>
            <div class="content" style="height: 50px;">
                <select name="workField" id="workField" form="callForm" required>
                  <?php foreach ($this->workField_List as $key => $data): ?>
                      <option value="<?php echo $data['workField']; ?>">
                        <?php echo $data['workField'] ?>
                      </option>
                  <?php endforeach ?>
                </select>
                <button type="button" class="btn btn-work-field">설거지</button>
                <button type="button" class="btn btn-work-field">주방보조</button>
                <button type="button" class="btn btn-work-field">홀서빙</button>
            </div>
        </div>
        
        <div class="box">
            <div class="title">기타요청사항</div>
            <div class="content"><textarea name="detail" id="detail" cols="30" rows="5"></textarea></div>
        </div>

        <h1 class="callPrice"></h1>
        <button id="btnSendCall" class="btn btn-insert" type="button">콜 신청하기</button>
    </form>
</div>