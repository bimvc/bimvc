jQuery(document).ready(function($){
    $('#form_add2card').submit(function(e){
            $('#button_add2card').addClass('loading')
            e.preventDefault();
            var m_data=$(this).serialize();
            $.ajax({
                type: "POST",
                url: "/wp-admin/admin-ajax.php", 
                data: m_data,
                success: function(data) {
                    $('#button_add2card').removeClass('loading')
                    $('#button_add2card').html("Добавлено");
                    $.ajax({
                        url: "/wp-admin/admin-ajax.php", 
                        data: {
                        action: "foobar",
                        },
                        success: function(data) {
                        $('.number-pro').html(data);
                        }
                    });
                }

            });
        });
});
