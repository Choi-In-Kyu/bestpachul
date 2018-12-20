<!-- Delete Modal -->
<div id="modalDelete" class="modal">
    <div class="modal-content">
        <form id="formDelete" action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="table" id="deleteTable">
            <input type="hidden" name="id" id="deleteID">
            <textarea name="deleteDetail"></textarea>
            <button type="button" class="btn btn-insert" id="btnDelete">삭제하기</button>
            <button type="button" class="btn btn-danger btn-close-modal">닫기</button>
        </form>
    </div>
</div>
<!-- Call Cancel Modal -->
<div id="modalCallCancel" class="modal">
    <div class="modal-content">
        <h1 class="detail">취소사유</h1>
        <form id="formCallCancel" action="" method="post">
            <input type="hidden" name="action" value="callCancel">
            <input type="hidden" name="callID" id="callCancelID">
            <textarea name="detail" id="detail" size="200"></textarea>
            <button id="btnCallCancel" type="button" class="btn btn-insert">콜 취소</button>
            <button class="btn btn-danger btn-close-modal" type="button">닫기</button>
        </form>
    </div>
</div>
<!-- Assign Cancel Modal -->
<div id="modalAssignCancel" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="assignCancel">
            <input type="hidden" name="callID">
            <input class="btn btn-insert" type="submit" value="배정취소">
        </form>
        <h1 class="detail">펑크사유</h1>
        <form action="" method="post">
            <input type="hidden" name="action" value="punk">
            <input type="hidden" name="callID">
            <input type="hidden" name="employeeName">
            <textarea id="punkDetail" name="detail" size="200">무단잠수</textarea>
            <input class="btn btn-insert" type="submit" value="펑크">
        </form>
        <input id="closeAssignCancelModal" class="btn btn-danger btn-close-modal" type="button" value="닫기">
    </div>
</div>
<!-- Fix Cancel Modal -->
<div id="modalFixCancel" class="modal">
    <div class="modal-content">
        <h1 class="detail">취소사유</h1>
        <form id="fixCancelForm" action="" method="post">
            <input name="action" type="hidden" value="fixCancel">
            <input name="fixID" type="hidden" id="fixCancelID">
            <input type="date" name="date">
            <textarea name="detail" id="detail" size="200"></textarea>
            <input id="fixCancelBtn" class="btn btn-insert" type="submit" value="콜 취소">
            <input id="closeFixCancelModal" class="btn btn-danger btn-close-modal" type="button" value="닫기">
        </form>
    </div>
</div>
<!-- Join Cancel Modal -->
<div id="modalJoinCancel" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input id="modal-joinID" type="hidden" name="joinID">
            <textarea name="deleteDetail"></textarea>
            <input class="btn btn-default btn-close-modal" type="button" value="취소">
            <input class="btn btn-danger" type="submit" value="삭제">
        </form>
    </div>
</div>
<!-- Join Update Modal -->
<div id="modalJoinUpdate" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="join_update">
            <input id="updateID" type="hidden" name="joinID">
            <input type="number" id="updatePrice" name="price">
            <textarea id="updateDetail" name="detail"></textarea>
            <input class="btn btn-default btn-close-modal" type="button" value="취소">
            <input class="btn btn-insert" type="submit" value="수정">
        </form>
    </div>
</div>
<!-- Pay Charged Call Modal -->
<div id="modalPayChargedCall" class="modal">
    <div class="modal-content">
        <form>
            <input id="pay-info" type="text" value="국민은행 477002-04-040107" disabled="disabled">
            <input id="copyBtn" class="btn btn-insert" type="submit" value="복사하기">
            <input class="btn btn-danger btn-close-modal" type="button" value="닫기">
        </form>
    </div>
</div>