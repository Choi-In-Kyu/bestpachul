<div class="board_view auto-center">
  <!--  Company Info-->
  <div class="form-style-2">
    <form action="" method="post" enctype=''>
      <fieldset>
        <legend>글작성</legend>
        <input type="hidden" name="action" value="<?php echo $action ?>">

        <div class="table">
          <div class="tr">
            <div class="td">
                업체명
              <input type="text" name="company-companyName" size="20" required autofocus value="">
            </div>
            <div class="td">
              대표자명
              <input type="text" name="ceo-ceoName" size="20" required>
            </div>
            <div class="td">
              업종
              <input type="text" list="businessTypeList" name="company-businessType">
              <datalist id="businessTypeList" class="input-field">
                  <?php foreach ($this->businessTypeList as $key => $data): ?>
                    <option value="<?php echo $data->businessType?>"></option>
                  <?php endforeach ?>
              </datalist>
            </div>
          </div>
          <div class="tr">
            <div class="td">
              업체전화
              <input type="text" name="company-companyPhoneNumber" size="20" required>
            </div>
            <div class="td">
              사장 전화
              <input type="text" name="ceo-ceoPhoneNumber" size="20" required>
            </div>
          </div>
          <div class="tr">
            <div class="td">
              간단주소
              <input list="addressList" name="company-address">
              <datalist id="addressList">
                <select>
                  <?php foreach ($this->addressList as $key => $data): ?>
                    <option value="<?php echo $data->address ?>"></option>
                  <?php endforeach ?>
                </select>
              </datalist>
            </div>
            <div class="td">
              상세주소
              <input type="text" name="company-detailAddress" size="20" required>
            </div>
          </div>
          <div class="tr">
            <div class="td">
              업체점수
              <input type="text" name="company-grade" size="20" required value="<?php echo $name ?>"></div>
            <div class="td">
              비고
              <textarea name="company-detail"></textarea>
            </div>
          </div>
        </div>

          <table>
            <tr>
              <td>
                가입시작일
              </td>
              <td>
                <input type="date" name="join_company-startDate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
              </td>
              <td>
                가입만기일
              </td>
              <td>
                <input type="date" name="join_company-endDate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
              </td>
            </tr>
            <tr>
              <td>
                가입금액
              </td>
              <td>
                <input type="number" name="join_company-price" required>
              </td>
              <td>
                가입비고
              </td>
              <td>
                <textarea name="join_company-detail"></textarea>
              </td>
            </tr>
          </table>


        <div class="btn_group">
          <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
          <button class="btn btn-submit" type="submit">완료</button>
        </div>
      </fieldset>
    </form>
  </div>
</div>