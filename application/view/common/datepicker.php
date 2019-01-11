<?php
  $thisYearCondition = "(YEAR(workDate) = YEAR(CURDATE()))";
  $thisMonthCondition = "(YEAR(workDate) = YEAR(CURDATE()) AND MONTH(workDate) = MONTH(CURDATE()))";
  $thisWeekCondition = "(YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 ))";
  
  $chargedCondition = "(`price` > 0)";
  $freeCondition = "(`price` = 0)";
  $pointCondition = "(`point` > 0)";
  $unfixedCondition = "(`fixID` = 0)";
  $fixedCondition = "(`fixID` > 0)";;
  $monthlyCondition = "(`fixID` > 0 AND `salary` = 0)"
?>
<div class="inline" style="width: 15%; height: 100%;">
    <div class="datepicker" id="datepicker"></div>
    <form action="" id="toggleForm" method="post">
        <input type="hidden" name="action" id="formAction">
        <input type="hidden" name="date" id="toggleDate">
      <?php if ($this->param->action == 'available_date'): ?>
          <input type="hidden" name="table" id="" value="employee_available_date">
      <?php endif; ?>
        <table>
            <!--기간에 따른 필터링-->
            <tr>
                <td><label class="form-switch p-1">올해<br><input type="checkbox" name="duration[]" value="<?php echo $thisYearCondition ?>"><i></i></label></td>
<!--                <td><label class="form-label month">올해</label><label class="form-switch month"><input id="form-input-month" type="checkbox" name="duration[]" value="--><?php //echo $thisYearCondition ?><!--"><i></i></label></td>-->
                <td><label class="form-label month">이번달</label><label class="form-switch month"><input id="form-input-month" type="checkbox" name="duration[]" value="<?php echo $thisMonthCondition ?>"><i></i></label></td>
                <td><label class="form-switch ">이번주<br><input type="checkbox" name="duration[]" value="<?php echo $thisWeekCondition ?>"><i></i></label></td>
            </tr>
          <?php if ($this->param->action == 'available_date'): ?>
              <!--유형에 따른 필터링-->
              <tr>
                  <td><label class="form-switch">가능<br><input type="checkbox"><i></i></label></td>
                  <td><label class="form-switch">불가능<br><input type="checkbox"><i></i></label></td>
              </tr>
          <?php else: ?>
              <!--콜 유형에 따른 필터링-->
              <tr>
                  <td><label class="form-switch">유료<br><input type="checkbox" name="charged[]" value="<?php echo $chargedCondition ?>"><i></i></label></td>
                  <td><label class="form-switch">무료<br><input type="checkbox" name="charged[]" value="<?php echo $freeCondition ?>"><i></i></label></td>
                  <td><label class="form-switch">포인트<br><input type="checkbox" name="charged[]" value="<?php echo $pointCondition ?>"><i></i></label></td>
              </tr>
              <!--고정 유무에 따른 필터링-->
              <tr>
                  <td><label class="form-switch">일반<br><input type="checkbox" name="fixed[]" value="<?php echo $unfixedCondition ?>"><i></i></label></td>
                  <td><label class="form-switch">고정<br><input type="checkbox" name="fixed[]" value="<?php echo $fixedCondition ?>"><i></i></label></td>
                  <td><label class="form-switch">월급<br><input type="checkbox" name="fixed[]" value="<?php echo $monthlyCondition ?>"><i></i></label></td>
              </tr>
              <tr>
                  <td colspan="4"><strong class="callStatus"></strong></td>
              </tr>
          <?php endif; ?>
        </table>
    </form>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    $('.form-switch').on('click', function () {
        console.log('click');
        let activeDate = $(document).find('.ui-state-active');
        activeDate.removeClass('ui-state-active');
        $('#toggleDate').val(null);
        // if ($(this).hasClass('all')) {
        //     if ($('input', this).is(':checked')) {
        //         $(this).closest('tr').find('.form-switch input').prop('checked', false);
        //     }
        //     else {
        //         $(this).closest('tr').find('.form-switch input').prop('checked', true);
        //     }
        // }
        // else {
            let all = $(this).closest('tr').find('.all input');
            if (all.is(':checked')) all.prop('checked', false);
            if ($(this).hasClass('month')) {
                $(this).closest('tr').find('.form-switch.week').click();
            }
        // }
        toggle_filter();
    });
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            toggle_filter();
        },
        onChangeMonthYear: function (year, month, inst) {
            $('.form-label.month').text(month + '월');
            $('#form-input-month').val("( (YEAR(workDate) = '" + year + "') AND (MONTH(workDate) = '" + month + "') )");
            toggle_filter();
        }
    });
    function toggle_filter() {
        console.log('toggle');
        if (pageAction === 'available_date') {
            $('#formAction').val('availableFilter');
            let date = $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val();
            $('#toggleDate').val(date);
            $.ajax({
                type: "POST",
                method: "POST",
                url: ajaxURL,
                data: $('#toggleForm').serialize(),
                dataType: "text",
                success: function (data) {
                    let array = JSON.parse(data).list;
                    let sql = JSON.parse(data).sql;

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
                            rows.hide();
                        }
                    });
                }
            });
        }
        else {
            $('#formAction').val('toggleFilter');
            $.ajax({
                type: "POST",
                method: "POST",
                url: ajaxURL,
                data: $('#toggleForm').serialize(),
                dataType: "text",
                success: function (data) {
                    console.log('success');
                    let sql = JSON.parse(data).sql;
                    let array = JSON.parse(data).arr;
                    console.log(sql);
                    // console.log(array);
                    
                    //let rows = $('.callRow');
                    // rows.each(function () {
                    //     if (array !== null) {
                    //         if (array.indexOf(parseInt(this.id)) > 0) {
                    //             $(this).show();
                    //         }
                    //         else {
                    //             $(this).hide();
                    //         }
                    //     }
                    // });
                    // let getMoneyBtn = $('.callRow:visible .btn-money');
                    // let totalPrice = 0;
                    // getMoneyBtn.each(function () {
                    //     totalPrice += parseInt($(this).text());
                    // });
                    // let totalCallNum = $('.callRow:visible').length - $('.callRow:visible.cancelled').length;
                    // let assignedNum = $('.callRow:visible .assignedEmployee a').length;
                    // let notAssignedNum = totalCallNum - assignedNum;
                    // $('.callStatus').text("총 : " + totalCallNum + " / 배정 : " + assignedNum + " / 미배정 : " + notAssignedNum);
                }
            });
        }
    }
</script>