<script>
    let ajaxURL = "http://bestpachul.com/application/ajax/ajax.php";
    let callForm = $('#callForm');
    let arr=[];
    let i=arr.length;
    let count=0;
    
    function initiate(time) {
        $('#formAction').val('initiate');
        $.ajax({
            type:"POST",
            url: ajaxURL,
            method:"POST",
            data: callForm.serialize(),
            dataType: "text",
            success: function (data) {
                console.log(data);
                myFunction(data, time);
            }
        });
    }
    function myFunction(data, time) {
        console.log(data);
        let joinType = JSON.parse(data).joinType;
        let callType = JSON.parse(data).callType;
        let holiday = JSON.parse(data).holiday;
        let callPrice = JSON.parse(data).callPrice;
        getSalary(time, holiday);
        if (callType === 'charged') {
            $('#callPrice').val(callPrice);
            $('#submitBtn').html("'유료' 콜 보내기 <br> 콜비 : " + callPrice + "원");
        }
        else if (callType === 'pointExceed') {
            $('#submitBtn').html("포인트 부족");
        }
        else if (callType === 'free') {
            $('#callPrice').val(0);
            $('#submitBtn').html("콜 보내기");
            if(joinType === 'point'){
                if (holiday) {
                    $('#callPoint').val(8000);
                }
                else $('#callPoint').val(6000);
            }
        }
        return data;
    }
    function getSalary(time, holiday) {
        let money;
        if (holiday === true) {
            $('#date').css({'color':'red','font-weight':'bold'});
            if (parseInt(endHour.val()) * 100 + parseInt(endMin.val()) > 2400) {//야간
                switch (time) {
                    case 5:money = 57000;break;
                    case 6:money = 64000;break;
                    case 7:money = 71000;break;
                    case 8:money = 78000;break;
                    case 9:money = 85000;break;
                    case 10:money = 92000;break;
                    case 11:money = 96000;break;
                    case 12:money = 100000;break;
                    default:money = 0;break;
                }
            }
            else {
                switch (time) {
                    case 5:money = 47000;break;
                    case 6:money = 54000;break;
                    case 7:money = 61000;break;
                    case 8:money = 68000;break;
                    case 9:money = 75000;break;
                    case 10:money = 82000;break;
                    case 11:money = 86000;break;
                    case 12:money = 90000;break;
                    default:money = 0;break;
                }
            }
        }
        else {
            $('#date').css('color', 'black');
            if (parseInt(endHour.val()) * 100 + parseInt(endMin.val()) > 2400) {
                switch (time) {
                    case 5:money = 52000;break;
                    case 6:money = 59000;break;
                    case 7:money = 66000;break;
                    case 8:money = 73000;break;
                    case 9:money = 80000;break;
                    case 10:money = 87000;break;
                    case 11:money = 91000;break;
                    case 12:money = 95000;break;
                    default:money = 0;break;
                }
            }
            else {
                switch (time) {
                    case 5:money = 42000;break;
                    case 6:money = 49000;break;
                    case 7:money = 56000;break;
                    case 8:money = 63000;break;
                    case 9:money = 70000;break;
                    case 10:money = 77000;break;
                    case 11:money = 81000;break;
                    case 12:money = 85000;break;
                    default:money = 0;break;
                }
            }
        }
        salary.html("근무시간: " + time + " 시간 / 일당: " + money + " 원");
        $('#salary').val(money);
    }
    function call() {
        $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
        $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
        $('#formAction').val('initiate');
        $.ajax({
            type:"POST",
            url: ajaxURL,
            method:"POST",
            data: $('#callForm').serialize(),
            dataType:"text",
            async: false,
            success:function(data)
            {
                data = myFunction(data, time);
                let callType = JSON.parse(data).callType;
                if(callType === 'free'){
                    freeCall(data);
                }
                if(callType === 'charged'){
                    chargedCall(data);
                }
                else if(callType === 'pointExceed'){
                    alert('포인트가 부족합니다. 충전해주세요');
                    window.location.reload();
                }
            }
        });
    }
    function chargedCall(data){
        if(confirm("유료콜입니다. 콜을 요청하시겠습니까?")){
            $('#formAction').val('call');
            $.ajax({
                type:"POST",
                url: ajaxURL,
                method:"POST",
                data: $('#callForm').serialize(),
                dataType:"text",
                async: false,
                success:function(data){
                    alert('유료 콜을 보냈습니다.');
                    // window.location.reload();
                }
            })
        }
        else{
            alert("콜을 취소했습니다.");
            // window.location.reload();
        }
    }
    function freeCall(data) {
        $('#submitBtn').html("콜 보내기");
        $('#formAction').val('call');
        $('#callPrice').val(0);
        $.ajax({
            type:"POST",
            url:"http://bestpachul.com/application/ajax/ajax.php",
            method:"POST",
            data: $('#callForm').serialize(),
            dataType:"text",
            success:function(data){
                alert('무료 콜을 보냈습니다.');
                // window.location.reload();
            }
        })
    }
    function cancel(){
        $.ajax({
            type:"POST",
            url:"http://bestpachul.com/application/ajax/ajax.php",
            method:"POST",
            data: $('#callCancelForm').serialize(),
            dataType:"text",
            success:function(data)
            {
                window.location.reload();
            }
        });
    }
    
    
    function fix(){
        $('#formAction').val('fix');
        $.ajax({
            type:"POST",
            method:"POST",
            url: ajaxURL,
            dataType: "text",
            data: callForm.serialize(),
            async: false,
        }).success(function (data) {
            let dateArray = JSON.parse(data);
            console.log(dateArray);
            for(let date in dateArray){
                myFix(dateArray[date]);
            }
        });
    }
    
    function myFix(date){
        $('#workDate').val(date);
        $('#formAction').val('initiate');
        $.ajax({
            type:"POST",
            url:"http://bestpachul.com/application/ajax/ajax.php",
            method:"POST",
            data: $('#callForm').serialize(),
            dataType:"text",
            async: false,
            success:function(data)
            {
                let callType = JSON.parse(data).callType;
                if(callType === 'free'){
                    freeCall(data);
                }
                if(callType === 'charged'){
                    chargedCall(data);
                }
                else if(callType === 'pointExceed'){
                    alert('포인트가 부족합니다. 충전해주세요');
                    window.location.reload();
                }
                recursive();
            }
        });
        count++;
    }

    function recursive() {
        console.log(count);
        if(count<i){
            $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
            $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
            $('#formAction').val('initiate');
            $.ajax({
                type:"POST",
                url:"http://bestpachul.com/application/ajax/ajax.php",
                method:"POST",
                data: $('#callForm').serialize(),
                dataType:"text",
                success:function(data)
                {
                    let callType = JSON.parse(data).callType;
                    if(callType === 'free'){
                        freeCall(data);
                    }
                    if(callType === 'charged'){
                        chargedCall(data);
                    }
                    else if(callType === 'pointExceed'){
                        alert('포인트가 부족합니다. 충전해주세요');
                        window.location.reload();
                    }
                    recursive();
                }
            });
            count++;
        }
    }
    
</script>