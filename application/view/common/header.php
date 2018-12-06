<?php
  $selectArr = array_fill(0,4, 'selectable');
    switch ($this->param->page_type) {
      case 'company': $selectArr[0] = 'selected';break;
      case 'employee': $selectArr[1] = 'selected';break;
      case 'call': $selectArr[2] = 'selected';break;
      case 'manage': $selectArr[3] = 'selected';break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>으뜸 파출</title>
    <!--css-->
    <link rel="stylesheet" href="<?php echo _CSS ?>default.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo _CSS ?>common.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo _CSS ?>toggle.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css"/><!--date picker css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--js-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
    <script src="/public/js/datepicker.js"></script>
    
    <!--toggle-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php if (!in_array($this->param->page_type, ['login', 'ceo'])): ?>
    <body>
    <header id="header">
        <div>
            <div class="row">
                <div class="dropdown col-md-2">
                    <button class="link dropbtn" onClick='location.href="<?php echo _URL ?>company"'>홈</button>
                </div>
                <div class="dropdown col-md-2">
                    <button class="link dropbtn <?php echo $selectArr[0]?>" onClick='location.href="<?php echo _URL ?>company"'>업체관리</button>
                </div>
                <div class="dropdown col-md-2">
                    <button class="link dropbtn <?php echo $selectArr[1]?>" onClick='location.href="<?php echo _URL ?>employee"'>인력관리</button>
                    <div class="dropdown-content">
                        <a class="link" href="<?php echo _URL ?>employee/available_date">근무 가능일/불가능일</a>
                    </div>
                </div>
                <div class="dropdown col-md-2">
                    <button class="link dropbtn <?php echo $selectArr[2]?>" onClick='location.href="<?php echo _URL ?>call"'>콜관리</button>
                    <div class="dropdown-content">
                        <a class="link" href="<?php echo _URL ?>call/assign">배정관리</a>
                        <a class="link" href="<?php echo _URL ?>call/punk">펑크관리</a>
                        <a class="link" href="<?php echo _URL ?>call/fix">콜 만들기</a>
                        <a class="link" href="<?php echo _URL ?>call/manage">고정콜/월급제 관리</a>
                    </div>
                </div>
                <div class="dropdown col-md-2">
                    <button class="link dropbtn <?php echo $selectArr[3]?>">기타
                    </button>
                    <div class="dropdown-content">
                        <a class="link" href="<?php echo _URL ?>manage/black">블랙리스트 관리</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    </body>
<?php endif; ?>

</html>