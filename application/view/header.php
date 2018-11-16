<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->title ?></title>
    <link rel="stylesheet" href="<?php echo _CSS ?>default.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo _CSS ?>common.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css"/>
    <!--  jquery-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
    <script src="/public/js/common.js"></script>
    <script src="/public/js/datepicker.js"></script>
</head>
<body>
<header id="header">
    <div>
        <div class="row">
            <div class="dropdown col-md-2">
                <button class="link dropbtn" onClick='location.href="<?php echo _URL ?>company"'>홈</button>
            </div>
            <div class="dropdown col-md-2">
                <button class="link dropbtn" onClick='location.href="<?php echo _URL ?>company"'>업체관리</button>
            </div>
            <div class="dropdown col-md-2">
                <button class="link dropbtn" onClick='location.href="<?php echo _URL ?>employee"'>인력관리</button>
                <div class="dropdown-content">
                    <a class="link" href="<?php echo _URL ?>employee/available_date">근무 가능일/불가능일</a>
                </div>
            </div>
            <div class="dropdown col-md-2">
                <button class="link dropbtn" onClick='location.href="<?php echo _URL ?>call"'>콜관리</button>
                <div class="dropdown-content">
                    <a class="link" href="<?php echo _URL ?>call/assign">배정관리</a>
                    <a class="link" href="<?php echo _URL ?>call/paid">유료콜관리</a>
                </div>
            </div>
            <div class="dropdown col-md-2">
                <button class="link dropbtn">기타
                </button>
                <div class="dropdown-content">
                    <a class="link" href="<?php echo _URL ?>manage/black">블랙리스트 관리</a>
                </div>
            </div>
        </div>
    </div>
</header>

</body>
</html>