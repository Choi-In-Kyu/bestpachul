<div class="mobile_view">
    <h1>콜 목록</h1>
    <div class="mobile_list">
        <table>
            <thead>
            <tr>
                <th>근무일</th>
                <th>시작</th>
                <th>끝</th>
                <th>직종</th>
                <th>배정</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->callList as $key => $value): ?>
                <tr>
                    <td><?php echo $value['workDate'] ?></td>
                    <td><?php echo $value['startTime'] ?></td>
                    <td><?php echo $value['endTime'] ?></td>
                    <td><?php echo $value['workField'] ?></td>
                    <td><?php echo $value['employeeID'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
