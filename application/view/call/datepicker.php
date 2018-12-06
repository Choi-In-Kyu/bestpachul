<?php
$thisweekCondition  = "(YEARWEEK( workDate, 1 ) = YEARWEEK( CURDATE( ) , 1 ))";
$thisMonthCondition = "(YEAR(workDate) = YEAR(CURDATE()) AND MONTH(workDate) = MONTH(CURDATE()))";
$chargedCondition   = "(`price` > 0)";
$freeCondition      = "(`price` = 0)";
$pointCondition     = "(`point` > 0)";
$unfixedCondition   = "(`fixID` = 0)";
$fixedCondition     = "(`fixID` > 0)";
$monthlyCondition   = "(`fixID` > 0 AND `salary` = 0)";
?>

<div class="inline" style="width: 15%; height: 100%;">
    <div class="datepicker" id="datepicker"></div>
    <form action="" id="toggleForm">
        <input type="hidden" name="action" id="formAction">
        <table>
            <tr>
                <td>
                    <label class="form-switch all">
                        전체<br><input type="checkbox"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch ">
                        이번달<br><input type="checkbox" name="duration[]" value="<?php echo $thisMonthCondition?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch ">
                        이번주<br><input type="checkbox" name="duration[]" value="<?php echo $thisweekCondition?>"><i></i>
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="form-switch all">
                        전체<br><input type="checkbox"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        유료<br><input type="checkbox" name="charged[]" value="<?php echo $chargedCondition?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        무료<br><input type="checkbox" name="charged[]" value="<?php echo $freeCondition?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        포인트<br><input type="checkbox" name="charged[]" value="<?php echo $pointCondition?>"><i></i>
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="form-switch all">
                        전체<br><input type="checkbox"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        일반<br><input type="checkbox" name="fixed[]" value="<?php echo $unfixedCondition?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        고정<br><input type="checkbox" name="fixed[]" value="<?php echo $fixedCondition?>"><i></i>
                    </label>
                </td>
                <td>
                    <label class="form-switch">
                        월급<br><input type="checkbox" name="fixed[]" value="<?php echo $monthlyCondition?>"><i></i>
                    </label>
                </td>
            </tr>
        </table>
    </form>

    <!--    <div>-->
    <!--        <form id="day_form" action="" method="post"><input type="hidden" name="filter" value="day">-->
    <!--            <input id="filterDate" type="hidden" name="date">-->
    <!--        </form>-->
    <!---->
    <!--        <form action="" method="post">-->
    <!--            <input type="hidden" name="filter" value="week">-->
    <!--            <input class="full_width filterBtn" type="submit" value="이번주">-->
    <!--        </form>-->
    <!---->
    <!--        <form action="" method="post">-->
    <!--            <input type="hidden" name="filter" value="month">-->
    <!--            <input type="hidden" name="year" class="filterYear" value="--><?php //echo date('Y') ?><!--">-->
    <!--            <input type="hidden" name="month" class="filterMonth" value="--><?php //echo date('n') ?><!--">-->
    <!--            <input class="full_width filterBtn" type="submit" id="filterMonthBtn" value="이번달 (모든콜)">-->
    <!--        </form>-->
    <!---->
    <!--        <form action="" method="post">-->
    <!--            <input type="hidden" name="filter" value="paid">-->
    <!--            <input type="hidden" name="year" class="filterYear" value="--><?php //echo date('Y') ?><!--">-->
    <!--            <input type="hidden" name="month" class="filterMonth" value="--><?php //echo date('n') ?><!--">-->
    <!--            <input class="full_width filterBtn" type="submit" id="filterMonthPaidBtn" value="이번달 (유료콜)">-->
    <!--        </form>-->
    <!---->
    <!--        <form action="" method="post">-->
    <!--            <input type="hidden" name="filter" value="all"-->
    <!--            <input class="full_width filterBtn" type="submit" value="전체기간">-->
    <!--        </form>-->
    <!--    </div>-->
</div>
<script>
    $('.form-switch.all').on('click', function () {
        if ($('input', this).is(':checked')) {
            console.log('checked');
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
                console.log(data);
                let array = JSON.parse(data);
                $('.callRow').each(function () {
                    if(array !== null){
                        if(array.indexOf(parseInt(this.id))>0){
                            $(this).show();
                        }
                        else{
                            $(this).hide();
                        }
                    }
                });
            }
        });
    });

</script>