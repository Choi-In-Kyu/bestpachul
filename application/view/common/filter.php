<?php $name = ($this->param->page_type == 'company') ? '업체' : '인력' ?>
<?php
  $selectArr = array_fill(0,4, 'selectable');
  if (isset($_POST['filterCondition'])) {
    switch ($_POST['filterCondition']) {
      case $this->activatedCondition['filter'] :$selectArr[1] = 'selected';break;
      case $this->deadlineCondition['filter'] :$selectArr[2] = 'selected';break;
      case $this->expiredCondition['filter'] :$selectArr[3] = 'selected';break;
      case $this->deletedCondition['filter']:$selectArr[4] = 'selected';break;
      default: $selectArr[0] = 'selected';break;
    }
  } else {
    $selectArr[0] = 'selected';
  }
?>

    <div class="row" style="width: 100%">
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->defaultCondition['filter']; ?>">
                <input class="btn btn-default <?php echo $selectArr[0] ?>" type="submit"
                       value="전체 <?php echo $name ?>: <?php echo $this->model->getListNum($this->defaultCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->activatedCondition['filter']; ?>">
                <input class="btn btn-default <?php echo $selectArr[1] ?>" type="submit"
                       value="활성화 <?php echo $name ?> : <?php echo $this->model->getListNum($this->activatedCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->deadlineCondition['filter'] ?>">
                <input class="btn btn-default <?php echo $selectArr[2] ?>" type="submit"
                       value="(만기임박 <?php echo $name ?>) : <?php echo $this->model->getListNum($this->deadlineCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->expiredCondition['filter'] ?>">
                <input class="btn btn-default <?php echo $selectArr[3] ?>" type="submit"
                       value="만기된 <?php echo $name ?> : <?php echo $this->model->getListNum($this->expiredCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->deletedCondition['filter'] ?>">
                <input class="btn btn-default <?php echo $selectArr[4] ?>" type="submit"
                       value="삭제된 <?php echo $name ?> : <?php echo $this->model->getListNum($this->deletedCondition) ?>">
            </form>
        </div>
        <div class="col">
            <form class="form-default" action="" method="post">
                <input class="btn btn-insert" type="button" value="<?php echo $name ?> 추가"
                       onclick="window.location.href='<?php echo $this->param->get_page ?>/write'"/>
            </form>
        </div>
        <div class="col" style="float: right">
            <form class="form-default" action="" method="post">
                <input type="hidden" name="filterCondition" value="<?php echo $this->condition['filter'] ?>">
                <input type="text" name="keyword">
                <input class="btn btn-submit" type="submit" value="검색"/>
            </form>
        </div>
    </div>