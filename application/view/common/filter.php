<?php
  $selectArr = array_fill(0, 4, 'selectable');
  if (isset($_POST['filterCondition'])) {
    switch ($_POST['filterCondition']) {
      case $this->activatedCondition['filter'] :
        $selectArr[1] = 'selected';
        break;
      case $this->deadlineCondition['filter'] :
        $selectArr[2] = 'selected';
        break;
      case $this->expiredCondition['filter'] :
        $selectArr[3] = 'selected';
        break;
      case $this->deletedCondition['filter']:
        $selectArr[4] = 'selected';
        break;
      default:
        $selectArr[0] = 'selected';
        break;
    }
  } else {
    $selectArr[1] = 'selected';
  }
?>

<div class="header" id="filterMain">
    <button type="button" class="btn btn-default <?php echo $selectArr[0] ?>">
        전체 : <?php echo $this->model->getListNum($this->defaultCondition) ?>
    </button>
    <button type="button" class="btn btn-default <?php echo $selectArr[0] ?>">
        활성화 : <?php echo $this->model->getListNum($this->activatedCondition) ?>
    </button>
    <button type="button" class="btn btn-default <?php echo $selectArr[0] ?>">
        만기임박 : <?php echo $this->model->getListNum($this->deadlineCondition) ?>
    </button>
    <button type="button" class="btn btn-default <?php echo $selectArr[0] ?>">
        만기 : <?php echo $this->model->getListNum($this->expiredCondition) ?>
    </button>
    <button type="button" class="btn btn-default <?php echo $selectArr[0] ?>">
        삭제 : <?php echo $this->model->getListNum($this->deletedCondition) ?>
    </button>
</div>
<div class="header" id="filterSub">
    <input type="text" id="inputKeyword" name="keyword" placeholder="검색할 내용을 입력하세요">
    <button class="btn btn-submit" type="button" id="btnSearch">검색</button>
    <button type="button" id="btnAddCompany" class="btn btn-insert" onclick="window.location.href='<?php echo $this->param->get_page ?>/write'">신규 추가</button>
</div>