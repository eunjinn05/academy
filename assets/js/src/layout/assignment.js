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

    $(document).on("click", ".fc-day", function () {
        var date = $(this).data('date');
        console.log(date);
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
                $('.upload-file-list').append("<div class='upload-file'><img src='"+res.files[i].path+"' class='upload-file-img'> <input type='hidden' class='upload-file-data' value='"+res.files[i].path+"'></div>");
              }
            } else {
              alert(res.message);
            }
          }
      });

    });

    $(document).on("click", "#writeBtn", function () {
      
    });
    
});