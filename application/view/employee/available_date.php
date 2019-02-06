<?php
  $query = "SELECT * FROM `employee_available_date`";
  if (!$_POST['type'] || $_POST['type'] == 'all') {
    $selected_option['all'] = 'selected';
  } else {
    $selected_option[$_POST['type']] = 'selected';
    $query .= " WHERE `{$_POST['type']}Date` IS NOT NULL";
  }
  $available_date_list = $this->model->getTable($query);
?>


<style>
    form {
        display: inline;
    }
</style>

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
                            <input type="text" list="employeeList" name="employeeName" required>
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
                            <input type="date" name="availableDate" required>
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

    <!--블랙리스트 필터 폼-->
    <div class="btn-group" style="display: inline;height: 150px;">
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="type" value="all">
            <input type="submit" class="btn btn-option <?php echo $selected_option['all'] ?>" value="전체"
                   style="height: 100%;">
        </form>
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="type" value="available">
            <input type="submit" class="btn btn-option <?php echo $selected_option['available'] ?>" value="근무가능일"
                   style="height: 100%;">
        </form>
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="type" value="notAvailable">
            <input type="submit" class="btn btn-option <?php echo $selected_option['notAvailable'] ?>" value="근무불가능일"
                   style="height: 100%;">
        </form>
    </div>

    <div class="al_c">
      <?php $table = 'employee_available_date' ?>
        <div class="inline" style="height: 100%; max-width: 255px">
            <div class="datepicker" id="datepicker"></div>
            <form action="" id="toggleForm" method="post">
                <input type="hidden" name="action" id="formAction">
                <input type="hidden" name="date" id="toggleDate">
                <input type="hidden" name="table" id="" value="employee_available_date">
                <table>
                    <!--기간에 따른 필터링-->
                    <tr>
                        <td><label class="form-switch duration">올해<br><input type="radio" name="duration"
                                                                             value="year"
                                                                             id="form-input-year"><i
                                        class="isolated"></i></label></td>
                        <td><label class="form-switch duration">이번달<br><input type="radio" name="duration"
                                                                              value="month"
                                                                              id="form-input-month"><i
                                        class="isolated"></i></label></td>
                        <td><label class="form-switch duration">이번주<br><input type="radio" name="duration"
                                                                              value="week"><i
                                        class="isolated"></i></label></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="inline  call" style="width: calc(100% - 260px);">
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
                <?php foreach ($available_date_list as $key => $data): ?>
                    <tr class="availableRow" id="<?php echo $data['availableDateID'] ?>">
                        <td class="al_c"><?php echo $data['availableDateID'] ?></td>
                      <?php $employeeName = $this->model->select('employee', "employeeID = $data[employeeID]", 'employeeName'); ?>
                        <td class="al_c"><?php echo $employeeName ?></td>
                        <td class="al_c"><?php echo ($data['availableDate']) ? $data['availableDate'] : '-' ?></td>
                        <td class="al_c"><?php echo ($data['notAvailableDate']) ? $data['notAvailableDate'] : '-' ?></td>
                        <td class="al_c"><?php echo $data['detail'] ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    let available = $('input[name=availableDate]');
    let notAvailable = $('input[name=notAvailableDate]');
    available.on('input', function () {
        notAvailable.prop('disabled', 'true');
    });
    notAvailable.on('input', function () {
        available.prop('disabled', 'true');
    });
    $('input[name=employeeName]').on('input', function () {
        console.log('test');
        set_validity($(this), 'employee');
    });
    $('.btn-submit').on('click', function () {
        if (available.val() || notAvailable.val()) {
            available.prop('required', false);
        }
        else{
            available.prop('required', true);
        }
    });
    $('.form-switch i').on('mouseup', function () {
        if ($(this).closest('td').find('label').hasClass('duration')) {
            $('.ui-state-default.ui-state-active').removeClass('ui-state-active');
            $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val(null);
        }
        setTimeout(toggle_filter, 100);
    });
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            let date = dateFormat($(this).datepicker('getDate'));
            toggle_filter(date);
            $('#toggleForm input').prop('checked', false);
        },
        onChangeMonthYear: function (year, month, inst) {
            $('.form-label.month').text(month + '월');
            $('#form-input-month').val("( (YEAR(workDate) = '" + year + "') AND (MONTH(workDate) = '" + month + "') )");
            toggle_filter();
            $('#toggleForm input').prop('checked', false);
        }
    });

    function toggle_filter() {
        let date = $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val();
        if (date) {
            $('#toggleDate').val(date);
        }
        else {
            $('#toggleDate').val(null);
        }
        $('#formAction').val('availableFilter');

        $.ajax({
            type: "POST",
            method: "POST",
            url: ajaxURL,
            data: $('#toggleForm').serialize(),
            dataType: "text",
            success: function (data) {
                let sql = JSON.parse(data).sql;
                console.log(sql);
                let array = JSON.parse(data).arr;
                let rows = $('.availableRow');
                rows.each(function () {
                    if (array !== null) {
                        if (array.indexOf(parseInt(this.id)) >= 0) {
                            $(this).show();
                        }
                        else {
                            $(this).hide();
                        }
                    }
                    else {
                        $(this).hide();
                    }
                });
            }
        });
    }
</script>