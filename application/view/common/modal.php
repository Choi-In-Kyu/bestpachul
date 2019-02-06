<style>
    #modalAssignCancel .btn{width: 200px;}
    form.search-form{    margin-top: 20px;
        display: block;}


    .wrap .search {
        position: relative
    }
    .wrap .search .searchTerm {
        display: inline;
        float: left;
        width: 400px;
        height: 44px;
        padding: 0;
        border: 3px solid #00B4CC;
        border-right: none;
    }
    .wrap .search .searchTerm:focus{
        color: #00B4CC;
    }
    .wrap .search .searchButton {
        display: inline;
        float: left;
        width: 70px;
        height: 50px;
        padding: 0;
        border: 1px solid #00B4CC;
        background: #00B4CC;
        color: #fff;
        cursor: pointer;
        text-align: center;
        font-size: 20px;
    }
</style>

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
            <button type="button" class="btn btn-danger" id="btnJoinCancel" >삭제</button>
        </form>
    </div>
</div>
<!-- Call Cancel Modal -->
<div id="modalCallCancel" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">취소 사유를 입력하세요</div>
        <form id="formCallCancel" action="" method="post">
            <input type="hidden" name="action" value="callCancel">
            <input type="hidden" name="callID" id="callCancelID">
            <textarea name="detail" id="detail" <?php if($this->param->page_type == 'ceo') echo "size='200'"?>></textarea>
            <button id="btnCallCancel" type="button" class="btn <?php if($this->param->page_type == 'ceo') echo "btn-mobile"?> btn-insert">취소</button>
        </form>
    </div>
</div>
<!-- Assign Cancel Modal -->
<div id="modalAssignCancel" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">
            
            
            
            <form action="" method="post">
                <input type="hidden" name="action" value="assignCancel">
                <input type="hidden" name="callID">
                <input class="btn btn-insert" type="submit" value="배정취소">
            </form>
            
            <input class="btn btn-insert" type="button" value="펑크">
            <form class="search-form" action="" method="post">
                <input type="hidden" name="action" value="punk">
                <input type="hidden" name="callID">
                <div class="wrap">
                    <div class="search">
                        <input type="text" class="searchTerm" name="detail" placeholder="펑크 사유를 입력하세요">
                        <button type="submit" class="searchButton">입력</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
<!-- Join Cancel Modal -->
<div id="modalGetMoney" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>            vp[;
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
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <h1 class="detail">취소사유</h1>
        <form id="fixCancelForm" action="" method="post">
            <input name="action" type="hidden" value="fixCancel">
            <input name="fixID" type="hidden" id="fixCancelID">
            <input type="date" name="date">
            <textarea name="detail" id="detail" size="200"></textarea>
            <input id="fixCancelBtn" class="btn btn-insert" type="submit" value="콜 취소">
        </form>
    </div>
</div>
<!-- Join Update Modal -->
<div id="modalJoinUpdate" class="modal">
    <div class="modal-content">
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">가입 내역 수정</div>
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
        <div class="modal-box al_r">
            <button type="button" class="btn btn-close-modal">X</button>
        </div>
        <div class="modal-box al_l">
            <form>
                <input type="text" style="height: 50px;" id="pay-info"  value="국민은행 477002-04-040107">
                <input id="copyBtn" class="btn btn-insert" type="submit" value="계좌번호 복사하기">
            </form>
        </div>
    </div>
</div>