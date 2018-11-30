<form action="" id="fixForm" method="post">
    <input type="hidden" name="action" id="formAction">
    <input type="hidden" name="companyID" value="--><?php //echo $this->companyID?><!--">
    <input type="hidden" name="startTime" id="startTime">
    <input type="hidden" name="endTime" id="endTime">
    <input type="hidden" name="salary" id="salary">
    <input type="hidden" name="price" id="callPrice">
    <input type="hidden" name="point" id="callPoint">
    <fieldset>
        <input type="hidden" name="action" value="fix">
        <div class="table">
            <div class="tr">
                <div class="td-label">인력명</div>
                <div class="td">
                    <input type="text" list="employeeList" name="employeeName">
                    <datalist id="employeeList" class="input-field">
                      <?php foreach ($this->employee_List as $key => $data): ?>
                          <option value="<?php echo $data['employeeName'] ?>"></option>
                      <?php endforeach ?>
                    </datalist>
                </div>
                <div class="td-label">업체명</div>
                <div class="td">
                    <input type="text" list="companyList" name="companyName">
                    <datalist id="companyList" class="input-field">
                      <?php foreach ($this->company_List as $key => $data): ?>
                          <option value="<?php echo $data['companyName'] ?>"></option>
                      <?php endforeach ?>
                    </datalist>
                </div>
            </div>
            <div class="tr">
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
            <div class="tr">
                <div class="td-label">직종</div>
                <div class="td">
                    <input type="text" list="workFieldList" name="workField" size="20">
                    <datalist id="workFieldList" class="input-field">
                      <?php foreach ($this->workField_List as $key => $data): ?>
                          <option value="<?php echo $data['workField'] ?>"></option>
                      <?php endforeach ?>
                    </datalist>
                </div>
                <div class="td-label">임금</div>
                <div class="td">
                    <input type="number">
                </div>
            </div>
            <div class="tr workTime">
                <div class="td-label">근무시간</div>
                <div class="td" style="width: auto;">
                    <input type="hidden" id="startTime" name="startTime">
                    <select class="time hour" id="startHour" form="fixForm">
                        <option value="" selected disabled hidden>근무 시작 시간</option>
                      <?php for ($i = 1; $i < 25; $i++): ?>
                          <option class="startOption" value="<?php echo $i ?>">
                            <?php echo $this->getTime($i); ?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="time minute" id="startMin" form="fixForm">
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                    <strong style="font-size: 30px;">~</strong>
                    <input type="hidden" id="endTime" name="endTime">
                    <select class="time hour" id="endHour" form="fixForm">
                        <option value="" selected disabled hidden>근무 종료 시간</option>
                      <?php for ($i = 1; $i < 37; $i++): ?>
                          <option class="endOption" value="<?php echo $i ?>">
                            <?php echo $this->getTime($i); ?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="time minute" id="endMin" form="fixForm">
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                </div>
            </div>
            <div class="tr">
                <div class="td-label">근무기간</div>
                <div class="td" style="width: 90%;">
                    <input type="date" class="datepicker" name="startDate">
                    <strong style="font-size: 30px;">~</strong>
                    <input type="date" class="datepicker" name="endDate">
                </div>
            </div>
            <div class="tr">
                <div class="td-label">비고</div>
                <div class="td-detail" style="width:60%;">
                            <textarea class="textarea-detail" name="detail"
                                      style="height: 50px; resize: none;">test</textarea>
                </div>
            </div>
        </div>
        <div class="btn_group">
            <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
            <input id="submitBtn" class="btn btn-submit" type="submit" value="등록">
        </div>
</form>