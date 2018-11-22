<div class="board_write auto-center">
    <div class="form-style-1">
        <button class="btn">고정</button> | <button class="btn">월급제</button>

        <form id="fixForm" action="" method="post">
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
                            <input type="number" required>
                        </div>
                    </div>

                    <div class="tr workTime">
                        <div class="td-label">근무시간</div>
                        <div class="td" style="width: auto;">
                            <input type="hidden" id="startTime" name="startTime">
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
                            <strong style="font-size: 30px;">~</strong>

                            <input type="hidden" id="endTime" name="endTime">
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
                            <textarea class="textarea-detail" name="detail" style="height: 50px; resize: none;">test</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="btn_group">
                    <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
                    <input id="submitBtn" class="btn btn-submit" type="submit" value="등록">
                </div>
                
        </form>
    </div>
</div>

<div class="board_list scroll_list right auto-center" style="overflow: hidden">
  <?php if (in_array($this->param->page_type, ['company', 'employee'])): ?>
      <h1>콜 내역</h1>
  <?php endif; ?>
  <?php require_once 'datepicker.php' ?>
  <?php $type = 'fix'; require 'callTable.php' ?>
</div>

<?php require_once 'call_modal.php' ?>
<?php require_once 'call_js.php' ?>

<script>
    let startHour = $('#startHour');
    let endHour = $('#endHour');
    let minute = $('.minute');
    let submit = $('#submitBtn');

    $(document).ready(function () {
        startHour.val('10');
        endHour.val('15');
    });
    
    minute.on('change', function () {
        minute.val($(this).val());
    });

    submit.on('click', function () {
        $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
        $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
    });

    startHour.on('change', function () {
        let starth = parseInt(startHour.val());
        endHour.val(starth + 5);
        for (let i = 0; i < 50; i++) {
            if ((i < starth + 4) || (i > starth + 11)) {
                $('.endOption').eq(i).css('display', 'none');
            }
            else {
                $('.endOption').eq(i).css('display', 'block');
            }
        }
        calculate(endHour.val() - startHour.val());
    });
    endHour.on('change', function () {
        calculate(endHour.val() - startHour.val())
    })
</script>