<div class="inline" style="width: 15%; height: 100%;">
    <div class="datepicker" id="datepicker"></div>
    <form action="" id="toggleForm" method="post">
        <input type="hidden" name="action" id="formAction">
        <input type="hidden" name="date" id="toggleDate">
        <table>
            <!--기간에 따른 필터링-->
            <tr>
                <td>
                    <label class="form-switch all">
                        전체<br><input type="checkbox"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch ">
                        이번달<br><input type="checkbox" name="duration[]" value="<?php echo $this->thisMonthCondition ?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch ">
                        이번주<br><input type="checkbox" name="duration[]" value="<?php echo $this->thisWeekCondition ?>"><i></i>
                    </label>
                </td>
            </tr>
            <!--콜 유형에 따른 필터링-->
            <tr>
                <td>
                    <label class="form-switch all">
                        전체<br><input type="checkbox"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        유료<br><input type="checkbox" name="charged[]" value="<?php echo $this->chargedCondition ?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        무료<br><input type="checkbox" name="charged[]" value="<?php echo $this->freeCondition ?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        포인트<br><input type="checkbox" name="charged[]" value="<?php echo $this->pointCondition ?>"><i></i>
                    </label>
                </td>
            </tr>
            <!--고정 유무에 따른 필터링-->
            <tr>
                <td>
                    <label class="form-switch all">
                        전체<br><input type="checkbox"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        일반<br><input type="checkbox" name="fixed[]" value="<?php echo $this->unfixedCondition ?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        고정<br><input type="checkbox" name="fixed[]" value="<?php echo $this->fixedCondition ?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        월급<br><input type="checkbox" name="fixed[]" value="<?php echo $this->monthlyCondition ?>"><i></i>
                    </label>
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
    $('.form-switch.all').on('click', function () {
        if ($('input', this).is(':checked')) {
            $(this).closest('tr').find('.form-switch input').prop('checked', false);
            $(this).closest('tr').removeClass('allCheckedTR');
        }
        else {
            console.log('false');
            $(this).closest('tr').find('.form-switch input').prop('checked', true);
            $(this).closest('tr').addClass('allCheckedTR');
        }
    });
    $(".form-switch input").change(function () {
        $('#formAction').val('toggleFilter');
        $.ajax({
            type: "POST",
            method: "POST",
            url: ajaxURL,
            data: $('#toggleForm').serialize(),
            dataType: "text",
            success: function (data) {
                let array = JSON.parse(data);
                $('.callRow').each(function () {
                    if (array !== null) {
                        if (array.indexOf(parseInt(this.id)) > 0) {
                            $(this).show();
                        }
                        else {
                            $(this).hide();
                        }
                    }
                });
            }
        });
    });
</script>