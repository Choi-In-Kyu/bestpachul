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
        <input type="hidden" name="workDate" id="workDate" class="workDate" value="<?php echo _TOMORROW ?>">
        <input type="hidden" name="endDate" id="endDate" class="endDate">
        <input type="hidden" name="fixID" id="fixID">
        <input type="hidden" name="commission">
        <div class="table">
            <!--인력이름, 업체이름-->
            <div class="tr">
                <div class="td td-3">
                    <label for="">업체명</label>
                    <input type="text" class="input-companyName" list="companyList" name="companyName" id="companyName"
                           placeholder="배정 요청한 업체를 입력하세요">
                    <datalist id="companyList" class="input-field">
                      <?php foreach ($companyList as $key => $data): ?>
                          <option value="<?php echo $data['companyName'] ?>">
                            <?php echo "(" . $this->model->joinType($data['companyID'], 'kor') . ")"; ?>
                          </option>
                      <?php endforeach ?>
                    </datalist>
                </div>
                <div class="td td-3">
                    <label for="">인력명</label>
                    <input type="text" list="employeeList" name="employeeName" id="employeeName"
                           placeholder="배정할 인력을 입력하세요 (생략가능)">
                    <datalist id="employeeList" class="input-field">
                      <?php foreach ($employeeList as $key => $data): ?>
                          <option value="<?php echo $data['employeeName'] ?>">
                            <?php if ($data['bookmark'] == 1) echo "(북마크)"; ?>
                          </option>
                      <?php endforeach ?>
                    </datalist>
                </div>
                <div class="td td-3" id="errorMsg" style="display: none">
                    <h2></h2>
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
                    <button class="basic btn btn-option selected" type="button" id="tomorrow">내일(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime(_TOMORROW))] ?>)</button>
                    <button class="basic btn btn-option" type="button" id="dayAfterTomorrow">모레(<?php echo unserialize(DAYOFWEEK)[date('w', strtotime("+2 day"))] ?>)</button>
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

