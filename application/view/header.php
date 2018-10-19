<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $this->title?></title>
  <link rel="stylesheet" href="<?php echo _CSS?>common.css?<?php echo time(); ?>">
<!--  jquery-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--  jquery-->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<header id="header">
  <div>
    <div class="row">
      <div class="dropdown col-md-3">
        <button class="dropbtn" onClick = 'location.href="<?php echo _URL?>company"'>HOME</button>
      </div>
      <div class="dropdown col-md-3">
        <button class="dropbtn" onClick = 'location.href="<?php echo _URL?>company"'>업체관리</button>
      </div>
      <div class="dropdown col-md-3">
        <button class="dropbtn" onClick = 'location.href="<?php echo _URL?>employee"'>인력관리</button>
          <div class="dropdown-content">
              <a href="<?php echo _URL?>employee">근무 가능일/불가능일</a>
          </div>
      </div>
      <div class="dropdown col-md-3">
        <button class="dropbtn">콜관리</button>
        <div class="dropdown-content">
          <a href="#">콜 관리</a>
        </div>
      </div>
      <div class="dropdown col-md-3">
        <button class="dropbtn">기타
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="#">블랙리스트 관리</a>
        </div>
      </div>
    </div>
    </div>
</header>

</body>
</html>