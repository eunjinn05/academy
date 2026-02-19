<main class="px-3 form-notice-list">
    <table class="notice-list-table">
        <tr>
            <th style="width: 15%;">번호</th>
            <th style="width: 50%;">제목</th>
            <th style="width: 15%;">글쓴이</th>
            <th style="width: 20%;">편집</th>
        </tr>

        <?php $con = 1; foreach ($list_data->result() as $row) { ?>
        <tr>
            <td><?php echo $total_rows + $con; ?></td>
            <td><?php echo $row->title; ?></td>
            <td><?php echo $row->writer; ?></td>
            <td>
                <a href="/index.php/notice/write/<?php echo $row->idx; ?>" class="btn btn-sm btn-secondary fw-bold border-white">수정</a>
                <a href="#" class="btn btn-sm btn-secondary fw-bold border-white board-del" data-idx="<?php echo $row->idx; ?>">삭제</a>
            </td>
        </tr>
        <?php $con++; } ?>
    </table>

    <div class="notice-list-bottom">    
        <?php echo $this->pagination->create_links();?>    
        <div class="notice-list-write-btn">
            <a href="#" class="btn btn-sm btn-secondary fw-bold border-white">글쓰기</a>        
        </div>
    </div>
</main>

