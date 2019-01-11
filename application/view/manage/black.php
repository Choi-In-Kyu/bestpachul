<?php
  $record_per_page = 30;
  if (isset($_POST['page'])) {
    $page = $_POST['page'];
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $record_per_page;
  $query = "
SELECT `blackListID`,`employee`.`employeeID`,`company`.`companyID`,`employeeName`,`companyName`,`blackList`.`detail`, `blackList`.`ceoReg`
FROM `blackList`
LEFT JOIN `employee` on blackList.employeeID = employee.employeeID
LEFT JOIN `company` on blackList.companyID = company.companyID
";
  
  if ($_POST['ceoReg'] == '1' OR $_POST['ceoReg'] == '0') {
    $query .= "WHERE `ceoReg` = '{$_POST['ceoReg']}'";
    if ($_POST['search']) {
      $query .= "
  AND
  (`employeeName` LIKE '%{$_POST['search']}%') OR
  (`companyName` LIKE '%{$_POST['search']}%') OR
  (`blackList`.`detail` LIKE '%{$_POST['search']}%')
  ";
    }
  } else {
    if ($_POST['search']) {
      $query .= "
  WHERE
  (`employeeName` LIKE '%{$_POST['search']}%') OR
  (`companyName` LIKE '%{$_POST['search']}%') OR
  (`blackList`.`detail` LIKE '%{$_POST['search']}%')
  ";
    }
  }
  
  $page_result = $this->model->getTable($query);
  $total_records = sizeof($page_result);
  
  echo json_encode($total_records);
  
  $total_pages = ceil($total_records / $record_per_page);
  $start_loop = $page;
  $difference = $total_pages - $page;
  
  if ($total_pages >= 5) {
    if ($difference <= 5) $start_loop = $total_pages - 5;
    $end_loop = $start_loop + 4;
  } else {
    $start_loop = 1;
    $end_loop = 1;
  }
  $query .= " ORDER BY `blackListID` DESC LIMIT {$start_from}, {$record_per_page} ";
  $black = $this->model->getTable($query);
  
  echo $query;
?>

<style>
    form {
        display: inline;
    }

    .search {
        width: 100%;
        position: relative
    }

    .searchTerm {
        float: left;
        width: 100%;
        border: 3px solid #00B4CC;
        padding: 5px;
        height: 20px;
        border-radius: 5px;
        outline: none;
        color: #9DBFAF;
    }

    .searchTerm:focus {
        color: #00B4CC;
    }

    .searchButton {
        position: absolute;
        right: -50px;
        width: 40px;
        height: 36px;
        border: 1px solid #00B4CC;
        background: #00B4CC;
        text-align: center;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        font-size: 20px;
    }

    /*Resize the wrap to see the search bar change!*/
    .wrap {
        width: 30%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>


<!--<div class="wrap">-->
<!--    <div class="search">-->
<!--        <input type="text" class="searchTerm" placeholder="What are you looking for?">-->
<!--        <button type="submit" class="searchButton">-->
<!--            <i class="fa fa-search"></i>-->
<!--        </button>-->
<!--    </div>-->
<!--</div>-->

<div class="board-write auto-center">
    <div class="title-table">
        <h1 class="title-main">블랙리스트 관리</h1>
    </div>
    <!--블랙리스트 추가 폼-->
    <div class="form-default">
        <form id="company_form" action="" method="post">
            <fieldset>
                <input type="hidden" name="action" value="black">
                <div class="table">
                    <div class="tr">
                        <div class="td td-3">
                            <label for="">인력명</label>
                            <input id="employeeName" type="text" list="employeeList" name="employeeName">
                            <datalist id="employeeList" class="input-field">
                              <?php foreach ($this->employee_List as $key => $data): ?>
                                  <option value="<?php echo $data['employeeName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td td-3">
                            <label for="">업체명</label>
                            <input type="text" list="companyList" name="companyName">
                            <datalist id="companyList" class="input-field">
                              <?php foreach ($this->company_List as $key => $data): ?>
                                  <option value="<?php echo $data['companyName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td td-3">
                            <label for="">유형</label>
                            <select name="type" style="height: 39px; width: 282px;">
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
    <div class="btn-group" style="display: inline;height: 150px;">
        <form action="" method="post" style="height: 100%;">
            <input type="text" name="search" style="width: 60px;height: 100%; border: 1px solid black;">
            <input type="submit" class="btn btn-insert" value="검색" style="height: 100%;">
        </form>
    </div>
    <!--블랙리스트 필터 폼-->
    <div class="btn-group" style="display: inline;height: 150px;">
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="ceoReg" value="1">
            <input type="submit" class="btn btn-insert" value="오지마세요" style="height: 100%;">
        </form>
        <form action="" method="post" style="height: 100%;">
            <input type="hidden" name="ceoReg" value="0">
            <input type="submit" class="btn btn-insert" value="안가요" style="height: 100%;">
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
            <th class="order link" id="refresh-companyName">업체명</th>
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
                <td class="al_l"><?php echo $data['detail'] ?></td>
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
              <input class="btn btn-option" type="submit" value="처음으로">
          </form>
          <form action="" method="post">
              <input type="hidden" name="page" value=<?php echo $page - 1 ?>>
              <input class="btn btn-option" type="submit" value="<">
          </form>
      <?php endif; ?>
      
      <?php for ($i = $start_loop; $i <= $end_loop; $i++): ?>
          <form action="" method="post">
              <input type="hidden" name="page" value="<?php echo $i ?>">
              <input class="btn btn-option" type="submit" value="<?php echo $i ?>">
          </form>
      <?php endfor; ?>
      
      <?php if (($page < $end_loop)): ?>
          <form action="" method="post">
              <input type="hidden" name="page" value="<?php echo $page + 1 ?>">
              <input class="btn btn-option" type="submit" value=">">
          </form>
          <form action="" method="post">
              <input type="hidden" name="page" value="<?php echo $total_pages ?>">
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
    });
</script>