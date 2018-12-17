<div class="mobile_view">

    <div class="user-profile">
        <img src="/public/img/favicon.png" alt="Avatar" class="avatar">
        <h1><?php echo $this->companyData['companyName'] ?></h1>
    </div>

    <div class="box">
        <div class="title">가입유형</div>
        <div class="content"><?php echo $this->model->joinType($this->companyID) ?></div>
    </div>

    <!--활성화된 가입 내역-->
  <?php $i = 1; ?>
  <?php foreach ($this->joinData as $key => $value): ?>
      <div class="box">
          <div class="title"><?php echo "가입{$i} ({$this->get_joinType($value)})  " ?></div>
          <div class="content">
            <?php echo $value['startDate'] . " ~ " ?>
            <?php if (isset($value['endDate'])) : ?>
              <?php echo $value['endDate'] ?>
              <?php echo "(" . (strtotime($value['endDate']) - strtotime(date('Y-m-d'))) / 3600 / 24 . "일 남음)" ?>
            <?php endif; ?>
          </div>
      </div>
    <?php $i = $i + 1; ?>
  <?php endforeach; ?>


    <!--부른 콜 / 남은 콜-->
  <?php if ($this->model->joinType($this->companyID) != 'deposit'): ?>
      <div class="box">
          <div class="title">금주 부른 콜</div>
          <div class="content">평일 : <?php echo sizeof($this->weekdayCount) ?> 콜 / 주말
              : <?php echo sizeof($this->weekendCount) ?> 콜
          </div>
      </div>
  <?php endif; ?>
  
  <?php if ($this->model->joinType($this->companyID) != 'point'): ?>
      <div class="box">
          <div class="title">금주 유료 콜</div>
          <div class="content">평일 : <?php echo sizeof($this->weekdayPaidCount) ?> 콜 / 주말
              : <?php echo sizeof($this->weekendPaidCount) ?> 콜
          </div>
      </div>
  <?php endif; ?>
  <?php if ($this->model->joinType($this->companyID) != 'point'): ?>

      <div class="box">
          <div class="title">콜비 누적</div>
          <div class="content"><?php echo $this->callPrice; ?></div>
      </div>
  <?php else: ?>
      <div class="box">
          <div class="title">잔여 포인트</div>
          <div class="content">
            <?php echo $this->totalPoint; ?>
          </div>
      </div>
  <?php endif; ?>
</div>