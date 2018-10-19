<div class="board_list auto-center">
    <div class="row" style="width: 100%">
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->defaultCondition['filter']; ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['default']?>; color: <?php echo $this->filterColor['default']?>;"
                       value="전체 인력: <?php echo $this->db->getListNum($this->defaultCondition); ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->activatedCondition['filter']; ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['activated']?>; color: <?php echo $this->filterColor['activated']?>"
                       value="활성화 인력 : <?php echo $this->db->getListNum($this->activatedCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->deadlineCondition['filter'] ?>">
                <input type="hidden" name="join" value="<?php echo $this->deadlineJoin ?>">
                <input type="hidden" name="group" value="<?php echo $this->deadlineGroup ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['deadline']?>; color: <?php echo $this->filterColor['deadline']?>;"
                       value="(만기임박 인력) : <?php echo $this->db->getListNum($this->deadlineCondition, $this->deadlineJoin) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->expiredCondition['filter'] ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['expired']?>; color: <?php echo $this->filterColor['expired']?>;"
                       value="만기된 인력 : <?php echo $this->db->getListNum($this->expiredCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->deletedCondition['filter'] ?>">
                <input class="btn btn-default" type="submit"
                       style="background-color: <?php echo $this->filterBgColor['deleted']?>"
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
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="employeeID">
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
                    <input type="hidden" name="order" value="employeeName">
                    <input type="hidden" name="direction" value=<?php echo $this->direction ?>>
                    <input type="hidden" name="keyword" value=<?php echo $this->keyword ?>>
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="성명">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="birthDate">
                    <input type="hidden" name="direction" value="<?php echo $this->direction ?>">
                    <input type="hidden" name="keyword" value="<?php echo $this->keyword ?>">
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="연령">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="address">
                    <input type="hidden" name="direction" value="<?php echo $this->direction ?>">
                    <input type="hidden" name="keyword" value="<?php echo $this->keyword ?>">
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="간단주소">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="employeePhoneNumber">
                    <input type="hidden" name="direction" value="<?php echo $this->direction ?>">
                    <input type="hidden" name="keyword" value="<?php echo $this->keyword ?>">
                    <input type="hidden" name="join" value="<?php echo $this->join ?>">
                    <input type="hidden" name="group" value="<?php echo $this->group ?>">
                    <input type="submit" value="전화번호">
                </th>
            </form>
            <form action="" method="post">
                <th>
                    <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                    <input type="hidden" name="order" value="grade">
                    <input type="hidden" name="direction" value="<?php echo $this->direction ?>">
                    <input type="hidden" name="keyword" value="<?php echo $this->keyword ?>">
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
                <td class="al_c"><?php echo $data['employeeID'] ?>
                    <a href="<?php echo "{$this->param->get_page}/view/{$data['idx']}" ?>">
                </td>
                <td class="al_l" style="cursor: pointer;"
                    onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data['employeeID']}" ?>"'>
                  <?php echo $data['employeeName'] ?>
                </td>
                <td class="al_l"><?php echo $this->db->getAge($data['birthDate']) ?></td>
                <td class="al_l"><?php echo $data['address'] ?></td>
                <td class="al_l"><?php echo $data['employeePhoneNumber'] ?></td>
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
            <textarea name="employee-deleteDetail" size="200">안해</textarea>
            <input class="btn btn-danger" type="button" id="closeModal" value="닫기">
            <input class="btn btn-insert" type="submit" value="삭제">
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