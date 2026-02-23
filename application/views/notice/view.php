<main class="px-3 form-notice-write">

    <h3><?php echo $data['notice']->title; ?></h3>
    <div>
        <?php echo $data['notice']->content; ?>
    </div>

    <div>
        <?php for($i=0; $i<count($data['files']); $i++ ) { ?>
            <img src="<?php echo $data['files'][$i]['file_path']; ?>" class="notice-img">
        <?php } ?>
    </div>

</main>
