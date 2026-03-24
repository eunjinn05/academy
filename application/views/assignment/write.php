<main class="px-3 form-assignment-write">
    <h3>Assignment 작성</h3>
    <table class="assignment-write-table">
        <tr>
            <td>카테고리</td>
            <td> 
                <input type="radio" id="word" name="assignment_type" value="word" <?php echo (@$data['category'] == "word" || !@$data['category']) ? 'checked' : ''; ?> > <label for="word">단어</label>
                <input type="radio" id="grammar" name="assignment_type" value="grammar" <?php echo (@$data['category'] == "grammar") ? 'checked' : ''; ?>> <label for="grammar">문법</label>
                <input type="radio" id="reading" name="assignment_type" value="reading" <?php echo (@$data['category'] == "reading") ? 'checked' : ''; ?>> <label for="reading">독해</label>
                <input type="radio" id="listening" name="assignment_type" value="listening" <?php echo (@$data['category'] == "listening") ? 'checked' : ''; ?>> <label for="listening">듣기</label>
                <input type="hidden" id="assignment_date" value="<?php echo $assignment_date; ?>">
            </td>
        </tr>
        <tr>
            <td>날짜</td>
            <td> 
                <input type="date" id="date" name="assignment_date" value="<?php echo @$data['assignment']->assignment_date; ?>">
            </td>
        </tr>
        <tr>
            <td>내용</td>
            <td>
                <textarea id="content" name="editor1" class="assignment-textarea"><?php echo (@$data['assignment']->content) ? $data['assignment']->content : '';?></textarea>
            </td>    
        </tr>
        <tr style="height:10%">
            <td>첨부파일</td>
            <td>
                <input type="file" class="form-control assignment-input-file" id="file" name="file[]" multiple>
                <input type="hidden" id="file_idx">
                <div class="upload-file-list">
                    <?php
                        if (@$data) {
                            for ($i=0; $i<count($data['files']); $i++) {
                                $ext_arr = explode('.', $data['files'][$i]['file_path']);
                                if (in_array(end($ext_arr), ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                                    <div class="upload-file">
                                        <div><img src="<?php echo $data['files'][$i]['file_path']; ?>" class="assignment-img"></div>
                                        <input type='hidden' class='upload-file-data' value='<?php echo $data['files'][$i]['file_path'];?>'>
                                    </div>
                         <?php  } else { ?>
                                    <div class="upload-file">
                                        <div><p>[<?php echo $data['files'][$i]['original_name']; ?>]</p></div>
                                        <input type='hidden' class='upload-file-data' value='<?php echo $data['files'][$i]['file_path'];?>'>
                                    </div>
                        <?php   }?>
                    <?php   } 
                        } ?>
                </div>
            </td>
       </tr>
    </table>

    <div class="write-btn-form">
        <a href="#" id="writeBtn" class="btn btn-lg btn-secondary fw-bold border-white">등록하기</a>
        <input type="hidden" id="idx" value="<?php echo @$data['assignment']->idx; ?>">
    </div>
</main>


