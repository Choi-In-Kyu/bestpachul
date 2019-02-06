<?php
    $companyList = $this->model->getTable("SELECT * FROM `company` WHERE `deleted` = 0 ORDER BY `companyName` ASC");
    
  $page = (isset($_POST['page'])) ? $_POST['page'] : 1;
  $record_per_page = 30;
  $start_from = ($page - 1) * $record_per_page;
  $query = "
SELECT `blackListID`,`employee`.`employeeID`,`company`.`companyID`,`employeeName`,`companyName`,`blackList`.`detail`, `blackList`.`ceoReg`
FROM `blackList`
LEFT JOIN `employee` on blackList.employeeID = employee.employeeID
LEFT JOIN `company` on blackList.companyID = company.companyID
";
  if ($_POST['ceoReg'] != null) {
      if($_POST['ceoReg'] == 'all'){
       $selected_option[2] = 'selected';
      }
      else{
        $condition[] = " `ceoReg` = '{$_POST['ceoReg']}' ";
        $selected_option[$_POST['ceoReg']] = 'selected';
      }
  }
  else{
    $selected_option[2] = 'selected';
  }
  if ($_POST['search']) {
    $condition[] = "
  (`employeeName` LIKE '%{$_POST['search']}%') OR
  (`companyName` LIKE '%{$_POST['search']}%') OR
  (`blackList`.`detail` LIKE '%{$_POST['search']}%')
  ";
  }
  if ($condition) {
    $query .= " WHERE ";
    $query .= implode(' AND ', $condition);
  }
  $page_result = $this->model->getTable($query);
  $total_records = sizeof($page_result);
  $total_pages = ceil($total_records / $record_per_page);
  $start_loop = max(1, $page - 2);
  $end_loop = min($total_pages, $page + 2);
  $difference = $total_pages - $page;
  $end_to = $start_from + $record_per_page;
  $query .= " ORDER BY `blackListID` DESC LIMIT {$start_from}, {$record_per_page} ";
  $black = $this->model->getTable($query);
  $selected_page[$page] = "selected";
  ?>

<style>
    form {
        display: inline-block;
    }
    
    /*.search {*/
        /*width: 100%;*/
        /*position: relative*/
    /*}*/
    
    /*.searchTerm {*/
        /*float: left;*/
        /*width: 100%;*/
        /*border: 3px solid #00B4CC;*/
        /*padding: 5px;*/
        /*height: 20px;*/
        /*border-radius: 5px;*/
        /*outline: none;*/
        /*color: #9DBFAF;*/
    /*}*/
    
    /*.searchTerm:focus {*/
        /*color: #00B4CC;*/
    /*}*/
    
    /*.searchButton {*/
        /*position: absolute;*/
        /*right: -50px;*/
        /*width: 40px;*/
        /*height: 36px;*/
        /*border: 1px solid #00B4CC;*/
        /*background: #00B4CC;*/
        /*text-align: center;*/
        /*color: #fff;*/
        /*border-radius: 5px;*/
        /*cursor: pointer;*/
        /*font-size: 20px;*/
    /*}*/
    
    /*!*Resize the wrap to see the search bar change!*!*/
    /*.wrap {*/
        /*width: 30%;*/
        /*position: absolute;*/
        /*top: 50%;*/
        /*left: 50%;*/
        /*transform: translate(-50%, -50%);*/
    /*}*/
</style>

