<main class="px-3 form-notice-write">

    <h3><?php echo $data['notice']->title; ?></h3>
    <div>
        <?php echo $data['notice']->content; ?>
    </div>

    <div>
        <?php for($i=0; $i<count($data['files']); $i++ ) {
            $ext_arr = explode('.', $data['files'][$i]['file_path']);
            if (in_array(end($ext_arr), ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                <img src="<?php echo $data['files'][$i]['file_path']; ?>" class="notice-img">
    <?php   } else { ?>
                <a href="<?php echo $data['files'][$i]['file_path']; ?>"><p>[<?php echo $data['files'][$i]['original_name']; ?>]</p></a>
        <?php } 
        } ?>
    </div>

</main>
