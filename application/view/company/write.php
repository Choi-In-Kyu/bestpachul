<div class="board_view auto-center">
    <h1>
      <?php
        if (isset ($this->companyData)) echo "업체정보 - " . $this->companyData['companyName'] . "(" . $this->companyData['actCondition'] . ")";
        else echo "업체 정보";
      ?>
    </h1>
    <div class="form-style-2">
        <form id="company_form" action="" method="post" enctype=''>
            <fieldset>
                <input type="hidden" name="action" value="<?php echo $this->action ?>">
                <input type="hidden" name="company-companyID" value="<?php echo $this->companyData['companyID'] ?>">
                <input type="hidden" name="ceo-ceoID" value="<?php echo $this->ceoData['ceoID'] ?>">
                <div class="table">
                    <div class="tr">
                        <div class="td-label">업체명</div>
                        <div class="td">
                            <input type="text" name="company-companyName" size="20" required autofocus
                                   value="<?php echo $this->companyData['companyName']; ?>">
                        </div>
                        <div class="td-label">대표자명</div>
                        <div class="td">
                            <input type="text" list="ceoList" name="ceo-ceoName" size="20" required
                                   value="<?php echo $this->ceoData['ceoName']; ?>">
                            <datalist id="ceoList" class="input-field">
                              <?php foreach ($this->ceoList as $key => $data): ?>
                                  <option value="<?php echo $data['ceoName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">업종</div>
                        <div class="td">
                            <input type="text" list="businessTypeList" name="company-businessType" size="20" required
                                   value="<?php echo $this->companyData['businessType']; ?>">
                            <datalist id="businessTypeList" class="input-field">
                              <?php foreach ($this->businessTypeList as $key => $data): ?>
                                  <option value="<?php echo $data['businessType'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">업체전화</div>
                        <div class="td">
                            <input type="text" name="company-companyPhoneNumber" size="20" required
                                   value="<?php echo $this->companyData['companyPhoneNumber']; ?>">
                        </div>
                        <div class="td-label">사장전화</div>
                        <div class="td">
                            <input type="text" name="ceo-ceoPhoneNumber" size="20" required
                                   value="<?php echo $this->ceoData['ceoPhoneNumber']; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">간단주소
                        </div>
                        <div class="td">
                            <input type="text" list="addressList" name="company-address"
                                   value="<?php echo $this->companyData['address']; ?>">
                            <datalist id="addressList">
                              <?php foreach ($this->addressList as $key => $data): ?>
                                  <option value="<?php echo $data['address'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">상세주소</div>
                        <div class="td">
                            <input type="text" name="company-detailAddress" size="20"
                                   value="<?php echo $this->companyData['detailAddress']; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">점수</div>
                        <div class="td">
                            <input type="text" name="company-grade" size="20" required
                                   value="<?php echo $this->companyData['grade']; ?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">비고</div>
                        <div class="td-detail">
                            <textarea class="textarea-detail"
                                      name="company-detail"><?php echo $this->get_detail($this->companyData,'company'); ?></textarea>
                        </div>
                      <?php if ($this->companyData['deleted'] == 1) : ?>
                          <div class="td-label">삭제비고</div>
                          <div class="td-detail" style="height: 50px;">
                              <textarea class="textarea-detail"
                                        name="company-deleteDetail"><?php echo $this->companyData['deleteDetail']; ?></textarea>
                          </div>
                      <?php endif; ?>
                    </div>
                </div>
              
              <?php if (!isset($this->param->idx)) : ?>
                  <br/>
                  <h1 class="table_title">가입 정보</h1>
                  <div class="btn_group" style="margin: 0; display: inline-block;">
                      <button type="button" id="btn_gujwa" onclick="type_toggle('gujwa')">구좌</button>
                      <button type="button" id="btn_deposit" onclick="type_toggle('deposit')">보증금</button>
                      <button type="button" id="btn_point" onclick="type_toggle('point')">포인트</button>
                  </div>
                  <div class="table" id="detail_table"></div>
              <?php endif; ?>

                <div class="btn_group">
                    <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
                    <button class="btn btn-submit" type="submit"><?php echo $submitButtonName ?></button>
                </div>
            </fieldset>
        </form>
    </div>

</div>

<?php include_once 'table_join.php'; ?>

<script>
    // type_toggle('gujwa');
    function type_toggle(argument) {
        let detail_table = document.getElementById('detail_table');
        switch (argument) {
            case 'gujwa':
                detail_table.innerHTML = document.getElementById('table_join_gujwa').innerHTML;
                break;
            case 'deposit':
                detail_table.innerHTML = document.getElementById('table_join_deposit').innerHTML;
                break;
            case 'point':
                detail_table.innerHTML = document.getElementById('table_join_point').innerHTML;
                break;
        }
    }
</script>