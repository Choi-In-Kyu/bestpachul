<div class="board-write auto-center">
    <h1>근무 가능일 / 근무 불가능일</h1>
    <div class="form-default">
        <form id="employee_form" action="" method="post">
            <fieldset>
                <input type="hidden" name="action" value="insert_day">
                <input type="hidden" name="employeeID" value="<?php echo $this->employeeData['employeeID'] ?>">
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
                    </div>
                    <div class="tr">
                        <div class="td-label">되는날</div>
                        <input type="date" name="availableDate">
                    </div>
                    <div class="tr">
                        <div class="td-label">안되는날</div>
                        <input type="date" name="notAvailableDate">
                    </div>
                    <div class="tr">
                        <div class="td-label">비고</div>
                        <textarea name="detail" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </fieldset>
            <div class="btn-group">
                <button class="btn btn-default" onclick="location.href = '<?php echo $this->param->get_page ?>'">취소</button>
                <button class="btn btn-submit" type="submit">추가</button>
            </div>
        </form>
    </div>

    <div class="al_c">
      <?php $table = 'employee_available_date' ?>
      <?php require_once _VIEW . '/common/datepicker.php' ?>
        <div class="inline  call" style="width: 50%;">
            <table style="width:84%; display: inline">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="20%">
                    <col width="20%">
                    <col width="40%">
                </colgroup>
                <thead>
                <tr>
                    <th>#</th>
                    <th>인력명</th>
                    <th>근무가능일</th>
                    <th>근무불가능일</th>
                    <th>비고</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->employee_available_date_List as $key => $data): ?>
                    <tr class="availableRow" id="<?php echo $data['availableDateID'] ?>">
                        <td class="al_c"><?php echo $data['availableDateID'] ?></td>
                      <?php $employeeName = $this->model->select('employee', "employeeID = $data[employeeID]", 'employeeName'); ?>
                        <td class="al_c"><?php echo $employeeName ?></td>
                        <td class="al_c"><?php echo $data['availableDate'] ?></td>
                        <td class="al_c"><?php echo $data['notAvailableDate'] ?></td>
                        <td class="al_c"><?php echo $data['detail'] ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>