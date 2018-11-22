<!-- Assign Cancel Modal -->
<div id="assignCancelModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="assignCancel">
            <input type="hidden" name="callID">
            <input class="btn btn-insert" type="submit" value="배정취소">
        </form>
        <form action="" method="post">
            <input type="hidden" name="action" value="punk">
            <input type="hidden" name="callID">
            <input type="hidden" name="employeeName">
            <textarea id="punkDetail" name="detail" size="200">펑크사유: 무단잠수</textarea>
            <input class="btn btn-insert" type="submit" value="펑크">
        </form>
        <input id="closeAssignCancelModal" class="btn btn-danger" type="button" value="닫기">
    </div>
</div>

<!-- Call Cancel Modal -->
<div id="callCancelModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="callCancel">
            <input type="hidden" name="callID">
            <textarea id="cancelDetail" name="detail" size="200">취소사유: </textarea>
            <input class="btn btn-insert" type="submit" value="콜 취소">
        </form>
        <input id="closeCallCancelModal" class="btn btn-danger" type="button" value="닫기">
    </div>
</div>