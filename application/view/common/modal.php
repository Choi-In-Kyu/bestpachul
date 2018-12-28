<!-- Delete Modal -->
<div id="modalDelete" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">삭제 사유를 입력하세요</div>
        <form action="" method="post" id="formDelete">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="table" id="deleteTable">
            <input type="hidden" name="id" id="deleteID">
            <textarea name="deleteDetail"></textarea>
            <button type="button" class="btn btn-danger" id="btnDelete">삭제</button>
        </form>
    </div>
</div>
<!-- Join Cancel Modal -->
<div id="modalJoinCancel" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">가입 삭제 사유를 입력하세요</div>
        <form action="" method="post" id="formJoinCancel">
            <input type="hidden" name="action" value="joinDelete">
            <input type="hidden" name="table" id="joinDeleteTable">
            <input type="hidden" name="id" id="joinDeleteID">
            <textarea name="detail"></textarea>
            <button type="button" class="btn btn-danger" id="btnJoinCancel" >취소</button>
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
            <button type="button" class="btn btn-close-modal">X</button>
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
        <button type="button" class="btn btn-close-modal">X</button>
    </div>
</div>
<!-- Join Cancel Modal -->
<div id="modalGetMoney" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">수금자 이름을 입력하세요</div>
        <form action="" method="post" id="formGetMoney">
            <input type="hidden" name="table"   id="inputGetMoneyTable">
            <input type="hidden" name="value"   id="inputGetMoneyValue">
            <input type="hidden" name="id"      id="inputGetMoneyID">
            <textarea name="receiver" id="inputGetMoneyReceiver"></textarea>
            <button type="button" class="btn btn-submit" id="btnGetMoney" >수금완료</button>
        </form>
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
            <button type="button" class="btn btn-close-modal">X</button>
        </form>
    </div>
</div>
<!-- Join Update Modal -->
<div id="modalJoinUpdate" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">수정할 내용을 입력하세요</div>
        <form action="" method="post">
            <input type="hidden" name="action" value="join_update">
            <input id="updateID" type="hidden" name="joinID">
            <table>
                <colgroup>
                    <col width="25%">
                    <col width="75%">
                </colgroup>
                <tr>
                    <td class="td-title">금액</td>
                    <td><input type="number" id="updatePrice" name="price" min="0"></td>
                </tr>
                <tr>
                    <td class="td-title">비고</td>
                    <td><textarea id="updateDetail" name="joinDetail"></textarea></td>
                </tr>
            </table>
            <div class="al_r">
                <input class="btn btn-submit" type="submit" value="수정">
            </div>
        </form>
    </div>
</div>
<!-- Pay Charged Call Modal -->
<div id="modalPayChargedCall" class="modal">
    <div class="modal-content">
        <form>
            <input id="pay-info" type="text" value="국민은행 477002-04-040107" disabled="disabled">
            <input id="copyBtn" class="btn btn-insert" type="submit" value="복사하기">
            <button type="button" class="btn btn-close-modal">X</button>
        </form>
    </div>
</div>