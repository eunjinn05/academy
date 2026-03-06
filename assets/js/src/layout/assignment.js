document.addEventListener('DOMContentLoaded', function() {
    
    var calendarEl = document.getElementById('calendar');
    if (calendarEl != null) {
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: '',
          center: 'title'
        }
      });
      calendar.render();
    }

    CKEDITOR.replace('editor1', {
      width: '100%',
      height: 430,
    });


    $(document).on("click", ".fc-day", function () {
        var date = $(this).data('date');
        location.href = '/index.php/assignment/view/'+date;
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
          url : '/index.php/assignment/assignment_upload_exec',
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

    $(document).on("click", "#writeBtn", function () {
      ckeditorUpdate();
      var category = $('[name="assignment_type"]:checked').val();
      var assignment_date = $('#date').val();
      var content = $('#content').val();
      var idx = $("#idx").val();
      var files = Array();
      var original_name = Array();

      if (assignment_date == "") {
        alert("날짜를 입력하세요");
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
          url : '/index.php/assignment/assignment_write_exec',
          dataType: 'json',
          async: false,
            data : {
                category : category,
                assignment_date : assignment_date,
                content : content,
                files : files,
                idx : idx,
                original_name : original_name
            },
          success: function (result) {
            if (result.return == true) {
              location.href = '/index.php/assignment/calendar';
            } else {
              alert("다시 확인해주세요.");
            }
          }
      })

    });

    $(document).on("click", ".assignment_type_chk", function () {
      var category = $(this).val();
      var assignment_date = $('#assignment_date').val();
      location.href = '/index.php/assignment/view/'+assignment_date+'/'+category;
    });
    
    function ckeditorUpdate() {
      for ( instance in CKEDITOR.instances ) {
        CKEDITOR.instances[instance].updateElement();
      }
    }

});