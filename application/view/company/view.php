<?php
  $companyID = $this->param->idx;
  $this->list = $this->db->getTable("SELECT * FROM company WHERE companyID = '{$companyID}'");
  $this->joinList = $this->db->getTable("SELECT * FROM join_company WHERE companyID = '{$companyID}' order by endDate DESC");
  alert(json_encode($this->joinList));
  function get_joinType($data){
      if(isset($data['price']) && $data['price']!=0){
          return "구좌";
      }
      elseif (isset($data['deposit']) && $data['deposit']!=0){
          return "보증금+콜비";
      }
      elseif(isset($data['point']) && $data['point']!=0){
          return "포인트";
      }
  }
?>
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
                <td class="al_l"><?php echo $data['price']."원" ?></td>
                <td class="al_l"><?php echo $data['startDate'] ?></td>
                <td class="al_l"><?php echo $data['endDate'] ?></td>
                <td class="al_l"><?php echo $data['detail'] ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>