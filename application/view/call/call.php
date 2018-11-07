<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
    <script>
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
        $(function () {
            $("#datepicker1").datepicker();
        });
    </script>
</head>
<body>
<div class="board_list right auto-center">
    <div id="datepicker1" style="display: inline; position: fixed; top: auto;"></div>
    <table id="call_table" width="100%">
        <colgroup>
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>근무날짜</th>
            <th>업체명</th>
            <th>시작</th>
            <th>끝</th>
            <th>업종</th>
            <th>일당</th>
            <th>요청사항</th>
            <th>배정</th>
            <th>배정취소</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->callList as $key => $data): ?>
            <tr style="background-color: <?php echo $data['color'] ?>">
                <td class="al_c"><?php echo $data['callID'] ?></td>
                <td class="al_l"><?php echo $data['workDate'] ?></td>
                <td class="al_l"><?php echo $data['companyID'] ?></td>
                <td class="al_l"><?php echo $data['startTime'] ?></td>
                <td class="al_l"><?php echo $data['endTime'] ?></td>
                <td class="al_l"><?php echo $data['workField'] ?></td>
                <td class="al_l"><?php echo $data['workField'] ?></td>
                <td class="al_l"><?php echo $data['detail'] ?></td>
                <td class="al_l">(배정버튼)</td>
                <td class="al_l">(취소버튼)</td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<script>
</script>
</body>
</html>