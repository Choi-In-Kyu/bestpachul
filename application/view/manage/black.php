<div class="board_view auto-center" style="margin: 0 200px;">
    <h1>블랙리스트 관리</h1>
    <div class="form-style-2">
        <form id="employee_form" action="" method="post" enctype=''>
            <fieldset>
                <input type="hidden" name="action" value="black">
                <div class="table">
                    <div class="tr">
                        <div class="td-label">인력명</div>
                        <div class="td">
                            <input id="employeeName" type="text" list="employeeList" name="employeeName">
                            <datalist id="employeeList" class="input-field">
                              <?php foreach ($this->employeeList as $key => $data): ?>
                                  <option value="<?php echo $data['employeeName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">업체명</div>
                        <div class="td">
                            <input type="text" list="companyList" name="companyName">
                            <datalist id="companyList" class="input-field">
                              <?php foreach ($this->companyList as $key => $data): ?>
                                  <option value="<?php echo $data['companyName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td">
                            <select name="type">
                                <option value="0">안가요</option>
                                <option value="1">안불러요</option>
                            </select>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">비고</div>
                        <textarea name="detail" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </fieldset>
            <div class="btn_group">
                <a class="btn btn-default" href="<?php echo $this->param->get_page ?>">취소</a>
                <button class="btn btn-submit" type="submit">추가</button>
            </div>
        </form>
    </div>

    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="15%">
            <col width="30%">
            <col width="5%">
            <col width="45%">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>인력명</th>
            <th>업체명</th>
            <th>구분</th>
            <th>비고</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->blackList as $key => $data): ?>
            <tr>
                <td class="al_c"><?php echo $data['blackListID'] ?></td>
                <td class="al_c"><?php echo $this->db->getTable("SELECT * FROM employee WHERE employeeID = '{$data['employeeID']}'")[0]['employeeName']?></td>
                <td class="al_c"><?php echo $this->db->getTable("SELECT * FROM company WHERE companyID = '{$data['companyID']}'")[0]['companyName']?></td>
                <td class="al_c"><?php echo $data['ceoReg'] ?></td>
                <td class="al_c"><?php echo $data['detail'] ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
