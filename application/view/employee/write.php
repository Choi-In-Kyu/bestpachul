<div class="board_view auto-center">
    <h1>
      <?php
        if (isset ($this->employeeData)) echo "인력정보 - " . $this->employeeData['employeeName'] . "(" . $this->employeeData['actCondition'] . ")";
        else echo "인력 정보";
      ?>
    </h1>
    <div class="form-style-2">
        <form id="employee_form" action="" method="post" enctype=''>
            <fieldset>
                <input type="hidden" name="action" value="<?php echo $this->action ?>">
                <input type="hidden" name="employee-employeeID" value="<?php echo $this->employeeData['employeeID'] ?>">
                <div class="table">
                    <div class="tr">
                        <div class="td-label">인력명</div>
                        <div class="td">
                            <input type="text" name="employee-employeeName" size="20" required autofocus
                                   value="<?php echo $this->employeeData['employeeName']; ?>">
                        </div>
                        <div class="td-label">성별</div>
                        <div class="td">
                            <input type="text" list="sexList" name="employee-sex" size="2" required autofocus
                                   value="<?php if (isset ($this->employeeData['sex'])) {
                                     echo $this->employeeData['sex'];
                                   } else echo "여" ?>">
                            <datalist id="sexList" class="input-field">
                                <option value="여"></option>
                                <option value="남"></option>
                            </datalist>
                        </div>
                        <div class="td-label">생일</div>
                        <div class="td">
                            <input type="date" name="employee-birthDate" size="20" required autofocus
                                   value="<?php echo $this->employeeData['birthDate']; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">업종1</div>
                        <div class="td">
                            <input type="text" list="workFieldList" name="employee-workField1" size="20"
                                   value="<?php echo $this->employeeData['workField1']; ?>">
                            <datalist id="workFieldList" class="input-field">
                              <?php foreach ($this->workFieldList as $key => $data): ?>
                                  <option value="<?php echo $data['workField'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">업종2</div>
                        <div class="td">
                            <input type="text" list="workFieldList" name="employee-workField2" size="20"
                                   value="<?php echo $this->employeeData['workField2']; ?>">
                            <datalist id="workFieldList" class="input-field">
                              <?php foreach ($this->workFieldList as $key => $data): ?>
                                  <option value="<?php echo $data['workField'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">업종3</div>
                        <div class="td">
                            <input type="text" list="workFieldList" name="employee-workField3" size="20"
                                   value="<?php echo $this->employeeData['workField3']; ?>">
                            <datalist id="workFieldList" class="input-field">
                              <?php foreach ($this->workFieldList as $key => $data): ?>
                                  <option value="<?php echo $data['workField'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">전화번호</div>
                        <div class="td">
                            <input type="text" name="employee-employeePhoneNumber" size="20" required
                                   value="<?php echo $this->employeeData['employeePhoneNumber']; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">간단주소</div>
                        <div class="td">
                            <input type="text" list="addressList" name="employee-address"
                                   value="<?php echo $this->employeeData['address']; ?>">
                            <datalist id="addressList">
                              <?php foreach ($this->addressList as $key => $data): ?>
                                  <option value="<?php echo $data['address'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">상세주소</div>
                        <div class="td">
                            <input type="text" name="employee-detailAddress" size="20"
                                   value="<?php echo $this->employeeData['detailAddress']; ?>">
                        </div>
                        <div class="td-label">희망근무지</div>
                        <div class="td">
                            <input type="text" list="addressList" name="employee-workPlace"
                                   value="<?php echo $this->employeeData['workPlace']; ?>">
                            <datalist id="addressList">
                              <?php foreach ($this->addressList as $key => $data): ?>
                                  <option value="<?php echo $data['address'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">한국어</div>
                        <div class="td">
                            <input type="text" list="languageList" name="employee-language" size="2" required
                                   value="<?php if (isset($this->employeeData['language'])) echo $this->employeeData['language']; else echo "상"; ?>">
                            <datalist id="languageList" class="input-field">
                                <option value="상"></option>
                                <option value="중"></option>
                                <option value="하"></option>
                            </datalist>
                        </div>
                        <div class="td-label">점수</div>
                        <div class="td">
                            <input type="text" name="employee-grade" size="20" required
                                   value="<?php if (isset($this->employeeData['grade'])) echo $this->employeeData['grade']; else echo "100"; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">비고</div>
                        <div class="td-detail">
                            <textarea class="textarea-detail"
                                      name="employee-detail"><?php echo $this->get_detail($this->employeeData,'employee'); ?></textarea>
                        </div>
                      <?php if ($this->employeeData['actCondition'] == "삭제됨") : ?>
                          <div class="td-detail">
                              삭제비고
                              <textarea
                                      name="employee-deleteDetail"><?php echo $this->employeeData['deleteDetail']; ?></textarea>
                          </div>
                      <?php endif; ?>
                    </div>
                    <div class="tr">
                        <table>
                            <tr>
                                <th></th>
                                <th>월</th>
                                <th>화</th>
                                <th>수</th>
                                <th>목</th>
                                <th>금</th>
                                <th>토</th>
                                <th>일</th>
                            </tr>
                            <tr>
                                <th>오전</th>
                                <td><input class="bn mon" type="checkbox" name="employee_available_day-mon" value="오전"
                                    <?php echo $this->getDay('mon', '오전') ?> ></td>
                                <td><input class="bn tue" type="checkbox" name="employee_available_day-tue" value="오전"
                                    <?php echo $this->getDay('tue', '오전') ?> ></td>
                                <td><input class="bn wed" type="checkbox" name="employee_available_day-wed" value="오전"
                                    <?php echo $this->getDay('wed', '오전') ?> ></td>
                                <td><input class="bn thu" type="checkbox" name="employee_available_day-thu" value="오전"
                                    <?php echo $this->getDay('thu', '오전') ?> ></td>
                                <td><input class="bn fri" type="checkbox" name="employee_available_day-fri" value="오전"
                                    <?php echo $this->getDay('fri', '오전') ?> ></td>
                                <td><input class="bn sat" type="checkbox" name="employee_available_day-sat" value="오전"
                                    <?php echo $this->getDay('sat', '오전') ?> ></td>
                                <td><input class="bn sun" type="checkbox" name="employee_available_day-sun" value="오전"
                                    <?php echo $this->getDay('sun', '오전') ?> ></td>
                            </tr>
                            <tr>
                                <th>오후</th>
                                <td><input class="an mon" type="checkbox" name="employee_available_day-mon" value="오후"
                                    <?php echo $this->getDay('mon', '오후') ?> ></td>
                                <td><input class="an tue" type="checkbox" name="employee_available_day-tue" value="오후"
                                    <?php echo $this->getDay('tue', '오후') ?> ></td>
                                <td><input class="an wed" type="checkbox" name="employee_available_day-wed" value="오후"
                                    <?php echo $this->getDay('wed', '오후') ?> ></td>
                                <td><input class="an thu" type="checkbox" name="employee_available_day-thu" value="오후"
                                    <?php echo $this->getDay('thu', '오후') ?> ></td>
                                <td><input class="an fri" type="checkbox" name="employee_available_day-fri" value="오후"
                                    <?php echo $this->getDay('fri', '오후') ?> ></td>
                                <td><input class="an sat" type="checkbox" name="employee_available_day-sat" value="오후"
                                    <?php echo $this->getDay('sat', '오후') ?> ></td>
                                <td><input class="an sun" type="checkbox" name="employee_available_day-sun" value="오후"
                                    <?php echo $this->getDay('sun', '오후') ?> ></td>
                            </tr>
                            <tr>
                                <th>종일</th>
                                <td><input class="ad mon" type="checkbox" name="employee_available_day-mon" value="종일"
                                    <?php echo $this->getDay('mon', '종일') ?> >
                                </td>
                                <td><input class="ad tue" type="checkbox" name="employee_available_day-tue" value="종일"
                                    <?php echo $this->getDay('tue', '종일') ?> >
                                </td>
                                <td><input class="ad wed" type="checkbox" name="employee_available_day-wed" value="종일"
                                    <?php echo $this->getDay('wed', '종일') ?> >
                                </td>
                                <td><input class="ad thu" type="checkbox" name="employee_available_day-thu" value="종일"
                                    <?php echo $this->getDay('thu', '종일') ?> >
                                </td>
                                <td><input class="ad fri" type="checkbox" name="employee_available_day-fri" value="종일"
                                    <?php echo $this->getDay('fri', '종일') ?> >
                                </td>
                                <td><input class="ad sat" type="checkbox" name="employee_available_day-sat" value="종일"
                                    <?php echo $this->getDay('sat', '종일') ?> >
                                </td>
                                <td><input class="ad sun" type="checkbox" name="employee_available_day-sun" value="종일"
                                    <?php echo $this->getDay('sun', '종일') ?> >
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
              
              <?php if (!isset($this->param->idx)) : ?>
                  <br/>
                  <h1>가입 정보</h1>
                  <table id="table_join_gujwa">
                      <tr>
                          <td>가입시작일</td>
                          <td><input type="date" id="startDate" name="join_employee-startDate" required></td>
                          <td>가입만기일</td>
                          <td><input type="date" id="endDate" name="join_employee-endDate" required></td>
                          <td>
                              <button type="button" class="btn btn-insert" onclick="auto_insert()">자동 입력
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

                <div class="btn_group">
                    <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
                    <button class="btn btn-submit" type="submit"><?php echo $submitButtonName ?></button>
                </div>
            </fieldset>
        </form>
    </div>

</div>

<script>
    function auto_insert() {
        $('#startDate').val('<?php echo date("Y-m-d")?>');
        $('#endDate').val('<?php echo date("Y-m-d", strtotime("+1 month -1 day"));?>');
        $('#price').val(50000);
        document.getElementById('paid').checked = true;
    }
</script>