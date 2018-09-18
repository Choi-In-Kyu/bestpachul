<?php
$condition = $_POST['condition'];
$keyword = $_POST['keyword'];
if(isset($keyword)&&$keyword!=""){
  $condition = "WHERE `companyName` LIKE '%{$keyword}%' OR `address` LIKE '%{$keyword}%' ";
}
$direction = $_POST['direction'];
if($direction=="ASC"){$direction="DESC";}else{$direction="ASC";}
$order = $_POST['order'];
if(isset($order)&&$order!=""){
  $order = " {$_POST['order']} {$direction}";
}
$this->getList($condition, $order);
?>

<div class="board_list auto-center">
  <div class="row" style="width: 100%">
    <div class="col">
      <form class="form-default" action="" method="post">
        <input class="btn btn-default" type="submit" value="전체 업체: <?php echo $listNum ?>">
      </form>
    </div>
    <div class="col">
      <form class="form-default" action="" method="post">
        <input type="hidden" name="condition" value="WHERE `activated` = 1 ">
        <input class="btn btn-default" type="submit" value="활성화 업체 : <?php echo $listNumAct ?>">
      </form>
    </div>
    <div class="col">
      <form class="form-default" action="" method="post">
        <input type="hidden" name="condition" value="WHERE `activated` = 0 ">
        <input class="btn btn-default" type="submit" value="만기임박 업체 : <?php echo $listNumNotAct ?>">
      </form>
    </div>
    <div class="col">
      <form class="form-default" action="" method="post">
        <input type="hidden" name="condition" value="WHERE `activated` = 0 ">
        <input class="btn btn-default" type="submit" value="만기된 업체 : <?php echo $listNumNotAct ?>">
      </form>
    </div>
    <div class="col">
      <form class="form-default" action="" method="post">
        <input class="btn btn-insert" type="button" value="업체 추가" onclick="window.location.href='<?php echo $this->param->get_page ?>/write'" />
      </form>
    </div>
    <div class="col" style="float: right">
      <form class="form-default" action="" method="post">
        <input type="hidden" name="condition" value=<?php echo $condition?>>
        <input type="hidden" name="order" value=<?php echo $order?>>
        <input type="hidden" name="direction" value=<?php echo $direction?>>
        <input type="hidden" name="keyword" value=<?php echo $keyword?>>
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
      <col width="40%">
      <col width="25%">
      <col width="15%">
    </colgroup>
    <thead>
    <tr>
      <form action="" method="post">
        <th>
          <input type="hidden" name="condition" value=<?php echo $condition?>>
          <input type="hidden" name="order" value="companyID">
          <input type="hidden" name="direction" value=<?php echo $direction?>>
          <input type="hidden" name="keyword" value=<?php echo $keyword?>>
          <input type="submit" value="#">
        </th>
      </form>
      <form action="" method="post">
        <th>
          <input type="hidden" name="order" value="companyName">
          <input type="hidden" name="direction" value=<?php echo $direction?>>
          <input type="hidden" name="keyword" value=<?php echo $keyword?>>
          <input type="submit" value="상호명">
        </th>
      </form>
      <form action="" method="post">
        <th>
          <input type="hidden" name="order" value="address">
          <input type="hidden" name="direction" value=<?php echo $direction?>>
          <input type="hidden" name="keyword" value=<?php echo $keyword?>>
          <input type="submit" value="간단주소">
        </th>
      </form>
      <form action="" method="post">
        <th>
          <input type="hidden" name="order" value="businessType">
          <input type="hidden" name="direction" value=<?php echo $direction?>>
          <input type="hidden" name="keyword" value=<?php echo $keyword?>>
          <input type="submit" value="업종">
        </th>
      </form>
      <form action="" method="post">
        <th>
          <input type="hidden" name="order" value="grade">
          <input type="hidden" name="direction" value=<?php echo $direction?>>
          <input type="hidden" name="keyword" value=<?php echo $keyword?>>
          <input type="submit" value="점수">
        </th>
      </form>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($this->list as $key => $data): ?>
      <tr style="cursor:pointer;" onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data->companyID}" ?>"'>
        <td class="al_c"><?php echo $data->companyID ?></td>
        <!--상호명-->
        <td class="al_l">
          <a href="<?php echo "{$this->param->get_page}/view/{$data->companyID}"?>">
            <?php echo $data->companyName ?>
          </a>
        </td>
        <td class="al_l"><?php echo $data->address ?></td>
        <td class="al_l"><?php echo $data->businessType ?></td>
        <td class="al_l"><?php echo $data->grade ?></td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
</div>


