<div class="board_list auto-center">
    <div class="row" style="width: 100%">
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->defaultCondition['filter']; ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['default'] ?>; color: <?php echo $this->filterColor['default'] ?>;"
                       value="전체 업체: <?php echo $this->db->getListNum($this->defaultCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->activatedCondition['filter']; ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['activated'] ?>; color: <?php echo $this->filterColor['activated'] ?>"
                       value="활성화 업체 : <?php echo $this->db->getListNum($this->activatedCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->deadlineCondition['filter'] ?>">
                <input type="hidden" name="join" value="<?php echo $this->deadlineJoin ?>">
                <input type="hidden" name="group" value="<?php echo $this->deadlineGroup ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['deadline'] ?>; color: <?php echo $this->filterColor['deadline'] ?>;"
                       value="(만기임박 업체) : <?php echo $this->db->getListNum($this->deadlineCondition, $this->deadlineJoin, $this->deadlineGroup) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->expiredCondition['filter'] ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['expired'] ?>; color: <?php echo $this->filterColor['expired'] ?>;"
                       value="만기된 업체 : <?php echo $this->db->getListNum($this->expiredCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->deletedCondition['filter'] ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['deleted'] ?>"
                       value="삭제된 업체 : <?php echo $this->db->getListNum($this->deletedCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input class="btn btn-insert" type="button" value="업체 추가"
                       onclick="window.location.href='<?php echo $this->param->get_page ?>/write'"/>
            </form>
        </div>
        <div class="col" style="float: right">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                <input type="hidden" name="order" value="<?php echo $this->order ?>">
                <input type="hidden" name="direction" value="<?php echo $this->direction ?>">
                <input type="hidden" name="join" value="<?php echo $this->join ?>">
                <input type="hidden" name="group" value="<?php echo $this->group ?>">
                <input type="text" name="keyword">
                <input class="btn btn-submit" type="submit" value="검색"/>
            </form>
        </div>
      <?php echo $message; ?>
    </div>

    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="15%">
            <col width="35%">
            <col width="25%">
            <col width="15%">
            <col width="5%">
        </colgroup>
        <thead>
        <tr>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="company.companyID">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="#">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="company.companyName">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="상호명">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="address">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="간단주소">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="businessType">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="업종">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="grade">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="점수">
                </th>
            </form>
            <th>
                삭제
            </th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($this->list as $key => $data): ?>
            <tr style="background-color: <?php echo $data['color'] ?>">
                <td class="al_c"><?php echo $data['companyID'] ?>
                    <a href="<?php echo "{$this->param->get_page}/view/{$data['idx']}" ?>">
                </td>
                <td class="al_l" style="cursor: pointer;"
                    onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data['companyID']}" ?>"'>
                  <?php echo $data['companyName'] ?>
                </td>
                <td class="al_l"><?php echo $data['address'] ?></td>
                <td class="al_l"><?php echo $data['businessType'] ?></td>
                <td class="al_l"><?php echo $data['grade'] ?></td>
                <td class="al_c">
                    <!-- Trigger/Open The Modal -->
                  <?php if ($data['deleted'] == 0) : ?>
                      <button id="myBtn" class="btnModal" value="<?php echo $data['companyID'] ?>">X</button>
                  <?php else: ?>
                      <form action="" method="post">
                          <input type="hidden" name="action" value="restore">
                          <input type="hidden" name="companyID" value="<?php echo $data['companyID']?>">
                          <input class="btn" type="submit" value="복구">
                      </form>
                  <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="company-deleted" value=1>
            <input type="hidden" name="company-activated" value="0">
            <input type="hidden" name="company-deletedDate" value="<?php echo date("Y-m-d") ?>">
            <input type="hidden" name="company-deleted" value="1">
            <input id="modal-companyID" type="hidden" name="company-companyID">
            <textarea name="company-deleteDetail" size="200"></textarea>
            <input class="btn btn-danger" type="button" id="closeModal" value="닫기">
            <input class="btn btn-insert" type="submit" value="삭제하기">
        </form>
    </div>
</div>

<script>
    $('.btnModal').click(function () {
        $('#myModal').show();
        $('#modal-companyID').val(this.value);
    })
    $('#closeModal').click(function () {
        $('#myModal').hide();
    })
</script>