<div class="board-write auto-center">
    <div class="title-table">
        <h1 class="title-main">블랙리스트 관리 - 총 <?php echo $total_records ?> 건</h1>
    </div>
    <!--블랙리스트 추가 폼-->
    <div class="form-default">
        <form id="formBlack" action="" method="post">
            <fieldset>
                <input type="hidden" name="action" value="black">
                <div class="table" style="width: 100%">
                    <div class="tr">
                        <div class="td td-4">
                            <label for="">인력명</label>
                            <input id="employeeName" type="text" list="employeeList" name="employeeName" required>
                            <datalist id="employeeList" class="input-field">
                              <?php foreach ($this->employee_List as $key => $data): ?>
                                  <option value="<?php echo $data['employeeName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td td-4">
                            <label for="">상호명</label>
                            <input type="text" list="companyList" name="companyName" required>
                            <datalist id="companyList" class="input-field">
                              <?php foreach ($companyList as $key => $data): ?>
                                  <option value="<?php echo $data['companyName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td td-3">
                            <label for="">유형</label>
                            <select name="type" style="height: 39px; width: 130px;" required>
                                <option value="0">안가요</option>
                                <option value="1">오지마세요</option>
                            </select>
                        </div>
                        <div class="td td-9">
                            <label for="">비고</label>
                            <input type="text" name="detail" style="width: 700px;">
                            </textarea>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="btn-group al_r">
                <button class="btn btn-insert" type="submit">추가</button>
            </div>
        </form>
    </div>
    <!--블랙리스트 검색 폼-->
    <div class="btn-group" style="display: inline-block; width: 500px;">
        <form action="" method="post" style="width: 100%;">
            <input type="text" name="search" style="width: 280px;height: 100%; border: 1px solid #dbdbdb; vertical-align: middle;">
            <input type="submit" class="btn btn-submit" value="검색" style="height: 100%;">
        </form>
    </div>
    <!--블랙리스트 필터 폼-->
    <div class="btn-group" style="display: inline;height: 150px;">
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="ceoReg" value="all">
            <input type="submit" class="btn btn-option <?php echo $selected_option[2] ?>" value="전체"
                   style="height: 100%;">
        </form>
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="ceoReg" value="1">
            <input type="submit" class="btn btn-option <?php echo $selected_option[1] ?>" value="오지마세요"
                   style="height: 100%;">
        </form>
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="ceoReg" value="0">
            <input type="submit" class="btn btn-option <?php echo $selected_option[0] ?>" value="안가요"
                   style="height: 100%;">
        </form>
    </div>
    <!--블랙리스트 테이블-->
    <table id="blackListTable" width="100%">
        <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="20%">
            <col width="10%">
            <col width="auto">
            <col width="5%">
        </colgroup>
        <thead>
        <tr>
            <th class="order link" id="refresh-blackListID">#</th>
            <th class="order link" id="refresh-employeeName">인력명</th>
            <th class="order link" id="refresh-companyName">상호명</th>
            <th class="order link" id="refresh-ceoReg">구분</th>
            <th class="order link" id="refresh-detail">비고</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($black as $key => $data): ?>
            <tr>
                <td class="al_c"><?php echo $data['blackListID'] ?></td>
                <td class="al_c link"
                    onClick='location.href="<?php echo _URL . "employee/view/{$data['employeeID']}" ?>"'>
                  <?php echo $data['employeeName'] ?>
                </td>
                <td class="al_l link"
                    onClick='location.href="<?php echo _URL . "company/view/{$data['companyID']}" ?>"'>
                  <?php echo $data['companyName'] ?>
                </td>
                <td class="al_c"><?php echo ($data['ceoReg'] == 1) ? '오지마세요' : '안가요' ?></td>
                <td class="al_l"><?php echo ($data['detail']) ? $data['detail'] : '-' ?></td>
                <td class="al_c">
                    <button type="button" class="btn btn-danger blackDelBtn" value="<?php echo $data['blackListID'] ?>">
                        삭제
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <!--페이지네이션-->
    <div class="al_c" style="margin-top: 10px;">
      <?php if ($page > 1) : ?>
          <form action="" method="post">
              <input type="hidden" name="page" value=1>
              <input type="hidden" name="ceoReg" value="<?php echo $_POST['ceoReg'] ?>">
              <input class="btn btn-option" type="submit" value="처음으로">
          </form>
          <form action="" method="post">
              <input type="hidden" name="page" value=<?php echo $page - 1 ?>>
              <input type="hidden" name="ceoReg" value="<?php echo $_POST['ceoReg'] ?>">
              <input class="btn btn-option" type="submit" value="<">
          </form>
      <?php endif; ?>
      
      <?php for ($i = $start_loop; $i <= $end_loop; $i++): ?>
          <form action="" method="post">
              <input type="hidden" name="page" value="<?php echo $i ?>">
              <input type="hidden" name="ceoReg" value="<?php echo $_POST['ceoReg'] ?>">
              <input class="btn btn-option <?php echo $selected_page[$i] ?>" type="submit" value="<?php echo $i ?>">
          </form>
      <?php endfor; ?>
      
      <?php if (($page < $total_pages)): ?>
          <form action="" method="post">
              <input type="hidden" name="page" value="<?php echo $page + 1 ?>">
              <input type="hidden" name="ceoReg" value="<?php echo $_POST['ceoReg'] ?>">
              <input class="btn btn-option" type="submit" value=">">
          </form>
          <form action="" method="post">
              <input type="hidden" name="page" value="<?php echo $total_pages ?>">
              <input type="hidden" name="ceoReg" value="<?php echo $_POST['ceoReg'] ?>">
              <input class="btn btn-option" type="submit" value="마지막으로">
          </form>
      <?php endif; ?>
    </div>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    $('.blackDelBtn').on('click', function () {
        let btn = $(this);
        if (confirm('정말 삭제하시겠습니까?')) {
            $.ajax({
                type: "POST",
                method: "POST",
                url: ajaxURL,
                data: {action: 'deleteBlack', blackID: btn.val()},
                dataType: "text",
                success: function (data) {
                    alert(data);
                    btn.closest('tr').slideUp();
                }
            });
        }
    });
    
    $('input[name=employeeName]').on('input',function () {
       set_validity($(this),'employee');
    });
    $('input[name=companyName]').on('input',function () {
        set_validity($(this),'company');
    });
    
    // function set_validity(input_element, table){
    //     console.log(table);
    //     let name = input_element.val();
    //     let input = input_element;
    //     let type = (table ==='employee') ? '인력' : '업체';
    //     $.ajax({
    //             type: "POST",
    //             method: "POST",
    //             url: ajaxURL,
    //             data: {action: 'checkDuplicate', table: table, name: name},
    //             dataType: "text",
    //             async: true,
    //             success: function (data) {
    //                 let match = JSON.parse(data).match;
    //                 if (!match) {
    //                     input.get(0).setCustomValidity('존재하지 않는 '+type+'입니다.');
    //                 }
    //                 else{
    //                     input.get(0).setCustomValidity('');
    //                 }
    //             }
    //         }
    //     );
    // }
</script>