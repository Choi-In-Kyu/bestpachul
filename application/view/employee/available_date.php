<div class="board-write auto-center">
    <div class="title-table">
        <h1 class="title-main">
            근무 가능일 / 근무 불가능일
        </h1>
    </div>
    <div class="form-default">
        <form id="employee_form" action="" method="post">
            <fieldset>
                <input type="hidden" name="action" value="insert_day">
                <input type="hidden" name="employeeID" value="<?php echo $this->employeeData['employeeID'] ?>">
                <div class="table">
                    <div class="tr">
                        <div class="td">
                            <label for="">인력명</label>
                            <input type="text" list="employeeList" name="employeeName">
                            <datalist id="employeeList" class="input-field">
                              <?php foreach ($this->employee_List as $key => $data): ?>
                                  <option value="<?php echo $data['employeeName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            <label for="">되는날</label>
                            <input type="date" name="availableDate">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            <label for="">안되는날</label>
                            <input type="date" name="notAvailableDate">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            <label for="">비고</label>
                            <textarea name="detail" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="btn-group al_r  ">
                <button class="btn btn-default" onclick="location.href = '<?php echo $this->param->get_page ?>'">취소
                </button>
                <button class="btn btn-submit" type="submit">추가</button>
            </div>
        </form>
    </div>

    <div class="al_c">
      <?php $table = 'employee_available_date' ?>
      <?php require_once _VIEW . '/common/datepicker.php' ?>
        <div class="inline  call" style="width: 84%;">
            <table style="width:100%;">
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
<script>
    let available = $('input[name=availableDate]');
    let notAvailable = $('input[name=notAvailableDate]');
    available.on('input', function () {
        notAvailable.prop('disabled', 'true');
    });
    notAvailable.on('input', function () {
        available.prop('disabled', 'true');
    });
</script>