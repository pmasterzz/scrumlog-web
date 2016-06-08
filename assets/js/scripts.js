jQuery(document).ready(function () {

    /*
     Fullscreen background
     */
    $.backstretch("assets/img/backgrounds/bg3.jpg");

    /*
     Form validation
     */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function () {
        $(this).removeClass('input-error');
    });

    $('.login-form').on('submit', function (e) {

        $(this).find('input[type="text"], input[type="password"], textarea').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            }
            else {
                $(this).removeClass('input-error');
            }
        });

    });
    $('#menu-toggle').click(function () {
        $(this).find('i').toggleClass('glyphicon-arrow-left glyphicon-arrow-right')
    });

    $('.cyclusDeleteBtn').click(function (event) {
        showConfirm(event, "Weet je zeker dat je deze cyclus wilt verwijderen?");
    });

    $('#emptyAllTablesBtn').click(function (e) {
        var c = confirm("Weet je zeker dat je alle tafels wilt legen?");
        if (!c) {
            e.preventDefault();
        }
        else {
            e.preventDefault();
            var data = {'clear': $(this).val()};
            $.post('php/clearTable.php', data, function (response) {
                    window.location.replace("?page=createTable");
                })
                .fail(function (e) {
                    alert('fail' + JSON.parse(e));
                })
        }
    })
    function showConfirm(event, message) {
        var c = confirm(message);
        if (!c) {
            event.preventDefault();
        }
    }
    
    $('#change').click(function () {
        $(this).toggleClass('incomplete complete')
    });
//    $('#todoKnop').click(function (e) {
//        e.preventDefault();
//            var data = {'submit': $(this).val(),
//                'Input_Remark': $('#Input_Remark').val(),
//                'Input_Teacher': $('#Input_Teacher').val(),
//                'ID':$('#ID').val()
//        };
//            $.post('php/submitTodo.php', data, function (response) {
//                alert('er staat een koe in brand')
//        })
//        .fail(function (e) {
//            alert('fail' + JSON.parse(e));
//        })
//    })
});


    

