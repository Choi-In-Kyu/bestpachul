<?php
  $employeeList = $this->model->getTable("SELECT * FROM `employee` WHERE `activated` = 1 OR `bookmark` = 1 ORDER BY `employeeName` ASC");
  $companyList = $this->model->getTable("SELECT * FROM `company` WHERE `activated` = 1 OR `bookmark` =1 ORDER BY `companyName` ASC");
?>

<div class="board-write">
    <div class="title-table">
        <h1 class="title-main">콜 만들기</h1>
    </div>
    <div>
        <button class="btn btn-option selected" id="manualCallBtn">일반콜</button>
        <button class="btn btn-option" id="fixCallBtn">고정</button>
        <button class="btn btn-option" id="monthlyCallBtn">월급제</button>
    </div>
    <form action="" id="callForm" method="post">
        <input type="hidden" name="action" id="formAction">
        <input type="hidden" name="companyID" id="companyID">
        <input type="hidden" name="employeeID" id="employeeID">
        <input type="hidden" name="startTime" id="startTime">
        <input type="hidden" name="endTime" id="endTime">
        <input type="hidden" name="salary" id="salary">
        <input type="hidden" name="price" id="callPrice">
        <input type="hidden" name="point" id="callPoint">
        <input type="hidden" name="workDate" id="workDate" class="workDate">
        <input type="hidden" name="endDate" id="endDate" class="endDate">
        <input type="hidden" name="fixID" id="fixID">
        <input type="hidden" name="commission">
        <div class="table">
            <!--인력이름, 업체이름-->
            <div class="tr">
                <div class="td td-3">
                    <label for="">인력명</label>
                    <input type="text" list="employeeList" name="employeeName" id="employeeName"
                           placeholder="배정할 인력을 입력하세요">
                    <datalist id="employeeList" class="input-field">
                      <?php foreach ($employeeList as $key => $data): ?>
                          <option value="<?php echo $data['employeeName'] ?>">
                            <?php if ($data['bookmark'] == 1) echo "(북마크)"; ?>
                          </option>
                      <?php endforeach ?>
                    </datalist>
                </div>
                <div class="td td-3">
                    <label for="">업체명</label>
                    <input type="text" list="companyList" name="companyName" id="companyName"
                           placeholder="배정 요청한 업체를 입력하세요">
                    <datalist id="companyList" class="input-field">
                      <?php foreach ($companyList as $key => $data): ?>
                          <option value="<?php echo $data['companyName'] ?>">
                            <?php if ($data['bookmark'] == 1) echo "(북마크)"; ?>
                          </option>
                      <?php endforeach ?>
                    </datalist>
                </div>
            </div>
            <!--근무요일-->
            <div class="tr fixable" id="workDay" style="display: none;">
                <div class="td td-9">
                    <label for="">근무요일</label>
                    <table style="width: 700px">
                        <tr>
                            <td><input type="checkbox" name="dow[]" value="monday"></td>
                            <td><input type="checkbox" name="dow[]" value="tuesday"></td>
                            <td><input type="checkbox" name="dow[]" value="wednesday"></td>
                            <td><input type="checkbox" name="dow[]" value="thursday"></td>
                            <td><input type="checkbox" name="dow[]" value="friday"></td>
                            <td><input type="checkbox" name="dow[]" value="saturday"></td>
                            <td><input type="checkbox" name="dow[]" value="sunday"></td>
                        </tr>
                        <tr>
                            <td>월</td>
                            <td>화</td>
                            <td>수</td>
                            <td>목</td>
                            <td>금</td>
                            <td>토</td>
                            <td>일</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!--근무기간-->
            <div class="tr">
                <div class="td td-3">
                    <label for="">근무기간</label>
                    <input type="date" class="workDate" value="<?php echo _TOMORROW ?>">
                </div>
                <div class="endDate fixable td td-3" style="display: none;">
                    <strong style="font-size: 30px;">~</strong>
                    <input type="date" class="endDate">
                </div>
                <div class="td td-3">
                    <button class="fixable btn btn-option" type="button" onclick="auto_insert_call_monthly()"
                            style="display: none">이번달
                    </button>
                </div>
                <div class="td td-3">
                    <button class="basic btn btn-option selected" type="button" id="tomorrow">내일</button>
                    <button class="basic btn btn-option" type="button" id="dayAfterTomorrow">모레</button>
                </div>
            </div>
            <!--근무시간-->
            <div class="tr">
                <div class="td td-6" id="">
                    <label for="">근무시간</label>
                    <select id="startHour" class="time hour" form="callForm" required>
                        <option value="" selected disabled hidden>근무 시작 시간</option>
                      <?php for ($i = 1; $i < 25; $i++): ?>
                          <option class="startOption" value="<?php echo $i ?>">
                            <?php echo $this->getTime($i); ?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="time minute" id="startMin" form="callForm" required>
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                    <select id="endHour" class="time hour" form="callForm" required>
                        <option value="" selected disabled hidden>근무 종료 시간</option>
                      <?php for ($i = 1; $i < 37; $i++): ?>
                          <option class="endOption" value="<?php echo $i ?>">
                            <?php echo $this->getTime($i); ?>
                          </option>
                      <?php endfor; ?>
                    </select>
                    <select class="time minute" id="endMin" form="callForm" required>
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                    </select>
                </div>
                <div class="td td-3">
                    <button type="button" class="btn btn-option timeSelect selected" id="morningBtn">오전</button>
                    <button type="button" class="btn btn-option timeSelect" id="afternoonBtn">오후</button>
                    <button type="button" class="btn btn-option timeSelect" id="allDayBtn">종일</button>
                </div>
            </div>
            <div class="tr">
                <div class="td td-9">
                    <label for="">임금</label>
                    <p id="salaryInfo" style="display:inline-table; width: 50%;">근무시간을 선택해주세요</p>
                </div>
            </div>
            <!--업종-->
            <div class="tr">
                <div class="td td-3">
                    <label for="">업종</label>
                    <select name="workField" id="workField" form="callForm" required>
                      <?php foreach ($this->workField_List as $key => $data): ?>
                          <option value="<?php echo $data['workField']; ?>">
                            <?php echo $data['workField'] ?>
                          </option>
                      <?php endforeach ?>
                    </select>
                </div>
                <div class="td td-3">
                    <button type="button" class="btn btn-option btn-work-field wash">설거지</button>
                    <button type="button" class="btn btn-option btn-work-field kitchen selected ">주방보조</button>
                    <button type="button" class="btn btn-option btn-work-field hall">홀서빙</button>
                </div>
            </div>
            <!--월급-->
            <div class="tr monthly" style="display: none;">
                <div class="td td-3">
                    <label for="">월급</label>
                    <input type="number" name="monthlySalary" id="monthlySalary">
                </div>
                <div class="td td-3">
                    <label for="">수수료 비율</label>
                    <input type="number" name="percentage" id="percentage">
                </div>
                <div class="td td-3">
                    <label for="">수수료</label>
                    <input type="number" name="commission" id="commission">
                </div>
            </div>
            <!--기타 요청 사항-->
            <div class="tr">
                <div class="td td-9">
                    <label for="">기타 요청 사항</label>
                    <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
                </div>
            </div>
            <!--콜 보내기 버튼-->
            <div class="btn-group al_r">
                <h1 class="callPrice"></h1>
                <button id="btnSendCall" class="btn btn-insert callBtn" type="button">콜 신청하기</button>
                <button id="submitFixedCallBtn" class="btn btn-insert callBtn fixBtn" type="button">고정 콜 만들기</button>
                <button id="submitMonthlyCallBtn" class="btn btn-insert callBtn fixBtn" type="button">월급제 만들기</button>
            </div>
    </form>
