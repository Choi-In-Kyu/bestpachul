<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input id="modal-deleteID" type="hidden" name="deleteID">
            <textarea name="deleteDetail"></textarea>
            <input class="btn btn-insert" type="submit" value="삭제하기">
            <input class="btn btn-danger closeModal" type="button" value="취소">
        </form>
    </div>
</div>
<!-- Call Cancel Modal -->
<div id="callCancelModal" class="modal">
    <div class="modal-content">
        <form id="callCancelForm" action="" method="post">
            <input name="action" type="hidden" value="callCancel">
            <input name="callID" type="hidden" id="callCancelID">
            <textarea name="detail" id="detail" size="200">취소사유: </textarea>
            <input id="callCancelBtn" class="btn btn-insert" type="submit" value="콜 취소">
            <input id="closeCallCancelModal" class="btn btn-danger closeModal" type="button" value="닫기">
        </form>
    </div>
</div>
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
        <input id="closeAssignCancelModal" class="btn btn-danger closeModal" type="button" value="닫기">
    </div>
</div>
<!-- Fix Cancel Modal -->
<div id="fixCancelModal" class="modal">
    <div class="modal-content">
        <form id="fixCancelForm" action="" method="post">
            <input name="action" type="hidden" value="fixCancel">
            <input name="fixID" type="hidden" id="fixCancelID">
            <input type="date" name="date">
            <textarea name="detail" id="detail" size="200">취소사유: </textarea>
            <input id="fixCancelBtn" class="btn btn-insert" type="submit" value="콜 취소">
            <input id="closeFixCancelModal" class="btn btn-danger closeModal" type="button" value="닫기">
        </form>
    </div>
</div>
<!-- Join Cancel Modal -->
<div id="joinCancelModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input id="modal-joinID" type="hidden" name="joinID">
            <textarea name="deleteDetail"></textarea>
            <input class="btn btn-default closeModal" type="button" value="취소">
            <input class="btn btn-danger" type="submit" value="삭제">
        </form>
    </div>
</div>
<!-- Join Update Modal -->
<div id="joinUpdateModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="join_update">
            <input id="updateID" type="hidden" name="joinID">
            <input type="number" id="updatePrice" name="price">
            <textarea id="updateDetail" name="detail"></textarea>
            <input class="btn btn-default closeModal" type="button" value="취소">
            <input class="btn btn-insert" type="submit" value="수정">
        </form>
    </div>
</div>