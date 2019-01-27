<?php
  $thisYearCondition    = "(YEAR(workDate) = YEAR(CURDATE()))";
  $thisMonthCondition   = "(YEAR(workDate) = YEAR(CURDATE()) AND MONTH(workDate) = MONTH(CURDATE()))";
  $thisWeekCondition    = "(YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 ))";
  
  $chargedCondition     = "(`price` > 0)";
  $freeCondition        = "(`price` = 0)";
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
                <td><label class="form-switch duration">올해<br><input type="radio" name="duration[]" value="<?php echo $thisYearCondition ?>" id="form-input-year"><i class="isolated"></i></label></td>
                <td><label class="form-switch duration">이번달<br><input type="radio" name="duration[]" value="<?php echo $thisMonthCondition ?>" id="form-input-month"><i class="isolated"></i></label></td>
                <td><label class="form-switch duration">이번주<br><input type="radio" name="duration[]" value="<?php echo $thisWeekCondition ?>"><i class="isolated"></i></label></td>
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
    $('.form-switch i').on('mouseup', function () {
        
        if($(this).closest('td').find('label').hasClass('duration')){
            $('.ui-state-default.ui-state-active').removeClass('ui-state-active');
            $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val(null);
        }
        setTimeout(toggle_filter,100);
    });
    
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            let date = dateFormat($(this).datepicker('getDate'));
            toggle_filter(date);
            $('#toggleForm input').prop('checked',false);
        },
        onChangeMonthYear: function (year, month, inst) {
            $('.form-label.month').text(month + '월');
            $('#form-input-month').val("( (YEAR(workDate) = '" + year + "') AND (MONTH(workDate) = '" + month + "') )");
            toggle_filter();
            $('#toggleForm input').prop('checked',false);
        }
    });
    function toggle_filter() {
        let date = $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val();
        if (pageAction === 'available_date') {
            $('#formAction').val('availableFilter');
            $.ajax({
                type: "POST",
                method: "POST",
                url: ajaxURL,
                data: $('#toggleForm').serialize(),
                dataType: "text",
                success: function (data) {
                    let array = JSON.parse(data).list;
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
            if(date){
                $('#toggleDate').val(date);
            }
            else{
                $('#toggleDate').val(null);
            }
            $('#formAction').val('toggleFilter');
            $('#toggleDate').val(date);
            $.ajax({
                type: "POST",
                method: "POST",
                url: ajaxURL,
                data: $('#toggleForm').serialize(),
                dataType: "text",
                success: function (data) {
                    let sql = JSON.parse(data).sql;
                    let post = JSON.parse(data).post;
                    let array = JSON.parse(data).arr;
                    let test = JSON.parse(data).test;
                    let rows = $('.callRow');
                    rows.each(function () {
                        if (array !== null) {
                            if (array.indexOf(parseInt(this.id)) >= 0) {
                                $(this).show();
                            }
                            else {
                                $(this).hide();
                            }
                        }
                    });
                    let getMoneyBtn = $('.callRow:visible .btn-money');
                    let totalPrice = 0;
                    getMoneyBtn.each(function () {
                        totalPrice += parseInt($(this).text());
                    });
                    let totalCallNum = $('.callRow:visible').length - $('.callRow:visible.cancelled').length;
                    let assignedNum = $('.callRow:visible .assignedEmployee a').length;
                    let notAssignedNum = totalCallNum - assignedNum;
                    $('.callStatus').text("총 " + totalCallNum + " (배정 " + assignedNum + " / 미배정 " + notAssignedNum+")");
                }
            });
        }
    }
</script>