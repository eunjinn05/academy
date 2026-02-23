$(function(){
    $(document).on("click", "#loginButton", function () {
        var id = $('#id').val();
        var password = $('#password').val();

        if (id == "") {
            alert("아이디를 입력해주세요.");
            return false;
        }

        if (password == "") {
            alert("비밀번호를 입력해주세요.");
            return false;
        }

       $.ajax({
            type : "POST", 
            url : '/index.php/login/login_exec',
            dataType: 'json',
			async: false,
            data : {
                id : id,
                password : password
            },
            success: function (result) {
                if (result.result == true) {
                    location.href = "/";
                } else {
                    alert("아이디 비밀번호를 확인해주세요.");
                }
            }
        })    
    });

    $(document).on("keydown", "input[type='text'], input[type='password']", function (e) {
        if (e.key === 'Enter') {
            $('#loginButton').trigger('click');
        }
    });







});