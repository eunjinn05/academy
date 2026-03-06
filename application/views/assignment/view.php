<main class="px-3 form-assignment-write">

    <div>
        <input type="hidden" id="assignment_date" value="<?php echo @$assignment_date; ?>">
        <?php
            for($i=0; $i < count($data['category_arr']); $i++) {
                if ($data['category_arr'][$i]['category'] == 'word') { ?>
                    <input type="radio" id="word" name="assignment_type" class="assignment_type_chk" value="word" <?php echo (@$category == 'word' || (!@$category && $data['category_arr'][0]['category'] == 'word')) ? "checked" : ""; ?>> <label for="word">단어</label>
        <?php } else if ($data['category_arr'][$i]['category'] == 'grammar') { ?>
                    <input type="radio" id="grammar" name="assignment_type" class="assignment_type_chk" value="grammar" <?php echo (@$category == 'grammar' || (!@$category && $data['category_arr'][0]['category'] == 'grammar')) ? "checked" : ""; ?>> <label for="grammar">문법</label>
        <?php } else if ($data['category_arr'][$i]['category'] == 'reading') { ?>
                     <input type="radio" id="reading" name="assignment_type" class="assignment_type_chk" value="reading" <?php echo (@$category == 'reading' || (!@$category && $data['category_arr'][0]['category'] == 'reading')) ? "checked" : ""; ?>> <label for="reading">독해</label>
        <?php } ?>
    <?php   } ?>
 </div>

    <div>
        <?php echo @$data['assignment']->content; ?>
    </div>

    <div>
        <?php for($i=0; $i<count($data['files']); $i++ ) {
            $ext_arr = explode('.', $data['files'][$i]['file_path']);
            if (in_array(end($ext_arr), ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                <div><img src="<?php echo $data['files'][$i]['file_path']; ?>" class="assignment-img"></div>
    <?php   } else { ?>
                <div><a href="<?php echo $data['files'][$i]['file_path']; ?>"><p>[<?php echo $data['files'][$i]['original_name']; ?>]</p></a></div>
        <?php } 
        } ?>
    </div>

</main>
