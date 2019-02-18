<div class="mobile_view">
    <form class="list-form" method="post">
        <select class="all-filter" name="year" id="all-year" form="listForm" required>
          <?php foreach ($this->yearList as $value): ?>
              <option class="year" value="<?php echo $value ?>"><?php echo $value.'년'?></option>
          <?php endforeach; ?>
        </select>
        <select class="all-filter" name="month" id="all-month" form="listForm">
          <?php foreach ($this->monthList as $value): ?>
              <option class="year" value="<?php echo $value ?>"><?php echo $value.'월' ?></option>
          <?php endforeach; ?>
        </select>
    </form>
    <table class="call-list">
        <colgroup>
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
        </colgroup>
        <thead>
        <tr>
            <th class="order link"  id="refresh-employeeID"> #</th>

            <th class="al_c order link" ">근무일</th>
            <th class="al_c order link" ">근무시간</th>
            <th class="al_c order link" >직종</th>
            <th class="al_c order link" ">콜비</th>
            <th class="al_c order link" ">배정</th>
        </tr>
        </thead>
        <tbody id="all-call-list-body"></tbody>
    </table>
</div>