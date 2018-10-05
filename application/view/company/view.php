
<?php include_once 'write.php' ?>

<div class="board_list auto-center">
    <table width="100%">
        <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="55%">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>가입구분</th>
            <th>가입금액</th>
            <th>가입 시작일</th>
            <th>가입 만기일</th>
            <th>비고</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->joinList as $key => $data): ?>
            <tr>
                <td class="al_c"><?php echo $data['joinID'] ?></td>
                <td class="al_l"><?php echo get_joinType($data) ?></td>
                <td class="al_l"><?php echo $data['price']." 원" ?></td>
                <td class="al_l"><?php echo $data['startDate'] ?></td>
                <td class="al_l"><?php echo $data['endDate'] ?></td>
                <td class="al_l"><?php echo $data['detail'] ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>

</script>