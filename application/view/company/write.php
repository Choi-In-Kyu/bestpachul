<div class="board_view auto-center">
    <h1>업체 정보</h1>
    <div class="form-style-2">
        <form id="company_form" action="" method="post" enctype=''>
            <fieldset>
                <input type="hidden" name="action" value="<?php echo $this->action ?>">
                <div class="table">
                    <div class="tr">
                        <div class="td">
                            업체명
                            <input type="text" name="company-companyName" size="20" required autofocus value="<?php echo $this->companyList[0]['companyName'];?>">
                        </div>
                        <div class="td">
                            대표자명
                            <input type="text" list="ceoList" name="ceo-ceoName" size="20" required value="<?php echo $this->ceoData[0]['ceoName'];?>">
                            <datalist id="ceoList" class="input-field">
                              <?php foreach ($this->ceoList as $key => $data): ?>
                                  <option value="<?php echo $data['ceoID'] ?>"> (<?php echo $data['ceoName']?>) </option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td">
                            업종
                            <input type="text" list="businessTypeList" name="company-businessType" size="20" required value="<?php echo $this->companyList[0]['businessType'];?>" >
                            <datalist id="businessTypeList" class="input-field">
                              <?php foreach ($this->businessTypeList as $key => $data): ?>
                                  <option value="<?php echo $data['businessType'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            업체전화
                            <input type="text" name="company-companyPhoneNumber" size="20" required value="<?php echo $this->companyList[0]['companyPhoneNumber'];?>">
                        </div>
                        <div class="td">
                            사장 전화
                            <input type="text" name="ceo-ceoPhoneNumber" size="20" required value="<?php echo $this->ceoData[0]['ceoPhoneNumber'];?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            간단주소
                            <input type="text" list="addressList" name="company-address" value="<?php echo $this->companyList[0]['address'];?>">
                            <datalist id="addressList">
                              <?php foreach ($this->addressList as $key => $data): ?>
                                  <option value="<?php echo $data['address'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td">
                            상세주소
                            <input type="text" name="company-detailAddress" size="20" required value="<?php echo $this->companyList[0]['detailAddress'];?>">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            업체점수
                            <input type="text" name="company-grade" size="20" required value="<?php echo $this->companyList[0]['detail'];?>">
                        </div>
                        <div class="td">
                            비고
                            <textarea name="company-detail"><?php echo $this->companyList[0]['detail'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="btn_group">
                    <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
                    <button class="btn btn-submit" type="submit"><?php echo $submitButtonName?></button>
                </div>
                <br/>

                <h1>가입 정보</h1>
              <?php if (!isset($this->param->idx)) : ?>
                  <button type="button" id="btn_gujwa" onclick="type_toggle('gujwa')">구좌</button>
                  <button type="button" id="btn_deposit" onclick="type_toggle('deposit')">보증금</button>
                  <button type="button" id="btn_point" onclick="type_toggle('point')">포인트</button>
              <?php endif; ?>
                <div id="detail_table"></div>

            </fieldset>
        </form>
    </div>

</div>

<?php include_once 'table_join.php'; ?>

<script>
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