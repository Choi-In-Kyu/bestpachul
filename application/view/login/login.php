<head>
    <link rel="stylesheet" href="<?php echo _CSS ?>login.css?<?php echo time(); ?>">
</head>
<body>

<div class="mobile-header al_c">
    <img src="/public/img/favicon.png" class="login-icon">
</div>

<div class="mobile-content">
    <div class="login-padding"></div>
    <form action="" method="post" class="login-form">
        <input type="hidden" name="action" value="login">
        <div class="login-container">
            <label class="login-label" for="user-name"><b>아이디</b></label>
            <input type="text" placeholder="아이디를 입력하세요" name="userName" required>
        </div>
        <div class="login-container">
            <label class="login-label" for="userPW"><b>비밀번호</b></label>
            <input type="password" placeholder="비밀번호를 입력하세요" name="userPW" required>
        </div>
        <div>
            <label class="save-pw"><input type="checkbox" name="login_keep" checked="checked">로그인 유지</label>
        </div>
        <div class="login-container">
            <input class="login-button" type="submit" value="로그인">
        </div>
    </form>
    <div class="login-padding"></div>
</div>

<div class="mobile-footer al_c">
    <div class="login-service-info">
        서비스 담당자: 변보선 (O1O-9l4l-722O)
    </div>
</div>
</body>