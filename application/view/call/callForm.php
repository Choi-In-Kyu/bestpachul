<form action="" id="callForm" method="post">
    <input type="hidden" name="action" id="formAction">
    <input type="hidden" name="companyID" id="companyID" value="<?php if(isset($this->companyID)) echo $this->companyID?>">
    <input type="hidden" name="employeeID" class="employee" id="employeeID">
    <input type="hidden" name="startTime" class="startTime" id="startTime">
    <input type="hidden" name="endTime" class="endTime" id="endTime">
    <input type="hidden" name="salary" id="salary">
    <input type="hidden" name="price" id="callPrice">
    <input type="hidden" name="point" id="callPoint">
    <input type="hidden" name="workDate" id="workDate" class="workDate" value="<?php echo _TOMORROW ?>">
    <input type="hidden" name="endDate" id="endDate" class="endDate">
    <input type="hidden" name="fixID" id="fixID">
    <input type="hidden" name="commission">
    <div class="table">
      
      
      <?php if ($this->param->page_type != 'ceo'): ?>
          <!--인력이름, 상호명-->
          <div class="tr">
              <div class="td td-4">
                  <label for="">상호명</label>
                  <input type="text" class="input-companyName" list="companyList" name="companyName" id="companyName"
                         placeholder="배정 요청한 거래처를 입력하세요">
                  <datalist id="companyList" class="input-field">
                    <?php foreach ($companyList as $key => $data): ?>
                        <option value="<?php echo $data['companyName'] ?>">
                          <?php echo "(" . $this->model->joinType($data['companyID'], 'kor') . ")"; ?>
                        </option>
                    <?php endforeach ?>
                  </datalist>
              </div>
              <div class="td td-4">
                  <label for="">인력명</label>
                  <input type="text" list="employeeList" name="employeeName" class="employee" id="employeeName"
                         placeholder="배정할 인력을 입력하세요 (생략가능)">
                  <datalist id="employeeList" class="input-field">
                    <?php foreach ($employeeList as $key => $data): ?>
                        <option value="<?php echo $data['employeeName'] ?>">
                          <?php if ($data['bookmark'] == 1) echo "(북마크)"; ?>
                        </option>
                    <?php endforeach ?>
                  </datalist>
              </div>
              <div class="td td-3" id="errorMsg" style="display: none;">
                  <h2 style="margin: 0 10px;"></h2>
              </div>
          </div>
      <?php endif; ?>

        <!--근무요일-->
        <div class="tr fixable" id="workDay" style="display: none;">
            <div class="td td-9">
                <label for="">근무요일</label>
                <table style="width: 700px">
                    <tr>
                        <td><input type="checkbox" name="dow[]" value="monday"></td>
                        <td><input type="checkbox" name="dow[]" value="tuesday"></td>
                        <td><input type="checkbox" name="dow[]" value="wednesday"></td>
                        <td><input type="checkbox" name="dow[]" value="thursday"></td>
                        <td><input type="checkbox" name="dow[]" value="friday"></td>
                        <td><input type="checkbox" name="dow[]" value="saturday"></td>
                        <td><input type="checkbox" name="dow[]" value="sunday"></td>
                    </tr>
                    <tr>
                        <td>월</td>
                        <td>화</td>
                        <td>수</td>
                        <td>목</td>
                        <td>금</td>
                        <td>토</td>
                        <td>일</td>
                    </tr>
                </table>
            </div>
        </div>
        <!--근무기간-->
        <div class="tr">
            <div class="td td-4">
                <label for="" style="font-weight: bold; font-size: 16px; display: block">근무기간</label>
                <input type="date" class="workDate" value="<?php echo _TOMORROW ?>">
            </div>
            <div class="endDate fixable td td-3" style="display: none;">
                <strong style="font-size: 30px; display: inline-block; margin-right: 28px; vertical-align: middle;">~</strong>
                <input type="date" class="endDate">
            </div>
            <div class="td td-3">
                <button class="fixable btn btn-option" type="button" onclick="auto_insert_call_monthly()"
                        style="display: none">이번달
                </button>
            </div>
            <div class="td td-3">
                <button class="basic btn btn-option selected" type="button" id="tomorrow">
                    내일(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime(_TOMORROW))] ?>)
                </button>
                <button class="basic btn btn-option" type="button" id="dayAfterTomorrow">
                    모레(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime("+2 day"))] ?>)
                </button>
            </div>
        </div>
        <!--근무시간-->
        <div class="tr">
            <div class="td td-6" id="">
                <label for="">근무시간</label>
                <select id="startHour" class="time hour" form="callForm" required>
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
                <select id="endHour" class="time hour" form="callForm" required>
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
            <div class="td td-3">
                <button type="button" class="btn btn-option timeSelect selected" id="morningBtn">오전</button>
                <button type="button" class="btn btn-option timeSelect" id="afternoonBtn">오후</button>
                <button type="button" class="btn btn-option timeSelect" id="allDayBtn">종일</button>
            </div>
        </div>
        <div class="tr">
            <div class="td td-9">
                <label for="">임금</label>
                <p id="salaryInfo" style="display:inline-table;    width: 100%; padding: 0 10px; margin: 0;">근무시간을 선택해주세요</p>
            </div>
        </div>
        <!--업종-->
        <div class="tr">
            <div class="td td-4">
                <label for="">업종</label>
                <select class="selector-work-field" name="workField" style="background: #fff; height: 40px; margin-right: 10px; font-size: 16px;" id="workField" form="callForm" required>
                  <?php foreach ($this->workField_List as $key => $data): ?>
                      <option value="<?php echo $data['workField']; ?>">
                        <?php echo $data['workField'] ?>
                      </option>
                  <?php endforeach ?>
                </select>
            </div>
            <div class="td td-3 container-jobs">
                <button type="button" class="btn btn-option btn-work-field wash">설거지</button>
                <button type="button" class="btn btn-option btn-work-field kitchen selected ">주방보조</button>
                <button type="button" class="btn btn-option btn-work-field hall">홀서빙</button>
            </div>
        </div>
        <!--월급-->
        <div class="tr monthly" style="display: none;">
            <div class="td td-4">
                <label for="">월급</label>
                <input type="number" name="monthlySalary" id="monthlySalary">
            </div>
            <div class="td td-4">
                <label for="">수수료 비율</label>
                <input type="number" name="percentage" id="percentage">
            </div>
            <div class="td td-4">
                <label for="">수수료</label>
                <input type="number" name="commission" id="commission">
            </div>
        </div>
        <!--기타 요청 사항-->
        <div class="tr">
            <div class="td td-9">
                <label for="" style="min-width: 200px;">기타 요청 사항</label>
                <textarea name="detail" id="detail" cols="30" rows="6"></textarea>
            </div>
        </div>
        <!--콜 보내기 버튼-->
        <div class="btn-group al_r" style="position: fixed; bottom: 0; left: 0; right: 0; ">
            <h1 class="callPrice"></h1>
            <button id="btnSendCall" class="btn btn-insert callBtn" type="button">콜 신청하기</button>
          <?php if ($this->param->page_type != 'ceo'): ?>
              <button id="submitFixedCallBtn" class="btn btn-insert callBtn fixBtn" type="button">고정 콜 만들기</button>
              <button id="submitMonthlyCallBtn" class="btn btn-insert callBtn fixBtn" type="button">월급제 만들기</button>
          <?php endif; ?>
        </div>
