<div class="board_list auto-center">
    <div class="row" style="width: 100%">
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="condition" value="<?php echo $this->defaultCondition; ?>">
                <input class="btn btn-default" type="submit"
                       value="전체 인력: <?php echo $this->db->getListNum($this->defaultCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="condition" value="<?php echo $this->activatedCondition; ?>">
                <input class="btn btn-default" type="submit"
                       value="활성화 인력 : <?php echo $this->db->getListNum($this->activatedCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="condition" value="<?php echo $this->deadlineCondition ?>">
                <input class="btn btn-default" type="submit"
                       value="(만기임박 인력) : <?php echo $this->db->getListNum($this->deadlineCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="condition" value="<?php echo $this->expiredCondition ?>">
                <input class="btn btn-default" type="submit"
                       value="만기된 인력 : <?php echo $this->db->getListNum($this->expiredCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="condition" value="<?php echo $this->deletedCondition ?>">
                <input class="btn btn-default" type="submit"
                       value="삭제된 인력 : <?php echo $this->db->getListNum($this->deletedCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input class="btn btn-insert" type="button" value="인력 추가"
                       onclick="window.location.href='<?php echo $this->param->get_page ?>/write'"/>
            </form>
        </div>
        <div class="col" style="float: right">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="condition" value=<?php echo $this->condition ?>>
                <input type="hidden" name="order" value=<?php echo $this->order ?>>
                <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                <input type="text" name="keyword">
                <input class="btn btn-submit" type="submit" value="검색"/>
            </form>
        </div>
      <?php echo $message; ?>
    </div>

    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="5%">

            <col width="10%">
            <col width="35%">
            <col width="25%">
            <col width="15%">
            <col width="5%">
        </colgroup>
        <thead>
        <tr>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="order" value="employeeID">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="submit" value="#">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="condition" value=<?php echo $this->condition ?>>
                    <input type="hidden" name="order" value="employeeName">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="submit" value="성명">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="condition" value=<?php echo $this->condition ?>>
                    <input type="hidden" name="order" value="employeeName">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="submit" value="연령">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="condition" value=<?php echo $this->condition ?>>
                    <input type="hidden" name="order" value="address">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="submit" value="간단주소">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="condition" value=<?php echo $this->condition ?>>
                    <input type="hidden" name="order" value="workType">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="submit" value="업종">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="condition" value=<?php echo $this->condition ?>>
                    <input type="hidden" name="order" value="grade">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
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
                <td class="al_c"><?php echo $data['employeeID'] ?>
                    <a href="<?php echo "{$this->param->get_page}/view/{$data['idx']}" ?>">
                </td>
                <td class="al_l" style="cursor: pointer;"
                    onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data['employeeID']}" ?>"'>
                  <?php echo $data['employeeName'] ?>
                </td>
                <td class="al_l"><?php echo $this->db->getAge($data['birthDate']) ?></td>
                <td class="al_l"><?php echo $data['address'] ?></td>
                <td class="al_l"><?php echo $data['workType'] ?></td>
                <td class="al_l"><?php echo $data['grade'] ?></td>
                <td class="al_c">
                    <!-- Trigger/Open The Modal -->
                    <button id="myBtn" class="btnModal" value="<?php echo $data['employeeID'] ?>">X</button>
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
            <input id="modal-employeeID" type="hidden" name="employee-employeeID">
            <textarea name="employee-deleteDetail" size="200"></textarea>
            <input class="btn btn-danger" type="button" id="closeModal" value="close">
            <input class="btn btn-insert" type="submit" value="submit">
        </form>
    </div>
</div>

<script>
    $('.btnModal').click(function () {
        $('#myModal').show();
        $('#modal-employeeID').val(this.value);
    })
    $('#closeModal').click(function () {
        $('#myModal').hide();
    })
</script>