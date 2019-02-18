<?php
  $chargedCondition = " (`price` > 0) ";
  $freeCondition = " (`price` = 0) ";
  $pointCondition = " (`point` > 0) ";
  $unfixedCondition = " (`fixID` = 0) ";
  $fixedCondition = " (`fixID` > 0) ";
  $monthlyCondition = " (`fixID` > 0 AND `salary` = 0) ";
  
  $year = ($_POST['year']) ? $_POST['year'] : date('Y', strtotime(_TODAY));
  
  if ($_POST['month']) {
    $month = $_POST['month'];
  } else {
    if ($_POST['year']) {
      $month = 1;
    } else {
      $month = date('m', strtotime(_TODAY));
    }
  }
  
  if ($_POST['date']) {
    $set_date_picker = date('y-m-d', strtotime($_POST['date']));
  } elseif ($_POST['year'] || $_POST['month']) {
    $set_date_picker = date('y-m-d', strtotime("{$year}-{$month}-01"));
  } else {
    $set_date_picker = date('y-m-d', strtotime(_TODAY));
  }


?>
<div class="inline" style="width: 15%; height: 100%;">
    <div class="datepicker" id="datepicker"></div>
    <form action="" id="toggleForm" method="post">
        <input type="hidden" name="action" id="formAction">
        <input type="hidden" name="date" id="toggleDate">
        <input type="hidden" name="year" id="formYear">
      <?php if ($this->param->action == 'available_date'): ?>
          <input type="hidden" name="table" id="" value="employee_available_date">
      <?php endif; ?>
        <table>
            <!--기간에 따른 필터링-->
            <tr>
                <td>
                    <label class="form-switch duration year">
                        <b>올해</b>
                        <input type="radio" name="year" value="<?php echo date('Y', strtotime(_TODAY)); ?>"
                               id="form-input-year" <?php echo ($_POST['year'] && !$_POST['date'] && !$_POST['week']) ? 'checked' : null ?>>
                        <i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch duration month">
                        <b>이번달</b>
                        <input type="radio" name="month" value="<?php echo date('n', strtotime(_TODAY)); ?>"
                               id="form-input-month" <?php echo ($_POST['month'] && !$_POST['date'] && !$_POST['week']) ? 'checked' : null ?>>
                        <i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch duration week">
                        <b>이번주</b>
                        <input type="radio" name="week" value="week" id="form-input-week" <?php echo ($_POST['week']) ? 'checked' : null ?>>
                        <i></i>
                    </label>
                </td>
            </tr>
            <!--가능일 유형에 따른 필터링-->
          <?php if ($this->param->action == 'available_date'): ?>
              <tr>
                  <td><label class="form-switch">가능<br><input type="checkbox"><i></i></label></td>
                  <td><label class="form-switch">불가능<br><input type="checkbox"><i></i></label></td>
              </tr>
          <?php else: ?>
              <!--콜 유형에 따른 필터링-->
              <tr>
                  <td>
                      <label class="form-switch">
                          <b>유료</b>
                          <input type="checkbox" checked><i id="charged"></i>
                      </label>
                  </td>
                  <td>
                      <label class="form-switch">
                          <b>무료</b>
                          <input type="checkbox" checked><i id="free"></i>
                      </label>
                  </td>
                  <td>
                      <label class="form-switch">
                          <b>포인트</b>
                          <input type="checkbox" checked><i id="point"></i>
                      </label>
                  </td>
              </tr>
              <!--고정 유무에 따른 필터링-->
              <tr>
                  <td>
                      <label class="form-switch">
                          <b>일반</b>
                          <input type="checkbox" checked><i id="normal"></i>
                      </label>
                  </td>
                  <td><label class="form-switch">
                          <b>고정</b>
                          <input type="checkbox" checked><i id="fixed"></i>
                      </label>
                  </td>
                  <td><label class="form-switch">
                          <b>월급</b>
                          <input type="checkbox" checked><i id="salary"></i>
                      </label>
                  </td>
              </tr>
              <tr>
                  <td colspan="4">
                      <strong class="assign-percentage"></strong><br>
                      <strong class="callStatus"></strong>
                  </td>
              </tr>
              <tr>
                  <td colspan="4">
                      <strong class="paid-percentage"></strong><br>
                      <strong class="paid_count_status"></strong><br>
                      <strong class="paid_price_status"></strong>
                  </td>
              </tr>
          <?php endif; ?>
        </table>
    </form>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    $(document).ready(function () {
        set_date_picker();
        click_duration();
        switch_click();
        calculate_assign();
        calculate_price();
    });

    function set_date_picker() {
        $.datepicker.setDefaults({
            dateFormat: 'yy-mm-dd',
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true,
            yearSuffix: '년'
        });
        $("#datepicker").datepicker(
            {
                changeMonth: true,
                changeYear: true,
                onSelect: function () {
                    let date = dateFormat($(this).datepicker('getDate'));
                    $('#toggleDate').val(date);
                    $('#toggleForm').submit();
                },
                onChangeMonthYear: function (year, month, inst) {
                    let now_year = new Date().getFullYear();
                    let now_month = new Date().getMonth() + 1;
                    let year_text = $('.form-switch.duration.year b');
                    let month_text = $('.form-switch.duration.month b');
                    year_text.text(year + '년');
                    month_text.text(month + '월');
                    if (year === now_year) year_text.text('올해');
                    if (month === now_month) month_text.text('이번달');
                    $('#form-input-year').val(year);
                    $('#form-input-month').val(month);
                    
                    if(<?php echo $year?> === year){
                        console.log('year fit');
                        $('#form-input-year').prop('checked',true);
                    }
                    else{
                        console.log(<?php echo $year?>);
                        console.log(year);
                        $('#form-input-year').prop('checked',false);
                    }
                    if(<?php echo $month?> === month){
                        console.log('month fit');
                        $('#form-input-month').prop('checked',true);
                    }
                    else{
                        $('#form-input-month').prop('checked',false);
                    }
                }
            }
        );
        $("#datepicker").datepicker('setDate',
            '<?php echo $set_date_picker ?>'
        );
    }

    function switch_click() {
        $('.form-switch i').on('mouseup', function () {
            setTimeout(toggle_filter($(this)), 100);
            setTimeout(calculate_assign, 100);
            setTimeout(calculate_price, 100);
        });
    }

    function click_duration() {
        $('.form-switch.duration.year').on('click', function () {
            $('#toggleDate').val(null);
            $('#form-input-week').prop('checked',false);
            $('#toggleForm').submit();
        });
        $('.form-switch.duration.month').on('click', function () {
            $('#toggleDate').val(null);
            $('#form-input-week').prop('checked',false);
            $('#formYear').val($('#form-input-year').val());
            $('#toggleForm').submit();
        });
        $('.form-switch.duration.week').on('click', function () {
            $('#toggleDate').val(null);
            $('#toggleForm').submit();
        });
    }

    function toggle_filter(element) {
        let id = element.attr('id');
        let status = element.parent().find('input[type=checkbox]').prop('checked');
        let rows = $('.callRow');
        if(status){
            rows.each(function () {
                if($(this).hasClass(id)){
                    $(this).hide();
                }
            });
        }
        else{
            rows.each(function () {
                if($(this).hasClass(id)){
                    $(this).show();
                }
            });
        }
    }

    function calculate_assign() {
        let total = $('.callRow:visible').length - $('.callRow:visible.cancelled').length;
        let assigned = $('.callRow:visible .assignedEmployee a').length;
        let not_assigned = total - assigned;
        let percentage = parseFloat((assigned * 100 / total).toFixed(1));
        if (total > 0) {
            $('.assign-percentage').text("배정률 : " + percentage + "%");
            $('.callStatus').text("총 " + total + " (배정 " + assigned + " / 미배정 " + not_assigned + ")");
        }
        else {
            $('.assign-percentage').text("콜이 없습니다.");
            $('.callStatus').text("-");
        }
    }

    function calculate_price() {
        let paid = 0;
        let paid_price = 0;
        let unpaid = 0;
        let unpaid_price = 0;
        let get_money_btn = $('.callRow:visible .btn-money');
        let paid_money_btn = $('.paid:visible');
        paid_money_btn.each(function () {
            paid += 1;
            paid_price += parseInt($(this).text());
        });
        get_money_btn.each(function () {
            unpaid += 1;
            unpaid_price += parseInt($(this).text());
        });
        let total = paid + unpaid;
        let total_price = paid_price + unpaid_price;
        let percentage = parseFloat((paid_price * 100 / total_price).toFixed(1));
        if (total > 0) {
            $('.paid-percentage').text("수금률 : " + percentage + "%");
            $('.paid_count_status').text("총 " + total + " (수금 " + paid + " / 미수 " + unpaid + ")");
            $('.paid_price_status').text("수금: " + number_format(paid_price * 1000) + "원 / 미수금: " + number_format(unpaid_price * 1000) + "원");
        }
        else {
            $('.paid-percentage').text("콜이 없습니다.");
            $('.paid_count_status').text("-");
            $('.paid_price_status').text("-");
        }

    }
</script>