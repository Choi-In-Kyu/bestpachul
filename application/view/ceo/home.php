<div class="mobile_view">
    <h1>업체명: <?php echo $this->companyData['companyName'] ?></h1>
    <div class="table">
        <div class="tr">
            <div class="lbl">가입유형 :</div>
            <div class="td"><?php echo $this->get_joinType($this->joinData) ?></div>
        </div>
      <?php foreach ($this->joinData as $key => $value): ?>
          <div class="tr">
              <div class="lbl"><?php echo "가입" . ($key + 1) . " : " ?></div>
              <div class="td">
                <?php echo $value['startDate'] . " ~ " . $value['endDate'] ?>
                
                <?php if ($this->leftDays($value['endDate']) > 0) echo "(만기)";
                else echo $this->leftDays($value['endDate'])
                ?>

              </div>
          </div>
      <?php endforeach; ?>

        <div class="tr">
            <div class="lbl">남은 콜 :</div>
            <div class="td"></div>
        </div>
        <div class="tr">
            <div class="lbl"><?php echo date('n') ?>월 콜비 :</div>
            <div class="td"></div>
        </div>
    </div>
</div>