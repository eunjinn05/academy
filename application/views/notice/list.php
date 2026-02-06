<main class="px-3 form-notice-list">
    <table class="notice-list-table">
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>글쓴이</th>
            <th>편집</th>
        </tr>

        <?php for($i=0; $i<=9; $i++) { ?>
        <tr>
            <td>1</td>
            <td>얘들아 말 좀 잘 들어라</td>
            <td>선생님</td>
            <td>
                <a href="#" class="btn btn-sm btn-secondary fw-bold border-white">수정</a>
                <a href="#" class="btn btn-sm btn-secondary fw-bold border-white">삭제</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="notice-list-bottom">
        <div class="notice-list-write-btn">
            <a href="#" class="btn btn-sm btn-secondary fw-bold border-white">글쓰기</a>        
        </div>
    </div>
</main>

