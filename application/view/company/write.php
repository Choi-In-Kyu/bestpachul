<?php $companyData = $this->companyData ?>
    <div class="board_write auto-center">
        <h1>
          <?php
            echo "업체정보";
            if (isset ($companyData)) echo " - " . $companyData['companyName'] . "(" . $companyData['actCondition'] . ")";
          ?>
        </h1>
        <div class="form-style-1">
            <form id="company_form" action="" method="post">
                <fieldset>
                    <input type="hidden" name="action"
                           value="<?php echo ($this->param->action == 'write') ? 'insert' : 'update' ?>">
                    <input type="hidden" name="company-companyID" value="<?php echo $companyData['companyID'] ?>">
                    <input type="hidden" name="ceo-ceoID" value="<?php echo $this->ceoData['ceoID'] ?>">
                    <div class="table">
                        <div class="tr">
                            <div class="td-label">업체명</div>
                            <div class="td">
                                <input type="text" name="company-companyName" size="20" required autofocus
                                       value="<?php echo $companyData['companyName']; ?>">
                            </div>
                            <div class="td-label">대표자명</div>
                            <div class="td">
                                <input type="text" list="ceoList" name="ceo-ceoName" size="20" required
                                       value="<?php echo $this->ceoData['ceoName']; ?>">
                                <datalist id="ceoList" class="input-field">
                                  <?php foreach ($this->ceo_List as $key => $data): ?>
                                      <option value="<?php echo $data['ceoName'] ?>"></option>
                                  <?php endforeach ?>
                                </datalist>
                            </div>
                            <div class="td-label">업종</div>
                            <div class="td">
                                <input type="text" list="businessTypeList" name="company-businessType" size="20"
                                       required value="<?php echo $companyData['businessType']; ?>">
                                <datalist id="businessTypeList" class="input-field">
                                  <?php foreach ($this->businessType_List as $key => $data): ?>
                                      <option value="<?php echo $data['businessType'] ?>"></option>
                                  <?php endforeach ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td-label">업체전화</div>
                            <div class="td">
                                <input type="text" name="company-companyPhoneNumber" size="20" required
                                       value="<?php echo $companyData['companyPhoneNumber']; ?>">
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
                                       value="<?php echo $companyData['address']; ?>">
                                <datalist id="addressList">
                                  <?php foreach ($this->address_List as $key => $data): ?>
                                      <option value="<?php echo $data['address'] ?>"></option>
                                  <?php endforeach ?>
                                </datalist>
                            </div>
                            <div class="td-label">상세주소</div>
                            <div class="td">
                                <input type="text" name="company-detailAddress" size="20" style="width: 660px;"
                                       value="<?php echo $companyData['detailAddress']; ?>">
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td-label">점수</div>
                            <div class="td">
                                <input type="text" name="company-grade" size="20" required
                                       value="<?php echo $companyData['grade']; ?>">
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td-label">비고</div>
                            <div class="td-detail">
                                <textarea class="textarea-detail" style="height: 200px;"
                                          name="company-detail"><?php echo $this->get_detail($companyData, 'company'); ?></textarea>
                            </div>
                          <?php if ($companyData['deleted'] == 1) : ?>
                              <div class="td-label">삭제비고</div>
                              <div class="td-detail">
                                  <textarea class="textarea-detail" style="height: 200px;"
                                            name="company-deleteDetail"><?php echo $companyData['deleteDetail']; ?></textarea>
                              </div>
                          <?php endif; ?>
                        </div>
                      <?php if (($this->param->action == 'view') && (sizeof($this->blackList) > 0)): ?>
                          <div class="tr">
                              <div class="td-label">블랙</div>
                              <div class="td-detail">
                                  <?php foreach ($this->blackList as $data){
                                      $type = ($data['ceoReg']==1) ? '오지마세요' : '안가요';
                                    echo $this->employeeName($data['employeeID'])." ".$type." : ".$data['detail'].'<br>';
                                  }
                                  ?>
                              </div>
                          </div>
                      <?php endif; ?>

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
                        <button class="btn btn-submit"
                                type="submit"><?php echo ($this->param->action == 'write') ? '추가' : '수정' ?></button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
<?php include_once 'companyAddJoinTable.php'; ?>

<script src="/public/js/call.js"></script>