</div>
<!--<script src="/public/js/ceo.js"></script>-->
<script>
    $(document).ready(function () {
        $('#workField').val('주방보조');
        startHour.val('10');
        endHour.val('15');
        initiate(endHour.val() - startHour.val());
        $('.callBtn').hide();
        $('#btnSendCall').show();
        limitTime(false);
    });
    $('#percentage').on('input', function () {
        $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
        $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
    });
    $('#monthlySalary').on('input', function () {
        $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
        $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
    });
    $('#companyName').on('input', function () {
        $('#formAction').val('getCompanyID');
        $.ajax({
            type: "POST",
            url: ajaxURL,
            method: "POST",
            data: $('#callForm').serialize(),
            dataType: "text",
            success: function (data) {
                $('#companyID').val(data);
                initiate(endHour.val() - startHour.val());
            }
        });
    });
    $('#employeeName').on('input', function () {
        $('#formAction').val('getEmployeeID');
        $.ajax({
            type: "POST",
            url: ajaxURL,
            method: "POST",
            data: $('#callForm').serialize(),
            dataType: "text",
            success: function (data) {
                $('#employeeID').val(data);
            }
        });
    });
    $('#manualCallBtn').on('click', function () {
        $('.callBtn').hide();
        $('#btnSendCall').show();
        $('.basic').slideDown();
        $('.monthly').slideUp();
        $('.fixable').slideUp();
    });
    $('#fixCallBtn').on('click', function () {
        $('.callBtn').hide();
        $('#submitFixedCallBtn').show();
        $('.endDate').css('display', 'inline');
        $('.basic').slideUp();
        $('.monthly').slideUp();
        $('.fixable').slideDown();
    });
    $('#monthlyCallBtn').on('click', function () {
        $('.callBtn').hide();
        $('#submitMonthlyCallBtn').show();
        $('.endDate').css('display', 'inline');
        $('.endDate').val();
        $('.basic').slideUp();
        $('.fixable').slideDown();
        $('.monthly').slideDown();
    });
    $('#callForm input').on('input', function () {
        initiate(endHour.val() - startHour.val());
    });
    $('#callForm select').on('input', function () {
        initiate(endHour.val() - startHour.val());
    });
    $('#tomorrow').on('click', function () {
        $('.workDate').val(tomorrow);
        $('.workDate').trigger('input');
    });
    $('#dayAfterTomorrow').on('click', function () {
        $('.workDate').val(dayaftertomorrow);
        $('.workDate').trigger('input');
    });
    $('.btn-option').click(function () {
        $(this).closest('div').find('.btn-option').removeClass("selected");
        $(this).addClass('selected');
    });
    $('#workField').on('input', function () {
        let value = $(this).val();
        if (value === '설거지') {
            let btn = $('.btn-option.wash');
            btn.closest('div').find('.btn-option').removeClass('selected');
            btn.addClass('selected');
        }
        else if (value === '주방보조') {
            let btn = $('.btn-option.kitchen');
            btn.closest('div').find('.btn-option').removeClass('selected');
            btn.addClass('selected');
        }
        else if (value === '홀서빙') {
            let btn = $('.btn-option.hall');
            btn.closest('div').find('.btn-option').removeClass('selected');
            btn.addClass('selected');
        }
        else {
            console.log('nothing');
            let btn = $('.btn-option.wash');
            btn.closest('div').find('.btn-option').removeClass('selected');
        }

    });
    $('.workDate').on('input', function () {
        let value = $(this).val();
        console.log(value);
        console.log(tomorrow);
        if (value === tomorrow) {
            let btn = $('#tomorrow');
            btn.closest('div').find('button').removeClass('selected');
            btn.addClass('selected');
        }
        else if (value === dayaftertomorrow) {
            let btn = $('#dayAfterTomorrow');
            btn.closest('div').find('button').removeClass('selected');
            btn.addClass('selected');
        }
        else {
            let btn = $('#dayAfterTomorrow');
            btn.closest('div').find('button').removeClass('selected');
        }
    })
    ;
</script>