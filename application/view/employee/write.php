<div class="board_write auto-center">
    <div class="title-table">
        <h1>
          <?php
            echo "인력 정보";
            if (isset ($this->employeeData)) echo " - " . $this->employeeData['employeeName'] . "(" . $this->employeeData['actCondition'] . ")";
          ?>
        </h1>
    </div>
    <div class="form-default">
        <form id="formInsertEmployee" action="" method="post">
            <fieldset>
                <input type="hidden" name="action"
                       value="<?php echo ($this->param->action == 'write') ? 'insert' : 'update' ?>">
                <input type="hidden" name="employee-employeeID" value="<?php echo $this->employeeData['employeeID'] ?>">
                <div class="table">
                    <div class="tr">
                        <div class="td">
                            <label for="">인력명</label>
                            <input type="text" name="employee-employeeName" size="20" required autofocus
                                   value="<?php echo $this->employeeData['employeeName']; ?>">
                        </div>
                        <div class="td">
                            <label for="">성별</label>
                            <input type="text" list="sexList" name="employee-sex" size="2" required autofocus
                                   value="<?php if (isset ($this->employeeData['sex'])) {
                                     echo $this->employeeData['sex'];
                                   } else echo "여" ?>">
                            <datalist id="sexList" class="input-field">
                                <option value="여"></option>
                                <option value="남"></option>
                            </datalist>
                        </div>
                        <div class="td">
                            <label for="">생일</label>
                            <input type="date" name="employee-birthDate" size="20" autofocus
                                   value="<?php echo $this->employeeData['birthDate']; ?>">
                        </div>
                    </div>
                    <div class="duplicate" id="employeeNameDuplicate">이름을 입력 해 주세요</div>
                    <div class="tr">
                        <div class="td td-3">
                            <label for="">업종1</label>
                            <input type="text" list="workFieldList" name="employee-workField1" size="20"
                                   value="<?php echo $this->employeeData['workField1']; ?>">
                            <datalist id="workFieldList" class="input-field">
                              <?php foreach ($this->workField_List as $key => $data): ?>
                                  <option value="<?php echo $data['workField'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td td-3">
                            <label for="">업종2</label>
                            <input type="text" list="workFieldList" name="employee-workField2" size="20"
                                   value="<?php echo $this->employeeData['workField2']; ?>">
                            <datalist id="workFieldList" class="input-field">
                              <?php foreach ($this->workField_List as $key => $data): ?>
                                  <option value="<?php echo $data['workField'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td td-3">
                            <label for="">업종3</label>
                            <input type="text" list="workFieldList" name="employee-workField3" size="20"
                                   value="<?php echo $this->employeeData['workField3']; ?>">
                            <datalist id="workFieldList" class="input-field">
                              <?php foreach ($this->workField_List as $key => $data): ?>
                                  <option value="<?php echo $data['workField'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td td-3">
                            <label for="">전화번호</label>
                            <input type="text" name="employee-employeePhoneNumber" size="20" required
                                   value="<?php echo $this->employeeData['employeePhoneNumber']; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            <label for="">간단주소</label>
                            <input type="text" list="addressList" name="employee-address"
                                   value="<?php echo $this->employeeData['address']; ?>">
                            <datalist id="addressList">
                              <?php foreach ($this->address_List as $key => $data): ?>
                                  <option value="<?php echo $data['address'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td">
                            <label for="">상세주소</label>
                            <input type="text" name="employee-detailAddress" size="20"
                                   value="<?php echo $this->employeeData['detailAddress']; ?>">
                        </div>
                        <div class="td">
                            <label for="">희망근무지</label>
                            <input type="text" list="addressList" name="employee-workPlace"
                                   value="<?php echo $this->employeeData['workPlace']; ?>">
                            <datalist id="addressList">
                              <?php foreach ($this->address_List as $key => $data): ?>
                                  <option value="<?php echo $data['address'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            <label for="">한국어</label>
                            <input type="text" list="languageList" name="employee-language" size="2" required
                                   value="<?php if (isset($this->employeeData['language'])) echo $this->employeeData['language']; else echo "상"; ?>">
                            <datalist id="languageList" class="input-field">
                                <option value="상"></option>
                                <option value="중"></option>
                                <option value="하"></option>
                            </datalist>
                        </div>
                        <div class="td">
                            <label for="">점수</label>
                            <input type="text" name="employee-grade" size="20" required
                                   value="<?php if (isset($this->employeeData['grade'])) echo $this->employeeData['grade']; else echo "100"; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td td-detail">
                            <label for="">비고</label>
                            <textarea class="textarea-detail-employee"
                                      name="employee-detail"><?php echo $this->get_detail($this->employeeData, 'employee'); ?></textarea>
                        </div>
                        <div class="td td-detail">
                          <?php require_once 'employeeAvailableDayTable.php' ?>
                        </div>
                    </div>
                  
                  <?php if ($this->employeeData['actCondition'] == "삭제됨") : ?>
                      <div class="tr">
                          <div class="td td-detail">
                              <label for="">삭제비고</label>
                              <textarea
                                      name="employee-deleteDetail"><?php echo $this->employeeData['deleteDetail']; ?></textarea>
                          </div>
                      </div>
                  <?php endif; ?>
                  
                  <?php if (($this->param->action == 'view') && (sizeof($this->blackList) > 0)): ?>
                      <div class="tr">
                          <div class="td-detail">
                              <label for="">블랙</label>
                            <?php foreach ($this->blackList as $data) {
                              $type = ($data['ceoReg'] == 1) ? '오지마세요' : '안가요';
                              echo $this->companyName($data['companyID']) . " " . $type . " : " . $data['detail'] . '<br>';
                            }
                            ?>
                          </div>
                      </div>
                  <?php endif; ?>
                  <?php $availableDateArray = $this->model->getTable("SELECT * FROM `employee_available_date` WHERE `employeeID` = '{$this->employeeData['employeeID']}'"); ?>
                  <?php if (($this->param->action == 'view') && (sizeof($availableDateArray) > 0)): ?>
                      <div class="tr">
                          <div class="td-detail">
                              <label for="">근무가능일 / 불가능일</label>
                            <?php foreach ($availableDateArray as $value) {
                              if ($value['availableDate'] > 0) {
                                echo "{$value['availableDate']} 갈래요 ({$value['detail']}) <br/>";
                              } else {
                                echo "{$value['notAvailableDate']} 못가요 ({$value['detail']}) <br/>";
                              }
                            }
                            ?>
                          </div>
                      </div>
                  <?php endif; ?>
                </div>
              
              <?php if (!isset($this->param->idx)) : ?>
                  <div class="title-table">
                      <h1>가입 정보</h1>
                  </div>
                  <table id="employeeAddJoinTable">
                      <tr>
                          <td>가입시작일</td>
                          <td><input type="date" id="startDate" name="join_employee-startDate" required></td>
                          <td>가입만기일</td>
                          <td><input type="date" id="endDate" name="join_employee-endDate" required></td>
                          <td>
                              <button type="button" class="btn btn-insert" onclick="auto_insert_employee_join('today')">
                                  오늘부터
                              </button>
                          </td>
                      </tr>
                      <tr>
                          <td>가입금액</td>
                          <td><input type="number" id="price" name="join_employee-price" required></td>
                          <td>가입비고</td>
                          <td><textarea name="join_employee-detail"></textarea></td>
                          <td>
                              <input type="checkbox" id="paid" name="join_employee-paid" value="1">회비 수금 여부
                          </td>
                      </tr>
                  </table>
              <?php endif; ?>
                <div class="btn-group al_r">
                    <a class="btn btn-default" href = '<?php echo $this->param->get_page ?>'>취소</a>
                    <button class="btn btn-submit" type="submit"><?php echo ($this->param->action == 'write') ? '추가' : '수정' ?></button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    check_duplicate_employee();
    check_day_box();

    function check_duplicate_employee() {
        let nameInput = $('#formInsertEmployee input[name=employee-employeeName]');
        if (nameInput.val() === null) {
            $('#employeeNameDuplicate').html('이름을 입력 해 주세요');
        }
        else {
            nameInput.on('input', function () {
                let employeeName = $(this).val();
                $.ajax({
                    type: "POST",
                    method: "POST",
                    url: ajaxURL,
                    data: {action: 'checkDuplicate', table: 'employee', name: employeeName},
                    dataType: "text",
                    success: function (data) {
                        let show = $('#employeeNameDuplicate');
                        let list = JSON.parse(data).list;
                        let msg = JSON.parse(data).msg;
                        let match = JSON.parse(data).match;
                        let allInput = $('#formInsertEmployee input,textarea');
                        let employeeName = $('#formInsertEmployee input[name=employee-employeeName]');
                        if (list) {
                            show.html("유사 : " + list);
                            if (match) {
                                show.html("일치 : " + match);
                                allInput.prop('disabled', true);
                                employeeName.prop('disabled', false);
                            }
                            else {
                                allInput.prop('disabled', false);
                                employeeName.prop('disabled', false);
                            }
                        }
                        else {
                            show.html(msg);
                            allInput.prop('disabled', false);
                        }
                    }
                });
            });
        }
    }
    function check_day_box(){
        $('.day').on('change', function () {
            let day = $(this).attr('class').split(' ')[2];
            let ab = $(this).attr('class').split(' ')[1];
            if (this.checked) {
                if (ab === 'bn') {
                    $('.ad' + '.' + day).prop('checked', false);
                    if ($('.an' + '.' + day).is(":checked")) {
                        $("input[name=employee_available_day-" + day + "]").val("반반");
                    }
                    else {
                        $("input[name=employee_available_day-" + day + "]").val("오전");
                    }
                }
                if (ab === 'an') {
                    $('.ad' + '.' + day).prop('checked', false);
                    if ($('.bn' + '.' + day).is(":checked")) {
                        $("input[name=employee_available_day-" + day + "]").val("반반");
                    }
                    else {
                        $("input[name=employee_available_day-" + day + "]").val("오후");
                    }
                }
                if (ab === 'ad') {
                    $('.' + day).prop('checked', false);
                    $(this).prop('checked', true);
                    $("input[name=employee_available_day-" + day + "]").val("종일");
                }
            }
            else {
                if (ab === 'bn') {
                    if ($('.an' + '.' + day).is(":checked")) {
                        $("input[name=employee_available_day-" + day + "]").val("오후");
                    }
                    else {
                        $("input[name=employee_available_day-" + day + "]").val('null');
                    }
                }
                if (ab === 'an') {
                    if ($('.bn' + '.' + day).is(":checked")) {
                        $("input[name=employee_available_day-" + day + "]").val("오전");
                    }
                    else {
                        $("input[name=employee_available_day-" + day + "]").val('null');
                    }
                }
                if (ab === 'ad') {
                    $(this).prop('checked', false);
                    $("input[name=employee_available_day-" + day + "]").val("null");
                }
            }
        });
    }
</script>