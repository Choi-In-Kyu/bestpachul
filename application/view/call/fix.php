<?php

?>


<div class="board_write">
    <div>
        <button class="btn btn-default selectable selected" id="manualCallBtn">일반콜</button>
        <button class="btn btn-default selectable" id="fixCallBtn">고정</button>
        <button class="btn btn-default selectable" id="monthlyCallBtn">월급제</button>
    </div>

    <form action="" id="callForm" method="post">
        <input type="hidden" name="action" id="formAction">
        <input type="hidden" name="companyID" id="companyID">
        <input type="hidden" name="employeeID" id="employeeID">
        <input type="hidden" name="startTime" id="startTime">
        <input type="hidden" name="endTime" id="endTime">
        <input type="hidden" name="salary" id="salary">
        <input type="hidden" name="price" id="callPrice">
        <input type="hidden" name="point" id="callPoint">
        <input type="hidden" name="workDate" id="workDate" class="workDate">
        <input type="hidden" name="endDate" id="endDate" class="endDate">
        <input type="hidden" name="fixID" id="fixID">
        <input type="hidden" name="commission">
        <div class="table">
            <!--인력이름, 업체이름-->
            <div class="tr">
                <div class="td-label">인력명</div>
                <div class="td">
                    <input type="text" list="employeeList" name="employeeName" id="employeeName">
                    <datalist id="employeeList" class="input-field">
                      <?php foreach ($this->employee_List as $key => $data): ?>
                          <option value="<?php echo $data['employeeName'] ?>"></option>
                      <?php endforeach ?>
                    </datalist>
                </div>
                <div class="td-label">업체명</div>
                <div class="td">
                    <input type="text" list="companyList" name="companyName" id="companyName">
                    <datalist id="companyList" class="input-field">
                      <?php foreach ($this->company_List as $key => $data): ?>
                          <option value="<?php echo $data['companyName'] ?>"></option>
                      <?php endforeach ?>
                    </datalist>
                </div>
            </div>
            <!--근무요일-->
            <div class="tr fixable" id="workDay" style="display: none;">
                <div class="td-label">근무요일</div>
                <div class="td">
                    <table>
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
                <div class="td-label">근무기간</div>
                <div class="td" style="width: 90%;">
                    <input type="date" class="workDate">
                    <div class="endDate fixable" style="display: none;">
                        <strong style="font-size: 30px;">~</strong>
                        <input type="date" class="endDate">
                    </div>
                    <button type="button" onclick="auto_insert_call_monthly()">이번달</button>
                </div>
            </div>
            <!--근무시간-->
            <div class="tr">
                <div class="td-label">시간</div>
                <div class="tr tr-body">
                    <div class="td td-70" id="">
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
                    <div class="td td-30">
                        <button type="button" class="timeSelect" id="morningBtn">오전</button>
                        <button type="button" class="timeSelect" id="afternoonBtn">오후</button>
                        <button type="button" class="timeSelect" id="allDayBtn">종일</button>
                    </div>
                </div>
                <div class="tr-title">
                    <div class="td">
                        <h1 id="salaryInfo">근무시간을 선택해주세요</h1>
                    </div>
                </div>
            </div>
            <!--업종-->
            <div class="tr">
                <div class="td-label">업종</div>
                <div class="td">
                    <button type="button" id="dish">설거지</button>
                    <button type="button" id="kitchen">주방보조</button>
                    <button type="button" id="hall">홀서빙</button>
                    <select name="workField" id="workField" form="callForm" required>
                      <?php foreach ($this->workField_List as $key => $data): ?>
                          <option value="<?php echo $data['workField']; ?>">
                            <?php echo $data['workField'] ?>
                          </option>
                      <?php endforeach ?>
                    </select>
                </div>
            </div>

            <!--월급-->
            <div class="tr monthly" style="display: none;">
                <div class="td-label">월급</div>
                <div class="td">
                    <input type="number" name="monthlySalary" id="monthlySalary">
                </div>
                <div class="td-label">수수료 비율</div>
                <div class="td">
                    <input type="number" name="percentage" id="percentage">
                </div>
                <div class="td-label">수수료</div>
                <div class="td">
                    <input type="number" name="commission" id="commission">
                </div>
            </div>

            <!--기타 요청 사항-->
            <div class="tr">
                <div class="td-label">기타요청사항</div>
                <div class="tr tr-body">
                    <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
                </div>
            </div>
            <!--콜 보내기 버튼-->
            <div class="tr al_r full_width">
                <h1 class="callPrice"></h1>
                <button id="submitBtn" class="btn btn-insert callBtn" type="button">콜 보내기</button>
                <button id="submitFixedCallBtn" class="btn btn-insert callBtn fixBtn" type="button">고정 콜 만들기</button>
                <button id="submitMonthlyCallBtn" class="btn btn-insert callBtn fixBtn" type="button">월급제 만들기</button>
            </div>
    </form>
</div>
<script src="/public/js/ceo.js"></script>
<script src="/public/js/fix.js"></script>
<script>
    $(document).ready(function () {
        $('#workField').val('주방보조');
        startHour.val('10');
        endHour.val('15');
        initiate(endHour.val() - startHour.val());
        $('.callBtn').hide();
        $('#submitBtn').show();
    });
    $('#percentage').on('input', function () {
        $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
        $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
    });
    $('#monthlySalary').on('input', function () {
        $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
        $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
    });
</script>