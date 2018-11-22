<div class="inline" style="width: 15%; height: 100%;">
  <div class="datepicker" id="datepicker"></div>
  <div>
      <form id="day_form" action="" method="post"><input type="hidden" name="filter" value="day"><input id="filterDate" type="hidden" name="date"></form>
      
      <form action="" method="post">
          <input type="hidden" name="filter" value="week">
          <input class="full_width filterBtn" type="submit" value="이번주">
      </form>
      
      <form action="" method="post">
          <input type="hidden" name="filter" value="month">
          <input type="hidden" name="year" class="filterYear" value="<?php echo date('Y')?>">
          <input type="hidden" name="month" class="filterMonth" value="<?php echo date('n')?>">
          <input class="full_width filterBtn" type="submit" id="filterMonthBtn" value="이번달 (모든콜)">
      </form>
      
      <form action="" method="post">
        <input type="hidden" name="filter" value="paid">
          <input type="hidden" name="year" class="filterYear" value="<?php echo date('Y')?>">
          <input type="hidden" name="month" class="filterMonth" value="<?php echo date('n')?>">
        <input class="full_width filterBtn" type="submit" id="filterMonthPaidBtn" value="이번달 (유료콜)">
      </form>
      
      <form action="" method="post"><input type="hidden" name="filter" value="all"><input class="full_width filterBtn" type="submit" value="전체기간"></form>

  </div>
</div>