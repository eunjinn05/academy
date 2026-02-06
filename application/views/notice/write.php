<main class="px-3 form-notice-write">
    <h3>공지사항 작성</h3>

    <table class="notice-write-table">
        <tr style="height:10%;">
            <td>제목</td>
            <td>
                <input type="text" class="form-control notice-input-text" id="title" placeholder="제목을 입력해주세요">
            </td>
        </tr>
        <tr>
            <td>내용</td>
            <td>
                <textarea id="content" name="editor1" class="notice-textarea"></textarea>
            </td>    
        </tr>
        <tr style="height:10%">
            <td>첨부파일</td>
            <td>
                <input type="file" class="form-control notice-input-file" id="file" multiple>
            </td>    
        </tr>
    </table>

    <div class="write-btn-form">
        <a href="#" id="writeBtn" class="btn btn-lg btn-secondary fw-bold border-white">등록하기</a>
    </div>
</main>


