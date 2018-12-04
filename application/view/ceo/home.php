<div class="mobile_view">
    <!--업체명-->
    <h1>업체명: <?php echo $this->companyData['companyName'] ?></h1>
    <div class="table">
        <div class="tr">
            <div class="lbl">가입유형 :</div>
            <div class="td"><?php echo $this->model->joinType($this->companyID) ?></div>
        </div>
        <!--활성회된 가입 내역-->
        <?php $i = 1; ?>
      <?php foreach ($this->joinData as $key => $value): ?>
              <div class="tr">
                  <div class="lbl"><?php echo "가입{$i} ({$this->get_joinType($value)}) : " ?></div>
                  <div class="td">
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
          <div class="tr">
              <div class="lbl">금주 부른 콜 :</div>
              <div class="td">
                  평일 : <?php echo sizeof($this->weekdayCount) ?> 콜 / 주말 : <?php echo sizeof($this->weekendCount) ?> 콜
              </div>
          </div>
      <?php endif; ?>
      <?php if ($this->model->joinType($this->companyID) != 'point'): ?>
          <div class="tr">
              <div class="lbl">
                  금주 유료 콜 :
              </div>
              <div class="td">
                  평일 : <?php echo sizeof($this->weekdayPaidCount) ?> 콜 / 주말
                  : <?php echo sizeof($this->weekendPaidCount) ?> 콜
              </div>
          </div>
      <?php endif; ?>
      <?php if ($this->model->joinType($this->companyID) != 'point'): ?>
          <div class="tr">
              <div class="lbl">콜비 누적 :</div>
              <div class="td">
                <?php echo $this->callPrice; ?>
              </div>
          </div>
      <?php else: ?>
          <div class="tr">
              <div class="lbl">잔여 포인트 :</div>
              <div class="td">
                <?php echo $this->totalPoint; ?>
              </div>
          </div>
      <?php endif; ?>
    </div>
</div>