<script>

    let start_hour = $('#startHour');
    let end_hour = $('#endHour');
    let first_start_hour = 10;//근무 시작 시간 기본값
    let first_end_hour = 15;//근무 종료 시간 기본값
    let work_field = $('#workField');
    let work_date = $('#workDate');

    $(document).ready(function () {//다른 js 파일 모두 불러온 뒤 함수 내용이 실행됨
        ready();
        input_company();
        input_work_date();
        input_work_time();
        input_work_field();
        input_employee();
        
        send_call();
    });

    function ready() {
        start_hour.val(first_start_hour);
        end_hour.val(first_end_hour);
        work_field.val('주방보조');
        $('.callBtn:not(#btnSendCall)').hide();
        $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', true);
        $('input.workDate').prop('min',today);
        getSalary(first_start_hour, first_end_hour, tomorrow);
    }

    function input_company() {
        $('#companyName').on('input', function () {
            let id_element = $('#companyID');
            let name_element = $(this);
            $('.workDate').val(tomorrow);
            $('.workDate').trigger('input');
            match_company_id(id_element, name_element);
            get_join_type(name_element, work_date.val());
    });
    }

    function match_company_id(id_element, name_element) {
        let company_name = name_element.val();
        $.ajax({
            type: "POST",
            method: "POST",
            url: ajaxURL,
            data: {action: 'get_company_id', name: company_name},
            dataType: "text",
            async: true,
            success: function (data) {
                let error = JSON.parse(data).error;
                if(error){
                    console.log(error);
                    $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', true);
                    $('#errorMsg h2').html(error);
                    $('#errorMsg').show();
                    id_element.val(null);
                }
                else{
                    $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', false);
                    id_element.val(data);
                }
            },
        });
    }

    function get_join_type(name_element, date) {
        $.ajax({
            type: "POST",
            method: "POST",
            url: ajaxURL,
            data: {action: 'get_join_type', name: name_element.val(), date:date},
            dataType: "text",
            async: true,
            success: function (data) {
                let join_type = JSON.parse(data).joinType;
                let size = JSON.parse(data).size;
                let end_date = JSON.parse(data).endDate;
                let call_type = JSON.parse(data).callType;
                let call_price = JSON.parse(data).callPrice;
                let error = JSON.parse(data).error;
                if(error){
                    console.log(error);
                    $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', true);
                    $('#errorMsg h2').html(error);
                    $('#errorMsg').show();
                }
                else{
                    $('#callForm input:not(.input-companyName), #callForm select, #callForm textarea, #callForm button').prop('disabled', false);
                    $('#errorMsg h2').html(join_type+" ("+size+"개 가입)");
                    $('#errorMsg').show();
                    if(join_type ==='구좌'){
                        $('input.workDate').prop('max',end_date);
                    }
                    if(call_price){
                        $('#btnSendCall').html("콜 신청하기 <br>"+"콜비 : "+call_price+"원");
                        $('#callPrice').val(call_price);
                    }
                    else{$('#btnSendCall').html("콜 신청하기");}
                }
            }
        });
    }

    function input_work_date() {
        let workDate = $('.workDate');
        let btn1 = $('#tomorrow');
        let btn2 = $('#dayAfterTomorrow');
        workDate.on('input', function () {
            let name_element = $('#companyName');
            let date = $(this).val();
            if (date === tomorrow) {//내일 날짜 선택 시
                btn1.addClass('selected');
                btn2.removeClass('selected');
            }
            else if (date === dayaftertomorrow) {//모레 날짜 선택 시
                btn1.removeClass('selected');
                btn2.addClass('selected');
            }
            else {//내일, 모레 아닌 날짜 선택 시
                btn1.removeClass('selected');
                btn2.removeClass('selected');
            }
            getSalary(start_hour.val(), end_hour.val(), $(this).val());
            get_join_type(name_element, $(this).val());//match 된 companyID 사용
        });
        btn1.on('click', function () {
            workDate.val(tomorrow);
            workDate.trigger('input');
        });
        btn2.on('click', function () {
            workDate.val(dayaftertomorrow);
            workDate.trigger('input');
        });
    }

    function limit_end_time(starth, endOption) {
        console.log(starth);
        for (let i = 0; i < 50; i++) {
            if ((i < starth + 4) || (i > starth + 11)) {
                endOption.eq(i).css('display', 'none');
            }
            else {
                endOption.eq(i).css('display', 'block');
            }
        }
    }

    function map_time_to_btn(starth, endh) {
        if (endh - starth >= 10) {//종일
            $('#allDayBtn').addClass('selected');
            $('#allDayBtn').closest('div').find('.btn-option:not(#allDayBtn)').removeClass('selected');
        }
        else {
            if (starth < 12) {//오전
                $('#morningBtn').addClass('selected');
                $('#morningBtn').closest('div').find('.btn-option:not(#morningBtn)').removeClass('selected');
            }
            else {//종일
                $('#afternoonBtn').addClass('selected');
                $('#afternoonBtn').closest('div').find('.btn-option:not(#afternoonBtn)').removeClass('selected');
            }
        }
    }

    function input_work_time() {
        //front input values
        let start = $('#startHour');
        let end = $('#endHour');
        let minute = $('.minute');
        let workDate = $('.workDate');
        let endOption = $('.endOption');
        
        //real input values
        let start_time = $('#startTime');
        let end_time = $('#endTime');
        
        start.on('input', function () {
            let starth = parseInt($(this).val());
            let endh = starth + 5;
            end.val(endh);
            start_time.val(starth+':'+$('#startMin').val());
            end_time.val(endh+':'+$('#startMin').val());
            limit_end_time(starth, endOption);
            map_time_to_btn(starth, endh);
            getSalary(start.val(), end.val(), workDate.val());
        });
        end.on('input', function () {
            let starth = parseInt(start.val());
            let endh = parseInt($(this).val());
            start_time.val(starth+':'+$('#endMin').val());
            end_time.val(endh+':'+$('#endMin').val());
            limit_end_time(starth, endOption);
            map_time_to_btn(starth, endh);
            getSalary(start.val(), end.val(), workDate.val());
        });
        minute.on('input',function () {
            minute.val($(this).val());
            start_time.val(start.val()+':'+minute.val());
            end_time.val(end.val()+':'+minute.val());
        });

        $('#morningBtn').on('click', function () {
            start_hour.val('10');
            end_hour.val('15');
            minute.val('00');
            start.trigger('input');
            minute.trigger('input');
        });
        $('#afternoonBtn').on('click', function () {
            start_hour.val('18');
            end_hour.val('23');
            minute.val('00');
            start.trigger('input');
            minute.trigger('input');
        });
        $('#allDayBtn').on('click', function () {
            start_hour.val('10');
            end_hour.val('21');
            minute.val('00');
            end.trigger('input');
            minute.trigger('input');
        });
    }

    function input_work_field() {
        work_field.on('input', function () {
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
                let btn = $('.btn-option.wash');
                btn.closest('div').find('.btn-option').removeClass('selected');
            }
        });
        $('.btn-work-field').on('click', function () {
            work_field.val($(this).text());
        });
    }

    function input_employee() {
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
            set_validity($(this), 'employee');
        });
    }
    
    function send_call(){
        $('#btnSendCall').on('click',function () {
            if (confirm("콜을 신청하시겠습니까?")) {
                $('#formAction').val('call');
                $.ajax({
                    type: "POST",
                    method: "POST",
                    url: ajaxURL,
                    data: $('#callForm').serialize(),
                    dataType: "text",
                    async: false,
                    success: function (data) {
                        console.log(data);
                        alert('콜을 보냈습니다!');
                        if (pageType !== 'call') {
                            window.location.reload();
                        }
                    }
                })
            }
            else {
                alert("콜을 취소했습니다.");
                if (pageType !== 'call') {
                    window.location.reload();
                }
            }
        });
    }

    $('#percentage').on('input', function () {
        $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
        $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
    });
    $('#monthlySalary').on('input', function () {
        $('#commission').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
        $('#callForm input[name=commission]').val($('#percentage').val() * 0.01 * $('#monthlySalary').val());
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
    $('.btn-option').on('click', function () {
        $(this).closest('div').find('.btn-option').removeClass("selected");
        $(this).addClass('selected');
    });


</script>