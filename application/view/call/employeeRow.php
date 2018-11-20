<?php for ($i = 1; $i <= 3; $i++): ?>
    <tr>
        <th><?php echo $i ?>군</th>
        <th>인력명</th>
        <th>간단주소</th>
        <th>배정</th>
    </tr>
  <?php foreach ($this->db->{'group'.$i} as $key => $data): ?>
        <tr>
            <td class="al_c"><?php echo $data['employeeID'] ?></td>
            <td class="al_l">
                <a href="http://bestpachul.com/employee/view/<?php echo $data['employeeID'] ?>"
                   class="link"><?php echo $data['employeeName'] . " (" . $this->db->getAge($data['birthDate']) . ")" ?></a>
            </td>
            <td class="al_l"><?php echo $data['address'] ?></td>
            <td class="al_c">
                <form action="" method="post">
                    <input type="hidden" name="filter" value="<?php echo $_POST['filter'] ?>">
                    <input type="hidden" name="date" value="<?php echo $_POST['date'] ?>">
                    
                    <input type="hidden" name="action" value="assign">
                    <input type="hidden" name="callID" id="callID" value="">
                    <input type="hidden" name="employeeID" id="employeeID" value="">
                    <input type="submit" class="btn btn-small btn-submit btn-assign" id="<?php echo $data['employeeID'] ?>" value="배정">
                </form>
            </td>
        </tr>
  <?php endforeach; ?>
<?php endfor; ?>
