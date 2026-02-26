<main class="px-3 form-notice-write">
    <h3>공지사항 작성</h3>
    <table class="notice-write-table">
        <tr style="height:10%;">
            <td>제목</td>
            <td>
                <input type="text" class="form-control notice-input-text" id="title" value="<?php echo (@$write_data['notice']->title) ? $write_data['notice']->title: ''; ?>" placeholder="제목을 입력해주세요">
            </td>
        </tr>
        <tr>
            <td>내용</td>
            <td>
                <textarea id="content" name="editor1" class="notice-textarea"><?php echo (@$write_data['notice']->content) ? $write_data['notice']->content : '';?></textarea>
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
                            for ($i=0; $i<count($write_data['files']); $i++) { 
                                $ext_arr = explode('.', $write_data['files'][$i]['file_path']);
                                
                                if (in_array(end($ext_arr), ['jpg', 'jpeg', 'png', 'gif'])) {  ?>
                                    <div class="upload-file">
                                        <img src="<?php echo $write_data['files'][$i]['file_path'];?>" style="width:150px; height:150px;">
                                        <input type='hidden' class='upload-file-data' value='<?php echo $write_data['files'][$i];?>'>
                                    </div>
                    <?php       } else { ?>
                                    <div class="upload-file">
                                        <p><?php echo $write_data['files'][$i]['original_name']; ?></p>
                                        <input type='hidden' class='upload-file-data' value='<?php echo $write_data['files'][$i];?>'>
                                    </div>        
                    <?php       }
                            } 
                        } ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="write-btn-form">
        <a href="#" id="writeBtn" class="btn btn-lg btn-secondary fw-bold border-white">등록하기</a>
        <input type="hidden" id="idx" value="<?php echo (@$write_data['notice']->idx) ? $write_data['notice']->idx : ''; ?>">
    </div>
</main>