</form>

<!--기존 모바일 화면-->
<!--<form action="" id="callForm" method="post">-->
<!--    <input type="hidden" name="action" id="formAction">-->
<!--    <input type="hidden" name="companyID" value="--><?php //echo $this->companyID ?><!--">-->
<!--    <input type="hidden" name="startTime" id="startTime">-->
<!--    <input type="hidden" name="endTime" id="endTime">-->
<!--    <input type="hidden" name="salary" id="salary">-->
<!--    <input type="hidden" name="price" id="callPrice">-->
<!--    <input type="hidden" name="point" id="callPoint">-->
<!---->
<!--    <div class="box">-->
<!--        <div class="title">근무 날짜</div>-->
<!--        <div class="content" style="height: 40px;">-->
<!--            <input id="date" type="date" name="workDate"-->
<!--                   min="--><?php //echo _TOMORROW ?><!--"-->
<!--                   max="--><?php //echo $this->lastJoinDate ?><!--" required-->
<!--                   value="--><?php //echo _TOMORROW ?><!--">-->
<!--            <button class="btn btn-day" type="button" id="1day">-->
<!--                내일(--><?php //echo unserialize(DAYOFWEEK)[date('w', strtotime(_TOMORROW))] ?><!--)-->
<!--            </button>-->
<!--            <button class="btn btn-day" type="button" id="2day">-->
<!--                모레(--><?php //echo unserialize(DAYOFWEEK)[date('w', strtotime("+2 day"))] ?><!--)-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="box">-->
<!--        <div class="title">근무 시간</div>-->
<!--        <div class="content content-time">-->
<!--            <div>-->
<!--                <select class="time hour" id="startHour" form="callForm" required>-->
<!--                    <option value="" selected disabled hidden>시작 시간</option>-->
<!--                  --><?php //for ($i = 1; $i < 25; $i++): ?>
<!--                      <option class="startOption" value="--><?php //echo $i ?><!--">-->
<!--                        --><?php //echo $this->getTime($i); ?>
<!--                      </option>-->
<!--                  --><?php //endfor; ?>
<!--                </select>-->
<!--                <select class="time minute" id="startMin" form="callForm" required>-->
<!--                    <option value="00">00분</option>-->
<!--                    <option value="30">30분</option>-->
<!--                </select>-->
<!--                <div class="tag">부터</div>-->
<!--            </div>-->
<!--            <div>-->
<!--                <select class="time hour" id="endHour" form="callForm" required>-->
<!--                    <option value="" selected disabled hidden>종료 시간</option>-->
<!--                  --><?php //for ($i = 1; $i < 37; $i++): ?>
<!--                      <option class="endOption" value="--><?php //echo $i ?><!--">-->
<!--                        --><?php //echo $this->getTime($i); ?>
<!--                      </option>-->
<!--                  --><?php //endfor; ?>
<!--                </select>-->
<!--                <select class="time minute" id="endMin" form="callForm" required>-->
<!--                    <option value="00">00분</option>-->
<!--                    <option value="30">30분</option>-->
<!--                </select>-->
<!--                <div class="tag">까지</div>-->
<!--            </div>-->
<!--            <div class="al_r">-->
<!--                <button type="button" class="btn btn-time" id="morningBtn">오전</button>-->
<!--                <button type="button" class="btn btn-time" id="afternoonBtn">오후</button>-->
<!--                <button type="button" class="btn btn-time" id="allDayBtn">종일</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="box">-->
<!--        <div class="title" id="salaryInfo"></div>-->
<!--    </div>-->
<!---->
<!--    <div class="box">-->
<!--        <div class="title">업종</div>-->
<!--        <div class="content" style="height: 50px;">-->
<!--            <select name="workField" id="workField" form="callForm" required>-->
<!--              --><?php //foreach ($this->workField_List as $key => $data): ?>
<!--                  <option value="--><?php //echo $data['workField']; ?><!--">-->
<!--                    --><?php //echo $data['workField'] ?>
<!--                  </option>-->
<!--              --><?php //endforeach ?>
<!--            </select>-->
<!--            <button type="button" class="btn btn-work-field">설거지</button>-->
<!--            <button type="button" class="btn btn-work-field">주방보조</button>-->
<!--            <button type="button" class="btn btn-work-field">홀서빙</button>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="box">-->
<!--        <div class="title">기타요청사항</div>-->
<!--        <div class="content"><textarea name="detail" id="detail" cols="30" rows="5"></textarea></div>-->
<!--    </div>-->
<!---->
<!--    <h1 class="callPrice"></h1>-->
<!--    <button id="btnSendCall" class="btn btn-insert" type="button">콜 신청하기</button>-->
<!--</form>-->