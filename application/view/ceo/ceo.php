<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/public/css/default.css?<?php echo time() ?>">
    <link rel="stylesheet" href="/public/css/common.css?<?php echo time() ?>">
    <link rel="stylesheet" href="/public/css/reset.css?<?php echo time() ?>">
    <link rel="stylesheet" href="/public/css/mobile.css?<?php echo time() ?>">
    <!--  jquery-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="cd-tabs js-cd-tabs">
    <nav>
        <ul class="cd-tabs_navigation js-cd-navigation">
            <li><a data-content="home" id="tabMyInfo" class="cd-selected">내정보</a></li>
            <li><a data-content="call" id="tabCall">콜보내기</a></li>
            <li><a data-content="list" id="tabList">콜목록</a></li>
            <li><a data-content="pay" id="tabPay">호출비 정산</a></li>
        </ul>
    </nav>
    <ul class="cd-tabs_content js-cd-content">
        <li data-content="home" class="cd-selected"><?php require_once 'home.php' ?></li>
        <li data-content="pay"><?php require_once 'pay.php' ?></li>
        <li data-content="list"><?php require_once 'list.php' ?></li>
        <li data-content="call"><?php require_once 'call.php' ?></li>
    </ul>
</div>

<?php require_once _VIEW . 'common/modal.php';?>

<script src="/public/js/mobile.js"></script>
<script src="/public/js/ajax.js"></script>
</body>
</html>
