<main class="px-3 form-assignment-write">
    <h3>Assignment 작성</h3>

    <table class="assignment-write-table">
        <tr>
            <td>카테고리</td>
            <td> 
                <input type="radio" id="word" name="assignment_type" value="word" checked> <label for="word">단어</label>
                <input type="radio" id="grammar" name="assignment_type" value="grammar"> <label for="grammar">문법</label>
                <input type="radio" id="reading" name="assignment_type" value="reading"> <label for="reading">독해</label>
            </td>
        </tr>
        <tr>
            <td>날짜</td>
            <td> 
                <input type="date" id="date" name="assignment_date">
            </td>
        </tr>
        <tr style="height:10%">
            <td>첨부파일</td>
            <td>
                <input type="file" class="form-control notice-input-file" id="file" name="file[]" multiple>
                <input type="hidden" id="file_idx">
                <div class="upload-file-list">
                    <?php
                        if (@$write_data) {
                            for ($i=0; $i<count($write_data['files']); $i++) { ?>
                                <div class="upload-file">
                                    <img src="<?php echo $write_data['files'][$i]['file_path'];?>" style="width:150px; height:150px;">
                                    <input type='hidden' class='upload-file-data' value='<?php echo $write_data['files'][$i]['file_path'];?>'>
                                </div>     
                    <?php   } 
                        } ?>
                </div>
            </td>
       </tr>
    </table>

    <div class="write-btn-form">
        <a href="#" id="writeBtn" class="btn btn-lg btn-secondary fw-bold border-white">등록하기</a>
        <input type="hidden" id="idx" value="<?php echo (@$write_data['assignment']->idx) ? $write_data['assignment']->idx : ''; ?>">
    </div>
</main>


