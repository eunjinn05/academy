$(function(){
    CKEDITOR.replace('editor1', {
      width: '100%',
      height: 430,
    });

    $(document).on("click", "#writeBtn", function () {
       var title = $('#title').val();
       ckeditorUpdate();
       var content = $('#content').val();

       if (title == null) {
          alert("제목을 입력해주세요.");
          return false;
       }

       if (content == null) {
          alert("내용을 입력해주세요.");
          return false;
       }

       $.ajax({
            type : "POST", 
            url : '/index.php/login/notice_write_exec',
            dataType: 'json',
            async: false,
              data : {
                  title : title,
                  content : content
              },
            success: function (result) {
              console.log(result);
              // if (result.result == true) {
              //   // alert("등록되었습니다.")
              // } else {
              // }
            }
        })

    });
    

    function ckeditorUpdate() {
      for ( instance in CKEDITOR.instances ) {
        CKEDITOR.instances[instance].updateElement();
      }
    }





});