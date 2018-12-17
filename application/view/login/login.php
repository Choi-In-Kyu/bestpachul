<head>
    <link rel="stylesheet" href="<?php echo _CSS ?>login.css?<?php echo time(); ?>">
</head>
<body>
<div class="al_c">
    <div class="mobile-header">
        <img src="/public/img/favicon.png" alt="Avatar" class="avatar">
    </div>
    <div class="mobile-content">
        <form action="" method="post" class="login-form">
            <input type="hidden" name="action" value="login">
            <label class="login-label" for="user-name"><b>업체명</b></label>
            <input type="text" placeholder="가게 이름을 입력하세요" name="userName" required>
            <label class="login-label" for="userPW"><b>비밀번호</b></label>
            <input type="password" placeholder="사장님 전화번호를 입력하세요" name="userPW" required>
            <input class="login-button" type="submit" value="로그인">
        </form>
    </div>
    <div class="mobile-footer" style="text-align: center">
        <small class="text-muted">서비스 담당자: 변보선 (010-9141-7220)</small>
    </div>
</div>
</body>