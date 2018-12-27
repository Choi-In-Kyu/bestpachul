<?php $companyData = $this->companyData ?>
<div class="form-default">
    <form action="" id="formInsertCompany" method="post">
        <fieldset>
            <input type="hidden" name="action"
                   value="<?php echo ($this->param->action == 'write') ? 'insert' : 'update' ?>">
            <input type="hidden" name="companyID" value="<?php echo $companyData['companyID'] ?>">
            <input type="hidden" name="ceoID" value="<?php echo $this->ceoData['ceoID'] ?>">
            <div class="table">
                <div class="tr">
                    <div class="td">
                        <label for="company-companyName">업체명</label>
                        <input type="text" name="companyName" id="company-companyName" size="20" required autofocus
                               value="<?php echo $companyData['companyName']; ?>">
                    </div>
                    <div class="td">
                        <label for="company-ceoName">사장이름</label>
                        <input type="text" list="ceoList" name="ceoName" id="company-ceoName" size="20" required
                               value="<?php echo $this->ceoData['ceoName']; ?>">
                        <datalist id="ceoList" class="input-field">
                          <?php foreach ($this->ceo_List as $key => $data): ?>
                              <option value="<?php echo $data['ceoName'] ?>"></option>
                          <?php endforeach ?>
                        </datalist>
                    </div>
                    <div class="td">
                        <label for="company-businessType">업종</label>
                        <input type="text" list="businessTypeList" name="businessType" id="company-businessType"
                               size="20"
                               required value="<?php echo $companyData['businessType']; ?>">
                        <datalist id="businessTypeList" class="input-field">
                          <?php foreach ($this->businessType_List as $key => $data): ?>
                              <option value="<?php echo $data['businessType'] ?>"></option>
                          <?php endforeach ?>
                        </datalist>
                    </div>
                </div>
                <div class="duplicate" id="companyNameDuplicate">업체명을 입력 해 주세요</div>
                <div class="tr">
                    <div class="td">
                        <label for="company-companyPhoneNumber">업체전화</label>
                        <input type="text" name="companyPhoneNumber" id="company-companyPhoneNumber" size="20"
                               required
                               value="<?php echo $companyData['companyPhoneNumber']; ?>">
                    </div>
                    <div class="td">
                        <label for="company-ceophoneNumber">사장전화</label>
                        <input type="text" name="ceoPhoneNumber" id="company-ceophoneNumber" size="20" required
                               value="<?php echo $this->ceoData['ceoPhoneNumber']; ?>">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label for="company-address">간단주소</label>
                        <input type="text" list="addressList" name="address"
                               value="<?php echo $companyData['address']; ?>">
                        <datalist id="addressList">
                          <?php foreach ($this->address_List as $key => $data): ?>
                              <option value="<?php echo $data['address'] ?>"></option>
                          <?php endforeach ?>
                        </datalist>
                    </div>
                    <div class="td" style="width: 60%;">
                        <label for="company-detailAddress" style="width: 10%">상세주소</label>
                        <input type="text" name="detailAddress" size="20" style="width: 80%"
                               value="<?php echo $companyData['detailAddress']; ?>">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label for="company-grade">점수</label>
                        <input type="number" name="grade" min = "0" max="100" required
                               value="<?php echo $companyData['grade']; ?>">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <label for="company-detail">비고</label>
                        <textarea name="detail" id="company-detail" class="textarea-detail"
                                  style="height: 200px; width: 70%"><?php echo $this->get_detail($companyData, 'company'); ?></textarea>
                    </div>
                  <?php if ($companyData['deleted'] == 1) : ?>
                      <label for="deleteDetail">삭제비고</label>
                      <div class="td-detail">
                          <textarea name="deleteDetail" id="deleteDetail" class="textarea-detail"
                                    style="height: 200px;"><?php echo $companyData['deleteDetail']; ?></textarea>
                      </div>
                  <?php endif; ?>
                </div>
              <?php if (($this->param->action == 'view') && (sizeof($this->blackList) > 0)): ?>
                  <div class="tr">
                      <div class="td-detail">
                          <label for="">블랙</label>
                        <?php foreach ($this->blackList as $data) {
                          $type = ($data['ceoReg'] == 1) ? '오지마세요' : '안가요';
                          echo $this->employeeName($data['employeeID']) . " " . $type . " : " . $data['detail'] . '<br>';
                        }
                        ?>
                      </div>
                  </div>
              <?php endif; ?>
            </div>
        </fieldset>
        <?php require_once 'companyAddJoin.php'?>
    </form>
    <form action="" id="formInsertCompanyJoin" method="post">
        <input type="hidden" name="action" value="new_insert">
    </form>
</div>