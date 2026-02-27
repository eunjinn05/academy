$(function(){
    CKEDITOR.replace('editor1', {
      width: '100%',
      height: 430,
    });

    $(document).on("click", "#writeBtn", function () {
      ckeditorUpdate();
      var title = $('#title').val();
      var content = $('#content').val();
      var idx = $("#idx").val();
      var files = Array();
      var original_name = Array();

       if (title == "") {
          alert("제목을 입력해주세요.");
          return false;
       }

       if (content == "") {
          alert("내용을 입력해주세요.");
          return false;
       }

        $(".upload-file-data").each(function(i, e) {
          files.push($(e).val());
        });
        
        $(".upload-file-original-name-data").each(function(i, e) {
          original_name.push($(e).val());
        });

       $.ajax({
            type : "POST", 
            url : '/index.php/notice/notice_write_exec',
            dataType: 'json',
            async: false,
              data : {
                  title : title,
                  content : content,
                  files : files,
                  idx : idx,
                  original_name : original_name
              },
            success: function (result) {
              if (result.return == true) {
                location.href = '/index.php/notice/list';
              } else {
                alert("다시 확인해주세요.");
              }
            }
        })

    });

    $(document).on("click", ".upload-file", function () {
      $(this).remove();
    });

    $(document).on("change", "#file", function () {
      var formData = new FormData();
      
      const files = this.files;
      for (let i = 0; i < files.length; i++) {
          formData.append('files[]', files[i])
      }

      $.ajax({
          type : "POST", 
          url : '/index.php/notice/notice_upload_exec',
          data : formData,
          processData: false,
          contentType: false,
          success: function (result) {
            var res = JSON.parse(result);
            if (res.success) {
              for(var i=0; i<res.files.length; i++) {
                if (res.files[i].ext == "png" || res.files[i].ext == "jpg" || res.files[i].ext == "jpeg" || res.files[i].ext == "gif") {
                  $('.upload-file-list').append("<div class='upload-file'><img src='"+res.files[i].path+"' class='upload-file-img'>");
                  $('.upload-file-list').append("<input type='hidden' class='upload-file-data' value='"+res.files[i].path+"'>");
                  $('.upload-file-list').append("<input type='hidden' class='upload-file-original-name-data' value='"+res.files[i].original_name+"'></div>");
                } else {
                  $('.upload-file-list').append("<div class='upload-file'><p>"+res.files[i].original_name+"</p><input type='hidden' class='upload-file-data' value='"+res.files[i].path+"'><input type='hidden' class='upload-file-original-name-data' value='"+res.files[i].original_name+"'></div>");
                }
              }
            } else {
              alert(res.message);
            }
          }
      });

    });

    function ckeditorUpdate() {
      for ( instance in CKEDITOR.instances ) {
        CKEDITOR.instances[instance].updateElement();
      }
    }

    $(document).on("click", ".board-del", function () {
      var idx = $(this).data('idx');
      var admin = $(this).data('session');

      if (!admin) {
        alert("관리자만 삭제 가능합니다. 로그인해주세요.");
        return false;
      }

      if(confirm("정말 삭제하시겠습니까?")) {
        $.ajax({
          type : "POST", 
          url : '/index.php/notice/notice_delete_exec',
          data : {
            idx : idx
          },
          success: function (result) {
            var res = JSON.parse(result);
            console.log(res);
            if (res.result) {
              alert("삭제되었습니다.");
              location.reload();
            } else {
              alert("다시 시도해주세요");
            }
          }
        });
      }

    });

    $(document).on("click", ".notice-view", function () {
      var idx = $(this).data('idx');
      location.href = "/index.php/notice/view/"+idx;
    });



});